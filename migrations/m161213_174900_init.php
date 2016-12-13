<?php


class m161213_174900_init extends \atans\history\migrations\Migration
{
    public function up()
    {
        $this->createTable('{{%activerecord_history}}', [
            'id'         => $this->primaryKey(),
            'table'      => $this->string('50')->notNull(),
            'event'      => $this->string('50')->notNull(),
            'scenario'   => $this->string('50')->notNull(),
            'key'        => $this->string('32')->notNull(),
            'data'       => $this->text()->notNull(),
            'ip'         => $this->string(42)->null(),
            'created_at' => $this->dateTime()->notNull(),
        ], $this->tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%activerecord_history}}');
    }
}