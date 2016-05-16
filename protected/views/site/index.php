<?
/* @var $this SiteController */
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.validate.min.js');
?>
<div class="container main-page">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-lg-offset-3 col-md-offset-3 col-sm-offset-3 search-box">
        <div class="logo">
            <div class="icon"></div>
            <h1>بوکر</h1>
            <h2>رزرو آنلاین هتل های خارجی</h2>
        </div>
        <div class="box">
            <h3>جستجوی هتل</h3>
            <div class="row">
                <ul class="tabs">
                    <li class="tab col-lg-4 col-md-4 col-sm-4 col-xs-12"><a id="destination-container-trigger" class="active" href="#destination-container">1. مقصد</a></li>
                    <li class="tab col-lg-4 col-md-4 col-sm-4 col-xs-12 disabled"><a id="dates-trigger" href="#dates">2. تاریخ</a></li>
                    <li class="tab col-lg-4 col-md-4 col-sm-4 col-xs-12 disabled"><a  id="rooms-trigger"href="#rooms">3. اتاق</a></li>
                </ul>
            </div>
            <form id="search-form">
                <div id="destination-container" class="tab-content">
                    <div class="input-field">
                        <input type="text" id="destination" required>
                        <label for="destination">شهر مقصد *</label>
                    </div>
                </div>
                <div id="dates" class="tab-content">
                    <div class="input-field">
                        <?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
                            'id'=>'enter-date',
                            'options'=>array(
                                'format'=>'DD MMMM YYYY',
                                'onShow'=>"js:function(){
                                    $('.datepicker-plot-area').width($('#enter-date').width()).
                                        css('top',(($(window).height()/2)-($('.datepicker-plot-area').height()/2)));
                                    $('.datepicker-overlay').removeClass('hidden');
                                }",
                                'onHide'=>"js:function(){
                                    $('.datepicker-overlay').addClass('hidden');
                                }"
                            )
                        ));?>
                        <label for="enter-date">تاریخ ورود</label>
                    </div>
                    <div class="input-field out-date-container">
                        <?php $this->widget('application.extensions.PDatePicker.PDatePicker', array(
                            'id'=>'out-date',
                            'options'=>array(
                                'format'=>'DD MMMM YYYY',
                                'onShow'=>"js:function(){
                                    $('.datepicker-plot-area').width($('#out-date').width()).
                                        css('top',(($(window).height()/2)-($('.datepicker-plot-area').height()/2)));
                                    $('.datepicker-overlay').removeClass('hidden');
                                }",
                                'onHide'=>"js:function(){
                                    $('.datepicker-overlay').addClass('hidden');
                                }"
                            )
                        ));?>
                        <label for="out-date">تاریخ خروج</label>
                    </div>
                </div>
                <div id="rooms" class="tab-content">
                    <div class="input-field select-container">
                        <select id="rooms-count">
                            <option value="" disabled selected>تعداد اتاق را انتخاب کنید</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                </div>
                <div class="buttons-block">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <button class="btn waves-effect waves-light red lighten-1 col-md-12 disabled" type="button" id="previous">قبلی</button>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <?php echo CHtml::hiddenField('active-step', 'destination-container');?>
                            <button class="btn waves-effect waves-light green lighten-1 col-md-12" type="button" id="next">ادامه</button>
                            <button class="btn waves-effect waves-light green lighten-1 col-md-12 hidden" type="submit" id="search">جستجو</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <ul class="nav nav-pills">
            <li role="presentation"><a href="<?php echo $this->createUrl('/login');?>">ورود</a href=""></li>
            <li role="presentation"><a href="<?php echo $this->createUrl('/register');?>">ثبت نام</a></li>
            <li role="presentation"><a href="<?php echo $this->createUrl('/terms');?>">قوانین و مقررات</a></li>
            <li role="presentation"><a href="<?php echo $this->createUrl('/help');?>">راهنما</a></li>
            <li role="presentation"><a href="<?php echo $this->createUrl('/about');?>">درباره ما</a></li>
            <li role="presentation"><a href="<?php echo $this->createUrl('/contactUs');?>">تماس با ما</a></li>
        </ul>
    </div>
    <div class="slider">
        <ul class="cb-slideshow">
            <li><span class="slide-item" style="background: url('uploads/s1.jpg') no-repeat center / cover;"></span></li>
            <li><span class="slide-item" style="background: url('uploads/s2.jpg') no-repeat center / cover;"></span></li>
            <li><span class="slide-item" style="background: url('uploads/s3.jpg') no-repeat center / cover;"></span></li>
            <li><span class="slide-item" style="background: url('uploads/s4.jpg') no-repeat center / cover;"></span></li>
        </ul>
    </div>
    <div class="licences">
        <img id='rgvjfukzwlaooeuksizp' style='cursor:pointer' onclick='window.open("http://logo.samandehi.ir/Verify.aspx?id=36489&p=xlaogvkaaodsmcsipfvl", "Popup","toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")' alt='logo-samandehi' src='http://logo.samandehi.ir/logo.aspx?id=36489&p=qftiwlbqshwlaqgwbsiy'/>
    </div>
</div>
<div class="datepicker-overlay hidden"></div>
<div id="rooms-modal" class="modal bottom-sheet">
    <div class="modal-content">
        <h4>اتاق ها</h4>
        <div class="row"></div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="waves-effect waves-green btn-flat">ثبت</a>
        <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">انصراف</a>
    </div>
</div>