function handlebarsHelper(templateId){
    return Handlebars.compile($(templateId).html());
}

var Utils = (() => {
    var WEEK_DAYS = ["일", "월", "화", "수", "목", "금", "토"];
    
    function getFormatDate(inputDate) {
        var date = new Date(inputDate);
    
        return date.getFullYear() + "." +
            (date.getMonth() + 1) + "." +
            date.getDate() + "." + "(" + WEEK_DAYS[new Date(inputDate).getDay()] + ")";
    }

    return {
        getFormatDate
    }
    
})();

