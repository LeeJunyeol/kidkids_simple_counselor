<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
<script type="text/handlebars-template" id="answer-input-template">
    <h2 style="margin-bottom: 30px;">답변 목록</h2>

    <form class="form">
        <div style="width: 100%; display: flex; justify-content: space-between;">
            <div class="form-group">
                <label for="Answer ID">Anwer ID</label>
                <input type="text" class="form-control" name="answerId" id="inputAnswerID" placeholder="Answer ID">
            </div>
            <div class="form-group">
                <label for="Question ID">Question ID</label>
                <input type="text" class="form-control" name="questionId" id="inputQuestionID" placeholder="Question ID">
            </div>
            <div class="form-group">
                <label for="User ID">User ID</label>
                <input type="text" class="form-control" name="userId" id="inputUserID" placeholder="User ID">
            </div>
            <div class="form-group">
                <label for="제목">Title</label>
                <input type="text" class="form-control" name="title" id="inputTitle" placeholder="질문입니다.">
            </div>
        </div>
        <div style="width: 100%; display: flex; justify-content: space-between;">
            <div class="form-group" style="width: 100%;>
                <label for="내용">Content</label>
                <input type="text" class="form-control" name="content" id="inputContent" placeholder="내용입니다.">
            </div>
        </div>
        <div style="width: 100%; display: flex; justify-content: space-between;">
            <div class="form-group">
                <label for="채택여부">채택</label>
                <input type="text" class="form-control" name="selection" id="inputSelection" placeholder="채택">
            </div>
            <div class="form-group">
                <label for="등록일">Create Date</label>
                <input type="text" class="form-control" name="createDate" id="inputCreateDate" placeholder="등록일">
            </div>
            <div class="form-group">
                <label for="수정일">Modify Date</label>
                <input type="text" class="form-control" name="modifyDate" id="inputModifyDate" placeholder="수정일">
            </div>
            <button type="submit" class="btn btn-default add">추가</button>
            <button type="submit" class="btn btn-default update">수정</button>
            <button type="submit" class="btn btn-default delete">삭제</button>
        </div>
    </form>
</script>


</body>
</html>