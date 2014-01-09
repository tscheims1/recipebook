<?php
include "Mobile_Detect.php";
$detect = new Mobile_Detect();
?>

<html>
<head>
<style>
html
{
	font-family: Verdana;
}
#progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
#bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
#percent { position:absolute; display:inline-block; top:3px; left:48%;}	
	
</style>
</head>
<body>


<h2>HTML 5 OCR Reader</h2>
<div class="webcam-utils">
<div id="source"></div>
<video id="videostream" autoplay></video>
<img id="capturedImage" src="">
<canvas style="display:none;" width="640"  height="480"
></canvas>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script src="base64.js"></script>
<script>
/*
(function addXhrProgressEvent($) {
var originalXhr = $.ajaxSettings.xhr;
$.ajaxSetup({
progress: function() { console.log("standard progress callback"); },
xhr: function() {
var req = originalXhr(), that = this;
if (req) {
if (typeof req.addEventListener == "function") {
req.addEventListener("progress", function(evt) {
that.progress(evt);
},false);
}
}
return req;
}
});
})(jQuery);
	*/
/*
 * algorithm for more image contrast
 */
function contrastImage(imageData, contrast) {

    var data = imageData.data;
    var factor = (259 * (contrast + 255)) / (255 * (259 - contrast));

    for(var i=0;i<data.length;i+=4)
    {
        data[i] = (factor * ((data[i] - 128) + 128));
        data[i+1] = (factor * ((data[i+1] - 128) + 128));
        data[i+2] = (factor * ((data[i+2] - 128) + 128));
    }
    return imageData;
}
</script>	


<script>
	
	var videoSource = 1;
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
	
	if (typeof MediaStreamTrack === 'undefined'){
	  console.log('This browser does not support MediaStreamTrack.\n\nTry Chrome Canary.');
	} else {
	  //MediaStreamTrack.getSources(gotSources);
	}
	var hdConstraints = {
		  video: {
		    mandatory: {
		      minWidth: 640,
		      minHeight: 480,
		     // facingMode: "environment"
		    },
		   // optional: [{sourceId: videoSource}]
		  }
		};
	
	
	
	//alert(videoSource);
	
		if(navigator.getUserMedia)
		{
			/*
			 * Enable Usermedia 
			 * The User must allow the Webcam
			 */
			navigator.getUserMedia(hdConstraints, successCallback, function(){console.log("fail");});
			
			/*
			 * TODO set canvas with automatic
			 */
			//jQuery("canvas").attr('width',jQuery("#videostream").width());
			//jQuery("canvas").attr('width',jQuery("#videostream").height());
		}
		else
		{
			console.log( "Your Browser dosen't support getUserMedia.");
		}
/*
 * Necessary for chrome mobile
 */	
function gotSources(sourceInfos)
{
	/*
	var html = "";
	for(var i = 0; i < sourceInfos.length;i++)
	{
		 var sourceInfo = sourceInfos[i];
		 if(sourceInfo.kind =="video")
		 {
		 	//html +"= "<option>"+sourceInfo.label+"</option>";
		 	//html += sourceInfo.id+"<br />";
		 }
		 //html += sourceInfo.label+" <br />";
	}
	videoSource = sourceInfos[2].id;
	//alert(videoSource);
	//jQuery("#source").html(html);
			
	//alert(sources);*/
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
/*
 * 
 * Events **********
 */
jQuery(document).ready(function()
{
	jQuery("#selfie,#videostream").click(function()
	{
		
	 if (localMediaStream) {
	 	
	 
	 	//video.contrast(2.0);
	 	console.log("selfie");
	    ctx.drawImage(video, 0, 0);
	    /*imgData = ctx.getImageData(0,0,640,480);
	    imgData = contrastImage(imgData,80);*/
	    
	      // "image/webp" works in Chrome.
	      // Other browsers will fall back to image/png.
	      
	      document.querySelector('img').src = canvas.toDataURL('image/png');
    }
    
 });
 jQuery("#upload-id").click(function()
 {
 	var data = {data:canvas.toDataURL('image/png')};
 	
	/*
 	 * Init Progressbar
 	 */
 	$("#progress").show();
    //clear everything
    $("#bar").width('0%');
    $("#upload-message").html("");
        $("#percent").html("0%");
	 	
 	
 	jQuery.ajax("ajax.php",
 	{
 		data:data,
 		type:'post',
 		complete:function(response)
	 	{
	 		console.log(response);
	 		var json = JSON.parse(response.responseText);
	 		jQuery("#message").html(json.text);
	 		//console.log(response.message);
	 		
	 	},
	 	success:function()
	 	{
	 		 $("#bar").width('100%');
        	$("#percent").html('100%');
        
	 	},
	 	/*progress: function(evt)
	 	{
	 		console.log(evt);
	 		var percent = evt;
	 		 $("#bar").width(percent+'%');
        	$("#percent").html(percent+'%');
	 	},*/
	 	dataType:'json',
	 	
 });
 
 });
 /*AJAX Fileupload************************
  * 
  */
 
 	
 	var options = {
    beforeSend: function()
    {
        $("#progress").show();
        //clear everything
        $("#bar").width('0%');
        $("#upload-message").html("");
        $("#percent").html("0%");
    },
    uploadProgress: function(event, position, total, percentComplete)
    {
        $("#bar").width(percentComplete+'%');
        $("#percent").html(percentComplete+'%');
 
    },
    success: function(response)
    {
        $("#bar").width('100%');
        $("#percent").html('100%');
        
       
 
    },
    complete: function(response)
    {
    	var json = JSON.parse(response.responseText);
        $("#upload-message").html("<font color='green'>"+response.responseText+"</font>");
  
        jQuery("#message").html(json.text);
        
    },
    error: function()
    {
        $("#upload-message").html("<font color='red'> ERROR: unable to upload files</font>");
 
    }
  };
    
     $("#file-upload-form").ajaxForm(options);
    
	<?php if( $detect->isiOS() ){?>
	
		jQuery(".webcam-utils").hide();
	<?php }?>		

});

</script>
<!--<input type="button" value="start" id="start" />-->
<div class="webcam-utils">
<input type="button" value="selfie" id="selfie" />
<input type="button" value="upload" id="upload-id" />
</div>
<form id="file-upload-form" action="ajaxupload.php" method="post" enctype="multipart/form-data "/>
<input type="file" id="file-upload" name="fileupload" />
<!---<input type="button" value="file upload" id="file-upload-button"/>-->
<input type="submit" value="file upload" />
</form>
<div id="progress">
        <div id="bar"></div>
        <div id="percent">0%</div >
</div>
<!--<div id="upload-message"></div>-->

<h3>OCR Callback</h3>
<div id="message"></div>
</body>
</html>