<?php
$pdo = new PDO('mysql:host=localhost;dbname=uk2', 'root', '');
// Set 0 to NULL
$pdo->exec("UPDATE mahasiswa SET id_user=NULL WHERE id_user=0");
echo "Cleaned up id_user=0 to NULL";
