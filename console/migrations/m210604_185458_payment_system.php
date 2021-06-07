<?php
declare(strict_types=1);

use yii\db\Migration;

/**
 * Class m210604_185458_payment_system
 */
class m210604_185458_payment_system extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \yii\base\Exception
     */
    public function safeUp() : bool
    {
        $this->createTable('{{%payment_system}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->comment('Название'),
            'active' => $this->boolean()->defaultValue(false)->comment('Активность'),
            'currencies' => $this->json()->comment('Список валют'),
            'created_at' => $this->integer()->notNull()->comment('Создано'),
            'updated_at' => $this->integer()->notNull()->comment('Обновлено'),
        ]);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() : bool
    {
        $this->dropTable('{{%payment_system}}');

        return true;
    }
}
