<style>
	.import-list{
               
            }
                .import-list .left{
                    float: left;
                }
                    .import-list .left label{
                        text-align: center;
                    }
                    .import-list ul{
                        padding: 5px 5px 4px 5px;
                        width: 300px;
                        /*min-height: 150px;*/
                        height: 300px;
                        overflow-y: auto;
                        border: 1px solid #452716 !important;
                        border-radius: 5px;
                        background-color: #FFF5D1;
                        /*float: left;*/
                    }
                    .import-list .left:first-child{
                        margin-right: 20px;
                    }
                    .import-list .left:last-child{
                        
                    }
                        .import-list ul li{
                            cursor: move;
                            position: relative;
                            list-style: none;
                            padding: 5px 10px;
                            /*margin-bottom: 5px;*/
                            color: #F5E9BC;
                            background-color: #452716;
                            border: 0px solid #F5E9BC;
                            border-bottom: 1px solid #F5E9BC;
                            font-size: 14px;
                            text-shadow: 0 1px 1px rgba(0,0,0,0.5);
                            font-family: "RobotoRegular";
                            /*text-shadow: 0 1px 1px rgba(0,0,0,0.5);*/
                        }
                            .import-list ul li.ui-sortable-helper{
                                background-color: #D26A44;
                                border-bottom: 1px solid #D26A44;
                            }
                            .import-list ul li:hover{
                                background-color: #D26A44;
                            }
                        .import-list ul:first-child li{

                        }
                        .import-list ul:last-child li{
                            
                        }
                            .import-list .left:last-child ul li span,
                            .b-variants li span{
                                border-radius: 50%;
                                background-color: #F5E9BC;
                                color: #452716;
                                height: 20px;
                                padding-top: 0;
                                width: 20px;
                                text-align: center;
                                display: block;
                                position: absolute;
                                right: 5px;
                                top: 5px;
                                font-size: 18px;
                                text-shadow: 0 0px 0px rgba(0,0,0,0.5);
                            }  
                                .import-list .left:last-child ul li span:after,
                                .b-variants li span:after{
                                    content: "×";
                                    position: relative;
                                    top: -2px;
                                    font-size: 18px;
                                }
                                .import-list .left:last-child ul li span:hover,
                                .b-variants li span:hover{
                                    cursor: pointer;
                                    background-color: #452716;
                                    color: #F5E9BC;
                                }
</style>
<h1><?=$model->name?></h1>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'import-step2',
	'action' => Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminstep3'),
	'enableAjaxValidation'=>false
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row import-list clearfix" style="display:inline-block;">
        <div class="left">
            <label for="">Все атрибуты</label>
            <ul id="attr-list">
                <? foreach ($model->fields as $key => $value): ?>
                <li data-id="<?=$value->attribute->id?>"><?=$value->attribute->name?></li>
                <? endforeach; ?>
            </ul>
        </div>
        <div class="left">
            <label for="">Атрибуты Excel</label>
          	<ul id="imp-sort">
                <? foreach ($xls as $key=>$value): ?>
                <li class="ui-state-default"><?=$value?><input type="hidden" name="excel[<?=$key?>]" value="no-id"></li>
                <? endforeach; ?>
            </ul>
        </div>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Перейти к предпросмотру'); ?>
		<input type="hidden" name="excel_folder" value="<?=$folder?>">
		<input type="button" value="Отменить">
	</div>

<?php $this->endWidget(); ?>