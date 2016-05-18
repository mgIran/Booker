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
            <form id="search-form">
                <div class="input-field">
                    <input type="text" id="destination" required>
                    <label for="destination">شهر مقصد *</label>
                </div>
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
                <div class="input-field">
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
                <div class="input-field">
                    <select id="rooms-count">
                        <option value="" disabled selected>تعداد اتاق را انتخاب کنید</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                <div class="room-info row"></div>
                <div class="buttons-block">
                    <button class="btn waves-effect waves-light green lighten-1 col-md-12" type="submit" id="search">جستجو</button>
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