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
    // curl_setopt($ch, CURLOPT_COOKIEJAR, '-');
    // curl_setopt($ch, CURLOPT_REFERER, $url);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   // cURL будет выводить подробные сообщения о всех производимых действиях
   // curl_setopt($ch, CURLOPT_VERBOSE, 1);
   // curl_setopt($ch, CURLOPT_COOKIESESSION,1);
   // curl_setopt($ch, CURLOPT_CERTINFO,1);
   // curl_setopt($ch, CURLOPT_POST, 1);
   // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
   // curl_setopt($ch, CURLOPT_POST, true);
   // curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.134 Safari/537.36");
   curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    // 'Content-type: application/x-www-form-urlencoded',
    // 'Content-length: 59',
    'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
'Accept-Encoding:gzip, deflate',
'Accept-Language:ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4',
'Cache-Control:no-cache',
'Connection:keep-alive',
'Content-Length:59',
'Content-Type:application/x-www-form-urlencoded',
'Host:www.yahon.ru',
'Origin:http://www.yahon.ru',
'Pragma:no-cache',
'Referer:http://www.yahon.ru/',
'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.134 Safari/537.36'
    ));
  	curl_setopt($ch, CURLOPT_POSTFIELDS, array(
  		'set_login'=>'svcl',
  		'set_pass'=>'kb5e1law',
  		'set_from'=>'',
  		'to_remain_here'=>'Y'
  	));
  	$content = curl_exec( $ch );

	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $content, $results);
  $cookies = implode(';', $results[1]);
  
	// $cookies = array();
	// foreach($matches[1] as $item) {
	//     parse_str($item, $cookie);
	//     $cookies = array_merge($cookies, $cookie);
	// }
	// var_dump($cookies);

  	curl_close( $ch );
    $file = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/cookie.txt');
    $file = explode(PHP_EOL,$file);
    $file =  preg_split('/\s+/', $file[4]);
    // print_r($content);

  	$ch = curl_init();
    // print_r($cookies);
    // curl_setopt($ch, CURLOPT_HEADER, 1); 
    curl_setopt($ch, CURLOPT_POST, 0);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//     // 'Content-type: application/x-www-form-urlencoded',
//     // 'Content-length: 59',
//     'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
// 'Accept-Encoding:gzip, deflate, sdch',
// // 'Accept-Language:ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4',
// 'Cache-Control:no-cache',
// 'Connection:keep-alive',
// // 'Host:www.yahon.ru',
// 'Pragma:no-cache',
// // 'Referer:http://www.yahon.ru/',
// 'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.134 Safari/537.36'
//     ));
    
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.134 Safari/537.36");
    print_r($cookies);
    // print_r($file[4]);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // ГўГ®Г§ГўГ°Г Г№Г ГҐГІ ГўГҐГЎ-Г±ГІГ°Г Г­ГЁГ¶Гі
    curl_setopt($ch, CURLOPT_HEADER, 1); 
    // curl_setopt($ch, CURLOPT_COOKIE, $cookies);
    // curl_setopt($ch, CURLOPT_POST, 1);
  	// curl_setopt($ch, CURLOPT_COOKIEFILE,  $_SERVER['DOCUMENT_ROOT'].'/cookie.txt');
  	$url = "https://www.yahon.ru/personal/bids";
  	curl_setopt($ch, CURLOPT_URL, $url);
  	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 	print_r(curl_exec( $ch ));


	// $url = "http://tomsk.baza.drom.ru/upload-image-jquery";
	// curl_setopt($ch, CURLOPT_URL, $url);
	// // curl_setopt($ch, CURLOPT_HTTPHEADER,array('Accept:application/json, text/javascript, */*; q=0.01','Accept-Encoding:gzip, deflate','Accept-Language:ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4','Cache-Control:no-cache','Connection:keep-alive','Content-Type:multipart/form-data'));
	// $cfile = curl_file_create(dirname(__FILE__).'/4-1.jpg','image/jpeg','4-1');


	// {"controlId":0,"id":95536149,"url":"http:\/\/static.baza.farpost.ru\/v\/1428593306920_thumbnail120","urlMiddle":"http:\/\/static.baza.farpost.ru\/v\/1428593306920_bulletin","tag":"","fileName":"11"}
	// stdClass Object ( [controlId] => 0 [id] => 95535667 [url] => http://static.baza.farpost.ru/v/1428593263493_thumbnail120 [urlMiddle] => http://static.baza.farpost.ru/v/1428593263493_bulletin [tag] => [fileName] => test_name )







	// Assign POST data
// 	$data = array('up[0]' => $cfile);
// 	curl_setopt($ch, CURLOPT_POST,1);
// 	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
// 	$abc = (json_decode(curl_exec( $ch ))) ;
// 	print_r($abc);
// 	$url = "http://tomsk.baza.drom.ru/api/1.0/save/bulletin";
// 	curl_setopt($ch, CURLOPT_URL, $url);
// 	 curl_setopt($ch, CURLOPT_POST, 1); // ГЁГ±ГЇГ®Г«ГјГ§Г®ГўГ ГІГј Г¤Г Г­Г­Г»ГҐ Гў post
// // client_type:v2:editing
// 	$obj = (object) array(
// 	'cityId' => 940,
// 	'bulletinType'=>'bulletinRegular',
// 	'fields'=> (object) array(),
// 	'directoryId'=> 234,
// 	'images' => (object) array(
// 		'images' => array ($abc->id),
// 		'tags' => (object) array(
// 			$abc->id => array (null)
// 		),
// 		'masterImageId'=>$abc->id,
// 		'order'=> array($abc->id)
// 	), 
// 	'id'=>35135750);

// 	$obj = json_encode($obj);

//   	curl_setopt($ch, CURLOPT_POSTFIELDS, array(
//   	'changeDescription'=>$obj,
//     'client_type'=>'v2:editing'
//   	));
//   	// print_r(json_decode(curl_exec( $ch )));
// 	curl_close( $ch );



  // ГіГ¤Г Г«ГҐГ­ГЁГҐ Г®ГЎГєГїГўГ«ГҐГ­ГЁГї

 //  $ch = curl_init();
 //  curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');
 //  $url = "http://tomsk.baza.drom.ru/bulletin/service-configure?ids=35089152&applier=deleteBulletin";
 //  curl_setopt($ch, CURLOPT_URL, $url);
 //  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 //  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 //  curl_exec( $ch );
 //  $html = str_get_html ( curl_exec($ch) );
 //  foreach ($html->find('input[name=uid]') as $item) { 
 //  $uid=$item->value;
 //  }
 //  $url = "https://tomsk.baza.drom.ru/bulletin/service-apply";
 //  curl_setopt($ch, CURLOPT_URL, $url);
 //  	curl_setopt($ch, CURLOPT_POST, 1);
	// curl_setopt($ch, CURLOPT_POSTFIELDS, array(
	// 'return_to'=>'http://tomsk.baza.drom.ru/personal/draft/bulletins',
	// 'applier'=>'deleteBulletin',
	// 'uid'=>$uid,
	// 'price'=>'0',
	// 'order_id'=>'0',
	// 'bulletin[35089152]'=>'on'
	// ));
	// curl_exec( $ch );
 //  curl_close( $ch );
 




//  $ch = curl_init();
// // $uagent = "Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36";
// // curl_setopt($ch, CURLOPT_USERAGENT, $uagent);
// // ГіГ±ГІГ Г­Г®ГўГЄГ  URL ГЁ Г¤Г°ГіГЈГЁГµ Г­ГҐГ®ГЎГµГ®Г¤ГЁГ¬Г»Гµ ГЇГ Г°Г Г¬ГҐГІГ°Г®Гў
// curl_setopt($ch, CURLOPT_URL, "http://drom.ru/");
// // curl_setopt($ch, CURLOPT_HEADER, true);
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
// // $header[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*;q=0.8";  
// // $header[] = "Accept-Encoding:gzip, deflate, sdch"; 
// // $header[] = "Content-Type: text/html; charset=windows-1251"; 
// // $header[] = "Cache-Control:no-cache"; 
// // $header[] = "Connection:keep-alive"; 
// // $header[] = "Accept-Language: en-us,en;q=0.5"; 
// // $header[] = "Pragma:no-cache"; 
// // curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
// // Г§Г ГЈГ°ГіГ§ГЄГ  Г±ГІГ°Г Г­ГЁГ¶Г» ГЁ ГўГ»Г¤Г Г·Г  ГҐВё ГЎГ°Г ГіГ§ГҐГ°Гі
// $html=curl_exec($ch);
// // $html= iconv('windows-1251', 'UTF-8', $html);
// echo $html;

// // Г§Г ГўГҐГ°ГёГҐГ­ГЁГҐ Г±ГҐГ Г­Г±Г  ГЁ Г®Г±ГўГ®ГЎГ®Г¦Г¤ГҐГ­ГЁГҐ Г°ГҐГ±ГіГ°Г±Г®Гў
// curl_close($ch);

 // $curl = curl_init(); 

 //  // Setup headers - I used the same headers from Firefox version 2.0.0.6 
 //  // below was split up because php.net said the line was too long. :/ 
  

 //  curl_setopt($curl, CURLOPT_URL, "http://www.google.com"); 
 //  curl_setopt($curl, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)'); 
 //  curl_setopt($curl, CURLOPT_HTTPHEADER, $header); 
 //  curl_setopt($curl, CURLOPT_REFERER, 'http://www.google.com'); 
 //  curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate'); 
 //  curl_setopt($curl, CURLOPT_AUTOREFERER, true); 
 //  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
 //  curl_setopt($curl, CURLOPT_TIMEOUT, 10); 

 //  $html = curl_exec($curl); // execute the curl command 
 //  curl_close($curl); // close the connection 

 //  echo $html; // and finally, return $html 
?> 
