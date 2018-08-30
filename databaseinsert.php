<?php 
session_start();
define('ROOT', dirname(__FILE__));
require_once(ROOT.'/models/User.php');
require_once(ROOT.'/components/connect.php');
require_once(ROOT.'/controllers/SiteController.php');
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

    <!-- _________________________Панель навигации_______________ -->
        <!-- <div class="nav-bar">
            <ul>
                <li>
                    <div class="nav-item">
                        раздел
                    </div>
                </li>
                <li>
                    <div class="nav-item border">
                        раздел
                    </div>
                </li>
                <li>                                                        
                    <div class="nav-item border">
                        раздел
                    </div>
                </li>
                <li>
                    <div class="nav-item border">
                        раздел
                    </div>
                </li>
            </ul>
        </div> -->

    <!--________________________Конец панели_____________________-->



        <div class = "content clearfix">
            <?php if (!isset($_SESSION['userID'])) :?>
                <p>Страница доступна только для авторизованных пользователей, пожалуйста войдите в систему
                на <a href="login.php">специальной странице</a></p>
            <?php endif;?>
            <?php if (isset($_SESSION['userID'])) : ?>
            <div class="navigate">
                <div class="item"><a href="cabinet.php">Мой кабинет</a></div>
                <div class="item"><a href="index.php">Выбор данных</a></div>
                <div class="item sel"><a href="databaseinsert.php">Загрузка данных</a></div>
                <?php if ($userData[3] == 1) :?>
                <div class="item"><a href="adminpanel.php">Панель администратора</a></div>
                <?php endif;?>
            </div>
            <div class = "form" style="width:75%;">
            <label>Вставьте данные в поле</label>
                <form method="post" action="databaseinsert.php">
                    </br>
                    <input type="radio" id="minute" name="dataType" value="minute">
                    <label for="minute">Минутные данные</label>
                    <input type="radio" id="hourly" name="dataType" value="hourly" checked>
                    <label for="hourly">Часовые данные</label>                                                    
                    <div class="textarea clearfix">
                        <textarea name="inputData" style="width:100%;"><?php if (isset($_POST['submit'])) {
                            echo $_POST['inputData'];
                        }?></textarea>
                    </div>  
                    <input type="submit" name="submit" id="submit" value="Добавить данные">           
                </form>
                <?php if (isset($_POST['submit'])) : ?>
                <label style="padding-left:45%;">Окно статуса</label>
                <div>
                    <textarea id="progress" style="width:100%;"><?php error_reporting(E_ALL);
                        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                        
                        $controller = new SiteController;
                        $controller->StartInsert($connect);
                    ?></textarea>                                    
                </div>
                <?php endif;?>
            </div>
            <?php endif;?>
        </div>
    <footer>
        <div class = "footer-menu">
            <ul>
                <li>
                    <a href="http://www.wdcb.ru/stp/index.ru.html">Главная страница</a>
                </li>
                <li>
                    <a href="http://www.wdcb.ru/stp/data.ru.html">Данные</a>
                </li>
                <li>
                    <a href="http://www.wdcb.ru/stp/prognoz.ru.html">Прогнозы</a>
                </li>
                <li>
                    <a href="http://www.wdcb.ru/stp/links.ru.html" target="_blank">Ссылки</a>
                </li>
                <li>
                    <a href="http://www.wdcb.ru/stp/contacts.ru.html" target="_blank">Контактируйте с нами</a>
                </li>
            </ul>
        </div>
        <div class="line">
            <img src="template/line.gif"></img>
        </div>
        <p>© 1995-2018 МЦД по СЗФ, ГЦ РАН</p>
    </footer>
    <script type='text/javascript' src='ntsaveforms.js'></script>
    </div>
    <script src="leaflet/leaflet.js"></script>
    <script src="components/dronestrikes.js"></script>
    <script type='text/javascript' src='http://code.jquery.com/jquery-latest.min.js'></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="jquery/jquery.maskedinput.js"></script>


<script src="main.js"></script>
</body>
</html>
    



