<!DOCTYPE html>
<html>
 
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="<?= base_url(); ?>/favicon.ico">
    <title><?= $title; ?> <?=$setting->nama_rs?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/adminlte.min.css">
    <style>
    .login-box {margin-top: -200px;}
    </style>
</head>

<body class="hold-transition login-page" style="background: url('<?=base_url(''.$setting->site_background)?>') no-repeat center center;background-size: cover; ">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?= base_url('login'); ?>" class="h3">
                <span class="text-light font-weight-bold"><?=$setting->nama_rs?></span>
                <p class="text-sm text-light">
                    <?=$setting->site_title?>
                </p>
            </a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <?= $this->session->flashdata('msg'); ?>
                <p class="login-box-msg">Login untuk menggunakan aplikasi</p>
                <?= form_open(); ?>
                <div class="form-group">
                    <div class="input-group">
                        <input autofocus onfocus="this.select()" type="text" id="username" name="username" class="form-control" value="<?= set_value('username'); ?>" placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <?= form_error('username'); ?>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <?= form_error('password'); ?>
                </div>
                <button type="submit" class="btn btn-info bg-gradient-info btn-block">Login</button>
                <?= form_close(); ?>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url(); ?>assets/dist/js/adminlte.min.js"></script>

</body>

</html>