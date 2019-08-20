<!--
메인 역할: 화면
글을 읽는 부분
-->
<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/db.php";
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>게시판</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="stylesheet" href="/css/jquery-ui.css">
    <script src="/js/jquery.js"></script>
    <script src="/js/jquery-ui.js"></script>
    <script src="/js/common.js"></script>
</head>
<body>
    <?php
        $bno = $_GET['idx'];
        $hit = mysqli_fetch_array(mq("SELECT * FROM board WHERE idx = '".$bno."'"));
        $hit = $hit['hit'] + 1;
        $fet = mq("UPDATE board SET hit = '".$hit."' WHERE idx = '".$bno."'");
        $sql = mq("SELECT * FROM board WHERE idx='".$bno."'");
        $board = $sql -> fetch_array();
    ?>
<!-- 글 불러오기 -->
<div id="board_read">
    <h2><?php echo $board['title'];?></h2>
        <div id="user_info">
            <?php echo $board['name']; ?>
            <?php echo $board['date']; ?>
            <?php echo "조회:" . $board['hit']; ?>
            <div id="bo_line"></div>
        </div>
        <div>
            파일 : <a href="../../upload/<?php echo $board['file']; ?>" download><?php echo $board['file'] ?></a>
        </div>      
        <div id="bo_content">
            <?php echo nl2br("$board[content]"); ?>
        </div>

<!-- 목록, 수정, 삭제 -->
<div id="bo_ser">
    <ul>
        <li><a href="/">[목록으로]</a></li>
        <li><a href="modify.php?idx=<?php echo $board['idx']; ?>">[수정]</a></li>
        <li><a href="delete.php?idx=<?php echo $board['idx']; ?>">[삭제]</a></li>
    </ul>
</div>
<!-- 댓글 불러오기 -->
<div class="reply_view">
    <h3>댓글목록</h3>
    <?php
        $sql3 = mq("SELECT * FROM reply WHERE con_num='".$bno."' ORDER BY idx DESC");
        while($reply = $sql3->fetch_array()){
    ?>
            <div class="dap_lo">
                <div><b><?php echo $reply['name'];?></b></div>
                <div class="dap_to comt_edit"><?php echo nl2br("$reply[content]"); ?></div>
                <div class="rep_me dap_to"><?php echo $reply['date']?></div>
                <div class="rep_me rep_menu">
                    <a class="dat_edit_bt" href="#">수정</a>
                    <a class="dat_delete_bt" href="#">삭제</a>
                </div>
                <!-- 댓글 수정 폼 dialog, while문 내부에서 각각 form안에서 게시글 index 댓글 index를 보내준다.-->
                <div class="dat_edit">
                    <form action="rep_modify_ok.php" method="POST">
                        <input type="hidden" name="rno" value="<?php echo $reply['idx']; ?>">
                        <input type="hidden" name="b_no" value="<?php echo $bno;?>">
                        <input type="password" name="pw" class="dap_sm" placeholder="비밀번호">
                        <textarea name="content" class="dap_edit_t"><?php echo $reply['content']; ?></textarea>
                        <input type="submit" value="수정하기" class=re_mo_bt>
                    </form>
                </div>
                <!-- 댓글 삭제 비밀번호 확인 dialog, while문 내부에서 각각 form안에서 게시글 index 댓글 index를 보내준다. -->
                <div class="dat_delete">
                    <form action="reply_delete.php" method="POST">
                        <input type="hidden" name="rno" value="<?php echo $reply['idx'] ?>">
                        <input type="hidden" name="b_no" value="<?php echo $bno; ?>">
                        <p>비밀번호<input type="password" name="pw"> <input type="submit" value="확인"></p>
                    </form>
                </div>
            </div>
    <?php
    }?>
</div>

<!-- 댓글 입력 폼 -->
<div class="dap_ins">
    <form method="POST" class="reply_form">
        <input type="hidden" name="bno" value="<?php echo $bno; ?>">
        <input type="text" name="dat_user" id="dat_user" size="15" placeholder="아이디">
        <input type="password" name="dat_pw" id="dat_pw" size="15" placeholder="비밀번호">
        <div style="margin-top:10px;">
            <textarea name="content" class="reply_content" id="re_content"></textarea>
            <button type="submit" class="re_bt">댓글</button>
        </div>
    </form>
</div>

<!-- 댓글 불러오기 끝-->
<div id="foot_box"></div>

</div>

</body>
</html>
