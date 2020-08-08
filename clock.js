function updateClock()
{
    const DATESEPARATOR = "/";
    const CLOCKSEPARATOR = ":";

    var clock = document.getElementById("clock");
    var now = new Date();
    var day = now.getDate();
    var month = now.getMonth();
    var year = now.getFullYear();
    var h = now.getHours();
    var min = now.getMinutes();
    var sec = now.getSeconds();

    var dateString = "";

    if (day < 10)
    {
        dateString += "0";
    }
    dateString += day + DATESEPARATOR;

    if (month < 10)
    {
        dateString += "0";
    }
    dateString += month + DATESEPARATOR;
    dateString += year;
    

    dateString += "&nbsp;&nbsp;&nbsp;";
    dateString += "Time: ";

    if (h < 10)
    {
        dateString += "0";
    }
    dateString += h + CLOCKSEPARATOR;

    if (min < 10)
    {
        dateString += "0";
    }
    dateString += min + CLOCKSEPARATOR;

    if (sec < 10)
    {
        dateString += "0";
    }
    dateString += sec;

    clock.innerHTML = dateString;
}

updateClock();
setInterval(updateClock, 1000);