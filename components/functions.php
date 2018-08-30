<?php

//Функция проверки элементов
function ElementChek($table) {
    $flag = 'XYZF';
        for ($i = 0; $i <=10; $i++) {
            if  ($table[$i][1] == 'D' or $table[$i][1] == 'H') {
                $flag = 'DHZF';
                break;
            }
        }
    return $flag;
}

//Функция расчета значений для элементов
function MyCount($element, $basic, $znach) {
    if ($znach == '9999') {
        $value = '99999.00';
    }   elseif ($element == 'D' or $element == 'I') {
            $value = ($basic * 60) + ($znach / 10);
    }   else { 
            $value = $basic * 100 + $znach;
        }
    return $value;
}

//Функция работы со строкой
function RowJob($row1, $row2, $row3, $row4) {
    $array = array();
    $date = $row1[2];
    $explode_date = explode('-', $date);
    $doy = date('z', mktime(0,0,0,$explode_date[1], $explode_date[2],$explode_date[0])) +1;
    $hour = 0;
    if ($doy <10) {
        $doy = "00$doy";
    }   elseif ($doy >9 && $doy<100) {
        $doy = "0$doy";
    }   else {
        $doy = "$doy";
    }
    if ($row2[2] == $date && $row3[2] == $date && $row4[2] == $date) {
        for ($i = 4, $j = 0; $i<=27; $i++, $j++) {
           
            $el1 = MyCount($row1[1], $row1[3], $row1[$i]);
            $el2 = MyCount($row2[1], $row2[3], $row2[$i]);
            $el3 = MyCount($row3[1], $row3[3], $row3[$i]);
            $el4 = MyCount($row4[1], $row4[3], $row4[$i]);
            $string = "$date $hour:30:00.000 $doy    $el1 $el2 $el3 $el4\n";
            $array[$j][0] = $date;
            if ($hour < 10){
                $array[$j][1] = "0$hour:30.00.000";
            }   else {
                $array[$j][1] = "$hour:30.00.000";
            }
            $array[$j][2] = $doy;
            //перестановка первого элемента
            if ($row1[1] == 'D' or $row1[1] == 'X') {
                $array[$j][3] = $el1;
            }   elseif ($row1[1] == 'H' or $row1[1] == 'Y') {
                    $array[$j][4] = $el1;
            }   elseif ($row1[1] == 'Z'){
                    $array[$j][5] = $el1;
            }   else {$array[$j][6] = $el4;}
            //перестановка второго элемента
            if ($row2[1] == 'D' or $row2[1] == 'X') {
                $array[$j][3] = $el2;
            }   elseif ($row2[1] == 'H' or $row2[1] == 'Y') {
                    $array[$j][4] = $el2;
            }   elseif ($row2[1] == 'Z'){
                    $array[$j][5] = $el2;
            }else {$array[$j][6] = $el4;}
            //перестановка третьего элемента
            if ($row3[1] == 'D' or $row3[1] == 'X') {
                $array[$j][3] = $el3;
            }   elseif ($row3[1] == 'H' or $row3[1] == 'Y') {
                    $array[$j][4] = $el3;
            }   elseif ($row3[1] == 'Z'){
                    $array[$j][5] = $el3;
            }else {$array[$j][6] = $el4;}
            //перестановка четвертого элемента
            if ($row4[1] == 'D' or $row4[1] == 'X') {
                $array[$j][3] = $el4;
            }   elseif ($row4[1] == 'H' or $row4[1] == 'Y') {
                    $array[$j][4] = $el4;
            }   elseif ($row4[1] == 'Z'){
                    $array[$j][5] = $el4;
            }else {$array[$j][6] = $el4;}
            $hour++;
        }
    }   elseif ($row1[1] != 'F' && $row2[1] != 'F' && $row3[1] != 'F' && $row4[1] != 'F') {
            for ($i = 4, $j = 0; $i<=27; $i++, $j++) {
                $el1 = MyCount($row1[1], $row1[3], $row1[$i]);
                $el2 = MyCount($row2[1], $row2[3], $row2[$i]);
                $el3 = MyCount($row3[1], $row3[3], $row3[$i]);
                //$el4 = MyCount($row4[1], $row4[3], $row4[$i]);
                $string = "$date $hour:30:00.000 $doy    $el1 $el2 $el3 99999.00\n";
                
                $array[$j][0] = $date;
                if ($hour < 10){
                    $array[$j][1] = "0$hour:30.00.000";
                }   else {
                    $array[$j][1] = "$hour:30.00.000";
                }
                $array[$j][2] = $doy;
                //перестановка первого элемента
                if ($row1[1] == 'D' or $row1[1] == 'X') {
                    $array[$j][3] = $el1;
                }   elseif ($row1[1] == 'H' or $row1[1] == 'Y') {
                        $array[$j][4] = $el1;
                }   elseif ($row1[1] == 'Z'){
                        $array[$j][5] = $el1;
                }
                //перестановка второго элемента
                if ($row2[1] == 'D' or $row2[1] == 'X') {
                    $array[$j][3] = $el2;
                }   elseif ($row2[1] == 'H' or $row2[1] == 'Y') {
                        $array[$j][4] = $el2;
                }   elseif ($row2[1] == 'Z'){
                        $array[$j][5] = $el2;
                }
                //перестановка третьего элемента
                if ($row3[1] == 'D' or $row3[1] == 'X') {
                    $array[$j][3] = $el3;
                }   elseif ($row3[1] == 'H' or $row3[1] == 'Y') {
                        $array[$j][4] = $el3;
                }   elseif ($row3[1] == 'Z'){
                        $array[$j][5] = $el3;
                }
                $array[$j][6] = '99999.00';
                $hour++;
            }
    }
    return $array;
}

//Функция вывода
function output($array, $elements,$KOD) {
    if ($elements == 'DHZF') {
        $el11 = 'D';
        $el22 = 'H';
        $el33 = 'Z';
        $el44 = 'F';
    } else {
        $el11 = 'X';
        $el22 = 'Y';
        $el33 = 'Z';
        $el44 = 'F';
    }

echo " Format                  IAGA-2002                                   |
 Source of Data                                                      |
 Station Name                                                        |
 IAGA Code               $KOD                                         |
 Geodetic Latitude                                                   |
 Geodetic Longitude                                                  |
 Elevation                                                           |
 Reported                $elements                                        |
 Sensor Orientation                                                  |
 Digital Sampling                                                    |
 Data Interval Type      HOUR                                        |
 Data Type                                                           |
 DATE       TIME         DOY     " . $KOD . "$el11      " . $KOD . "$el22      " . $KOD . "$el33      " . $KOD . "$el44  |\n";
    foreach ($array as $level1) {
        foreach ($level1 as $level2) {
            $date = $level2[0];
            $time = $level2[1];
            $doy = $level2[2];
            $el1 = $level2[3];
            $el2 = $level2[4];
            $el3 = $level2[5];
            $el4 = $level2[6];
            if (is_int($el1)) {
                $el1 = "$el1.00";
            }   elseif (is_float($el1)) {
                $el1 = "$el1"."0";
            }

            if (is_int($el2)) {
                $el2 = "$el2.00";
            }   elseif (is_float($el2)) {
                $el2 = "$el2"."0";
            }

            if (is_int($el3)) {
                $el3 = "$el3.00";
            }   elseif (is_float($el3)) {
                $el3 = "$el3"."0";
            }

            if (is_int($el4)) {
                $el4 = "$el4.00";
            }   elseif (is_float($el4)) {
                $el4 = "$el4"."0";
            }

            $el1 = str_pad($el1, 9, " ", STR_PAD_LEFT);
            $el2 = str_pad($el2, 9, " ", STR_PAD_LEFT);
            $el3 = str_pad($el3, 9, " ", STR_PAD_LEFT);
            $el4 = str_pad($el4, 9, " ", STR_PAD_LEFT);

            
            $string = "$date $time $doy    $el1 $el2 $el3 $el4\n";
            echo $string;
        }
    }
}