<?php 
include_once ('navbar.php');
include_once ('controller/controller-orders.php'); 
?>
<title>Inventory Details - IMS</title>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Inventory Details</h1>
            <?php if (isset($_GET['successfully-deleted'])) { ?>
                <div class="text-success">
                    <p>Inventory Successfully Deleted.</p>
                </div>
            <?php } ?>
            
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="inventory-table.php">Inventory</a></li>
                <li class="breadcrumb-item active"><?= $_GET['name']; ?></li>

            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    List of Inventory &nbsp
                    <a class="btn btn-primary p-1" href="items-table.php">Add more</a>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Date Ordered</th>
                                <th>Item ID</th>
                                <th>Item Name</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total Price</th>
                                <th>Expiration Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $datas = $orderClass->readItemDetails($_GET['id']); ?>
                            <?php $totalPrice = 0; ?>
                            <?php if (!empty($datas)) { ?>
                                <?php foreach ($datas as $data) { ?>
                                    <tr>
                                        <td><?= date('F d, Y', strtotime($data['expense_date'])); ?></td>
                                        <td><?= 'ITEMID'.$data['expense_itemID']; ?></td>
                                        <td><?= $data['item_name']; ?></td>
                                        <?php $datas = $orderClass->readQtyLeft($data['expense_itemID']); ?>
                                        <td><b><?= number_format($data['expense_qtyLeft']); ?></b></td>
                                        <td><?= number_format($data['expense_price'],2); ?></td>
                                        <?php $totalPrice = $data['expense_price'] * $data['expense_qtyLeft']; ?>
                                        <td><?= number_format($totalPrice,2); ?></td>
                                        <td><?= date('F d, Y', strtotime($data['expense_expirationDate'])); ?></td>
                                        <td><a class="btn btn-warning" href="inventory-item-update.php?id=<?= $data['expense_ID']; ?>">Update</a></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

<?php include_once ('footer.php'); ?>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>