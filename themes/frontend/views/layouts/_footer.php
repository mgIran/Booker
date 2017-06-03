<footer class="footer">
    <div class="container">
        <div class="pull-right">
            <ul class="nav nav-pills">
                <li role="presentation"><a href="<?php echo $this->createAbsoluteUrl('//');?>">صفحه اصلی</a></li>
                <li role="presentation"><a href="<?php echo $this->createUrl('/reservation/hotels/cancellation');?>">درخواست انصراف</a></li>
                <li role="presentation"><a href="<?php echo $this->createUrl('/terms');?>">قوانین و مقررات</a></li>
                <li role="presentation"><a href="<?php echo $this->createUrl('/help');?>">راهنما</a></li>
                <li role="presentation"><a href="<?php echo $this->createUrl('/about');?>">درباره ما</a></li>
                <li role="presentation"><a href="<?php echo $this->createUrl('/contactUs');?>">تماس با ما</a></li>
                <li class="copyright">&copy; <?php echo date('Y');?> Booker24</li>
            </ul>
        </div>
        <div class="pull-left rahbod">
            <a href="https://t.me/rahbod" target="_blank" title="Rahbod"><img src="<?php echo Yii::app()->theme->baseUrl."/svg/rahbod.svg";?>"></a>
        </div>
    </div>
</footer>