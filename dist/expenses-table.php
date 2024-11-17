<?php 
include_once ('navbar.php');
include_once ('controller/controller-orders.php'); 
?>
<title>Expenses - IMS</title>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Expenses</h1>
            <?php if (isset($_GET['successfully-deleted'])) { ?>
                <div class="text-success">
                    <p>Expenses Successfully Deleted.</p>
                </div>
            <?php } ?>
            
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Expenses</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    List of Expenses &nbsp
                    <a class="btn btn-primary p-1" href="items-table.php">Add more</a>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Receipt No</th>
                                <th>Supplier</th>
                                <th>Item Name</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Expiration Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $datas = $orderClass->readExpenses(); ?>
                            <?php if (!empty($datas)) { ?>
                                <?php foreach ($datas as $data) { ?>
                                    <tr>
                                        <td><?= date('F d, Y', strtotime($data['expense_date'])); ?></td>
                                        <td><?= $data['expense_receiptNo']; ?></td>
                                        <td><?= $data['expense_supplier']; ?></td>
                                        <td><?= $data['item_name']; ?></td>
                                        <td><?= number_format($data['expense_qty']); ?></td>
                                        <td><?= number_format($data['expense_price'],2); ?></td>
                                        <?php $total = $data['expense_qty'] * $data['expense_price']; ?>
                                        <td><?= number_format($total,2); ?></td>
                                        <td><?= date('F d, Y', strtotime($data['expense_expirationDate'])); ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th></th>
                            </tr>
                        </tfoot>
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