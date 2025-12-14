<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Questionnaire extends Migration
{
    public function up()
    {
        // Periode Kuisioner
        $this->forge->addField([
            'id_periode' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'keterangan' => ['type' => 'VARCHAR', 'constraint' => 255],
            'status_periode' => ['type' => 'ENUM', 'constraint' => ['Aktif', 'Tidak Aktif'], 'default' => 'Tidak Aktif'],
        ]);
        $this->forge->addKey('id_periode', true);
        $this->forge->createTable('periode_kuisioner');

        // Pertanyaan
        $this->forge->addField([
            'id_pertanyaan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'pertanyaan' => ['type' => 'TEXT'],
            'id_prodi' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addKey('id_pertanyaan', true);
        $this->forge->addForeignKey('id_prodi', 'prodi', 'id_prodi', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pertanyaan');

        // Pilihan Jawaban Pertanyaan
        $this->forge->addField([
            'id_pilihan_jawaban' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'deskripsi_pilihan' => ['type' => 'VARCHAR', 'constraint' => 255],
            'id_pertanyaan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addKey('id_pilihan_jawaban', true);
        $this->forge->addForeignKey('id_pertanyaan', 'pertanyaan', 'id_pertanyaan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pilihan_jawaban_pertanyaan');

        // Pertanyaan Periode Kuisioner
        $this->forge->addField([
            'id_pertanyaan_periode_kuisioner' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_periode_kuisioner' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_pertanyaan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addKey('id_pertanyaan_periode_kuisioner', true);
        $this->forge->addForeignKey('id_periode_kuisioner', 'periode_kuisioner', 'id_periode', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_pertanyaan', 'pertanyaan', 'id_pertanyaan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pertanyaan_periode_kuisioner');

        // Jawaban
        $this->forge->addField([
            'id_jawaban' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nim' => ['type' => 'VARCHAR', 'constraint' => 20],
            'id_pertanyaan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_pilihan_jawaban_pertanyaan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_periode' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addKey('id_jawaban', true);
        $this->forge->addForeignKey('nim', 'mahasiswa', 'nim', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_pertanyaan', 'pertanyaan', 'id_pertanyaan', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_pilihan_jawaban_pertanyaan', 'pilihan_jawaban_pertanyaan', 'id_pilihan_jawaban', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_periode', 'periode_kuisioner', 'id_periode', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jawaban');
    }

    public function down()
    {
        $this->forge->dropTable('jawaban');
        $this->forge->dropTable('pertanyaan_periode_kuisioner');
        $this->forge->dropTable('pilihan_jawaban_pertanyaan');
        $this->forge->dropTable('pertanyaan');
        $this->forge->dropTable('periode_kuisioner');
    }
}
