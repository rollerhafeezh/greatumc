<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title><?= $title ?> | <?= $_ENV['MAIN_USER'] ?> <?= $_ENV['MAIN_TAG'] ?></title>

    <!-- STYLESHEETS -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--- -->
	<link rel="apple-touch-icon" href="<?=$_ENV['LOGO_100']?>" sizes="180x180">
	<link rel="icon" href="<?=$_ENV['LOGO_100']?>" sizes="32x32" type="image/png">
	<link rel="icon" href="<?=$_ENV['LOGO_100']?>" sizes="16x16" type="image/png">
	<link rel="mask-icon" href="<?=$_ENV['LOGO_100']?>" color="#fe0000">
	<link rel="icon" href="<?=$_ENV['LOGO_100']?>">
	<meta name="theme-color" content="#d43c2c">
	
    <!-- Fonts [ OPTIONAL ] -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS [ REQUIRED ] -->
    <link rel="stylesheet" href="<?=$_ENV['THM_LINK']?>css/bootstrap.min.css">

    <!-- Nifty CSS [ REQUIRED ] -->
    <link rel="stylesheet" href="<?=$_ENV['THM_LINK']?>css/nifty.min.css">
	
	<!-- Premium icons [ OPTIONAL ] -->
    <link rel="stylesheet" href="<?= $_ENV['THM_LINK'] ?>premium/icon-sets/icons/line-icons/premium-line-icons.min.css">
    <link rel="stylesheet" href="<?= $_ENV['THM_LINK'] ?>premium/icon-sets/icons/solid-icons/premium-solid-icons.min.css">

    <!-- Color Scheme -->
    <link rel="stylesheet" href="<?= $_ENV['THM_LINK'] ?>css/color-schemes/all-headers/umc/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $_ENV['THM_LINK'] ?>css/color-schemes/all-headers/umc/nifty.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Bootstrap 5 tags [ OPTIONAL ] -->
    <link rel="stylesheet" href="<?=$_ENV['THM_LINK']?>/vendors/bootstrap5-tags/bootstrap5-tags.min.css">
    <style type="text/css">
        .badge {
            text-decoration: none !important;
            color: white !important;
        }
    </style>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~---

    [ REQUIRED ]
    You must include this category in your project.


    [ OPTIONAL ]
    This is an optional plugin. You may choose to include it in your project.


    [ DEMO ]
    Used for demonstration purposes only. This category should NOT be included in your project.


    [ SAMPLE ]
    Here's a sample script that explains how to initialize plugins and/or components: This category should NOT be included in your project.


    Detailed information and more samples can be found in the documentation.

    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--- -->
</head>
<body class="jumping">

    <!-- PAGE CONTAINER -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div id="root" class="root mn--max hd--expanded">

        <!-- CONTENTS -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <section id="content" class="content">
            <div class="content__header content__boxed overlapping">
                <div class="content__wrap">

                    <!-- Breadcrumb 
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="./index.html">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                    <!-- END : Breadcrumb -->

                    <h2 class="my-1 page-tittle"><?= $title ?></h2>

                </div>

            </div>
			<?php $this->load->view($content); ?>
			
            <!-- FOOTER -->
            <footer class="mt-auto">
                <div class="content__boxed">
                    <div class="content__wrap py-3 py-md-1 d-flex flex-column flex-md-row align-items-md-center">
                        <div class="text-nowrap mb-4 mb-md-0">Copyright &copy; 2022 <a href="#" class="ms-1 btn-link fw-bold"><?=$_ENV['MAIN_USER']?> <?=$_ENV['MAIN_TAG']?> </a></div>
                        <!--<nav class="nav flex-column gap-1 flex-md-row gap-md-3 ms-md-auto" style="row-gap: 0 !important;">
                            <a class="nav-link px-0" href="#">Policy Privacy</a>
                            <a class="nav-link px-0" href="#">Terms and conditions</a>
                            <a class="nav-link px-0" href="#">Contact Us</a>
                        </nav>-->
                    </div>
                </div>
            </footer>
            <!-- END - FOOTER -->

        </section>

        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <!-- END - CONTENTS -->

        <!-- HEADER -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <header class="header">
            <div class="header__inner">

                <!-- Brand -->
                <div class="header__brand">
                    <div class="brand-wrap">

                        <!-- Brand logo -->
                        <a href="<?=base_url('beranda')?>" class="brand-img stretched-link">
                            <img src="<?=$_ENV['LOGO_100']?>" alt="Nifty Logo" class="ENSITEC" width="40" height="40">
                        </a>

                        <!-- Brand title -->
                        <div class="brand-title"><?= $_ENV['MAIN_USER']?></div>

                        <!-- You can also use IMG or SVG instead of a text element. -->

                    </div>
                </div>
                <!-- End - Brand -->
			</div>
        </header>
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <!-- END - HEADER -->
	</div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <!-- END - PAGE CONTAINER -->

    <!-- SCROLL TO TOP BUTTON -->
    <div class="scroll-container">
        <a href="#root" class="scroll-page rounded-circle ratio ratio-1x1" aria-label="Scroll button"></a>
    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <!-- END - SCROLL TO TOP BUTTON -->

    <!-- JAVASCRIPTS -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
	
    <!-- Popper JS [ OPTIONAL ] -->
    <script src="<?=$_ENV['THM_LINK']?>vendors/popperjs/popper.min.js" defer></script>

    <!-- Bootstrap JS [ OPTIONAL ] -->
    <script src="<?=$_ENV['THM_LINK']?>vendors/bootstrap/bootstrap.min.js" defer></script>

    <!-- Nifty JS [ OPTIONAL ] -->
    <script src="<?=$_ENV['THM_LINK']?>js/nifty.js" defer></script>

    <!-- Nifty Settings [ DEMO ] -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
	
    <!-- Initialize the tooltips and popovers [ SAMPLE ] -->
    <script src="https://cdn.jsdelivr.net/gh/ardimardiana/great@master/assets//pages/tooltips-popovers.js" defer></script>
</body>

</html>