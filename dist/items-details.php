<?php
include_once ('controller/controller-items.php');
include_once ('controller/controller-categories.php');
include_once ('controller/controller-user-cookies.php');
$userdetails = $userInfoClass->get_userdata();
if (!isset($userdetails)) {
    echo '<script>window.location.assign("login.php?login-first")</script>';
}
$datas = $itemClass->readThisItem($_GET['id']);
$userdetails = $userInfoClass->get_userdata();
$itemClass->updateItem($datas['item_ID'],$datas['item_name']);
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

                                        <?php if (isset($_GET['name-exists'])) { ?>
                                            <div class="text-center text-danger mb-2">
                                                Name already taken.
                                            </div>
                                        <?php } elseif (isset($_GET['update-success'])) { ?>
                                            <div class="text-center text-success mb-2">
                                                Update Category Successfully.
                                            </div>
                                        <?php } ?>

                                        <form action="" method="POST">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputName" type="text" placeholder="Name" name="name" value="<?= $datas['item_name']; ?>" required/>
                                                <label for="inputName">Name</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Tags" rows="5" name="tags"><?= $datas['item_tags']; ?></textarea>
                                                <label for="exampleFormControlTextarea1" class="form-label">Tags</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <select id="selectCategory" class="form-control" name="category" id="" required>
                                                    <option value="<?= $datas['category_ID']; ?>"><?= $datas['category_name']; ?></option>
                                                    <?php $datas = $categoryClass->readCategories(); ?>
                                                    <?php if (!empty($datas)) { ?>
                                                        <?php foreach ($datas as $data) { ?>
                                                            <option value="<?= $data['category_ID']; ?>"><?= $data['category_name']; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                                <label for="selectCategory">Category</label>
                                            </div>
                                            
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><button type="submit" class="btn btn-primary btn-block" name="update-item">Update Item</button></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="items-table.php">Go back to Items.</a></div>
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
