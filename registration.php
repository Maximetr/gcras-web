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
            <?php if (isset($_POST['submit'])) {
                error_reporting(E_ALL);
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                define('ROOT', dirname(__FILE__));
                require_once(ROOT.'/components/connect.php');
                require_once(ROOT.'/controllers/UserController.php');
                session_start();
                $user = new UserController;
                $result = $user->actionRegister($connect);
            } ?>
            <h3>Регистрация</h3>
            <div class="form" style="text-align:right;"> 
                <form action="registration.php" method="post">
                    <div class="userform">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" value=<?php if (isset($_POST['email'])) echo $_POST['email'];?>>
                    </div>
                        
                    <div class="userform">
                        <label for="password">Пароль</label>
                        <input type="password" name="password" id="password">
                    </div>
                    <div class="userform">
                        <label for="confirmPassword">Повторите пароль</label>
                        <input type="password" name="confirmPassword" id="confirmPassword">
                    </div>

                    <input type="submit" name="submit" value="Зарегестроваться">
                    
                </form>
            </div>
            <div style="padding-top:15px;">
                <label>Уже зарегестрированы? <a href='login.php'>Войти</a></label>
            </div>
        </div>
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