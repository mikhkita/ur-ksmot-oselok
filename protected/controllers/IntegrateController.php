<?php

class IntegrateController extends Controller
{
    private $params = array(
        "TIRE" => array(
            "TITLE_CODE" => 98
        ),
        "DISC" => array(
            "TITLE_CODE" => 99
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
            $result[$key] = array(
                "TEXT" => $header."<br>".$this->generateList($group).$footer,
                "TITLE" => $key,
                "PRICE" => intval($group[0]->fields_assoc[20]->value)
            );
        }

        print_r($result);
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


            $out .= Interpreter::generate($this->params["TIRE"]["TITLE_CODE"],$group[$min_id])."<br>";
            unset($group[$min_id]);
        }

        return $out;
    }

    public function actionIndex(){
        
    }

    public function actionAdminIndex(){
        
    }
}
