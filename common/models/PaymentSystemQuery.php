<?php
declare(strict_types=1);

namespace common\models;

use DateTimeImmutable;

/**
 * This is the ActiveQuery class for [[PaymentSystem]].
 *
 * @see PaymentSystem
 */
class PaymentSystemQuery extends \yii\db\ActiveQuery
{
    /**
     * @param bool $active
     *
     * @return $this
     */
    public function active(bool $active) : self
    {
        return $this->andWhere([
            '[[active]]' => $active,
        ]);
    }

    /**
     * @param string $date
     *
     * @return $this
     * @throws \Exception
     */
    public function byCreatedAt(string $date) : self
    {
        $dateTime = new DateTimeImmutable($date);
        $dateTimeBegin = $dateTime->setTime(0, 0);
        $dateTimeEnd = $dateTime->setTime(23, 59, 59);
        return $this->andWhere([
            'between',
            'created_at',
            $dateTimeBegin->getTimestamp(),
            $dateTimeEnd->getTimestamp(),
        ]);
    }

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
