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
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/shop.js"></script>
    <?php foreach ($this->scripts AS $script): ?><script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/<?php echo $script?>.js"></script><? endforeach; ?>
</head>
<body> 
	<? if(Yii::app()->params['debug']): ?>
	<div class="b-debug"><?=$this->debugText?></div>
	<? endif; ?>
    <div class="b b-header">
        <div class="b-block">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/i/logo.png" alt="">
        </div>
    </div>
    <div class="b b-menu">
        <div class="b-block clearfix">
            <ul class="hor left clearfix">
                <li class="active">Диски</li>
                <li>Шины</li>
                <li>Контакты</li>
            </ul>
            <form class="right" action="#" method="POST" novalidate="novalidate">
                <input type="text" name="search" placeholder="Поиск">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/i/search-shop.png" alt="">
            </form>
        </div>
    </div>
    <div class='b b-content'><?php echo $content;?></div>
    <div class="b b-bottom">
        <div class="b-block">
            <h3>© 2015 Михайло и Ко</h3>
        </div>
    </div>
                
</body>
</html>
