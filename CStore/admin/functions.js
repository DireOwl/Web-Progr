function getTable(TableName, DataAr){
    $.ajax({
        url: 'tablegen.php',
        type: 'POST',
        dataType: 'html',
        data: {
        TableName: TableName,
        DataAr:DataAr,
        },success: function(data){
            $('.table').html(data);

            var rowWidth = document.querySelector('.row').offsetWidth;
            var tableHeader = $('.table_header');
            tableHeader.css('width', rowWidth);
        }
    });
}

function getSideBar(rowId){
    $.ajax({
        url: 'sidebargen.php',
        type: 'POST',
        dataType: 'html',
        data: {
        },success: function(data){
            $('.table_list').html(data); 
             var rowElem = $(document.getElementById(rowId));
             rowElem.slideToggle(550);
             
             rowElem.parent().children('.table_info').children('.table_name_arrow').children('.arrow').addClass('rotate');
            }
        });
}

function addDelAltAjax(criteriaAr, action, tableName, rowId){
    $.ajax({
        url: 'addDelAlt.php',
        type: 'POST',
        dataType: 'html',
        data: {
            criteriaAr: criteriaAr,
            action: action,
            tableName: tableName,
        },success: function(data){
            var dataAr = [1];
            getTable(tableName, dataAr);
            getSideBar(rowId);
        }
    });
}

function getCriteriaAr(critHandAmount, id){
    var criteriaAr = [];  
    var counter = 0;
    var flag;
    for(var i=0; i < critHandAmount; i++){
        var idToGet = id + i;
        var criteriaName = document.getElementById(idToGet).getAttribute('slug');
        var criteriaContent = document.getElementById(idToGet).value;
        if(criteriaContent == ""){
            return false;
        }
        criteriaAr.push([]);
        criteriaAr[i][0] = criteriaName;
        criteriaAr[i][1] = criteriaContent; 
    }
    return criteriaAr;
}

function getCriteriaField(TableName){
    $.ajax({
        url: 'criteriafield.php',
        type: 'POST',
        dataType: 'html',
        data: {
            TableName: TableName,
        },success: function(data){
            $('.criteria_field').html(data);
            
            $('.criteria_button').click(function(){
                var critAmount = document.getElementsByName('criteria_selected').length;
                var criteriaAr = [];  
                var counter = 0;
                for(var i=0; i < critAmount; i++){
                    var idToGet = 'opt' + i;
                    var criteriaName = document.getElementById(idToGet).getAttribute('slug');
                    var criteriaContent = document.getElementById(idToGet).value;
                    if(criteriaContent == ""){
                        counter=counter+1;
                    }
                    criteriaAr.push([]);
                    criteriaAr[i][0] = criteriaName;
                    criteriaAr[i][1] = criteriaContent; 
                }
                console.log(criteriaAr);
                if(counter == criteriaAr.length){
                    criteriaAr = [1];
                }
                getTable(TableName, criteriaAr);
                });
            }
        });
}