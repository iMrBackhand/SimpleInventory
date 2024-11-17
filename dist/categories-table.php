<?php 
include_once ('navbar.php');
include_once ('controller/controller-categories.php'); 
$categoryClass->deleteCategory();

?>
<title>Categories - IMS</title>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Categories</h1>
            <?php if (isset($_GET['successfully-deleted'])) { ?>
                <div class="text-success">
                    <p>Category Successfully Deleted.</p>
                </div>
            <?php } ?>
            
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Categories</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    List of Categories &nbsp
                    <a class="btn btn-primary p-1" href="categories-create.php">Add more</a>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $datas = $categoryClass->readCategories(); ?>
                            <?php if (!empty($datas)) { ?>
                                <?php foreach ($datas as $data) { ?>
                                    <tr>
                                        <td><?= 'CATID'.$data['category_ID']; ?></td>
                                        <td><?= $data['category_name']; ?></td>
                                        <td><?= $data['category_desc']; ?></td>
                                        <td>
                                            <form action="" method="post">
                                                <a class="btn btn-warning" href="categories-details.php?id=<?= $data['category_ID']; ?>">Update</a>
                                                <?php if ($userdetails['access'] == 1) { ?>
                                                    <button class="btn btn-danger" type="submit" name="delete-category" value="<?= $data['category_ID']; ?>">Delete</button>
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