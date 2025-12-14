<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJenjangToProdi extends Migration
{
    public function up()
    {
        $this->forge->addColumn('prodi', [
            'jenjang' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'after'      => 'nama_prodi',
                'default'    => 'S1'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('prodi', 'jenjang');
    }
}
