<?php
namespace KCS\Controller;

use KCS\Model\CategoryModel;

class CategoryController {
    public $categoryModel;
    public function __construct(){
        $this->categoryModel = new CategoryModel();
    }

    public function getAll(){
        print_r($this->categoryModel->getAll());
        exit;
    }
}

/*

/api/category/{id}/questions

*/
?>