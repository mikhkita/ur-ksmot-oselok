<?
// include_once(dirname(__FILE__).'/simple_html_dom.php');
  	// $html = new simple_html_dom();

  	$ch = curl_init();
  	$url = "https://www.yahon.ru/auth";
  	// unset($_SERVER['DOCUMENT_ROOT'].'/cookie.txt');
  	curl_setopt($ch, CURLOPT_URL, $url);
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // ГўГ®Г§ГўГ°Г Г№Г ГҐГІ ГўГҐГЎ-Г±ГІГ°Г Г­ГЁГ¶Гі
  	curl_setopt($ch, CURLOPT_HEADER, 1);           // Г­ГҐ ГўГ®Г§ГўГ°Г Г№Г ГҐГІ Г§Г ГЈГ®Г«Г®ГўГЄГЁ
  	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // ГЇГҐГ°ГҐГµГ®Г¤ГЁГІ ГЇГ® Г°ГҐГ¤ГЁГ°ГҐГЄГІГ Г¬
  	//   // useragent

  	// curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);// Г­ГҐ ГЇГ°Г®ГўГҐГ°ГїГІГј SSL Г±ГҐГ°ГІГЁГґГЁГЄГ ГІ
  	// curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);// Г­ГҐ ГЇГ°Г®ГўГҐГ°ГїГІГј Host SSL Г±ГҐГ°ГІГЁГґГЁГЄГ ГІГ 
  	// curl_setopt($ch, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT'].'/cookie.txt'); // Г±Г®ГµГ°Г Г­ГїГІГј ГЄГіГЄГЁ Гў ГґГ Г©Г«
  	// curl_setopt($ch, CURLOPT_COOKIEFILE,  $_SERVER['DOCUMENT_ROOT'].'/cookie.txt');
  	curl_setopt($ch, CURLOPT_POST, 1); // ГЁГ±ГЇГ®Г«ГјГ§Г®ГўГ ГІГј Г¤Г Г­Г­Г»ГҐ Гў post
  	curl_setopt($ch, CURLOPT_POSTFIELDS, array(
  		'set_login'=>'svcl',
  		'set_pass'=>'kb5e1law',
  		'set_from'=>'',
  		'to_remain_here'=>'Y'
  	));
  	$content = curl_exec( $ch );

    preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $content, $result);
    $cookies = implode(';', $result[1]);

    echo $cookies;

    // print_r($content);
    curl_close( $ch );

    $ch = curl_init();
    $url = "https://www.yahon.ru/yahoo/bid_preview";
    // unset($_SERVER['DOCUMENT_ROOT'].'/cookie.txt');
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // ГўГ®Г§ГўГ°Г Г№Г ГҐГІ ГўГҐГЎ-Г±ГІГ°Г Г­ГЁГ¶Гі
    curl_setopt($ch, CURLOPT_HEADER, 1);           // Г­ГҐ ГўГ®Г§ГўГ°Г Г№Г ГҐГІ Г§Г ГЈГ®Г«Г®ГўГЄГЁ
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // ГЇГҐГ°ГҐГµГ®Г¤ГЁГІ ГЇГ® Г°ГҐГ¤ГЁГ°ГҐГЄГІГ Г¬
    //   // useragent

    // curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);// Г­ГҐ ГЇГ°Г®ГўГҐГ°ГїГІГј SSL Г±ГҐГ°ГІГЁГґГЁГЄГ ГІ
    // curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);// Г­ГҐ ГЇГ°Г®ГўГҐГ°ГїГІГј Host SSL Г±ГҐГ°ГІГЁГґГЁГЄГ ГІГ 
    // curl_setopt($ch, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT'].'/cookie.txt'); // Г±Г®ГµГ°Г Г­ГїГІГј ГЄГіГЄГЁ Гў ГґГ Г©Г«
    // curl_setopt($ch, CURLOPT_COOKIEFILE,  $_SERVER['DOCUMENT_ROOT'].'/cookie.txt');
    curl_setopt($ch, CURLOPT_POST, 1); // ГЁГ±ГЇГ®Г«ГјГ§Г®ГўГ ГІГј Г¤Г Г­Г­Г»ГҐ Гў post
    curl_setopt($ch, CURLOPT_COOKIE, $cookies);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
        'lot_no'=>'m140896975',
        'user_rate'=>'1401',
        'quantity'=>'1'
    ));
    $content = curl_exec( $ch );

    preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $content, $result);
    $cookies = implode(';', $result[1]);

    echo $cookies;

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
