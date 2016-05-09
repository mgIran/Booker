<?
/* @var $this SiteController */
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
            <form>
                <div class="input-field">
                    <input type="text" id="target">
                    <label for="target">شهر مقصد</label>
                </div>
                <div class="input-field">
                    <input type="text" id="enter-date">
                    <label for="enter-date">تاریخ ورود</label>
                </div>
                <div class="input-field">
                    <input type="text" id="out-date">
                    <label for="out-date">تاریخ خروج</label>
                </div>
                <div class="input-field select-container">
                    <select>
                        <option value="" disabled selected>تعداد اتاق را انتخاب کنید</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <div class="input-field">
                            <input type="text" id="adult-count">
                            <label for="adult-count">تعداد بزرگسال</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <div class="input-field">
                            <input type="text" id="kid-count">
                            <label for="kid-count">تعداد خردسال</label>
                        </div>
                    </div>
                </div>
                <div class="buttons-block">
                    <button class="btn waves-effect waves-light col-md-12 red lighten-1" type="submit" name="action">جستجو</button>
                </div>
            </form>
        </div>
        <ul class="nav nav-pills">
            <li role="presentation"><a href="<?php echo $this->createUrl('/login');?>">ورود</a href=""></li>
            <li role="presentation"><a href="<?php echo $this->createUrl('/register');?>">ثبت نام</a></li>
            <li role="presentation"><a href="<?php echo $this->createUrl('/terms');?>">قوانین و مقررات</a></li>
            <li role="presentation"><a href="<?php echo $this->createUrl('/help');?>">راهنما</a></li>
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
</div>