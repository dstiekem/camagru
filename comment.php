<html>
<head>
    <link rel="stylesheet" type="text/css" href="stylesheet2.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700i,700,800&display=swap" rel="stylesheet">
    <?php
        session_start();
        if(isset($_SESSION['form_message']))
            unset($_SESSION['form_message']);
        if(isset($_SESSION['uid']))
        {   
            $page = "comment";
            require (dirname(__FILE__) . '/header.php');
            require (dirname(__FILE__) . '/config/database.php');
            include (dirname(__FILE__) . '/functions/convertdatetime.php');
            $thisuser = $_SESSION['uid'];
            if(!isset($_POST['imageid']))
            {
                header('Location: ../mvc2/home.php');
            }
            $imageid = $_POST['imageid'];
        }
        else
        {
            header('Location: ../mvc2/loggedout.php');
        }
    ?>
</head>
<body>
    <?php
        
        if(isset($_POST["imagelikeid"]) && isset($_POST["userlikeid"]))
        {
            $imagelikeid = $_POST["imagelikeid"];
            $userlikeid = $_POST["userlikeid"];
            try{
                $inslike = $pdo->prepare("INSERT INTO likes (imageid, `user_id`) VALUES (:imageid, :userid)");
                $inslike->bindParam("imageid", $imagelikeid);
                $inslike->bindParam("userid", $userlikeid);
                $inslike->execute();
            }
            catch (PDOexception $e){
                //throw $th;
                    echo $e->getMessage();
            }
        }
    ?>
    <div class="grid2">
        <div>
        <?php
            try{
                $querim = $pdo->prepare("SELECT * FROM images WHERE imageid = :imid");
                $querim->bindParam(':imid', $imageid);
                $querim->execute();
                $fetchim = $querim->fetch();
                
                $userid = $fetchim['user_id'];
                $querusername = $pdo->prepare("SELECT * FROM users WHERE userid = :userid");
                $querusername->bindParam(':userid', $userid);
                $querusername->execute();
                $fetchus = $querusername->fetch();
                }
                catch (PDOexception $e)
                {
                    //throw $th;
                    echo $e->getMessage();
                }
        ?>
      <!--   PERSON WHO POSTED IMAGE -->
            <img id="picbox" src=<?php echo $fetchim['imagepath'];?>>
        </div>
        <div id="comment">
        <div class="user"><?php echo $fetchus['username'];?></div>
        
        <p class="sub"><?php echo convdt($fetchim['imagetime']);?></p>
        <!-- LIKES INDICATOR --> 
        <div class="likegrid">
        <div id="likes">
            <input type="checkbox" name="liking" id="toggle" style="display: none;">
            <label for="toggle"><img src="http://localhost:8080/mvc2/graphics/tolike.svg" /></label>
            <input type="hidden" value="<?php echo $imageid?>" id="imagelikeid">
            <input type="hidden" value="<?php echo $thisuser?>" id="userlikeid">
        </div>
        <?php
        try{ 
            $querlikes = $pdo->prepare("SELECT * FROM likes WHERE `user_id` = :thisuser AND imageid = :thatimage");
            $querlikes->bindParam('thisuser', $thisuser);
            $querlikes->bindParam('thatimage', $fetchim['imageid']);
            $querlikes->execute();
            $fetcheduslikes = $querlikes->fetch();
            if($fetcheduslikes['user_id'] && $fetcheduslikes['imageid'])
            {
                ?>
                <script>document.getElementById('toggle').checked = true;</script>
                <?php
            }
            else
            {
                ?>  
                <script>document.getElementById('toggle').checked = false;</script>
                <?php
            }
        }
        catch (PDOexception $e)
        {
            //throw $th;
            echo $e->getMessage();
        }
        ?>
        <script>
        window.addEventListener('load', (e)=>{
            var likeimid = document.getElementById('imagelikeid').value;
            var likeuserid = document.getElementById('userlikeid').value;
            var like = document.getElementById("toggle");
            console.log("klippies");
            like.addEventListener('change', (e)=>{
                console.log(e.target.checked);
                var request = new XMLHttpRequest();
                request.open("POST", "/mvc2/functions/setlikes.php");
                request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                request.send("check=" + e.target.checked + "&imageid=" + likeimid + "&user_id=" + likeuserid);
            });
        });
        </script>
        <?php
        /* COMMENTS INDICATOR */
        try{
            $quercomments = $pdo->prepare("SELECT * FROM comments WHERE `user_id` = :thisuser AND imageid = :thatimage");
            $quercomments->bindParam('thisuser', $thisuser);
            $quercomments->bindParam('thatimage', $fetchim['imageid']);
            $quercomments->execute();
            $fetcheduscomments = $quercomments->fetch();
            if($fetcheduscomments['user_id'] && $fetcheduscomments['imageid'])
            {
                ?>
                <img id="comments" src="http://localhost:8080/mvc2/graphics/commented.svg">
                <?php
            }
            else
            {
                ?>
                <img id="comments" src="http://localhost:8080/mvc2/graphics/tocomment.svg">
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

        <!-- COMMENTS AND THE USERS WHO COMMENTED -->
        <div style="position: relative; z-index: 8; padding: 10px 0;">
        <div class="commentgrid">
            <?php
            try{
                $querallcomments = $pdo->prepare("SELECT * FROM comments WHERE imageid = :thatimage");
                $querallcomments->bindParam('thatimage', $fetchim['imageid']);
                $querallcomments->execute();
                //echo $fetchim['imageid'];
            }
            catch (PDOexception $e)
            {
                //throw $th;
                echo $e->getMessage();
            }
            while($fetchedallcomments = $querallcomments->fetch())
            {
                try{
                    $quercomus = $pdo->prepare("SELECT * FROM users WHERE userid = :use_id");
                    $quercomus->bindParam("use_id", $fetchedallcomments['user_id']);
                    $quercomus->execute();
                    if($fetchthisuser = $quercomus->fetch())
                    {
                    ?>
                    <div class="commenteach">
                        <p style="font-weight: 700; font-size: 1em; z-index:"><?php echo $fetchthisuser['username']?></p>
                        <p><?php echo $fetchedallcomments['commenttext']?></p>
                    </div>
                    <?php
                    }
                }
                catch (PDOexception $e)
                {
                    //throw $th;
                    echo $e->getMessage();
                }
            }
            ?>
        </div>
        
            <div class="text">
                <input type="text" id="commentbox" placeholder="comment">
                <input type="hidden" id="imid" value=<?php echo $fetchim['imageid'] ?>>
                <input type="hidden" id="thisuserid" value=<?php echo $thisuser;?>>
                <button id="textsubmit" style="position: absolute; left: -9999px"></button>
                <!-- <?php //header('location:' . $_SERVER['REQUEST_URI']);?> -->
            </div>
            <script>
            var commentbox = document.getElementById('commentbox');
            var imid = document.getElementById('imid').value;
            var thisuserid = document.getElementById('thisuserid');
            var textsubmit = document.getElementById('textsubmit');

            commentbox.addEventListener("keyup", (e) => {
                if (e.keyCode === 13)
                {
                    console.log("any");
                    e.preventDefault();
                    textsubmit.click();
                    var request = new XMLHttpRequest();
                    request.addEventListener("load", (e) => {
                        var textdisplay = document.createElement('commenteach');
                        textdisplay.innerHTML = (request.responseText);
                        var commentgrid = document.getElementsByClassName('commentgrid');
                        console.log(request.responseText);
                        commentgrid.innerHTML.appendChild(textdisplay);
                        
                    });
                    request.open("POST", "/mvc2/savecomment.php");
                    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    request.send("commenttext=" + commentbox.value + "&imageid=" + imid + "&uid=" + thisuserid);
                /* } */
                }
            });
                
            </script>
        <!-- </div> -->
        </div>
                
        </div>
    </div>
<body>
</html>