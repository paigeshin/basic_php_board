<!--
메인 역할: 데이터 처리
글을 수정하는 부분을 처리
-->
<?php
include_once  $_SERVER['DOCUMENT_ROOT']."/db.php";

$bno = $_POST['idx'];
$name = $_POST['name'];
$userpw = password_hash($_POST['pw'], PASSWORD_DEFAULT);
$title = $_POST['title'];
$content = $_POST['content'];

$sql = mq("UPDATE board SET name='$name', pw='$userpw', title='$title', content='$content' WHERE idx='".$bno."'");
?>
<script type="text/javascript">alert("수정되었습니다.");</script>
<meta http-equiv="refresh" content="0 url=/page/board/read.php?idx=<?php echo $bno; ?>">

