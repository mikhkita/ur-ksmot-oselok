<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to 'column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='admin';
	public $scripts = array();

    public $courses = array("USD" => 120);
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();

    public $title="Godzilla Wheels";
    public $description="Godzilla Wheels";
    public $keywords="Godzilla Wheels";
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();

    public $interpreters = array();

    public $user;

    public $cache = array();

    public $start;
    public $render;
    public $debugText = "";

    public $settings = array();

    public $adminMenu = array();

    public function init() {
        parent::init();

        date_default_timezone_set("Asia/Novosibirsk");
        
        $this->user = User::model()->with("role")->findByPk(Yii::app()->user->id);

        $model = ModelNames::model()->findAll(array("order" => "sort ASC"));
        $this->adminMenu["items"] = $this->removeExcess($model);

        foreach ($this->adminMenu["items"] as $key => $value) {
            if( $value->admin_menu == 0 ){
                unset($this->adminMenu["items"][$key]);
            }else{
                $this->adminMenu["items"][$key] = $this->toLowerCaseModelNames($value);
            }
        }

        $this->adminMenu["cur"] = $this->toLowerCaseModelNames(ModelNames::model()->find(array("condition" => "code = '".Yii::app()->controller->id."'")));
        
        $this->start = microtime(true);

        $this->getInterpreters();
    }

    public function beforeRender($view){
        parent::beforeRender($view);

        $this->render = microtime(true);

        $this->debugText = "Controller ".round(microtime(true) - $this->start,4);

        return true;
    }

    public function afterRenderPartial(){
        parent::afterRenderPartial();

        $this->debugText = ($this->debugText."<br>View ".round(microtime(true) - $this->render,4));
    }

    public function getUserRole(){
        return $this->user->role->code;
    }

    public function getUserRoleRus() {
        return $this->user->role->name;
    }

    public function getUserRoleFromModel(){
        $user = User::model()->findByPk(Yii::app()->user->id);
        return $user->role->code;
    }

    public function toLowerCaseModelNames($el){
        if( !$el ) return false;
        $el->vin_name = mb_strtolower($el->vin_name, "UTF-8");
        $el->rod_name = mb_strtolower($el->rod_name, "UTF-8");

        return $el;
    }

    public function insertValues($tableName,$values){
        if( !count($values) ) return true;

        $structure = array();
        foreach ($values[0] as $key => $value) {
            $structure[] = "`".$key."`";
        }

        $structure = "(".implode(",", $structure).")";

        $sql = "INSERT INTO `$tableName` ".$structure." VALUES ";

        $vals = array();
        foreach ($values as $value) {
            $item = array();
            foreach ($value as $el) {
                $item[] = "'".$el."'";
            }
            $vals[] = "(".implode(",", $item).")";
        }

        $sql .= implode(",", $vals);

        return Yii::app()->db->createCommand($sql)->execute();
    }

    public function replaceToBr($str){
        return str_replace("\n", "<br>", $str);
    }

    public function getInterpreters(){
        $tmp = array();
        $model = Interpreter::model()->findAll();
        foreach ($model as $item) {
            $tmp[$item->id.""] = $item;
        }
        $this->interpreters = $tmp;
    }

    public function getListValue($list_id,$attrs){
        $i = "list_".$list_id;
        if( !isset($this->cache[$i]) ){
            $model = Dictionary::model()->with("values")->findByPk($list_id);
            $tmp = array( "ATTRS" => array(), "VALUES" => array() );
            $tmp["ATTRS"]["attr_1"] = $model->attribute_id_1;
            foreach ($model->values as $key => $value) {
                $tmp["VALUES"][$value->attribute_1] = $value->value;
            }
            $this->cache[$i] = $tmp;
        }

        if( isset($attrs[$this->cache[$i]["ATTRS"]["attr_1"]]) ){
            if( is_array($attrs[$this->cache[$i]["ATTRS"]["attr_1"]]) ){
                foreach ($attrs[$this->cache[$i]["ATTRS"]["attr_1"]] as $key => &$value) {
                    $value = (isset($this->cache[$i]["VALUES"][$value->variant_id]))?$this->cache[$i]["VALUES"][$value->variant_id]:"";
                }
                return implode("/", $attrs[$this->cache[$i]["ATTRS"]["attr_1"]]);
            }else{
                return (isset($this->cache[$i]["VALUES"][$attrs[$this->cache[$i]["ATTRS"]["attr_1"]]->variant_id]))?$this->cache[$i]["VALUES"][$attrs[$this->cache[$i]["ATTRS"]["attr_1"]]->variant_id]:"";
            }
        }
        return "";
    }

    public function getTableValue($table_id,$attrs){
        $i = "table_".$table_id;
        if( !isset($this->cache[$i]) ){
            $model = Table::model()->with("values")->findByPk($table_id);
            $tmp = array( "ATTRS" => array(), "VALUES" => array() );
            $tmp["ATTRS"]["attr_1"] = $model->attribute_id_1;
            $tmp["ATTRS"]["attr_2"] = $model->attribute_id_2;
            foreach ($model->values as $key => $value) {
                if( !isset($tmp["VALUES"][$value->attribute_1]) ) $tmp["VALUES"][$value->attribute_1] = array();
                $tmp["VALUES"][$value->attribute_1][$value->attribute_2] = $value->value;
            }
            $this->cache[$i] = $tmp;
        }
        return ( isset($attrs[$this->cache[$i]["ATTRS"]["attr_1"]]->variant_id) && isset($attrs[$this->cache[$i]["ATTRS"]["attr_2"]]->variant_id) && isset($this->cache[$i]["VALUES"][$attrs[$this->cache[$i]["ATTRS"]["attr_1"]]->variant_id][$attrs[$this->cache[$i]["ATTRS"]["attr_2"]]->variant_id]) )?$this->cache[$i]["VALUES"][$attrs[$this->cache[$i]["ATTRS"]["attr_1"]]->variant_id][$attrs[$this->cache[$i]["ATTRS"]["attr_2"]]->variant_id]:"";
    }

    public function getCubeValue($cube_id,$attrs){
        $i = "cube_".$cube_id;
        if( !isset($this->cache[$i]) ){
            $model = Cube::model()->with("values")->findByPk($cube_id);
            $tmp = array( "ATTRS" => array(), "VALUES" => array() );
            $tmp["ATTRS"]["attr_1"] = $model->attribute_id_1;
            $tmp["ATTRS"]["attr_2"] = $model->attribute_id_2;
            $tmp["ATTRS"]["attr_3"] = $model->attribute_id_3;
            foreach ($model->values as $key => $value) {
                if( !isset($tmp["VALUES"][$value->attribute_1]) ) $tmp["VALUES"][$value->attribute_1] = array();
                if( !isset($tmp["VALUES"][$value->attribute_1][$value->attribute_2]) ) $tmp["VALUES"][$value->attribute_1][$value->attribute_2] = array();
                $tmp["VALUES"][$value->attribute_1][$value->attribute_2][$value->attribute_3] = $value->value;
            }
            $this->cache[$i] = $tmp;
        }
        
        return (isset($attrs[$this->cache[$i]["ATTRS"]["attr_1"]]->variant_id) && isset($attrs[$this->cache[$i]["ATTRS"]["attr_2"]]->variant_id) && isset($attrs[$this->cache[$i]["ATTRS"]["attr_3"]]->variant_id) &&  isset($this->cache[$i]["VALUES"][$attrs[$this->cache[$i]["ATTRS"]["attr_1"]]->variant_id][$attrs[$this->cache[$i]["ATTRS"]["attr_2"]]->variant_id][$attrs[$this->cache[$i]["ATTRS"]["attr_3"]]->variant_id]))?$this->cache[$i]["VALUES"][$attrs[$this->cache[$i]["ATTRS"]["attr_1"]]->variant_id][$attrs[$this->cache[$i]["ATTRS"]["attr_2"]]->variant_id][$attrs[$this->cache[$i]["ATTRS"]["attr_3"]]->variant_id]:"";
    }

    public function getVarValue($cube_id){
        $i = "var_".$cube_id;
        if( !isset($this->cache[$i]) ){
            $model = Vars::model()->findByPk($cube_id);
            $this->cache[$i] = (isset($model->value))?$model->value:"";
        }
        
        return $this->cache[$i];
    }

    public function checkAccess($model, $return = false){
        if( $return ){
            return Yii::app()->user->checkAccess($model->rule_code);
        }else if(!Yii::app()->user->checkAccess($model->rule_code)) 
            throw new CHttpException(403,'Доступ запрещен');
    }

    public function getDynObjects($dynamic,$good_type_id){
        $criteria = new CDbCriteria();
        $criteria->with = array("goodTypes","variants");
        $criteria->condition = "goodTypes.good_type_id=".$good_type_id." AND dynamic=1";
        $modelDyn = Attribute::model()->findAll($criteria);
        
        foreach ($modelDyn as $key => $value) {
            $curObj = AttributeVariant::model()->findByPk($dynamic[$value->id]);
            $dynObjects[$value->id] = (object) array("value"=>$curObj->value,"variant_id"=>$curObj->id);
        }

        return $dynObjects;
    }

    public function removeExcess($model){
        foreach ($model as $key => $item) {
            if( !$this->checkAccess( $item, true ) ) unset($model[$key]);
        }
        return array_values($model);
    }

    public function cutText($str, $max_char = 255){
        if( mb_strlen($str,"UTF-8") >= $max_char-3 ){
            $str = mb_substr($str, 0, $max_char-3,"UTF-8")."...";
        }
        return $str;
    }

    public function DownloadFile($source,$filename) {
        if (file_exists($source)) {
        
            if (ob_get_level()) {
              ob_end_clean();
            }

            $arr = explode(".", $source);
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.$filename.".".array_pop($arr) );
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($source));
            
            readfile($source);
            exit;
        }
    }

    public function implodeValues($arr){
        $out = array();
        foreach ($arr as $key => $value) {
            $out[] = $value->value;
        }
        return implode("/",$out);
    }

    public function getParam($category,$code){
        if( $this->settings == NULL ) $this->getSettings();

        $category_code = mb_strtoupper($category,"UTF-8");
        $param_code = mb_strtoupper($code,"UTF-8");

        return ( isset($this->settings[$category_code][$param_code]) )?$this->settings[$category_code][$param_code]:"";
    }

    public function getImages($good, $number = NULL)
    {   
        $imgs = array();
        $path = Yii::app()->params["imageFolder"];
        $code = $good->fields_assoc[3]->value;
        if($good->good_type_id==1) $path .= "/tires/";
        if($good->good_type_id==2) $path .= "/discs/";
        $dir = $path.$code;
        if (is_dir($dir)) {
            $imgs = array_values(array_diff(scandir($dir), array('..', '.', 'Thumbs.db')));
            $dir = Yii::app()->request->baseUrl."/".$path.$code;
            if(count($imgs)) {
                if($number) {
                    for ($i=0; $i < $number; $i++) { 
                        $imgs[$i] = $dir."/".$imgs[$i];
                    }
                } else {
                    foreach ($imgs as $key => &$value) {
                        $value = $dir."/".$value;
                    }
                }           
            } else {
                array_push($imgs, Yii::app()->request->baseUrl."/".$path."default.jpg");
            }
        }
        else {
            array_push($imgs, Yii::app()->request->baseUrl."/".$path."default.jpg");    
        }
        return $imgs;
    }

    public function getSettings(){
        $model = Category::model()->findAll();

        foreach ($model as $category) {
            foreach ($category->settings as $param) {
                $category_code = mb_strtoupper($category->code,"UTF-8");
                $param_code = mb_strtoupper($param->code,"UTF-8");
                if( !isset($this->settings[$category_code]) ) $this->settings[$category_code] = array();
                $this->settings[$category_code][$param_code] = $param->value;
            }
        }
    }
}