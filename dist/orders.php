<?php
include_once ('controller/controller-user-cookies.php');
$userdetails = $userInfoClass->get_userdata();
if (!isset($userdetails)) {
    echo '<script>window.location.assign("login.php?login-first")</script>';
}
include_once ('controller/controller-orders.php');
$orderClass->deleteOrder();
$orderClass->createExpenses();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Orders - IMS</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-dark">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xlg">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Orders</h3></div>
                                    <div class="card-body">

                                        <?php if (isset($_GET['no-orders'])) { ?>
                                            <div class="text-center text-danger mb-2">
                                                No Orders Found.
                                            </div>
                                        <?php } ?>

                                        <form action="" method="post">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputSupplier" type="text" placeholder="Supplier" name="supplier" required/>
                                                        <label for="inputSupplier">Supplier</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputReceiptNo" type="text" placeholder="Receipt No." name="receipt-no" required/>
                                                        <label for="inputReceiptNo">Receipt No.</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-4">
                                                <div class="card-header">
                                                    <i class="fas fa-table me-1"></i>
                                                    List of Orders
                                                </div>
                                                <div class="card-body">
                                                    <table id="datatablesSimple">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Name</th>
                                                                <th>Expiration Date</th>
                                                                <th>Variation</th>
                                                                <th>Total</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $datas = $orderClass->readOrders($userdetails['id']); ?>
                                                            <?php $totalValue= 0; ?>
                                                            <?php if (!empty($datas)) { ?>
                                                                <?php foreach ($datas as $data) { ?>
                                                                    <tr>
                                                                        <td><?= 'ITEMID'.$data['item_ID']; ?></td>
                                                                        <td><?= $data['item_name']; ?></td>
                                                                        <td>
                                                                            <div class="form-floating mb-3 mb-md-0">
                                                                                <input class="form-control" id="inputExpirationDate" type="date" placeholder="Expiration Date" name="exp-date[]" required/>
                                                                                <input type="hidden" name="itemID[]" value="<?= $data['order_itemID']; ?>">
                                                                                <input type="hidden" name="orderID[]" value="<?= $data['order_ID']; ?>">
                                                                                <label for="inputExpirationDate">Expiration Date</label>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="row mb-1">
                                                                                <div class="col-md-3 w-50">
                                                                                    <div class="form-floating mb-3 mb-md-0">
                                                                                        <input class="form-control" id="inputQty" type="number" placeholder="Qty" name="qty[]" value="<?= $data['order_qty']; ?>" min="1" required/>
                                                                                        <label for="inputQty">Qty</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3 w-50">
                                                                                    <div class="form-floating mb-3 mb-md-0">
                                                                                        <input class="form-control" id="inputPrice" type="number" placeholder="Price" name="price[]" step="any" value="<?= $data['order_price']; ?>" min="1" required/>
                                                                                        <label for="inputPrice">Price</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <?php $total = $data['order_qty'] * $data['order_price']; ?>
                                                                        <?php $totalValue += $total; ?>
                                                                        <td><?= number_format($total,2); ?></td>
                                                                        <td><button class="btn btn-danger" type="submit" name="delete-order" value="<?= $data['order_ID']; ?>">REMOVE</button></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputTotal" type="text" placeholder="Total" name="total" value="<?= number_format($totalValue,2); ?>" readonly/>
                                                        <label for="inputTotal">Total</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                        <div class="d-grid"><button type="submit" class="btn btn-primary btn-block" name="create-expense">Add Expenses</button></div>
                                                </div>
                                            </div>
                                            
                                            
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="items-table.php"> Order more Items.</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-secondary mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-light">Copyright &copy; Inventory Management System 2023</div>
                            <div>
                                <a class="text-light" href="#">Privacy Policy</a>
                                &middot;
                                <a class="text-light" href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
