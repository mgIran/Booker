<?php
/* @var $this DashboardController*/
/* @var $cancellationRequests CActiveDataProvider*/
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
<div class="panel panel-default col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="panel-heading">
        درخواست انصراف
    </div>
    <div class="panel-body">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'cancellation-grid',
            'dataProvider'=>$cancellationRequests,
            'columns'=>array(
                array(
                    'header'=>'درخواست کننده',
                    'value'=>'$data->booking->order->fullName'
                ),
                array(
                    'header'=>'موبایل',
                    'value'=>'$data->booking->order->buyer_mobile'
                ),
                array(
                    'header'=>'نام هتل',
                    'value'=>'$data->booking->hotel'
                ),
                array(
                    'header'=>'شهر',
                    'value'=>'$data->booking->city.", ".$data->booking->country'
                ),
                array(
                    'name'=>'created_date',
                    'value'=>'JalaliDate::date("d F Y - H:i", $data->created_date)'
                ),
                array(
                    'class'=>'CButtonColumn',
                    'template'=>'{view}',
                    'buttons'=>array(
                        'view'=>array(
                            'url'=>'Yii::app()->createUrl("/reservation/hotels/viewCancellationRequest", array("id"=>$data->id))',
                        ),
                    )
                ),
            ),
        )); ?>
    </div>
</div>