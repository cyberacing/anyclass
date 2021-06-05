<?php
declare(strict_types=1);

namespace common\models;

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
