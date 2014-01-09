Source: <div id="source"></div>
<video id="videostream" autoplay></video>
<img id="capturedImage" src="">
<canvas style="display:none;" width='800px'
	height='1200px'></canvas>
	

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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
	  alert('This browser does not support MediaStreamTrack.\n\nTry Chrome Canary.');
	} else {
	  //MediaStreamTrack.getSources(gotSources);
	}
	var hdConstraints = {
		  video: {
		    mandatory: {
		      minWidth: 800,
		      minHeight: 1200
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
		}
		else
		{
			alert( "Your Browser dosen't support getUserMedia.");
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

jQuery(document).ready(function()
{
	jQuery("#selfie,#videostream").click(function()
	{
		
	 if (localMediaStream) {
	 	console.log("selfie");
	      ctx.drawImage(video, 0, 0);
	      // "image/webp" works in Chrome.
	      // Other browsers will fall back to image/png.
	      document.querySelector('img').src = canvas.toDataURL('image/png');
    }
    
 });
 jQuery("#upload-id").click(function()
 {
 	var data = {data:canvas.toDataURL('image/png')};
 	
 	jQuery.post("ajax.php",data,function(response)
 	{
 		jQuery(".message").html("data");
 		console.log(response);
 		
 	},'json');
 });
});

</script>
<input type="button" value="start" id="start" />
<input type="button" value="selfie" id="selfie" />
<input type="button" value="upload" id="upload-id" />
<div class="message">msg</div>
