<?php
class TesseractOCR {

  function recognize($originalImage) {
    $tifImage       = TesseractOCR::convertImageToTif($originalImage);
    $configFile     = TesseractOCR::generateConfigFile(func_get_args());
    $outputFile     = TesseractOCR::executeTesseract($tifImage, $configFile);
    $recognizedText = TesseractOCR::readOutputFile($outputFile);
    TesseractOCR::removeTempFiles($tifImage, $outputFile, $configFile);
    return $recognizedText;
  }

  function convertImageToTif($originalImage) {
    $tifImage = 'tmpimages/tesseract-ocr-tif-'.rand().'.tif';
	//-modulate 100,200 
	// -units PixelsPerInch img 
    //exec("convert -units PixelsPerInch -colorspace gray +matte $originalImage -density 300  $tifImage");
    
    exec("convert -colorspace gray +matte -resample 200x200 -depth 8 $originalImage  $tifImage");
    return $tifImage;
	
	
  }

  function generateConfigFile($arguments) {
    $configFile = 'tmpimages/tesseract-ocr-config-'.rand().'.conf';
	$configFile = 'tmpimages/tesseractconf.conf';
    /*exec("touch $configFile");
    $whitelist = TesseractOCR::generateWhitelist($arguments);
    if(!empty($whitelist)) {
      $fp = fopen($configFile, 'w');
      fwrite($fp, "tessedit_char_whitelist $whitelist");
      fclose($fp);
    }*/
    return $configFile;
  }

  function generateWhitelist($arguments) {
    array_shift($arguments); //first element is the image path
    $whitelist = '';
    foreach($arguments as $chars) $whitelist.= join('', (array)$chars);
    return $whitelist;
  }

  function executeTesseract($tifImage, $configFile) {
    $outputFile = 'tmpimages/tesseract-ocr-output-'.rand();
	
	/*
	 * Set only Whitelist for the Webcam
	 */
	if(WHITELIST)
    	exec("tesseract $tifImage $outputFile -l deu nobatch tmpimages/tesseractconf.conf > /dev/null");
	else
		exec("tesseract $tifImage $outputFile -l deu nobatch abcdef > /dev/null");
    return $outputFile.'.txt'; //tesseract appends txt extension to output file
  }

  function readOutputFile($outputFile) {
    return trim(file_get_contents($outputFile));
  }

  function removeTempFiles() { //array_map("unlink", func_get_args()); 
  }
}
?>
