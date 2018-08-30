<?php
session_start();
if (!isset($_SESSION['userID'])){
    header("Location:login.php");
}
define('ROOT', dirname(__FILE__));
require_once(ROOT.'/models/User.php');
require_once(ROOT.'/components/connect.php');
$userData = User::getUserByID($_SESSION['userID'], $connect);
$email = $userData[1];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Геомагнитные данные</title>

<link  rel="stylesheet" href="style.css" type="text/css" />
<link rel="stylesheet" href="leaflet/leaflet.css" />
</head>
<body>
    <header>
       <div class="top-bottom-line">
            <a class="gcras-link" href="http://www.gcras.ru" target="_blank">Геофизический  центр  Российской  академии  наук - ГЦ РАН</a>
       </div>

       <div class="center-line">
            <div class="logo1 clearfix">
                <img src="template/logo/logo_wds.gif"></img>
            </div>

            <div class="site-name">
                <div class="left-text"><p>Мировой центр данных</p></div>
                <div class="center-text"><p>по солнечно-земной физике</p></div>
                <div class="right-text"><p>Москва, Россия</p></div>
            </div>

            <div class = "logo2 clearfix">
                <img src="template/logo/logo_sun.ru.gif"></img>
            </div>
       </div>

        <div class="top-bottom-line">
            <div class="nav-bar">
                <ul>
                    <li>
                        <div class="nav-item">
                            <a href="http://www.icsu-wds.org/" target="_blank">Мировая система данных</a>
                        </div>
                    </li>
                    <li>
                        <div class="nav-item border">
                            <a href="http://www.wdcb.ru/index.ru.html" target="_blank">МЦД в России и Украине</a>
                        </div>
                    </li>
                    <li>                                                        
                        <div class="nav-item border">
                            <a href="#">English</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class = "mainbody">
        <div class = "content clearfix">
        <div class="navigate">
                <div class="item"><a href="cabinet.php">Мой кабинет</a></div>
                <div class="item"><a href="/">Выбор данных</a></div>
                <div class="item"><a href="databaseinsert.php">Загрузка данных</a></div>
                <?php if ($userData[3] == 1) :?>
                <div class="item"><a href="adminpanel.php">Панель администратора</a></div>
                <?php endif;?>
            </div>
            <?php if (isset($_POST['submit'])) {
                require_once(ROOT.'/controllers/UserController.php');
                $user = new UserController;
                $result = $user->actionEdit($userData,$connect);
            }
            ?>
            <h3>Изменение личных данных</h3>
            <p>Заполняйте только те поля, которые хотите изменить</p>
            <div class="form" style="text-align:right;">
                <form action="edit.php" method="post">
                    <div class="userform">
                        <label for="oldEmail">Старый email</label>
                        <input type="text" name="oldEmail" id="oldEmail" value="<?php echo $email;?>">
                    </div>
                    <div class="userform">
                        <label for="newEmail">Новый email</label>
                        <input type="text" name="newEmail" id="newEmail">
                    </div>
                    <div class="userform">
                        <label for="oldPassword">Старый пароль</label>
                        <input type="password" name="oldPassword" id="oldPassword">
                    </div>
                    <div class="userform">
                        <label for="newPassword">Новый пароль</label>
                        <input type="password" name="newPassword" id="newPassword">
                    </div>
                    <input type="submit" name="submit" value="Обновить данные">
                </form>
            </div>
        </div>
    </div>