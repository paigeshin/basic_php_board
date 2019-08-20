<!--
메인 역할: 데이터 처리
글을 삭제하는 부분
 -->
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/db.php";

$bno = $_GET['idx'];
$sql = mq("DELETE FROM board WHERE idx='$bno';");
?>
<script type="text/javascript">alert("삭제되었습니다.");</script>
<meta http-equiv="refresh" content="0 url=/" />