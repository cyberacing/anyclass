<?php
declare(strict_types=1);

namespace common\models;

/**
 * This is the ActiveQuery class for [[PaymentSystem]].
 *
 * @see PaymentSystem
 */
class PaymentSystemQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return PaymentSystem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PaymentSystem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
