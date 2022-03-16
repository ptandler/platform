<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class AddFormsIconUrl extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     */
    public function change()
    {
        $this->table('forms')
            ->addColumn('icon_url', 'text', ['null' => true])
            ->update();
    }
}
