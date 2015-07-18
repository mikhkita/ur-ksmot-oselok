<?
    $lot = "f155971023";
// include_once(dirname(__FILE__).'/simple_html_dom.php');
  	// $html = new simple_html_dom();

  	$ch = curl_init();
  	$url = "https://www.yahon.ru/auth";
  	curl_setopt($ch, CURLOPT_URL, $url);
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  	curl_setopt($ch, CURLOPT_HEADER, 1);
  	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  	curl_setopt($ch, CURLOPT_POST, 1);
  	curl_setopt($ch, CURLOPT_POSTFIELDS, array(
  		'set_login'=>'svc1',
  		'set_pass'=>'kb5e1law',
  		'set_from'=>'',
  		'to_remain_here'=>'Y'
  	));
  	$content = curl_exec( $ch );

    preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $content, $result);
    $cookies = implode(';', $result[1]);

    curl_close( $ch );

    $ch = curl_init();
    $url = "http://www.yahon.ru/personal/bids";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_COOKIE, $cookies);
    $content = curl_exec( $ch );

    print_r($content);
    curl_close( $ch );


  // 	$ch = curl_init();
  //   curl_setopt($ch, CURLOPT_HEADER, 1);
  // 	// curl_setopt($ch, CURLOPT_COOKIEFILE,  $_SERVER['DOCUMENT_ROOT'].'/cookie.txt');
  // 	$url = "https://www.yahon.ru/";
  // 	curl_setopt($ch, CURLOPT_URL, $url);
  // 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  // 	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  //   curl_setopt($ch, CURLOPT_COOKIE, $cookies);
 	// print_r(curl_exec( $ch ));
  //   curl_close( $ch );

?> 
