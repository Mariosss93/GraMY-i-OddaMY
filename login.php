<?php
session_start();
$db = new SQLite3('../database/games.db');

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $res = $stmt->execute();
    $user = $res->fetchArray(SQLITE3_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Logowanie OK, ustaw sesję
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php");
        exit;
    } else {
        $message = "Nieprawidłowy login lub hasło!";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie - GraMY i Oddamy</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Logowanie</h1>
    <?php if ($message): ?>
        <div><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="POST">
        <label>Login: <input type="text" name="username" required></label><br><br>
        <label>Hasło: <input type="password" name="password" required></label><br><br>
        <button type="submit">Zaloguj się</button>
    </form>
    <p><a href="register.php">Nie masz konta? Zarejestruj się!</a></p>
    <p><a href="index.php">Powrót</a></p>
</body>
</html>
