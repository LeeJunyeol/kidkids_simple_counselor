var module = (function () {
    var $questionTable = $(".table > tbody");
    var questions = [];

    function init() {
        $.get("/db", function (data) {
            questions = data['messages'];
            var questionsHtml = "";
            $.each(questions, (i, question) => {
                questionsHtml += "<tr data-id=" + question['question_id'] + ">" +
                    $.map(question, (value) => {
                        return "<td>" +
                            "<input class='form-control text-center data' type='text' value=" + value + " readonly>" +
                            "</td>";
                    }).join() +
                    "<td><button class='btn btn-primary update'>수정</button></td>" +
                    "<td><button class='btn btn-primary delete'>삭제</button></td>" +
                    "</tr>";
            });
        });


        // // 추가 이벤트
        // $(".btn.add").on("click", function(e){
        //     e.preventDefault();
        //     $.ajax("/insert_question.php", {
        //         method: "POST",
        //         data: {
        //             user_id: $("#inputUserID").val(),
        //             category: $("#inputCategory").val(),
        //             title: $("#inputTitle").val(),
        //             content: $("#inputContent").val(),
        //             view: $("#inputView").val()
        //         }
        //     }).then(function(res){
        //         res = JSON.parse(res);
        //         var question = res['question']; 
        //         var questionsHtml = "<tr data-id=" + question['question_id'] + ">"
        //         + $.map(question, (value) => {
        //             return "<td>"
        //             + "<input class='form-control text-center data' type='text' value=" + value + " readonly>"
        //             + "</td>";
        //         }).join() 
        //         + "<td><button class='btn update'>수정</button></td>"
        //         + "<td><button class='btn delete'>삭제</button></td>"
        //         + "</tr>";
        //         $questionTable.append(questionsHtml);
        //     })
        // });

        // $.get("/db", function(data){
        //     questions = data['messages'];
        //     var questionsHtml = "";
        //     $.each(questions, (i, question) => {
        //         questionsHtml += "<tr data-id=" + question['question_id'] + ">"
        //         + $.map(question, (value) => {
        //             return "<td>"
        //             + "<input class='form-control text-center data' type='text' value=" + value + " readonly>"
        //             + "</td>";
        //        }).join() 
        //        + "<td><button class='btn btn-primary update'>수정</button></td>"
        //        + "<td><button class='btn btn-primary delete'>삭제</button></td>"
        //        + "</tr>";
        //    });
        //     $questionTable.append(questionsHtml);
        // }).then(function(){
        //     // 삭제 이벤트
        //     $(".btn.delete").on("click", function(e){
        //         e.preventDefault();
        //         console.log("삭제!");
        //         var $deletedRow = $(e.currentTarget).closest("tr");
        //         var question_id = $deletedRow.data("id");
        //         $deletedRow.remove();
        //         $.ajax("/delete_question.php", {
        //             method: "POST",
        //             data: {
        //                 question_id
        //             }
        //         }).then(function(res){
        //             console.log(res);
        //         });
        //     });

        //     $(".btn.update").on("click", function(e){
        //         e.preventDefault();
        //         $this = $(e.currentTarget);
        //         if(!$this.hasClass("edit")){
        //             $(e.currentTarget).text("수정완료!"); 
        //             $this.addClass("edit");
        //             $(e.currentTarget).closest("tr").find("input.data").prop("readonly", false);
        //         } else {
        //             var values = $(e.currentTarget).closest("tr").find("input.data");
        //             console.log(values[0].value);
        //             // var question = JSON.stringify({
        //             //     question_id: values[0].value,
        //             //     user_id: values[1].value,
        //             //     category: values[2].value,
        //             //     title: values[3].value,
        //             //     content: values[4].value,
        //             //     view: values[5].value,
        //             //     create_date: values[6].value,
        //             //     modify_date: values[7].value
        //             // });

        //             $.ajax("/update_question.php", {
        //                 method: "POST",
        //                 data: {
        //                     question_id: values[0].value,
        //                     user_id: values[1].value,
        //                     category: values[2].value,
        //                     title: values[3].value,
        //                     content: values[4].value,
        //                     view: values[5].value,
        //                     create_date: values[6].value,
        //                     modify_date: values[7].value
        //                 }
        //             }).then(function(res){
        //                 console.log(res);
        //             });

        //             $(e.currentTarget).text("수정"); 
        //             $this.removeClass("edit");
        //             $(e.currentTarget).closest("tr").find("input.data").prop("readonly", true);
        //         }
        //     })
        // });
    };

    return {
        init
    }
})();

$(document).ready(module.init());