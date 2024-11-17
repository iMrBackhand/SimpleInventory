<?php
Class Dashboard {
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

    //Read
    public function countUsers() {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT users_ID FROM tbl_users WHERE users_isDelete = ?");
        $stmt->execute([0]);
        $total = $stmt->rowCount();
        return $total;
        $this->closeConnection();
    }

    public function countOrders($userID) {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT order_ID FROM tbl_orders WHERE order_userID = ?");
        $stmt->execute([$userID]);
        $total = $stmt->rowCount();
        return $total;
        $this->closeConnection();
    }

    public function totalInventoryValue() {
        $connection = $this->openConnection();
        $date = date('Y-m-d');
        $stmt = $connection->prepare("SELECT expense_qtyLeft, expense_price FROM tbl_expenses WHERE expense_isDelete = ? AND expense_expirationDate != ?");
        $stmt->execute([0,$date]);
        $datas = $stmt->fetchAll();
        $total = 0; 
        $lowStocks = 0;
        foreach ($datas as $data) {
            $total += $data['expense_qtyLeft'] * $data['expense_price'];
        }
        
        return $total;
        $this->closeConnection();
    }

    public function totalLowStocks() {
        $connection = $this->openConnection();
        $date = date('Y-m-d');
        $stmt = $connection->prepare("SELECT expense_itemID FROM tbl_expenses GROUP BY expense_itemID");
        $stmt->execute();
        $datas = $stmt->fetchAll();
        $count = 0; 
        foreach ($datas as $data) {
            $stmt = $connection->prepare("SELECT expense_qtyLeft FROM tbl_expenses WHERE expense_itemID = ? AND expense_isDelete = ? AND expense_expirationDate != ?");
            $stmt->execute([$data['expense_itemID'],0,$date]);
            $qtys = $stmt->fetchAll();
            $totalqty = 0; 
            foreach ($qtys as $qty){
                $totalqty += $qty['expense_qtyLeft'];
            }

            if ($totalqty <= 10) { 
                $count ++;
            }
        }
        
        return $count;
        $this->closeConnection();
    }

    //Read
    public function readItemDetails() {
        $date = date('Y-m');
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT tbl_items.item_name,tbl_items.item_ID,
        tbl_expenses.expense_price,tbl_expenses.expense_ID,tbl_expenses.expense_itemID,expense_qtyLeft,
        tbl_expenses.expense_supplier,tbl_expenses.expense_expirationDate,tbl_expenses.expense_date 
        FROM tbl_expenses
        LEFT JOIN tbl_items ON tbl_items.item_ID = tbl_expenses.expense_itemID
        WHERE expense_qtyLeft != ? AND expense_expirationDate LIKE '%$date%'");
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

    

}
$dashboardClass = new Dashboard();
?>