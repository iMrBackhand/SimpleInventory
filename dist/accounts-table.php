<?php 
include_once ('controller/controller-accounts.php'); 
$accountClass->deleteAccount();
include_once ('navbar.php');

if ($userdetails['access'] == 0) {
    echo '<script>window.location.assign("404.php")</script>';
}

?>
<title>Accounts - IMS</title>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Accounts</h1>
            <?php if (isset($_GET['successfully-deleted'])) { ?>
                <div class="text-success">
                    <p>Account Successfully Deleted.</p>
                </div>
            <?php } ?>
            
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Accounts</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    List of Accounts
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Access</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Access</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $datas = $accountClass->readAccounts(); ?>
                            <?php if (!empty($datas)) { ?>
                                <?php foreach ($datas as $data) { ?>
                                    <tr>
                                        <td><?= 'USERID'.$data['users_ID']; ?></td>
                                        <td><?= $data['users_name']; ?></td>
                                        <td><?= $data['users_email']; ?></td>
                                        <td>
                                            <?php if ($data['users_isAdmin'] == 0) { ?>
                                                USER
                                            <?php } elseif ($data['users_isAdmin'] == 1) { ?>
                                                ADMIN
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <form action="" method="post">
                                                <a class="btn btn-warning" href="accounts-details.php?accounts-table&id=<?= $data['users_ID']; ?>">Update</a>
                                                <button class="btn btn-danger" type="submit" name="delete-account" value="<?= $data['users_ID']; ?>">Delete</button>
                                            </form>
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