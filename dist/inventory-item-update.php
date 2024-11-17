<?php
include_once ('controller/controller-orders.php');
include_once ('controller/controller-user-cookies.php');
$userdetails = $userInfoClass->get_userdata();
if (!isset($userdetails)) {
    echo '<script>window.location.assign("login.php?login-first")</script>';
}
$datas = $orderClass->readItemExpenses($_GET['id']);
$userdetails = $userInfoClass->get_userdata();
$orderClass->updateInventory($_GET['id']);
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Update Items - IMS</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-dark">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Update Items</h3></div>
                                    <div class="card-body">

                                        <?php if (isset($_GET['update-success'])) { ?>
                                            <div class="text-center text-success mb-2">
                                                Update Successfully.
                                            </div>
                                        <?php } ?>

                                        <form action="" method="POST">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputSupplier" type="text" placeholder="Supplier" name="supplier" value="<?= $datas['expense_supplier']; ?>" readonly/>
                                                <label for="inputSupplier">Supplier</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputReceiptNo" type="text" placeholder="Receipt No." name="receipt-no" value="<?= $datas['expense_receiptNo']; ?>" readonly/>
                                                <label for="inputReceiptNo">Receipt No.</label>
                                            </div>
                                            <hr>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputName" type="text" placeholder="Name" name="name" value="<?= $datas['item_name']; ?>" readonly/>
                                                <label for="inputName">Name</label>
                                            </div>
                                            <hr>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputDate" type="text" placeholder="Date" name="date" value="<?= date('F d, Y', strtotime($datas['expense_date'])); ?>" readonly/>
                                                        <label for="inputDate">Date</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputExpirationDate" type="text" placeholder="Expiration Date" name="exp-date" value="<?= date('F d, Y', strtotime($datas['expense_expirationDate'])); ?>" readonly/>
                                                        <label for="inputExpirationDate">Expiration Date</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputQty" type="number" placeholder="Qty" name="qty" value="<?= $datas['expense_qtyLeft']; ?>" min="0"/>
                                                        <label for="inputQty">Qty</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPrice" type="number" placeholder="Price" name="price" step="any" value="<?= $datas['expense_price']; ?>" min="0"/>
                                                        <label for="inputPrice">Price</label>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><button type="submit" class="btn btn-primary btn-block" name="update-item">Update item</button></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="inventory-item-details.php?id=<?= $datas['expense_itemID']; ?>&name=<?= $datas['item_name']; ?>">Go back to Inventory.</a></div>
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
    </body>
</html>
