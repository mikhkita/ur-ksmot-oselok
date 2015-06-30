<h1><?=$this->adminMenu["cur"]->name?></h1>
<?php $form=$this->beginWidget('CActiveForm', array(
	'enableAjaxValidation'=>false
)); ?>

	<a style="display:block; margin-top:20px;" href="#" data-path="<? echo Yii::app()->createUrl('/uploader/getForm',array('maxFiles'=>10,'extensions'=>'jpg,png', 'title' => 'Загрузка фотографий', 'selector' => '.photo', 'tmpPath' => Yii::app()->params['tempFolder']) ); ?>" class="b-get-image" ><span>Загрузить фотографии</span></a>
	<input type="hidden" name="photo_name" class="photo">
	<ul class='photo-preview'></ul>
	<input type="submit" class="hidden b-butt" value="Сохранить">
	<script>
		$(".photo").change(function(){
			var arr = $('.photo').val().split(','),error="";
			$(".photo-preview").empty();
			$.each( arr, function( index, item ) {
				var item_name = item.split('/');
				item_name = item_name.pop();
				if(item_name.indexOf('_') + 1) {
					var src = "<?=Yii::app()->request->baseUrl ?>"+"/"+item;
					$(".photo-preview").append("<li style='background-image: url("+src+");'></li><input type='hidden' name='photo[]' value='"+item+"'>");
				} else {
					error += " "+item_name+",";
				}
			});
			alert("Некорректное имя у"+error+" указанные файлы не будут загружены")
			$("input[type=submit]").removeClass('hidden');
		});
	</script>
<?php $this->endWidget(); ?>


