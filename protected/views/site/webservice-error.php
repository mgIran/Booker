<?php
/* @var $this SiteController */
/* @var $error array */
?>
<div class="page-error">
    <div class="title">با عرض پوزش خطایی در سیستم رخ داده است لطفا عملیات جستجو را دوباره انجام دهید.</div>

    <div class="buttons">
        <div class="row">
            <div class="col-md-6">
                <a href="<?php echo $this->createUrl('/site');?>" class="btn waves-effect waves-light red lighten-1 btn-block">صفحه اصلی <i class="arrow-icon right"></i></a>
            </div>
            <div class="col-md-6">
                <button onclick="history.back();" class="btn waves-effect waves-light btn-block"><i class="arrow-icon left"></i> بازگشت</button>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="copyright">
        <div class="ltr">
            Copyright &copy; <?php echo date('Y');?> Booker24.net All rights reserved.
        </div>
        <div>
            <a href="<?php echo $this->createUrl('/help')?>">راهنما</a> / <a href="<?php echo $this->createUrl('/contactUs')?>">تماس با ما</a>
        </div>
    </div>
    <!-- ./Copyright -->

</div>