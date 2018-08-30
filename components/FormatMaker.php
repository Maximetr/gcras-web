<?php

require_once(ROOT.'/components/AssistantFunctions.php');

class FormatMaker
{
    public static function WDCformat($data, $datatype)
    {
        if ($datatype == 'hourly') {
            foreach ($data as $row) {
                $observkod = $row[0];
                $year = $row[1];
                $month = $row[2];
                $element  = $row[3];
                $day = $row[4];
                $usznk = $row[6];
                $sostdays = $row[7];
                $I = $row[8];
                $basic = $row[9];
                $hoursets = array($row[10],$row[11],$row[12],$row[13],$row[14],$row[15],$row[16],$row[17],$row[18],$row[19],$row[20],$row[21],$row[22],$row[23],$row[24],$row[25],$row[26],$row[27],$row[28],$row[29],$row[30],$row[31],$row[32],$row[33],$row[34]);
                for ($j = 0; $j<=24; $j++) {
                if ($hoursets[$j] <> "9999") {
                    $hoursets[$j] = str_pad($hoursets[$j], 4, " ", STR_PAD_LEFT);
                    }
                }
                if ($usznk == "99") {
                    $usznk = "  ";
                }
                if ($sostdays == "999") {
                    $sostdays = " ";
                }
                if ($I == "9") {
                    $I = " ";
                }
                if ($day<=9){
                    $day = "0$day";
                }
                if ($month<=9){
                    $month = "0$month";
                }
                $basic = str_pad($basic, 4, "0", STR_PAD_LEFT);
    
                $resultRow = "$observkod$year$month$element$day  $usznk$sostdays$I$basic$hoursets[0]$hoursets[1]$hoursets[2]$hoursets[3]$hoursets[4]$hoursets[5]$hoursets[6]$hoursets[7]$hoursets[8]$hoursets[9]$hoursets[10]$hoursets[11]$hoursets[12]$hoursets[13]$hoursets[14]$hoursets[15]$hoursets[16]$hoursets[17]$hoursets[18]$hoursets[19]$hoursets[20]$hoursets[21]$hoursets[22]$hoursets[23]$hoursets[24]\n";
                array_shift($data);
                $resultData[] = $resultRow;
            }  
            return $resultData;
        }

        if ($datatype == 'minute') {
            foreach ($data as $row) {
                $latitude = str_pad($row[0], 6, ' ', STR_PAD_LEFT);
                $longtitude = str_pad($row[1], 6, ' ', STR_PAD_LEFT);
                
                $year = "$row[2]";
                if (strlen($year) == 1) {
                    $year = "0$year";
                }
                $month = "$row[3]";
                if (strlen($month) == 1) {
                    $month = "0$month";
                }
                $day = "$row[4]";
                if (strlen($day) == 1) {
                    $day = "0$day";
                }

                $element = $row[6];
                $hour = $row[7];
                $observkod = $row[8];
                $tableDataType = $row[9];
		$century = $row[71];

                $minuteSets = array();
                for ($i = 10; $i<=70; $i++){
                    if ($row <> '999999') {
                        $minuteSets[] = str_pad($row[$i], 6, " ", STR_PAD_LEFT);;
                    } else {
                        $minuteSets[] = $row[$i];
                    }
                }

		$resultRow = "$latitude$longtitude$year$month$day$element$hour$observkod $century$tableDataType       $minuteSets[0]$minuteSets[1]$minuteSets[2]$minuteSets[3]$minuteSets[4]$minuteSets[5]$minuteSets[6]$minuteSets[7]$minuteSets[8]$minuteSets[9]$minuteSets[10]$minuteSets[11]$minuteSets[12]$minuteSets[13]$minuteSets[14]$minuteSets[15]$minuteSets[16]$minuteSets[17]$minuteSets[18]$minuteSets[19]$minuteSets[20]$minuteSets[21]$minuteSets[22]$minuteSets[23]$minuteSets[24]$minuteSets[25]$minuteSets[26]$minuteSets[27]$minuteSets[28]$minuteSets[29]$minuteSets[30]$minuteSets[31]$minuteSets[32]$minuteSets[33]$minuteSets[34]$minuteSets[35]$minuteSets[36]$minuteSets[37]$minuteSets[38]$minuteSets[39]$minuteSets[40]$minuteSets[41]$minuteSets[42]$minuteSets[43]$minuteSets[44]$minuteSets[45]$minuteSets[46]$minuteSets[47]$minuteSets[48]$minuteSets[49]$minuteSets[50]$minuteSets[51]$minuteSets[52]$minuteSets[53]$minuteSets[54]$minuteSets[55]$minuteSets[56]$minuteSets[57]$minuteSets[58]$minuteSets[59]$minuteSets[60]\n";                $resultData[] = $resultRow;
            }
            return $resultData;
        }
    }

    public static function CSVformat($data, $datatype)
    {
        if ($datatype == 'hourly') {
            foreach ($data as $row) {
                $observkod = $row[0];
                $year = $row[1];
                $month = $row[2];
                $element  = $row[3];
                $day = $row[4];
                $usznk = $row[6];
                $sostdays = $row[7];
                $I = $row[8];
                $basic = $row[9];
                $hoursets = array($row[10],$row[11],$row[12],$row[13],$row[14],$row[15],$row[16],$row[17],$row[18],$row[19],$row[20],$row[21],$row[22],$row[23],$row[24],$row[25],$row[26],$row[27],$row[28],$row[29],$row[30],$row[31],$row[32],$row[33],$row[34]);
                for ($j = 0; $j<=24; $j++) {
                if ($hoursets[$j] <> "9999") {
                    $hoursets[$j] = str_pad($hoursets[$j], 4, " ", STR_PAD_LEFT);
                    }
                }
                if ($usznk == "99") {
                    $usznk = "  ";
                }
                if ($sostdays == "999") {
                    $sostdays = " ";
                }
                if ($I == "9") {
                    $I = " ";
                }
                if ($day<=9){
                    $day = "0$day";
                }
                if ($month<=9){
                    $month = "0$month";
                }
                $basic = str_pad($basic, 4, "0", STR_PAD_LEFT);
    
                $resultRow = "$observkod,$year,$month,$element,$day,  $usznk,$sostdays,$I,$basic,$hoursets[0],$hoursets[1],$hoursets[2],$hoursets[3],$hoursets[4],$hoursets[5],$hoursets[6],$hoursets[7],$hoursets[8],$hoursets[9],$hoursets[10],$hoursets[11],$hoursets[12],$hoursets[13],$hoursets[14],$hoursets[15],$hoursets[16],$hoursets[17],$hoursets[18],$hoursets[19],$hoursets[20],$hoursets[21],$hoursets[22],$hoursets[23],$hoursets[24],\n";
                array_shift($data);
                $resultData[] = $resultRow;
            }  
            return $resultData;
        }

        if ($datatype == 'minute') {
            foreach ($data as $row) {
                $latitude = str_pad($row[0], 6, ' ', STR_PAD_LEFT);
                $longtitude = str_pad($row[1], 6, ' ', STR_PAD_LEFT);
                
                $year = "$row[2]";
                if (strlen($year) == 1) {
                    $year = "0$year";
                }
                $month = "$row[3]";
                if (strlen($month) == 1) {
                    $month = "0$month";
                }
                $day = "$row[4]";
                if (strlen($day) == 1) {
                    $day = "0$day";
                }

                $element = $row[6];
                $hour = $row[7];
                $observkod = $row[8];
                $tableDataType = $row[9];
		$century = $row[71];

                $minuteSets = array();
                for ($i = 10; $i<=70; $i++){
                    if ($row <> '999999') {
                        $minuteSets[] = str_pad($row[$i], 6, " ", STR_PAD_LEFT);;
                    } else {
                        $minuteSets[] = $row[$i];
                    }
                }

		$resultRow = "$latitude,$longtitude,$year,$month,$day,$element,$hour,$observkod, ,$century,$tableDataType,       $minuteSets[0],$minuteSets[1],$minuteSets[2],$minuteSets[3],$minuteSets[4],$minuteSets[5],$minuteSets[6],$minuteSets[7],$minuteSets[8],$minuteSets[9],$minuteSets[10],$minuteSets[11],$minuteSets[12],$minuteSets[13],$minuteSets[14],$minuteSets[15],$minuteSets[16],$minuteSets[17],$minuteSets[18],$minuteSets[19],$minuteSets[20],$minuteSets[21],$minuteSets[22],$minuteSets[23],$minuteSets[24],$minuteSets[25],$minuteSets[26],$minuteSets[27],$minuteSets[28],$minuteSets[29],$minuteSets[30],$minuteSets[31],$minuteSets[32],$minuteSets[33],$minuteSets[34],$minuteSets[35],$minuteSets[36],$minuteSets[37],$minuteSets[38],$minuteSets[39],$minuteSets[40],$minuteSets[41],$minuteSets[42],$minuteSets[43],$minuteSets[44],$minuteSets[45],$minuteSets[46],$minuteSets[47],$minuteSets[48],$minuteSets[49],$minuteSets[50],$minuteSets[51],$minuteSets[52],$minuteSets[53],$minuteSets[54],$minuteSets[55],$minuteSets[56],$minuteSets[57],$minuteSets[58],$minuteSets[59],$minuteSets[60]\n";                $resultData[] = $resultRow;
            }
            return $resultData;
        }
    }

    public static function IAGA2002format($data, $datatype)
    {
        //если выбераем часовые данные
        if ($datatype == 'hourly') {

            $elementSet = AssistantFunctions::elementCheck($data[0], $data[1], $data[2], $data[3], $datatype);
            $_SESSION['elementSet'] = $elementSet;
            $recalculateData = AssistantFunctions::recalculateElement($data, $elementSet);

            // print_r($recalculateData);
            end($recalculateData);
            $end = key($recalculateData);
            $string = '';
            if ($elementSet == 'DHZ' or $elementSet == 'XYZ') {
                //работаем по 3 строчки
                for ($i=0; $i<=$end;) {
                    $row0 = $recalculateData[$i];
                    $row1 = $recalculateData[$i+1];
                    $row2 = $recalculateData[$i+2];
                    if ($row0[2] == $row1[2] && $row1[2] == $row2[2]) {
                        $explode_date = explode('-', $row0[2]);
                        $doy = date('z', mktime(0,0,0,$explode_date[1], $explode_date[2],$explode_date[0])) +1;
                        $doy = str_pad($doy, 3, '0', STR_PAD_LEFT);
                        for ($j=4; $j<=27; $j++) {
                            $hour = str_pad($j-4, 2, '0', STR_PAD_LEFT);
                            $el0 = str_pad($row0[$j], 9, ' ', STR_PAD_LEFT);
                            $el1 = str_pad($row1[$j], 9, ' ', STR_PAD_LEFT);
                            $el2 = str_pad($row2[$j], 9, ' ', STR_PAD_LEFT);
                            $string .= "$row0[2] $hour:30:00.000 $doy    $el0 $el1 $el2  99999.00\n";
                        }
                    }
                    $i = $i+3;
                }
            }

            if ($elementSet == 'DFHZ' or $elementSet == 'FXYZ') {
                //работаем по 4 строчки
                for ($i=0; $i<=$end;) {
                    $row0 = $recalculateData[$i];
                    $row1 = $recalculateData[$i+1];
                    $row2 = $recalculateData[$i+2];
                    $row3 = $recalculateData[$i+3];
                    if ($row0[2] == $row1[2] && $row1[2] == $row2[2] && $row2[2] == $row3[2]) {
                        $explode_date = explode('-', $row0[2]);
                        $doy = date('z', mktime(0,0,0,$explode_date[1], $explode_date[2],$explode_date[0])) +1;
                        $doy = str_pad($doy, 3, '0', STR_PAD_LEFT);
                        for ($j=4; $j<=27; $j++) {
                            $hour = str_pad($j-4, 2, '0', STR_PAD_LEFT);
                            $el0 = str_pad($row0[$j], 9, ' ', STR_PAD_LEFT);
                            $el1 = str_pad($row1[$j], 9, ' ', STR_PAD_LEFT);
                            $el2 = str_pad($row2[$j], 9, ' ', STR_PAD_LEFT);
                            $el3 = str_pad($row3[$j], 9, ' ', STR_PAD_LEFT);
                            if ($elementSet == 'DFHZ') {
                                $string .= "$row0[2] $hour:30:00.000 $doy    $el0 $el2 $el3 $el1\n";
                            } elseif ($elementSet == 'FXYZ') {
                                $string .= "$row0[2] $hour:30:00.000 $doy    $el1 $el2 $el3 $el0\n";
                            }
                        }
                    }
                    $i = $i+4;
                }  
            }
        return $string;
        }

        //если выбираем минутные значения
        if ($datatype == 'minute') {
            $elementSet = AssistantFunctions::elementCheck($data[0], $data[1], $data[2], $data[3], $datatype);
            $_SESSION['elementSet'] = $elementSet;
            end($data);
            $end = key($data);
            $string = '';
            if ($elementSet == 'DHZ' or $elementSet == 'XYZ') {
                //работаем по 3 строчки
                for ($i=0; $i<=$end;) {
                    $row0 = $data[$i];
                    $row1 = $data[$i+1];
                    $row2 = $data[$i+2];
                    if (($row0[5] == $row1[5] && $row1[5] == $row2[5]) && ($row0[7] == $row1[7] && $row1[7] == $row2[7])) {
                        $explode_date = explode('-', $row0[5]);
                        $doy = date('z', mktime(0,0,0,$explode_date[1], $explode_date[2],$explode_date[0])) +1;
                        $doy = str_pad($doy, 3, '0', STR_PAD_LEFT);
                        for ($j=10; $j<=69; $j++) {
                            $hour = $row0[7];
                            $minute = str_pad($j-10, 2, '0', STR_PAD_LEFT);
                            $el0 = str_pad($row0[$j], 6, ' ', STR_PAD_LEFT);
                            $el1 = str_pad($row1[$j], 6, ' ', STR_PAD_LEFT);
                            $el2 = str_pad($row2[$j], 6, ' ', STR_PAD_LEFT);
                            $string .= "$row0[5] $hour:$minute:00.000 $doy    $el0.00 $el1.00 $el2.00  99999.00\n";
                        }
                    }
                    $i = $i+3;
                }
            }

            if ($elementSet == 'DFHZ' or $elementSet == 'FXYZ') {
                //работаем по 4 строчки
                for ($i=0; $i<=$end;) {
                    $row0 = $data[$i];
                    $row1 = $data[$i+1];
                    $row2 = $data[$i+2];
                    $row3 = $data[$i+3];
                    if (($row0[5] == $row1[5] && $row1[5] == $row2[5] && $row2[5] == $row3[5])&& ($row0[7] == $row1[7] && $row1[7] == $row2[7] && $row2[7] == $row3[7])) {
                        $explode_date = explode('-', $row0[5]);
                        $doy = date('z', mktime(0,0,0,$explode_date[1], $explode_date[2],$explode_date[0])) +1;
                        $doy = str_pad($doy, 3, '0', STR_PAD_LEFT);
                        for ($j=10; $j<=69; $j++) {
                            $hour = $row0[7];
                            $minute = str_pad($j-10, 2, '0', STR_PAD_LEFT);
                            $el0 = str_pad($row0[$j], 6, ' ', STR_PAD_LEFT);
                            $el1 = str_pad($row1[$j], 6, ' ', STR_PAD_LEFT);
                            $el2 = str_pad($row2[$j], 6, ' ', STR_PAD_LEFT);
                            $el3 = str_pad($row3[$j], 6, ' ', STR_PAD_LEFT);
                            if ($elementSet == 'DFHZ') {
                                $string .= "$row0[5] $hour:$minute:00.000 $doy    $el0.00 $el2.00 $el3.00 $el1.00\n";
                            } elseif ($elementSet == 'FXYZ') {
                                $string .= "$row0[5] $hour:$minute:00.000 $doy    $el1.00 $el2.00 $el3.00 $el0.00\n";
                            }
                        }
                    }
                    $i = $i+4;
                }  
            }
        return $string;
            
            
        }
    }
}