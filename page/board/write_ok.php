<?php

include_once $_SERVER['DOCUMENT_ROOT']."/db.php";

$name = $_POST['name'];
$userpw = password_hash($_POST['pw'], PASSWORD_DEFAULT);
$title = $_POST['title'];
$content = $_POST['content'];
$date = date('Y-m-d');
if(isset($_POST['lockpost'])){
    $lo_post = '1';
} else {
    $lo_post = '0';
}

//파일 핸들링
$tmpfile = $_FILES['b_file']['tmp_name'];
$o_name = $_FILES['b_file']['name'];
$filename = iconv("UTF-8", "EUC-KR", $_FILES['b_file']['name']);
$folder = "../../upload/".$filename;
move_uploaded_file($tmpfile, $folder);

$mqq = mq("ALTER TABLE board AUTO_INCREMENT = 1"); //auto_increment 값 초기화 - idx 1, 2, 3, 4 가다가 중간에 없는 숫자가 있으면 거기서부터 만듬.

$sql = mq("INSERT INTO board(idx, name, pw, title, content, date, hit, lock_post, file) values(NULL ,'$name', '$userpw', '$title', '$content' ,'$date', 0, '$lo_post', '$o_name')");


?>

<script type="text/javascript">alert("글쓰기 완료되었습니다.");</script>
<!--<meta http-equiv="refresh" content="0 url=/" />-->
