<?php
$db_params = include(ROOT.'/config/db-params.php');
$dbhost = $db_params['host'];
$dbuser = $db_params['user'];
$dbpassword = $db_params['password'];
$dbname = $db_params['db_name'];
$connect = mysqli_connect("$dbhost", "$dbuser", "$dbpassword", "$dbname");//параметры в скобках ("хост", "имя пользователя", "пароль", "имя БД")
if (!$connect) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;																				//подключение к mysqli
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
?>