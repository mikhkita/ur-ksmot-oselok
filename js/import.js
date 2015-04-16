$(document).ready(function(){
	$("input[name='GoodType[id]']").eq(0).attr("checked","checked");
	$(".b-excel-input").change(function(){

		 $('input[type="submit"]').attr('disabled',false);
	});
        $("#import-step1").validate({
            ignore: ""
        });
        $("#import-step1").submit(function(e,a){
            if( $(this).valid() && !$(this).find("input[type=submit]").hasClass("blocked") ){
                var $form = $(this),
                    url = $("#import-step1").attr("action");

                $(this).find("input[type=submit]").addClass("blocked");

                // if( a == false ){
                //     $form.find("input[type='text'],input[type='number'],textarea").val("");
                //     $form.find("input").eq(0).focus();
                // }

                progress.setColor("#FFF");
                progress.start(3);

                // url = ( $(".main form").length ) ? (url+( (url.split("?").length>1)?"&":"?" )+$(".main form").serialize()) : url;

                // if( $form.attr("data-beforeAjax") && customHandlers[$form.attr("data-beforeAjax")] ){
                //     customHandlers[$form.attr("data-beforeAjax")]($form);
                // }

                $.ajax({
                    type: $("#import-step1").attr("method"),
                    url: url,
                    data: $("#import-step1").serialize(),
                    success: function(msg){
                        progress.end(function(){
                        });
                    }
                });
            }
            return false;
        });

});