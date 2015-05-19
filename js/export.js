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

});