<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> WPS SITE </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url(); ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>/dist/css/adminlte.min.css">
    <!-- jQuery -->
    <script src="<?= base_url(); ?>/plugins/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="<?= base_url(); ?>/plugins/sweetalert2/sweetalert2.min.css">
    <script src="<?= base_url(); ?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>
</head>


<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <div class="col-mb-5">
                    <h1 class="m-2">
                        <?= $this->rendersection('judul'); ?>
                    </h1>
                </div>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->

                <!-- Messages Dropdown Menu -->

                <!-- Notifications Dropdown Menu -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url(); ?>/index3.html" class="brand-link">
                <img src="<?= base_url(); ?>/dist/img/Wps.png" alt="WPS LOGO" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">E-PROCUREMENT</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url(); ?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= session()->namauser; ?></a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <?php if (session()->idlevel == 1) : ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <p>
                                    Master
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= site_url("kategori/index"); ?>" class="nav-link">
                                        <i class="nav-icon fa fa-tasks text-white"></i>
                                        <p>Kategori</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class=" nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= site_url("satuan/index"); ?>" class="nav-link">
                                        <i class="nav-icon fa fa-angle-double-right text-white"></i>
                                        <p>Satuan</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class=" nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= site_url("barang/index"); ?>" class="nav-link">
                                        <i class="nav-icon fa fa-box text-white"></i>
                                        <p>Barang</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= site_url("kategori/index"); ?>" class="nav-link">
                                        <i class="nav-icon fa fa-users"></i>
                                        <p>Supplier</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class=" nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= site_url("costumer/index"); ?>" class="nav-link">
                                        <i class="nav-icon fa fa-user text-white"></i>
                                        <p>Costumer</p>
                                    </a>
                                </li>
                            </ul>

                        <li class="nav-header">Transaksi</li>
                        <li class="nav-item">
                            <a href="<?= site_url("barangmasuk/data"); ?>" class="nav-link">
                                <i class="nav-icon fa fa-arrow-alt-circle-down text-white"></i>
                                <p class="text">Barang Masuk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url("barangkeluar/data"); ?>" class="nav-link">
                                <i class="nav-icon fa fa-arrow-alt-circle-up text-white"></i>
                                <p class="text">Barang Keluar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url(""); ?>" class="nav-link">
                                <i class="nav-icon fa fa-file-alt text-white"></i>
                                <p class="text">Laporan</p>
                            </a>
                        </li>
                        <li class="nav-item">

                            <a href="<?= site_url("po/index"); ?>" class="nav-link">
                                <i class=" nav-icon fa fa-tasks text-white"></i>
                                <p class="text">Purchasing Order</p>
                            </a>
                        </li>

                        <li class="nav-header">Utility</li>
                        <li class="nav-item">
                            <a href="<?= site_url('users/index'); ?>" class="nav-link">
                                <i class="nav-icon fa fa-users "></i>
                                <p class="text">Management User</p>
                            </a>
                        </li>


                        <?php endif; ?>

                        <?php if (session()->idlevel == 2) : ?>
                        <li class="nav-header">Transaksi</li>
                        <li class="nav-item">
                            <a href="<?= site_url("barangmasuk/data"); ?>" class="nav-link">
                                <i class="nav-icon fa fa-arrow-alt-circle-down text-white"></i>
                                <p class="text">Barang Masuk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url("barangkeluar/data"); ?>" class="nav-link">
                                <i class="nav-icon fa fa-arrow-alt-circle-up text-white"></i>
                                <p class="text">Barang Keluar</p>
                            </a>
                        </li>
                        <li class="nav-header">Laporan</li>
                        <li class="nav-item">
                            <a href="<?= site_url(""); ?>" class="nav-link">
                                <i class="nav-icon fa fa-file-alt text-white"></i>
                                <p class="text">Laporan</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (session()->idlevel == 3) : ?>
                        <li class="nav-header">Master</li>
                        <li class="nav-item">
                            <a href="<?= site_url("kategori/index"); ?>" class="nav-link">
                                <i class="nav-icon fa fa-tasks text-primary"></i>
                                <p class="text">Kategori</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url("satuan/index"); ?>" class="nav-link">
                                <i class="nav-icon fa fa-angle-double-right text-warning"></i>
                                <p class="text">Satuan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url("barang/index"); ?>" class="nav-link">
                                <i class="nav-icon fa fa-box text-maroon"></i>
                                <p class="text">Barang</p>
                            </a>
                        </li>
                        <li class="nav-header">Transaksi</li>
                        <li class="nav-item">
                            <a href="<?= site_url("barangmasuk/data"); ?>" class="nav-link">
                                <i class="nav-icon fa fa-arrow-alt-circle-down text-blue"></i>
                                <p class="text">Barang Masuk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url("barangkeluar/data"); ?>" class="nav-link">
                                <i class="nav-icon fa fa-arrow-alt-circle-up text-warning"></i>
                                <p class="text">Barang Keluar</p>
                            </a>
                        </li>
                        <li class="nav-header">Laporan</li>
                        <li class="nav-item">
                            <a href="<?= site_url(""); ?>" class="nav-link">
                                <i class="nav-icon fa fa-file-alt text-cyan"></i>
                                <p class="text">Laporan</p>
                            </a>
                        </li>
                        <?php endif; ?>


                        <?php if (session()->idlevel == 4) : ?>
                        <li class="nav-header">Transaksi</li>
                        <li class="nav-item">
                            <a href="<?= site_url("barangmasuk/data"); ?>" class="nav-link">
                                <i class="nav-icon fa fa-arrow-alt-circle-down text-blue"></i>
                                <p class="text">Barang Masuk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url("barangkeluar/data"); ?>" class="nav-link">
                                <i class="nav-icon fa fa-arrow-alt-circle-up text-warning"></i>
                                <p class="text">Barang Keluar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url(""); ?>" class="nav-link">
                                <i class="nav-icon fa fa-file"></i>
                                <p class="text">Laporan</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a href="<?= site_url("login/keluar"); ?>" class="nav-link">
                                <i class="nav-icon fa fa-sign-out-alt text-white"></i>
                                <p class="text">Logout</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('users/index'); ?>" class="nav-link">
                                <i class="nav-icon fa fa-users "></i>
                                <p class="text">Management User</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">


            <div class="content-header">
                <div class="container-fluid">
                    <div class="row sm-1">
                        <div class="col-sm-3">
                        </div>
                        <div class="col-sm-1">
                            <!-- <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v1</li>
                            </ol> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <?= $this->rendersection('subjudul'); ?>
                        </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?= $this->rendersection('isi'); ?>
                    </div>
                    <!-- /.card-body -->

                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-middle">
            </div>
            <strong>Harun &copy; 2022
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- Bootstrap 4 -->
    <script src="<?= base_url(); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url(); ?>/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?= base_url(); ?>/dist/js/demo.js"></script>
</body>

</html>