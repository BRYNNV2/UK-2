<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProdiToMahasiswa extends Migration
{
    public function up()
    {
        $this->forge->addColumn('mahasiswa', [
            'id_prodi' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'nama_mahasiswa'
            ],
        ]);
        $this->forge->addForeignKey('id_prodi', 'prodi', 'id_prodi', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('mahasiswa', 'mahasiswa_id_prodi_foreign');
        $this->forge->dropColumn('mahasiswa', 'id_prodi');
    }
}
