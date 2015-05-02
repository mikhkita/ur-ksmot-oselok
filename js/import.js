$(document).ready(function(){
    var progress = new KitProgress("#D26A44",2);
    progress.endDuration = 0.3;

    // Первый шаг --------------------------------------------------- Первый шаг
    if( $("#import-step1").length ){
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
            }else{
                return false;
            }
        });
    }
    // Первый шаг --------------------------------------------------- Первый шаг

    // Второй шаг --------------------------------------------------- Второй шаг
    function data_set() {
        for (var i = 0; i < $("#attr-list li").length; i++) {
            $("#imp-sort li:eq("+i+") input").val($("#attr-list li").eq(i).attr("data-id"));
        }
    };
    $( "#imp-sort li" ).draggable({ revert: true, revertDuration:false, axis: "y", containment: "parent"});
    $( "#imp-sort li" ).droppable({
        accept: "#imp-sort li",
        create: data_set,
        drop: function( event, ui ) {
            var temp = ui.draggable.html();
            ui.draggable.html($(this).html());
            $(this).html(temp);
            data_set();
        }
    });
    // Второй шаг --------------------------------------------------- Второй шаг

    // Третий шаг --------------------------------------------------- Третий шаг
    if( $(".b-import-preview-table").length ){
        var log = $(".b-log"),
            count,
            ready = 0;
        $(".b-import-butt").click(function(){
            startImport();
            return false;
        });
    }
    function startImport(){
        count = $(".b-import-preview-table tr").length-1,
        showImport();
        while( sendNext() ){}
    }
    function endImport(){
        $(".progress").addClass("ready");
        setLog("Импорт завершен успешно");
    }
    function showImport(){
        $(".b-import").show();
        $(".b-preview").hide();
    }
    function sendNext(){
        if( $(".b-import-preview-table tr").eq(1).length ){
            var $tr = $(".b-import-preview-table tr").eq(1),
                data = $('<form>').append( $tr.clone() ).serialize();

            $.ajax({
                type: "POST",
                url: $(".b-preview").attr("data-url"),
                data: data,
                success: function(msg){
                    ready++;
                    var json = JSON.parse(msg);
                    setLog(json.message);
                    updateProgressBar();
                }
            });

            $tr.remove();
            return true;
        }else{
            return false;
        }
        
    }
    function setLog(string){
        log.prepend("<li>"+string+"</li>")
    }
    function updateProgressBar(){
        var percent = Math.ceil(ready/count*100)+"%";
        $(".progress-bar").css("width",percent).html(percent);
        if( count == ready ){
            endImport();
        }
    }
    // Третий шаг --------------------------------------------------- Третий шаг

});