<?php
declare(strict_types=1);

namespace common\models;

use DateTimeImmutable;

/**
 * This is the ActiveQuery class for [[Invoice]].
 *
 * @see Invoice
 */
class InvoiceQuery extends \yii\db\ActiveQuery
{
    /**
     * @param int $userId
     *
     * @return $this
     */
    public function byUserId(int $userId) : self
    {
        return $this->andWhere([
            '[[user_id]]' => $userId,
        ]);
    }

    /**
     * @param string $productTitle
     *
     * @return $this
     */
    public function filterProduct(string $productTitle) : self
    {
        return $this->joinWith([
            'product' => function (ProductQuery $productQuery) use ($productTitle) {
                $productQuery->filterTitle($productTitle);
            },
        ]);
    }

    /**
     * @param string $username
     *
     * @return $this
     */
    public function filterUser(string $username) : self
    {
        return $this->joinWith([
            'user' => function (UserQuery $userQuery) use ($username) {
                $userQuery->filterUsername($username);
            },
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
            '[[invoice.currency]]',
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
            'invoice.created_at',
            $dateTimeBegin->getTimestamp(),
            $dateTimeEnd->getTimestamp(),
        ]);
    }

    /**
     * {@inheritdoc}
     * @return Invoice[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Invoice|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
