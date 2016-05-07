<div class="sidebar hidden-sm hidden-xs">
    <?php if($this->platform==1):?>
        <div>
            <a href="<?php echo Yii::app()->createUrl('/android');?>" class="android" data-platform="android">
                <span class="icon-android icon-2x"></span>
                اندروید
            </a>
        </div>
        <div>
            <a href="<?php echo Yii::app()->createUrl('/ios');?>" class="apple" data-platform="ios">
                <span class="icon-apple icon-2x"></span>
                iOS
            </a>
        </div>
        <div>
            <a href="<?php echo Yii::app()->createUrl('/windowsphone');?>" class="win" data-platform="windowsphone">
                <span class="icon-windows icon-2x"></span>
                ویندوز فون
            </a>
        </div>
    <?php elseif($this->platform==2):?>
        <div>
            <a href="<?php echo Yii::app()->createUrl('/ios');?>" class="apple" data-platform="ios">
                <span class="icon-apple icon-2x"></span>
                iOS
            </a>
        </div>
        <div>
            <a href="<?php echo Yii::app()->createUrl('/windowsphone');?>" class="win" data-platform="windowsphone">
                <span class="icon-windows icon-2x"></span>
                ویندوز فون
            </a>
        </div>
        <div>
            <a href="<?php echo Yii::app()->createUrl('/android');?>" class="android" data-platform="android">
                <span class="icon-android icon-2x"></span>
                اندروید
            </a>
        </div>
    <?php elseif($this->platform==3):?>
        <div>
            <a href="<?php echo Yii::app()->createUrl('/windowsphone');?>" class="win" data-platform="windowsphone">
                <span class="icon-windows icon-2x"></span>
                ویندوز فون
            </a>
        </div>
        <div>
            <a href="<?php echo Yii::app()->createUrl('/android');?>" class="android" data-platform="android">
                <span class="icon-android icon-2x"></span>
                اندروید
            </a>
        </div>
        <div>
            <a href="<?php echo Yii::app()->createUrl('/ios');?>" class="apple" data-platform="ios">
                <span class="icon-apple icon-2x"></span>
                iOS
            </a>
        </div>
    <?php endif;?>
</div>