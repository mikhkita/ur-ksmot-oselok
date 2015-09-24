<?

Class Drom {
    private $login = "";
    private $password = "";
    private $curl;
    private $drom_params = array(
        "1" => array(
            "subject" => array("type" => 'inter',"id" => 8),
            "cityId" => array("type" => 'inter',"id" => 31),
            "goodPresentState" => array("type" => 'inter',"id" => 102),
            "model" => array("type" => 'inter',"id" => 12),
            "inSetQuantity" => array("type" => 'attr',"id" => 28),
            "wheelSeason" => array("type" => 'inter',"id" => 101),
            "wheelTireWear" => array("type" => 'attr',"id" => 29),
            "year" => array("type" => 'attr',"id" => 10),
            "wheelSpike" => array("type" => 'inter',"id" => 104),
            "price" => array("type" => 'inter',"id" => 45),
            "marking" => array("type" => 'inter',"id" => 13),
            "text" => array("type" => 'inter',"id" => 10),
            "pickupAddress" => array("type" => 'inter',"id" => 40),
            "localPrice" => array("type" => 'inter',"id" => 39),
            "minPostalPrice" => array("type" => 'inter',"id" => 38),
            "comment" => array("type" => 'inter',"id" => 72),
            "guarantee" => array("type" => 'inter',"id" => 73),   
        ),
        "2" => array(
            "subject" => array("type" => 'inter',"id" => 17),
            "cityId" => array("type" => 'inter',"id" => 30),
            "goodPresentState" => array("type" => 'inter',"id" => 103),
            "model" => array("type" => 'inter',"id" => 92),
            "wheelDiameter" => array("type" => 'attr',"id" => 9),
            "inSetQuantity" => array("type" => 'attr',"id" => 28),
            "wheelPcd" => array("type" => 'inter',"id" => 19),
            "price" => array("type" => 'inter',"id" => 22),
            "disc_width" => array("type" => 'inter',"id" => 93),
            "disc_et" => array("type" => 'attr',"id" => 32),
            "text" => array("type" => 'inter',"id" => 21),
            "pickupAddress" => array("type" => 'inter',"id" => 41),
            "localPrice" => array("type" => 'inter',"id" => 37),
            "minPostalPrice" => array("type" => 'inter',"id" => 36),
            "comment" => array("type" => 'inter',"id" => 32),
            "guarantee" => array("type" => 'inter',"id" => 29),           
        )
        
    );
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

    public function addAdvert(){
        $good = Good::model()->find();
        // $images = array(dirname(__FILE__).'/1.jpg',dirname(__FILE__).'/2.jpg',dirname(__FILE__).'/3.jpg');
        $params = array();
        foreach ($this->drom_params[$good->good_type_id] as $key => $value) {
            if($value['type']=="attr") {
                $params[$key] = $good->fields_assoc[$value['id']]->value;
            } else {
                $params[$key] = Interpreter::generate($value['id'],$good);
            }
        }
        $params['model'] = array($params["model"],0,0);
        $params['price'] = array($params["price"],"RUB");
        $params['quantity'] = 1;
        $params['contacts'] =  array("email" => "","is_email_hidden" => false,"contactInfo" => "+7 982 242-42-44");
        $params['delivery'] = array("pickupAddress" => $params['pickupAddress'],"localPrice" => $params['localPrice'],"minPostalPrice" => $params['minPostalPrice'],"comment" => $params['comment']);
        unset($params['pickupAddress'],$params['localPrice'],$params['minPostalPrice'],$params['comment']);

        if($good->good_type_id== "1") {
            $dirId = 234; 
            $params['predestination'] = "regular";
        }
        if($good->good_type_id== "2") {
            $dirId = 235;
            $wheelPcd = explode("/",$params['wheelPcd']);
            $params['wheelPcd'] = array();
            foreach ($wheelPcd as $value) {
                array_push($params['wheelPcd'],$value);
            }  
            $disc_width = explode("/",$params['disc_width']);
            $disc_et = explode("/",$params['disc_et']);
            unset($params['disc_width'],$params['disc_et']);
            $params['discParameters'] = array();
            foreach ($disc_width as  $i => $value) {
                $params['discParameters'][] = array("disc_width" => $value,"disc_et" => $disc_et[$i]);
            }           
            
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

        $images = $good->getImages();
        foreach ($images as &$image_path) {
           $image_path = json_decode($this->curl->request("http://baza.drom.ru/upload-image-jquery",'up[]' => '@'.$image_path))->id;
        }
        
        $options = array(
	        'cityId' => $params['cityId'],
	        'bulletinType'=>'bulletinRegular',
	        'directoryId'=> $dirId,
	        'fields' => $params,
	        'images' => array(
	            'images' => $images
	            // 'order'=> $images
	        ), 
	        'id'=>$advert_id
        );

        $options= array(
            'changeDescription' => json_encode($options),
            'client_type' => 'v2:editing'
        );

        $this->curl->request("http://baza.drom.ru/api/1.0/save/bulletin",$options);
        $this->curl->request("http://baza.drom.ru/bulletin/".$advert_id."/draft/publish?from=draft.publish",'from'=>'adding.publish');
    }
}

?>