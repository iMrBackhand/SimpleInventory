<?php
Class Account {
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
    
    //Create
    public function createAccount() {
        if (isset($_POST['create-account'])) {
            $name = strtoupper($_POST['name']);
            $email = $_POST['email'];
            $password = sha1($_POST['password']);
            $cPassword = sha1($_POST['cpassword']);
            $access = $_POST['access'];

            //checking if email exist.
            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM tbl_users WHERE users_email = ? AND users_isDelete = ?");
            $stmt->execute([$email,0]);
            $total = $stmt->rowCount();
            if ($total == 0) { 
                if ($password == $cPassword) { 
                    $stmt = $connection->prepare("INSERT INTO tbl_users (users_email,users_password,users_name,users_isAdmin) 
                    VALUES (?,?,?,?)");
                    $stmt->execute([$email,$password,$name,$access]);
                    $this->closeConnection();
                    echo '<script>window.location.assign("login.php?account-created")</script>';
                } else { 
                    echo '<script>window.location.assign("register.php?password-not-same")</script>';
                }
            } else {
                echo '<script>window.location.assign("register.php?email-exists")</script>';
            }

            $this->closeConnection();
            
        }

    }

    //Read

    //Read Accounts
    public function readAccounts() {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT * FROM tbl_users WHERE users_isDelete = ?");
        $stmt->execute([0]);
        $datas = $stmt->fetchAll();
        $total = $stmt->rowCount();
        if($total > 0) {
            return $datas;
        } else {
            return null;
        }
        $this->closeConnection();
    }

    //read specific User using ID -- users-accounts.php
    public function readUserAccount($userid) {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT * FROM tbl_users WHERE users_ID = ?");
        $stmt->execute([$userid]);
        $users = $stmt->fetch();
        $total = $stmt->rowCount();
        if($total > 0) {
            return $users;
        } else {
            return null;
        }
        $this->closeConnection();
    }

    //Update
    public function updateAccount($id,$cpassword,$cemail,$isAdmin) {
        if (isset($_POST['update-account'])) {
            $name = strtoupper($_POST['name']);
            $email = $_POST['email'];
            $access = $_POST['access'];

            $connection = $this->openConnection();
            if ($isAdmin == 1) {
                $password = $cpassword;
            } else {
                $password = sha1($_POST['password']);
            }

            if ($password == $cpassword) { 
                if ($email == $cemail) {
                    $stmt = $connection->prepare("UPDATE tbl_users SET users_name = ?, users_isAdmin = ?
                    WHERE users_ID = ?");
                    $stmt->execute([$name,$access,$id]);
                    echo '<script>window.location.assign("accounts-details.php?accounts-table&update-success&id='.$id.'")</script>';
                } else {
                    $stmt = $connection->prepare("SELECT * FROM tbl_users WHERE users_email = ? AND users_isDelete = ?");
                    $stmt->execute([$email,0]);
                    $total = $stmt->rowCount();
                    if ($total == 0) { 
                        $stmt = $connection->prepare("UPDATE tbl_users SET users_email = ?, users_name = ?, users_isAdmin = ?
                        WHERE users_ID = ?");
                        $stmt->execute([$email,$name,$access,$id]);
                        echo '<script>window.location.assign("accounts-details.php?accounts-table&update-success&id='.$id.'")</script>';
                    } else {
                        echo '<script>window.location.assign("accounts-details.php?accounts-table&email-exists&id='.$id.'")</script>';
                    }
                }
            } else {
                echo '<script>window.location.assign("accounts-details.php?accounts-table&password-not-correct&id='.$id.'")</script>';
            }
            $this->closeConnection();
        }
        
    }

    //update Password
    public function updatePassword($userID,$currentPassword) {
        if (isset($_POST['update-password'])) {
            $password = sha1($_POST['current-password']);
            $newPassword = sha1($_POST['new-password']);
            $repeatPassword = sha1($_POST['confirm-password']);
            if ($currentPassword == $password) {
                if ($newPassword == $repeatPassword) {
        
                    $connection = $this->openConnection();
                    $stmt = $connection->prepare("UPDATE tbl_users SET users_password = ? WHERE users_ID = ?");
                    $stmt->execute([$newPassword,$userID]);
                    echo '<script>window.location.assign("controller/controller-logout.php")</script>';
                    $this->closeConnection();
                } else {
                    echo '<script>window.location.assign("settings-password.php?password-not-match")</script>';
                }
            } else {
                echo '<script>window.location.assign("settings-password.php?wrong-current-password")</script>';
            }
            
        }
        
    }

    //Reset Password
    public function resetPassword($id) {
        if (isset($_POST['reset-password'])) {
            $connection = $this->openConnection();
            $stmt = $connection->prepare("UPDATE tbl_users SET users_password = ? WHERE users_ID = ?");
            $stmt->execute(['40bd001563085fc35165329ea1ff5c5ecbdbbeef',$id]);
            echo '<script>window.location.assign("accounts-details.php?accounts-table&reset-password&id='.$id.'")</script>';
            $this->closeConnection();
        }
        
    }

    //Delete
    public function deleteAccount() {
        if (isset($_POST['delete-account'])) {
            $id = $_POST['delete-account'];

            $connection = $this->openConnection();
            $stmt = $connection->prepare("UPDATE tbl_users SET users_isDelete = ? WHERE users_ID = ?");
            $stmt->execute([1,$id]);
            echo '<script>window.location.assign("accounts-table.php?successfully-deleted")</script>';
            $this->closeConnection();
        }
        
    }

}
$accountClass = new Account();
?>