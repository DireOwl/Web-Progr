<?php
include "../mysql.php";

$tableName = $_POST['tableName'];
$criteriaAr = $_POST['criteriaAr'];
$action = $_POST['action'];

echo $tableName . $criteriaAr . $action;

switch($action){
    case 'add':
        $columnsAr = "";  
	    $valuesAr = "";
        $itter = 0;
        $a = count($criteriaAr);
        for($i=0; $i<$a; $i++){
            if($itter > 0){
                $columnsAr = $columnsAr . ', ';
                $valuesAr = $valuesAr . ', ';
            }
            $columnsAr = $columnsAr . $criteriaAr[$i][0];
            $valuesAr = $valuesAr . "'". $criteriaAr[$i][1] . "'";
            $itter++;
        }
        $query = mysqli_query($link, "INSERT INTO $tableName ($columnsAr) VALUES ($valuesAr)");
		
		$login = $criteriaAr[0][1];
        $password = $criteriaAr[0][1];
        $query = mysqli_query($link, "INSERT INTO users (`login`, `password`, `privilege`) VALUES ($login, $password, 'user')");
        break;
        
    case 'del':
        $delColumn = $criteriaAr[1];
        if(ctype_digit($criteriaAr[0])){
            $delquery = $criteriaAr[0];
        }else{
            $delquery = "'" . $criteriaAr[0] . "'";
        }
        $query = mysqli_query($link, "DELETE FROM $tableName WHERE $tableName.$delColumn = $delquery");
		
		$query = mysqli_query($link, "DELETE FROM users WHERE login = $delquery");
        break;
        
    case 'alt':
        $setParams = "";
        $a = count($criteriaAr);
        $altColumn = $criteriaAr[$a-1][0];
        $altId = $criteriaAr[$a-1][1];
        
        if(!ctype_digit($altId)){
            $altId = "'". $altId ."'";
        }
        
        for($i=0; $i<$a-1; $i++){
            if($itter > 0){
                $setParams = $setParams . ', ';
            }
            
            if(ctype_digit($criteriaAr[$i][1])){
                 $setParams = $setParams . $criteriaAr[$i][0] .' = '. $criteriaAr[$i][1];
            }else{
                 $setParams = $setParams . $criteriaAr[$i][0] .' = '."'". $criteriaAr[$i][1] . "'";
            }
            $itter++;
        }
        $query = mysqli_query($link, "UPDATE $tableName SET $setParams WHERE $tableName.$altColumn = $altId");
        break;
}


?>