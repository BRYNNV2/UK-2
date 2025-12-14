<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKaprodiToProdi extends Migration
{
    public function up()
    {
        $this->forge->addColumn('prodi', [
            'id_kaprodi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ]
        ]);
        // Foreign Key linkage (optional, but good)
        // Note: We might just rely on logic if we don't want strict constraint errors during dev
    }

    public function down()
    {
        $this->forge->dropColumn('prodi', 'id_kaprodi');
    }
}
