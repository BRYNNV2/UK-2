<?php
// rename_tables.php
$host = 'localhost';
$db   = 'uk2';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
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
    
    foreach ($mapping as $old => $new) {
        // Check if old exists
        $stmt = $pdo->query("SHOW TABLES LIKE '$old'");
        if ($stmt->fetch()) {
            echo "Renaming $old to $new... ";
            $pdo->exec("RENAME TABLE `$old` TO `$new`");
            echo "Done.\n";
        } else {
            // Check if new exists
            $stmtNew = $pdo->query("SHOW TABLES LIKE '$new'");
            if ($stmtNew->fetch()) {
                echo "Table $new already exists (Previously renamed).\n";
            } else {
                echo "Warning: Table $old not found and $new not found.\n";
            }
        }
    }
    
    echo "All renames attempted.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
