var API_BASE_URL = "http://localhost/ksc/api";

var WriteModule = (function () {
    var $titleArea = $("div.write.header>textarea");
    var $contentArea = $("div.write.content>textarea");
    var $ulTags = $("ul.tags");

    // var $categorySpan = $("button>span.top"); // 카테고리 드롭다운(보여지는거)
    var $categoryH3 = $(".selected-category>h3");
    var $btnPostQuestion = $("#btn-post-question"); // 등록/수정 버튼

    var tagTemplateScript = $("#tag-template").html();
    var tagTemplate = Handlebars.compile(tagTemplateScript);

    var myQuestion = {}; // 글 등록,수정 할 때 요청에 보낼 데이터
    var questionId;
    var userId = $("#welcome").data("id") || "";

    function init() {
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
            $(".write.category").addClass("hide");
            $.ajax(API_BASE_URL + "/my/Question/" + splitedUrl[1], {
                type: "GET"
            }).then(function (res) {
                res = JSON.parse(res);
                var myQuestion = res['question'];
                $titleArea.val(myQuestion['title']);
                $contentArea.val(myQuestion['content']);
                var tags = myQuestion['tags'].split("/");
                tags.forEach(element => {
                    $ulTags.append(tagTemplate(element));
                });
                $btnPostQuestion.text("수정");
                $btnPostQuestion.removeClass("post");
                $btnPostQuestion.addClass("update");
            }).then(function (id) {
                $btnPostQuestion.data("id", id);
            }.call(this, splitedUrl[1]));
        }

        // 카테고리 검색 팝업 띄우기
        $("#search-category-form").on("click", "#search-category", function (e) {
            var searchStr = $(e.delegateTarget).find("input").val();
            if (searchStr === "") {
                alert("질문 분야를 입력해주세요.");
                return;
            };
            $("#modalForm").modal("show");
            $.ajax("http://localhost/ksc/api/Category?search-category-string=" + searchStr, {
                type: "GET"
            }).then(function (res) {
                var result = JSON.parse(res);
                var categories = result['categories'];
                var resultArr = [];
                for (var i = 0; i < categories.length; i++) {
                    var nameSet = new Set();
                    var idSet = new Set();
                    for (var j = 0; j < categories.length; j++) {
                        if (i !== j && categories[i].parent_idx === categories[j].category_id) {
                            nameSet.add(categories[j].p_c_name);
                            nameSet.add(categories[j].category_name);
                            idSet.add(categories[j].p_c_id);
                            idSet.add(categories[j].category_id);
                        }
                    }
                    nameSet.add(categories[i].p_c_name);
                    nameSet.add(categories[i].category_name);
                    idSet.add(categories[i].p_c_id);
                    idSet.add(categories[i].category_id);

                    var dataObj = {
                        category_id: categories[i].category_id,
                        category_id_set: Array.from(idSet),
                        category_name: categories[i].category_name,
                        category_string: Array.from(nameSet).join(" > ")
                    }
                    resultArr.push(dataObj);
                }
                var searchCategoryListTemplate = handlebarsHelper("#search-category-template");
                $("#ul-search-list").html(searchCategoryListTemplate(resultArr));
            });
        });

        // 질문 등록하기
        $("div.submit").on("click", ".post", function (e) {
            var title = $("div.write.header>textarea").val();
            var content = $("div.write.content>textarea").val();
            var tags = $("li.tags>span").map(function (i, element) {
                return element.innerHTML;
            }).get().join("/");
            var category = $categoryH3.text();
            var category_ids = $categoryH3.data("cid-set");
            if (title === "") {
                alert("제목을 입력하여 주시기 바랍니다.");
                return;
            }
            if (content === "") {
                alert("질문 내용을 입력하여 주시기 바랍니다.");
                return;
            }
            if (category === "") {
                alert("카테고리를 지정하여 주시기 바랍니다.");
                return;
            }
            $.ajax(API_BASE_URL + "/Question", {
                type: "POST",
                contentType: "application/x-www-form-urlencoded",
                data: {
                    mydata: {
                        category,
                        title,
                        content,
                        tags,
                        category_ids,
                        user_id: userId,
                    }
                }
            }).then(function (res) {
                var result = JSON.parse(res);
                alert(result["message"]);
                if (result["success"]) {
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
            if (title === "") {
                alert("제목을 입력하여 주시기 바랍니다.");
                return;
            }
            if (content === "") {
                alert("질문 내용을 입력하여 주시기 바랍니다.");
                return;
            }
            $.ajax(API_BASE_URL + "/my/Question/" + $(this).data("id"), {
                type: "PUT",
                contentType: "application/json",
                data: JSON.stringify({
                    category,
                    title,
                    content,
                    tags,
                    user_id: userId
                })
            }).then(function (res) {
                var result = JSON.parse(res);
                alert(result["message"]);
                if (result["success"]) {
                    location.href = result["redirectURL"];
                }
            })
        })


        function validate(title, content, $categorySpan) {
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
            if (!validateResult['isValidate']) {
                alert(validateResult['message']);
            }

            myQuestion['category'] = $(".selected-category>h3").text();
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

        $(".modal-footer>button.submitBtn").on("click", function(e){
            selectCategory();
        })

    }

    function selectCategory() {
        var $checkedCategory = $("input[name='category-list']:checked");
        var categoryId = $checkedCategory.val();
        var categoryName = $checkedCategory.data("name");
        var $selectedCategory = $(".selected-category");
        if($selectedCategory.hasClass("hide")){
            $selectedCategory.removeClass("hide");
        }
        $selectedCategory.find("h3").text(categoryName);
        $selectedCategory.find("h3").data("category-id", categoryId); 
        $selectedCategory.find("h3").data("cid-set", $checkedCategory.data("cid-set"));
        modalHide();
    }
    return {
        init
    }
})();

$(document).ready(function () {
    WriteModule.init();
});