<?php
// nastavení přihlašovacích údajů z Wedosu
$host    = 'md425.wedos.net'; // server Wedosu
$db      = 'd385835_form2';   // název databáze
$user    = 'a385835_form2';   // uživatelské jméno
$pass    = 'k2PCpEQm';    // heslo
$charset = 'utf8mb4'; // kódování (pro čekou diakritiku)

// sestavení DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// konfigurace chování PDO
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //pri chybe vyhodi vyjimku exception
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //databaze vrati nactena data jako asociativni pole
    PDO::ATTR_EMULATE_PREPARES => false, //PHP mmusi posilat dotazy odděleně
];

// pokus o připojení k databázi
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $err) {
    die("Chyba připojení k databázi: " . $err->getMessage());
}