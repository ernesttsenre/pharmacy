<?php

class m160923_063342_fixFileExist extends CDbMigration
{
	public function safeUp()
	{
	    $this->dropColumn('file_exist', 'distributor');
	}
}