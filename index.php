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

$errors = [];

if (empty($_POST['fio']) || !preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $_POST['fio'])) {
    $errors[] = "Ошибка в ФИО.";
}

if (empty($_POST['phone']) || !preg_match('/^\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}$/', $_POST['phone'])) {
    $errors[] = "Введите телефон в формате +7(XXX)-XXX-XX-XX";
}

if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Некорректный email.";
}

$date_from_post = $_POST['birthday'] ?? $_POST['birth_date'] ?? '';
$today = date('Y-m-d');
if (empty($date_from_post) || $date_from_post > $today) {
    $errors[] = "Дата рождения не может быть в будущем или пустой.";
}

if (empty($_POST['gender'])) {
    $errors[] = "Выберите пол.";
}

if (empty($_POST['languages'])) {
    $errors[] = "Выберите хотя бы один язык.";
}

if (empty($_POST['contract'])) {
    $errors[] = "Необходимо согласие с контрактом.";
}

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<div style='color:red; font-weight:bold;'>$error</div>";
    }
    include('form.php');
    exit();
}

try {
    $db->beginTransaction();

    $stmt = $db->prepare("INSERT INTO applications (fio, phone, email, birth_date, gender, biography, contract) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['fio'],
        $_POST['phone'],
        $_POST['email'],
        $date_from_post,
        $_POST['gender'],
        $_POST['biography'] ?? '',
        isset($_POST['contract']) ? 1 : 0
    ]);
    
    $app_id = $db->lastInsertId();

    $stmt_lang = $db->prepare("INSERT INTO application_languages (application_id, language_id) SELECT ?, id FROM languages WHERE name = ?");
    foreach ((array)$_POST['languages'] as $lang_name) {
        $stmt_lang->execute([$app_id, $lang_name]);
    }

    $db->commit();
    echo "Данные успешно сохранены! <a href='index.php'>Назад</a>";
} catch (Exception $e) {
    $db->rollBack();
    echo "Ошибка: " . $e->getMessage();
}
