<!-- DB연결, mq함수 -->

<?php
session_start();
//한글 깨짐 방지.
header('Content-Type: text/html; charset=utf-8');

$db = mysqli_connect("localhost", "root", "123123", "post_board");
$db->set_charset("utf-8");

/*
아래 함수를 통해서 기존에
mysqli_query($connection, $sql_statement)를 return.
*/
function mq($sql){
    global $db;
    return mysqli_query($db, $sql);
}

?>