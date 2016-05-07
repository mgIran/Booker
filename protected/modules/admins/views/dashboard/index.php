<?php
/* @var $this DashboardController*/
/* @var $devIDRequests CActiveDataProvider*/
/* @var $newestPrograms CActiveDataProvider*/
/* @var $newestDevelopers CActiveDataProvider*/
?>
<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success fade in">
        <button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
        <?php echo Yii::app()->user->getFlash('success');?>
    </div>
<?php elseif(Yii::app()->user->hasFlash('failed')):?>
    <div class="alert alert-danger fade in">
        <button class="close close-sm" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
        <?php echo Yii::app()->user->getFlash('failed');?>
    </div>
<?php endif;?>

<div class="panel panel-default col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="panel-heading">
        جدیدترین نرم افزار ها
    </div>
    <div class="panel-body">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'newest-apps-grid',
            'dataProvider'=>$newestPrograms,
            'columns'=>array(
                'title',
                'developer_id'=>array(
                    'name'=>'developer_id',
                    'value'=>'(is_null($data->developer_id) or empty($data->developer_id))?$data->developer_team:$data->developer->userDetails->developer_id'
                ),
                'confirm'=>array(
                    'name'=>'confirm',
                    'value'=>'CHtml::dropDownList("confirm", "pending", $data->confirmLabels, array("class"=>"change-confirm", "data-id"=>$data->id))',
                    'type'=>'raw'
                ),
                array(
                    'class'=>'CButtonColumn',
                    'template' => '{view}{delete}{download}',
                    'buttons'=>array(
                        'view'=>array(
                            'label'=>'مشاهده برنامه',
                            'url'=>'Yii::app()->createUrl("/apps/".$data->id."/".urlencode($data->title))',
                            'options'=>array(
                                'target'=>'_blank'
                            ),
                        ),
                        'delete'=>array(
                            'url'=>'CHtml::normalizeUrl(array(\'/manageApps/\'.$data->platformsID[$data->platform_id].\'/delete/\'.$data->id))'
                        ),
                        'download'=>array(
                            'label'=>'دانلود',
                            'url'=>'Yii::app()->createUrl("/uploads/apps/files/".$data->platformsID[$data->platform_id]."/".$data->file_name)',
                            'imageUrl'=>Yii::app()->theme->baseUrl.'/img/download.png',
                        ),
                    ),
                ),
            ),
        ));?>
        <?php Yii::app()->clientScript->registerScript('changeConfirm', "
            $('.change-confirm').on('change', function(){
                $.ajax({
                    url:'".$this->createUrl('/manageApps/android/changeConfirm')."',
                    type:'POST',
                    dataType:'JSON',
                    data:{app_id:$(this).data('id'), value:$(this).val()},
                    success:function(data){
                        if(data.status)
                            $.fn.yiiGridView.update('newest-apps-grid');
                        else
                            alert('در انجام عملیات خطایی رخ داده است لطفا مجددا تلاش کنید.');
                    }
                });
            });
        ");?>
    </div>
</div>
<div class="panel panel-default col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="panel-heading">
        اطلاعات توسعه دهندگان جدید<small>(تایید نشده)</small>
    </div>
    <div class="panel-body">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'newest-developers-grid',
            'dataProvider'=>$newestDevelopers,
            'columns'=>array(
                'email'=>array(
                    'name'=>'email',
                    'value'=>'CHtml::link($data->user->email, Yii::app()->createUrl("/users/".$data->user_id))',
                    'type'=>'raw'
                ),
                'fa_name',
                array(
                    'class'=>'CButtonColumn',
                    'template' => '{view}{confirm}{refused}',
                    'buttons'=>array(
                        'confirm'=>array(
                            'label'=>'تایید کردن',
                            'url'=>"CHtml::normalizeUrl(array('/users/usersManage/confirmDeveloper', 'id'=>\$data->user_id))",
                            'imageUrl'=>Yii::app()->theme->baseUrl.'/img/confirm.png',
                        ),
                        'refused'=>array(
                            'label'=>'رد کردن',
                            'url'=>'CHtml::normalizeUrl(array(\'/users/usersManage/refuseDeveloper\', \'id\'=>$data->user_id))',
                            'imageUrl'=>Yii::app()->theme->baseUrl.'/img/refused.png',
                        ),
                        'view'=>array(
                            'url'=>'CHtml::normalizeUrl(array("/users/".$data->user_id))',
                        ),
                    ),
                ),
            ),
        ));?>
    </div>
</div>
<div class="panel panel-default col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="panel-heading">
        درخواست های تغییر شناسه توسعه دهنده
    </div>
    <div class="panel-body">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'dev-id-requests-grid',
            'dataProvider'=>$devIDRequests,
            'columns'=>array(
                'user_id'=>array(
                    'name'=>'user_id',
                    'value'=>'CHtml::link($data->user->userDetails->fa_name, Yii::app()->createUrl("/users/".$data->user->id))',
                    'type'=>'raw'
                ),
                'requested_id',
                array(
                    'class'=>'CButtonColumn',
                    'template' => '{confirm}{delete}',
                    'buttons'=>array(
                        'confirm'=>array(
                            'label'=>'تایید کردن',
                            'url'=>"CHtml::normalizeUrl(array('/users/usersManage/confirmDevID', 'id'=>\$data->user_id))",
                            'imageUrl'=>Yii::app()->theme->baseUrl.'/img/confirm.png',
                        ),
                        'delete'=>array(
                            'url'=>'CHtml::normalizeUrl(array(\'/users/usersManage/deleteDevID\', \'id\'=>$data->user_id))'
                        ),
                    ),
                ),
            ),
        ));?>
    </div>
</div>
<div class="panel panel-default col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="panel-heading">
        آمار بازدیدکنندگان
    </div>
    <div class="panel-body">
        <p>
            افراد آنلاین : <?php echo Yii::app()->userCounter->getOnline(); ?><br />
            بازدید امروز : <?php echo Yii::app()->userCounter->getToday(); ?><br />
            بازدید دیروز : <?php echo Yii::app()->userCounter->getYesterday(); ?><br />
            تعداد کل بازدید ها : <?php echo Yii::app()->userCounter->getTotal(); ?><br />
            بیشترین بازدید : <?php echo Yii::app()->userCounter->getMaximal(); ?><br />
        </p>
    </div>
</div>