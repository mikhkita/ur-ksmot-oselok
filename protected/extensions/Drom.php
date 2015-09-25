<?

Class Drom {
    private $login = "";
    private $password = "";
    private $curl;
    
    function __construct() {
        $this->curl = new Curl();
    }

    public function setUser($login,$password){
        $this->login = $login;
        $this->password = $password;
    }

    public function auth($redirect = ""){
        $this->curl->removeCookies();

        $params = array(
            'sign' => $this->login,
            'password' => $this->password
        );

        return iconv('windows-1251', 'utf-8', $this->curl->request("https://www.farpost.ru/sign?mode=openid&return=".urlencode($redirect)."&login_by_password=1",$params));
    }

    public function upAdverts(){
        $links = $this->parseExpired();
        $upLinks = array();
        Log::debug("Пользователь ".$this->login." ".count($links)." неактивных объявлений");

        foreach ($links as $key => $value) {
            $index = floor($key/50);
            $upLinks[$index] = $upLinks[$index]."&bulletin%5B".$value."%5D=on";
        }

        foreach ($upLinks as $key => $value) {
            $url = "http://baza.drom.ru/bulletin/service-configure?return_to=%2Fpersonal%2Fnon_active%2Fbulletins%3Fpage%3D2&from=personal.non_active&applier%5BprolongBulletin%5D=prolongBulletin".$value."=on&note=";
            $this->curl->request($url);
        }
    }

    public function parseExpired(){
        include_once Yii::app()->basePath.'/extensions/simple_html_dom.php';

        $html = str_get_html($this->auth("http://baza.drom.ru/personal/non_active/bulletins"));

        $links = array();
        $pageLinks = $html->find('.bullNotPublished');
        $page = 1;
        while(count($pageLinks)){
            foreach($pageLinks as $element){
                $exp = $element->find(".expired");
                if( count($exp) )
                    array_push($links, $element->find(".bulletinLink",0)->getAttribute("name"));
            }

            $page++;
            $html = str_get_html(iconv('windows-1251', 'utf-8', $this->curl->request("http://baza.drom.ru/personal/non_active/bulletins?page=".$page)));
            $pageLinks = $html->find('.bullNotPublished');
        }

        return $links;
    }

    public function addAdvert($params,$good,$images){
        $params['model'] = array($params["model"],0,0);
        $params['price'] = array($params["price"],"RUB");
        $params['quantity'] = 1;
        $params['contacts'] =  array("email" => "","is_email_hidden" => false,"contactInfo" => "+79528960999");
        $params['delivery'] = array("pickupAddress" => $params['pickupAddress'],"localPrice" => $params['localPrice'],"minPostalPrice" => $params['minPostalPrice'],"comment" => $params['comment']);
        unset($params['pickupAddress'],$params['localPrice'],$params['minPostalPrice'],$params['comment']);

        if($good->good_type_id== "1") {
            $dirId = 234; 
            $params['predestination'] = "regular";
        }
        if($good->good_type_id== "2") {
            $dirId = 235; 
            $disc_width = explode("/",$params['disc_width']);
            $params['discParameters'] = array();
            foreach ($disc_width as  $i => $value) {
                $params['discParameters'][$i]["disc_width"] = $value;
                if(is_array($params['disc_et'])) {
                	$params['discParameters'][$i]["disc_et"] = (isset($params['disc_et'][$i])) ? $params['disc_et'][$i] : null;
            	} else $params['discParameters'][0]["disc_et"] = $params['disc_et'];
            }  
            if(is_array($params['disc_et']))
            foreach ($params['disc_et'] as  $j => $value) {
            	$params['discParameters'][$j]["disc_width"] = (isset($disc_width[$j])) ? $disc_width[$j] : null;
                $params['discParameters'][$j]["disc_et"] = $value;
            }     
            unset($params['disc_width'],$params['disc_et'],$disc_width);
        }

        $options = array(
            'cityId' => $params['cityId'],
            'bulletinType'=>'',
            'fields'=> array(
                'cityId' => $params['cityId'],
                "subject" => $params['subject'],
                "dirId" => $dirId
                ),
            'directoryId'=> $dirId
        );

        $options = array(
            'changeDescription' => json_encode($options),
            'client_type' => 'v2:adding'
        );
        
        $advert_id = json_decode($this->curl->request("http://baza.drom.ru/api/1.0/save/bulletin",$options))->id;

        foreach ($images as &$image_path) {
           $image_path = json_decode($this->curl->request("http://baza.drom.ru/upload-image-jquery",array('up[]' => '@'.Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.$image_path)))->id;
        }

        $options = array(
	        'cityId' => $params['cityId'],
	        'bulletinType'=>'bulletinRegular',
	        'directoryId'=> $dirId,
	        'fields' => $params,
	        'images' => array(
	            'images' => $images,
	            // 'order'=> $images
	        ), 
	        'id'=>$advert_id
        );
        
        $options= array(
            'changeDescription' => json_encode($options),
            'client_type' => 'v2:editing'
        );

        $this->curl->request("http://baza.drom.ru/api/1.0/save/bulletin",$options);
        $this->curl->request("http://baza.drom.ru/bulletin/".$advert_id."/draft/publish?from=draft.publish",array('from'=>'adding.publish'));
    }
}

?>