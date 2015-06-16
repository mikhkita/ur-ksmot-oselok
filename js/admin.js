var customHandlers = [];
$(document).ready(function(){   
    var myWidth,
        myHeight,
        title = window.location.href,
        titleVar = ( title.split("localhost").length > 1 )?4:3,
        progress = new KitProgress("#FFF",2);

    progress.endDuration = 0.3;

    title = title.split(/[\/#?]+/);
    title = title[titleVar];


    $(".modules li[data-name='"+title+"'],.modules li[data-nameAlt='"+title+"']").addClass("active");    

    function whenResize(){
        if( typeof( window.innerWidth ) == 'number' ) {
            myWidth = window.innerWidth;
            myHeight = window.innerHeight;
        } else if( document.documentElement && ( document.documentElement.clientWidth || 
        document.documentElement.clientHeight ) ) {
            myWidth = document.documentElement.clientWidth;
            myHeight = document.documentElement.clientHeight;
        } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
            myWidth = document.body.clientWidth;
            myHeight = document.body.clientHeight;
        }
        $("body,html").css("height",myHeight);
        $(".main").css("height",myHeight-50);
    }
    $(window).resize(whenResize);
    whenResize();

    $(".ajax-update,.ajax-create").fancybox({
        type: "ajax",
        helpers: {
            overlay: {
                locked: true 
            },
            title : null
        },
        padding: 0,
        margin: 30,
        beforeShow: function(){
            var $form = $(".fancybox-inner form");
            bindForm($form);
            bindImageUploader();
            bindTinymce();
            bindAutocomplete();
            bindTooltip();
            bindDoubleList();
            if( $form.attr("data-beforeShow") && customHandlers[$form.attr("data-beforeShow")] ){
                customHandlers[$form.attr("data-beforeShow")]($form);
            }
        },
        afterClose:function(){
            unbindTinymce();
        },
        afterShow: function(){
            bindVariants();
            $(".fancybox-inner").find("input").eq(0).focus();
        }
    });

    $(document).on("click",".ajax-delete", function(){
        var warning = ($(this).attr("data-warning"))?$(this).attr("data-warning"):"Вы действительно хотите удалить</br>запись?";
        warning += ( $(this).parents(".b-table").attr("data-warning") )?"<br><b>"+$(this).parents(".b-table").attr("data-warning")+"</b>":"";
        $.fancybox.open({
            padding: 0,
            content: '<div class="b-popup b-popup-delete"><h1>'+warning+'</h1><div class="row buttons"><input type="button" class="b-delete-yes" value="Да"><input type="button" onclick="$.fancybox.close();" value="Нет"></div></div>'
        });
        bindDelete($(this).attr("href"));
        return false;
    });

    function setResult(html){
        $(".b-main-center").html(html);

        setTimeout(function(){
            bindFilter();
            bindTooltip();
            bindAutocomplete();
        },100);
    }

    function bindDelete(url){
        $(document).unbind("keypress");
        $(document).bind("keypress",function( event ) {
            if ( event.which == 13 ) {
                $(".fancybox-inner .b-delete-yes").click();
            }
        });
        $(".fancybox-inner .b-delete-yes").click(function(){

            progress.setColor("#FFF");
            progress.start(3);

            url = ( $(".main form").length ) ? (url+"&"+$(".main form").serialize()) : url;

            $.ajax({
                url: url,
                success: function(msg){
                    progress.end(function(){
                        setResult(msg);
                    });
                    $.fancybox.close();
                }
            });    
        });
    }

    function bindFilter(){
        if( $(".main .b-filter").length ){
            $(".main form select, .main form input").bind("change",function(){
                var $form = $(this).parents("form");

                progress.setColor("#D26A44");
                progress.start(3);

                $.ajax({
                    url: "?partial=true&"+$form.serialize(),
                    success: function(msg){
                        progress.end(function(){
                            setResult(msg);
                            history.pushState(null, null, '?'+$form.serialize());
                        });
                    }
                });    
            });
            $(".main form").submit(function(){
                return false;
            });
            $(".b-clear-filter").click(function(){
                $(".main form select,.main form input").val("");
                $(".main form select,.main form input").eq(0).trigger("change");
                return false;
            });
        }
    }

    function bindForm($form){
        $form.validate({
            ignore: ""
        });

        $(".numeric").numericInput({ allowFloat: true, allowNegative: true });

        $form.submit(function(e,a){
            tinymce.triggerSave();
            if( $(this).valid() && !$(this).find("input[type=submit]").hasClass("blocked") ){
                var $form = $(this),
                    url = $form.attr("action");

                $(this).find("input[type=submit]").addClass("blocked");

                if( a == false ){
                    $form.find("input[type='text'],input[type='number'],textarea").val("");
                    $form.find("input").eq(0).focus();
                }

                progress.setColor("#FFF");
                progress.start(3);

                url = ( $(".main form").length ) ? (url+( (url.split("?").length>1)?"&":"?" )+$(".main form").serialize()) : url;

                if( $form.attr("data-beforeAjax") && customHandlers[$form.attr("data-beforeAjax")] ){
                    customHandlers[$form.attr("data-beforeAjax")]($form);
                }

                $.ajax({
                    type: $form.attr("method"),
                    url: url,
                    data: $form.serialize(),
                    success: function(msg){
                        progress.end(function(){
                            $form.find("input[type=submit]").removeClass("blocked");
                            setResult(msg);
                        });
                        if( a != false ){
                            $.fancybox.close();
                        }
                    }
                });
            }else{
                $(".fancybox-overlay").animate({
                    scrollTop : 0
                },200);
            }
            return false;
        });

        // $(".b-input-image").change(function(){
        //     if( $(this).val() != "" ){
        //         $(".b-input-image-add").addClass("hidden");
        //         $(".b-image-wrap").removeClass("hidden");
        //         $(".b-input-image-img").css("background-image","url('"+$(".b-input-image-img").attr("data-base")+"/"+$(this).val()+"')");
        //     }else{
        //         $(".b-input-image-add").removeClass("hidden");
        //         $(".b-image-wrap").addClass("hidden");
        //     }
        // });

        // // Удаление изображения
        // $(".b-image-delete").click(function(){
        //     $(".b-image-cancel").attr("data-url",$(".b-input-image").val())// Сохраняем предыдущее изображение для того, чтобы можно было восстановить
        //                         .show();// Показываем кнопку отмены удаления
        //     $(".b-input-image").val("").trigger("change");// Удаляем ссылку на фотку из поля
        // });

        // // Отмена удаления
        // $(".b-image-cancel").click(function(){
        //     $(".b-input-image").val($(".b-image-cancel").attr("data-url")).trigger("change")// Возвращаем сохраненную ссылку на изображение в поле
        //     $(".b-image-cancel").hide(); // Прячем кнопку отмены удаления                                 
        // });

    }

    function bindImageUploader(){
        $(".b-get-image").click(function(){
            $(".b-for-image-form").load($(".b-get-image").attr("data-path"), {}, function(){
                $(".upload").addClass("upload-show");
                $(".b-upload-overlay").addClass("b-upload-overlay-show")
                $(".plupload_cancel,.b-upload-overlay,.plupload_save").click(function(){
                    $(".b-upload-overlay").removeClass("b-upload-overlay-show");
                    $(".upload").addClass("upload-hide");
                    setTimeout(function(){
                        $(".b-for-image-form").html("");
                    },400);
                    return false;
                });
                $(".plupload_save").click(function(){
                    $(".b-input-image").val($(".b-input-image-img").attr("data-path")+"/"+$("input[name='uploaderPj_0_tmpname']").val()).trigger("change");
                });
            });
        });
    }

    /* TinyMCE ------------------------------------- TinyMCE */
    function bindTinymce(){
        if( $("#tinymce").length ){
            tinymce.init({
                selector : "#tinymce",
                width: '700px',
                height: '500px',
                language: 'ru',
                plugins: 'image table autolink emoticons textcolor charmap directionality colorpicker media contextmenu link textcolor responsivefilemanager',
                skin: 'kit-mini',
                toolbar: 'undo redo bold italic forecolor alignleft aligncenter alignright alignjustify bullist numlist outdent indent link image',
                onchange_callback: function(editor) {
                    tinymce.triggerSave();
                    $("#" + editor.id).valid();
                },
                image_advtab: true ,
                external_filemanager_path:"/filemanager/",
                filemanager_title:"Файловый менеджер" ,
                external_plugins: { "filemanager" : "/filemanager/plugin.min.js"}
            });
        }
    }

    function unbindTinymce(){
        tinymce.remove();
    }
    /* TinyMCE ------------------------------------- TinyMCE */

    /* Preloader ----------------------------------- Preloader */
    function setPreloader(el){
        var str = '<div class="circle-cont">';
        for( var i = 1 ; i <= 3 ; i++ ) str += '<div class="c-el c-el-'+i+'"></div>';
        el.append(str+'</div>').addClass("blocked");
    }

    function removePreloader(el){
        el.removeClass("blocked").find(".circle-cont").remove();
    }
    /* Preloader ----------------------------------- Preloader */

    /* Hot keys ------------------------------------ Hot keys */
    if( $(".ajax-create").length ){
        var cmddown = false,
            ctrldown = false;
        function down(e){
            if( e.keyCode == 13 && ( cmddown || ctrldown ) ){
                if( !$(".b-popup form").length ){
                    $(".ajax-create").click();
                }else{
                    $(".fancybox-wrap form").trigger("submit",[false]);
                }
            }
            if( e.keyCode == 13 ){
                enterVariantsHandler();
            }
            if( e.keyCode == 91 ) cmddown = true;
            if( e.keyCode == 17 ) ctrldown = true;
            if( e.keyCode == 27 && $(".fancybox-wrap").length ) $.fancybox.close();
        }
        function up(e){
            if( e.keyCode == 91 ) cmddown = false;
            if( e.keyCode == 17 ) ctrldown = false;
        }
        $(document).keydown(down);
        $(document).keyup(up);
    }
    /* Hot keys ------------------------------------ Hot keys */

    /* Autocomplete -------------------------------- Autocomplete */
    function bindAutocomplete(){
        if( $(".autocomplete").length ){
            var i = 0;
            $(".autocomplete").each(function(){
                i++;
                $(this).wrap("<div class='autocomplete-cont'></div>");
                var $this = $(this),
                    data = JSON.parse($this.attr("data-values"));
                $this.removeAttr("data-values");

                var $cont = $this.parent("div"),
                    $clone = $this.clone(),
                    $label = $this.clone();

                $clone.removeAttr("required")
                      .attr("name","clone-"+i)
                      .attr("class","clone");
                $label.removeAttr("required")
                      .attr("name","label-"+i)
                      .attr("class","label")
                      .val($this.attr("data-label"))
                      .attr("readonly","readonly");
                $this.attr("type","hidden").removeClass("autocomplete");
                $cont.prepend($clone);
                $cont.prepend($label);

                if( $this.hasClass("categories") ){
                    $clone.catcomplete({
                        minLength: 0,
                        delay: 0,
                        source: data,
                        appendTo: $cont,
                        select: function( event, ui ) {
                            $clone.val(ui.item.label);
                            $label.show().val(ui.item.label);
                            $this.val(ui.item.val).trigger("change");
                            return false;
                        },
                        focus: function( event, ui ) {
                            // $(".ui-menu-item").each(function(){
                            //     alert($(this).attr("class"));
                            // });
                        }
                    });    
                }else{
                    $clone.autocomplete({
                        minLength: 0,
                        delay: 0,
                        source: data,
                        appendTo: $cont,
                        select: function( event, ui ) {
                            $clone.val(ui.item.label);
                            $label.show().val(ui.item.label);
                            $this.val(ui.item.val).trigger("change");
                            return false;
                        }
                    });
                }
                
                $clone.blur(function(){
                    $label.show();
                });

                $label.on("click focus",function(){
                    $label.hide();
                    $clone.val("").select();
                    if( $this.hasClass("categories") ){
                        $clone.catcomplete('search');
                    }else{
                        $clone.autocomplete('search');
                    }
                });
            });
        }
    }

    $.widget( "custom.catcomplete", $.ui.autocomplete, {
        _create: function() {
            this._super();
            this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
        },
        _renderMenu: function( ul, items ) {
            var that = this,
                currentCategory = "";
            $.each( items, function( index, item ) {
                var li;
                if ( item.category != currentCategory ) {
                    ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
                    currentCategory = item.category;
                }
                li = that._renderItemData( ul, item );
                if ( item.category ) {
                    li.attr( "aria-label", item.category + " : " + item.label );
                }
            });
        }
    });
    /* Autocomplete -------------------------------- Autocomplete */

    /* Tooltip ------------------------------------- Tooltip */
    function bindTooltip(){
        bindTooltipSkin(".b-tooltip, .b-panel-icons-item a,.b-tool, .b-image-nav, .b-help, .b-title","qtip-light");
    }
    function bindTooltipSkin(selector,skin){
        $(selector).qtip('destroy', true);
        $(selector).qtip({
            position: {
                my: 'bottom center',
                at: 'top center'
            },
            style: {
                classes: skin+' qtip-shadow qtip-rounded'
            },
            show: {
                delay: 500
            }
        });
    }
    /* Tooltip ------------------------------------- Tooltip */

    /* Double-list --------------------------------- Double-list */
    function bindDoubleList(){
        if( $(".double-list").length ){
            $("#sortable1").sortable({
                connectWith: ".connectedSortable",
                update: function( event, ui ) {
                    customHandlers["sortList"]();
                }
            }).disableSelection();
            $("#sortable2").sortable({
                update: function( event, ui ) {
                    $("#sortable2 span").remove();
                    $("#sortable2 li").append("<span></span>");
                }
            }).disableSelection();
            customHandlers["sortList"]();
        }
    }
    $("body").on("click",".double-list li span",function(){
        $("#sortable1").prepend($(this).parents("li"));
        customHandlers["sortList"]();
    });

    customHandlers["attributesAjax"] = function($form){
        $("#sortable1 input").remove();
    }

    customHandlers["sortList"] = function(){
        var min = "&";
        $("#sortable1 li").each(function(){
            var max = "№";
            $("#sortable1 li").each(function(){
                var curId = $(this).attr("data-id");
                if(curId < max && curId > min){
                    max = curId;
                }
            });
            min = max;
            $("#sortable1").append($("#sortable1 li[data-id='"+min+"']"));
        });
    }
    /* Double-list --------------------------------- Double-list */

    /* Variants ------------------------------------ Variants */
    $("body").on("click","#add-variant",function(){
        $(".b-variant-cont .error").addClass("hidden");
        if( !$("#new-variant").hasClass("hidden") ){
            // Если вводили в инпут
            var val = $("#new-variant").val();
            if( !tryToAddVariant(val) ){
                $(".b-variant-cont .error-single").removeClass("hidden");
            }
        }else{
            // Если вводили в инпут textarea
            var val = $("#new-variant-list").val(),
                tmpArr = val.split("\n"),
                tmpError = new Array();
            for( var i in tmpArr ){
                if( !tryToAddVariant(tmpArr[i]) && tmpArr[i] != "" ){
                    tmpError.push(tmpArr[i]);
                }
            }
            if( tmpError.length ){
                $(".b-variant-cont .error-list").removeClass("hidden");
            }
            $("#new-variant-list").val(tmpError.join("\n"));
        }

        $((!$("#new-variant").hasClass("hidden"))?"#new-variant":"#new-variant-list").focus();
        updateVariantsSort();
        $.fancybox.update();
    });

    $("body").on("click","#b-variants li span",function(){
        if( confirm("Если удалить этот вариант, то во всех товарах, где был выбран именно этот вариант будет пустое значение атрибута. Подтвердить удаление?") ){
            $(this).parents("li").remove();
            updateVariantsSort();
            $.fancybox.update();
        }
    });

    $("body").on("click",".b-variant-cont .b-set-list",function(){
        $("#new-variant-list, .b-variant-cont .b-set-single").show();
        $("#new-variant, .b-variant-cont .b-set-list").hide().addClass("hidden");
        $("#new-variant-list").focus();
        $.fancybox.update();
    });

    $("body").on("click",".b-variant-cont .b-set-single",function(){
        $("#new-variant-list, .b-variant-cont .b-set-single").hide();
        $("#new-variant, .b-variant-cont .b-set-list").show().removeClass("hidden");
        $("#new-variant").focus();
        $.fancybox.update();
    });

    function tryToAddVariant(val){
        val = regexVariant(val);
        if( val != "" ){
            if( !$("input[data-name='"+val.toLowerCase()+"']").length ){
                $("#b-variants ul").append("<li><p>"+val+"</p><span></span><input data-name=\""+val.toLowerCase()+"\" type=\"hidden\" name=\"VariantsNew["+val+"]\" value=\"\"></li>");
                $("#new-variant").val("");
                return true;
            }
        }
        return false;
    }

    function regexVariant(val){
        var regArr;
        switch( $("#new-variant").attr("data-type") ) {
            case "float":
                regArr = /^[^\d-]*(-{0,1}\d+\.{0,1}\d+)[\D]*$/.exec(val);

                break;
            case "int":
                regArr = /^[^\d-]*(-{0,1}\d+)[\D]*$/.exec(val);

                break;
            default:
                regArr = ["",val];
                break;
        }
        return ( regArr != null )?regArr[1]:"";
    }

    function updateVariantsSort(){
        var i = 0;
        $("#b-variants ul li").each(function(){
            i+=10;
            $(this).find("input").val(i);
        });
    }
    function enterVariantsHandler(){
        if( !$(".b-variant-cont input[type='text']").hasClass("hidden") ){
            $("#add-variant").click();
        }
    }
    function bindVariants(){
        if( $("#b-variants").length ){
            $("#b-variants .sortable").sortable({
                update: function( event, ui ) {
                    updateVariantsSort();
                }
            }).disableSelection();

            switch( $("#new-variant").attr("data-type") ) {
                case "float":
                    $("#new-variant").numericInput({ allowFloat: true, allowNegative: true });

                    break;
                case "int":
                    $("#new-variant").numericInput({ allowFloat: false, allowNegative: true });

                    break;
            }
        }
    }
    /* Variants ------------------------------------ Variants */

    function transition(el,dur){
        el.css({
            "-webkit-transition":  "all "+dur+"s ease-in-out", "-moz-transition":  "all "+dur+"s ease-in-out", "-o-transition":  "all "+dur+"s ease-in-out", "transition":  "all "+dur+"s ease-in-out"
        });
    }

    bindFilter();
    bindAutocomplete();
    bindTooltip();
    bindImageUploader();
});