<?php

use yii\db\Migration;

class m160806_150930_create_expense extends Migration
{
    const TABLE_NAME = 'expense';

    public function up()
    {
        $this->createTable(self::TABLE_NAME, [
            'expense_id'  => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'value'       => $this->integer(),
            'comment'     => $this->text(),
            'date'        => $this->date(),
        ]);
    }

    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
