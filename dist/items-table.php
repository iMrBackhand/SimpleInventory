<?php 
include_once ('navbar.php');
include_once ('controller/controller-items.php'); 
$itemClass->deleteItem();
?>
<title>Items - IMS</title>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Items</h1>
            <?php if (isset($_GET['successfully-deleted'])) { ?>
                <div class="text-success">
                    <p>Item Successfully Deleted.</p>
                </div>
            <?php } ?>
            
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Items</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    List of Items &nbsp
                    <a class="btn btn-primary p-1" href="items-create.php">Add more</a>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Tags</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $datas = $itemClass->readItems(); ?>
                            <?php if (!empty($datas)) { ?>
                                <?php foreach ($datas as $data) { ?>
                                    <tr>
                                        <td><?= 'ITEMID'.$data['item_ID']; ?></td>
                                        <td><?= $data['item_name']; ?></td>
                                        <td><?= $data['item_tags']; ?></td>
                                        <td>
                                            <form action="" method="post">
                                                <a class="btn btn-success" href="items-shop.php?id=<?= $data['item_ID']; ?>">Order</a>
                                                <a class="btn btn-warning" href="items-details.php?id=<?= $data['item_ID']; ?>">Update</a>
                                                <?php if ($userdetails['access'] == 1) { ?>
                                                    <button class="btn btn-danger" type="submit" name="delete-item" value="<?= $data['item_ID']; ?>">Delete</button>
                                                <?php } ?>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Tags</th>
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