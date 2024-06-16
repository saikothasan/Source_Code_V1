
$(document).ready(function () {
    $("#sidebarToggle").click(function () {
        let mainSideBar = $(".main-sidebar");
        mainSideBar.toggleClass("sidebar-active");

    })
    function makeTimer() {
        let date = new Date();
        let hours = date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
        let am_pm = date.getHours() >= 12 ? "PM" : "AM";
        hours = hours < 10 ? "0" + hours : hours;
        let minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
        let seconds = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();
        time = hours + ":" + minutes + ":" + seconds + " " + am_pm;
        $("#currentTime").html(time);

    }

    setInterval(function () {
        makeTimer();
    }, 1000);
})


$(document).mouseup(function(e){
    let container = $(".sidebar-active");
    if(!container.is(e.target) && container.has(e.target).length === 0 && $( "#sidebar_area" ).hasClass( "sidebar-active" )){
        $(".main-sidebar").toggleClass("sidebar-active");
    }
});
