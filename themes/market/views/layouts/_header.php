<header class="col-lg-12 col-md-12 hidden-sm hidden-xs">
    <div class="logo-box col-xs-12">
        <a href="<?= Yii::app()->createAbsoluteUrl('//'); ?>"></a>
        <h1><?= $this->siteName ?></h1>
        <h2><?= $this->pageTitle ?></h2>
        <img class="logo" src="<?= Yii::app()->createAbsoluteUrl('themes/market/images/logo.png'); ?>" alt="HyperApps" >
    </div>
    <div class="right-header col-xs-12">
        <div class="search-box col-xs-12">
            <?
            $form = $this->beginWidget('CActiveForm',array(
                'id' => 'header-serach-form',
                'action' => array('/site/search'),
                'htmlOptions' => array(
                    'class' => 'col-lg-9 col-md-9 col-sm-9 col-xs-6'
                )
            ));
            ?>
                <div class="form-group pull-left col-lg-10 col-md-10 col-sm-12 col-xs-12">
                    <?= CHtml::textField('searchText','',array('placeholder' => 'جستجو کنید ...')); ?>
                    <span class="add-in svg svg-search"></span>
                </div>
            <?
            $this->endWidget();
            ?>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                <?
                if(!Yii::app()->user->isGuest && Yii::app()->user->type == 'user') {
                    ?>
                    <div class="user-section">
                        <div class="avatar">
                            <span class="icon icon-user"></span>
                            <div class="tri-1"></div>
                            <div class="tri-2"></div>
                        </div>
                        <div class="user-menu">
                            <div class="inner">
                                <div class="avatar">
                                    <span class="icon icon-user"></span>
                                </div>
                                <div class="user-detail">
                                    <span class="name"><?= $this->userDetails->getShowName(); ?></span>
                                    <span class="type"><?= $this->userDetails->roleLabels[Yii::app()->user->roles] ?></span>
                                    <span class="type">اعتبار : <?= Controller::parseNumbers(number_format($this->userDetails->credit, 0)) ?> تومان</span>
                                </div>
                                <footer>
                                    <a class="btn btn-default" href="<?= Yii::app()->createUrl('/dashboard') ?>">پنل کاربری</a>
                                    <?
                                    if(Yii::app()->user->roles == 'developer'):
                                    ?>
                                    <a class="btn btn-default" href="<?= Yii::app()->createUrl('/developers/panel') ?>">پنل توسعه دهندگان</a>
                                    <?
                                    endif;
                                    ?>
                                    <a class="btn btn-danger pull-left" href="<?= Yii::app()->createUrl('logout') ?>">خروج</a>
                                </footer>
                            </div>
                        </div>
                    </div>
                    <?
                }
                else{
                    ?>
                    <div class="header-links pull-left">
                        <a href="<?= Yii::app()->createUrl('/login') ?>">
                            ورود
                        </a>
                        <a href="<?= Yii::app()->createUrl('/register') ?>">
                            ثبت نام
                        </a>
                    </div>
                <?
                }
                ?>
            </div>
        </div>
    </div>
</header>