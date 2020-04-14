<?php
    function loadcomment($querallcomments)
    {
        if(!isset($_SESSION['uid']))
        {
            session_start();
        }
        require ('../config/database.php');
        if($fetchedallcomments = $querallcomments->fetch())
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
    }
?>