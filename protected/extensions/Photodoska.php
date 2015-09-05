<?

Class Photodoska {
    
    function __construct() {

    }

    public function auth(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://photodoska.ru/?a=auth');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'data53'=>'Vladis1ove',
            'data84'=>'261192'
        ));
        curl_exec( $ch );
        curl_close($ch);
    }

    public function add_ad($file,$title,$text,$tel,$price) {
        $this->auth();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $cfile = curl_file_create($file);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('upload' => $cfile));
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
        curl_exec( $ch );
        curl_close($ch);
    }

    public function del_ads($save_id = NULL) {
        include_once  Yii::app()->basePath.'/extensions/simple_html_dom.php';
        $html = new simple_html_dom();
        $this->auth();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, "http://photodoska.ru/u/Vladis1ove");
        $html =  str_get_html(curl_exec($ch));
        curl_setopt($ch, CURLOPT_URL, "http://photodoska.ru/?a=delete_ad");
        foreach($html->find('.delete_ad') as $element) {
            $id = $element->getAttribute('data-id');
            if($save_id != $id) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, array("id" => $id) );
                curl_exec($ch);
            }
        }
        curl_close($ch);
    }
    public function parse_ads($ads_title) {
        include_once  Yii::app()->basePath.'/extensions/simple_html_dom.php';
        $html = new simple_html_dom();
        $html =  file_get_html('http://photodoska.ru/u/Vladis1ove');
        foreach ($ads_title as &$item) {
            if($html->find('a[title='.$item.']',0) ) {
                $item = 1;
            } else $item = 0;
        }
        return $ads_title;
    }

}

?>