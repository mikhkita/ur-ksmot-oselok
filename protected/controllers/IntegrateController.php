<?php

class IntegrateController extends Controller
{
    private $params = array(
        "TIRE" => array(
            "GOOD_TYPE_ID" => 1,
            "TITLE_CODE" => 100,
            "HEADER" => "HEADER_T",
            "FOOTER" => "FOOTER_T",
            "JOIN" => array(7,8,9),
            "ADVERT_TITLE_CODE" => 13,
        ),
        "DISC" => array(
            "GOOD_TYPE_ID" => 2,
            "TITLE_CODE" => 101,
            "HEADER" => "HEADER_D",
            "FOOTER" => "FOOTER_D",
            "JOIN" => array(9,5,31),
            "ADVERT_TITLE_CODE" => 102,
        )
    );

    public function filters()
    {
        return array(
                'accessControl'
            );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users'=>array('*'),
            ),
        );
    }

// Фотодоска ------------------------------------------------------------- Фотодоска
    public function photodoska($good_type_code,$delete = false){
        Log::debug("Начало выкладки на фотодоску");

        $photodoska = new Photodoska();
        $photodoska->auth();
        
        if( $delete ) $photodoska->deleteAdverts(trim($this->getParam("PHOTODOSKA","MAIN_ADVERT")));

        $this->publicateAdverts($photodoska,$this->getGroups($good_type_code));

        Log::debug("Конец выкладки на фотодоску");
    }

    public function actionPhotodoskaTire(){
        $this->photodoska("TIRE","1");
    }

    public function actionPhotodoskaDisc(){
        $this->photodoska("DISC");
    }

    public function publicateAdverts($photodoska,$adverts){
        // $i = 1;
        foreach ($adverts as $advert) {
            sleep(2);
            $resizeObj = new Resize($advert["IMAGE"]);
            $resizeObj -> resizeImage(800, 600, 'auto');
            $resizeObj -> saveImage(Yii::app()->params['tempFolder']."/photodoska.jpg", 100);

            $photodoska->addAdvert(Yii::app()->params['tempFolder']."/photodoska.jpg",$advert["TITLE"],$advert["TEXT"],trim($this->getParam("PHOTODOSKA","PHONE")),$advert["PRICE"]);
            
            // if( $i >= 1 ) return;
            // $i++;
        }
    }

    public function getGroups($good_type_code){
        $curParams = $this->params[$good_type_code];

        $model = GoodType::model()->with('goods.fields.variant','goods.fields.attribute')->findByPk($curParams["GOOD_TYPE_ID"])->goods;
        $result = array();

        foreach ($model as $item) {
            $tog = true;

            foreach ($curParams["JOIN"] as $field)
                if( $item->fields_assoc[intval($field)]->value == 0 ) $tog = false;

            if( $tog ){
                $title = Interpreter::generate($curParams["ADVERT_TITLE_CODE"],$item);

                if( !isset($result[$title]) ) $result[$title] = array();
                array_push($result[$title], $item);
            }
        }

        $header = $this->replaceToBr($this->getParam("PHOTODOSKA",$curParams["HEADER"]));
        $footer = $this->replaceToBr($this->getParam("PHOTODOSKA",$curParams["FOOTER"]));

        foreach ($result as $key => $group) {
            $price = $this->findPrice($group);
            if( $price != false ){
                $result[$key] = array(
                    "TEXT" => $header."<br>".$this->generateList($group,$curParams["TITLE_CODE"]).$footer,
                    "TITLE" => $key,
                    "PRICE" => $price,
                    "IMAGE" => substr($this->findImage($group),1)
                );
            }else{
                unset($result[$key]);
            }
        }

        return $result;
    }

    public function generateList($group,$interpreter_id){
        $out = "";

        for( $j = 0 ; $j < count($group); $j++ ) {
            $min = 999999;
            $min_id = 0;

            foreach ($group as $i => $item) {
                if( intval($item->fields_assoc[20]->value) < $min ){
                    $min_id = $i;
                    $min = intval($item->fields_assoc[20]->value);
                } 
            }

            if( $min != 0 )
                $out .= Interpreter::generate($interpreter_id,$group[$min_id])."<br>";
            unset($group[$min_id]);
        }

        return $out;
    }

    public function findPrice($group){
        $min = 999999;

        foreach ($group as $i => $item) {
            $price = intval($item->fields_assoc[20]->value);
            if( $price < $min && $price != 0 ){
                $min = $price;
            } 
        }

        return ( $min == 999999 )?false:$min;
    }

    public function findImage($group){
        foreach ($group as $item) {
            $images = $this->getImages($item);
            if( count($images) != 0 ) return $images[0];
        }
        return "";
    }
// Фотодоска ------------------------------------------------------------- Фотодоска

// Дром ------------------------------------------------------------------ Дром
    public function actionDromUp(){
        Log::debug("Начало автоподнятия дром");
        $drom = new Drom();

        $users = $this->getParam("DROM","USERS");

        $users = explode("\n", $users);

        foreach ($users as $value) {
            $user = explode(" ", $value);
            $drom->setUser($user[0],$user[1]);
            $drom->upAdverts();
        }

        Log::debug("Кончало автоподнятия дром");
    }
// Дром ------------------------------------------------------------------ Дром

    public function actionAdminIndex(){
        
    }
}
