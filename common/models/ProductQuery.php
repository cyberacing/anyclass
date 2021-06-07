<?php
declare(strict_types=1);

namespace common\models;

use DateTimeImmutable;

/**
 * This is the ActiveQuery class for [[Product]].
 *
 * @see Product
 */
class ProductQuery extends \yii\db\ActiveQuery
{
    /**
     * @param string|null $title
     *
     * @return $this
     */
    public function filterTitle(?string $title) : self
    {
        return $this->andFilterWhere([
            'like',
            '[[title]]',
            $title,
        ]);
    }

    /**
     * @param string|null $currency
     *
     * @return $this
     */
    public function filterCurrency(?string $currency) : self
    {
        return $this->andFilterWhere([
            'like',
            '[[currency]]',
            $currency,
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
     * @return Product[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Product|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
