<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBlog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'username' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'level' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
           
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('blog');
    }
   
}
    

  

