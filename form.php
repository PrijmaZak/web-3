<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма регистрации - Задание 3</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .form-container { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); width: 100%; max-width: 450px; }
        h2 { text-align: center; color: #1c1e21; margin-bottom: 20px; }
        input, select, textarea { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 14px; }
        .radio-group { margin: 15px 0; font-size: 14px; color: #4b4f56; }
        .radio-group label { margin-right: 15px; cursor: pointer; }
        button { width: 100%; background-color: #1877f2; color: white; border: none; padding: 12px; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background 0.3s; }
        button:hover { background-color: #166fe5; }
        .error { color: #d32f2f; background: #ffebee; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 13px; }
        .success { color: #2e7d32; background: #e8f5e9; padding: 10px; border-radius: 4px; margin-bottom: 15px; text-align: center; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Анкета разработчика</h2>
        <form action="index.php" method="POST">
            <input type="text" name="fio" placeholder="ФИО (только буквы)" required maxlength="150">
            <input type="tel" name="phone" placeholder="Телефон" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <label style="font-size: 12px; color: #666;">Дата рождения:</label>
            <input type="date" name="birth_date" required>
            
            <div class="radio-group">
                Пол: 
                <label><input type="radio" name="gender" value="male" checked> Мужской</label>
                <label><input type="radio" name="gender" value="female"> Женский</label>
            </div>

            <label style="font-size: 12px; color: #666;">Любимые языки программирования:</label>
            <select name="languages[]" multiple="multiple" size="5">
                <option value="Pascal">Pascal</option> <option value="C">C</option>
                <option value="C++">C++</option> <option value="JavaScript">JavaScript</option>
                <option value="PHP">PHP</option> <option value="Python">Python</option>
                <option value="Java">Java</option> <option value="Go">Go</option>
            </select>

            <textarea name="biography" rows="4" placeholder="Краткая биография..."></textarea>
            
            <label style="font-size: 13px;"><input type="checkbox" name="contract" required style="width: auto;"> С контрактом ознакомлен(а)</label>
            
            <button type="submit">Сохранить данные</button>
        </form>
    </div>
</body>
</html>
