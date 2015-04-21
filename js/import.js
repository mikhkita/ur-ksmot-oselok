$(document).ready(function(){
    var progress = new KitProgress("#D26A44",2);
    progress.endDuration = 0.3;

	$("input[name='GoodTypeId']").eq(0).attr("checked","checked");
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
                            $(".b-main-center").html(msg);
                            $("#imp-sort").sortable({
                                create: function( event, ui ) {
                                    for (var i = 0; i < $("#attr-list li").length; i++) {
                                        $("#imp-sort li:eq("+i+") input").val($("#attr-list li").eq(i).attr("data-id"));
                                    };
                                },
                                update: function( event, ui ) {
                                    for (var i = 0; i < $("#attr-list li").length; i++) {
                                        $("#imp-sort li:eq("+i+") input").val($("#attr-list li").eq(i).attr("data-id"));
                                    };
                                    for (var j = $("#attr-list li").length; j < $("#imp-sort li").length; j++) {
                                        $("#imp-sort li:eq("+j+") input").val("no-id");
                                    }
                                }
                            }).disableSelection();
                        });
                    }
                });
            }
            return false;
        });
        $(".b-main-center").on("submit","#import-step2",function(e,a){
            if( $(this).valid() && !$(this).find("input[type=submit]").hasClass("blocked") ){
                var $form = $(this),
                    url = $("#import-step2").attr("action");

                $(this).find("input[type=submit]").addClass("blocked");

                // if( a == false ){
                //     $form.find("input[type='text'],input[type='number'],textarea").val("");
                //     $form.find("input").eq(0).focus();
                // }
                
                progress.start(3);

                // url = ( $(".main form").length ) ? (url+( (url.split("?").length>1)?"&":"?" )+$(".main form").serialize()) : url;

                // if( $form.attr("data-beforeAjax") && customHandlers[$form.attr("data-beforeAjax")] ){
                //     customHandlers[$form.attr("data-beforeAjax")]($form);
                // }

                $.ajax({
                    type: $("#import-step2").attr("method"),
                    url: url,
                    data: $("#import-step2").serialize(),
                    success: function(msg){
                        progress.end(function(){
                            $(".b-main-center").html(msg);
                            
                        });
                    }
                });
            }
            return false;
        });

});