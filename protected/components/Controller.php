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
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();

    public $interpreters = array();

    public $user;

    public $start;
    public $render;
    public $debugText = "";

    public $adminMenu = array();

    public function init() {
        parent::init();
        
        $this->user = User::model()->findByPk(Yii::app()->user->id);

        $this->adminMenu["items"] = ModelNames::model()->findAll(array("order" => "sort ASC"));

        foreach ($this->adminMenu["items"] as $key => $value) {
            $this->adminMenu["items"][$key] = $this->toLowerCaseModelNames($value);
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
        return $this->user->usr_role;
    }

    public function getUserRoleRus() {
    	switch ($this->user->usr_role){
    		case 'root':
    			return 'Создатель';
    			break;
    		case 'admin':
    			return 'Администратор';
    			break;
    		case 'manager':
    			return 'Пользователь';
    			break;

    		default:
    			return 'Пользователь';
    			break;
    	}
    }

    public function toLowerCaseModelNames($el){
        if( !$el ) return false;
        $el->vin_name = mb_strtolower($el->vin_name, "UTF-8");
        $el->rod_name = mb_strtolower($el->rod_name, "UTF-8");

        return $el;
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

    public function getMenuCodes(){
        $model = Page::model()->findAllByPk(array(1,2),array("order"=>"pag_id ASC"));
        return $model;
    }
}