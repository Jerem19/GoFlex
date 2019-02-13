var footerDiv = document.getElementById('footer'),
    main = document.getElementById('main-content');

footerDiv.style.minHeight = document.getElementById('footer-child').offsetHeight + "px";

function resizeFooter() {
    // TO DO: correct the main div height (change while the process)
    var mainS = main.offsetHeight;
    var h = winHeight - mainS;

    footerDiv.style.height = h + "px";
}

var winHeight = null;
window.onresize = function() {
    if (winHeight != window.innerHeight) { // only if height change
        winHeight = window.innerHeight;
        resizeFooter();
    }
};
window.onresize();

// change language
document.getElementById('languages').onchange = function() {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "lang", true);
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4)
            if (JSON.parse(this.responseText)) location.reload();
    };
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('lang='+this.value);
};

// https://stackoverflow.com/questions/39206614/jquery-when-abort-multiple-ajax
function when(...xhrs) {
    return {
        abort() {
            xhrs.forEach(xhr => {
                xhr.abort();
            });
        },
        promise: $.when(...xhrs)
    };
}