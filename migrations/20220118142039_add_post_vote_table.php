<?php

use Phinx\Migration\AbstractMigration;

class AddPostVoteTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     **/
    public function change()
    {
        $this->table('post_votes' /*, ['id' => false, 'primary_key' => 'id']*/)
            ->addColumn('post_id', 'integer', ['null' => false])
            ->addColumn('user_id', 'integer', ['null' => false])
            ->addColumn('vote', 'integer', ['null' => false])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated', 'timestamp', ['null' => false,
                'default' => 'CURRENT_TIMESTAMP',
                'update' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['post_id', 'user_id'], ['unique' => true /*, 'name' => 'id'*/])
            ->addIndex(['user_id'])
            ->addIndex(['post_id'])
            ->addIndex(['created'])
            ->addIndex(['updated'])
            ->addForeignKey('user_id', 'users', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('post_id', 'posts', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->create();
    }
}
