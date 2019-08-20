<?php

include_once "../../db/db.php";

if(isset($_POST['boardId']) && isset($_POST['replyId']) && isset($_POST['replyPassword']) && isset($_POST['replyContent'])){

    $boardId = $_POST['boardId'];
    $replyId = $_POST['replyId'];
    $replyPassword = password_hash($_POST['replyPassword'], PASSWORD_DEFAULT);
    $replyContent = $_POST['replyContent'];
    $date = date("Y-m-d");

    $sql_create_comment = "INSERT INTO reply (idx, board_id, name, pw, content, date) VALUES(NULL, '$boardId', '$replyId', '$replyPassword', '$replyContent', '$date')";
    mysqli_query($connection, $sql_create_comment);

}

?>