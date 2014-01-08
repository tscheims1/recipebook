<video autoplay></video>
<img id="capturedImage" src="">
<canvas style="display:none;" width='1280'
	height='720'></canvas>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
	var hdConstraints = {
		  video: {
		    mandatory: {
		      minWidth: 1280,
		      minHeight: 720
		    }
		  }
		};

	var video = document.querySelector('video');
	var canvas = document.querySelector('canvas');
	var canvas = document.querySelector('canvas');
  	var ctx = canvas.getContext('2d');
  	var localMediaStream = null;
	
	/*
	 * GET
	 */
	navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
	window.URL = window.URL || window.webkitURL || window.mozURL || window.msURL;
	console.log(navigator.getUserMedia);
	
	if(navigator.getUserMedia)
	{
		/*
		 * Enable Usermedia 
		 * The User must allow the Webcam
		 */
		navigator.getUserMedia(hdConstraints, successCallback, function(){console.log("fail");});
	}
	else
	{
		alert( "Your Browser dosen't support getUserMedia. Go fuck yourself.");
	}
	
function successCallback(stream) {
    if (video.mozSrcObject !== undefined) {
        video.mozSrcObject = stream;
    } else {
        video.src = (window.URL && window.URL.createObjectURL(stream)) || stream;
    };
    video.play();
    
   
    localMediaStream = stream;
    
    }

jQuery(document).ready(function()
{
	jQuery("#selfie").click(function()
	{
		
	 if (localMediaStream) {
	 	console.log("selfie");
	      ctx.drawImage(video, 0, 0);
	      // "image/webp" works in Chrome.
	      // Other browsers will fall back to image/png.
	      document.querySelector('img').src = canvas.toDataURL('image/png');
    }
    
 });
 jQuery("#upload").click(function()
 {
 	var data = {data:canvas.toDataURL('image/png')};
 	jQuery.post("ajax.php",data,function()
 	{
 		console.log("successful uploaded");
 	},'json');
 });
});

</script>
<input type="button" value="selfie" id="selfie" />
<input type="button" value="upload" id="upload" />
</html>



<?php

$handle = pspell_new("de","","","utf-8",PSPELL_NORMAL );

$word = "Gemus";

if(pspell_check($handle,$word))
{
	echo "das wort ist gültig";
}
else 
{
	echo "ungültig";
	echo "vorschläge";	
	print_r(pspell_suggest($handle,$word));
}
?>