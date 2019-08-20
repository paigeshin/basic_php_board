<?php
include_once "../db/db.php";

$userId = $_POST['userId'];
$userPassword = password_hash($_POST['userPassword'], PASSWORD_DEFAULT);
$userTitle = $_POST['userTitle'];
$userContent = $_POST['userContent'];
$date = date("Y-m-d");
$hit = 0;

$sql_statement = "INSERT INTO board (idx, name, pw, title, content, date, hit) VALUES (NULL, '$userId', '$userPassword', '$userTitle', '$userContent', '$date', '$hit')";
$query = mysqli_query($connection, $sql_statement);

if(!$query){
    return;
}

?>


<script type="text/javascript">alert("글쓰기가 완료되었습니다.")</script>
<meta http-equiv="refresh" content="0 url=/">




