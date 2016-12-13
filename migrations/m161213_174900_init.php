<?php


class m161213_174900_init extends \atans\history\migrations\Migration
{
    public function up()
    {
        $tableName = \atans\hisotry\models\History::tableName();

        $this->createTable($tableName, [
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

        $this->createIndex('table', $tableName, ['table']);
        $this->createIndex('event', $tableName, ['event']);
        $this->createIndex('scenario', $tableName, ['scenario']);
        $this->createIndex('key', $tableName, ['key']);
        $this->createIndex('created_by', $tableName, ['created_by']);
    }

    public function down()
    {
        $this->dropTable(\atans\hisotry\models\History::tableName());
    }
}