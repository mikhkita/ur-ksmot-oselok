<?

Class Drom {
    private $login = "";
    private $password = "";
    private $curl;
    private $drom_params = array(
        "1" => array(
            "SUBJECT" => array("type" => 'inter',"id" => 8),
            "CITY_ID" => array("type" => 'inter',"id" => 31),
            "GOOD_PRESENT_STATE" => array("type" => 'inter',"id" => 102),
            "MODEL" => array("type" => 'inter',"id" => 12),
            "IN_SET_QUANTITY" => array("type" => 'attr',"id" => 28),
            "WHEEL_SEASON" => array("type" => 'inter',"id" => 101),
            "WHEEL_TIREWEAR" => array("type" => 'attr',"id" => 29),
            "YEAR" => array("type" => 'attr',"id" => 10),
            "WHEEL_SPIKE" => array("type" => 'inter',"id" => 104),
            "PRICE" => array("type" => 'inter',"id" => 45),
            "MARKING" => array("type" => 'inter',"id" => 13),
            "TEXT" => array("type" => 'inter',"id" => 10),
            "PICKUP_ADDRESS" => array("type" => 'inter',"id" => 40),
            "LOCAL_PRICE" => array("type" => 'inter',"id" => 39),
            "MIN_POSTAL_PRICE" => array("type" => 'inter',"id" => 38),
            "COMMENT" => array("type" => 'inter',"id" => 72),
            "GUARANTEE" => array("type" => 'inter',"id" => 73),   
        )
        "2" => array(
            "SUBJECT" => array("type" => 'inter',"id" => 17),
            "CITY_ID" => array("type" => 'inter',"id" => 30),
            "GOOD_PRESENT_STATE" => array("type" => 'inter',"id" => 103),
            "MODEL" => array("type" => 'inter',"id" => 92),
            "WHEEL_DIAMETER" => array("type" => 'attr',"id" => 9),
            "IN_SET_QUANTITY" => array("type" => 'attr',"id" => 28),
            "WHEEL_PCD" => array("type" => 'inter',"id" => 19),
            "PRICE" => array("type" => 'inter',"id" => 22),
            "DISC_WIDTH" => array("type" => 'inter',"id" => 93),
            "DISC_ET" => array("type" => 'attr',"id" => 32),
            "TEXT" => array("type" => 'inter',"id" => 21),
            "PICKUP_ADDRESS" => array("type" => 'inter',"id" => 41),
            "LOCAL_PRICE" => array("type" => 'inter',"id" => 37),
            "MIN_POSTAL_PRICE" => array("type" => 'inter',"id" => 36),
            "COMMENT" => array("type" => 'inter',"id" => 32),
            "GUARANTEE" => array("type" => 'inter',"id" => 29),           
        ),
        
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
        $images = array(dirname(__FILE__).'/1.jpg',dirname(__FILE__).'/2.jpg',dirname(__FILE__).'/3.jpg');
        $params = array();
        foreach ($this->drom_params[$good->good_type_id] as $key => $value) {
            if($value['type']=="attr") {
                $params[$key] = $good->fields_assoc[$value['id']]->value;
            } else {
                $params[$key] = Interpreter::generate($value['id'],$good);
            }
        }
        if($good->good_type_id== "1") $params["DIR_ID"] = 234; 
        if($good->good_type_id== "2") $params["DIR_ID"] = 235;
        
        $options = array(
            'cityId' => $params['CITY_ID'],
            'bulletinType'=>'',
            'fields'=> array(
                'cityId' => $params['CITY_ID'],
                "subject" => $params['SUBJECT'],
                "dirId" => $params["DIR_ID"]
                ),
            'directoryId'=> $params["DIR_ID"]
        );
        $fields = array(
            'changeDescription' => json_encode($options),
            'client_type' => 'v2:adding'
        );
        $advert_id = json_decode($this->curl->request("http://baza.drom.ru/api/1.0/save/bulletin",$fields))->id;

        foreach ($images as &$image_path) {
           $image_path = json_decode($this->curl->request("http://baza.drom.ru/upload-image-jquery",'up[]' => '@'.$image_path))->id;
        }
        
        $options = array(
        'cityId' => $params['CITY_ID'],
        'bulletinType'=>'bulletinRegular',
        'directoryId'=> $params["DIR_ID"],
        'fields' => array(
            "goodPresentState" => $params["GOOD_PRESENT_STATE"],
            "model" => array($params["MODEL"],0,0),
            "inSetQuantity" => $params["IN_SET_QUANTITY"],
            "quantity" => 1,
            "price" => array($params["PRICE"],"RUB"),
            "text" => $params["TEXT"],
            'pickupAddress' => $params["PICKUP_ADDRESS"],
            'localPrice' => $params["LOCAL_PRICE"],
            'minPostalPrice' => $params["MIN_POSTAL_PRICE"],
            'comment' => $params["COMMENT"],
            'guarantee' => $params["GUARANTEE"],
            "contacts" => array("email" => "","is_email_hidden" => false,"contactInfo" => "+7 982 242-42-44")
        ),
        'images' => array(
            'images' => $images,
            'order'=> $images
        ), 
        'id'=>$advert_id
        );
        if($good->good_type_id== "1") {
            $options['fields']['wheelSeason'] = $params["WHEEL_SEASON"];
            $options['fields']['wheelTireWear'] = $params["WHEEL_TIREWEAR"];
            $options['fields']['year'] = $params["YEAR"];
            $options['fields']['wheelSpike'] = $params["WHEEL_SPIKE"];
            $options['fields']['marking'] = $params["MARKING"];
            $options['fields']['predestination'] = "regular"; 
        }
        if($good->good_type_id== "2") {
            $options['fields']['wheelDiameter'] = $params["WHEEL_SEASON"];
            $options['fields']['wheelPcd'] = $params["WHEEL_TIREWEAR"];
            $options['fields']['year'] = $params["YEAR"];
            $options['fields']['wheelSpike'] = $params["WHEEL_SPIKE"];
            $options['fields']['marking'] = $params["MARKING"];
        }
            $options['fields'] = array(
                "model" => array("5ZIGEN",0,0),
                "wheelDiameter" => "4.5",
                "quantity" => 1,
                "goodPresentState" => "present",
                "text" => "Объява",
                "contacts" => array("email" => "","is_email_hidden" => false,"contactInfo" => "+7 982 242-42-44")
            );
        $params = array(
            'changeDescription' => json_encode($options),
            'client_type' => 'v2:editing'
        );

        $this->curl->request("http://baza.drom.ru/api/1.0/save/bulletin",$params);
        $this->curl->request("http://baza.drom.ru/bulletin/".$advert_id."/draft/publish?from=draft.publish",'from'=>'adding.publish');
    }
}

?>