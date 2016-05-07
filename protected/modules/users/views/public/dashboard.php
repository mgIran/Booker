<?php
/* @var $this PublicController */
/* @var $model Users */
?>
<div class="container dashboard-container">
    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#credit-tab">اعتبار</a>
        </li>
        <li>
            <a data-toggle="tab" href="#transactions-tab">تراکنش ها</a>
        </li>
        <li>
            <a data-toggle="tab" href="#buys-tab">خریدها</a>
        </li>
        <li>
            <a data-toggle="tab" href="#bookmarks-tab">نشان شده ها</a>
        </li>
        <li>
            <a data-toggle="tab" href="#setting-tab">تنظیمات</a>
        </li>
    </ul>
    <?php if(Yii::app()->user->roles!='developer'):?>
        <a class="btn btn-danger developer-signup-link" href="<?php echo Yii::app()->createUrl('/developers/panel/signup/step/agreement')?>">توسعه دهنده شوید</a>
    <?php elseif(Yii::app()->user->roles=='developer'):?>
        <a class="btn btn-success developer-signup-link" href="<?php echo Yii::app()->createUrl('/developers/panel')?>">پنل توسعه دهندگان</a>
    <?php endif;?>

    <div class="tab-content">
        <div id="credit-tab" class="tab-pane fade in active">
            <?php $this->renderPartial('_credit',array(
                'model'=>$model,
            ))?>
        </div>
        <div id="transactions-tab" class="tab-pane fade">
            <?php $this->renderPartial('_transactions',array(
                'model'=>$model,
            ))?>
        </div>
        <div id="buys-tab" class="tab-pane fade">
            <?php $this->renderPartial('_buys_list',array(
                'model'=>$model,
            ))?>
        </div>
        <div id="setting-tab" class="tab-pane fade">
            <?php $this->renderPartial('_setting',array(
                'model'=>$model,
            ))?>
        </div>
        <div id="bookmarks-tab" class="tab-pane fade">
            <?php $this->renderPartial('_bookmarks',array(
                'model'=>$model,
            ))?>
        </div>
    </div>
</div>