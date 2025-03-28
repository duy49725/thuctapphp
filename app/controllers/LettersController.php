<?php 
    require '../app/PHPMailer/src/Exception.php';
    require '../app/PHPMailer/src/PHPMailer.php';
    require '../app/PHPMailer/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    class LettersController extends BaseController{
        private $letterModel;
        private $userModel;
        public function __construct(){
            parent::__construct();
            $this->letterModel = new LetterModel();
            $this->userModel = new UserModel();
        }

        private function getEmailTemplate($title, $from_name, $from_email, $message, $type = 'application') {
            $header = $type === 'application' ? "ĐƠN XIN " . strtoupper($title) 
                                              :  ($type === 'Approval' ? "THÔNG BÁO ĐỒNG Ý" . strtoupper($title)
                                                                     : "THÔNG BÁO HỦY ĐƠN");
            return "
            <!DOCTYPE html>
            <html lang='vi'>
            <head>
                <meta charset='UTF-8'>
                <style>
                    body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
                    .container { max-width: 600px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
                    .header { text-align: center; padding-bottom: 20px; border-bottom: 2px solid #3498db; }
                    .header h1 { color: #2c3e50; font-size: 24px; margin: 0; text-transform: uppercase; }
                    .content { padding: 20px 0; color: #333; line-height: 1.6; }
                    .content p { margin: 10px 0; }
                    .footer { text-align: center; padding-top: 20px; border-top: 1px solid #dcdcdc; color: #7f8c8d; font-size: 12px; }
                    .signature { margin-top: 30px; text-align: right; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>$header</h1>
                    </div>
                    <div class='content'>
                        <p>Kính gửi: Quý Ban Lãnh đạo/Quản lý, và các bạn nhân viên</p>
                        <p>Tôi tên là: <strong>$from_name</strong>,</p>
                        <p>Email: <strong>$from_email</strong>,</p>
                        <p>Nội dung: </p>
                        <p>" . nl2br($message) . "</p>
                    </div>
                    <div class='signature'>
                        <p>Trân trọng,</p>
                        <p><strong>$from_name</strong></p>
                    </div>
                    <div class='footer'>
                        <p>Email được gửi từ hệ thống tự động - Vui lòng không trả lời trực tiếp.</p>
                    </div>
                </div>
            </body>
            </html>";
        }
        
        public function list(){
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $sort = isset($_GET['sort']) ? $_GET['sort'] : 'letters.letterId';
            $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
            $search = isset($_GET['search']) ? trim($_GET['search']) : '';
            $result = $this->letterModel->getLetters($page, $sort, $order, $search);
            $letters = $result['letters'];
            $total = $result['total'];

            $totalPages = ceil($total / ITEMS_PER_PAGE);
            $data = [
                'letters' => $letters,
                'page' => $page,
                'totalPages' => $totalPages,
                'sort' => $sort,
                'order' => $order,
                'search' => $search
            ];
            $this->view('letters/list', $data);
        }

        public function testCreate(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $user_department = $_SESSION['user_department'];
                $usersDepartment = $this->letterModel->getUserByDepartment($user_department);
                $data = [
                    'userId' => trim($_POST['userId']) ?? '',
                    'title' => isset($_POST['title']) ? trim($_POST['title']) : '',
                    'content' => isset($_POST['content']) ? trim($_POST['content']) : '',
                    'approver' => isset($_POST['approver']) ? trim($_POST['approver']) : '',
                    'typesOfApplication' => isset($_POST['typesOfApplication']) ? trim($_POST['typesOfApplication']) : '',
                    'startDate' => isset($_POST['startDate']) ? trim($_POST['startDate']) : '',
                    'endDate' => isset($_POST['endDate']) ? trim($_POST['endDate']) : '',
                    'status' => 'Chờ duyệt',
                    'attachment' => isset($_POST['attachment']) ? trim($_POST['attachment']) : '',
                    'userId_err' => '',
                    'title_err' => '',
                    'content_err' => '',
                    'approver_err' => '',
                    'typesOfApplication_err' => '',
                    'startDate_err' => '', 
                    'endDate_err' => '',
                    'attachment_err' => '',
                    'usersDepartment' => $usersDepartment
                ];
                
                if(empty($data['userId'])){
                    $data['userId_err'] = '※Vui lòng đăng nhập để tạo đơn';
                }

                if(empty($data['title'])){
                    $data['title_err'] = '※Tiêu đề không được để trống';
                }

                if(empty($data['content'])){
                    $data['content_err'] = '※Nội dung không được để trống';
                }

                if(empty($data['approver'])){
                    $data['approver_err'] = '※Vui lòng lựa chọn người duyệt';
                }

                if(empty($data['typesOfApplication'])){
                    $data['typesOfApplication_err'] = '※Vui lòng lựa chọn loại đơn';
                }

                if(empty($data['startDate'])){
                    $data['startDate_err'] = '※Vui lòng lựa chọn ngày duyệt';
                }else if($data['startDate'] > $data['endDate']){
                    $data['startDate_err'] = '※Ngày bắt đầu phải nhỏ hơn ngày kết thúc';
                }

                if(empty($data['endDate'])){
                    $data['endDate_err'] = '※Vui lòng lựa chọn ngày kết thúc';
                }else if($data['startDate'] > $data['endDate']){
                    $data['endDate_err'] = '※Ngày bắt đầu phải nhỏ hơn ngày kết thúc';
                }

                if(isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK){
                    $upload_dir = "uploads/";
                    if(!file_exists($upload_dir)){
                        mkdir($upload_dir, 0777, true);
                    }
                    $file_name = $_SESSION['user_userId'] . '_' .time() . '_' . basename($_FILES['attachment']['name']);
                    $target_file = $upload_dir . $file_name;
                    if(move_uploaded_file($_FILES['attachment']['tmp_name'], $target_file)){
                        $_SESSION['add_letter'] = [
                            'userId' => $_POST['userId'],
                            'title' => $_POST['title'],
                            'content' => $_POST['content'],
                            'approver' => $_POST['approver'],
                            'status' => $data['status'],
                            'typesOfApplication' => $_POST['typesOfApplication'],
                            'startDate' => $_POST['startDate'],
                            'endDate' => $_POST['endDate'],
                            'attachment' => $file_name
                        ];
                        $this->redirect('letters/create');
                    }else{
                        $data['attachment_err'] = '※Vui lòng lựa chọn tệp đính kèm';
                    }
                }else{
                    $data['attachment_err'] = '※Vui lòng lựa chọn tệp đính kèm';
                    $this->view('letters/testcreate', $data);
                }
            }else{
                $user_department = $_SESSION['user_department'];
            
                $usersDepartment = $this->letterModel->getUserByDepartment($user_department);
                $data = [
                    'userId' => '',
                    'title' => '',
                    'content' => '',
                    'approver' => '',
                    'typesOfApplication' => '',
                    'startDate' => '',
                    'endDate' => '',
                    'status' => 'Chờ duyệt',
                    'attachment' => '',
                    'userId_err' => '',
                    'title_err' => '',
                    'content_err' => '',
                    'approver_err' => '',
                    'typesOfApplication_err' => '',
                    'startDate_err' => '', 
                    'endDate_err' => '',
                    'attachment_err' => '',
                    'usersDepartment' => $usersDepartment
                ];
                $this->view('letters/testcreate', $data);
                var_dump($usersDepartment);
            }
        }

        public function create(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(!isset($_SESSION['add_letter'])){
                    header('Location: ' . BASE_URL . "/public/index.php?url=letters");
                    exit();
                }

                $letterData = $_SESSION['add_letter'];
                $userId = $letterData['userId'];
                $title = $letterData['title'];
                $content = $letterData['content'];
                $approver = $letterData['approver'];
                $typesOfApplication = $letterData['typesOfApplication'];
                $startDate = $letterData['startDate'];
                $endDate = $letterData['endDate'];
                $attachment = $letterData['attachment'];
                $status = $letterData['status'];
                $data = [
                    'userId' => $userId,
                    'title' => $title,
                    'content' => $content,
                    'approver' => $approver,
                    'typesOfApplication' => $typesOfApplication,
                    'startDate' => $startDate,
                    'endDate' =>$endDate,
                    'attachment' => $attachment,
                    'status' => $status
                ];
                if ($this->letterModel->addLetter($data)) {
                    $userApproval = $this->userModel->getUserById($data['approver']);
                    $userEmail = $_SESSION['user_email'];
                    $userName = $_SESSION['user_username'];
                    $from_name = $userName;
                    $from_email = $userEmail;
                    $to_email = $userApproval->email;
                    $subject = $data['title'];
                    $message = $data['content'];

                    $system_email = 'duy49725@gmail.com'; 
                    $system_password = 'xmvj narp srbd zdoh'; 
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; 
                    $mail->SMTPAuth = true;
                    $mail->Username = $system_email; 
                    $mail->Password = $system_password; 
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;
            
                    $mail->setFrom($system_email, $from_name); 
                    $mail->addReplyTo($from_email, $from_name); 
                    $mail->addAddress($to_email); 
            
                    $mail->isHTML(true);
                    $mail->Subject = $subject;
                    $mail->Body    = $this->getEmailTemplate($data->title, $from_name, $from_email, $message, 'application');
                    $mail->AltBody = $message;
            
                    $mail->send();
                    unset($_SESSION['add_letter']);
                    $this->redirect('letters/create');
                } else {
                    echo "Failed to add letter. Check the error log for details.";
                    echo("Failed to add letter. Data: " . json_encode($data));
                    exit;
                }
            }else{
                if(!isset($_SESSION['add_letter'])){
                    header('Location: ' . BASE_URL . "/public/index.php?url=letters");
                    exit();
                }
                $letterData = $_SESSION['add_letter'];
                $userId = $letterData['userId'];
                $title = $letterData['title'];
                $content = $letterData['content'];
                $approver = $letterData['approver'];
                $typesOfApplication = $letterData['typesOfApplication'];
                $startDate = $letterData['startDate'];
                $endDate = $letterData['endDate'];
                $attachment = $letterData['attachment'];
                $status = $letterData['status'];
                $data = [
                    'userId' => $userId,
                    'title' => $title,
                    'content' => $content,
                    'approver' => $approver,
                    'typesOfApplication' => $typesOfApplication,
                    'startDate' => $startDate,
                    'endDate' =>$endDate,
                    'attachment' => $attachment,
                    'status' => $status,
                    'userId_err' => '',
                    'title_err' => '',
                    'content_err' => '',
                    'approver_err' => '',
                    'typesOfApplication_err' => '',
                    'startDate_err' => '', 
                    'endDate_err' => '',
                    'attachment_err' => ''
                ];
                $this->view('letters/create', $data);
            }
        }

        public function approvalLetter($letterId, $userId){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if($this->letterModel->approvalLetter($letterId)){
                    $userApproval = $this->userModel->getUserById($userId);
                    if($userApproval === null){
                        echo("Không tìm thấy người dùng với ID: $userId trong cancelLetter");
                        die('Không tìm thấy người dùng để gửi email');
                    }
                    $reasonForApproval = 'Đồng ý với đề nghị';
                    $userEmail = $_SESSION['user_email'];
                    $userName = $_SESSION['user_username'];
                    $from_name = $userName;
                    $from_email = $userEmail;
                    $to_email = $userApproval->email;
                    $subject = 'Đồng ý';
                    $message = $reasonForApproval;

                    $system_email = 'duy49725@gmail.com';
                    $system_password = 'xmvj narp srbd zdoh';
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = $system_email;
                    $mail->Password = $system_password;
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;

                    $mail->setFrom($system_email, $from_name);
                    $mail->addReplyTo($from_email, $from_name);
                    $mail->addAddress($to_email);

                    $mail->isHTML(true);
                    $mail->Subject = $subject;
                    $letter = $this->letterModel->getLetterById($letterId);
                    if($letter === null){
                        die('Không tìm thấy thư để lấy tiêu đề');
                    }
                    $mail->Body = $this->getEmailTemplate($letter->title, $from_name, $from_email, $message, 'Approval');
                    $mail->AltBody = $message;

                    $mail->send();
                    $this->redirect('letters');
                }else{
                    die('Something went wrong');
                }
            }else{
                $letterData = $this->letterModel->getLetterById($letterId);
                $userId = $letterData->userId;
                $title = $letterData->title;
                $content = $letterData->content;
                $approver = $letterData->approver;
                $typesOfApplication = $letterData->typesOfApplication;
                $startDate = $letterData->startDate;
                $endDate = $letterData->endDate;
                $attachment = $letterData->attachment;
                $data = [
                    'letterId' => $letterId,
                    'userId' => $userId,
                    'title' => $title,
                    'content' => $content,
                    'approver' => $approver,
                    'typesOfApplication' => $typesOfApplication,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'attachment' => $attachment
                ];
                $this->view('letters/approval', $data);
            }
        }

        public function cancelLetter($letterId, $userId){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if($this->letterModel->cancelLetter((int)$letterId)){
                    $userCancel = $this->userModel->getUserById($userId);
                    if ($userCancel === null) {
                        echo("Không tìm thấy người dùng với ID: $userId trong cancelLetter");
                        die('Không tìm thấy người dùng để gửi email');
                    }
                    $reasonForCancellation = $_POST['reason'] ?? 'Không có lý do cụ thể';
                    $userEmail = $_SESSION['user_email'];
                    $userName = $_SESSION['user_username'];
                    $from_name = $userName;
                    $from_email = $userEmail;
                    $to_email = $userCancel->email;
                    $subject = 'Lý do chưa hợp lý';
                    $message = $reasonForCancellation;
            
                    $system_email = 'duy49725@gmail.com'; 
                    $system_password = 'xmvj narp srbd zdoh'; 
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; 
                    $mail->SMTPAuth = true;
                    $mail->Username = $system_email; 
                    $mail->Password = $system_password; 
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;
                    
                    $mail->setFrom($system_email, $from_name); 
                    $mail->addReplyTo($from_email, $from_name); 
                    $mail->addAddress($to_email); 
                    
                    $mail->isHTML(true);
                    $mail->Subject = $subject;
                    $letter = $this->letterModel->getLetterById($letterId); 
                    if ($letter === null) {
                        die('Không tìm thấy thư để lấy tiêu đề');
                    }
                    $mail->Body    = $this->getEmailTemplate($letter->title, $from_name, $from_email, $message, 'cancellation');
                    $mail->AltBody = $message;
                    
                    $mail->send();
                    $this->redirect('letters');
                }else{
                    die('Có lỗi khi hủy thư');
                }
            }else{
                $this->redirect('letters');
            }
        }
        public function delete($id){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if($this->letterModel->deleteLetter($id)){
                    $this->redirect('letters');
                }else{
                    die('Something went wrong');
                }
            }else{
                $this->redirect('letters');
            }
        }
    }
?>