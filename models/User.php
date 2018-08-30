<?php

class User 
{
    public static function validation($email, $password, $confirmPassword = '', $connect) {
        $errors = array();

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Некорректный email';
        }
        if (strlen($password) <= 4) {
            $errors[] = 'Пароль должен быть не короче 4 символов';
        }
        if ($password == '' or $confirmPassword == '') {
            $errors[] = 'Все поля должны быть заполнены';
        }
        if ($password !== $confirmPassword) {
            $errors[] = 'Пароли не совпадают';
        }
        if (!self::checkEmailAvailable($email,$connect)) {
            $errors[] = 'Такой Email уже занят';
        }


        return $errors;
    }

    public static function register($email, $password, $connect) {
        
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO UsersToDownload (Email, PasswordHash) VALUES ('$email', '$passwordHash')";
        $result = mysqli_query($connect, $sql);

        if ($result) {
            $user = self::getUser($email,$connect);
            $userID = $user[0];
            return self::saveUserSession($userID);
        }

        echo 'Ошибка регистрации';
        return false;
    }

    public static function checkEmailAvailable($email, $connect) {
        $emails = array();
        $sql = "SELECT Email FROM UsersToDownload WHERE Email = '$email'";
        $query = mysqli_query($connect, $sql);

        while ($result = mysqli_fetch_array($query, MYSQLI_NUM)) {
            $emails[] = $result;
        }

        if ($emails) {
            return false;
        }
        return true;
    }

    public static function saveUserSession($userID) {
        $_SESSION['userID'] = $userID;
        if (isset($_SESSION['userID'])) {
            return true;
        }
        return false;
    }

    public static function getUser($email, $connect) {
        $sql = "SELECT * FROM UsersToDownload WHERE Email LIKE '$email'";
        $result = mysqli_query($connect, $sql);
        
        if ($result) {
            $user = mysqli_fetch_row($result);
            return $user;
        }

        return false;
    }

    public static function getUserByID($userID, $connect) {
        $sql = "SELECT * FROM UsersToDownload WHERE UserID LIKE '$userID'";
        $result = mysqli_query($connect, $sql);
        
        if ($result) {
            $user = mysqli_fetch_row($result);
            return $user;
        }
        return false;
    }

    public static function editUserData($userID, $email = '', $password = '', $connect) {
        if ($email == '') {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE UsersToDownload SET PasswordHash = '$passwordHash' WHERE UserID = '$userID'";
        }
        if ($password == '') {
            $sql = "UPDATE UsersToDownload SET Email = '$email' WHERE UserID = '$userID'";
        }
        if ($email !== '' && $password !== '') {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE UsersToDownload SET Email = '$email', PasswordHash = '$passwordHash' WHERE UserID = '$userID'";
        }

        $result = mysqli_query($connect, $sql);

        return $result;
    }
}