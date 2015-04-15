function getNextField($form){
	var j = 1;
	while( $form.find("input[name="+j+"]").length ){
		j++;
	}
	return j;
}

$(document).ready(function(){	
	var rePhone = /^\+\d \(\d{3}\) \d{3}-\d{2}-\d{2}$/,
		tePhone = '+7 (999) 999-99-99';

	$.validator.addMethod('customPhone', function (value) {
		return rePhone.test(value);
	});

	$(".ajax").parents("form").each(function(){
		$(this).validate({
			rules: {
				email: 'email',
				phone: 'customPhone'
			}
		});
		if( $(this).find("input[name=phone]").length ){
			$(this).find("input[name=phone]").mask(tePhone,{placeholder:" "});
		}
	});

	$(".fancy").each(function(){
		var $popup = $($(this).attr("data-block")),
			$this = $(this);
		$this.fancybox({
			padding : 0,
			content : $popup,
			beforeShow: function(){
				$popup.find(".custom-field").remove();
				if( $this.attr("data-value") ){
					var name = getNextField($popup.find("form"));
					$popup.find("form").append("<input type='hidden' class='custom-field' name='"+name+"' value='"+$this.attr("data-value")+"'/><input type='hidden' class='custom-field' name='"+name+"-name' value='"+$this.attr("data-name")+"'/>");
				}
			}
		});
	});

	$(".b-go").click(function(){
		var block = $( $(this).attr("data-block") ),
			off = $(this).attr("data-offset")||50;
		$("body, html").animate({
			scrollTop : block.offset().top-off
		},800);
		return false;
	});

	$(".fancy-img").fancybox({
		padding : 0
	});

	$(".ajax").parents("form").submit(function(){
  		if( $(this).find("input.error").length == 0 ){
  			var $this = $(this),
  				data = $this.serialize(),
  				$thanks = $($this.attr("data-block"));

  			$.ajax({
			  	type: $(this).attr("method"),
			  	url: $(this).attr("action"),
			  	data: data,
				success: function(msg){
					var $form;
					if( msg == "1" ){
						$form = $thanks;
					}else{
						$form = $("#b-popup-error");
					}

					$this.find("input[type=text],textarea").val("");
					$.fancybox.open({
						content : $form,
						padding : 0
					});	
				}
			});
  		}
  		return false;
  	});
});