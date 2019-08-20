<!--
메인 역할: 화면
비밀글 modal 띄어주고, 비밀번호가 맞으면 글을 보여주는 화면으로 간다.
-->
<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/db.php";
?>
<link rel="stylesheet" href="/css/jquery-ui.css">
<script src="/js/jquery.js"></script>
<script src="/js/jquery-ui.js"></script>
<script>
    $(function(){
        $("#writepass").dialog({
            modal: true,
            title:'비밀글입니다.',
            width: 400
        });
    });
</script>

<?php

$bno = $_GET['idx'];
$sql = mq("SELECT * FROM board WHERE idx='".$bno."'");
$board = $sql -> fetch_array();
$bpw = $board['pw']; //db에서 가져온 비밀번호

?>

<div id="writepass">
    <form action="" method="POST">
        <p>비밀번호<input type="password" name="pw_chk"><input type="submit" value="확인"></p>
    </form>
</div>

<?php

if(isset($_POST['pw_chk'])){
    $pwk = $_POST['pw_chk'];
    if(password_verify($pwk, $bpw)){
?>
    <script>location.replace("read.php?idx=<?php echo $board['idx'];?>")</script>
<?php
    } else {
?>
    <script>alert("비밀번호가 틀립니다");</script>
<?php
    }
}
?>