<?php
include "../mysql.php";
$tableName = $_POST['TableName'];

switch($tableName){
    case 'action':
            $settingsAr = array( 
                array('Код Акции', false, 'none', 'none', 'id_action'), 
                array('Дата Начала', false, 'none', 'none', 'begin'), 
                array('Дата Окончания', false, 'none', 'none', 'end'),
                array('Название', false, 'none', 'none', 'name'),
                array('Условия', false, 'none', 'none', 'condition')
            );
        break;

    case 'position':
            $settingsAr = array(
                array('Код Должности', false, 'none', 'none', 'is_pos'),
                array('Название Должности', false, 'none', 'none', 'position'),
                array('Зарплата', false, 'none', 'none', 'salary')
            );
        break;
		
    case 'order':
            $settingsAr = array(
                array('Код Заказа', false, 'none', 'none', 'id_order'),
                array('Код Клиента', false, 'none', 'none', 'id_client'),
                array('Код Акции', false, 'none', 'none', 'id_action'),
				array('Код Товара', false, 'none', 'none', 'id_item'),
				array('Дата Заказа', false, 'none', 'none', 'date_order'),
				array('Дата Выдачи', false, 'none', 'none', 'date_issue'),
				array('Стоимость', false, 'none', 'none', 'cost'),
				array('Состояние Заказа', true, false, array('Готовится', 'Выдан'), 'status'),
				array('Код Сотрудника', false, 'none', 'none', 'id_emp'),
            );
		break;
		
		case 'client':
            $settingsAr = array(
                array('Код Клиента', false, 'none', 'none', 'id_client'),
                array('Имя', false, 'none', 'none', 'name'),
                array('Фамилия', false, 'none', 'none', 'surname'),
                array('Отчество', false, 'none', 'none', 'middle_name'),
                array('Адрес', false, 'none', 'none', 'address'),
                array('Номер Счета', false, 'none', 'none', 'acc_num'),
                array('Номер Телефона', false, 'none', 'none', 'ph_num'),
                array('E-mail', false, 'none', 'none', 'E_mail'),
                array('Индекс', false, 'none', 'none', 'index'),
            );
		break;
		
		case 'prod':
            $settingsAr = array(
                array('Код Производства Партии', false, 'none', 'none', 'id_prod'),
                array('Дата', false, 'none', 'none', 'date'),
                array('Количество', false, 'none', 'none', 'amount'),
                array('Название', false, 'none', 'none', 'name'),
                array('Состав', false, 'none', 'none', 'structure'),        
            );
		break;
		
		case 'storage':
            $settingsAr = array(
                array('Код Товара', false, 'none', 'none', 'id_item'),
                array('Код Производства Партии', false, 'none', 'none', 'id_prod'),
                array('Название', false, 'none', 'none', 'name'),
                array('Размеры', false, 'none', 'none', 'size'),
                array('Количество', false, 'none', 'none', 'amount'),
                array('Цена', false, 'none', 'none', 'cost'),
            );
		break;
		
		case 'employee':
            $settingsAr = array(
                array('Код Сотрудника', false, 'none', 'none', 'id_emp'),
                array('Код Должности', false, 'none', 'none', 'id_pos'),
                array('Имя', false, 'none', 'none', 'name'),
                array('Фамилия', false, 'none', 'none', 'surname'),
                array('Отчество', false, 'none', 'none', 'mid_name'),
                array('Дата Рождения', false, 'none', 'none', 'birth'),
                array('Номер Телефона', false, 'none', 'none', 'ph_num'),
                array('Домашний Адрес', false, 'none', 'none', 'address'),
            );
		break;
	
}   		

$arrayLength = count($settingsAr);

echo '<ul class="criteria_field_criteria_list">';
    for($i=0; $i<$arrayLength; $i++){
        if($settingsAr[$i][1] == true){
            echo '<li class="criteria_field_criteria"><select class="criteria_select" name="criteria_selected" id="opt'.$i.'" slug="'.$settingsAr[$i][4].'"><option class="criteria_option" value="">'.$settingsAr[$i][0].'</option>';
            if($settingsAr[$i][2] == true){
                $tableName = $settingsAr[$i][3][0];
                $columnName = $settingsAr[$i][3][1];
                
                $optionsListQuery = mysqli_query($link, "SELECT $columnName FROM $tableName");
                if($optionsListQuery){
                    while($optionsListFetch = mysqli_fetch_array($optionsListQuery)){
                        echo '<option class="criteria_option" value="'.$optionsListFetch[$columnName].'">'.$optionsListFetch[$columnName].'</option>';
                    }
                }
            }elseif($settingsAr[$i][2] == false){
                $massLength = count($settingsAr[$i][3]);
                for($m=0;$m<$massLength;$m++){
                    echo '<option class="criteria_option" value="'.$settingsAr[$i][3][$m].'">'.$settingsAr[$i][3][$m].'</option>';
                }
            }
            
            echo '</select></li>';
        }elseif($settingsAr[$i][1] == false){
            echo '<li class="criteria_field_criteria"><input class="criteria_input" type="text" placeholder="'.$settingsAr[$i][0].'" name="criteria_selected" id="opt'.$i.'" slug="'.$settingsAr[$i][4].'"></li>';
        }  
    }
echo '</ul>
        <div class="criteria_button_handler">
        <button class="criteria_button">Найти</button>
        </div>';
?>