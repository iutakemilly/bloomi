<?php
$host = 'localhost';
$dbname = 'bloobloo'; // Nome do banco atualizado
$username = 'root';   // Ajuste se necessário
$password = 'Home@spSENAI2025!';       // Ajuste se necessário

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}