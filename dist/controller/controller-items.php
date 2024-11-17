<?php
Class Items {
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
    public function createItem() {
        if (isset($_POST['create-item'])) {
            $name = strtoupper($_POST['name']);
            $tags = $_POST['tags'];
            $category = $_POST['category'];

            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM tbl_items WHERE item_isDelete = ? AND item_name = ?");
            $stmt->execute([0,$name]);
            $total = $stmt->rowCount();
            if ($total == 0) { 
                $stmt = $connection->prepare("INSERT INTO tbl_items (item_name,item_tags,item_categoryID) VALUES (?,?,?)");
                $stmt->execute([$name,$tags,$category]);
                echo '<script>window.location.assign("items-create.php?item-added")</script>';
            } else {
                echo '<script>window.location.assign("items-create.php?item-exists")</script>';
            }
            
            $this->closeConnection();
            
        }

    }

    //Read
    public function readItems() {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT tbl_items.*, tbl_category.* FROM tbl_items
        LEFT JOIN tbl_category ON tbl_items.item_categoryID = tbl_category.category_ID 
        WHERE item_isDelete = ?");
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

    public function readThisItem($id) {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT tbl_items.*, tbl_category.* FROM tbl_items
        LEFT JOIN tbl_category ON tbl_items.item_categoryID = tbl_category.category_ID 
        WHERE item_ID = ? AND item_isDelete = ?");
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
    public function updateItem($id,$cname) {
        if (isset($_POST['update-item'])) {
            $name = strtoupper($_POST['name']);
            $tags = $_POST['tags'];
            $category = $_POST['category'];
            $connection = $this->openConnection();
            if ($cname == $name) {
                $stmt = $connection->prepare("UPDATE tbl_items SET item_tags = ?, item_categoryID = ?
                WHERE item_ID = ?");
                $stmt->execute([$tags,$category,$id]);
                echo '<script>window.location.assign("items-details.php?update-success&id='.$id.'")</script>';
            } else {
                $stmt = $connection->prepare("SELECT * FROM tbl_items WHERE item_name = ? AND item_isDelete = ?");
                $stmt->execute([$name,0]);
                $total = $stmt->rowCount();
                if ($total == 0) {
                    $stmt = $connection->prepare("UPDATE tbl_items SET item_name = ?, item_tags = ?, item_categoryID = ?
                    WHERE item_ID = ?");
                    $stmt->execute([$name,$tags,$category,$id]);
                    echo '<script>window.location.assign("items-details.php?update-success&id='.$id.'")</script>';
                } else {
                    echo '<script>window.location.assign("items-details.php?name-exists&id='.$id.'")</script>';
                }
            }
            
            $this->closeConnection();
            
        }
        
    }

    //Delete
    public function deleteItem() {
        if (isset($_POST['delete-item'])) {
            $id = $_POST['delete-item'];
            $connection = $this->openConnection();
            $stmt = $connection->prepare("UPDATE tbl_items SET item_isDelete = ? WHERE item_ID = ?");
            $stmt->execute([1,$id]);
            $this->closeConnection();
        }
    }

}
$itemClass = new Items();
?>