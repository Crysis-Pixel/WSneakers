<?php
    include("categoryRepository.php");

    class CategoryService{

        private CategoryRepo $CategoryRepo;
        public function __construct(){
            $this->CategoryRepo = new CategoryRepo();
        }

        public function Insert(Category $c){
            if ($this->CategoryRepo->AddCategory($c)){
                echo "Category added successfully! <br>";
            }
            else{
                echo "<br> Failed to add category. <br>";
            }
        }

        public function Delete(int $CategoryID){
            if ($this->CategoryRepo->RemoveCategory($CategoryID)){
                echo "Category deleted successfully! <br>";
            }
            else{
                echo "Failed to delete category. <br>";
            }
        }

        public function Update(Category $c, int $CategoryID){
            if ($this->CategoryRepo->UpdateCategory($c, $CategoryID)){
                echo "Category updated successfully! <br>";
            }
            else{
                echo "Failed to update category. <br>";
            }
        }

        public function Search(string $Type){
            $result = $this->CategoryRepo->SearchCategory($Type);
            return $result;
        }

        public function getAllCategories(){
            $result = $this->CategoryRepo->getAllCategories();
            return $result;
        }
        public function GetCategoryCount(){
            return $this->CategoryRepo->getCategoryCount();
        }
        public function getCategory($CategoryID){
            return $this->CategoryRepo->getCategory($CategoryID);
        }
    }
?>