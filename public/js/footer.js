window.onresize = function() {
    var h = window.innerHeight - document.getElementById('main-content').offsetHeight;
    if (h < 0)
        h = document.getElementById('footer-child').offsetHeight;
    document.getElementById('footer').style.height = h + "px";
};
window.onresize();