<?

Class Photodoska {

    private $login = "wheels70";
    private $password = "411447";
    
    function __construct() {

    }

    public function auth(){
        unlink(dirname(__FILE__).'/cookie.txt');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://photodoska.ru/?a=auth');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'data53'=>$this->login,
            'data84'=>$this->password
        ));
        curl_exec( $ch );
        curl_close($ch);
    }

    public function addAdvert($file,$title,$text,$tel,$price) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $cfile = curl_file_create($file);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('upload' => $cfile, 'image/jpeg', 'image.jpg'));
        curl_setopt($ch, CURLOPT_URL, "http://photodoska.ru/?a=upload_photo");
        $photo = substr(curl_exec($ch),2);

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
        curl_setopt($ch, CURLOPT_URL, "http://photodoska.ru/?a=add_ad");
        print_r( curl_exec( $ch ) );
        curl_close($ch);
    }

    public function deleteAdverts($save_id = NULL) {
        print_r(Yii::app()->basePath);
        include_once  Yii::app()->basePath.'/extensions/simple_html_dom.php';
        $html = new simple_html_dom();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, "http://photodoska.ru/u/".$this->login);
        curl_setopt($ch, CURLOPT_URL, "http://photodoska.ru/?a=delete_ad");
        $arr = $this->parseAdverts();
        foreach($arr as $element) {
            if($save_id != $element['id']) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, array("id" => $element['id']) );
                curl_exec($ch);
            }
        }
        curl_close($ch);
    }
    public function parseAdverts() {
        include_once  Yii::app()->basePath.'/extensions/simple_html_dom.php';
        $html = new simple_html_dom();
        $html =  file_get_html('http://photodoska.ru/u/'.$this->login);
        $arr = array();
        foreach ($html->find('a.f-ad') as $item) {
            $temp = array();
            $temp['url'] = $item->href;
            $temp['title'] = $item->title;
            $temp['id'] = array_pop(explode('-', $item->href));
            array_push($arr, $temp);
        }
        return $arr;
    }

}

?>