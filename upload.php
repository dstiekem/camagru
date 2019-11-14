<?php

?>

<canvas id="canvas"></canvas>
<input type="file" name="imagefile" id="hello">

<script>
window.onload = function()
{
    var canvas = document.getElementById("canvas");
    var image = document.getElementById("hello");

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
            }
            doc.src = URL.createObjectURL(file);
            console.log(doc.src);
            
        }
    });
    console.log(canvas);
    var canvasData = canvas.toDataURL("image/png");
    var x = new XMLHttpRequest();
    x.open("POST",'save.php',true);
    x.setRequestHeader('Content-Type', 'application/upload');
    x.send(canvasData );

    $.ajax({
    type: "POST",
    url: "script.php",
    data: { 
     imgBase64: dataURL
    }
    }).done(function(o) {
    console.log('saved'); 
    // If you want the file to be visible in the browser 
    // - please modify the callback in javascript. All you
    // need is to return the url to the file, you just saved 
    // and than put the image in your browser.
    });
 }


</script>