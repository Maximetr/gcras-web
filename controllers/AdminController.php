<?php

require_once(ROOT.'/models/Admin.php');

class AdminController {
    public function actionSearch($connect, $userID) {
        $email = $_POST['search'];

        if (isset($_POST['all'])) {
            $users = Admin::selectAll($connect, $userID);
            return $users;
        }
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $users = Admin::selectByEmail($connect, $email, $userID);
            return $users;
        }
    }

    public function actionSave($users, $connect) {

        if (isset($_POST['insert'])) {
            foreach ($users as $user) {
                $userID = $user[0];
                $insertRules = $user[2];

                $arraySearch = array_search($userID, $_POST['insert']);

                if (!is_bool($arraySearch)) {
                    Admin::setInsertRights($connect,$userID);
                }
                if (is_bool($arraySearch) and $insertRules == '1') {
                    Admin::unsetInsertRights($connect,$userID);
                }
                if (is_bool($arraySearch) and $insertRules == '0') {
                    
                }
            }
        }   else {
            foreach ($users as $user) {
                $userID = $user[0];
                $adminRules = $user[3];

                Admin::unsetInsertRights($connect,$userID);
            }
        }

        if (isset($_POST['admin'])) {
            foreach ($users as $user) {
                $userID = $user[0];
                $adminRules = $user[3];

                $arraySearch = array_search($userID, $_POST['admin']);

                if (!is_bool($arraySearch)) {
                    Admin::setAdminRights($connect,$userID);
                }
                if (is_bool($arraySearch) and $adminRules == '1') {
                    Admin::unsetAdminRights($connect,$userID);
                }
                if (is_bool($arraySearch) and $adminRules == '0') {
                    
                }
            }
        } else {
            foreach ($users as $user) {
                $userID = $user[0];
                $adminRules = $user[3];

                Admin::unsetAdminRights($connect,$userID);
            }
        }


        // var_dump($users);
          

    }
}