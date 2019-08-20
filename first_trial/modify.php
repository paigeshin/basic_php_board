<?php

include_once "db/db.php";
include_once "views/header/header.php"

?>

<h1>글수정</h1>

<!--여기서 해당 index를 가져와서 수정할 데이터를 가져옴-->

<?php

$idx = $_GET['idx'];
$sql_statement = "SELECT * FROM board WHERE idx = '".$idx."'";
$query = mysqli_query($connection, $sql_statement);
$board = mysqli_fetch_array($query);

?>

<form id="dynamicForm" action="handler/modify_ok.php?idx=<?php echo $idx ?>" method="POST">
    <div>
        <label for="userId"></label>
        <input type="text" id="userId" name="userId" placeholder="아이디를 입력해주세요." value="<?php echo $board['name'] ?>" required>
        <label for="userPassword"></label>
        <input type="password" id="userPassword" name="userPassword" placeholder="비밀번호를 입력해주세요." required>
    </div>
    <div>
        <label for="userTitle"></label>
        <input type="text" id="userTitle" placeholder="제목을 입력해주세요." name="userTitle" value="<?php echo $board['title']?>" required>
    </div>
    <div>
        <label for="userContent"></label>
        <textarea name="userContent" id="userContent" placeholder="내용을 입력해주세요." cols="30" rows="10" required><?php echo $board['content']?></textarea>
    </div>

    <button type="submit" id="btnModify">글 수정</button>
    <button type="submit" id="btnDelete">글 삭제 </button>
    <button><a href="/">목록으로</a></button>

    <script>
        document.querySelector("#btnModify").addEventListener("click", function(){
            document.querySelector("#dynamicForm").setAttribute("action", "handler/modify_ok.php?idx=<?php echo $idx?>");
        });

        document.querySelector("#btnDelete").addEventListener("click", function(){
            document.querySelector("#dynamicForm").setAttribute("action", "handler/delete_ok.php?idx=<?php echo $idx?>");
        });

    </script>


</form>



<?php

include_once "views/footer/footer.php";

?>