<?php
class Category {
    public $categoryId;    // int 11 PK
    public $categoryName;  // varchar 45
    public $depth;
    public $parentIdx;     // int 11

    public function __contruct($params){
        $this->categoryId = $params['categoryId'];
        $this->categoryName = $params['categoryName'];
        $this->depth = $params['depth'];
        $this->parentIdx = $params['parentIdx'];
    }
}
?>