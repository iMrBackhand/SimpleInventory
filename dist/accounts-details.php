<?php
include_once ('controller/controller-accounts.php');
include_once ('controller/controller-user-cookies.php');
$datas = $accountClass->readUserAccount($_GET['id']);
$userdetails = $userInfoClass->get_userdata();
if (!isset($userdetails)) {
    echo '<script>window.location.assign("login.php?login-first")</script>';
}
$accountClass->updateAccount($datas['users_ID'],$datas['users_password'],$datas['users_email'],$userdetails['access']);
$accountClass->resetPassword($datas['users_ID']); 

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Update Account - IMS</title>
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
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Update Account</h3></div>
                                    <div class="card-body">

                                        <?php if (isset($_GET['password-not-correct'])) { ?>
                                            <div class="text-center text-danger mb-2">
                                                Password not correct. Please try again.
                                            </div>
                                        <?php } elseif (isset($_GET['email-exists'])) { ?>
                                            <div class="text-center text-danger mb-2">
                                                Email exists. Please use another email.
                                            </div>
                                        <?php } elseif (isset($_GET['update-success'])) { ?>
                                            <div class="text-center text-success mb-2">
                                                Update Account Successfully.
                                            </div>
                                        <?php } elseif (isset($_GET['reset-password'])) { ?>
                                            <div class="text-center text-success mb-2">
                                                Reset Password Successfully.
                                            </div>
                                        <?php } ?>

                                        <form action="" method="POST">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="text" placeholder="Name" name="name" value="<?= $datas['users_name']; ?>"  required/>
                                                <label for="inputEmail">Full Name</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com" name="email" value="<?= $datas['users_email']; ?>" required/>
                                                <label for="inputEmail">Email address</label>
                                            </div>

                                            <?php if ($userdetails['access'] == 1) { ?>
                                                <div class="form-floating mb-3">
                                                    <select id="selectAccess" class="form-control" name="access" id="" required>
                                                    <?php if ($datas['users_isAdmin'] == 0) { ?>
                                                        <option value="0">USER</option>
                                                        <option value="1">ADMIN</option>
                                                    <?php } elseif ($datas['users_isAdmin'] == 1) { ?>
                                                        <option value="1">ADMIN</option>
                                                        <option value="0">USER</option>
                                                    <?php } ?>
                                                    </select>
                                                    <label for="selectAccess">Access</label>
                                                </div>
                                            <?php } else { ?>
                                                <input type="hidden" name="access" value="<?= $datas['users_isAdmin']; ?>">
                                            <?php } ?>

                                            <?php if ($userdetails['access'] == 0) { ?>
                                                <hr>
                                                <div class="form-floating mb-3">
                                                    <input class="form-control" id="inputPassword" type="password" placeholder="Create a password" name="password" required/>
                                                            <label for="inputPassword">Enter Password</label>
                                                </div>
                                            <?php } ?>
                                            
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><button type="submit" class="btn btn-primary btn-block" name="update-account">Update Account</button></div>
                                            </div>
                                        </form>
                                        <hr>
                                        <form action="" method="post">
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><button type="submit" value="<?= $datas['users_ID']; ?>" class="btn btn-warning btn-block" name="reset-password">Reset Password</button></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <?php if (isset($_GET['accounts-table'])) { ?>
                                            <div class="small"><a href="accounts-table.php">Go back to Accounts.</a></div>
                                        <?php } elseif (isset($_GET['dashboard'])) { ?>
                                            <div class="small"><a href="dashboard.php">Go back to Dashboard.</a></div>
                                        <?php } ?>
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
