<?php
class PDatePicker extends CInputWidget
{
    protected $publishedAssetsPath;
    public $model;
    public $id;
    public $options;
    public $htmlOptions;
    public $variableName;
    public $inTimeout = false;
    public $scriptPosition = CClientScript::POS_READY;

    public function init()
    {
        if (Yii::getPathOfAlias('PDatePicker') === false) Yii::setPathOfAlias('PDatePicker', realpath(dirname(__FILE__) . '/..'));
        $cs = Yii::app()->clientScript;
        $cs->registerCssFile($this->getAssetsUrl() . '/css/persian-datepicker-0.4.5.min.css');
        $cs->registerScriptFile($this->getAssetsUrl() . '/js/moment.min.js');
        $cs->registerScriptFile($this->getAssetsUrl() . '/js/moment-jalaali.js');
        $cs->registerScriptFile($this->getAssetsUrl() . '/js/persian-date.js');
        $cs->registerScriptFile($this->getAssetsUrl() . '/js/persian-datepicker-0.4.5.js');

        if (!isset($this->options['altField'])) {
            $this->options['altField'] = '#' . $this->id . '_altField';
            $this->options['altFormat'] = 'X';
        }

        $defaultJs = '';
        $defaultValue = null;
        if (isset($this->options['default'])) {
            $defaultJs = "var selectedDate=persianDate.unix(" . CHtml::encode($this->options['default']) . ");";
            $defaultJs .= "$('#$this->id').pDatepicker('setDate', [selectedDate.pDate.year, selectedDate.pDate.month, selectedDate.pDate.date])";
            $defaultValue = $this->options['default'];
            unset($this->options['default']);
        }

        $js = "$this->variableName = $('#$this->id').persianDatepicker(" . CJavaScript::encode($this->options) . ");";

        if ($this->scriptPosition == CClientScript::POS_HEAD)
            $js = 'jQuery(function($) {' . $js . '});';

        $cs->registerScript(__CLASS__ . $this->id, $js, $this->scriptPosition);
        $cs->registerScript(__CLASS__ . $this->id . '-default-value', $defaultJs, CClientScript::POS_LOAD);

        echo CHtml::textField($this->id, '', $this->htmlOptions);
        echo CHtml::hiddenField($this->id . '_altField', $defaultValue, array('unixDate' => is_null($defaultValue) ? null : $defaultValue * 1000));
    }

    public function getAssetsUrl()
    {
        if (!isset($this->publishedAssetsPath)) {
            $assetsSourcePath = Yii::getPathOfAlias('ext.PDatePicker.assets');

            $publishedAssetsPath = Yii::app()->assetManager->publish($assetsSourcePath, false, -1);

            return $this->publishedAssetsPath = $publishedAssetsPath;
        } else return $this->publishedAssetsPath;
    }
}