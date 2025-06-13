<?php
session_start();
// Połączenie z bazą
$db = new SQLite3('../database/games.db');

// Tworzymy tabelę users jeśli nie istnieje
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    role TEXT DEFAULT 'user'
)");

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = 'user'; // domyślna rola, można dodać wybór przy zakładaniu admina/pracownika

    if (strlen($username) < 3 || strlen($password) < 4) {
        $message = "Za krótka nazwa lub hasło!";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        $stmt->bindValue(':username', $username, SQLITE3_TEXT);
        $stmt->bindValue(':password', $hash, SQLITE3_TEXT);
        $stmt->bindValue(':role', $role, SQLITE3_TEXT);

        try {
            $stmt->execute();
            $message = "✅ Rejestracja udana, możesz się zalogować!";
        } catch (Exception $e) {
            $message = "❌ Nazwa użytkownika już istnieje!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja - GraMY i Oddamy</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Rejestracja nowego użytkownika</h1>
    <?php if ($message): ?>
        <div><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="POST">
        <label>Nazwa użytkownika: <input type="text" name="username" required></label><br><br>
        <label>Hasło: <input type="password" name="password" required></label><br><br>
        <button type="submit">Zarejestruj</button>
    </form>
    <p><a href="login.php">Masz już konto? Zaloguj się</a></p>
    <p><a href="index.php">Powrót</a></p>
</body>
</html>
