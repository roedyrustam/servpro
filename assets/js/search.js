$(document).ready(function(){ 

    var url = base_url + 'search_service';    
    
    $("#common_search").autocomplete({
            source: url,
            select: function(event, ui) {
                console.log(event);
                var selected_value = String(ui.item.label);
                if (selected_value != "No Results Found") {
                    var serch = ui.item.id;
                    window.location.href = base_url+'request-view/'+serch;
                    }
            }
     });
 
}); 