document.getElementById('languages').onchange = function() {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "lang", true);

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
            var success = JSON.parse(this.responseText);
            if(success)
                location.reload();
        }
    };
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('lang='+this.value);
}