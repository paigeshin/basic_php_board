$(document).ready(() => {

    //현재 ajax가 제대로 작동되지 않아서 그냥 php로 작성.

    let boardId = $("#boardId").val();

    //댓글 작성
    $("#btnReplyCreate").on("click", () => {
        let replyId = $("#replyId").val();
        let replyPassword = $("#replyPassword").val();
        let replyContent = $("#replyContent").val();
        $.ajax({
            url: "http://localhost/handler/reply/reply_ok.php",
            type: "POST",
            data: {
                boardId: boardId,
                replyId: replyId,
                replyPassword: replyPassword,
                replyContent: replyContent
            },
            success: (data) => {
                location.reload(() => {
                    $("#btnShowReply").click();
                });
            }
        });
    });


});