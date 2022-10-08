<?php
include "../mysql.php";

$tableName = $_POST['TableName'];
$rowName = $_POST['rowName'];
$slug = $_POST['rowSlug'];
	 
if($_POST[DataAr][0] == 1){
    $query = 1;
}else{
    $query = $_POST[DataAr];
}

if($query != 1 && !$_POST['rowName']){
    $critariaAr = $query;
    $query = '';
    $itter = 0;

    foreach($critariaAr as $critariaArElem){
        if($critariaArElem[1] != NULL){
            if($itter > 0){
                $query = $query . ' AND ';
            }

            if(ctype_digit($critariaArElem[1])){
                $query = $query . $critariaArElem[0] .'='. $critariaArElem[1];
            }else{
                $trim = trim($critariaArElem[1]);
                $query = $query . $critariaArElem[0] .'='."'". $trim ."'";
            }
            $itter++;
         }
    }
}

//проверка на нахождение в главной таблице
if(!$_POST['rowName']){	
    //проверка на имя загружаемой таблицы, изменение содержимого переменных
	switch($tableName){
		
		case 'action':
			$customTableNames = array('Код Акции', 'Дата Начала', 'Дата Окончания', 'Название', 'Условия');
			$headerMessage = 'Список Акций';
            $onDeleteId = 'id_action';
            $settingsAr = array( 
                array('Код Акции', false, 'none', 'none', 'id_action'), 
                array('Дата Начала', false, 'none', 'none', 'begin'), 
                array('Дата Окончания', false, 'none', 'none', 'end'),
                array('Название', false, 'none', 'none', 'name'),
                array('Условия', false, 'none', 'none', 'condition')
            );
		break;

		case 'position':
			$customTableNames = array('Код Должности', 'Название Должности', 'Зарплата');
			$headerMessage = 'Список Должностей';
            $onDeleteId = 'id_pos';
            $settingsAr = array(
                array('Код Должности', false, 'none', 'none', 'id_pos'),
                array('Название Должности', false, 'none', 'none', 'position'),
                array('Зарплата', false, 'none', 'none', 'salary')
            );
		break;
		
		case 'c_order':
			$customTableNames = array('Код Заказа', 'Код Клиента', 'Код Акции', 'Код товара', 'Дата Заказа', 'Дата Выдачи', 'Стоимость', 'Статус', 'Код Работника');
			$headerMessage = 'Список Заказов';
            $onDeleteId = 'id_order';
            $settingsAr = array(
                array('Код Заказа', false, 'none', 'none', 'id_order'),
                array('Код Клиента', false, 'none', 'none', 'id_client'),
                array('Код Акции', false, 'none', 'none', 'id_action'),
                array('Код Товара', false, 'none', 'none', 'id_item'),
                array('Дата Заказа', false, 'none', 'none', 'data_order'),
                array('Дата Выдачи', false, 'none', 'none', 'data_issue'),
                array('Стоимость', false, 'none', 'none', 'cost'),
                array('Статус', false, 'none', 'none', 'status'),
                array('Код Работника', false, 'none', 'none', 'id_emp')
            );
		break;
		
		case 'client':
			$customTableNames = array('Код Клиента', 'Имя', 'Фамилия', 'Отчетство', 'Адрес', 'Номер Счета', 'Номер Телефона', 'E-mail', 'Индекс');
			$headerMessage = 'Список Клиентов';
            $onDeleteId = 'id_client';
            $settingsAr = array(
                array('Код Клиента', false, 'none', 'none', 'id_client'),
                array('Имя', false, 'none', 'none', 'name'),
                array('Фамилия', false, 'none', 'none', 'surname'),
                array('Отчество', false, 'none', 'none', 'middle_name'),
                array('Адрес', false, 'none', 'none', 'address'),
                array('Номер Счета', false, 'none', 'none', 'acc_num'),
                array('Номер Телефона', false, 'none', 'none', 'ph_num'),
                array('E-mail', false, 'none', 'none', 'E_mail'),
                array('Индекс', false, 'none', 'none', 'index')
            );
		break;
		
		case 'prod':
			$customTableNames = array('Код Производства Партии', 'Дата', 'Количество', 'Название', 'Состав');
			$headerMessage = 'Список Производства';
            $onDeleteId = 'id_prod';
            $settingsAr = array(
                array('Код Производства Партии', false, 'none', 'none', 'id_prod'),
                array('Дата', false, 'none', 'none', 'date'),
                array('Количество', false, 'none', 'none', 'amount'),
                array('Название', false, 'none', 'none', 'name'),
                array('Состав', false, 'none', 'none', 'structure')       
            );
		break;
		
		case 'storage':
			$customTableNames = array('Код Товара', 'Код Производства Партии', 'Название', 'Размеры', 'Количество', 'Цена');
			$headerMessage = 'Список Товаров';
            $onDeleteId = 'id_item';
            $settingsAr = array(
                array('Код Товара', false, 'none', 'none', 'id_item'),
                array('Код Производства Партии', false, 'none', 'none', 'id_prod'),
                array('Название', false, 'none', 'none', 'name'),
                array('Размеры', false, 'none', 'none', 'size'),
                array('Количество', false, 'none', 'none', 'amount'),
                array('Цена', false, 'none', 'none', 'cost')
            );
		break;
		
		case 'employee':
			$customTableNames = array('Код Сотрудника', 'Код должности', 'Имя', 'Фамилия', 'Отчество', 'Дата Рождения', 'Номер телефона', 'Домашний адрес');
			$headerMessage = 'Список Сотрудников';
            $onDeleteId = 'id_emp';
            $settingsAr = array(
                array('Код Сотрудника', false, 'none', 'none', 'id_emp'),
                array('Код Должности', false, 'none', 'none', 'id_pos'),
                array('Имя', false, 'none', 'none', 'name'),
                array('Фамилия', false, 'none', 'none', 'surname'),
                array('Отчество', false, 'none', 'none', 'mid_name'),
                array('Дата Рождения', false, 'none', 'none', 'birth'),
                array('Номер Телефона', false, 'none', 'none', 'ph_num'),
                array('Домашний Адрес', false, 'none', 'none', 'address')
            );
		break;
	}

    //вывод заголовка таблицы, вывод названий столбцов
	echo '<div class="table_header"><h1>'. $headerMessage .'</h1><div class="row" style="margin-left: 0px;">';
	foreach($customTableNames as $customTable){
		echo '<div class="element columnName"><p>'. $customTable .'</p></div>';
	}
	echo '</div></div>'; 
		
    //создание запроса к БД на выборку
	$tableQuery = mysqli_query($link, "SELECT * FROM $tableName WHERE $query"); 

    //скрипт вывода сожержимого таблиц
	if($tableQuery){
		while($tableFetch = mysqli_fetch_array($tableQuery)){
        //запрос на получение названий столбцов текущей таблицы
		$tableColumns = mysqli_query($link, "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'$tableName'");
		echo '<div class="row">';
			if($tableColumns){
				while($tableColumnsFetch = mysqli_fetch_array($tableColumns)){
                //вывод информации из каждого стобца, занесение ее в строку на сайте
				$columnName = $tableColumnsFetch['COLUMN_NAME'];

				echo '<div class = "element">' . $tableFetch[$columnName] . '</div>';
                    if($columnName == $onDeleteId){
                            $deleteId = $tableFetch[$columnName];
                    }
				}
			}
		echo '<button class="element element_alt" name="daa_button" id="'.$deleteId.'" altColumn="'.$onDeleteId.'"><img width="100%" src="img/alter.png"></button>
                <button class="element element_del" id="'.$deleteId.'" name="daa_button" delColumn="'.$onDeleteId.'"><img width="100%" src="img/delete.png"></button></div>';
		}
        //подсчет длинны массива настроек, устанавливает количество полей ввода
        $arrayLength = count($settingsAr);
        echo '<div class="row addRow">';
            for($i=0; $i<$arrayLength; $i++){
            //если второй параметр = true, то это значит, что поле должно быть с выбором параметров(select)
            if($settingsAr[$i][1] == true){
                echo '<div class="element addElement"><select class="criteria_select" id="critId'.$i.'" name="addCrit" slug="'.$settingsAr[$i][4].'">
                <option class="criteria_option" value="">'.$settingsAr[$i][0].'</option>';
                //если третий параметр массива = true, то это значит, что выпадающий список формируется из данных БД
                if($settingsAr[$i][2] == true){
                    //получение из массива название таблицы и колонки, из которой скрипт получает информацию
                    $tableName = $settingsAr[$i][3][0];
                    $columnName = $settingsAr[$i][3][1];

                    $optionsListQuery = mysqli_query($link, "SELECT $columnName FROM $tableName");
                    if($optionsListQuery){
                        while($optionsListFetch = mysqli_fetch_array($optionsListQuery)){
                            echo '<option class="criteria_option" value="'.$optionsListFetch[$columnName].'">'.$optionsListFetch[$columnName].'</option>';
                        }
                    }
                //если третий параметр = false, то выборка идет не из БД, а из данных в самом массиве
                }elseif($settingsAr[$i][2] == false){
                    //подсчет длинны массива, который содержит информацию для полей ввода
                    $massLength = count($settingsAr[$i][3]);
                    for($m=0;$m<$massLength;$m++){
                        echo '<option class="criteria_option" value="'.$settingsAr[$i][3][$m].'">'.$settingsAr[$i][3][$m].'</option>';
                    }
                }

                echo '</select></div>';
            //если второй параметр = false, то скрипт просто формирует поле input
            }elseif($settingsAr[$i][1] == false){
                echo '<div class="element addElement"><input class="criteria_input" type="text" placeholder="'.$settingsAr[$i][0].'" id="critId'.$i.'" name="addCrit" slug="'.$settingsAr[$i][4].'"></div>';
            }  
        }
        echo '<button class="element element_add" name="daa_button"><img width="100%" src="img/add.png"></button></div>';
	}
}

?>