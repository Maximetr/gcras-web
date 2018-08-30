<?php

require_once(ROOT.'/models/User.php');

class UserController 
{
    public function actionRegister($connect)
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        $errors = User::validation($email, $password, $confirmPassword, $connect);

        if ($errors) {
            foreach ($errors as $error) {
                echo "$error"."</br>";
            }
            return false;
        }

        $result = User::register($email, $password, $connect);
        if ($result) {
            header("Location: cabinet.php");
            return $result;
        } else {
            echo 'Ошибка регистрации';
            return false;
        }
    }

    public function actionLogin($connect)
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = User::getUser($email, $connect);
        if (!$user) {
            echo 'Пользователь с таким email не существует';
            return false;
        } elseif (!password_verify($password, $user[2])) {
            echo 'Неверно введен пароль';
            return false;
        } else {
            User::saveUserSession($user[0]);
            header("Location: cabinet.php");
        }
    }

    public function actionEdit($userData, $connect) {
        $oldEmail = $_POST['oldEmail'];
        $newEmail = $_POST['newEmail'];
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];

        $result = false;

        if ($oldEmail == $userData[1] && $oldPassword == '' && $newPassword == '' && $newEmail == '') {
            echo 'Вы не изменили никакие данные';
        }

        //если меняем только email
        if ($newEmail !== '' && $oldPassword == '' && $newPassword == '') {
           if ($oldEmail == $userData[1]) {
               if (filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                   $result = User::editUserData($userData[0], $newEmail, $newPassword, $connect);
                   if ($result) {
                       echo 'Email изменен'; 
                   } else {
                       echo 'Серверная ошибка при изменении email`a';
                   }
               } else {
                   echo 'Новый email некорректен';
               }
           } else {
               echo 'Старый email введен неверно';
           }
        }

        //если меняем только пароль
        if ($newPassword !== '' && $newEmail == '') {
            if (password_verify($oldPassword, $userData[2])) {
                $result = User::editUserData($userData[0], $newEmail, $newPassword, $connect);if ($result) {
                    echo 'Пароль изменен'; 
                } else {
                    echo 'Серверная ошибка при изменении пароля';
                }
            } else {
                echo 'Старый пароль введен неверно';
            }
        }

        //если меняем email и пароль
        if ($newEmail !=='' && $oldPassword !== '' && $newPassword !== '') {
            if ($oldEmail == $userData[1]) {
                if (filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                    if (password_verify($oldPassword, $userData[2])) {
                        $result = User::editUserData($userData[0], $newEmail, $newPassword, $connect);
                        if ($result) {
                            echo 'Данные изменены'; 
                        } else {
                            echo 'Серверная ошибка при изменении данных';
                        }
                    } else {
                        echo 'Старый пароль введен неверно';
                    }   
                } else {
                    echo 'Новый email некорректен';
                }
            } else {
                echo 'Старый email введен неверно';
            }
        }
        return $result;
    }


}