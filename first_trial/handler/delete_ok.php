<?php

include_once "../db/db.php";

//db에서 비밀번호를 꺼내서 비교해주기 위해 작성.
$idx = $_GET['idx'];
$password = $_POST['userPassword'];
$sql = "SELECT * FROM board WHERE idx = '$idx'";
$query = mysqli_query($connection ,$sql);
$board = mysqli_fetch_array($query);
?>

//비밀번호 맞는지 아닌지 확인
<?php
$validation = password_verify($password , $board['pw']);
if($validation){
    //삭제
    $sql_delete = "DELETE FROM board WHERE idx='$idx'";
    $query_delete = mysqli_query($connection ,$sql_delete);
?>

<script type="text/javascript">alert("삭제되었습니다!")</script>
<meta http-equiv="refresh" content="0 url=/">

<?php } else { ?>

<script type="text/javascript">alert("비밀번호가 일치하지 않습니다!")</script>
<meta http-equiv="refresh" content="0 url=/show.php?idx=<?php echo $idx; ?>">

<?php } ?>





