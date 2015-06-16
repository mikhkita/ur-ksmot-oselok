$(document).ready(function(){
    
    // Бинд на открытие окна редактирования или создания шаблона для экспорта
    customHandlers["exportBeforeShow"] = function($form){
        $("#export-good-type-id").change(function(){
            $("#sortable1,#sortable2").html("");
            $("#sortable1").load($form.attr("data-getfieldsurl")+"?goodTypeId="+$(this).val(),function(){
                customHandlers["sortList"]();
            });
        });
    }

    // $(".b-export-preview tr td").hover(function(){
    // 	var divHeight = $(this).find("div").height(),
    // 		pHeight = $(this).find("p").height();
    // 	if( divHeight < pHeight ){
    // 		$(this).append("<div class='b-view-more'>"+$(this).find("p").text()+"</div>");
    // 	}
    // },function(){
    // 	$(this).find(".b-view-more").remove();
    // });

});