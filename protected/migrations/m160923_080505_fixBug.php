<?php

class m160923_080505_fixBug extends CDbMigration
{
	public function safeUp()
	{
	    $this->addColumn('distributor', 'converter', 'varchar(128) not null');

        $this->update('distributor', [
            'converter' => 'Distributor1Converter',
        ], 'id = :id', ['id' => 1]);

        $this->update('distributor', [
            'converter' => 'Distributor2Converter',
        ], 'id = :id', ['id' => 2]);
	}
}