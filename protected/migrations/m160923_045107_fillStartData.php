<?php

class m160923_045107_fillStartData extends CDbMigration
{
	public function safeUp()
	{
	    $this->insert('distributor', [
	        'id' => 1,
            'title' => 'Дистрибьютор 1',
            'created' => date('Y-m-d H:i:s'),
        ]);

        $this->insert('distributor', [
            'id' => 2,
            'title' => 'Дистрибьютор 2',
            'created' => date('Y-m-d H:i:s'),
        ]);
	}

	public function safeDown()
	{
	    $this->truncateTable('distributor');
	}
}