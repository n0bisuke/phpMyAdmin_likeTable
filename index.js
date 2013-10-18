(function(documet){    
    $(document).ready(function(){
    	$("#data-list > tbody > tr > .edit").click(edit_toggle());
        $("h3").click(edit_toggle());
    });

    function edit_toggle(){
        var edit_flag = false;
        return function(){
            if(edit_flag) return;
            var $input = $("<input>").attr("type","text").attr("title","li").val($(this).text());
            $(this).html($input);
            $("input", this).focus().blur(function(){
                save(this);
                $(this).after($(this).val()).unbind().remove();
                edit_flag = false;
            });
            edit_flag = true;
        }
    }
    
    function save(elm){
        //列数を取得し，編集するカラム名を取得する
        var colcount = 4; //指定フィールド数
        var colnum = $("[title='li']").index(elm) % colcount;
        if(colnum == 0)colnum = colcount;
        var edit_col = $("th:eq("+colnum+")").text(); //カラム名を取得する．

        //行数を取得し，編集するidを取得する．
        var rec_num = $('input').index(elm) / 2; //何行目か
        var edit_id = $(".edit-id:eq("+rec_num+")").text(); //行の先頭:idを取得
        //alert(edit_id);
        //変種内容をポスト送信する
        $.post('dbconnect.php',
            {
                'edit_mes': $(elm).val(), //編集内容
                'edit_id': edit_id, //編集するid
                'edit_col': edit_col //編集するフィールド
            },
            function(data){
                //alert(data);
                console.log(data.edit);
                window.location.reload();   //ページをリロード
            }
        );
    }
})(document);