<?php
include "../mysql.php";

    $tableAr = array('action', 'position', 'c_order', 'client', 'prod', 'storage', 'employee');
    $tableArCuctomNames = array('Акции', 'Должности', 'Заказы', 'Клиенты', 'Производство', 'Склад', 'Сотрудники');
    $a = 0;
				
    foreach($tableAr as $tableName){
        switch($tableName){
            case 'action':
                            $query = 'id_action, name';
                            $idFoAjax = 'id_action';
                            $slug = 'student';
                            break;
                            
                        case 'position':
                            $query = 'id_pos, position';
                            $idFoAjax = 'id_pos';
                            $slug = 'position';
                            break;
							
						case 'c_order':
                            $query = 'id_order, date_order';
                            $idFoAjax = 'id_order';
                            $slug = 'с_order';
                            break;
							
						case 'client':
                            $query = 'id_client, name, surname';
                            $idFoAjax = 'id_client';
                            $slug = 'client';
                            break;
							
						case 'prod':
                            $query = 'id_prod, date';
                            $idFoAjax = 'id_prod';
                            $slug = 'prod';
                            break;
							
						case 'storage':
                            $query = 'id_item, name';
                            $idFoAjax = 'id_item';
                            $slug = 'storage';
                            break;
							
						case 'employee':
                            $query = 'id_emp, name, surname';
                            $idFoAjax = 'id_emp';
                            $slug = 'employee';
                            break;
        }

        $tableInfo = mysqli_query($link, "SELECT $query FROM $tableName");

        echo '<li class="table_handler">
        <div class="table_name" id="'. $tableName .'"><p>'.
        $tableArCuctomNames[$a]
        .'</p>
        <div class="table_name_arrow">
        <img class="arrow" src="img/images.png">
        </div>
        </div>
        <ul class="table_row_list" id="'. ($a+1) .'">';
        if($tableInfo){
            while($tableInfoFetch = mysqli_fetch_array($tableInfo)){
                echo '<li class="table_row" id="'. $tableInfoFetch[$idFoAjax] .'" slug="'. $slug .'"><p>'.

                $tableInfoFetch[0]. " " . $tableInfoFetch[1]

                .'</p></li>';
            }
        }    
        echo '</ul>
        </li>';
        $a++;
    }
?>