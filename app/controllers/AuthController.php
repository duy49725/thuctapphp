<?php 
    class AuthController extends BaseController{
        private $authModel;

        public function __construct(){
            parent::__construct();
            $this->authModel = new AuthModel();
        }

        public function login(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'username' => trim($_POST['username']),
                    'password' => trim($_POST['password']),
                    'username_err' => '',
                    'password_err' => ''
                ];
                $user = $this->authModel->login($data['username'], $data['password']);
                if(empty($data['username'])){
                    $data['username_err'] = '※Xin hãy nhập tên đăng nhập';
                }else{

                }
                if(empty($data['password'])){
                    $data['password_err'] = '※Xin hãy nhập passoword';
                }

                if(!$user){
                    $data['password_err'] = '※Sai tài khoản hoặc mật khẩu';
                }

                if(empty($data['username_err']) && empty($data['password_err']) && $user->status == 'Đang hoạt động'){
                    if($user){
                        $_SESSION['user_id'] = $user->userId;
                        $_SESSION['user_username'] = $user->username;
                        $_SESSION['user_email'] = $user->email;
                        $_SESSION['user_department'] = $user->department;
                        $_SESSION['user_categoryUser'] = $user->categoryUser;
                        $this->redirect('dashboard/dashboard');
                    }else{
                        $data['password_err'] = 'Sai tài khoản hoặc mật khẩu';
                        $this->viewlogin('auth/login', $data);
                    }
                }else{
                    $this->viewlogin('auth/login', $data);
                }
            }else{
                $data = [
                    'username' => '',
                    'password' => '',
                    'username_err' => '',
                    'password_err' => ''
                ];
                $this->viewlogin('auth/login', $data);
            }
        }

        public function logout(){
            unset($_SESSION['user_id']);
            unset($_SESSION['user_username']);
            session_destroy();
            $this->redirect('auth/login');
        }
    }
?>