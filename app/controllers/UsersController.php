<?php 
    class UsersController extends BaseController{
        private $userModel;

        public function __construct(){
            parent::__construct();
            $this->userModel = new UserModel();
        }

        public function list(){
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $sort = isset($_GET['sort']) ? $_GET['sort'] : 'userId';
            $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
            $search = isset($_GET['search']) ? trim($_GET['search']) : '';
            $department =  $_SESSION['user_department'];
            $categoryUser = $_SESSION['user_categoryUser'];
            $result = $this->userModel->getUsers($page, $sort, $order, $search, $department, $categoryUser);
            $users = $result['users'];
            $total = $result['total'];
            $totalPages = ceil($total / ITEMS_PER_PAGE);
            $data = [
                'users' => $users,
                'page' => $page,
                'totalPages' => $totalPages,
                'sort' => $sort,
                'order' => $order,
                'search' => $search,
                'department' => $department
            ];
            
            $this->view('users/list', $data); 
        }

        public function testCreate(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'username' => trim($_POST['username']),
                    'fullname' => trim($_POST['fullname']),
                    'password' => trim($_POST['password']),
                    'email' => trim($_POST['email']),
                    'birthDate' => trim($_POST['birthDate']),
                    'categoryUser' => trim($_POST['categoryUser']),
                    'department' => trim($_POST['department']),
                    'status' => trim($_POST['status']),
                    'username_err' => '',
                    'fullname_err' => '',
                    'password_err' => '',
                    'email_err' => '',
                    'birthDate_err' => '',
                    'categoryUser_err' => '',
                    'department_err' => '',
                    'status_err' => ''
                ];
                if(empty($data['username'])){
                    $data['username_err'] = '※Xin hãy nhập tên';
                }else{
                    if($this->userModel->findUserByUsername($data['username'])){
                        $data['username_err'] = '※Tên người dùng đã được sử dụng';
                    }
                }

                if(empty($data['fullname'])){
                    $data['fullname_err'] = '※Xin hãy nhập họ tên đầy đủ';
                }

                if(empty($data['password'])){
                    $data['password_err'] = '※Xin hãy nhập mật khẩu';
                }elseif(!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $data['password'])) {
                    $data['password_err'] = "※Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ cái, số và ký tự đặc biệt!";
                }

                if(empty($data['email'])){
                    $data['email_err'] = '※Xin hãy nhập email';
                }else{
                    if($this->userModel->findUserByEmail($data['email'])){
                        $data['email_err'] = '※Email đã được sử dụng';
                    }
                }

                if(empty($data['birthDate'])){
                    $data['birthDate_err'] = '※Xin hãy nhập ngày sinh';
                }

                if(empty($data['categoryUser'])){
                    $data['categoryUser_err'] = '※Xin hãy nhập loại người dùng';
                }

                if(empty($data['department'])){
                    $data['department_err'] = '※Xin hãy nhập phòng ban';
                }

                if(empty($data['username_err']) && empty($data['fullname_err']) && empty($data['password_err']) 
                && empty($data['email_err']) && empty($data['birthDate_err']) && empty($data['categoryUser_err']) && empty($data['department_err'])){
                    $_SESSION['add_user'] = [
                        'username' => $_POST['username'],
                        'fullname' => $_POST['fullname'],
                        'password' => $_POST['password'],
                        'email' => $_POST['email'],
                        'birthDate' => $_POST['birthDate'] ?: null,
                        'categoryUser' => $_POST['categoryUser'],
                        'department' => $_POST['department'],
                        'status' => $_POST['status']
                    ];
                    $this->redirect('users/create');
                }else{
                    $this->view('users/testcreate', $data);
                }
            }else{
                $data = [
                    'username' => '',
                    'fullname' => '',
                    'password' => '',
                    'email' => '',
                    'birthDate' => '',
                    'categoryUser' => '',
                    'department' => '',
                    'status' => '',
                    'username_err' => '',
                    'fullname_err' => '',
                    'password_err' => '',
                    'email_err' => '',
                    'birthDate_err' => '',
                    'categoryUser_err' => '',
                    'department_err' => '',
                    'status_err' => ''
                ];
                $this->view('users/testcreate', $data);
            }
        }

        public function create(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if (!isset($_SESSION['add_user'])) {
                    header("Location: " . BASE_URL . "/public/index.php?url=users");
                    exit();
                }
                
                $userData = $_SESSION['add_user'];
                $username = $userData['username'] ?? '';
                $fullname = $userData['fullname'] ?? '';
                $password = $userData['password'] ?? '';
                $email = $userData['email'] ?? '';
                $birthDate = $userData['birthDate'] ?? '';
                $categoryUser = $userData['categoryUser'] ?? '';
                $department = $userData['department'] ?? '';
                $status = $userData['status'] ?? '';
                $data = [
                    'username' => $username,
                    'fullname' => $fullname,
                    'password' => $password,
                    'email' => $email,
                    'birthDate' => $birthDate,
                    'categoryUser' => $categoryUser,
                    'department' => $department,
                    'status' => $status
                ];
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                if($this->userModel->addUser($data)){
                    unset($_SESSION['add_user']);
                    $this->redirect('users');
                }else{
                    die('Something went wrong');
                }
            }else{
                if (!isset($_SESSION['add_user'])) {
                    header("Location: " . BASE_URL . "/public/index.php?url=users");
                    exit();
                }
                
                $userData = $_SESSION['add_user'];
                $username = $userData['username'] ?? '';
                $fullname = $userData['fullname'] ?? '';
                $password = $userData['password'] ?? '';
                $email = $userData['email'] ?? '';
                $birthDate = $userData['birthDate'] ?? '';
                $categoryUser = $userData['categoryUser'] ?? '';
                $department = $userData['department'] ?? '';
                $status = $userData['status'] ?? '';
                $data = [
                    'username' => $username,
                    'fullname' => $fullname,
                    'password' => $password,
                    'email' => $email,
                    'birthDate' => $birthDate,
                    'categoryUser' => $categoryUser,
                    'department' => $department,
                    'status' => $status,
                    'username_err' => '',
                    'fullname_err' => '',
                    'password_err' => '',
                    'email_err' => '',
                    'birthDate_err' => '',
                    'categoryUser_err' => '',
                    'department_err' => '',
                    'status_err' => ''
                ];
                $this->view('users/create', $data);
            }
        }
        
        public function testEdit($userId){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'userId' => $userId,
                    'username' => trim($_POST['username']),
                    'fullname' => trim($_POST['fullname']),
                    'password' => trim($_POST['password']),
                    'email' => trim($_POST['email']),
                    'birthDate' => trim($_POST['birthDate']),
                    'categoryUser' => trim($_POST['categoryUser']),
                    'department' => trim($_POST['department']),
                    'status' => trim($_POST['status']),
                    'username_err' => '',
                    'fullname_err' => '',
                    'password_err' => '',
                    'email_err' => '',
                    'birthDate_err' => '',
                    'categoryUser_err' => '',
                    'department_err' => '',
                    'status_err' => ''
                ];
                if(empty($data['username'])){
                    $data['username_err'] = '※Xin hãy nhập tên';
                }

                if(empty($data['fullname'])){
                    $data['fullname_err'] = '※Xin hãy nhập họ tên đầy đủ';
                }

                if(empty($data['password'])){
                    $data['password_err'] = '※Xin hãy nhập mật khẩu';
                }elseif(!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $data['password'])){
                    $data['password_err'] = "※Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ cái, số và ký tự đặc biệt!";
                }

                if(empty($data['email'])){
                    $data['email_err'] = '※Xin hãy nhập email';
                }

                if(empty($data['birthDate'])){
                    $data['birthDate_err'] = '※Xin hãy nhập ngày sinh';
                }
                
                if(empty($data['categoryUser'])){
                    $data['categoryUser_err'] = '※Xin hãy nhập loại người dùng';
                }

                if(empty($data['department'])){
                    $data['department_err'] = '※Xin hãy nhập phòng ban';
                }

                if(empty($data['username_err']) && empty($data['fullname_err']) && empty($data['password_err']) 
                && empty($data['email_err']) && empty($data['birthDate_err']) && empty($data['categoryUser_err']) && empty($data['department_err'])){
                    $_SESSION['edit_user'] = [
                        'userId' => $userId,
                        'username' => $_POST['username'],
                        'fullname' => $_POST['fullname'],
                        'password' => $_POST['password'],
                        'email' => $_POST['email'],
                        'birthDate' => $_POST['birthDate'],
                        'categoryUser' => $_POST['categoryUser'],
                        'department' => $_POST['department'],
                        'status' => $_POST['status']
                    ];
                    $this->redirect('users/edit');
                }else{
                    $this->view('users/testedit', $data);
                }

            }else{
                $user = $this->userModel->getUserById($userId);
                $data = [
                    'userId' => $user->userId,
                    'username' => $user->username,
                    'fullname' => $user->fullname,
                    'password' => $user->password,
                    'email' => $user->email,
                    'birthDate' => $user->birthDate,
                    'categoryUser' => $user->categoryUser,
                    'department' => $user->department,
                    'status' => $user->status,
                    'username_err' => '',
                    'fullname_err' => '',
                    'password_err' => '',
                    'email_err' => '',
                    'birthDate_err' => '',
                    'categoryUser_err' => '',
                    'department_err' => '',
                    'status_err' => ''
                ];
                $this->view('users/testedit', $data);
            }
        }

        public function edit(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(!isset($_SESSION['edit_user'])){
                    header("Location: " . BASE_URL . "/public/index.php?url=users");
                    exit();
                }
                $userData = $_SESSION['edit_user'];
                $userId = $userData['userId'] ?? '';
                $username = $userData['username'] ?? '';
                $fullname = $userData['fullname'] ?? '';
                $password = $userData['password'] ?? '';
                $email = $userData['email'] ?? '';
                $birthDate = $userData['birthDate'] ?? '';
                $categoryUser = $userData['categoryUser'] ?? '';
                $department = $userData['department'] ?? '';
                $status = $userData['status'] ?? '';
                $data = [
                    'userId' => $userId,
                    'username' => $username,
                    'fullname' => $fullname,
                    'password' => $password,
                    'email' => $email,
                    'birthDate' => $birthDate,
                    'categoryUser' => $categoryUser,
                    'department' => $department,
                    'status' => $status,
                    'username_err' => '',
                    'fullname_err' => '',
                    'password_err' => '',
                    'email_err' => '',
                    'birthDate_err' => '',
                    'categoryUser_err' => '',
                    'department_err' => ''
                ];
                if(empty($data['username'])){
                    $data['username_err'] = 'Xin hãy nhập tên';
                }

                if(empty($data['fullname'])){
                    $data['fullname_err'] = 'Xin hãy nhập họ tên đầy đủ';
                }

                if(empty($data['password'])){
                    $data['password_err'] = 'Xin hãy nhập mật khẩu';
                }elseif(!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $data['password'])) {
                    echo "Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ cái, số và ký tự đặc biệt!";
                }

                if(empty($data['email'])){
                    $data['email_err'] = 'Xin hãy nhập email';
                }

                if(empty($data['birthDate'])){
                    $data['birthDate_err'] = 'Xin hãy nhập ngày sinh';
                }

                if(empty($data['categoryUser'])){
                    $data['categoryUser_err'] = 'Xin hãy nhập loại người dùng';
                }

                if(empty($data['department'])){
                    $data['department_err'] = 'Xin hãy nhập phòng ban';
                }

                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                if($this->userModel->updateUser($data)){
                    unset($_SESSION['edit_user']);
                    $this->redirect('users');
                }else{
                    die('Something went wrong');
                }

            }else{
                if(!isset($_SESSION['edit_user'])){
                    header("Location: " . BASE_URL . "/public/index.php?url=users");
                    exit();
                }
                $userData = $_SESSION['edit_user'];
                $userId = $userData['userId'] ?? '';
                $username = $userData['username'] ?? '';
                $fullname = $userData['fullname'] ?? '';
                $password = $userData['password'] ?? '';
                $email = $userData['email'] ?? '';
                $birthDate = $userData['birthDate'] ?? '';
                $categoryUser = $userData['categoryUser'] ?? '';
                $department = $userData['department'] ?? '';
                $status = $userData['status'] ?? '';
                $user = $this->userModel->getUserById($userId);
                $data = [
                    'userId' => $userId,
                    'username' => $username,
                    'fullname' => $fullname,
                    'password' => $password,
                    'email' => $email,
                    'birthDate' => $birthDate,
                    'categoryUser' => $categoryUser,
                    'department' => $department,
                    'status' => $status,
                    'username_err' => '',
                    'fullname_err' => '',
                    'password_err' => '',
                    'email_err' => '',
                    'birthDate_err' => '',
                    'categoryUser_err' => '',
                    'department_err' => '',
                    'status_err' => ''
                ];
                $this->view('users/edit', $data);
            }
        }

        public function delete($id){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if($this->userModel->deleteUser($id)){
                    $this->redirect('users');
                }else{
                    die('Something went wrong');
                }
            }else{
                $this->redirect('users');
            }
        }

        public function deleteMultiple(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $ids = isset($_POST['ids']) ? $_POST['ids'] : [];
                if(count($ids) > 0){
                    if($this->userModel->deleteMultipleUsers($ids)){
                        $this->redirect('users');
                    }else{
                        foreach($ids as $id){
                            echo $id;
                        }
                    }
                }else{
                    $this->redirect('users');
                }
            }else{
                $this->redirect('users');
            }
        }
    }
?>