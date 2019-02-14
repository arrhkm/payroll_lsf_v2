$(document).ready(function() {            
    var options1 = {                
        clearFiltersControls: [$('#cleanfilters')],                
    };
    $('#demotable1').tableFilter(options1);
			
    var grid2 = $('#demotable2');
    var options2 = {                
        filteringRows: function(filterStates) {										
                                grid2.addClass('filtering');
        },
        filteredRows: function(filterStates) {      															
            grid2.removeClass('filtering');					
            setRowCountOnGrid2();
        }
    };			
    function setRowCountOnGrid2() {
        var rowcount = grid2.find('tbody tr:not(:hidden)').length;
        $('#rowcount').text('(Rows ' + rowcount + ')');										
    }
			
    grid2.tableFilter(options2); // No additional filters			
    setRowCountOnGrid2();
});
		
// here we define global variable
var ajaxdestination="";

function getdata(what,where) { // get data from source (what)
    try {
        xmlhttp = window.XMLHttpRequest?new XMLHttpRequest():
        new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch (e) { /* do nothing */ }
    document.getElementById(where).innerHTML ="<center><img src='../images/loading.gif'></center>";
    // we are defining the destination DIV id, must be stored in global variable (ajaxdestination)
    ajaxdestination=where;
    xmlhttp.onreadystatechange = triggered; // when request finished, call the function to put result to destination DIV
    xmlhttp.open("GET", what);
    xmlhttp.send(null);
    return false;
}

function triggered() { // put data returned by requested URL to selected DIV
    if (xmlhttp.readyState == 4) if (xmlhttp.status == 200) 
        document.getElementById(ajaxdestination).innerHTML =xmlhttp.responseText;
}