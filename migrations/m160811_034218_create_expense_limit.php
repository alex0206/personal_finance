<?php

use yii\db\Migration;

class m160811_034218_create_expense_limit extends Migration
{
    const TABLE_NAME = 'expense_limit';

    public function up()
    {
        $this->createTable(self::TABLE_NAME, [
            'limit_id'     => $this->primaryKey(),
            'sum'          => $this->integer()->notNull(),
            'created_date' => $this->date(),
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
