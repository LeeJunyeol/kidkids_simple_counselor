var AdminModule = (function () {
    var BASE_URL = location.origin + "";
    var QUESTION_API_URL = BASE_URL + "/api/Question"

    // 등록/수정/삭제 판넬
    // var categoryHeaderTemplate = handlebarsHelper("#category-header-template");
    var userAdminTemplate = handlebarsHelper("#user-admin-template");

    // 테이블 헤더 템플릿
    var categoryHeaderTemplate = handlebarsHelper("#category-header-template");

    // 템플릿
    //    var categoryTemplate = handlebarsHelper("#category-template");

    var $selectedRow; // 선택한 행

    var am;

    function init() {
        am = QuestionModule;
        am.init();

        // 페이지 네비게이션 이벤트
        $("#pageNav").on("click", "li.previous", prevPage);
        $("#pageNav").on("click", "li.next", nextPage);
        $("#pageNav").on("click", "li.pageNum", moveToPageNum);


        $("#table-main-body").on("click", "button.delete", function (e) {
            e.preventDefault();
            e.stopPropagation();

            if(confirm("삭제 하시겠습니까?")){
                var $currentRow = $(e.currentTarget).closest("tr");
                var id;
                var targetController;
                if($currentRow.data("question-id")){
                    id = $currentRow.data("question-id");
                    targetController = "Question";
                } else if($currentRow.data("answer-id")){
                    id = $currentRow.data("answer-id");
                    targetController = "Answer";
                }
    
                var url = BASE_URL + "/api/" + targetController + "/" + id;
                $.ajax(url, {
                    type: 'DELETE'
                }).then(function (res) {
                    alert(JSON.parse(res)['message']);
                    $currentRow.remove();
                });
            }
        })

        $("#menu>a:eq(0)").on("click", function (e) {
            am = QuestionModule;
            am.init();
            hideUserAdmin();
            $("#wrapper").removeClass("hide");
            $("#useradmin").addClass("hide");
        })
        $("#menu>a:eq(1)").on("click", function (e) {
            am = AnswerModule;
            am.init();
            hideUserAdmin();
            $("#wrapper").removeClass("hide");
            $("#useradmin").addClass("hide");
        })
        $("#menu>a:eq(2)").on("click", function (e) {
            getUserScores().then(drawUserTemplate).then(bindAdvancementEvents);
            $("#useradmin").removeClass("hide");
            $("#wrapper").addClass("hide");
        })
        // $("#menu>li:eq(2)").on("click", function (e) {
        //     getCategories(1);
        //     hideUserAdmin();
        //     $("#wrapper").removeClass("hide");
        //     $("#useradmin").addClass("hide");
        // })

        $("tbody").on("click", "tr", function(e) {
            e.stopPropagation();
            var obj = $(e.currentTarget).data("obj");
            if(obj['answerId'] !== undefined){
                location.href = BASE_URL + "/admin/answer/" + obj['answerId'];
            } else {
                location.href = BASE_URL + "/admin/question/" + obj['questionId'];
            }
        })

        // 맨위에 값 업데이트
        $("table").on("click", "tr", function (e) {
            $tedRow = $(e.currentTarget);

            var selectedData = $(e.currentTarget).data("obj");
            selectedData["content"] = $(e.currentTarget).find(".content").text();
            selectedData["createDate"] = new Date(selectedData["createDate"]).toISOString().slice(0, 10);
            selectedData["modifyDate"] = new Date(selectedData["modifyDate"]).toISOString().slice(0, 10);
            $(".form-control").each(function (i, v) {
                var name = $(v).prop("name");
                if (i === 0) {
                    // id 값 업데이트
                    $("#form").data("id", this[name]);
                    // 객체 전송하기 쉽게 데이터 바인딩
                    $("#form").data("obj", this);
                }
                $(v).val(this[name]);
            }.bind(selectedData));
        });

        // bindDeleteEvent();
        // bindUpdateEvent();
    }

    function prevPage(e) {
        if (currentPageNum > 1) {
            currentPageNum--;
            am.get(currentPageNum, sortBy);
        } else {
            alert("첫 페이지입니다.");
        }
    }

    function nextPage(e) {
        if (currentPageNum < lastPageNum) {
            currentPageNum++;
            am.get(currentPageNum, sortBy);
        } else {
            alert("마지막 페이지입니다.");
        }
    }

    function moveToPageNum(e) {
        currentPageNum = parseInt($(e.currentTarget).data("num"));
        am.get(currentPageNum, sortBy);
    }

    // function bindUpdateEvent() {
    //     $("#form").on("click", "button.update", function (e) {
    //         e.preventDefault();

    //         var thisData = $(e.delegateTarget).data("obj");
    //         var thisDataKeys = Object.keys(thisData);
    //         $(".form-control").each(function (i, v) {
    //             thisData[$(v).prop("name")] = $(v).val();
    //         });

    //         var id = $(e.delegateTarget).data("id");
    //         var targetController;
    //         var callbackFunc;
    //         switch (Object.keys(thisData)[0]) {
    //             case "questionId":
    //                 targetController = "Question";
    //                 callbackFunc = getQuestions;
    //                 break;
    //             case "answerId":
    //                 targetController = "Answer";
    //                 break;
    //         }
    //         var url = BASE_URL + "/api/" + targetController + "/" + id;
    //         $.ajax(url, {
    //             type: 'PUT',
    //             contentType: 'application/json',
    //             data: JSON.stringify(thisData)
    //         }).then(function (res) {
    //             window.alert(JSON.parse(res)['message']);
    //             this(1);
    //         }.bind(callbackFunc));
    //     })
    // }

    // function bindDeleteEvent() {
    //     $("#form").on("click", "button.delete", function (e) {
    //         e.preventDefault();

    //         var thisData = $(e.delegateTarget).data("obj");
    //         var id = $(e.delegateTarget).data("id");
    //         var targetController;
    //         switch (Object.keys(thisData)[0]) {
    //             case "questionId":
    //                 targetController = "Question";
    //                 break;
    //             case "answerId":
    //                 targetController = "Answer";
    //                 break;
    //         }
    //         var url = BASE_URL + "/api/" + targetController + "/" + id;
    //         $.ajax(url, {
    //             type: 'DELETE'
    //         }).then(function (res) {
    //             alert(JSON.parse(res)['message']);
    //             $selectedRow.remove();
    //         });
    //     })
    // }

    function bindAdvancementEvents() {
        $("#useradmin").on("click", ".advance", function (e) {
            var user = $(e.currentTarget).closest("tr").data("user");
            user['user_type'] = "전문가";
            user['message'] = "승급되었습니다.";
            updateUserType(user);
        });
        $("#useradmin").on("click", ".demolition", function (e) {
            var user = $(e.currentTarget).closest("tr").data("user");
            user['user_type'] = "일반";
            user['message'] = "강등되었습니다.";
            updateUserType(user);
        });
    }

    function updateUserType(user) {
        $.ajax(BASE_URL + "/api/User", {
            type: "PUT",
            contentType: "application/json",
            data: JSON.stringify(user)
        }).then(function () {
            alert(user['message']);
            getUserScores().then(drawUserTemplate).then(bindAdvancementEvents);
            $("#useradmin").removeClass("hide");
            $("#wrapper").addClass("hide");
        })
    }

    function hideUserAdmin() {
        if ($("#useradmin").hasClass("hide")) {
            $("#useradmin").addClass("hide");
        }
    }

    function drawUserTemplate(res) {
        $("#useradmin").html(userAdminTemplate(res));
    }

    function getUserScores() {
        return $.ajax(BASE_URL + "/api/Controllers/User.php", {
            type: 'GET',
            contentType: "application/json"
        }).then(function (res) {
            var results = JSON.parse(res);
            results['userScores'].forEach(function (user, i) {
                var 승급가능 = 사용자가승급가능한지(user);
                if (승급가능 > 0) {
                    user['ok'] = true;
                } else if (승급가능 < 0) {
                    user['no'] = true;
                }
            });
            var answerCntMap = {};
            results['answerCnt'].forEach((element) => {
                answerCntMap[[element['user_id']]] = element['answer_cnt'];
            })
            var questionCntMap = {};
            results['questionCnt'].forEach((element) => {
                questionCntMap[[element['user_id']]] = element['question_cnt'];
            })
            // var questionCntMap = results['questionCnt'].map(function(obj){
            //     var rObj = {};
            //     rObj[obj['user_id']] = obj['question_cnt'];
            //     return rObj;
            // })
            var reformatRes = results['userScores'];
            reformatRes.forEach((element) => {
                if(questionCntMap[element['user_id']]){
                    element['question_cnt'] = questionCntMap[element['user_id']];  
                } else {
                    element['question_cnt'] = 0;
                }
                if(answerCntMap[element['user_id']]){
                    element['answer_cnt'] = answerCntMap[element['user_id']];  
                } else {
                    element['answer_cnt'] = 0;
                }
            });
            return reformatRes;
        })
    }

    function 사용자가승급가능한지(user) {
        if (parseInt(user['selection_percentage']) >= 60 &&
            parseInt(user['myscore']) >= 100 &&
            user['user_type'] !== "전문가") {
            return 1;
        } else if ((parseInt(user['selection_percentage']) < 60 ||
                parseInt(user['myscore']) < 100) &&
            user['user_type'] === "전문가") {
            return -1;
        } else {
            return 0;
        }
    }

    function prevPage(e) {
        if (currentPageNum > 1) {
            currentPageNum--;
            am.get(currentPageNum);
        } else {
            alert("첫 페이지입니다.");
        }
    }

    function nextPage(e) {
        if (currentPageNum < lastPageNum) {
            currentPageNum++;
            am.get(currentPageNum);
        } else {
            alert("마지막 페이지입니다.");
        }
    }

    function moveToPageNum(e) {
        currentPageNum = parseInt($(e.currentTarget).data("num"));
        am.get(currentPageNum);
    }

    return {
        init
    }
})();

$(document).ready(function () {
    AdminModule.init();
})

var AnswerModule = (() => {
    var answerInputTemplate = handlebarsHelper("#answer-input-template");
    var answerHeaderTemplate = handlebarsHelper("#answer-header-template");
    var answerTemplate = handlebarsHelper("#answer-template");
    var paginationTemplate = handlebarsHelper("#pagination-template");

    var BASE_URL = location.origin + "";
    var $selectedRow; // 선택한 행

    var currentPageNum = 1;
    var lastPageNum = 1;

    var sortBy = "default";
    var isAsc = false;

    var init = () => {
        get(1);
    }

    function get(page) {
        var dataObj = {};
        dataObj['page'] = page;
        dataObj['limit'] = 10;

        $.ajax(BASE_URL + "/api/Controllers/Answer.php", {
            type: 'GET',
            contentType: "application/json",
            data: dataObj
        }).then(function (res) {
            var results = JSON.parse(res);
            $("#form").html(answerInputTemplate());
            $("thead").html(answerHeaderTemplate());
            results['answers'].forEach((element) => {
                if(element['content'].length > 100){
                    element['content'] = element['content'].substring(0, 100) + "...";
                }
            })
            $("tbody").html(answerTemplate(results['answers']));
            var arr = [];
            for (lastPageNum = 0; lastPageNum <= parseInt(results['count'][0]) / 10; lastPageNum++) {
                arr.push(lastPageNum + 1);
            }
            $("ul.pagination").html(paginationTemplate(arr));
        })
    }

    return {
        init,
        get
    }

})();

var QuestionModule = (() => {
    var questionInputTemplate = handlebarsHelper("#question-input-template");
    var questionHeaderTemplate = handlebarsHelper("#question-header-template");
    var questionTemplate = handlebarsHelper("#question-template");
    var paginationTemplate = handlebarsHelper("#pagination-template");

    var BASE_URL = location.origin + "";
    var $selectedRow; // 선택한 행

    var currentPageNum = 1;
    var lastPageNum = 1;

    var sortBy = "default";
    var isAsc = false;


    var init = () => {
        get(1);
    }

    // function prevPage(e){
    //     if (currentPageNum > 1) {
    //         currentPageNum--;
    //         getQuestions(currentPageNum, sortBy);
    //     } else {
    //         alert("첫 페이지입니다.");
    //     }
    // }

    // function nextPage(e){
    //     if (currentPageNum < lastPageNum) {
    //         currentPageNum++;
    //         getQuestions(currentPageNum, sortBy);
    //     } else {
    //         alert("마지막 페이지입니다.");
    //     }
    // }

    // function moveToPageNum(e){
    //     currentPageNum = parseInt($(e.currentTarget).data("num"));
    //     getQuestions(currentPageNum, sortBy);
    // }

    function get(page) {
        var dataObj = {};
        dataObj['page'] = page;
        dataObj['sortBy'] = "id";
        dataObj['isASC'] = "true";
        dataObj['limit'] = 10;
        $.ajax(BASE_URL + "/api/Controllers/Question.php", {
            type: 'GET',
            contentType: "application/json",
            data: dataObj
        }).then(function (res) {
            var results = JSON.parse(res);
            $("#form").html(questionInputTemplate());
            $("thead").html(questionHeaderTemplate());
            results['questions'].forEach((element) => {
                if (element['content'].length > 150) {
                    element['content'] = element['content'].substring(0, 150) + "...";
                }
            });
            $("tbody").html(questionTemplate(results['questions']));
            var arr = [];
            for (lastPageNum = 0; lastPageNum <= parseInt(results['count'][0]) / 10; lastPageNum++) {
                arr.push(lastPageNum + 1);
            }
            $("ul.pagination").html(paginationTemplate(arr));
        })
    }

    return {
        init,
        get
    }
})();