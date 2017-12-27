<?php
require_once "../Config/Database.php";
require_once '../Models/CategoryModel.php';

$conn = Database::getConnection();

$categoryModel = new CategoryModel($conn);

switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
    // api/Category?page=?&limit=?
    if(isset($_GET['page']) && isset($_GET['limit'])){
        $limit = $_GET['limit'];
        $offset = ($_GET['page'] - 1) * $limit;

        $categories = $categoryModel->getForPage($offset, $limit);
        echo json_encode([
            "success" => true,
            "categories" => $categories
        ]);
        return;
    }
    if(isset($_GET['categoryId'])){
        $currentCategory = $categoryModel->getByCategoryId($_GET['categoryId']);
        $categories = $categoryModel->getSub($_GET['categoryId']);
        echo json_encode([
            "success" => true,
            "categories" => $categories,
            "currentCategory" => $currentCategory
        ]);
        return;
    }
    if(isset($_GET['search-category-string'])){
        $categories = $categoryModel->searchByCategoryName($_GET['search-category-string']);
        $categoriesAll = $categoryModel->searchAll();
        echo json_encode([
            "success" => true,
            "categories" => $categories,
            "categoriesAll" => $categoriesAll
        ]);
        return;
    }
    // default
    $categories = $categoryModel->getSub(0);
    echo json_encode([
        "success" => true,
        "categories" => $categories
    ]);
    break;
    case 'POST':
    // api/Category
    // 카테고리 입력 한 뒤, 그걸 리턴
    if(isset($_POST['categoryName']) && isset($_POST['depth'])
    && isset($_POST['parentIdx'])){
        $categoryId = $categoryModel->add($_POST['categoryName'], $_POST['depth'], $_POST['parentIdx']);
        if($categoryId > 0){
            $category = $categoryModel->getByCategoryId($categoryId);
            echo json_encode([
                "success" => true,
                "category" => $category
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => $categoryId
            ]);
        }
        return;
    }
    break;
}
?>