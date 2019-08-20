<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/db.php";
?>

<!doctype html>

<html>
<head>
    <meta charset="UTF-8">
    <title>게시판</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">

</head>
<body>
    <div id="board_area">
        <h1>자유게시판</h1>
        <h4>자유롭게 글을 쓸 수 있는 게시판입니다.</h4>
            <table class="list-table">
                <thead>
                    <tr>
                        <th width="70">번호</th>
                        <th width="500">제목</th>
                        <th width="120">글쓴이</th>
                        <th width="100">작성일</th>
                        <th width="100">조회수</th>
                    </tr>
                </thead>
    <?php
            /*
            페이징 로직 짜기 전 정리
            - GET을 통해 page 값을 받는다.
            - 전체 게시판 수를 구한다. (관련 함수, mysqli_num_rows)
            - 페이지마다 출력할 게시판 숫자를 정한다.
            - 전체 블록 수를 구한다. (관련 함수, ceil)
            - 위의 값들을 활용하여 page값과 연관하여 LIMIT `starting_page` `board_to_be_shown`
            */

            if(isset($_GET['page'])){
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $sql = mq("SELECT * FROM board");
            $row_num = mysqli_num_rows($sql); //게시판의 총 숫자.
            $list = 10; //한 페이지에 보여줄 게시판의 숫자.
            $block_ct = 10; //블록당 보여줄 페이지의 개수

            $block_num = ceil($page / $block_ct); //현재 페이지 블록 구하기
            $block_start = (($block_num - 1) * $block_ct) + 1; //블록의 시작번호
            $block_end = $block_start + $block_ct - 1; //블록 마지막 번호

            $total_page = ceil($row_num / $list); //페이징한 페이지 수 구하기.
            if($block_end > $total_page) { $block_end = $total_page; } //만약 블록의 마지막 번호가 페이지수보다 많다면 마지막번호는 페이지 수
            $total_block = ceil($total_page / $block_ct);
            $start_num = ($page - 1) * $list; //시작번호 (page - 1)에서 $list를 곱한다.

            $sql2 = mq("SELECT * FROM board ORDER BY idx DESC LIMIT $start_num, $list");
                while($board = $sql2 -> fetch_array()){
                    $title = $board["title"];
                    //게시글 제목 30자 이상이면, ...로 대체.
                    if(strlen($title) > 30){
                       $title = str_replace($board["title"], mb_substr($board["title"], 0, 30, "utf-8"). "..." , $board["title"]);
                    }
                    //댓글 카운팅
                    $sql3 = mq("SELECT * FROM reply WHERE con_num='".$board['idx']."'");
                    $rep_count = mysqli_num_rows($sql3);
    ?>
            <tbody>
                <tr>
                    <td width="70"><?php echo $board['idx']?></td>
                    <!-- 아래 기본적인 로직 잠긴 글과 아닐때 게시판 번호를 보내는 곳이 다름.-->
                    <td width="500"><?php
                        $lockimg = "<img src='/img/lock.png' alt='lock' title='lock' width='20' height='20' />";
                        if($board['lock_post']=="1")
                        { ?><a href='/page/board/ck_read.php?idx=<?php echo $board["idx"];?>'><?php echo $title, $lockimg;
                            }else{  ?>

                    <!-- 새로써진 글 new 표시하기 -->
                    <?php
                        $boardtime = $board['date'];
                        $timenow = date("Y-m-d");

                        if($boardtime == $timenow){
                            $img = "<img src='/img/new.png' alt='new' title='new'/>";
                        } else {
                            $img = "";
                        }

                    ?>
                            <a href='/page/board/read.php?idx=<?php echo $board["idx"]; ?>'><?php echo $title; }?><span class="re_ct">[<?php echo $rep_count; ?>]<?php echo $img; ?></span> </a></td>
                    <td width="120"><?php echo $board['name']?></td>
                    <td width="100"><?php echo $board['date']?></td>
                    <td width="100"><?php echo $board['hit']?></td>
                </tr>
            </tbody>

    <?php } ?>
        </table>
        <div id="page_num">
            <ul>
                <?php
                if($page <= 1)
                { //만약 page가 1보다 크거나 같다면
                    echo "<li class='fo_re'>처음</li>"; //처음이라는 글자에 빨간색 표시
                }else{
                    echo "<li><a href='?page=1'>처음</a></li>"; //아니라면 처음글자에 1번페이지로 갈 수있게 링크
                }
                if($page <= 1)
                { //만약 page가 1보다 크거나 같다면 빈값

                }else{
                    $pre = $page-1; //pre변수에 page-1을 해준다 만약 현재 페이지가 3인데 이전버튼을 누르면 2번페이지로 갈 수 있게 함
                    echo "<li><a href='?page=$pre'>이전</a></li>"; //이전글자에 pre변수를 링크한다. 이러면 이전버튼을 누를때마다 현재 페이지에서 -1하게 된다.
                }
                for($i=$block_start; $i<=$block_end; $i++){
                    //for문 반복문을 사용하여, 초기값을 블록의 시작번호를 조건으로 블록시작번호가 마지박블록보다 작거나 같을 때까지 $i를 반복시킨다
                    if($page == $i){ //만약 page가 $i와 같다면
                        echo "<li class='fo_re'>[$i]</li>"; //현재 페이지에 해당하는 번호에 굵은 빨간색을 적용한다
                    }else{
                        echo "<li><a href='?page=$i'>[$i]</a></li>"; //아니라면 $i
                    }
                }
                if($block_num >= $total_block){ //만약 현재 블록이 블록 총개수보다 크거나 같다면 빈 값

                }else{
                    $next = $page + 1; //next변수에 page + 1을 해준다.
                    echo "<li><a href='?page=$next'>다음</a></li>"; //다음글자에 next변수를 링크한다. 현재 4페이지에 있다면 +1하여 5페이지로 이동하게 된다.
                }
                if($page >= $total_page){ //만약 page가 페이지수보다 크거나 같다면
                    echo "<li class='fo_re'>마지막</li>"; //마지막 글자에 긁은 빨간색을 적용한다.
                }else{
                    echo "<li><a href='?page=$total_page'>마지막</a></li>"; //아니라면 마지막글자에 total_page를 링크한다.
                }
                ?>
            </ul>
        </div>

        <div id="write_btn">
            <a href="/page/board/write.php"><button>글쓰기</button></a>
        </div>

        <div id="search_box">
            <form action="/page/board/search_result.php" method="GET">
                <select name="catgo">
                    <option value="title">제목</option>
                    <option value="name">글쓴이</option>
                    <option value="content">내용</option>
                </select>
                <input type="text" name="search" size="40" required> <button>검색</button>
            </form>
        </div>

    </div>
</body>
</html>