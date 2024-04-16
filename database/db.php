<?php
    class Db
    {
        private static $instance;

        private $db_server = "localhost";
        private $db_user = "root";
        private $db_pass = "";
        private $db_name = "wsneakers";
        private $con = null;
    
        public function getConnection(): mysqli | null {
            if ($this->con === null) {
                $con = @mysqli_connect($this->db_server, $this->db_user, $this->db_pass, $this->db_name);
        
                if ($con) {
                    $this->con = $con;
                } else {
                    echo "Failed to connect.";
                }
            }
            
            return $this->con;
        }
        public static function getInstance(): Db
        {
            if (!isset(Db::$instance))
            {
                Db::$instance = new Db();
            }
            return Db::$instance;
        }
    }
?>