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