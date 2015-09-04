<?
include_once(dirname(__FILE__).'/simple_html_dom.php');
  $html = new simple_html_dom();
  $ch = curl_init();
  $url = "http://photodoska.ru/?a=auth";
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // ГўГ®Г§ГўГ°Г Г№Г ГҐГІ ГўГҐГЎ-Г±ГІГ°Г Г­ГЁГ¶Гі
  // curl_setopt($ch, CURLOPT_HEADER, 0);           // Г­ГҐ ГўГ®Г§ГўГ°Г Г№Г ГҐГІ Г§Г ГЈГ®Г«Г®ГўГЄГЁ
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // ГЇГҐГ°ГҐГµГ®Г¤ГЁГІ ГЇГ® Г°ГҐГ¤ГЁГ°ГҐГЄГІГ Г¬
  //   // useragent
   // curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);// Г­ГҐ ГЇГ°Г®ГўГҐГ°ГїГІГј SSL Г±ГҐГ°ГІГЁГґГЁГЄГ ГІ
  // curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);// Г­ГҐ ГЇГ°Г®ГўГҐГ°ГїГІГј Host SSL Г±ГҐГ°ГІГЁГґГЁГЄГ ГІГ 
  curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt'); // Г±Г®ГµГ°Г Г­ГїГІГј ГЄГіГЄГЁ Гў ГґГ Г©Г«
  curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');
  curl_setopt($ch, CURLOPT_POST, 1); // ГЁГ±ГЇГ®Г«ГјГ§Г®ГўГ ГІГј Г¤Г Г­Г­Г»ГҐ Гў post
  curl_setopt($ch, CURLOPT_POSTFIELDS, array(
  'data53'=>'Vladis1ove',
  'data84'=>'261192'
  ));
  curl_exec( $ch );

	$url = "http://photodoska.ru/?a=upload_photo";
	curl_setopt($ch, CURLOPT_URL, $url);
	// curl_setopt($ch, CURLOPT_HTTPHEADER,array('Accept:application/json, text/javascript, */*; q=0.01','Accept-Encoding:gzip, deflate','Accept-Language:ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4','Cache-Control:no-cache','Connection:keep-alive','Content-Type:multipart/form-data'));
	// $cfile = curl_file_create(dirname(__FILE__).'/4-1.jpg','image/jpeg','4-1');


	// {"controlId":0,"id":95536149,"url":"http:\/\/static.baza.farpost.ru\/v\/1428593306920_thumbnail120","urlMiddle":"http:\/\/static.baza.farpost.ru\/v\/1428593306920_bulletin","tag":"","fileName":"11"}
	// stdClass Object ( [controlId] => 0 [id] => 95535667 [url] => http://static.baza.farpost.ru/v/1428593263493_thumbnail120 [urlMiddle] => http://static.baza.farpost.ru/v/1428593263493_bulletin [tag] => [fileName] => test_name )




	$cfile = curl_file_create(dirname(__FILE__).'/4-1.jpg','image/jpeg','4-1');
	$data = array('upload' => $cfile);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_URL, $url);
	$photo = substr(curl_exec($ch),2);
	$url = "http://photodoska.ru/?a=add_ad";
  	curl_setopt($ch, CURLOPT_URL, $url);

	$title = "asdasd";
	$text = "<p>фывфыв</p>"; 
	$tel = '89231231212';
	$price = 1000;
	$data = array(
		'data[0][name]' => 'city_id',
		'data[0][value]' => 1,
		'data[1][name]' => 'parent_rubric_id',
		'data[1][value]' => 1,
		'data[2][name]' => 'child_rubric_id',
		'data[2][value]' => 42,
		'data[3][name]' => 'title',
		'data[3][value]' => $title,
		'data[4][name]' => 'text',
		'data[4][value]' => $text,
		'data[6][name]' => 'photo_1',
		'data[6][value]' => $photo,
		'data[11][name]' => 'price',
		'data[11][value]' => $price,
		'data[12][name]' => 'phone',
		'data[12][value]' => $tel,
		'data[13][name]' => 'comment_permission',
		'data[13][value]' => 0
		);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	print_r(curl_exec( $ch ));
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
