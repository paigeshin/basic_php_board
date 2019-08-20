$(document).ready(function(){

    //댓글 쓰기
   $(".re_bt").on("click", function(){
       let params = $("form").serialize();
       $.ajax({
           type: "POST",
           url: "reply_ok.php?=<?php echo $board['idx']; ?>",
           data: params,
           dataType: 'HTML',
           success: function(data){
               //아래는 곧바로 데이터를 보내서 refresh 없이 뿌려주기 위함.
               $(".reply_view").html(data);
               console.log(data.toString());
               $(".reply_content").val('');
           }
       })
   });

   //아래의 것들은 jquery_ui를 다운받아야 사용할 수 있는 modal 들이다.

    //댓글 수정하기
    $(".dat_edit_bt").on("click", function(){
        //버튼 누르면 가장 가까운 dat_lo에서 dat_edit form을 통해 dialog를 보여줌.
        //dat_edit은 숨겨져 있는 form이다.
      let obj = $(this).closest(".dap_lo").find(".dat_edit");
      obj.dialog({
          modal: true,
          width: 650,
          height: 200,
          title: "댓글 수정"
      })
    });

    //댓글 지우기
    $(".dat_delete_bt").on("click", function(){
        //버튼 누르면 가장 가까운 dat_lo에서 dat_delete form을 통해 dialog를 보여줌.
        //dat_delete은 숨겨져 있는 form이다.
        let obj = $(this).closest(".dap_lo").find(".dat_delete");
        obj.dialog({
            modal: true,
            width: 400,
            title: "댓글 삭제 확인"
        })
    })

});