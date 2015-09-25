<?php

class DromController extends Controller
{
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
            "price" => array("type" => 'inter',"id" => 22),
            "subject" => array("type" => 'inter',"id" => 17),
            "cityId" => array("type" => 'inter',"id" => 30),
            "goodPresentState" => array("type" => 'inter',"id" => 103),
            "model" => array("type" => 'inter',"id" => 92),
            "condition" => array("type" => 'inter',"id" => 108),
            "wheelDiameter" => array("type" => 'attr',"id" => 9),
            "inSetQuantity" => array("type" => 'attr',"id" => 28),
            "wheelPcd" => array("type" => 'attr',"id" => 5),
            "price" => array("type" => 'inter',"id" => 22),
            "wheelWeight" => array("type" => 'attr',"id" => 34),
            "diskHoleDiameter" => array("type" => 'attr',"id" => 33),
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


// Дром ------------------------------------------------------------------ Дром
    public function actionIndex(){
        $good = Good::model()->find("id=1123");
        $images = $this->getImages($good);
        $dynamic = array( 38 => 1081, 37 => 869);
        foreach ($this->drom_params[$good->good_type_id] as $key => $value) {
            if($value['type']=="attr") {
                if(isset($good->fields_assoc[$value['id']]))
                if(is_array($good->fields_assoc[$value['id']])) {
                    foreach ($good->fields_assoc[$value['id']] as $i => $item) {
                        if($key=='wheelPcd') {
                            $item = explode("*", $item->value);
                            $item[1] = number_format ($item[1],2);
                            $params[$key][$i] = $item[1]."x".$item[0];
                        }else $params[$key][$i] = $item->value;
                    }
                } else  if($key=='wheelPcd') {
                    $pcd = explode("*", $good->fields_assoc[$value['id']]->value);
                    $pcd[1] = number_format ($pcd[1],2);
                    $params[$key] = $pcd[1]."x".$pcd[0];
                } else $params[$key] = $good->fields_assoc[$value['id']]->value;
            } else {
                $params[$key] = Interpreter::generate($value['id'],$good,$this->getDynObjects($dynamic,$good->good_type_id));
            }
            
        }
        $drom = new Drom();
        $drom->setUser("79528960988","aeesnb33");
        $drom->auth("http://baza.drom.ru/personal/");
        $drom->addAdvert($params,$good,$images);
    }   

// Дром ------------------------------------------------------------------ Дром

    public function actionAdminIndex(){
        
    }
}
