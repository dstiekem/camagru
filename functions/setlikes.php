<?php
if(!isset($_SESSION['uid']))
{
    session_start();
    set_include_path("..");
    include ('config/database.php');
    function setlike($boool, $uid, $imid){
        global $pdo;
        if($boool === 1)
        {
            try{
                $update = $pdo->prepare("INSERT INTO likes (imageid, `user_id`) VALUES (:imid, :userid)");
                $update->bindParam(':imid', $imid);
                $update->bindParam(':userid', $uid);
                $update = $update->execute();
            }
            catch (PDOexception $e) {
                //throw $th;
                echo $e->getMessage();
            }
        }
        else if(!$boool === 0)
        {
            try{
                $update = $pdo->prepare("DELETE FROM likes WHERE imageid = :imid AND `user_id` = :userid");
                $update->bindParam(':imid', $imid);
                $update->bindParam(':userid', $uid);
                $update = $update->execute();
            }
            catch (PDOexception $e) {
                //throw $th;
                echo $e->getMessage();
            }
        }
        return ;
    }
    if(isset($_POST['check']))
        setlike(1, $_POST['user_id'], $_POST['imageid']);
    else if(!isset($_POST['check']))
        setlike(0, $_POST['user_id'], $_POST['imageid']);
}
?>