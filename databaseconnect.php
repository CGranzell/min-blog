<?php
// Inloggnings uppgifter för databasen
$host     = 'localhost';
$database = 'blog';
$user     = 'root';
$password = '';
$charset  = 'utf8mb4';


$dns     = "mysql:host={$host};dbname={$database};charset={$charset}";

// 
$options = [
  //Felmeddelande och vilken typ
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  //Hur jag väljer att hämta och visa data från databas
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];


// Upprätta en DB koppling
try {
  // Försök köra koden i try-blocket
  $pdo = new PDO($dns, $user, $password, $options);
} catch (\PDOException $e) {
  // Catch-blocket körs om något gick fel i try-blocket
  throw new \PDOException($e->getMessage(), (int) $e->getCode());
}
