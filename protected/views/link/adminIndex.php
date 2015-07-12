<h1><?=$this->adminMenu["cur"]->name?></h1>
<?php $form=$this->beginWidget('CActiveForm', array(
	'enableAjaxValidation'=>false,
	'id' => "link"
)); ?>
	<textarea class="link" name="link"></textarea>
	<input type="submit" class="b-butt" value="Получить изображения">
	
<?php $this->endWidget(); ?>
	<script>
		$("#link").submit(function(){
			var str=$("textarea[name=link]").serialize();
			str = str.substr(5);
			str = decodeURIComponent(str);
			var arr = str.split('\n');
	        linkajax(0,arr);
        	return false;
        });
        function linkajax(i,arr) {
        	if(arr[i].indexOf("https")+1) {
	        	$.ajax({
	                type: 'POST',
	                url: "/admin/link",
	                data: {link: arr[i]},
	                success: function(msg){
	                	if(msg=="1") {
	                		console.log("Изображения по "+(i+1)+" ссылке скопированы");
	                	}   
	                },
	                complete: function() {
	                	if(arr[i+1]) {
	                		i++;
	                		linkajax(i,arr);
	                	}
	                } 
	            });
	        } else if(arr[i+1]) {
        		i++;
        		linkajax(i,arr);
        	}
        }
	</script>

