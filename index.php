<?php
header('Content-Type: text/html; charset=UTF-8');

$user = 'u82352';
$pass = '9562557'; 

try {
    $db = new PDO("mysql:host=localhost;dbname=$user", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include('form.php');
    exit();
}

$fio = trim($_POST['fio'] ?? '');
if (empty($fio) || !preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $fio)) {
    die("Ошибка в ФИО. <a href='index.php'>Назад</a>");
}

try {
    $db->beginTransaction();
    $stmt = $db->prepare("INSERT INTO applications (fio, phone, email, birth_date, gender, biography, contract) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$fio, $_POST['phone'], $_POST['email'], $_POST['birth_date'], $_POST['gender'], $_POST['biography'], isset($_POST['contract']) ? 1 : 0]);
    $app_id = $db->lastInsertId();
    $stmt_lang = $db->prepare("INSERT INTO application_languages (application_id, language_id) SELECT ?, id FROM languages WHERE name = ?");
    foreach ((array)$_POST['languages'] as $lang) {
        $stmt_lang->execute([$app_id, $lang]);
    }
    $db->commit();
    echo "Данные сохранены! <a href='index.php'>Назад</a>";
} catch (Exception $e) {
    $db->rollBack();
    echo "Ошибка: " . $e->getMessage();
}
