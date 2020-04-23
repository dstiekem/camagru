<html>
  <head>
  <link rel="stylesheet" type="text/css" href="stylesheet2.css">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700i,800&display=swap" rel="stylesheet">
  </head>
<?php
session_start();
if(!isset($_SESSION['uid']))
{
    
    header('Location: ' . str_replace("newimage.php", "loggedout.php", $_SERVER['REQUEST_URI']));
}
else
{
    
        $page = "newimage";
        require (dirname(__FILE__) . '/header.php');
        require (dirname(__FILE__) . '/config/database.php');
        /* require (dirname(__FILE__) . '/functions/fetchuid.php'); */
        require (dirname(__FILE__) . '/functions/modal.php');
    ?>
    <body>
        <div class="grid">
            <div style="max-height: 480px;">
                <div>
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
            <div id="imholder">
                <div>   
                    <!-- WHERE THE IMAGES ARE DISPLAYED  -->
                    <div style="position: relative; width: 480px; height:480px" id="disparent">
                        <img id="imagedis" width="480" height="480">
                        <img id="stickdis" style="position: absolute; top: 0; left: 0; z-index: 100;" width="480" height="480">
                    </div>
                </div>
                <div id="stickerbackground">
                <?php
                    //STICKER PANEL
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
                        echo $e->getMessage();
                    }
                    ?>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div class="stickerdisplayn">
                        <input type="submit" value="CLEAR" id="clear" class="btn">
                    </div>
                </div>
                <div class="delandsave">
                    <input type="submit" value="SAVE" id="save" class="btn">
                    <input type="submit" value="DELETE" id="delete" class="btn">
                </div>
            </div>
        </div>
        <div id="newthumbnails"></div>
        <div id="thumbnails">
        <?php
        //THUMBNAILS THAT GO TO COMMENTS
        try
        {
            $images = $pdo->prepare("SELECT * FROM images ORDER BY imagetime DESC");
            $images->execute();
            
            if(isset($_SESSION['uid']))
            {
                while($fetchedim = $images->fetch())
                {
                    ?>
                    <div class="thumbnailsinner">
                    <form action="comment.php" method="post">
                        <input type="hidden" id="thumbid" value="<?php echo ($fetchedim['imageid'])?>" name="imageid">
                        <input type="image" id="thumbim" src="<?php echo ($fetchedim['imagepath']);?>" alt="Submit" />
                    </form>
                    </div>
                    <?php
                }
            }
        }
        catch (PDOexception $e)
        {
            echo $e->getMessage();
        }
        ?>
        </div>
        <script>
        window.onload = function()
        {
            var imagecanvas = document.createElement('canvas');
            
            var image = document.getElementById("hello");
            var video = document.getElementById("video");
            var display = document.getElementById("display");
            var save = document.getElementById("save");
            var del = document.getElementById("delete");
            var clear = document.getElementById("clear");
            var imdis = document.getElementById("imagedis");
            save.disabled = true;
            del.disabled = true;
            clear.disabled = true;

            //NEW THUMNAILS TO DISPLAY and DELETE
            var thumb = document.getElementsByClassName('thumbnailsinner');
            var thumbparent = document.getElementById('thumbnails');
            /* var newthumbparent = thumbparent.cloneNode(false);
            newthumbparent.id = "newthumbnails";  */
            var newthumbparent = document.getElementById('newthumbnails');
     

            //SETUP CAMERA AND STICKERS
            if(navigator.mediaDevices.getUserMedia)
            {
                navigator.mediaDevices.getUserMedia({video: true}).then((stream) => {
                    video.srcObject = stream;
                }).catch((error) => {
                    console.log(error);
                });
            }
            var button = document.getElementById("button");
            var imcontext = imagecanvas.getContext("2d");
            
            var stickercanvas = document.createElement('canvas');
            var stickdis = document.getElementById("stickdis");
            stickercanvas.height = 480;
            stickercanvas.width = 480;
            var stickcontext = stickercanvas.getContext("2d");
            var stickers = document.getElementsByClassName('stickerdisplay');
            var i = 0;
            while (i < stickers.length)
            {
                var sticker = stickers[i];
                sticker.addEventListener("click", (e) => {
                    /* var putstick = imcontext.getImageData(0, 0, 480, 480); */
                    /* var sticktodraw = sticker.getAttributeNode("src"); */
                    /*  */
                    stickcontext.drawImage(e.target, 0, 0);
                    stickdis.src = stickercanvas.toDataURL("image/png");
                    clear.disabled = false;    
                });
                sticker.style.pointerEvents = "none";
                i++;         
            }
            clear.addEventListener("click", (cl) => {
                var clearstick = stickcontext.createImageData(480, 480);
                stickcontext.putImageData(clearstick, 0, 0);
                /* stickcontext.drawImage(cl.target, 0, 0); */
                stickdis.src = stickercanvas.toDataURL("image/png");
                console.log("clear clicked");
            });

            //TAKE A PICTURE
            button.addEventListener("click", (e) => {
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
                //convert image to data in order to grayscale
                var data = imageData.data;

                for(i = 0; i < data.length; i += 4) 
                {
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
                imdis.src = imagecanvas.toDataURL("image/png");   
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
                       /*  display.src = canvas.toDataURL(piece);  */

                        var imageData = imcontext.getImageData(0, 0, doc.width, doc.height);
                        var data = imageData.data;
                    
                        for(i = 0; i < data.length; i += 4) {
                        var brightness = 0.34 * data[i] + 0.5 * data[i + 1] + 0.16 * data[i + 2];
                        data[i] = brightness;
                        data[i + 1] = brightness;
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
                        imdis.src = imagecanvas.toDataURL("image/png");

                    }
                    doc.src = URL.createObjectURL(piece);
                    console.log(doc.src); 
                    
                }
            });
            save.addEventListener("click", (ne) => {
                var canvasData = imagecanvas.toDataURL("image/png");
                if(stickdis.src != "")
                {
                    var stickerData = stickdis.src;
                }
                var request = new XMLHttpRequest();
                request.addEventListener("load", (e) => {
                    
                    console.log(request.responseText);
                    var justsavedpath = "<?php echo "http://" . $_SERVER['HTTP_HOST'] ?>" + request.responseText.substr(7, 33);
                    console.log(justsavedpath);
                    var justsavedid = request.responseText.substr(0, 5);

                    var newthumb = thumb[0].cloneNode(true);
                    document.body.insertBefore(newthumbparent, thumbparent);
                    newthumbparent.prepend(newthumb);
                    var newthumbv = newthumb.querySelector('#thumbid');
                    var newthumbs = newthumb.querySelector('#thumbim');
                    newthumb.id = "newthumbid"; 
                    
                    newthumbv.setAttribute('value', justsavedid);
                    /* newthumbv.id = "thumbidnew"; */
                    newthumbs.setAttribute('src', justsavedpath);
                    if(newthumbparent.hasChildNodes())
                    {
                        console.log("it exists");
                        del.disabled=false;
                    }
                });
                request.responseType = '';

                request.open("POST", "<?php echo str_replace("newimage.php", "save.php", $_SERVER['REQUEST_URI'])?>");

                request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                if(stickerData)
                {
                    request.send("image=" + encodeURIComponent(canvasData.replace("data:image/png;base64,", ""))+ "&sticker=" + encodeURIComponent(stickerData.replace("data:image/png;base64,", "")));
                }
                else
                {
                    request.send("image=" + encodeURIComponent(canvasData.replace("data:image/png;base64,", "")) + "&sticker=NOT");

                }
            });
            /* var thumbremove = document.getElementById("newthumbnails"); */
            if(!newthumbparent.hasChildNodes())
            {
                del.disabled=true;
                console.log("fuckyou");
            }
                console.log("it exists");
                /* del.disabled=false; */
                del.addEventListener("click", (e) => {
                        var thumbv = thumb[0].querySelector('#thumbid').value;
                        var thumbremove = document.getElementById("newthumbid");
                        var request = new XMLHttpRequest();
                        newthumbnails.removeChild(thumbremove);
                        request.addEventListener("load", (l) => {
                            console.log(request.responseText);
                            if(request.responseText == "it dunnaeworkFOK")
                            {
                                /* document.getElementById("imholder").innerHTML = "
                                echo modal("error", "You can't delete other peoples stuff! rude");
                                " */
                                console.log("no");
                            }     

                        });
                    request.open("POST", "<?php echo str_replace("newimage.php", "delete.php", $_SERVER['REQUEST_URI'])?>");
                    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    request.send("imageid=" + thumbv + "&usim=" + "<?php echo $fetchedim['user_id']?>" + "&usus=" + "<?php echo $_SESSION['uid']?>");
                }); 
        }
        </script>
    </body>
    <?php
    }
    ?>
</html>