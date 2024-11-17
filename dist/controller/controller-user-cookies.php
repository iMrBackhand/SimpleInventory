<?php
Class UserCookies {
    private $server = "mysql:host=localhost;dbname=dbims";
    private $user = "root";
    private $pass = "";
    private $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE =>
    PDO::FETCH_ASSOC);
    protected $con;
    
    public function openConnection() {
        try {
            $this->con = new PDO($this->server,$this->user,$this->pass,$this->options);
            return $this->con;  
        } catch (PDOException $e) {
            echo "There is some problem in the connection".$e->getMessage();
        }
    }
    
    public function closeConnection() {
        $this->con = null;
    }

    public function set_userdata($array) {
        if(!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['userdata'] = array(
            "name" => $array['users_name'],
            "email" => $array['users_email'], "id" => $array['users_ID'],
            "access" => $array['users_isAdmin'], "password" => $array['users_password']
        );

        return $_SESSION['userdata'];
    }

    public function get_userdata() {
        if(!isset($_SESSION)) {
            session_start();
        }

        if(isset($_SESSION['userdata'])){
            return $_SESSION['userdata'];
        } else {
            return null;
        }
        
    }

    public function login() {
        if(isset($_GET['login'])) {
            $email = $_GET['email'];
            $password = sha1($_GET['password']);
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM tbl_users WHERE users_email = ? AND (users_password = ?) AND (users_isDelete = ?)");
            $stmt->execute([$email,$password,0]);
            $user = $stmt->fetch();
            $total = $stmt->rowCount();

            if($total > 0) {
                $this->set_userdata($user);
                header ('Location: dashboard.php');
            } else {
                header ('Location: login.php?login-failed');
                
            }
            $this->closeConnection(); 
        }
    }

    public function logout($email) {
        if(!isset($_SESSION)) {
            session_start();
        }

        $_SESSION['userdata'] = null;
        unset($_SESSION['userdata']);
        
    }
    
}

$userInfoClass = new UserCookies();
?>