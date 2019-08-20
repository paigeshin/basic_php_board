<?php

include_once "db/db.php";
include_once "views/header/header.php"

?>

<h1>자유롭게 글을 쓰는 공간입니다.</h1>
<h4>의견을 표현해주세요.</h4>


<table>
    <thead>
        <tr>
            <th>번호</th>
            <th>제목</th>
            <th>글쓴이</th>
            <th>작성일</th>
            <th>조회</th>
        </tr>
    </thead>

<!-- 나중에 php while문으로 아래 데이터로 글 목록을 차례대로 가져온다.  -->
<?php
/*

페이징 부분 로직

page1, results 1 - 20
page2, results 21 - 40
page3, results 41 - 60

page1, 20 results per page, LIMIT 0,20
page2, 20 results per page, LIMIT 20, 20
page2, 20 results per page, LIMIT 40, 20
page2, 20 results per page, LIMIT 60, 20
page2, 20 results per page, LIMIT 80, 20

starting_limit_number = (page_number - 1) * results_per_page

*/


// 페이지마다 뽑아올 데이터의 양 정의.
$results_per_page = 20; //🔷 페이지마다 뽑아올 데이터 양 정의.

// 데이터를 불러와서 전체 데이터를 세준다.
$sql_num_rows = "SELECT * FROM board";
$result = mysqli_query($connection, $sql_num_rows);
$number_of_results = mysqli_num_rows($result); //🔷 전체 row의 숫자를 세줌.

//전체 페이지 숫자 계산.
$number_of_pages = ceil($number_of_results / $results_per_page); //🔷ceil을 쓰면 2.1이면 3까지 출력.

//현재 어디 page에 있는지 계산.
if(!isset($_GET['page']))
    {
        //초기 화면에선 페이지가 고정적으로 1
        $page = 1;
    }
else
    {
        //나머지는 url parameter로 가져온 값.
        $page = $_GET['page'];
    }

// 가장 처음 page 계산.
$this_page_first_result = ($page - 1) * $results_per_page;//🔷사실상 이게 핵심적인 것.

// LIMIT을 통해서 paging.
$sql_paging = "SELECT * FROM board ORDER BY idx DESC LIMIT " . $this_page_first_result . ',' . $results_per_page;
$query_paging = mysqli_query($connection, $sql_paging);

while($board = mysqli_fetch_array($query_paging)){

    $title = $board['title'];
    if(strlen($title) > 30)
        {
            $title = str_replace($board['title'], mb_substr($board['title'], 0 , 30, "utf-8")."...", $board['title']);
        }

    ?>

    <tbody>
        <tr>
            <td class="col-idx"><?php echo $board['idx'] ?></td>
            <td class="col-title"><a href="show.php?idx=<?php echo $board['idx']?>"><?php echo $title ?></a></td>
            <td class="col-name"><?php echo $board['name'] ?></td>
            <td class="col-date"><?php echo $board['date'] ?></td>
            <td class="col-hit"><?php echo $board['hit'] ?></td>
        </tr>
    </tbody>

<?php } ?>

</table>

<?php

// 페이지 1, 2, 3 나오는 것.
echo '<nav>';
echo '<ul class="pagination justify-content-center mt-3">';
for($page = 1; $page <= $number_of_pages; $page++){
    echo '<li class="page-item"><a class="page-link" href="index.php?page=' . $page . '">' . $page . '</a>' . '</li>';
}
echo '</ul>';
echo '</nav>';

?>

<div>
    <button class="btnWrite"><a href="write.php">글쓰기</a></button>
</div>

<?php

include_once "views/footer/footer.php";

?>