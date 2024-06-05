<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSuppliersTable extends Migration
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
            "supplier_id" => [
                "type" => "INT",
                "constraint" => 5,
                "unsigned" => true
            ],
            "nama" => [
                "type" => "VARCHAR",
                "constraint" => 30
            ],
            "alamat" => [
                "type" => "VARCHAR",
                "constraint" => 50
            ],
            "telp" => [
                "type" => "VARCHAR",
                "constraint" => 20
            ],
            "avatar" => [
                "type" => "VARCHAR",
                "constraint" => 255
            ],
            "data" => [
                "type" => "VARCHAR",
                "constraint" => 255
            ],
            "pengajuan" => [
                "type" => "BOOLEAN",
                "null" => false
            ],
            "tetap" => [
                "type" => "BOOLEAN",
                "null" => false
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

        $this->forge->createTable("suppliers");
    }

    public function down()
    {
        $this->forge->dropTable("suppliers");
    }
}
