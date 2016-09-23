<?php

class m160923_054024_createFileTables extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('file', [
            'id' => 'pk',
            'distributor_id' => 'int not null',
            'path' => 'varchar(256) not null',
            'status' => 'enum("process", "complete") not null default "process"',
            'created' => 'datetime not null',
        ]);
        $this->addForeignKey('file:distributor_id-distributor:id', 'file', 'distributor_id', 'distributor', 'id',
            'CASCADE', 'CASCADE');

        $this->createTable('file_exist', [
            'id' => 'pk',
            'file_id' => 'int not null',
            'distributor' => 'varchar(256) not null',
            'pharmacy' => 'varchar(256) not null',
            'count' => 'decimal(10,2) not null',
            'created' => 'datetime not null',
        ]);
        $this->addForeignKey('file_exist:file_id-file:id', 'file_exist', 'file_id', 'file', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('file_exist:file_id-file:id', 'file_exist');
        $this->dropTable('file_exist');

        $this->dropForeignKey('file:distributor_id-distributor:id', 'file');
        $this->dropTable('file');
    }
}