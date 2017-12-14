var API_BASE_URL = "http://localhost/ksc/api";

$(document).ready(function () {
    var $titleArea = $("div.write.header>textarea");
    var $contentArea = $("div.write.content>textarea");
    var $ulTags = $("ul.tags");

    var $dropdownMenu = $("ul.dropdown-menu");  
    var $categorySpan = $("button>span.top"); // 카테고리 드롭다운(보여지는거)
    var $btnPostQuestion = $("#btn-post-question"); // 등록/수정 버튼

    var tagTemplateScript = $("#tag-template").html();
    var tagTemplate = Handlebars.compile(tagTemplateScript);

    var myQuestion = {}; // 글 등록,수정 할 때 요청에 보낼 데이터
    var questionId;
    var userId =  $("#welcome").data("id") || "";
    
    // 태그 입력할 때, 엔터키를 누르면 태그 라벨이 추가된다.
    $("input").on("keyup", function (e) {
        if (e.which === 13 && $("li.tags").length < 5) {
            $("ul.tags").append(tagTemplate($(this).val()));
            $(this).val("");
        }
    })

    // 데이터 로드
    var splitedUrl = location.pathname.split("/").splice(-2);
    if (splitedUrl[0] === "update") {
        $.ajax(API_BASE_URL + "/my/Question/" + splitedUrl[1], {
            type: "GET"
        }).then(function (res) {
            res = JSON.parse(res);
            var myQuestion = res['question'];
            $categorySpan.removeClass("unclicked");
            $categorySpan.text(myQuestion['category']);
            $titleArea.val(myQuestion['title']);
            $contentArea.val(myQuestion['content']);
            var tags = myQuestion['tags'].split("/");
            tags.forEach(element => {
                $ulTags.append(tagTemplate(element));
            });
            $btnPostQuestion.text("수정");
            $btnPostQuestion.removeClass("post");
            $btnPostQuestion.addClass("update");
        }).then(function(id){
            $btnPostQuestion.data("id", id);
        }.call(this, splitedUrl[1]));
    }

    // 드롭다운 이벤트
    $dropdownMenu.on("click", "li", function (e) {
        this.removeClass("unclicked");
        this.text($(e.currentTarget).find("a").text());
    }.bind($categorySpan));

    // 질문 등록하기
    $("div.submit").on("click", ".post", function (e) {
        var title = $("div.write.header>textarea").val();
        var content = $("div.write.content>textarea").val();
        var tags = $("li.tags>span").map(function (i, element) {
            return element.innerHTML;
        }).get().join("/");
        if(title === ""){
            alert("제목을 입력하여 주시기 바랍니다.");
            return;
        }
        if(content === ""){
            alert("질문 내용을 입력하여 주시기 바랍니다.");
            return;
        }
        if($categorySpan.hasClass("unclicked")){
            alert("카테고리를 지정하여 주시기 바랍니다.");
            return;
        }
        var category = $categorySpan.text();

        $.ajax(API_BASE_URL + "/Question", {
            type: "POST",
            contentType: "application/x-www-form-urlencoded",
            data: {
                mydata: {
                    category, title, content, tags,
                    user_id: userId
                }
            }
        }).then(function (res) {
            var result = JSON.parse(res);
            alert(result["message"]);
            if(result["success"]){
                location.href = "/";
            }
        })
    })

    // 질문 수정하기
    $("div.submit").on("click", ".update", function (e) {
        var title = $("div.write.header>textarea").val();
        var content = $("div.write.content>textarea").val();
        var tags = $("li.tags>span").map(function (i, element) {
            return element.innerHTML;
        }).get().join("/");
        if(title === ""){
            alert("제목을 입력하여 주시기 바랍니다.");
            return;
        }
        if(content === ""){
            alert("질문 내용을 입력하여 주시기 바랍니다.");
            return;
        }
        if($categorySpan.hasClass("unclicked")){
            alert("카테고리를 지정하여 주시기 바랍니다.");
            return;
        }
        var category = $categorySpan.text();

        $.ajax(API_BASE_URL + "/my/Question/" + $(this).data("id"), {
            type: "PUT",
            contentType: "application/json",
            data: JSON.stringify({
                category, title, content, tags,
                user_id: userId
            })
        }).then(function (res) {
            console.log(res);
            var result = JSON.parse(res);
            alert(result["message"]);
            if(result["success"]){
                location.href = result["redirectURL"];
            }
        })
    })
    

    function validate(title, content, $categorySpan){
        var message;
        if (title === "") {
            return {
                isValidate: false,
                message: "제목을 입력하여 주시기 바랍니다."
            };
        }
        if (content === "") {
            return {
                isValidate: false,
                message: "질문 내용을 입력하여 주시기 바랍니다."
            }
        }
        if ($categorySpan.hasClass("unclicked")) {
            return {
                isValidate: false,
                message: "카테고리를 지정하여 주시기 바랍니다."
            }
        }
        return {
            isValidate: true
        }
    }
    

    function post(e) {
        alert("post");
        myQuestion['title'] = $titleArea.val();
        myQuestion['content'] = $contentArea.val();
        myQuestion['tags'] = $("li.tags>span").map(function (i, element) {
            return element.innerHTML;
        }).get().join("/");
        var validateResult = validate(myQuestion['title'], myQuestion['content'], $categorySpan);
        if(!validateResult['isValidate']){
            alert(validateResult['message']);
        }

        myQuestion['category'] = $categorySpan.text();
        myQuestion['user_id'] = $("#welcome").data("id");

        console.log(myQuestion);
        questionId = $(this).data("id");
        $.ajax({
            type: "POST",
            url: API_BASE_URL + "/Question",
            contentType: "aplication/x-www-form-urlencoded",
            data: {
                title: myQuestion['title'],
                content: myQuestion['content'],
                tags: myQuestion['tags']
            }
        }).then(function (res) {
            console.log(res);
            var result = JSON.parse(res);
            alert(result["message"]);
            if (result["success"]) {
                location.href = "/";
            }
        })
    }
});