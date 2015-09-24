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
    public function actionAddAvert(){
        $good = Good::model()->find("id=968");
        $dynamic = array( 37 => 1081, 38 => 869);
        $dynObjects = $this->getDynObjects($dynamic,$good->good_type_id);
        print_r($dynObjects[37]->value);
        // die();
        foreach ($this->drom_params[$good->good_type_id] as $key => $value) {
            if($value['type']=="attr") {
                $params[$key] = $good->fields_assoc[$value['id']]->value;

            } else {
                $params[$key] = Interpreter::generate($value['id'],$good,$dynObjects);
            }
            
        }
        $drom = new Drom();
        $drom->setUser("79528960988","8k6pewk4");
        $drom->addAdvert($params,$good);
    }   

// Дром ------------------------------------------------------------------ Дром

    public function actionAdminIndex(){
        
    }
}
