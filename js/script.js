function openTab(tabname) {
    var i;
    var x = document.getElementsByClassName("tab-data");

    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";  
    }

    document.getElementById(tabname).style.display = "block";  
    if(tabname == 'cart') document.getElementById(tabname).style.display = "flex";  
}