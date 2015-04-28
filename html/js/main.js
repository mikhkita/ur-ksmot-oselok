$(document).ready(function(){	
	$(".fancy-img").fancybox({
        padding : 0
    });
    $(".images ul li").click(function(){
        $("#bg-img").css("background-image",$(this).css("background-image"));
        $("#bg-img a").attr("href",$(this).find("a").attr("href"));
        return false;
    });

});