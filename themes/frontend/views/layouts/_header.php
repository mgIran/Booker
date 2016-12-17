<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="collapsed navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="<?php echo $this->createUrl('/site');?>" class="navbar-brand">
                <i class="icon"></i>
                <h1 class="hidden-md hidden-sm">بوکر<small>رزرو آنلاین هتل های خارجی</small></h1>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo $this->createUrl('/site');?>">صفحه اصلی</a></li>
                <li<?php echo (Yii::app()->createUrl('/reservation/hotels/cancellation')==Yii::app()->request->requestUri)?' class="active"':''; ?>><a href="<?php echo $this->createUrl('/reservation/hotels/cancellation');?>">درخواست انصراف</a></li>
                <li<?php echo (Yii::app()->createUrl('/terms')==Yii::app()->request->requestUri)?' class="active"':''; ?>><a href="<?php echo $this->createUrl('/terms');?>">قوانین و مقررات</a></li>
                <li<?php echo (Yii::app()->createUrl('/help')==Yii::app()->request->requestUri)?' class="active"':''; ?>><a href="<?php echo $this->createUrl('/help');?>">راهنما</a></li>
                <li<?php echo (Yii::app()->createUrl('/about')==Yii::app()->request->requestUri)?' class="active"':''; ?>><a href="<?php echo $this->createUrl('/about');?>">درباره ما</a></li>
                <li<?php echo (Yii::app()->createUrl('/contactUs')==Yii::app()->request->requestUri)?' class="active"':''; ?>><a href="<?php echo $this->createUrl('/contactUs');?>">تماس با ما</a></li>
            </ul>
        </div>
    </div>
</nav>