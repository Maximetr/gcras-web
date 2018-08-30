<?php

class Admin {

    public static function selectAll($connect, $userID) {
        $users = array();
        $sql = "SELECT UserID, Email, InsertRights, AdminRights FROM UsersToDownload WHERE UserID <> $userID";
        $query = mysqli_query($connect, $sql);

        while ($result = mysqli_fetch_array($query, MYSQLI_NUM)) {
            $users[] = $result;
        }
        return $users;
    }

    public static function selectByEmail($connect, $email, $userID) {
        $users = array();
        $sql = "SELECT UserID, Email, InsertRights, AdminRights FROM UsersToDownload WHERE UserID <> $userID AND Email LIKE '$email%'";
        $query = mysqli_query($connect, $sql);

        while ($result = mysqli_fetch_array($query, MYSQLI_NUM)) {
            $users[] = $result;
        }
        return $users;
    }

    public static function setInsertRights($connect, $userID) {
        $sql = "UPDATE UsersToDownload SET InsertRights = 1 WHERE UserID = $userID";
        $query = mysqli_query($connect,$sql);
    }

    public static function unsetInsertRights($connect, $userID) {
        $sql = "UPDATE UsersToDownload SET InsertRights = 0 WHERE UserID = $userID";
        $query = mysqli_query($connect,$sql);
    }

    public static function setAdminRights($connect, $userID) {
        $sql = "UPDATE UsersToDownload SET AdminRights = 1 WHERE UserID = $userID";
        $query = mysqli_query($connect,$sql);
    }

    public static function unsetAdminRights($connect, $userID) {
        $sql = "UPDATE UsersToDownload SET AdminRights = 0 WHERE UserID = $userID";
        $query = mysqli_query($connect,$sql);
    }
}