<?php

use yii\db\Migration;

class m160804_174845_create_category extends Migration
{
    const TABLE_NAME = 'category';

    public function up()
    {
        $this->createTable(self::TABLE_NAME, [
            'category_id' => $this->primaryKey(),
            'name'        => $this->string()->notNull(),
        ]);

        $this->createIndex('idx_name', self::TABLE_NAME, 'name', true);
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
