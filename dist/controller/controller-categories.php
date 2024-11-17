<?php
Class Categories {
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
    public function createCategory() {
        if (isset($_POST['create-category'])) {
            $name = strtoupper($_POST['name']);
            $desc = $_POST['description'];

            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM tbl_category WHERE category_isDelete = ? AND category_name = ?");
            $stmt->execute([0,$name]);
            $total = $stmt->rowCount();
            if ($total == 0) { 
                $stmt = $connection->prepare("INSERT INTO tbl_category (category_name,category_desc) VALUES (?,?)");
                $stmt->execute([$name,$desc]);
                $this->closeConnection();
                echo '<script>window.location.assign("categories-create.php?category-added")</script>';
            } else { 
                echo '<script>window.location.assign("categories-create.php?category-exists")</script>';
            }

            
        }

    }

    //Read
    public function readCategories() {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT * FROM tbl_category WHERE category_isDelete = ? ORDER BY category_ID DESC");
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

    public function readThisCategories($id) {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT * FROM tbl_category WHERE category_ID = ? AND category_isDelete = ?");
        $stmt->execute([$id,0]);
        $datas = $stmt->fetch();
        $total = $stmt->rowCount();
        if($total > 0) {
            return $datas;
        } else {
            return null;
        }
        $this->closeConnection();
    }

    //Update
    public function updateCategory($id,$cname) {
        if (isset($_POST['update-category'])) {
            $name = strtoupper($_POST['name']);
            $desc = $_POST['description'];
            $connection = $this->openConnection();

            if ($cname == $name) {
                $stmt = $connection->prepare("UPDATE tbl_category SET category_name = ?, category_desc = ?
                WHERE category_ID = ?");
                $stmt->execute([$name,$desc,$id]);
                echo '<script>window.location.assign("categories-details.php?update-success&id='.$id.'")</script>';
            } else {
                $stmt = $connection->prepare("SELECT * FROM tbl_category WHERE category_name = ? AND category_isDelete = ?");
                $stmt->execute([$name,0]);
                $total = $stmt->rowCount();
                if ($total == 0) {
                    $stmt = $connection->prepare("UPDATE tbl_category SET category_name = ?, category_desc = ?
                    WHERE category_ID = ?");
                    $stmt->execute([$name,$desc,$id]);
                    echo '<script>window.location.assign("categories-details.php?update-success&id='.$id.'")</script>';
                } else {
                    echo '<script>window.location.assign("categories-details.php?name-exists&id='.$id.'")</script>';
                }
            }

            $this->closeConnection();
            
        }
        
    }

    //Delete
    public function deleteCategory() {
        if (isset($_POST['delete-category'])) {
            $id = $_POST['delete-category'];
            $connection = $this->openConnection();
            $stmt = $connection->prepare("UPDATE tbl_category SET category_isDelete = ? WHERE category_ID = ?");
            $stmt->execute([1,$id]);
            $this->closeConnection();
            echo '<script>window.location.assign("categories-table.php?successfully-deleted")</script>';
        }
    }

}
$categoryClass = new Categories();
?>