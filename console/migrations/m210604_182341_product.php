<?php
declare(strict_types=1);

use yii\db\Migration;

/**
 * Class m210604_182341_product
 */
class m210604_182341_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() : bool
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->comment('Название'),
            'price' => $this->float()->comment('Цена'),
            'currency' => $this->string(3)->notNull()->comment('Валюта'),
            'created_at' => $this->dateTime()->notNull()->comment('Создано'),
            'updated_at' => $this->dateTime()->notNull()->comment('Обновлено'),
        ]);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() : bool
    {
        $this->dropTable('{{%product}}');

        return true;
    }
}
