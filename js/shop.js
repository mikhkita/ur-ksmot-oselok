$(document).ready(function(){	

	$( "#slider-range" ).slider({
		range: true,
		min: 1000,
		max: 50000,
		values: [ 1000, 36000 ],
		slide: function( event, ui ) {
			$( "#amount-l" ).text( ui.values[ 0 ] );
			$( "#amount-r" ).text( ui.values[ 1 ] );
		}
	});
	$( "#amount-l" ).text( $( "#slider-range" ).slider( "values", 0 ) );
	$( "#amount-r" ).text( $( "#slider-range" ).slider( "values", 1 ) );

	$(".fancy-img").fancybox({
        padding : 0
    });
    $(".images ul li").click(function(){
        $("#bg-img").css("background-image",$(this).css("background-image"));
        $("#bg-img a").attr("href",$(this).find("a").attr("href"));
        return false;
    });

 	$(".b-main-items").on("click","#yw0 li a", function(){
 		if(!$(this).parent().hasClass("hidden") || !$(this).parent().hasClass("selected"))  {
 			$('.b-main-items').load($(this).attr("href")+' .pagination');  
 	    }
 		return false;
 	});
    $( document ) .ajaxComplete(function(){
        if( $("#yw0 .selected a").text()*1==4 ) {
            $("#yw0 .first").show();
        }
        if( $("#yw0 .selected a").text()*1>4 ) {
            $("#yw0 .first").show();
            $("<li class='points'>...</li>").insertAfter("#yw0 .first");
        }
        if( ($("#yw0 .last a").text()*1-$("#yw0 li.page").last().find("a").text()*1)==1 ) {
            $("#yw0 .last").show();
        }
        if( ($("#yw0 .last a").text()*1-$("#yw0 li.page").last().find("a").text()*1)>1 ) {
            $("#yw0 .last").show();
            $("<li class='points'>...</li>").insertBefore("#yw0 .last");
        }
    });

     if( ($("#yw0 .last a").text()*1-$("#yw0 li.page").last().find("a").text()*1)==1 ) {
            $("#yw0 .last").show();
        }
        if( ($("#yw0 .last a").text()*1-$("#yw0 li.page").last().find("a").text()*1)>1 ) {
            $("#yw0 .last").show();
            $("<li class='points'>...</li>").insertBefore("#yw0 .last");
        }

 	
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