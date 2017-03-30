<?php

class m161213_174900_init extends \atans\history\migrations\Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableName = \atans\history\models\History::tableName();

        $this->createTable($tableName, [
            'id'             => $this->primaryKey(),
            'user_id'          => $this->integer()->null(),
            'table'          => $this->string(50)->notNull(),
            'event'          => $this->string(50)->notNull(),
            'model_scenario' => $this->string(50)->notNull(),
            'key'            => $this->string(32)->notNull(),
            'data'           => $this->text()->notNull(),
            'ip'             => $this->string(42)->null(),
            'created_by'     => $this->string(42)->null(),
            'created_at'     => $this->dateTime()->notNull(),
        ], $this->tableOptions);

        $this->createIndex('user_id', $tableName, ['user_id']);
        $this->createIndex('table', $tableName, ['table']);
        $this->createIndex('event', $tableName, ['event']);
        $this->createIndex('model_scenario', $tableName, ['model_scenario']);
        $this->createIndex('key', $tableName, ['key']);
        $this->createIndex('created_by', $tableName, ['created_by']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(\atans\history\models\History::tableName());
    }
}
