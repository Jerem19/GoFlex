var footerDiv = document.getElementById('footer'),
    main = document.getElementById('main-content');

footerDiv.style.minHeight = document.getElementById('footer-child').offsetHeight + "px";

var winHeight = null;
window.onresize = function() {
    if (winHeight != window.innerHeight) {
        // TO DO: correct the main div height (change while the process)
        winHeight = window.innerHeight;
        var mainS = main.offsetHeight;
        var h = winHeight - mainS;

        footerDiv.style.height = h + "px";
    }
};
window.onresize();