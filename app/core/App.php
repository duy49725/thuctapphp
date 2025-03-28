<?php 
    class App{
        public function __construct(){
            require_once APP_PATH . '/config/config.php';
            require_once APP_PATH . '/config/database.php';

            spl_autoload_register(function($className){
                $paths = ['controllers/', 'models/', 'core/'];
                foreach($paths as $path){
                    $file = APP_PATH . '/' . $path . $className . '.php';
                    if(file_exists($file)){
                        require_once $file;
                    }
                }
            });

            $router = new Router();
        }
    }
?>