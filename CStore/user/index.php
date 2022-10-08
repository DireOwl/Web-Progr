<?php
session_start();

include "../mysql.php";
include "../functions.php";

checkForSession('admin', $link);

if(isset($_POST['clear'])){
    session_destroy();
    header("Location:" . $_SERVER['PHP_SELF']);
    checkForSession('admin', $link);
}

?>
<!DOCTYPE>
<html>
	<head>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
		<link href="../style.css" rel="stylesheet">
	</head>
	
	<body style="background: azure; margin: 0px;">
	<div id="0"></div>
		<div class="sidebar"><!--Сайдбар-->
			<ul class="table_list">
				
				
			</ul>
		</div>
		
		<div style="margin-left: 250px; height: 100%;">
			<div class="table"> <!--Таблица-->
				
            </div>
            <div class="criteria_field"><!--Поле поиска-->
                
            </div><!--Поле поиска-->
			<div class="profile_admin">
				<p style="max-width: 100%; display: inline-block; margin: 3px;">Учетная запись администратора</p>
				<form style="display: inline" method="post">
                <input class="logout_button" name="clear" type="submit" value="Выход">
            </form>
        </div>
		</div>
    <script src="jquery-3.6.0.min.js"></script>
    <script src="functions.js"></script>
	<script>
	 $(document).ready(function(){
         var defaultId = '0';
         var rowId = defaultId;
         
         getSideBar(rowId);
         
         $(document).on('click', '[class="table_name"]', function(){
             $('.table_row').removeClass('table_row_selected');
             
			 var TableName = $(this).attr('id');
             $('.table').attr('name', TableName);
             var DataAr = [1];
             
			 getTable(TableName, DataAr);
			 getCriteriaField(TableName);
             
             $('.arrow').removeClass('rotate');
             var rowElem = $(document.getElementById(rowId));
             var a = rowId;
             rowElem.slideToggle(600);
             
             rowId = $(this).parent().children('.table_row_list').attr('id');
             if(a == rowId){rowId = defaultId; return false;}
             $(this).parent().children('.table_row_list').slideToggle(600);
             $(this).children().children('.arrow').addClass('rotate');
         });
         
         $(document).on('click', '[name="daa_button"]', function(){
             var witchBut = $(this).attr('class');
             var TableName = $('.table').attr('name');

             switch(witchBut){
                case 'element element_alt':
                        var action = 'alt';
                        var infoFieldAmount = $(this).parent().children('div.element').length;

                        var altId = $(this).attr('id');
                        var altColumn = $(this).attr('altcolumn');

                        var elemsToColor = $('.addRow').children('div.addElement');
                        var elemsToAlt = $(this).parent().children('div.element');
                        var elemsToPut = $('.addRow').children('div.addElement').children();

                        for(let i=0; i<infoFieldAmount; i++){

                            if(elemsToPut[i].getAttribute('class') == 'criteria_select'){
                                elemsToPut[i].children[0].setAttribute('value', elemsToAlt[i].innerText);
                                elemsToPut[i].children[0].innerText = elemsToAlt[i].innerText;
                            }else{
                                elemsToPut[i].setAttribute('value', elemsToAlt[i].innerText);
                            }
                            elemsToColor[i].style.backgroundColor = '#c6c6f6';
                        }
                        $('.element_add').attr('name', 'sendAltBut');
                        $('[name="sendAltBut"]').click(function(){
                            var criteriaAr = getCriteriaAr(infoFieldAmount, 'critId');
                            var a = criteriaAr.length;
                            criteriaAr.push([]);
                            criteriaAr[a][0] = altColumn;
                            criteriaAr[a][1] = altId;
                            addDelAltAjax(criteriaAr, action, TableName, rowId);
                        });
                     break;
                     
                case 'element element_del':
                        var action = 'del';
                        var criteriaAr = [$(this).attr('id'), $(this).attr('delcolumn')];
                     
                        addDelAltAjax(criteriaAr, action, TableName, rowId);
                     break;
                    
                case 'element element_add':
                     var action = 'add';
                     var amount = document.getElementsByName('addCrit').length;
                     var criteriaAr = getCriteriaAr(amount, 'critId');
                     
                     addDelAltAjax(criteriaAr, action, TableName, rowId);
                     break;
                    }
         });
         
         $(document).on('click', '[class="table_row"]', function(){
			 let rowName = $(this).attr('id');
             let rowSlug = $(this).attr('slug');

             $.ajax({
                url: 'tablegen.php',
                type: 'POST',
                dataType: 'html',
                data: {
                    rowName: rowName,
                    rowSlug:rowSlug,
                },success: function(data){
                    $('.table').html(data);
                    }
                });
			 
			 
            $('.table_row').removeClass('table_row_selected');
            $(this).addClass('table_row_selected');
         });
     });
	</script>
	</body>
</html>