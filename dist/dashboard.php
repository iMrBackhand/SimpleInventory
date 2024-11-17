<?php 
include_once ('navbar.php'); 
include_once ('controller/controller-dashboard.php'); 
?>

<title>Dashboard - IMS</title>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">Total Users: <b><?= $dashboardClass->countUsers(); ?></b></div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <?php if ($userdetails['access'] == 1) { ?>
                                <a class="small text-white stretched-link" href="accounts-table.php">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            <?php } else { ?>
                                <div class="small text-white">&nbsp</div>
                            <?php } ?>
                            
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">Total Pending Orders: <b><?= $dashboardClass->countOrders($userdetails['id']); ?></b></div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="orders.php">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Total Inventory Value: <b><?= number_format($dashboardClass->totalInventoryValue(),2); ?></b></div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="inventory-table.php">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">Low Stocks: <b> <?= $dashboardClass->totalLowStocks(); ?></b></div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="inventory-table.php?low-stocks">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    List of product will expire this month
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Qty</th>
                                <th>Expiration Date</th>
                                <th>Days Left</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Item Name</th>
                                <th>Qty</th>
                                <th>Expiration Date</th>
                                <th>Days Left</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $datas = $dashboardClass->readItemDetails(); ?>
                            <?php if (!empty($datas)) { ?>
                                <?php foreach ($datas as $data) { ?>
                                    <tr>
                                        <td><?= $data['item_name']; ?></td>
                                        <td><b><?= $data['expense_qtyLeft']; ?></b></td>
                                        <td><?= date('F d, Y', strtotime($data['expense_expirationDate'])); ?></td>
                                        <?php
                                            $datetime1 = strtotime($data['expense_expirationDate']);
                                            $datenow = date('Y-m-d');
                                            $datetime2 = strtotime($datenow);
                                            
                                            $secs = $datetime1 - $datetime2;// == <seconds between the two times>
                                            $days = $secs / 86400;
                                        ?>
                                        <td><b><?= $days; ?></b></td>
                                        <td>
                                            <a class="btn btn-warning" href="inventory-item-update.php?id=<?= $data['expense_ID']; ?>">Update</a>
                                        </td>
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