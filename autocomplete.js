var searchbox = document.getElementById('searchbox');
var resultbox = document.getElementById('autocomplete');
searchbox.onkeyup = auto;

function auto() {
    var text = this.value;
    resultbox.innerHTML = "";
    
    if (text.length > 2) {
        $.post("autocomplete.php", { text : text, }, function(result){
            
            var suggests = result.split(",");            
            resultbox.style.visibility = "visible";
            
            var i;
            for(i=0; i < suggests.length - 1; i++) { 
                var num = i.toString();
                var id = "suggest" + num;
                resultbox.innerHTML += "<div class=\"suggest\" id=\"" + id + "\">" + suggests[i] + "</div>";                
            }
            
            for(i=0; i < suggests.length - 1; i++) { 
                var num = i.toString();
                var id = "suggest" + num;               
                document.getElementById(id).addEventListener('click', select, false);
            }
        }
        );
    }
};

function select() {
    resultbox.innerHTML = "";
    searchbox.value = this.innerHTML;
    document.getElementById("search").submit();
}

