<?php
Class Orders {
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
    public function createOrder($id,$userID) {
        if (isset($_POST['add-order'])) {
            $qty = $_POST['qty'];
            $price = $_POST['price'];

            $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM tbl_orders WHERE order_itemID = ? AND order_userID = ?");
            $stmt->execute([$id,$userID]);
            $total = $stmt->rowCount();
            if ($total == 0) { 
            $stmt = $connection->prepare("INSERT INTO tbl_orders (order_userID,order_itemID,order_qty,order_price) VALUES (?,?,?,?)");
            $stmt->execute([$userID,$id,$qty,$price]);
            $this->closeConnection();
            echo '<script>window.location.assign("orders.php")</script>';
            } else {
                echo '<script>window.location.assign("items-shop.php?id='.$id.'&order-exists")</script>';
            }
            
            
        }

    }

    public function createExpenses() {
        if (isset($_POST['create-expense'])) {
            if (!empty($_POST['itemID'])) { 
                $supplier  = strtoupper($_POST['supplier']);
                $receiptNo  = $_POST['receipt-no'];

                $qty = $_POST['qty'];
                $price = $_POST['price'];
                $itemID  = $_POST['itemID'];
                $expDate  = $_POST['exp-date'];
                $orderID = $_POST['orderID'];

                foreach ($qty as $index => $qtys) {
                    $s_qty = $qtys;
                    $s_price = $price[$index];
                    $s_itemID = $itemID[$index];
                    $s_expDate = $expDate[$index];
                    $s_orderID = $orderID[$index];
    
                    $connection = $this->openConnection();
                    $stmt = $connection->prepare("INSERT INTO tbl_expenses (expense_receiptNo,expense_supplier,expense_itemID,expense_qty,expense_qtyLeft,expense_price,expense_expirationDate) 
                    VALUES (?,?,?,?,?,?,?)");
                    $stmt->execute([$receiptNo,$supplier,$s_itemID,$s_qty,$s_qty,$s_price,$s_expDate]);
                    $stmt = $connection->prepare("DELETE FROM tbl_orders WHERE order_ID = ?");
                    $stmt->execute([$s_orderID]);
    
                }

                $this->closeConnection();
                echo '<script>window.location.assign("orders.php")</script>';
            } else {
                echo '<script>window.location.assign("orders.php?no-orders")</script>';
            }
            
        }

    }

    //Read
    public function readExpenses() {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT tbl_items.item_name,tbl_items.item_ID,tbl_expenses.expense_qty,
        tbl_expenses.expense_price,tbl_expenses.expense_ID,tbl_expenses.expense_itemID,tbl_expenses.expense_receiptNo,
        tbl_expenses.expense_supplier,tbl_expenses.expense_expirationDate,tbl_expenses.expense_date 
        FROM tbl_expenses
        LEFT JOIN tbl_items ON tbl_items.item_ID = tbl_expenses.expense_itemID");
        $stmt->execute();
        $datas = $stmt->fetchAll();
        $total = $stmt->rowCount();
        if($total > 0) {
            return $datas;
        } else {
            return null;
        }
        $this->closeConnection();
    }

    //Read
    public function readInventory() {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT tbl_items.item_name,tbl_items.item_ID,tbl_expenses.expense_qty,
        tbl_expenses.expense_price,tbl_expenses.expense_ID,tbl_expenses.expense_itemID,tbl_expenses.expense_receiptNo,
        tbl_expenses.expense_supplier,tbl_expenses.expense_expirationDate,tbl_expenses.expense_date,tbl_expenses.expense_qtyLeft,tbl_category.category_name 
        FROM tbl_expenses
        LEFT JOIN tbl_items ON tbl_items.item_ID = tbl_expenses.expense_itemID
        LEFT JOIN tbl_category ON tbl_category.category_ID = tbl_items.item_categoryID 
        GROUP BY item_name");
        $stmt->execute();
        $datas = $stmt->fetchAll();
        $total = $stmt->rowCount();
        if($total > 0) {
            return $datas;
        } else {
            return null;
        }
        $this->closeConnection();
    }

    //Read
    public function readLowStocks() {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT tbl_items.item_name,tbl_items.item_ID,tbl_expenses.expense_qty,
        tbl_expenses.expense_price,tbl_expenses.expense_ID,tbl_expenses.expense_itemID,tbl_expenses.expense_receiptNo,
        tbl_expenses.expense_supplier,tbl_expenses.expense_expirationDate,tbl_expenses.expense_date,tbl_expenses.expense_qtyLeft,tbl_category.category_name 
        FROM tbl_expenses
        LEFT JOIN tbl_items ON tbl_items.item_ID = tbl_expenses.expense_itemID
        LEFT JOIN tbl_category ON tbl_category.category_ID = tbl_items.item_categoryID
        WHERE expense_qtyLeft <= 10
        GROUP BY item_name");
        $stmt->execute();
        $datas = $stmt->fetchAll();
        $total = $stmt->rowCount();
        if($total > 0) {
            return $datas;
        } else {
            return null;
        }
        $this->closeConnection();
    }

    public function readQtyLeft($itemID) {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT expense_qtyLeft,expense_price FROM tbl_expenses WHERE expense_itemID = ? AND expense_isDelete = ?");
        $stmt->execute([$itemID,0]);
        $datas = $stmt->fetchAll();
        $total = $stmt->rowCount();
        if($total > 0) {
            return $datas;
        } else {
            return null;
        }
        $this->closeConnection();
    }

    //Read
    public function readItemDetails($itemID) {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT tbl_items.item_name,tbl_items.item_ID,
        tbl_expenses.expense_price,tbl_expenses.expense_ID,tbl_expenses.expense_itemID,expense_qtyLeft,
        tbl_expenses.expense_supplier,tbl_expenses.expense_expirationDate,tbl_expenses.expense_date 
        FROM tbl_expenses
        LEFT JOIN tbl_items ON tbl_items.item_ID = tbl_expenses.expense_itemID
        WHERE expense_itemID = ? AND expense_qtyLeft != ?");
        $stmt->execute([$itemID,0]);
        $datas = $stmt->fetchAll();
        $total = $stmt->rowCount();
        if($total > 0) {
            return $datas;
        } else {
            return null;
        }
        $this->closeConnection();
    }

    //Read
    public function readItemExpenses($expenseID) {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT tbl_items.item_name,tbl_items.item_ID,
        tbl_expenses.expense_price,tbl_expenses.expense_ID,tbl_expenses.expense_itemID,expense_qtyLeft,expense_receiptNo,
        tbl_expenses.expense_supplier,tbl_expenses.expense_expirationDate,tbl_expenses.expense_date 
        FROM tbl_expenses
        LEFT JOIN tbl_items ON tbl_items.item_ID = tbl_expenses.expense_itemID
        WHERE expense_ID = ?");
        $stmt->execute([$expenseID]);
        $datas = $stmt->fetch();
        $total = $stmt->rowCount();
        if($total > 0) {
            return $datas;
        } else {
            return null;
        }
        $this->closeConnection();
    }

    //Read
    public function readOrders($id) {
        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT tbl_items.item_name,tbl_items.item_ID,tbl_orders.order_qty,tbl_orders.order_price,tbl_orders.order_ID,tbl_orders.order_itemID  
        FROM tbl_orders 
        LEFT JOIN tbl_items ON tbl_items.item_ID = tbl_orders.order_itemID
        WHERE order_userID = ?");
        $stmt->execute([$id]);
        $datas = $stmt->fetchAll();
        $total = $stmt->rowCount();
        if($total > 0) {
            return $datas;
        } else {
            return null;
        }
        $this->closeConnection();
    }

    //update
    public function updateInventory($id) {
        if (isset($_POST['update-item'])) {
            $qty = $_POST['qty'];
            $price = $_POST['price'];
            $connection = $this->openConnection();
            $stmt = $connection->prepare("UPDATE tbl_expenses SET expense_qtyLeft = ?, expense_price = ? WHERE expense_ID = ?");
            $stmt->execute([$qty,$price,$id]);
            echo '<script>window.location.assign("inventory-item-update.php?update-success&id='.$id.'")</script>';
            $this->closeConnection();
            
        }
        
    }

    //Delete
    public function deleteOrder() {
        if (isset($_POST['delete-order'])) {
            $id = $_POST['delete-order'];
            $connection = $this->openConnection();
            $stmt = $connection->prepare("DELETE FROM tbl_orders WHERE order_ID = ?");
            $stmt->execute([$id]);
            $this->closeConnection();
        }
    }

}
$orderClass = new Orders();
?>