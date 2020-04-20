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
    <div class="grid2">
        <div>
        <?php
            
            try{
                //FETCH IMAGE
                $querim = $pdo->prepare("SELECT * FROM images WHERE imageid = :imid");
                $querim->bindParam(':imid', $imageid);
                $querim->execute();
                $fetchim = $querim->fetch();
                
                //FETCH USER
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
        <!-- POSTED IMAGE -->
            <img id="picbox" src=<?php echo $fetchim['imagepath'];?>>
        </div>
        <!-- COMMENT PART OF THE BLOCK -->
        <div id="comment">
            <div class="user"><?php echo $fetchus['username'];?></div>
            <p class="sub"><?php echo convdt($fetchim['imagetime']);?></p>
            <!-- LIKES INDICATOR --> 
            <div class="likegrid">
                <div id="likes">
                    <input type="hidden" id="imagelikeid" value=<?php echo $fetchim['imageid'];?>>
                    <input type="hidden" id="userlikeid" value=<?php echo $thisuser;?>>
                    <input type="hidden" id="notifluserid" value=<?php echo $fetchus['email'];?>>
                    <input type="hidden" id="notiflenable" value=<?php echo $fetchus['notif'];?>>
                    <input type="checkbox" id="toggle"/>
                    <label for="toggle" id="toggling"></label> 
                    <!-- <input type="submit" id="likesubmit" style="display: hidden"/> -->
                </div>
                <?php
                //FETCH LIKES
                    try
                    {
                        $querlikes = $pdo->prepare("SELECT * FROM likes WHERE `user_id` = :thisuser AND `imageid` = :thatimage");
                        $querlikes->bindParam('thisuser', $thisuser);
                        $querlikes->bindParam('thatimage', $fetchim['imageid']);
                        $querlikes->execute();
                        $fetcheduslikes = $querlikes->fetch();
                        if($fetcheduslikes['imageid'] && $fetcheduslikes['user_id'])
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
                    window.addEventListener('load', (e) => {
                        var likeimid = document.getElementById('imagelikeid');
                        var likeuserid = document.getElementById('userlikeid').value;
                        var notifluserid = document.getElementById('notifluserid').value;
                        var notiflenable = document.getElementById('notiflenable').value;
                        console.log(likeimid);
                        console.log(likeuserid);
                        console.log(notiflenable);
                        var like = document.getElementById("toggle");
                        like.addEventListener("change", (e) => 
                        {
                            var request = new XMLHttpRequest();
                            request.addEventListener("load", (f) => 
                            {
                                /* location.reload(); */
                                console.log(request.responseText);
                                console.log(e.target.checked);
                                console.log(request.readyState);                            
                            });
                            request.open("POST", "/mvc2/savelike.php");
                            request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            request.send("`imageid`=" + likeimid.value + "&`user_id`=" + likeuserid + "&check=" + e.target.checked + "&notifluser=" + notifluserid + "&notif=" + notiflenable);
                            /* + "&`user_id`=" + likeuserid + "&check=" + e.target.checked */
                        });
                    });
                </script>
                <?php
                /* COMMENTS INDICATOR */
                    try
                    {
                        $quercomcount = $pdo->prepare("SELECT commentscnt FROM images WHERE imageid = :thatimage");
                        $quercomcount->bindParam('thatimage', $fetchim['imageid']);
                        $fetchcomcount = $quercomcount->fetch();
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
                        ?>
                        <p class="sub"><?php echo $fetchcomcount['commentscnt']; ?></p>
                        <?php
                    }
                    catch (PDOexception $e)
                    {
                        //throw $th;
                        echo $e->getMessage();
                    }
                ?>
            </div>
            <div style="position: relative; z-index: 8; padding: 10px 0;">
            <!-- COMMENTS AND THE USERS WHO COMMENTED -->
                <div class="commentgrid">
                <?php
                    try
                    {
                        $querallcomments = $pdo->prepare("SELECT * FROM comments WHERE imageid = :thatimage ORDER BY commenttime DESC");
                        $querallcomments->bindParam('thatimage', $fetchim['imageid']);
                        $querallcomments->execute();
                        //echo $fetchim['imageid'];
                    }
                    catch (PDOexception $e)
                    {
                        echo $e->getMessage();
                    }
                    while($fetchedallcomments = $querallcomments->fetch())
                    {
                        try
                        {
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
                    <input type="hidden" id="imid" value=<?php echo $fetchim['imageid']?>>
                    <input type="hidden" id="thisuserid" value=<?php echo $thisuser;?>>
                    <input type="hidden" id="notifuserid" value=<?php echo $fetchus['email'];?>>
                    <input type="hidden" id="notifenable" value=<?php echo $fetchus['notif'];?>>
                    <input type="submit" id="textsubmit" style="position: absolute; left: -9999px">
                </div>
                <div>
                <script>
                var commentfocus = document.getElementById('comments');
                var commentbox = document.getElementById('commentbox');
                var imid = document.getElementById('imid').value;
                var thisuserid = document.getElementById('thisuserid').value;
                var notifuserid = document.getElementById('notifuserid').value;
                var notifenable = document.getElementById('notifenable').value;
                var textsubmit = document.getElementById('textsubmit');

                commentfocus.addEventListener("click", (c) =>{
                    if(commentbox.value === '')
                    {
                        commentbox.focus();
                    }
                });

                commentbox.addEventListener("keyup", (e) => {
                    if (e.keyCode === 13)
                    { 
                        var requestc = new XMLHttpRequest();
                        requestc.onload = function () {
                            console.log('DONE', requestc.readyState);
                            console.log("foks");
                            location.reload();
                        };
                        requestc.open("POST", "/mvc2/savecomment.php");
                        requestc.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        requestc.send("commenttext=" + commentbox.value + "&imageid=" + imid + "&uid=" + thisuserid + "&notifuser=" + notifuserid + "&notif=" + notifenable);
                    }
                }); 
                </script>
                </div>
            </div>
        </div>
    </div>
</body>
</html>