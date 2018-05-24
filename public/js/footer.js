window.onresize = function() {
    var h = window.innerHeight - document.getElementById('main-content').offsetHeight;
    if (h < 0)
        h = document.getElementById('footer-child').offsetHeight;
    //ajoute car le height et trop grand et la page coulisse pour rien. ce sera mieux pour l'utilisateur
    //A valider
    h-= 20;
    document.getElementById('footer').style.height = h + "px";
};
window.onresize();