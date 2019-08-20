<?php
include_once "../db/db.php";

//page에서 데이터 받아오기
$idx = $_GET['idx'];
$user_id = $_POST['userId'];
$password = $_POST['userPassword'];
$user_password = password_hash($password, PASSWORD_DEFAULT);
$user_title = $_POST['userTitle'];
$userContent = $_POST['userContent'];

//해당 글의 id password가 보내온 값과 같은지 않은지 체크하는 validation
$sql_validation = "SELECT * FROM board WHERE idx='$idx'";
$query_validation = mysqli_query($connection, $sql_validation);
$board_validation = mysqli_fetch_array($query_validation);
$validation = password_verify($password , $board_validation['pw']);
if($validation){ ?>
    <script type="text/javascript">alert("수정되었습니다.");</script>
    <meta http-equiv="refresh" content="0 url=/show.php?idx=<?php echo $idx; ?>">
    <?php
        //비밀번호가 일치할 시에 업데이트 시킴.
        $sql_update = "UPDATE board set name='$user_id', pw = '$user_password', title = '$user_title', content = '$userContent' WHERE idx='$idx'";
        $query_update = mysqli_query($connection, $sql_update);
        if(!$query_update)
        {
            return;
        }
    ?>

<?php } else { ?>

    <script type="text/javascript">alert("비밀번호가 일치하지 않습니다!")</script>
    <meta http-equiv="refresh" content="0 url=/show.php?idx=<?php echo $idx; ?>">

<?php } ?>