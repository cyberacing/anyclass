<?php
declare(strict_types=1);

use yii\db\Migration;

/**
 * Class m210604_190600_invoice
 */
class m210604_190600_invoice extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() : bool
    {
        $this->createTable('{{%invoice}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull()->comment('Продукт'),
            'user_id' => $this->integer()->notNull()->comment('Пользователь'),
            'amount' => $this->float()->comment('Сумма чека'),
            'currency' => $this->string(3)->notNull()->comment('Валюта чека'),
            'created_at' => $this->integer()->notNull()->comment('Создано'),
            'updated_at' => $this->integer()->notNull()->comment('Обновлено'),
        ]);

        $this->addForeignKey('FK-invoice-product', '{{%invoice}}', 'product_id', '{{%product}}', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('FK-invoice-user', '{{%invoice}}', 'user_id', '{{%user}}', 'id', 'RESTRICT', 'CASCADE');

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() : bool
    {
        $this->dropTable('{{%invoice}}');

        return true;
    }
}
