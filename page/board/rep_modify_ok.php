<!--
메인 역할: 데이터 처리
댓글 수정하는 부분
-->

<?php
include_once $_SERVER['DOCUMENT_ROOT']."/db.php";
$rno = $_POST['rno'];
$sql = mq("SELECT * FROM reply WHERE idx='$rno'");
$reply = $sql->fetch_array();

$bno = $_POST['b_no'];
$sql2 = mq("SELECT * FROM board WHERE idx='$bno'");
$board = $sql2 -> fetch_array();

$content = $_POST['content'];
$sql3 = mq("UPDATE reply SET content='$content' WHERE idx = '".$rno."'");
?>

<script type="text/javascript">alert('수정되었습니다.'); location.replace("read.php?idx=<?php echo $bno; ?>");</script>
