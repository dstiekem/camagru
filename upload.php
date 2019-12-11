<html>
  <head>
  <link rel="stylesheet" type="text/css" href="stylesheet2.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700i,800&display=swap" rel="stylesheet">
  </head>
<?php

?>
<body>
    
    <div class="darkbox">
        <video width="480" height="480" id="video" autoplay="true"></video>
        <div class="btn-holder">
            <div class="upload-btn-wrapper">
                <button class="btn" id="button">SNAP</button>
            </div>
            <div class="upload-btn-wrapper">
                <button class="btn">UPLOAD</button> 
                <input type="file" name="imagefile" value="UPLOAD" id="hello"/>
            </div>
        </div>
    </div>
    
        <canvas id="canvas"></canvas>
        <img id="display"/>
        <input type="submit" value="SAVE" id="save" class="btn">
    </div>
<script>
window.onload = function()
{
    var canvas = document.createElement('canvas');
    var image = document.getElementById("hello");
    var video = document.getElementById("video");
    var display = document.getElementById("display");
    var save = document.getElementById("save");
    save.disabled = true;
    image.addEventListener("change", (e) => {
        var piece = null;
        for (var i=0; i < image.files.length; i++)
        { 
            var file = image.files[i];
            if(file.type.match(/image\/*/))
            {
                piece = file;
            }
        }
        if(piece != null)
        {
            var doc = new Image();
            var context = canvas.getContext("2d");
            doc.onload = () => {
                canvas.height = doc.height;
                canvas.width = doc.width;
                context.drawImage(doc, 0,0);
                display.src = canvas.toDataURL(piece);
                save.disabled=false;
            }
            doc.src = URL.createObjectURL(piece);
            console.log(doc.src); 
        }
    });
    if(navigator.mediaDevices.getUserMedia)
    {
        navigator.mediaDevices.getUserMedia({video: true}).then((stream) => {
            video.srcObject = stream;
        }).catch((error) => {
            console.log(error);
        });
    }
    var button = document.getElementById("button");
    var context = canvas.getContext("2d");
    button.addEventListener("click", (e) => {
        canvas.height = video.offsetHeight;
        canvas.width = video.offsetWidth;
        /* context.GlobalCompositeOperation = "difference";
        context.drawImage(video, 0,0); */
        context.drawImage(video, 0, 0);
        save.disabled=false;
    });
    save.addEventListener("click", (ne) => {
        var canvasData = canvas.toDataURL("image/png");
        console.log(canvas);
        var request = new XMLHttpRequest();
        request.addEventListener("load", (e) => {
            console.log(request.responseText);
        });
        request.open("POST", "/mvc2/save.php");
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("image=" + encodeURIComponent(canvasData.replace("data:image/png;base64,", "")));
    });
}
</script>

    </body>
</html>