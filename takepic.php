<?php
?>

<canvas id="canvas"></canvas>
<video id="video" autoplay="true"></video>
<button id="button">snap!!</button>
<button type="submit" value="save" id="save">save</button>

<script>
window.onload = function()
{
    var canvas = document.getElementById("canvas");
    //var image = document.getElementById("hello");
    var video = document.getElementById("video");
    var save = document.getElementById("save");
    save.disabled = true;
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
        context.drawImage(video, 0,0);
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
        console.log(canvasData);
        request.send("image=" + encodeURIComponent(canvasData.replace("data:image/png;base64,", "")));
    });
}
</script>