<?php

include_once "db/db.php";
include_once "views/header/header.php"

?>

<h1>글쓰기</h1>

<form action="handler/write_ok.php" method="POST">
    <div>
        <label for="userId"></label>
        <input type="text" id="userId" name="userId" placeholder="아이디를 입력해주세요." required>
        <label for="userPassword"></label>
        <input type="password" id="userPassword" name="userPassword" placeholder="비밀번호를 입력해주세요." required>
    </div>
    <div>
        <label for="userTitle"></label>
        <input type="text" id="userTitle" placeholder="제목을 입력해주세요." name="userTitle" required>
    </div>
    <div>
        <label for="userContent"></label>
        <textarea name="userContent" id="userContent" placeholder="내용을 입력해주세요." cols="30" rows="10" required></textarea>
    </div>

    <button type="submit">글쓰기</button>
</form>


<?php

include_once "views/footer/footer.php";

?>