<?php 
    class DashboardController extends BaseController{
        private $dashboardModel;
        public function __construct(){
            parent::__construct();
            $this->dashboardModel = new DashboardModel();
        }

        public function dashboard(){
            $letters = $this->dashboardModel->getLetters();
            $data = [
                'letters' => $letters,
            ];
            $this->view('dashboard/dashboard', $data);
        }
    }
?>