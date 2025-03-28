<?php 
    class BaseController{
        protected $view;

        public function __construct(){
            if(!isset($_SESSION)){
                session_start();
            }

            if(!isset($_SESSION['user_id']) && get_class($this) != 'AuthController'){
                header('Location: ' . BASE_URL . '/public/index.php?url=' . 'auth/login');
                exit;
            }
            
        }

        public function view($view, $data = []){
            if(file_exists(VIEWS_PATH . '/' . $view . '.php')){
                extract($data);
                require_once VIEWS_PATH . '/layouts/header.php';
                require_once VIEWS_PATH . '/' . $view . '.php';
                require_once VIEWS_PATH . '/layouts/footer.php';
            }else{
                die('View does not exist');
            }
        }

        public function viewLogin($view, $data = []){
            if(file_exists(VIEWS_PATH . '/' . $view . '.php')){
                extract($data);
                require_once VIEWS_PATH . '/' . $view . '.php';
            }else{
                die('View does not exist');
            }
        }

        public function redirect($url){
            $fullUrl = BASE_URL . '/public/index.php?url=' . $url;
            header('Location: ' . $fullUrl);
            exit;
        }
    }
?>