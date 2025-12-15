<?php

namespace App\Controllers;

class SystemFix extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $forge = \Config\Database::forge();

        $mapping = [
            'users'                        => '2301020001_user',
            'fakultas'                     => '2301020005_fakultas',
            'jurusan'                      => '2301020008_jurusan',
            'prodi'                        => '2301020011_prodi',
            'periode_kuisioner'            => '2301020037_periode_kuisioner',
            'pertanyaan'                   => '2301020088_pertanyaan',
            'pilihan_jawaban_pertanyaan'   => '2301020093_pilihan_jawaban_pertanyaan',
            'pertanyaan_periode_kuisioner' => '2301020104_pertanyaan_periode_kuisioner',
            'mahasiswa'                    => '2301020111_mahasiswa',
            'jawaban'                      => '2301020043_jawaban'
        ];

        echo "<h2>Current Tables:</h2><ul>";
        $tables = $db->listTables();
        foreach ($tables as $t) {
            echo "<li>$t</li>";
        }
        echo "</ul>";

        echo "<h2>Renaming Tables...</h2>";

        foreach ($mapping as $old => $new) {
             // ... logic ...
             try {
                if ($db->tableExists($old)) {
                    $db->query("RENAME TABLE `$old` TO `$new`");
                    echo "Renamed $old to $new <br>";
                } elseif ($db->tableExists($new)) {
                     echo "$new already exists (Skipped)<br>";
                } else {
                    echo "Table $old not found <br>";
                }
             } catch (\Exception $e) {
                 echo "Error renaming $old: " . $e->getMessage() . "<br>";
             }
        }
        echo "Done.";
    }
}
