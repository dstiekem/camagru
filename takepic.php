<?php
echo "taking pictures";
?>

<canvas id="canvas"></canvas>
<video id="video" autoplay="true"></video>
<button id="button">snap!!</button>
<script>
window.onload = function()
{
    var canvas = document.getElementById("canvas");
    //var image = document.getElementById("hello");
    var video = document.getElementById("video");
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
        context.GlobalCompositeOperation = "difference";
        context.drawImage(video, 0,0);
        context.drawImage(video, 0,0);
    })
}
</script>