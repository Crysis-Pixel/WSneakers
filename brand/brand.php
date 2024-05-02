<?php

    class Brand{
        private int $BrandID = 0;
        private string $Name;

        public function __construct(string $Name){
            $this->Name = $Name;
        }

        public function setBrandID(int $BrandID){
            $this->BrandID = $BrandID;
        }

        public function setName(string $Name){
            $this->Name = $Name;
        }

        public function getBrandID(){
            return $this->BrandID;
        }

        public function getName(){
            return $this->Name;
        }
    }
?>