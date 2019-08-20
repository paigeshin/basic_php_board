<?php

include_once "../../db/db.php";


    //비밀번호 verification
    $reply_index = $_GET['idx'];
    $boardId = $_POST['boardId'];
    $replyModificationId = $_POST['replyModificationId'];
    $replyModificationPassword = $_POST['replyModificationPassword'];
    $replyModificationText = $_POST['replyModificationText'];
    $date = date("Y-m-d");

    $sql_update_comment = "UPDATE reply SET NAME = '$replyModificationId', content = '$replyModificationText', date = '$date' WHERE idx = '24' AND board_id = '$boardId'";
    mysqli_query($connection, $sql_update_comment);



?>