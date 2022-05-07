<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;


class UserMigration extends AbstractMigration
{
   //migration que cria tabela de usuários no banco
    public function change()
    {
        $table = $this->table("users");
          $table->addColumn("email", MysqlAdapter::PHINX_TYPE_STRING)
          ->addColumn("name", MysqlAdapter::PHINX_TYPE_STRING)
          ->addColumn("password", MysqlAdapter::PHINX_TYPE_STRING)
          ->addTimestamps()
          ->create();
            
    }
}