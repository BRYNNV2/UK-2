<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AcademicStructure extends Migration
{
    public function up()
    {
        // Fakultas
        $this->forge->addField([
            'id_fakultas' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_fakultas' => ['type' => 'VARCHAR', 'constraint' => 255],
        ]);
        $this->forge->addKey('id_fakultas', true);
        $this->forge->createTable('fakultas');

        // Jurusan
        $this->forge->addField([
            'id_jurusan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_jurusan' => ['type' => 'VARCHAR', 'constraint' => 255],
            'id_fakultas' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addKey('id_jurusan', true);
        $this->forge->addForeignKey('id_fakultas', 'fakultas', 'id_fakultas', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jurusan');

        // Prodi
        $this->forge->addField([
            'id_prodi' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_prodi' => ['type' => 'VARCHAR', 'constraint' => 255],
            'id_user_kaprodi' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_jurusan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addKey('id_prodi', true);
        $this->forge->addForeignKey('id_user_kaprodi', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('id_jurusan', 'jurusan', 'id_jurusan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('prodi');

        // Mahasiswa
        $this->forge->addField([
            'nim' => ['type' => 'VARCHAR', 'constraint' => 20],
            'nama_mahasiswa' => ['type' => 'VARCHAR', 'constraint' => 255],
            'id_user' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
        ]);
        $this->forge->addKey('nim', true);
        $this->forge->addForeignKey('id_user', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('mahasiswa');
    }

    public function down()
    {
        $this->forge->dropTable('mahasiswa');
        $this->forge->dropTable('prodi');
        $this->forge->dropTable('jurusan');
        $this->forge->dropTable('fakultas');
    }
}
