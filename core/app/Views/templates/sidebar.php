<aside class="main-sidebar sidebar-dark-primary bg-navy elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url(); ?>" class="brand-link">
        <img src="<?= base_url(); ?>/logo-t2net-hd-putih.png" width="60%"><br />
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url(); ?>img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">

            </div>
            <div class="info">
                <a href="#" class="d-block"><?= user()->username; ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control bg-navy form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="bg-navy btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?= base_url(); ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url(); ?>reset" class="nav-link">
                        <i class="nav-icon fas fa-key"></i>
                        <p>
                            Ubah Password
                        </p>
                    </a>
                </li>
                <?php if (in_groups('superuser')) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url(); ?>mitra" class="nav-link">
                            <i class="nav-icon fas fa-handshake"></i>
                            <p>
                                Data Mitra
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url(); ?>pelanggan" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Data Pelanggan
                            </p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (in_groups('mitra')) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url(); ?>pelangganmitra" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Data Pelanggan Mitra
                            </p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ((in_groups('superuser'))) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url(); ?>users" class="nav-link">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>
                                Data Akun
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url(); ?>log" class="nav-link">
                            <i class="nav-icon fas fa-history"></i>
                            <p>
                                Log Data
                            </p>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a data-toggle="modal" data-target="#modal-logout" href="#" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Keluar
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<div class="modal fade" id="modal-logout">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Keluar Aplikasi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah anda yakin akan keluar?&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <a href="<?= base_url(); ?>logout" class="btn btn-primary">Keluar</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->