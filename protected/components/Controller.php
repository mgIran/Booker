<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    /**
     * @var string the default layout for the controller views. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public $description;
    public $keywords;
    public $siteName;
    public $pageTitle;
    public $pageName;

    public function beforeRender($view){
        $this->description = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "site_description"')
            ->queryScalar();
        $this->keywords = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "keywords"')
            ->queryScalar();
        $this->siteName = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "site_title"')
            ->queryScalar();
        $this->pageTitle = Yii::app()->db->createCommand()
            ->select('value')
            ->from('ym_site_setting')
            ->where('name = "default_title"')
            ->queryScalar();
        return true;
    }

    public static function createAdminMenu()
    {
        if(Yii::app()->user->type === 'admin')
            return array(
                array(
                    'label' => 'پیشخوان' ,
                    'url' => array('/admins/dashboard')
                ) ,
                array(
                    'label' => 'نقشه گوگل<span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'مدیریت' ,'url' => Yii::app()->createUrl('/map/manage/update')) ,
                    )
                ) ,
                array(
                    'label' => 'شهرها<span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'مدیریت شهرها' ,'url' => Yii::app()->createUrl('/cityNames/manage/admin')) ,
                        array('label' => 'افزودن شهر جدید' ,'url' => Yii::app()->createUrl('/cityNames/manage/create')) ,
                    )
                ) ,
                array(
                    'label' => 'صفحات متنی' ,
                    'url' => Yii::app()->createUrl('/pages/manage/admin/?slug=base'),
                ) ,
                array(
                    'label' => 'مدیران <span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'مدیریت' ,'url' => Yii::app()->createUrl('/admins/manage')) ,
                        array('label' => 'افزودن' ,'url' => Yii::app()->createUrl('/admins/manage/create')) ,
                    )
                ) ,
                array(
                    'label' => 'کاربران <span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'مدیریت' ,'url' => Yii::app()->createUrl('/users/manage')) ,
                    )
                ) ,
                array(
                    'label' => 'تنظیمات<span class="caret"></span>' ,
                    'url' => '#' ,
                    'itemOptions' => array('class' => 'dropdown' ,'tabindex' => "-1") ,
                    'linkOptions' => array('class' => 'dropdown-toggle' ,'data-toggle' => "dropdown") ,
                    'items' => array(
                        array('label' => 'عمومی' ,'url' => Yii::app()->createUrl('/setting/siteSettingManage/changeSetting')) ,
                    )
                ) ,
                array(
                    'label' => 'ورود' ,
                    'url' => array('/admins/login') ,
                    'visible' => Yii::app()->user->isGuest
                ) ,
                array(
                    'label' => 'خروج' ,
                    'url' => array('/admins/login/logout') ,
                    'visible' => !Yii::app()->user->isGuest) ,
            );
        else
            return array();
    }

    /**
     * @param $model
     * @return string
     */
    public function implodeErrors($model)
    {
        $errors = '';
        foreach($model->getErrors() as $err){
            foreach($err as $error)
                $errors .= "<li>$error</li>";
        }
        return $errors;
    }

    public static function generateRandomString($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for($i = 0;$i < $length;$i++){
            $randomString .= $characters[rand(0 ,$charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Converts latin numbers to farsi script
     */
    public static function parseNumbers($matches)
    {
        $farsi_array = array('۰' ,'۱' ,'۲' ,'۳' ,'۴' ,'۵' ,'۶' ,'۷' ,'۸' ,'۹');
        $english_array = array('0' ,'1' ,'2' ,'3' ,'4' ,'5' ,'6' ,'7' ,'8' ,'9');

        return str_replace($english_array ,$farsi_array ,$matches);
    }

    public static function allCategories()
    {
        Yii::import('advertises.models.AdvertiseCategories');
        return AdvertiseCategories::model()->findAll('parent IS NULL order by name ASC');
    }

    public static function fileSize($file){
        if(file_exists($file)) {
            $size = filesize($file);
            if($size < 1024)
                return $size.' Byte';
            elseif($size < 1024*1024){
                $size = (float)$size/1024;
                return number_format($size,1). ' KB';
            }
            elseif($size < 1024*1024*1024){
                $size = (float)$size/(1024*1024);
                return number_format($size,1). ' MB';
            }else
            {
                $size = (float)$size/(1024*1024*1024);
                return number_format($size,1). ' MB';
            }
        }
        return 0;
    }

    public function getFixedPrice($price)
    {
        Yii::app()->getModule('setting');
        $commission = SiteSetting::model()->findByAttributes(array('name' => 'commission'));
        $commission = $commission->value;
        $tax = SiteSetting::model()->findByAttributes(array('name' => 'tax'));
        $tax = $tax->value;

        $price=$price*5000;

        $commission = ($price * $commission) / 100;
        $tax = ($price * $tax) / 100;
        return $price + $commission + $tax;
    }
}