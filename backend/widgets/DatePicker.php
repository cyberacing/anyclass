<?php
declare(strict_types=1);

namespace backend\widgets;

use Yii;
use yii\base\InvalidArgumentException;
use yii\helpers\FormatConverter;
use yii\helpers\Html;

/**
 * Class DatePicker
 *
 * @package backend\widgets
 */
class DatePicker extends \kartik\date\DatePicker
{
    /** @var string|null */
    public $saveDateFormat = null;

    /** @var bool */
    public $removeButton = false;
    /** @var string */
    public $pickerButton = '<span class="input-group-addon kv-date-calendar" title="Выбрать дату"><i class="fa fa-calendar"></i></span>';
    /** @var int */
    public $type = self::TYPE_INPUT;

    /** @var string */
    private string $savedValueInputID = '';
    /** @var string|null */
    private ?string $attributeValue = null;

    /**
     * DatePicker constructor.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        $defaultOptions = [
            'type' => $this->type,
            'convertFormat' => true,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => Yii::$app->formatter->dateFormat,
                'todayHighlight' => true,
            ],
            'saveDateFormat' => Yii::$app->formatter->dateFormat,
        ];
        $config = array_replace_recursive($defaultOptions, $config);

        parent::__construct($config);
    }

    /**
     * @inheritDoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if ($this->hasModel()) {
            $model = $this->model;
            $attribute = $this->attribute;
            $value = $model->$attribute;

            $this->model = null;
            $this->attribute = null;
            $this->name = Html::getInputName($model, $attribute);

            if ($value !== null && $value !== '') {
                $this->attributeValue = (string)$value;
                try {
                    $this->value = Yii::$app->formatter->asDatetime($value, $this->pluginOptions['format']);
                } catch (InvalidArgumentException $e) {
                    $this->value = null;
                }
            }
        }

        parent::init();
    }

    /**
     * @inheritDoc
     * @throws \yii\base\InvalidConfigException
     */
    protected function parseMarkup($input)
    {
        $res = parent::parseMarkup($input);

        $res .= $this->renderSavedValueInput();
        $this->registerScript();

        return $res;
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    protected function renderSavedValueInput() : string
    {
        $value = $this->attributeValue;

        if ($value !== null && $value !== '') {
            // format value according to saveDateFormat
            try {
                $value = Yii::$app->formatter->asDate($value, $this->saveDateFormat);
            } catch (InvalidArgumentException $e) {
                // ignore exception and keep original value if it is not a valid date
            }
        }

        $this->savedValueInputID = $this->options['id'] . '-saved-value';

        $options = $this->options;
        $options['id'] = $this->savedValueInputID;
        $options['value'] = $value;

        // render hidden input
        if ($this->hasModel()) {
            $contents = Html::activeHiddenInput($this->model, $this->attribute, $options);
        } else {
            $contents = Html::hiddenInput($this->name, $value, $options);
        }

        return $contents;
    }

    /**
     * @return void
     */
    protected function registerScript() : void
    {
        $format = $this->saveDateFormat;
        $format = strncmp($format, 'php:', 4) === 0 ? substr($format, 4) :
            FormatConverter::convertDateIcuToPhp($format, $this->type);
        $saveDateFormatJs = static::convertDateFormat($format);

        $containerID = $this->options['data-datepicker-source'];
        $hiddenInputID = $this->savedValueInputID;
        $script = "
            $('#{$containerID}').on('changeDate', function(e) {
                var savedValue = e.format(0, '{$saveDateFormatJs}');
                var oldValue = $('#{$hiddenInputID}').val();
                if(oldValue !== savedValue) {
                    $('#{$hiddenInputID}').val(savedValue).trigger('change');
                }
            }).on('clearDate', function(e) {
                var savedValue = e.format(0, '{$saveDateFormatJs}');
                var oldValue = $('#{$hiddenInputID}').val();
                if(oldValue !== savedValue) {
                    $('#{$hiddenInputID}').val(savedValue).trigger('change');
                }
            }).on('keyup', function() {
                $('#{$containerID}').data('datepicker')._trigger('changeDate');
            });

            $('#{$containerID}').data('datepicker').update();
            $('#{$containerID}').data('datepicker')._trigger('changeDate');
        ";
        $view = $this->getView();
        $view->registerJs($script);
    }
}
