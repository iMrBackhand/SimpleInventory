<?php 
include_once ('navbar.php');
include_once ('controller/controller-orders.php'); 
?>
<title>Inventory - IMS</title>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Inventory</h1>
            <?php if (isset($_GET['successfully-deleted'])) { ?>
                <div class="text-success">
                    <p>Inventory Successfully Deleted.</p>
                </div>
            <?php } ?>
            
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Inventory</li>
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
                                <th>Item ID</th>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Qty</th>
                                <th>Total Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($_GET['low-stocks'])) { ?>
                                <?php $datas = $orderClass->readLowStocks(); ?>
                            <?php } else { ?> 
                                <?php $datas = $orderClass->readInventory(); ?>
                            <?php } ?>
                            
                            <?php if (!empty($datas)) { ?>
                                <?php foreach ($datas as $data) { ?>
                                    <tr>
                                        <td><?= 'ITEMID'.$data['expense_itemID']; ?></td>
                                        <td><?= $data['item_name']; ?></td>
                                        <td><?= $data['category_name']; ?></td>
                                        <?php $qtys = $orderClass->readQtyLeft($data['expense_itemID']); ?>
                                        <?php $totalQty = 0; ?>
                                        <?php $totalValue = 0; ?>
                                        <?php foreach ($qtys as $qty) { ?>
                                            <?php $totalQty += $qty['expense_qtyLeft']; ?>
                                            <?php $totalValue += $qty['expense_qtyLeft'] * $qty['expense_price']; ?>
                                        <?php } ?>

                                        <?php if ($totalQty <= 10) { ?>
                                            <td><b><p class="text-danger"><?= number_format($totalQty); ?></p></b></td>
                                        <?php } else { ?>
                                            <td><b><?= number_format($totalQty); ?></b></td>
                                        <?php } ?>
                                        <td><?= number_format($totalValue,2); ?></td>
                                        
                                        <td><a class="btn btn-success" href="inventory-item-details.php?id=<?= $data['expense_itemID']; ?>&name=<?= $data['item_name']; ?>">View</a></td>
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