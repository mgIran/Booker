<footer class="footer">
    <nav>
        <ul class="nav nav-list">
            <li>
                <a href="<?= Yii::app()->createUrl('/site/privacy'); ?>"></a>
                حریم شخصی
            </li><li>
                <a href="<?= Yii::app()->createUrl('/site/terms'); ?>"></a>
                شرایط استفاده از خدمات
            </li><li>
                <?php if(isset(Yii::app()->user->roles) and Yii::app()->user->roles=='developer'):?>
                    <a href="<?= Yii::app()->createUrl('/developers/panel'); ?>"></a>
                <?php else:?>
                    <a href="<?= Yii::app()->createUrl('/developers/panel/signup/step/agreement'); ?>"></a>
                <?php endif;?>
                توسعه دهندگان
            </li><li>
                <a href="<?= Yii::app()->createUrl('/site/help');?>"></a>
                راهنما
            </li><li>
                <a href="<?= Yii::app()->createUrl('/site/contactUs'); ?>"></a>
                تماس با ما
            </li><li>
                <a href="<?= Yii::app()->createUrl('/site/about');?>"></a>
                درباره ما
            </li>
        </ul>
    </nav>
    <div class="copyright ltr pull-left" >
        &copy;
        <strong>2016</strong>
        Hyper Apps
    </div>
</footer>