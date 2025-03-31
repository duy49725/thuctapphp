<?php
    class LetterModel extends BaseModel{
        public function __construct(){
            parent::__construct();
        }

        public function getLetters($page = 1, $sort = '1', $order = 'ASC', $search = '', $categoryUser, $department){
            $offset = ($page - 1) * ITEMS_PER_PAGE;
            $stmt = $this->db->callProcedure('GetLetters', [
                $offset,
                ITEMS_PER_PAGE,
                $sort,
                $order,
                $search,
                $categoryUser, 
                $department
            ]);
            $letters = $stmt->fetchAll(PDO::FETCH_OBJ);
            $stmt->nextRowset();
            $total = $stmt->fetch(PDO::FETCH_OBJ)->total;
            return [
                'letters' => $letters,
                'total' => $total
            ];
        }

        public function getLetterById($id){
            $stmt = $this->db->callProcedure('GetLetterById', [$id]);
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function getUserByDepartment($department){
            $stmt = $this->db->callProcedure('GetUserByDepartment', [$department]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function approvalLetter($id){
            $stmt = $this->db->callProcedure('ApprovalLetter', [$id]);
            return $stmt ? true : false;
        }

        public function cancelLetter($id) {
            $stmt = $this->db->callProcedure('CancelLetter', [$id]);
            return $stmt ? true : false;
        }
        public function addLetter($data) {
            try {
                $params = [
                    $data['userId'],
                    $data['title'],
                    $data['content'],
                    $data['approver'],
                    $data['typesOfApplication'],
                    $data['startDate'],
                    $data['endDate'],
                    $data['status'],
                    $data['attachment']
                ];
        
                $stmt = $this->db->callProcedure('AddLetter', $params);

                if ($stmt === false) {
                    echo("Failed to execute AddLetter stored procedure. Parameters: " . json_encode($params));
                    return false;
                }
                return true;
            } catch (Exception $e) {
                echo("Error in addLetter: " . $e->getMessage());
                return false;
            }
        }
    }
?>