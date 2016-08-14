<?php

use yii\db\Migration;

class m160811_034158_create_setting extends Migration
{
    const TABLE_NAME = 'setting';

    public function up()
    {
        $this->createTable(self::TABLE_NAME, [
            'setting_id' => $this->primaryKey(),
            'name'       => $this->string()->notNull(),
            'value'      => $this->string(),
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
