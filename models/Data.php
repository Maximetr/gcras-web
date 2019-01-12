<?php

require_once(ROOT.'/components/FormatMaker.php');
require_once(ROOT.'/components/AssistantFunctions.php');

class Data {
    /*Проверка входных значений из формы
    $errors - массив с ошибками;
    */
    public static function Validation($mindate, $maxdate, $savedata) {
        $errors = array();

        if ($maxdate == '' or $mindate == ''){
            $errors[] = 'Временной интервал должен быть заполнен';
        }

        if ($maxdate < $mindate) {
            $errors[] = 'Неверно введен временной интервал';
        }

        if ($savedata <> 'IAGA2002' && $savedata <> 'WDC' && $savedata <> 'CSV') {
            $errors[] = 'Выбран неизвестный формат данных';
        }

        return $errors;
    }

    /*Получение необходимых данных из БД */
    public static function getData($mindate, $maxdate, $kod, $savedata, $email, $type, $connect)
    {
        //если выбираем часовые данные
        if ($type == 'hourly') {
            $data = self::getHourlyData($mindate, $maxdate, $kod, $connect, $savedata, $email);
            if ($savedata == 'WDC') {
                $data = FormatMaker::WDCformat($data, $type);
                return $data;
            }
            if ($savedata == 'CSV') {
                $data = FormatMaker::CSVformat($data, $type);
                return $data;
            }
            if ($savedata == 'IAGA2002') {
                $data = FormatMaker::IAGA2002format($data, $type);
                return $data;
            }
        }
        //если выбираем минутные данные
        if ($type == 'minute') {
            $data = self::getMinuteData($mindate, $maxdate, $kod, $savedata, $email, $connect);
            if ($savedata == 'WDC') {
                $data = FormatMaker::WDCformat($data, $type);
                return $data;
            }
            if ($savedata == 'CSV') {
                $data = FormatMaker::CSVformat($data, $type);
                return $data;
            }
            if ($savedata == 'IAGA2002') {
                $data = FormatMaker::IAGA2002format($data, $type);
                return $data;
            }
        }
    }

    public static function getHourlyData($mindate, $maxdate, $kod, $connect, $savedata, $email) {


        $data = array();
        mysqli_query($connect, ("INSERT INTO user_contacts (`email`) VALUES ('$email')"));
        if ($savedata == 'IAGA2002') {
            $query = mysqli_query($connect, ("SELECT Kod, Element, Date, Basic, HourSet1,HourSet2,HourSet3,HourSet4,HourSet5,HourSet6,HourSet7,HourSet8,HourSet9,HourSet10,HourSet11,HourSet12,HourSet13,HourSet14,HourSet15,HourSet16,HourSet17,HourSet18,HourSet19,HourSet20,HourSet21,HourSet22,HourSet23,HourSet24
                                FROM hourdata WHERE Kod LIKE '$kod' AND (Date >= '$mindate' AND Date <= '$maxdate') ORDER BY Date ASC, Element ASC"));
        } else {
            $query = mysqli_query($connect, ("SELECT * FROM hourdata WHERE Kod LIKE '$kod' AND (Date>='$mindate' AND Date<='$maxdate')"));
        }

        if ($query->num_rows == 0) {
            return false;
        }

        while ($result = mysqli_fetch_array($query, MYSQLI_NUM)) {
            $data[] = $result;
        }

        return $data;
    }

    public static function getMinuteData($mindate, $maxdate, $kod, $savedata, $email, $connect) {
        mysqli_query($connect, ("INSERT INTO user_contacts (`email`) VALUES ('$email')"));

        $data = array();

        if ($savedata == 'WDC' or $savedata == 'CSV') { 
            $query = mysqli_query($connect, ("SELECT * FROM minutedata WHERE Kod = '$kod' AND (Date >= '$mindate' AND Date <= '$maxdate') ORDER BY Day ASC"));
            while ($result = mysqli_fetch_array($query, MYSQLI_NUM)) {
                $data[] = $result;
            }
        }
        if ($savedata == 'IAGA2002') {
            $query = mysqli_query($connect, ("SELECT * FROM minutedata WHERE Kod = '$kod' AND (Date >= '$mindate' AND Date <= '$maxdate') ORDER BY Date ASC, Hour ASC, Element ASC"));
            while ($result = mysqli_fetch_array($query, MYSQLI_NUM)) {
                $data[] = $result;
            }
        }

        return $data;
    }

    public static function output($data, $savedata, $kod, $type, $connect, $dataType = '')
    {
        

        if ($savedata == 'WDC' or $savedata == 'CSV') {
            foreach ($data as $row) {
                echo $row;
            }
        }

        if ($savedata == 'IAGA2002') {
            $observatoryData = self::getObservatoryByCode($connect, $kod);
            $stationName = AssistantFunctions::mb_str_pad($observatoryData[2], 44, ' ', STR_PAD_RIGHT);
            $latitude = str_pad($observatoryData[4], 44, ' ', STR_PAD_RIGHT);
            $longitude = str_pad($observatoryData[5], 44, ' ', STR_PAD_RIGHT);
            $altitude = str_pad($observatoryData[6], 44, ' ', STR_PAD_RIGHT);
            $elementSet = $_SESSION['elementSet'];
            if ($elementSet == 'FXYZ' or $elementSet == 'XYZ') {
                $elementsRow = "DATE       TIME         DOY     $kod"."X      $kod"."Y      $kod"."Z      $kod"."F   |\n";
                $elementSet = 'XYZF';
            }
            if ($elementSet == 'DHZ' or $elementSet == 'DFHZ') {
                $elementsRow = "DATE       TIME         DOY     $kod"."D      $kod"."H      $kod"."Z      $kod"."F   |\n";
                $elementSet = 'DHZF';
            }
            if ($type == 'minute') {
                $interval = 'PT1M';
            }
            if ($type == 'hourly') {
                $interval = 'HOUR';
            }
            if ($dataType[0] == 'D') {
                $dataType[0] = 'DEFINITIVE';
            }
            $dataType = str_pad($dataType[0], 44, ' ', STR_PAD_RIGHT);
            $head = " Format                  IAGA-2002                                   |
 Source of Data                                                      |
 Station Name            $stationName|
 IAGA Code               $kod                                         |
 Geodetic Latitude       $latitude|
 Geodetic Longitude      $longitude|
 Elevation               $altitude|
 Reported                $elementSet                                        |
 Sensor Orientation                                                  |
 Digital Sampling                                                    |
 Data Interval Type      $interval                                        |
 Data Type               $dataType|
$elementsRow";
            echo $head;
            echo $data;
        }

        return true;
    }

    public static function getObservatoriesList($connect) {
        mysqli_query($connect,"set names utf8");
        $sql = "SELECT * FROM Observatories ORDER BY IAGAcode ASC";
        $query = mysqli_query($connect, $sql);

        while ($result = mysqli_fetch_array($query, MYSQLI_NUM)) {
            $observatoriesList[] = $result;
        }

        return $observatoriesList;
    }

    public static function getObservatoryByCode($connect, $kod) {
        mysqli_query($connect,"set names utf8");
        $sql = "SELECT * FROM Observatories WHERE IAGAcode LIKE '$kod'";
        $query = mysqli_query($connect, $sql);

        $result = mysqli_fetch_array($query, MYSQLI_NUM);
        $observatoryData = $result;

        return $observatoryData;
    }
    public static function getDataType($connect, $mindate,$maxdate,$kod)
    {
        $sql = "SELECT DataType FROM minutedata WHERE Kod = '$kod' AND (Date >= '$mindate' AND Date <= '$maxdate') LIMIT 1";
        $query = mysqli_query($connect, $sql);

        $result = mysqli_fetch_row($query);
        return $result;
    }
}
