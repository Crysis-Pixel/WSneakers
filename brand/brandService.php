<?php
    include("brandRepository.php");

    class BrandService{

        private BrandRepo $BrandRepo;
        public function __construct(){
            $this->BrandRepo = new BrandRepo();
        }

        //go to AddProduct in ProductRepository.php for details
        public function Insert(Brand $b){
            if ($this->BrandRepo->AddBrand($b)){
                echo "Brand added successfully! <br>";
            }
            else{
                echo "<br> Failed to add brand. <br>";
            }
        }

        //go to RemoveProduct in ProductRepository.php for details
        public function Delete(int $BrandID){
            if ($this->BrandRepo->RemoveBrand($BrandID)){
                echo "Brand deleted successfully! <br>";
            }
            else{
                echo "Failed to delete brand. <br>";
            }
        }

        public function Update(Brand $b, int $BrandID){
            if ($this->BrandRepo->UpdateBrand($b, $BrandID)){
                echo "Brand updated successfully! <br>";
            }
            else{
                echo "Failed to update brand. <br>";
            }
        }

        public function Search(string $BrandName){
            $result = $this->BrandRepo->SearchBrand($BrandName);
            return $result;
        }

        public function GetAllBrands(){
            $result = $this->BrandRepo->getAllBrands();
            return $result;
        }
        public function GetBrandCount(){
            return $this->BrandRepo->getBrandCount();
        }
        public function GetBrand(int $BrandID){
            return $this->BrandRepo->getBrand($BrandID);
        }
    }
?>