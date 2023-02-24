<?php

include("database_connection.php");

if (isset($_COOKIE["type"])) {
    header("location:admin.php");
}

$message = '';

if (isset($_POST["login"])) {
    if (empty($_POST["user_login"]) || empty($_POST["user_password"])) {
        $message = "<div>Оба поля должны быть заполнены</div>";
    } else {
        $query = "SELECT * FROM user_details   WHERE user_login = :user_login";
        $statement = $connect->prepare($query); //PDO::prepare — Подготавливает запрос к выполнению и возвращает связанный с этим запросом объект
        $statement->execute( //PDOStatement::execute — Запускает подготовленный запрос на выполнение
            array(
                'user_login' => $_POST["user_login"]
            )
        );
        $count = $statement->rowCount();//PDOStatement::rowCount — Возвращает количество строк, затронутых последним SQL-запросом
        if ($count > 0) {
            $result = $statement->fetchAll();//PDOStatement::fetchAll — Выбирает оставшиеся строки из набора результатов
            foreach ($result as $row) {
                if ($_POST["user_password"] == $row["user_password"]) {
                    setcookie("type", $row["user_type"], time() + 3600);
                    header("location:admin.php");
                } else {
                    $message = '<div>Неверный пароль</div>';
                }
            }
        } else {
            $message = "<div>Неверный логин</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <h1>Страница с авторизацией</h1>
    <div>
        <span><?php echo $message; ?></span>
        <form method="post">
            <div>
                <label>login</label>
                <input type="text" name="user_login" id="user_login" />
            </div>
            <div>
                <label>Пароль</label>
                <input type="password" name="user_password" id="user_password" />
            </div>
            <div>
                <input type="submit" name="login" id="login" value="Войти" />
            </div>
        </form>
    </div>
</body>

</html>