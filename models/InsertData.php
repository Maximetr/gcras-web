<?php


class InsertData {
    //Метод проверки введенных пользователем данных
    public static function CheckMinute($rows) {

        $regular = '~((\\s*[0-9]{1,5})|([0-9]{6})){2}[0-9]{2}((\\s[0-9]|1[0-2])|(0[0-9]|1[0-2]))((\\s[0-9])|([0-9]{2}))(D|I|H|X|Y|Z|E|F)((\\s[0-9])|([0-9]{2}))[A-Z]{3}.(0|9|8|\\s)(P|D|\\s)\\s{7}((\\s|9|-|0-9)(\\s*-?[0-9]{1,5})){61}~';
        $lineNumber = 1;

        foreach ($rows as $row) {
            $checkResult = preg_match($regular, $row);

            if ($checkResult == false) {
                $error = "Строка номер $lineNumber не соответствует формату данных";
                return $error;
                break;
            }
            $lineNumber++;
        }
        return true;
    }

    public static function CheckHourly($rows) {

        $regular = "~([A-Z]{3})([0-9]{2})((\\s[0-9]|1[0-2])|(0[0-9]|1[0-2]))([D|H|Z|F|X|Y])((\\s|[0-3])[0-9])(\\s{2})(.{2})((\\s{2}|18|19|20))([\\s*-?0-9]{4})([\\s|9|-|0-9][\\s*-?0-9]{1,3}){25}~";
        $lineNumber = 1;

        foreach ($rows as $row) {

            $checkResult = preg_match($regular, $row);
            if ($checkResult == false) {
                $error = "Строка номер $lineNumber не соответвует формату данных";
                
                return $error;
                break;
            }
            
            $lineNumber++;
        }

        return true;
    }
    //Метод добавления проверенных данных
    public static function InsertMinute($rows, $connect) {

        $lineNumber = 1;

        foreach ($rows as $row) {
            $latitude = trim(substr($row, 0, 6), ' ');
            $longtitude = trim(substr($row, 6, 6), ' ');
            $year = substr($row, 12, 2);
            $month = trim(ltrim(substr($row, 14, 2), '0'), ' ');
            $day = trim(ltrim(substr($row, 16, 2), '0'), ' ');
            $element = substr($row, 18, 1);
            $hour = substr($row, 19, 2);
            $code = substr($row, 21, 3);
            $datatype = substr($row,24,1);
            $century = substr($row, 25, 1);
            if ($century == '') {
                if ($year >= 20 && $year <= 99) {
                    $century = '19';
                }
                if ($year >= 0 && $year <= 19) {
                    $century = '20';
                }
            }
            $date = self::makeDate($year, $month, $day);
            $minutevalues = array();
            $hourvalues = array();
            for ($i = 34, $j = strlen($row); $i < $j;) {
                if ($row[$i] == '9' && $i <> 394) {
                    $minutevalues[] = '999999';
                }   elseif ($row[$i] <> '9' && $i <> 394) {
                    $minutevalues[] = trim(substr($row,$i,6),' ');
                    }
                if ($i == 394 && $row[$i] <> '9') {
                    $hourvalues = trim(substr($row,394,6), ' ');
                }   elseif ($i == 394 && $row[$i] == '9') {
                    $hourvalues = '999999';
                }
                 $i = $i+6;
            }


            $insert = mysqli_query($connect, ("INSERT INTO `minutedata` (`Latitude`,`Longtitude`,`Year`,`Month`,`Day`,`Date`,`Element`,`Hour`,`Kod`,`DataType`,`MinuteSet1`,`MinuteSet2`,`MinuteSet3`,`MinuteSet4`,`MinuteSet5`,`MinuteSet6`,`MinuteSet7`,`MinuteSet8`,`MinuteSet9`,`MinuteSet10`,`MinuteSet11`,`MinuteSet12`,`MinuteSet13`,`MinuteSet14`,`MinuteSet15`,
                            `MinuteSet16`,`MinuteSet17`,`MinuteSet18`,`MinuteSet19`,`MinuteSet20`,`MinuteSet21`,`MinuteSet22`,`MinuteSet23`,`MinuteSet24`,`MinuteSet25`,`MinuteSet26`,`MinuteSet27`,`MinuteSet28`,`MinuteSet29`,`MinuteSet30`,
                            `MinuteSet31`,`MinuteSet32`,`MinuteSet33`,`MinuteSet34`,`MinuteSet35`,`MinuteSet36`,`MinuteSet37`,`MinuteSet38`,`MinuteSet39`,`MinuteSet40`,`MinuteSet41`,`MinuteSet42`,`MinuteSet43`,`MinuteSet44`,`MinuteSet45`,
                            `MinuteSet46`,`MinuteSet47`,`MinuteSet48`,`MinuteSet49`,`MinuteSet50`,`MinuteSet51`,`MinuteSet52`,`MinuteSet53`,`MinuteSet54`,`MinuteSet55`,`MinuteSet56`,`MinuteSet57`,`MinuteSet58`,`MinuteSet59`,`MinuteSet60`,`HourSet`, `Century`)
                            VALUES ('$latitude','$longtitude','$year','$month','$day','$date','$element','$hour','$code','$datatype','$minutevalues[0]','$minutevalues[1]','$minutevalues[2]','$minutevalues[3]','$minutevalues[4]','$minutevalues[5]','$minutevalues[6]','$minutevalues[7]','$minutevalues[8]','$minutevalues[9]','$minutevalues[10]',
                            '$minutevalues[11]','$minutevalues[12]','$minutevalues[13]','$minutevalues[14]','$minutevalues[15]','$minutevalues[16]','$minutevalues[17]','$minutevalues[18]','$minutevalues[19]','$minutevalues[20]','$minutevalues[21]','$minutevalues[22]','$minutevalues[23]','$minutevalues[24]','$minutevalues[25]','$minutevalues[26]',
                            '$minutevalues[27]','$minutevalues[28]','$minutevalues[29]','$minutevalues[30]','$minutevalues[31]','$minutevalues[32]','$minutevalues[33]','$minutevalues[34]','$minutevalues[35]','$minutevalues[36]','$minutevalues[37]','$minutevalues[38]','$minutevalues[39]','$minutevalues[40]','$minutevalues[41]','$minutevalues[42]',
                            '$minutevalues[43]','$minutevalues[44]','$minutevalues[45]','$minutevalues[46]','$minutevalues[47]','$minutevalues[48]','$minutevalues[49]','$minutevalues[50]','$minutevalues[51]','$minutevalues[52]','$minutevalues[53]','$minutevalues[54]','$minutevalues[55]','$minutevalues[56]','$minutevalues[57]','$minutevalues[58]',
                            '$minutevalues[59]','$hourvalues','$century')"));

            if ($insert) {
                echo 'Строка '.$lineNumber." успешно добавлена в бд\n";
            }   else {
                echo 'Ошибка добавления строки '.$lineNumber."\n";
            }

            unset($minutevalues);
            unset($hourvalues);
            $lineNumber++;
        }
    }

    //Метод формирования даты вида YYYY-MM-DD
    public static function makeDate($year, $month, $day) {
        if ($month < 10) {
            $month = '0'.$month;
        }
        if ($day < 10) {
            $day = '0'.$day;
        }
    
        if ($year < 25) {
            $date = '20'.$year.'-'.$month.'-'.$day;
        } else {
            $date = '19'.$year.'-'.$month.'-'.$day;
        }   
        return $date;
    }

    public static function InsertHourly($rows, $connect) {

        $lineNumber = 1;

        foreach ($rows as $row) {

            $code = substr($row, 0, 3);
            $year = substr($row, 3, 2);
            $month = ltrim(substr($row,5,2), '0');
            $element = substr($row, 7,1);
            $day = ltrim(substr($row, 8,2), '0');
            $usznk = substr($row, 12, 2);
            $sostDays = substr($row,14,1);
            $I = substr($row, 15,1);
            $century = substr($row, 14, 2);
            if ($century == '') {
                if ($year >= 20 && $year <= 99) {
                    $century = '19';
                }
                if ($year >= 0 && $year <= 19) {
                    $century = '20';
                }
            }
            $basic = ltrim(substr($row, 16, 4), '0');
            $date = self::makeDate($year, $month, $day);
            
            if ($basic == '') {
                $basic = '0';
            }
            
            if ($usznk == '  ') {
                $usznk = '99';
            }
            if ($sostDays == ' ') {
                $sostDays = '9';
            }
            if ($I == ' ') {
                $I = '9';
            }

            $hourvalues = array();
            $dayvalues = array();

            for ($i = 20, $j = strlen($row); $i < $j;) {
                if ($row[$i] == '9' && $i <> 116) {
                    $hourvalues[] = '9999';
                }   elseif ($row[$i] <> '9' && $i <> 116) {
                    $hourvalues[] = trim(substr($row,$i,4),' ');
                    }
                if ($i == 116 && $row[$i] <> '9') {
                    $dayvalues = trim(substr($row,116,4), ' ');
                }   elseif ($i == 116 && $row[$i] == '9') {
                    $dayvalues = '9999';
                }
                 $i = $i+4;
            }

            $sql = "INSERT INTO `hourdata` (`Kod`, `Year`, `Month`, `Element`, `Day`, `Date`, `UsZnk`,`SostDays`,`I`,`Basic`,
            `HourSet1`, `HourSet2`, `HourSet3`, `HourSet4`, `HourSet5`, `HourSet6`, `HourSet7`, `HourSet8`, `HourSet9`, `HourSet10`, `HourSet11`, `HourSet12`, `HourSet13`, `HourSet14`, `HourSet15`, `HourSet16`, `HourSet17`, `HourSet18`, `HourSet19`, `HourSet20`, `HourSet21`, `HourSet22`, `HourSet23`, `HourSet24`, `DailySet`, `Century`)
            VALUES ('$code', '$year', '$month', '$element', '$day', '$date', '$usznk', '$sostDays', '$I', '$basic',
            '$hourvalues[0]', '$hourvalues[1]', '$hourvalues[2]', '$hourvalues[3]', '$hourvalues[4]', '$hourvalues[5]', '$hourvalues[6]', '$hourvalues[7]', '$hourvalues[8]', '$hourvalues[9]', '$hourvalues[10]', '$hourvalues[11]', '$hourvalues[12]', '$hourvalues[13]', '$hourvalues[14]',
            '$hourvalues[15]', '$hourvalues[16]', '$hourvalues[17]', '$hourvalues[18]', '$hourvalues[19]', '$hourvalues[20]', '$hourvalues[21]', '$hourvalues[22]', '$hourvalues[23]', '$dayvalues', '$century')";
            $insert = mysqli_query($connect, $sql);

            if ($insert) {
                echo 'Строка '.$lineNumber." успешно добавлена в бд\n";
            }   else {
                echo 'Ошибка добавления строки '.$lineNumber."\n";
            }

            unset($dayvalues);
            unset($hourvalues);
            $lineNumber++;
        }

    }
}