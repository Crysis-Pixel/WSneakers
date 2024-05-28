<?php
    include("reviewsRepo.php");
    class ReviewsService{
        private ReviewsRepo $reviewRepo;
        public function __construct(){
            $this->reviewRepo = new ReviewsRepo();
        }

        public function Insert(Reviews $r){
            if ($this->reviewRepo->AddReview($r)){
                echo "Review added successfully! <br>";
                return true;
            }
            else{
                echo "<br> Failed to add review. <br>";
                return false;
            }
        }

        public function DeleteReview(int $ReviewID){
            if ($this->reviewRepo->DeleteReview($ReviewID)){
                echo "Review deleted successfully! <br>";
            }
            else{
                echo "Failed to delete review. <br>";
            }
        }

        public function UpdateReview(Reviews $r, int $ReviewID){
            if ($this->reviewRepo->UpdateReview($ReviewID, $r)){
                echo "Review updated successfully! <br>";
            }
            else{
                echo "Failed to update review. <br>";
            }
        }

        public function Search(string $Username, string $ProductName){
            $result = $this->reviewRepo->SearchReview($Username, $ProductName);
            return $result;
        }

        public function getReview(int $ReviewID){
            $result = $this->reviewRepo->getReview($ReviewID);
            return $result;
        }
    }
?>