<?php

class IntegrateController extends Controller
{
    private $params = array(
        "TIRE" => array(
            "TITLE_CODE" => 100
        ),
        "DISC" => array(
            "TITLE_CODE" => 101
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
    public function actionPhotodoska(){
        $model = GoodType::model()->with('goods.fields.variant','goods.fields.attribute')->findByPk(1)->goods;
        $result = array();

        foreach ($model as $item) {
            if( $item->fields_assoc[7]->value != 0 && $item->fields_assoc[8]->value != 0 && $item->fields_assoc[9]->value != 0 ){
                $title = $item->fields_assoc[7]->value."/".$item->fields_assoc[8]->value."/".$item->fields_assoc[9]->value;

                if( !isset($result[$title]) ) $result[$title] = array();
                array_push($result[$title], $item);
            }
        }

        $header = $this->replaceToBr($this->getParam("PHOTODOSKA","HEADER_T"));
        $footer = $this->replaceToBr($this->getParam("PHOTODOSKA","FOOTER_T"));

        foreach ($result as $key => $group) {
            $price = $this->findPrice($group);
            if( $price != false ){
                $result[$key] = array(
                    "TEXT" => $header."<br>".$this->generateList($group).$footer,
                    "TITLE" => $key,
                    "PRICE" => $price,
                    "IMAGE" => substr($this->findImage($group),1)
                );
            }else{
                unset($result[$key]);
            }
        }

        $photodoska = new Photodoska();

        $photodoska->auth();

        $photodoska->deleteAdverts("867053");
        // die();

        $i = 1 ;
        foreach ($result as $advert) {
            $resizeObj = new Resize($advert["IMAGE"]);
            $resizeObj -> resizeImage(800, 600, 'auto');
            $resizeObj -> saveImage(Yii::app()->params['tempFolder']."/photodoska.jpg", 100);

            $photodoska->addAdvert(Yii::app()->params['tempFolder']."/photodoska.jpg",$advert["TITLE"],$advert["TEXT"],"9234577327",$advert["PRICE"]);
            
            if( $i >= 3 ) die();
            $i++;
        }
    }

    public function generateList($group){
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
                $out .= Interpreter::generate($this->params["TIRE"]["TITLE_CODE"],$group[$min_id])."<br>";
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

    public function actionIndex(){
        
    }

    public function actionAdminIndex(){
        
    }
}
