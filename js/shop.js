$(document).ready(function(){	
    // var progress = new KitProgress("#FFF",2);
    var price_min = 0,
    price_max = 36000;
    if(location.search!='') {
        var price = decodeURIComponent(location.search.substr(1)).split('&');
        $.each( price, function( key, value ) {
            if(value.indexOf('price-min') + 1) price_min = value.split('=').pop();
            if(value.indexOf('price-max') + 1) price_max = value.split('=').pop();
        });
        
    }
	$( "#slider-range" ).slider({
		range: true,
		min: 0,
		max: 50000,
		values: [ price_min, price_max ],
		slide: function( event, ui ) {
			$( "#amount-l" ).text( ui.values[ 0 ] );
			$( "#amount-r" ).text( ui.values[ 1 ] );
            $( "#price-min" ).val( ui.values[ 0 ] );
            $( "#price-max" ).val( ui.values[ 1 ] );
            $("#filter-search").remove();
            $(this).closest(".filter-cont").append('<input type="submit" id="filter-search" value="Поиск">');
		}
	});
	$( "#amount-l" ).text( $( "#slider-range" ).slider( "values", 0 ) );
	$( "#amount-r" ).text( $( "#slider-range" ).slider( "values", 1 ) );
    $( "#price-min" ).val( $( "#slider-range" ).slider( "values", 0 ) );
    $( "#price-max" ).val( $( "#slider-range" ).slider( "values", 1 ) );

	$(".fancy-img").fancybox({
        padding : 0
    });
    $("body").on("click",".images ul li", function(){
        $("#bg-img").css("background-image",$(this).css("background-image"));
        $("#bg-img a").attr("href",$(this).find("a").attr("href"));
        return false;
    });

    $("#filter label").click(function(){
        $("#filter-search").remove();
        $(this).closest(".filter-cont").append('<input type="submit" id="filter-search" value="Поиск">');
    });
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
    
    if( $("#yw0 .selected a").text()*1>3 ) {
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