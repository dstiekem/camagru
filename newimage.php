<html>
  <head>
  <link rel="stylesheet" type="text/css" href="stylesheet2.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700i,800&display=swap" rel="stylesheet">
  </head>
<?php
    session_start();
    $page = "newimage";
    require (dirname(__FILE__) . '/header.php');
    require (dirname(__FILE__) . '/config/database.php');
    require (dirname(__FILE__) . '/functions/fetchuid.php');
    require (dirname(__FILE__) . '/functions/modal.php');
?>
<body>
    <div class="grid">
                
            <!-- <div class="boxnewimage">
                <img id="display" style="width: 100%;"/>
            </div> -->
            <div>
                <div >
                    <video width="480" height="480" id="video" autoplay="true"></video>
                </div>
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
            <div style="display: grid; grid-template-columns: auto auto 20%; padding: 0 20px; text-align: center;">
                <div>    
                    <div style="position: relative; width: 480px; height:480px">
                        <!-- <canvas width="480" height="480" id="canvas"></canvas> -->
                        <img id="imagedis" width="480" height="480">
                        <img id="stickdis" style="position: absolute; top: 0; left: 0; z-index: 100;" width="480" height="480">
                    </div>
                </div>
                <div id="stickerbackground">
                <?php
                    try
                    {
                        $sticker = $pdo->prepare("SELECT stickpath, stickey FROM stickers");
                        $sticker->execute();

                        while($fetchedst = $sticker->fetch())
                        {
                            $fetchedst['stickpath'];
                        ?>                  
                            
                            <img id="<?php echo ($fetchedst['stickey']);?>" class="stickerdisplay" src="<?php echo ($fetchedst['stickpath']);?>">
                        <?php
                        }
                    }
                    catch (PDOexception $e)
                    {
                        //throw $th;
                        echo $e->getMessage();
                    }
                    ?>
                </div>
                
                <div>
                    <input type="submit" value="SAVE" id="save" class="btn">
                </div>
           </div>
    </div>
    <div class="thumbnails">
    <?php
    try
    {
    $images = $pdo->prepare("SELECT * FROM images ORDER BY imagetime DESC");
    $images->execute();
    
    if(isset($_SESSION['uid']))
    {
      while($fetchedim = $images->fetch())
      {
        ?>
        <div class="thumbnails">
          <form action="newimage.php" method="post">
            <input type="hidden" value="<?php echo ($fetchedim['imageid'])?>" name="imageid">
            <input type="image" id="thumbim" src="<?php echo ($fetchedim['imagepath']);?>" alt="Submit" />
          </form>
        </div>
        <?php
      }
    }
    }
    catch (PDOexception $e)
    {
        //throw $th;
        echo $e->getMessage();
    }
    //on click
    ?>
    </div>
<script>
window.onload = function()
{
    var canvas2 = document.getElementById('canvas');
    var canvas = document.getElementById('canvas');
    var imagecanvas = document.createElement('canvas');
    var stickercanvas = document.createElement('canvas');

    stickercanvas.height = 480;
    stickercanvas.width = 480;

    var image = document.getElementById("hello");
    var video = document.getElementById("video");
    var display = document.getElementById("display");
    var save = document.getElementById("save");
    var imdis = document.getElementById("imagedis");
    var stickdis = document.getElementById("stickdis");

    save.disabled = true;
    /* document.getElementsById("stickerbackground").setAttribute("id", "stickerdisabled");  */

    //TAKE A PICTURE
    if(navigator.mediaDevices.getUserMedia)
    {
        navigator.mediaDevices.getUserMedia({video: true}).then((stream) => {
            video.srcObject = stream;
        }).catch((error) => {
            console.log(error);
        });
    }
    var button = document.getElementById("button");
    //var context = canvas2.getContext("2d");
    var imcontext = imagecanvas.getContext("2d");
    var stickcontext = stickercanvas.getContext("2d");
    var stickers = document.getElementsByClassName('stickerdisplay');
   
    var i = 0;
    while (i < stickers.length)
    {
        var sticker = stickers[i];
        sticker.addEventListener("click", (e) => {
            stickcontext.drawImage(e.target, 0, 0);
            stickdis.src = stickercanvas.toDataURL();
        });
        sticker.style.pointerEvents = "none";
        i++;
    }
    button.addEventListener("click", (e) => {
        /* canvas2.height = video.offsetHeight;
        canvas2.width = video.offsetWidth; */
        var xoff, yoff, size;
        size = video.offsetWidth > video.offsetHeight ? video.offsetHeight : video.offsetWidth;
        imagecanvas.height = size;
        imagecanvas.width = size;
        if (video.offsetWidth > video.offsetHeight)
        {
            yoff = 0;
            xoff = -0.25 * video.offsetWidth;
        }
        else
        {
            xoff = 0;
            yoff = -0.25 * video.offsetHeight;
        }    
        imcontext.drawImage(video, yoff, xoff);

        var imageData = imcontext.getImageData(0, 0, video.width, video.height);
        var data = imageData.data;
    
        for(i = 0; i < data.length; i += 4) {
          var brightness = 0.34 * data[i] + 0.5 * data[i + 1] + 0.16 * data[i + 2];
          // red
          data[i] = brightness;
          // green
          data[i + 1] = brightness;
          // blue
          data[i + 2] = brightness;
        }
        // overwrite original image
        imcontext.putImageData(imageData, 0, 0);
        save.disabled=false;
        i = 0;
        while (i < stickers.length)
        {
            var sticker = stickers[i];
            sticker.style.pointerEvents = "auto";
            i++;
        }
        imdis.src = imagecanvas.toDataURL();
      
    });

    //UPLOAD AN IMAGE

    image.addEventListener("change", (ne) => {
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
            doc.onload = () => {
                var xoff, yoff, size;
                size = doc.width > doc.height ? doc.height : doc.width;
                imagecanvas.height = size;
                imagecanvas.width = size;
                if (doc.width > doc.height)
                {
                    yoff = 0;
                    xoff = -0.25 * doc.width;
                }
                else
                {
                    xoff = 0;
                    yoff = -0.25 * doc.height;
                }    
                imcontext.drawImage(doc, xoff,yoff);
                //display.src = canvas.toDataURL(piece);

                var imageData = imcontext.getImageData(0, 0, doc.width, doc.height);
                var data = imageData.data;
            
                for(i = 0; i < data.length; i += 4) {
                var brightness = 0.34 * data[i] + 0.5 * data[i + 1] + 0.16 * data[i + 2];
                // red
                data[i] = brightness;
                // green
                data[i + 1] = brightness;
                // blue
                data[i + 2] = brightness;
                }
                // overwrite original image
                imcontext.putImageData(imageData, 0, 0);
                save.disabled=false;
                i = 0;
                while (i < stickers.length)
                {
                    var sticker = stickers[i];
                    sticker.style.pointerEvents = "auto";
                    i++;
                }
                /* save.disabled=false; */
                imdis.src = imagecanvas.toDataURL();
            }
            doc.src = URL.createObjectURL(piece);
            console.log(doc.src);
        }
    });
    save.addEventListener("click", (ne) => {
        var canvasData = imagecanvas.toDataURL("image/png");
        var stickerData = stickercanvas.toDataURL("image/png");
        console.log(stickerData);
        var request = new XMLHttpRequest();
        request.addEventListener("load", (e) => {
            console.log(request.responseText);
        });
        request.open("POST", "/mvc2/save.php");
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send("image=" + encodeURIComponent(canvasData.replace("data:image/png;base64,", "")) + "&sticker=" + encodeURIComponent(stickerData.replace("data:image/png;base64,", "")));
    });
}
</script>
    </body>
</html>