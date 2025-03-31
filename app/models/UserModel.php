<?php 
    class UserModel extends BaseModel{
        public function __construct(){
            parent::__construct();
        }

        public function getUsers($page = 1, $sort = '1', $order = 'ASC', $search = '', $department, $categoryUser){
            $offset = ($page - 1) * ITEMS_PER_PAGE;
            $stmt = $this->db->callProcedure('GetUsers', [
                $offset,
                ITEMS_PER_PAGE,
                $sort,
                $order,
                $search,
                $department,
                $categoryUser
            ]);

            $users = $stmt->fetchAll(PDO::FETCH_OBJ);
            $stmt->nextRowset();
            $total = $stmt->fetch(PDO::FETCH_OBJ)->total;
            return [
                'users' => $users,
                'total' => $total
            ];
        }

        public function getUserById($id){
            $id = (int)$id; 
            $stmt = $this->db->callProcedure('GetUserById', [$id]);
            if ($stmt === false) {
                echo("Không thể thực thi GetUserById với ID: $id. Lỗi: " . $this->db->error);
                return null; 
            }
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result ?: null; 
        }

        public function findUserByEmail($email){
            $stmt = $this->db->callProcedure('FindUserByEmail', [$email]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function findUserByUsername($username){
            $stmt = $this->db->callProcedure('FindUserByUsername', [$username]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function addUser($data){
            $stmt = $this->db->callProcedure('AddUser', [
                $data['username'],
                $data['fullname'],
                $data['password'],
                $data['email'],
                $data['birthDate'],
                $data['categoryUser'],
                $data['department'],
                $data['status']
            ]);
            return $stmt ? true : false;
        }

        public function deleteUser($id){
            $stmt = $this->db->callProcedure('DeleteUser', [$id]);
            return $stmt ? true : false;
        }

        public function updateUser($data){ 
            $params = [
                $data['userId'],
                $data['username'],
                $data['fullname'],
                $data['password'],
                $data['email'],
                $data['birthDate'],
                $data['categoryUser'],
                $data['department'],
                $data['status']
            ];
        
            $stmt = $this->db->callProcedure('UpdateUser', $params); 
            return $stmt ? true : false;
        }

        public function deleteMultipleUsers($ids){
            $success = true;
            foreach($ids as $id){
                $stmt = $this->db->callProcedure('DeleteUser', [$id]);
                if(!$stmt){
                    $success = false;
                    echo "Failed to delete user with ID: $id<br>";
                }
            }
            return $success;
        }
    }
?>