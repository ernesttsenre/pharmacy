<?php

class m160923_062732_additionalTables extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('product', [
            'id' => 'pk',
            'title' => 'varchar(256) not null',
            'created' => 'datetime not null'
        ]);

        $this->addColumn('exist', 'product_id', 'int not null');
        $this->addForeignKey('exist:product_id-product:id', 'exist', 'product_id', 'product', 'id', 'CASCADE',
            'CASCADE');

        $this->addColumn('file_exist', 'product', 'varchar(256) not null');
    }
}