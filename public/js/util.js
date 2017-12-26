import Handlebars from "handlebars";

var HandlebarsHelper = function(templateId) {
  var $template = $(templateId);
  if ($template.length > 0) {
    return Handlebars.compile($(templateId).html());
  } else {
    console.log(templateId + "에 해당하는 템플릿이 존재하지 않습니다.");
    return false;
  }
};

var Utils = (function() {
  var WEEK_DAYS = ["일", "월", "화", "수", "목", "금", "토"];

  function getFormatDate(inputDate) {
    var date = new Date(inputDate);

    return (
      date.getFullYear() +
      "." +
      (date.getMonth() + 1) +
      "." +
      date.getDate() +
      "." +
      "(" +
      WEEK_DAYS[new Date(inputDate).getDay()] +
      ")"
    );
  }

  return {
    getFormatDate: getFormatDate
  };
})();

export { HandlebarsHelper, Utils };
