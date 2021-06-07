<?php
declare(strict_types=1);

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class UserQuery
 *
 * @package common\models
 * @see \common\models\User
 */
class UserQuery extends ActiveQuery
{
    /**
     * @param string|null $username
     *
     * @return $this
     */
    public function filterUsername(?string $username) : self
    {
        return $this->andFilterWhere([
            'like',
            '[[username]]',
            $username,
        ]);
    }

    /**
     * {@inheritdoc}
     * @return User[]|array
     */
    public function all($db = null) : array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return User|array|null
     */
    public function one($db = null)
    {
        $this->limit(1);

        return parent::one($db);
    }
}
