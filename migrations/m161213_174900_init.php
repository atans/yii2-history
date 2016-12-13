<?php


class m161213_174900_init extends \atans\history\migrations\Migration
{
    public function up()
    {
        $this->createTable('{{%activerecord_history}}', [
            'id'         => $this->primaryKey(),
            'table'      => $this->string(50)->notNull(),
            'event'      => $this->string(50)->notNull(),
            'scenario'   => $this->string(50)->notNull(),
            'key'        => $this->string(32)->notNull(),
            'data'       => $this->text()->notNull(),
            'ip'         => $this->string(42)->null(),
            'created_by' => $this->string(42)->null(),
            'created_at' => $this->dateTime()->notNull(),
        ], $this->tableOptions);

        $this->createIndex('table', '{{%activerecord_history}}', ['table']);
        $this->createIndex('event', '{{%activerecord_history}}', ['event']);
        $this->createIndex('scenario', '{{%activerecord_history}}', ['scenario']);
        $this->createIndex('key', '{{%activerecord_history}}', ['key']);
        $this->createIndex('created_by', '{{%activerecord_history}}', ['created_by']);
    }

    public function down()
    {
        $this->dropTable('{{%activerecord_history}}');
    }
}