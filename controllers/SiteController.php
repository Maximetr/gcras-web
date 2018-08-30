<?php

require_once(ROOT.'/models/Data.php');
require_once(ROOT.'/models/InsertData.php');
require_once(ROOT.'/components/connect.php');


class SiteController {

    /*Запуск обработчика
    $datatype - тип запрашиваемых данных;
    $mindate - нижний край временного интервала;
    $maxdate - верхний край временного интервала;
    $kod - 3-х значний МАГА-код обсерватории;
    $savedata - формат вывода данных;
    $email - email пользователя;
    */
    public function run($connect) {

        $datatype = $_POST['datatype'];
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

        $data = Data::getData($mindate, $maxdate, $kod, $savedata, $email, $datatype, $connect);
        Data::output($data, $savedata, $kod, $datatype, $connect);

    }


    public function StartInsert($connect) {

        $dataType = $_POST['dataType'];
        $inputData = $_POST['inputData'];

        if ($dataType == 'minute') {
            
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

        if ($dataType == 'hourly') {

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