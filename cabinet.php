<?php 
session_start();
define('ROOT', dirname(__FILE__));
require_once(ROOT.'/models/User.php');
require_once(ROOT.'/components/connect.php');
$userData = User::getUserByID($_SESSION['userID'], $connect);
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
            <?php if (isset($_SESSION['userID'])) : ?>
            <div class="navigate">
                <div class="item sel"><a href="cabinet.php">Мой кабинет</a></div>
                <div class="item"><a href="index.php">Выбор данных</a></div>
                <div class="item"><a href="databaseinsert.php">Загрузка данных</a></div>
                <?php if ($userData[3] == 1) :?>
                <div class="item"><a href="adminpanel.php">Панель администратора</a></div>
                <?php endif;?>
            </div>
            <h3>Мои данные</h3>
            <div class="cabinet">
                
                <p>Email: <?php echo $userData[1];?>  <a href="edit.php">изменить</a></p>
                <p>Пароль: ******** <a href="edit.php">изменить</a></p>
                <p>Доступ к загрузке данных: <?php if ($userData[4] == 1) {echo "разрешен  <a href='databaseinsert.php'>перейти</a>";} else {echo "запрещен.</br> Для получения доступа обратитесь к администратору.";} ?>
		</br>
                </br>
                <p><a href="logout.php">Выход из системы</a></p>
            </div>
            <?php else :?>
            <h4>Страница доступна только для авторизованных пользователей, пожалуйста <a href="login.php">войдите</a> в систему</h4>
        </div>
    </div>
            <?php endif;?>