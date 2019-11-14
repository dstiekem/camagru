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
    save.getElementById("save").disabled = true;
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
    save.getElementById("save").addEventListener("click", (f) =>
    {
        
        function uploadfile()
        {
            const form = new FormData();
            form.append('image', filename);
            form.append('upload', 'true');
            console.log(canvas);
            function loadImage()
            {
                var x = new XMLHttpRequest();
                x.open("POST",'save.php',true);
                x.onload = function()
                {
                    if(this.status = 200)
                    {
                        var inside = this.responseText;
                        console.log(inside);
                    }
                    else
                    {
                        console.log(this.status)
                    }
                }
                x.setRequestHeader('Content-Type', 'application/upload');
                x.send(canvasData);
            }
        }
    });
    
    // If you want the file to be visible in the browser 
    // - please modify the callback in javascript. All you
    // need is to return the url to the file, you just saved 
    // and than put the image in your browser.
}
    


</script>