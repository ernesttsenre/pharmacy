<?php

class m160923_044434_createTables extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('distributor', [
            'id' => 'pk',
            'title' => 'varchar(256) not null',
            'created' => 'datetime not null',
        ]);

        $this->createTable('pharmacy', [
            'id' => 'pk',
            'title' => 'varchar(256) not null',
            'created' => 'datetime not null',
        ]);

        $this->createTable('exist', [
            'id' => 'pk',
            'distributor_id' => 'int not null',
            'pharmacy_id' => 'int not null',
            'count' => 'decimal(10,2) not null',
            'created' => 'datetime not null',
        ]);

        $this->addForeignKey('exist:distributor_id-distributor:id', 'exist', 'distributor_id', 'distributor', 'id',
            'CASCADE', 'CASCADE');

        $this->addForeignKey('exist:pharmacy_id-pharmacy:id', 'exist', 'pharmacy_id', 'pharmacy', 'id',
            'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('exist:pharmacy_id-pharmacy:id', 'exist');
        $this->dropForeignKey('exist:distributor_id-distributor:id', 'exist');

        $this->dropTable('exist');
        $this->dropTable('pharmacy');
        $this->dropTable('distributor');
    }
}