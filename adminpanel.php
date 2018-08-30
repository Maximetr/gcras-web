<?php
session_start();
define('ROOT', dirname(__FILE__));
require_once(ROOT.'/models/User.php');
require_once(ROOT.'/components/connect.php');
require_once(ROOT.'/models/User.php');
require_once(ROOT.'/controllers/AdminController.php');
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
            <?php if (!isset($_SESSION['userID'])) : ?>
                <p>Страница доступна только для администраторов. Пожалуйста <a href="login.php">войдите</a> в систему или обратитесь к администраторам для получения доступа</p>
            <?php endif;?>
            <?php if (isset($_SESSION['userID'])) : ?>
            <div class="navigate">
                <div class="item"><a href="cabinet.php">Мой кабинет</a></div>
                <div class="item"><a href="index.php">Выбор данных</a></div>
                <div class="item"><a href="databaseinsert.php">Загрузка данных</a></div>
                <?php if ($userData[3] == 1) :?>
                <div class="item sel"><a href="adminpanel.php">Панель администратора</a></div>
                
            </div>
            <div class="menu">
                <div class="search">
                <h4>Поиск пользователей</h4>
                    <div>
                        <form method="post" action="adminpanel.php">
                            <input type="checkbox" name="all" value="all" id="all">
                            <label for="all">Выбрать всех пользователей</label>
                            <p>или</p>
                            <label for="email">Поиск по email</label>
                            <input type="text" name ="email" id="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
                            <input type="submit" name="search" value="Найти" style="width:50%; margin-top:10px;">
                        </form>
                    </div>
                </div>
                
                <?php if (isset($_POST['search'])) : ?>
                    <?php 
                        $admin = new AdminController;
                        $users = $admin->actionSearch($connect, $_SESSION['userID']);
                        $_SESSION['users'] = $users;
                    ?>
                <div class="userlist">
                <h4>Список пользователей</h4>
                    <form action="adminpanel.php" method="post">
                        <ul>
                            <li style="margin-bottom:15px;">
                                <div><label>Email</label></div>
                                <div><label>Права на загрузку данных</label></div>
                                <div><label>Права администратора</label></div>
                            </li>
                            <?php foreach ($users as $user) : ?>
                            <li>
                                <div><label><?php echo $user[1]; ?></label></div>
                                <div><input type="checkbox" <?php if ($user[2] == 1) echo 'checked '; echo "value='$user[0]'"; echo "name='insert[]'"; ?>></div>
                                <div><input type="checkbox" <?php if ($user[3] == 1) echo 'checked '; echo "value='$user[0]'"; echo "name='admin[]'"; ?>></div>
                            </li>
                            <?php endforeach;?>
                        </ul>
                        <input type="submit" style="margin-top:15px;" name="save">
                    </form>
                </div>
                <?php endif;?>
                <?php 
                if (isset($_POST['save'])) {
                    $admin = new AdminController;
                    $users = $_SESSION['users'];
                    $result = $admin->actionSave($users, $connect);
                }
                ?>
                <?php endif;?>
                <?php endif;?>
            </div>
        </div>
    </div>
        
    