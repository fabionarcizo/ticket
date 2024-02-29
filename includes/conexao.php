<?php
// $host = '';
// $user = '';
// $banco = '';
// $pass = '';
// $port = '';

// $conexao = new PDO("mysql:host=$host;port=$port;dbname=" . $banco, $user, $pass);

date_default_timezone_set('America/Sao_Paulo');
$database = 'Leader_src_prd';
$server = '192.168.25.9';

$user = 'usr_src';
$pass = 'E7zQE0iXT4h';
$conexao = new PDO("sqlsrv:Database=$database;server=$server;ConnectionPooling=0", $user, $pass);

?>