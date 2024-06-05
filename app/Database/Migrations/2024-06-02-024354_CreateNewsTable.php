<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNewsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type" => "INT",
                "constraint" => 5,
                "unsigned" => true,
                "auto_increment" => true
            ],
            "image" => [
                "type" => "VARCHAR",
                "constraint" => 255
            ],
            "title" => [
                "type" => "VARCHAR",
                "constraint" => 255
            ],
            "description" => [
                "type" => "VARCHAR",
                "constraint" => 255
            ],
            "created_at" => [
                "type" => "DATETIME",
                "null" => true
            ],
            "updated_at" => [
                "type" => "DATETIME",
                "null" => true
            ]
        ]);

        $this->forge->addPrimaryKey("id");

        $this->forge->createTable("news");
    }

    public function down()
    {
        $this->forge->dropTable("news");
    }
}
