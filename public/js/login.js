document.forms[0].onsubmit = function() {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
            console.log(this);
            alert(JSON.parse(this.responseText));
            console.log(this.responseText);
        }
    };
    xhttp.open("POST", "log", true);
    xhttp.send();
    return false;
}