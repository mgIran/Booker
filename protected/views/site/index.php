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
            <li role="presentation"><a class="modal-trigger waves-effect waves-light" href="#login-modal">ورود</a></li>
            <li role="presentation"><a href="<?php echo $this->createUrl('/register');?>">ثبت نام</a></li>
            <li role="presentation"><a href="#">راهنما</a></li>
            <li role="presentation"><a href="#">تماس با ما</a></li>
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
<div id="login-modal" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4 class="yekan-text">ورود</h4>
        <form>
            <div class="input-field">
                <input type="text" id="username">
                <label for="username">پست الکترونیکی</label>
            </div>
            <div class="input-field">
                <input type="password" id="password">
                <label for="password">کلمه عبور</label>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">ورود</a>
        <a class="modal-action modal-close waves-effect waves-red btn-flat " href="#!">انصراف</a>
    </div>
</div>