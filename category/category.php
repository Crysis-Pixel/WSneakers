<?php

    class Category{
        private int $CategoryID = 0;
        private string $Type;

        public function __construct(string $Type){
            $this->Type = $Type;
        }

        public function setCategoryID(int $CategoryID){
            $this->CategoryID = $CategoryID;
        }

        public function setType(string $Type){
            $this->Type = $Type;
        }

        public function getCategoryID(){
            return $this->CategoryID;
        }

        public function getType(){
            return $this->Type;
        }
    }
?>