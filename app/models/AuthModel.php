<?php 
    class AuthModel extends BaseModel{
        public function __construct(){
            parent::__construct();
        }

        public function login($username, $password){
            $stmt = $this->db->callProcedure('FindUserByUsername', [$username]);
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            if(!$user){
                return false;
            }

            if(password_verify($password, $user->password)){
                return $user;
            }else{
                return false;
            }
        }
    }
?>