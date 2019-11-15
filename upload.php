<?php

?>

<canvas id="canvas"></canvas>
<button type="submit" value="save" id="save">save</button>
<input type="file" name="imagefile" id="hello">

<script>
window.onload = function()
{
    var canvas = document.getElementById("canvas");
    var image = document.getElementById("hello");
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
                save.disabled=false;
            }
            doc.src = URL.createObjectURL(file);
            console.log(doc.src); 
        }
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