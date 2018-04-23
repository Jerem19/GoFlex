document.forms[0].onsubmit = function() {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "login", true);

    var submitBtn = this["submit"];
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
            var success = JSON.parse(this.responseText);
            if (success)
                location.reload();
            else {
                submitBtn.classList.add('wrong');
                setTimeout(function() {
                    submitBtn.classList.remove('wrong')
                }, 501);
            }
        }
    };
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('username='+this["username"].value+'&password='+this["password"].value);
    return false;
}