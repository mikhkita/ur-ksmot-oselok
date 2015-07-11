$(document).ready(function(){	
    // var progress = new KitProgress("#FFF",2);
    var price_min_def = $( "#price_min" ).val()*1,
    price_max_def = $( "#price_max" ).val()*1,
    price_max = price_max_def*0.7,price_min=price_min_def,type,filter=0;
    if(location.search!='') {
        var price = decodeURIComponent(location.search.substr(1)).split('&');
        $.each( price, function( key, value ) {
            if(value.indexOf('price-min') + 1) price_min = value.split('=').pop()*1;
            if(value.indexOf('price-max') + 1) price_max = value.split('=').pop()*1;
            if(value.indexOf('type') + 1) type = value.split('=').pop()*1;
        });
        
    }
	$( "#slider-range" ).slider({
		range: true,
		min: price_min_def,
		max: price_max_def,
		values: [ price_min, price_max ],
		slide: function( event, ui ) {
			$( "#amount-l" ).text( ui.values[ 0 ] );
			$( "#amount-r" ).text( ui.values[ 1 ] );
            $( "#price-min" ).val( ui.values[ 0 ] );
            $( "#price-max" ).val( ui.values[ 1 ] );
            $("#filter-search").remove();
            setTo($(this));
		},
    change: function( event, ui ) {
        filter++;
         setTimeout(function() {
           filter--;
        }, 900);
        setTimeout(function() {
            showCount(filter);
        }, 1000);
    }
	});
	$( "#amount-l" ).text( $( "#slider-range" ).slider( "values", 0 ) );
	$( "#amount-r" ).text( $( "#slider-range" ).slider( "values", 1 ) );
    $( "#price-min" ).val( $( "#slider-range" ).slider( "values", 0 ) );
    $( "#price-max" ).val( $( "#slider-range" ).slider( "values", 1 ) );

	$(".fancy-img").fancybox({
        padding : 0
    });
    $("body").on("click",".fancy-img-thumb", function(){
        $("#bg-img").css("background-image",$(this).parents("li").css("background-image"));
        $("#bg-img a").attr("href",$(this).attr("href"));
        return false;
    });

    $(".fancy-img-big").click(function(){
        // alert($(".fancy-img[href='"+$(this).attr("href")+"']").attr("href"));
        $(".fancy-img[href='"+$(this).attr("href")+"']").click();
        return false;
    });

    $("#filter label").click(function(){
        filter++;
        $("#filter-search").remove();
        setTo($(this));
        setTimeout(function() {
           filter--;
        }, 900);
        setTimeout(function() {
            showCount(filter);
        }, 1000);
        
    });

    function setTo(el){
        el.closest(".filter-cont").append('<div id="filter-search" class="filter-search"><input type="submit" value="Показать"><img src="/i/294.GIF"></div>');  
    }

    $("#go-back").click(function(){
        window.history.back();
    });
    function showCount() {
        if(filter==0) {
            $.ajax({
                type: 'GET',
                url: "/shop/index?countGood=true",
                data: $("#filter").serialize(),
                success: function(msg){
                    $("#filter-search img").hide();
                    $("#filter-search").append("<span>Товаров: "+msg+"</span>")
                }
            }); 
        }
    }
 	// $(".b-main-items").on("click","#yw0 li a", function(){
  //       progress.setColor("#D26A44");
  //       progress.start(3);
  //       $.ajax({
  //           type: 'GET',
  //           url: $(this).attr("href")+"&partial=true",
  //           // data: $("#filter").serialize(),
  //           success: function(msg){
  //               progress.end(function(){
  //                   $('.b-main-items').html(msg);
  //                   if( $("#yw0 .selected a").text()*1>3 ) {
  //                       $("#yw0 .first").show();
  //                   }
  //                   if( ($("#yw0 li.page").eq(0).find("a").text()*1)>2 ) {
  //                       $("#yw0 .first").show();
  //                       $("<li class='first-points'>...</li>").insertAfter("#yw0 .first");
  //                   }
  //                   if( ($("#yw0 .last a").text()*1-$("#yw0 li.page").last().find("a").text()*1)==1 ) {
  //                       $("#yw0 .last").show();
  //                   }
  //                   if( ($("#yw0 .last a").text()*1-$("#yw0 li.page").last().find("a").text()*1)>1 ) {
  //                       $("#yw0 .last").show();
  //                       $("<li class='last-points'>...</li>").insertBefore("#yw0 .last");
  //                   }
  //               });
  //           }
  //       }); 
 	// 	return false;
 	// });
    
    if( $("#yw0 .selected a").text()*1>3 && $("#yw0 li.page").eq(0).find("a").text()*1>1 ) {
        $("#yw0 .first").show();
    }
    if( ($("#yw0 li.page").eq(0).find("a").text()*1)>2 ) {
        $("#yw0 .first").show();
        $("<li class='first-points'>...</li>").insertAfter("#yw0 .first");
    }
    if( ($("#yw0 .last a").text()*1-$("#yw0 li.page").last().find("a").text()*1)==1 ) {
        $("#yw0 .last").show();
    }
    if( ($("#yw0 .last a").text()*1-$("#yw0 li.page").last().find("a").text()*1)>1 ) {
        $("#yw0 .last").show();
        $("<li class='last-points'>...</li>").insertBefore("#yw0 .last");
    }
    // if( ($("#yw0 .last a").text()*1-$("#yw0 li.page").last().find("a").text()*1)==1 ) {
    //     $("#yw0 .last").show();
    // }
    // if( ($("#yw0 .last a").text()*1-$("#yw0 li.page").last().find("a").text()*1)>1 ) {
    //     $("#yw0 .last").show();
    //     $("<li class='last-points'>...</li>").insertBefore("#yw0 .last");
    // }

    // $("body").on("click",".good", function(){
    //     progress.setColor("#D26A44");
    //     progress.start(3);
    //     var id = $(this).attr("data-id");
    //     $.ajax({
    //         type: 'GET',
    //         url: "/shop/detail?partial=id="+id,
    //         success: function(msg){
    //             progress.end(function(){
    //                 $('.b-content').html(msg);
    //                 history.pushState(null, null, '?id='+id);
    //             });        
    //         }
    //     });  
    // });

    // $("#filter").submit(function(){
    //     progress.setColor("#D26A44");
    //     progress.start(3);
    //     $.ajax({
    //         type: 'GET',
    //         url: "/shop/filter?partial=true",
    //         data: $("#filter").serialize(),
    //         success: function(msg){
    //             progress.end(function(){
    //                 $('.b-main-items').html(msg);
    //                 if( $("#yw0 .selected a").text()*1==4 ) {
    //                     $("#yw0 .first").show();
    //                 }
    //                 if( $("#yw0 .selected a").text()*1>4 ) {
    //                     $("#yw0 .first").show();
    //                     if(!$(".first-points").length) $("<li class='first-points'>...</li>").insertAfter("#yw0 .first");
    //                 }
    //                 if( ($("#yw0 .last a").text()*1-$("#yw0 li.page").last().find("a").text()*1)==1 ) {
    //                     $("#yw0 .last").show();
    //                 }
    //                 if( ($("#yw0 .last a").text()*1-$("#yw0 li.page").last().find("a").text()*1)>1 ) {
    //                     $("#yw0 .last").show();
    //                     if(!$(".last-points").length) $("<li class='last-points'>...</li>").insertBefore("#yw0 .last");
    //                 }
    //                 history.pushState(null, null, '?'+$("#filter").serialize());
    //             });        
    //         }
    //     });
    //     return false;  
    // });
 	
 	// var progress = new KitProgress("#D26A44",2);
  //   progress.endDuration = 0.3;

 	// $(".b-main-center").on("submit","#import-step2",function(e,a){
  //           if( $(this).valid() && !$(this).find("input[type=submit]").hasClass("blocked") ){
  //               var $form = $(this),
  //                   url = $("#import-step2").attr("action");

  //               $(this).find("input[type=submit]").addClass("blocked");
                
  //               progress.start(3);

  //               $.ajax({
  //                   type: $("#import-step2").attr("method"),
  //                   url: url,
  //                   data: $("#import-step2").serialize(),
  //                   success: function(msg){
  //                       progress.end(function(){
  //                           $(".b-main-center").html(msg);
                            
  //                       });
  //                   }
  //               });
  //           }
  //           return false;
  //       });
});