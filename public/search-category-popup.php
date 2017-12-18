<?php
require_once "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>카테고리 검색</title>
</head>
<body>
<div></div>
<?php
echo $_GET['search-category-string'];
// 마이페이지에 내 점수 표시 가능하다면 그래프
// 답변을 기다리는 질문 표시
// 채택 100점 // 추천 - 비추천 = 점수 
// 점수 상승에 따라 레벨업!
?>
    <script src="<?php echo _NODE ?>/jquery/dist/jquery.js"></script>
    <script src="<?php echo _NODE ?>/jquery.redirect/jquery.redirect.js"></script>
    <script src="<?php echo _NODE ?>/bootstrap/dist/js/bootstrap.js"></script>
    <script src="<?php echo _NODE ?>/handlebars/dist/handlebars.js"></script>
    <script src="<?php echo _JS ?>/util.js"></script>
    <script>
        var SearchModule = (function(){
            function init(){
                $.ajax("http://localhost/ksc/api/Category" + location.search, {
                    type: "GET"
                }, function(res){
                    var result = JSON.parse(res);
                    console.log(result);
                    var categories = result['categories'];
                    $("div").append(categories[0]);
                });
            }
            return init;
        })();
        $(document).ready(SearchModule);
    </script>
</body>
</html>
