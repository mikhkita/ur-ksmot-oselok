<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="keywords" content=''>
	<meta name="description" content=''>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1">
	<link rel="stylesheet" href="css/reset.css" type="text/css">
	<link rel="stylesheet" href="css/jquery.fancybox.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="js/plupload/jquery.plupload.queue/css/jquery.plupload.queue.css" />
	<link rel="stylesheet" href="css/layout.css" type="text/css">
	<link rel="icon" type="image/vnd.microsoft.icon" href="favicon.ico">

	<meta name="viewport" content="width=1000">

	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox.js"></script>
	<script type="text/javascript" src="js/TweenMax.min.js"></script>
	<script type="text/javascript" src="js/plupload/plupload.full.js"></script>
    <script type="text/javascript" src="js/plupload/jquery.plupload.queue/jquery.plupload.queue.js"></script>
	<script type="text/javascript" src="js/css3-mediaqueries.js"></script>
	<script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>
	<script type="text/javascript" src="js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="js/KitProgress.js"></script>
	<script type="text/javascript" src="js/device.js"></script>
	<script type="text/javascript" src="js/KitSend.js"></script>
	<script type="text/javascript" src="js/main.js"></script>

</head>
<body>
	<ul class="ps-lines">
		<li class="v" style="margin-left:-501px"></li>
		<li class="v" style="margin-left:500px"></li>
		<li class="v" ></li>
	</ul>
	<div class="b b-1">
		<form action="excel.php" method="POST" id="b-main-form">
		<div class="b-block">
			<div class="clearfix fields">
				<div class="left">
					<label for="header">Header</label>
					<textarea name="header" id="header" cols="30" rows="10">Продам летние шины с японского аукциона. Без пробега по РФ. Без грыж и порезов.
Шины в наличии в г. Томске. Продаются без торга. Обмен не интересен. Подойдут на ваш авто или нет - не знаю.</textarea>
				</div>
				<div class="right">
					<label for="footer">Footer</label>
					<textarea name="footer" class="right" id="header" cols="30" rows="10">+7-923-457-7327
wheels70@mail.ru
Много резины, дисков в наличии в Томске: [url=http://koleso.tomsk.ru]http://koleso.tomsk.ru[/url]</textarea>
				</div>
			</div>
<!-- 			<div class="hidden" id="tp_head_text_data">Загрузка изображений</div> -->
			<!-- <form action="/adv/setAdvImg?id=" method="POST" id="uploader"> -->
			    <div class="upload">
			        <h3>Загрузка файлов</h3>
			        <!-- <div class="max-files">Оставшееся количество изображений: <span class="max-files-count" data-count=""></span></div> -->
			        <div id="uploaderPj">Ваш браузер не поддерживает Flash.</div>
			        <div class="b-save-buttons">
			            <a href="#" onclick="$('#b-main-form').submit();" class="plupload_button plupload_save">Сгенерировать</a>
			            <!-- <a href="#" class="plupload_button plupload_cancel" >Отменить</a> -->
			        </div>
			    </div>
			    <!-- <div class="b-upload-overlay"></div> -->
			<!-- </form> -->
		</div>
		</form>
	</div>
	<div class="b b-2">
		<div class="b-block">
			
		</div>
	</div>
</body>
</html>