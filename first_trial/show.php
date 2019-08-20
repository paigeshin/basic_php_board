<?php

include_once "db/db.php";
include_once "views/header/header.php"

?>

<?php
    //일단 idx 값으로 해당 정보를 가져옴
    $idx = $_GET['idx'];
    $sql_statement = "SELECT * FROM board WHERE idx = '".$idx."'";
    $query = mysqli_query($connection, $sql_statement);
    $selected_board = mysqli_fetch_array($query);
    //조회수 업데이트
    $hit = $selected_board['hit'] +1;
    $update_sql_statement = "UPDATE board SET hit = '".$hit."' WHERE idx = '".$idx."'";
    $update_query = mysqli_query($connection, $update_sql_statement);
    //다시 업데이트된 내용을 토대로 게시물을 가져옴
    $sql_updated_statement = "SELECT * FROM board WHERE idx = '".$idx."'";
    $query_updated = mysqli_query($connection, $sql_updated_statement);
    $board = mysqli_fetch_array($query_updated);

?>

<h1>글읽기</h1>
<h3><?php echo $board['title'] ?></h3>
<p><?php echo $board['name'] . "  |  " . $board['date'] . "  |  " . "조회수: " . $board['hit']?></p>
<hr>
<p><?php echo $board['content'] ?></p>

<hr>
<!--
여기서부터 댓글 로직 시작
1. 댓글을 표현해줄 공간을 만든다.
    - 댓글마다 각각 수정, 삭제, 답글 버튼도 달려있어야함.
2. 댓글을 작성하는 공간을 만든다.
3. DB에 데모데이터를 넣어서 불러온다.
-->


    <form id="dynamicFormReply" method="POST">
        <p>
            <a id="btnShowReply" class="btn btn-success" data-toggle="collapse" href="#showReply" role="button" aria-expanded="false" aria-controls="showReply">
                댓글보기
            </a>
            <a id="btnCreateReply" style="color:white;" class="btn btn-primary" data-toggle="collapse" href="#createFormReply" aria-expanded="false" aria-controls="createFormReply">
                댓글작성
            </a>
        </p>

        <div class="collapse" id="showReply">

            <!--  댓글 불러오기 -->
            <?php
                $sql_reply = "SELECT * FROM reply WHERE board_id='".$idx."' ORDER BY idx DESC";
                $query_reply = mysqli_query($connection, $sql_reply);
                while($reply = mysqli_fetch_array($query_reply)){
            ?>

            <div class="card card-body reply_body" style="text-align: left">
                <p><?php echo $reply['name'] . " | " . $reply['date']?></p>
                <p class="content-<?php echo $reply['idx']?>"><?php echo $reply['content'] ?></p>
                <p></p>
                <div>
                    <button type="submit" class="btn btn-warning btn-sm btnReplyReply" style="color:white; width: 100px">
                        <a href="handler/reply/reply_modify_ok.php?idx=<?php echo $reply['idx'] ?>">답글 달기</a></button>
                    <button type="submit" class="btn btn-info btn-sm btnReplyModify" style="width: 100px">
                        <a href="handler/reply/reply_modify_ok.php?idx=<?php echo $reply['idx'] ?>">수정</a></button>
                    <button type="submit" class="btn btn-danger btn-sm btnReplyDelete" style="width: 100px">
                        <a href="handler/reply/reply_modify_ok.php?idx=<?php echo $reply['idx'] ?>">삭제</a></button>
                </div>
            </div>

            <?php } ?>
        </div>


        <script>

            let clicked = false;

            $('#btnShowReply').on('click' , () => {
                $('#createFormReply').removeClass("show");
            });
            $('#btnCreateReply').on('click', () => {
                $('#showReply').removeClass("show");
            })

        </script>

        <!-- 자바스크립트로 ajax 통해 작성,작성,수정,삭제 등을 control 할 것.-->
        <script src="script/reply_ajax.js"></script>


    </form>

    <!--  댓글 작성 form.  -->
    <div style="text-align: left" class="collapse" id="createFormReply">
        <div class="form-group">
            <input type="hidden" id="boardId" name="boardId" value="<?php echo $idx?>">
            <label for="replyId">아이디</label>
            <input type="text" class="form-control" id="replyId" name="replyId" placeholder="name@example.com">
        </div>
        <div class="form-group">
            <label for="replyPassword">비밀번호</label>
            <input type="password" class="form-control" id="replyPassword" name="replyPassword" placeholder="name@example.com" required>
        </div>
        <div class="form-group">
            <label for="replyContent">댓글 작성</label>
            <textarea class="form-control" id="replyContent" name="replyContent" rows="3" required></textarea>
        </div>
        <button type="button" id="btnReplyCreate" class="btn btn-secondary">확인</button>
    </div>



<!--글 수정. -->
<div class="mt-3">
    <button><a href="modify.php?idx=<?php echo $board['idx']?>">글 수정</a></button>
    <button><a href="/">목록으로</a></button>
</div>

<?php

include_once "views/footer/footer.php";

?>