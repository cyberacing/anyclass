<?php
declare(strict_types=1);

namespace common\models;

use app\helpers\sanitizers\DataSanitizer;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Json;

/**
 * This is the model class for table "payment_system".
 *
 * @property int $id
 * @property string $title Название
 * @property bool|null $active Активность
 * @property string|null $currencies Список валют
 * @property string $created_at Создано
 * @property string $updated_at Обновлено
 */
class PaymentSystem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_system';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['active'], 'boolean'],
            [['currencies', 'created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'active' => 'Активность',
            'currencies' => 'Список валют',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return array
     */
    public function behaviors() : array
    {
        return [
            TimestampBehavior::class => [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return bool
     */
    public function load($data, $formName = null) : bool
    {
        if (parent::load($data, $formName)) {
            if (!empty($this->currencies)) {
                $this->currencies = Json::encode($this->currencies);
            }

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     * @return PaymentSystemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PaymentSystemQuery(get_called_class());
    }
}
