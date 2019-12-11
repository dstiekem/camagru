<html>
<head>
    <link rel="stylesheet" type="text/css" href="stylesheet2.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700i,700,800&display=swap" rel="stylesheet">
    <?php
        session_start();
        if(isset($_SESSION['uid']))
        {   
            $page = "comment";
            require (dirname(__FILE__) . '/header.php');
            require (dirname(__FILE__) . '/config/database.php');
            include (dirname(__FILE__) . '/functions/convertdatetime.php');
            $thisuser = $_SESSION['uid'];
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
        if(isset($_POST['comment']) && isset($_POST['imageid']))
        {
            $comment = htmlspecialchars($_POST['comment'], ENT_QUOTES);
            $user = $_SESSION['uid'];
            $imageid = $_POST['imageid'];
            try{
                $inscomment = $pdo->prepare("INSERT INTO comments (`imageid`, `user_id`, commenttext) VALUES
                (:imageid, :userid, :commentt)");
                $inscomment->bindParam("imageid", $imageid);
                $inscomment->bindParam("userid", $user);
                $inscomment->bindParam("commentt", $comment);
                $inscomment->execute();
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
                
                <p class="sub"><?php echo convdt($fetchim['imagetime'])?></p>
                
                <div class="likegrid">
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
                        <img id="likes" src="http://localhost:8080/mvc2/graphics/liked.svg">
                        <?php
                    }
                    else
                    {
                        ?>
                        <img id="likes" src="http://localhost:8080/mvc2/graphics/tolike.svg">
                        <input type="hidden" name="imageid" value=<?php echo $fetchim['imageid'] ?>>
                        <input type="submit" style="position: absolute; left: -9999px"/>
                        <?php

                    }
                }
                catch (PDOexception $e)
                {
                    //throw $th;
                    echo $e->getMessage();
                }
                /* COMMENTS AND LIKES INDICATOR */
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
                <!-- <div style="position: static;"> -->
                    <form action="comment.php" method="post" class="text">
                        <input type="text" placeholder="comment" name="comment">
                        <input type="hidden" name="imageid" value=<?php echo $fetchim['imageid'] ?>>
                        <input type="submit" style="position: absolute; left: -9999px"/>
                    </form>
                <!-- </div> -->
                </div>
                
        </div>
    </div>
<body>
</html>