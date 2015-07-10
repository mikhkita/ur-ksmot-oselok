<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=8" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />
	<title><?php echo $this->pageTitle; ?></title>
    <link rel="shortcut icon" href="/favicon2.ico" type="image/x-icon"> 
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.fancybox.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/shop.css" />

	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.fancybox.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/KitProgress.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.maskedinput.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/KitSend.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/shop.js"></script>
    <?php foreach ($this->scripts AS $script): ?><script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/<?php echo $script?>.js"></script><? endforeach; ?>
</head>
<body> 
	
    <div class="b b-header">
        <div class="b-block">
        <a href="http://koleso.tomsk.ru/"><img src="<?php echo Yii::app()->request->baseUrl; ?>/i/logo.png" alt=""></a>
        </div>
    </div>
    <?php echo $content;?>
    <div class="b b-bottom">
        <div class="b-block">
            <h3>© 2015 Godzilla</h3>
        </div>
    </div>
    <div style="display: none;">
        <div id="b-popup-buy">
            <div class="b-popup b-popup-buy">
                <h3>Для покупки позвоните по телефону</h3>
                <h4>+7 (999) 999 99-99</h4>
                <h5>или</h5>
                <h6>Оставьте заявку<br>и мы Вам перезвоним в ближайшее время</h6>
                <form action="#" id="b-form-buy">
                    <input type="text" name="phone" id="phone" placeholder="Ваш номер телефона" required/>
                    <input type="text" name="1" id="region" placeholder="Ваш регион" required/>
                    <input type="hidden" name="1-name" value="Регион" />
                    <a href="#" class="ajax b-blue-butt" onclick="$('#b-form-buy').submit();">Отправить</a>
                </form>
            </div>
        </div>
        <div id="b-popup-thanks">
            <div class="b-thanks b-popup">
                <h3>Спасибо за заявку</h3>
                <h4>В ближайшее время мы Вам перезвоним для уточнения заказа</h4>
                <a href="#" class="ajax b-blue-butt" onclick="$.fancybox.close();">Закрыть</a>
            </div>
        </div>
    </div>        

</body>
</html>
