<?php
require_once 'db.php'; //require_once zajisti ze se sem vlozi objekt $pdo pro propojeni s databazi
$zprava = ""; //prázdná proměnná pro hlášku o uložení

// promenne
$jmeno = "";
$email = "";
$souhlas = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    // Ověřit odeslání formuláře metodou POST
    // Načíst data z globálního pole $_POST do lokálních proměnných (pro ořehlednost a jednoduchost)
    $jmeno = $_POST['jmeno'];
    $email = $_POST['email'];
    $souhlas = $_POST['souhlas'];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") { //"$_SERVER" = globalni podminka, "REQUEST_METHOD" = konkrétní klíč v poli$_SERVER
    // načíst data z globálního pole $_POST do lokálních proměnných (pro ořehlednost a jednoduchost)
    $jmeno = $_POST['jmeno'];
    $email = $_POST['email'];
    $souhlas = $_POST['souhlas'];

    // přidání bezpečného zápisu do databáze (Prepared Statements)
    $sql = "INSERT INTO uzivatele (jmeno, email, souhlas) VALUES (?, ?, ?)"; //misto otazniku pak funkce execute dosadi z promennych
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$jmeno, $email, $souhlas]);

    //hláška pro uživatele
    $zprava = "Úspěšně uloženo do databáze!";
}

// načtení všech dat z tabulky uzivatele pro zobrazení dole na stránce
$dotaz = $pdo->query("SELECT * FROM uzivatele ORDER BY id DESC"); //příkaz SELECT vybere vše
$vsechna_data = $dotaz->fetchAll(); //fetchAll() vytvoří jedno velké pole ($vsechna_data), které níže projdeme cyklem.

?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Formular</title>
</head>
<body>

    <?php if ($zprava != "") { echo "<p><strong>$zprava</strong></p>"; } ?> //zobrazeni zpravy $zprava

    <!-- action="" (bez souboru) znamena odeslat na stejnou stranku -->
    <form action="" method="POST">
        <label>Jmeno:</label><br>
        <input type="text" name="jmeno" required><br><br>

        <label>Email:</label><br>
        <input type="text" name="email"><br><br>

        <label>Chcete dostavat newsletter?</label><br>
        <input type="radio" name="souhlas" value="Ano" required> Ano
        <input type="radio" name="souhlas" value="Ne"> Ne<br><br>

        <button type="submit">Odeslat</button>
    </form>

    <hr>

        <!-- zobrazeni (pouze pokud odeslano) -->
    <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>
        <h3>Prijata data:</h3>
        <p><strong>Jmeno:</strong> <?php echo $jmeno; ?></p>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Odpoved:</strong> <?php echo $souhlas; ?></p>
    <?php } ?> <!-- konec podminky -->
    <!-- Rozdělení na php a html - pozor na spravne umisteni < ?php...?> -->


    <h3>Veškerá data z databáze:</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Jméno</th>
            <th>E-mail</th>
            <th>Souhlas</th>
        </tr>
        
        <?php foreach ($vsechna_data as $radek) { ?> //foreach projde pole $vsechna_data
            <tr>
                <td><?php echo htmlspecialchars($radek['id']); ?></td>
                <td><?php echo htmlspecialchars($radek['jmeno']); ?></td>
                <td><?php echo htmlspecialchars($radek['email']); ?></td>
                <td><?php echo htmlspecialchars($radek['souhlas']); ?></td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>