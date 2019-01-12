<?php

require_once(ROOT.'/models/Data.php');
require_once(ROOT.'/models/InsertData.php');
require_once(ROOT.'/components/connect.php');


class SiteController {

    /*Запуск обработчика
    $type - тип запрашиваемых данных;
    $mindate - нижний край временного интервала;
    $maxdate - верхний край временного интервала;
    $kod - 3-х значний МАГА-код обсерватории;
    $savedata - формат вывода данных;
    $email - email пользователя;
    */
    public function run($connect) {

        $type = $_POST['datatype'];
        $mindate = $_POST['date1'];
        $maxdate = $_POST['date2'];
        $kod = $_POST['obsnametab'];
        $savedata = $_POST['savedata'];
        $email = $_POST['email'];

        $errors = Data::Validation($mindate, $maxdate, $savedata);
        
        if ($errors) {
           foreach ($errors as $error) {
            echo $error;
           }
            return false;
        }

        $data = Data::getData($mindate, $maxdate, $kod, $savedata, $email, $type, $connect);
        if ($type == 'minute') {
            $dataType = Data::getDataType($connect, $mindate,$maxdate,$kod,$type);
        }
        if ($data) {
            Data::output($data, $savedata, $kod, $type, $connect, $dataType);
        } else {
            echo 'Не найдены данные за выбранный период';
        }

    }


    public function StartInsert($connect) {

        $type = $_POST['dataType'];
        $inputData = $_POST['inputData'];

        if ($type == 'minute') {
            
            $rows = explode("\n", $inputData);

            $checkResult = InsertData::CheckMinute($rows);
            if ($checkResult === true) {
                echo "Данные корректны, начинаю добавление в базу данных\n";  
                $result = InsertData::InsertMinute($rows, $connect);
            } else {
                echo "Данные введены некорректно\n";
                echo "$checkResult\n";   
            }
        }

        if ($type == 'hourly') {

            $rows = explode("\n", $inputData);

            $checkResult = InsertData::CheckHourly($rows);

            if ($checkResult === true) {
                echo "Данные корректны, начинаю добавление в базу данных\n";  
                $result = InsertData::InsertHourly($rows, $connect);        
            } else {
                echo "Данные введены некорректно\n";
                echo "$checkResult\n";   
            }
        }
        
    }

    public function actionIndex($connect) {
        $observatoriesList = Data::getObservatoriesList($connect);
        return $observatoriesList;
    }

}