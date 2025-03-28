<?php 
    class DashboardModel extends BaseModel{
        public function __construct(){
            parent::__construct();
        }

        public function getLetters(){
            $stmt = $this->db->callProcedure('GetLetterForDashboard');
            $letters = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $letters;
        }
    }
?>