function handlebarsHelper(templateId){
    var $templateId = $(templateId);
    if($templateId.length > 0){
        return Handlebars.compile($templateId.html());
    } else {
        return {"error" : "해당하는 템플릿이 없습니다."};
    }
}

var Utils = (function(){
    var WEEK_DAYS = ["일", "월", "화", "수", "목", "금", "토"];
    
    function getFormatDate(inputDate) {
        var date = new Date(inputDate);
    
        return date.getFullYear() + "." +
            (date.getMonth() + 1) + "." +
            date.getDate() + "." + "(" + WEEK_DAYS[new Date(inputDate).getDay()] + ")";
    }

    return {
        getFormatDate: getFormatDate
    };
})();

