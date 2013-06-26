
window.onload = function(){
    var selyear1 = document.getElementById("actYear1");
    var selmonth1 = document.getElementById("actMonth1");
    var selday1 = document.getElementById("actDay1");
    var selhour1 = document.getElementById("actHour1");
    var selyear2 = document.getElementById("actYear2");
    var selmonth2 = document.getElementById("actMonth2");
    var selday2 = document.getElementById("actDay2");
    var selhour2 = document.getElementById("actHour2");
    var curYear = (new Date()).getFullYear();
    var curMon = (new Date()).getMonth();
    var curDay = (new Date()).getDate();
    var curHour = (new Date()).getHours();
    for(var i = curYear; i < 2100; i++) {
        var year = document.createElement("option");
        year.text = i;
        year.value = i;
        selyear1.appendChild(year);
    }
    for(var i = 1; i < 13; i++) {
        var month = document.createElement("option");
        month.text = i;
        month.value = i;
        selmonth1.appendChild(month);
    }
    for(var i = 1; i < 32; i++) {
        var day = document.createElement("option");
        day.text = i;
        day.value = i;
        selday1.appendChild(day);
    }
    for(var i = 0; i < 24; i++) {
        var hour = document.createElement("option");
        hour.text = i;
        hour.value = i;
        selhour1.appendChild(hour);
    }
    for(var i = curYear; i < 2100; i++) {
        var year = document.createElement("option");
        year.text = i;
        year.value = i;
        selyear2.appendChild(year);
    }
    for(var i = 1; i < 13; i++) {
        var month = document.createElement("option");
        month.text = i;
        month.value = i;
        selmonth2.appendChild(month);
    }
    for(var i = 1; i < 32; i++) {
        var day = document.createElement("option");
        day.text = i;
        day.value = i;
        selday2.appendChild(day);
    }
    for(var i = 1; i < 25; i++) {
        var hour = document.createElement("option");
        hour.text = i;
        hour.value = i;
        selhour2.appendChild(hour);
    }
}

function showMemu(li) {
    document.getElementById("show").style.display = "block";
}
function hideMenu(li) {
    document.getElementById("show").style.display = "none";
}

function showMemu2(li) {
    document.getElementById("show2").style.display = "block";
}
function hideMenu2(li) {
    document.getElementById("show2").style.display = "none";
}


