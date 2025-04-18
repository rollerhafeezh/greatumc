<!DOCTYPE html>
<html lang="en" class="notranslate" translate="no">
    
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="google" content="notranslate" /> 
    <title><?= $title ?> | <?= $_ENV['MAIN_USER'] ?> <?= $_ENV['MAIN_TAG'] ?></title>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-186JWY5CM7"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-186JWY5CM7');
    </script>
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
    <!--<script src="https://kit.fontawesome.com/509c53832e.js" crossorigin="anonymous"></script>-->

    <!-- Bootstrap 5 tags [ OPTIONAL ] -->
    <link rel="stylesheet" href="<?=$_ENV['THM_LINK']?>/vendors/bootstrap5-tags/bootstrap5-tags.min.css">
    <style type="text/css">
        .badge {
            text-decoration: none !important;
            color: white !important;
        }
    </style>
	
	<?php  
    	if (isset($head))
    		for ($i=0; $i < count($head); $i++) { echo $head[$i]; }
    ?>
	
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
<style>
.loading-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, .6); z-index: 1000; }  .lds-ring { display: inline-block; position: absolute; top: 50%; left: 50%; width: 100%; } .lds-ring div { box-sizing: border-box; display: block; position: absolute; width: 64px; height: 64px; margin: 8px; border: 8px solid #fff; border-radius: 50%; animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite; border-color: #fff transparent transparent transparent; } .lds-ring div:nth-child(1) { animation-delay: -0.45s; } .lds-ring div:nth-child(2) { animation-delay: -0.3s; } .lds-ring div:nth-child(3) { animation-delay: -0.15s; } @keyframes lds-ring { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
</style>
</head>
<div class="loading-overlay" id="loading" style="display:none"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>
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

                    <?php if($content == 'studi_akhir/edit'): ?>
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dasbor</a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url('studi_akhir') ?>">Studi Akhir</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Studi Akhir</li>
                            </ol>
                        </nav>
                        <!-- END : Breadcrumb -->
                    <?php endif; ?>

                    <h2 class="my-1 page-tittle"><?= $title ?></h2>

                    <?php if(isset($lead)): ?>
                        <p class="lead"><?= $lead ?></p>
                    <?php endif; ?>

					<?php if(isset($_SESSION['msg'])) { ?>
						<div class="alert alert-<?=$_SESSION['msg_clr']?> alert-dismissible fade show" role="alert">
						  <?=$_SESSION['msg']?>
						  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					<?php  } ?>
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
                        <a href="<?=base_url('dashboard')?>" class="brand-img stretched-link">
                            <img src="<?=$_ENV['LOGO_100']?>" alt="Nifty Logo" class="ENSITEC" width="40" height="40">
                        </a>

                        <!-- Brand title -->
                        <div class="brand-title"><?= $_SESSION['nama_app']?></div>

                        <!-- You can also use IMG or SVG instead of a text element. -->

                    </div>
                </div>
                <!-- End - Brand -->

                <div class="header__content">

                    <!-- Content Header - Left Side: -->
                    <div class="header__content-start">

                        <!-- Navigation Toggler -->
                        <button type="button" class="nav-toggler header__btn btn btn-icon btn-sm" aria-label="Nav Toggler">
                            <i class="psi-list-view"></i>
                        </button>
						
						<div class="dropdown">
                            <!-- Toggler -->
                            <div direction="right">
								TA : <?= $_SESSION['nama_smt'] ?> <?=format_indo(date("Y-m-d H:i:s"))?>
							</div>
                        </div>

                        
                    </div>
                    <!-- End - Content Header - Left Side -->
					<div class="header__content-end">
						<div class="dropdown">
                        &nbsp;	
						</div>
					</div>
                </div>
            </div>
        </header>
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <!-- END - HEADER -->

        <!-- MAIN NAVIGATION -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <nav id="mainnav-container" class="mainnav">
            <div class="mainnav__inner">

                <!-- Navigation menu -->
                <div class="mainnav__top-content scrollable-content pb-5">

                    <!-- Profile Widget -->
                    <div class="mainnav__profile mt-3 d-flex3">

                        <div class="mt-2 d-mn-max"></div>

                        <!-- Profile picture  -->
                        <div class="mininav-toggle text-center py-2">
                            <img class="mainnav__avatar img-md rounded-circle border" src="<?=$_SESSION['picture']?>" alt="Profile Picture">
                        </div>

                        <div class="mininav-content collapse d-mn-max">
                            <div class="d-grid">

                                <!-- User name and position -->
                                <div class="d-block btn shadow-none p-2">
									<h5 class="mb-0 me-3"><?=$_SESSION['nama_pengguna']?></h5>
									<?php if($_SESSION['app_level']==1){ ?>
									<p class="text-muted"><?=$_SESSION['id_user']?></p>
									<?php }else{ ?>
									<p class="text-muted"><?=$_SESSION['username']?></p>
									<?php } ?>
								</div>
                            </div>
                        </div>

                    </div>
                    <!-- End - Profile widget -->

                    <!-- Navigation Category -->
                    <div class="mainnav__categoriy py-3">
                        <h6 class="mainnav__caption mt-0 px-3 fw-bold"><?=$_SESSION['level_name']?></h6>
                        <ul class="mainnav__menu nav flex-column">

							<!-- Regular menu link -->
                            <li class="nav-item">
                                <a href="<?= base_url('dashboard') ?>" class="nav-link mininav-toggle"><i class="psi-home fs-5 me-2"></i>
									<span class="nav-label mininav-content ms-1">Dashboard</span>
                                </a>
                            </li>
                            <!-- END : Regular menu link -->
							<?php $this->load->view('lyt/sidebar'); ?>
						</ul>
                    </div>
                    <!-- END : Navigation Category -->
				</div>
                <!-- End - Navigation menu -->

                <!-- Bottom navigation menu -->
                <div class="mainnav__bottom-content border-top pb-2">
                    <ul id="mainnav" class="mainnav__menu nav flex-column">
                        <li class="nav-item">
                            <a href="<?= base_url('logout') ?>" class="nav-link mininav-toggle collapsed" aria-expanded="false">
                                <i class="pli-unlock fs-5 me-2"></i>
                                <span class="nav-label ms-1">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- End - Bottom navigation menu -->

            </div>
        </nav>
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <!-- END - MAIN NAVIGATION -->

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
    
    <script src="<?= base_url('assets/plugins/timeago.js/dist/timeago.min.js') ?>" type="text/javascript"></script>
	
	<?php 
		if (isset($footer))
			for ($i=0; $i < count($footer); $i++) { echo $footer[$i]; } 
	?>
	
</body>

</html>