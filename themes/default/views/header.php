<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $page_title . ' | ' . $Settings->site_name; ?></title>
    <link rel="shortcut icon" href="<?= $assets ?>images/icon.png"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="<?= $assets ?>dist/css/styles.css" rel="stylesheet" type="text/css" />
    <?= $Settings->rtl ? '<link href="' . $assets . 'dist/css/rtl.css" rel="stylesheet" />' : ''; ?>
    <script src="<?= $assets ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <style>
    @media print {
      html, body, .pos, .modal, .modal-dialog {
        min-width: 200px !important;
        width: auto !important;
      }
    }
    </style>
</head>
<body class="skin-<?= $Settings->theme_style; ?> fixed sidebar-mini">
<div class="wrapper rtl rtl-inv">

    <header class="main-header">
        <a href="<?= site_url(); ?>" class="logo">
            <?php if ($store) { ?>
            <span class="logo-mini"><?= $store->code; ?></span>
            <span class="logo-lg"><?= $store->name == 'SimplePOS' ? 'Simple<b>POS</b>' : $store->name; ?></span>
            <?php } else { ?>
            <span class="logo-mini">POS</span>
            <span class="logo-lg"><?= $Settings->site_name == 'SimplePOS' ? 'Simple<b>POS</b>' : $Settings->site_name; ?></span>
            <?php } ?>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <ul class="nav navbar-nav pull-left">
                <li class="dropdown hidden-xs">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="<?= $assets; ?>images/<?= $Settings->selected_language; ?>.png" alt="<?= $Settings->selected_language; ?>"></a>
                    <ul class="dropdown-menu">
                        <?php $scanned_lang_dir = array_map(function ($path) {
    return basename($path);
                        }, glob(APPPATH . 'language/*', GLOB_ONLYDIR));
                                                                                         foreach ($scanned_lang_dir as $entry) { ?>
                            <li><a href="<?= site_url('pos/language/' . $entry); ?>"><img
                                        src="<?= $assets; ?>images/<?= $entry; ?>.png"
                                        class="language-img"> &nbsp;&nbsp;<?= ucwords($entry); ?></a></li>
                                                                                         <?php } ?>
                    </ul>
                </li>
            </ul>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="hidden-xs hidden-sm"><a href="#" class="clock"></a></li>
                    <li class="hidden-xs"><a href="<?= site_url(); ?>" data-toggle="tooltip" data-placement="bottom" title="<?= lang('dashboard'); ?>"><i class="fa fa-dashboard"></i></a></li>
                    <?php if ($Admin) { ?>
                    <li class="hidden-xs"><a href="<?= site_url('settings'); ?>" data-toggle="tooltip" data-placement="bottom" title="<?= lang('settings'); ?>"><i class="fa fa-cogs"></i></a></li>
                    <?php } ?>
                    <li class="dropdown user user-menu" style="padding-right:5px;">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?= base_url('uploads/avatars/thumbs/' . ($this->session->userdata('avatar') ? $this->session->userdata('avatar') : $this->session->userdata('gender') . '.png')) ?>" class="user-image" alt="Avatar" />
                            <span class="hidden-xs"><?= $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'); ?></span>
                        </a>
                        <ul class="dropdown-menu" style="padding-right:3px;">
                            <li class="user-header">
                                <img src="<?= base_url('uploads/avatars/' . ($this->session->userdata('avatar') ? $this->session->userdata('avatar') : $this->session->userdata('gender') . '.png')) ?>" class="img-circle" alt="Avatar" />
                                <p>
                                    <?= $this->session->userdata('email'); ?>
                                    <small><?= lang('member_since') . ' ' . $this->session->userdata('created_on'); ?></small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?= site_url('users/profile/' . $this->session->userdata('user_id')); ?>" class="btn btn-default btn-flat"><?= lang('profile'); ?></a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?= site_url('logout'); ?>" class="btn btn-default btn-flat<?= $this->session->userdata('register_id') ? ' sign_out' : ''; ?>"><?= lang('sign_out'); ?></a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu">
                <!-- <li class="header"><?= lang('mian_navigation'); ?></li> -->

                <li class="mm_welcome"><a href="<?= site_url(); ?>"><i class="fa fa-dashboard"></i> <span><?= lang('dashboard'); ?></span></a></li>
                <?php if ($Settings->multi_store && !$this->session->userdata('store_id')) { ?>
                <li class="mm_stores"><a href="<?= site_url('stores'); ?>"><i class="fa fa-building-o"></i> <span><?= lang('stores'); ?></span></a></li>
                <?php } ?>

                <?php if ($Admin) { ?>
                <li class="treeview mm_auth">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span><?= lang('people'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="auth_users"><a href="<?= site_url('users'); ?>"><i class="fa fa-circle-o"></i> <?= lang('list_users'); ?></a></li>
                        <li id="auth_add"><a href="<?= site_url('users/add'); ?>"><i class="fa fa-circle-o"></i> <?= lang('add_user'); ?></a></li>
                    </ul>
                </li>

                <li class="treeview mm_settings">
                    <a href="#">
                        <i class="fa fa-cogs"></i>
                        <span><?= lang('settings'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="settings_index"><a href="<?= site_url('settings'); ?>"><i class="fa fa-circle-o"></i> <?= lang('settings'); ?></a></li>
                        <li class="divider"></li>
                        <li id="settings_stores"><a href="<?= site_url('settings/stores'); ?>"><i class="fa fa-circle-o"></i> <?= lang('stores'); ?></a></li>
                        <?php if ($Settings->multi_store) { ?>
                        <li id="settings_add_store"><a href="<?= site_url('settings/add_store'); ?>"><i class="fa fa-circle-o"></i> <?= lang('add_store'); ?></a></li>
                        <li class="divider"></li>
                        <?php } ?>
                        <li id="settings_printers"><a href="<?= site_url('settings/printers'); ?>"><i class="fa fa-circle-o"></i> <?= lang('printers'); ?></a></li>
                        <li id="settings_add_printer"><a href="<?= site_url('settings/add_printer'); ?>"><i class="fa fa-circle-o"></i> <?= lang('add_printer'); ?></a></li>
                        <li class="divider"></li>
                        <?php if ($this->db->dbdriver != 'sqlite3') { ?>
                        <li id="settings_backups"><a href="<?= site_url('settings/backups'); ?>"><i class="fa fa-circle-o"></i> <?= lang('backups'); ?></a></li>
                        <?php } ?>
                        <!-- <li id="settings_updates"><a href="<?= site_url('settings/updates'); ?>"><i class="fa fa-circle-o"></i> <?= lang('updates'); ?></a></li> -->
                    </ul>
                </li>

                <li class="treeview mm_categories mm_subcategories mm_products">
                    <a href="#">
                        <i class="fa fa-folder"></i>
                        <span><?= lang('PRODUCT CATALOG'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="categories_index"><a href="<?= site_url('categories'); ?>"><i class="fa fa-circle-o"></i> <?= lang('LIST CATEGORY'); ?></a></li>
                        <li id="categories_add"><a href="<?= site_url('categories/add'); ?>"><i class="fa fa-circle-o"></i> <?= lang('ADD CATEGORY'); ?></a></li>
                        <li class="divider"></li>
                        <li id="subcategories_index"><a href="<?= site_url('subcategories'); ?>"><i class="fa fa-circle-o"></i> <?= lang('LIST SUBCATEGORY'); ?></a></li>
                        <li id="subcategories_add"><a href="<?= site_url('subcategories/add'); ?>"><i class="fa fa-circle-o"></i> <?= lang('ADD SUBCATEGORY'); ?></a></li>
                        <li class="divider"></li>
                        <li id="products_index"><a href="<?= site_url('products'); ?>"><i class="fa fa-circle-o"></i> <?= lang('LIST PRODUCT'); ?></a></li>
                        <li id="products_add"><a href="<?= site_url('products/add'); ?>"><i class="fa fa-circle-o"></i> <?= lang('ADD PRODUCT'); ?></a></li>
                    </ul>
                </li>

                <li class="treeview mm_homepageslider mm_fabriccolors mm_bandcolors mm_coupons">
                    <a href="#">
                        <i class="fa fa-laptop"></i>
                        <span><?= lang('WEBSITE MANAGEMENT'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                    <li id="homepageslider_index"><a href="<?= site_url('homepageslider'); ?>"><i class="fa fa-circle-o"></i> <?= lang('LIST HOMEPAGE SLIDER'); ?></a></li>
                     <li id="homepageslider_add"><a href="<?= site_url('homepageslider/add'); ?>"><i class="fa fa-circle-o"></i> <?= lang('ADD HOMEPAGE SLIDER'); ?></a></li>
                     <li class="divider"></li>
                     <li id="fabriccolors_index"><a href="<?= site_url('fabriccolors'); ?>"><i class="fa fa-circle-o"></i> <?= lang('LIST FABRIC COLORS'); ?></a></li>
                     <li id="fabriccolors_add"><a href="<?= site_url('fabriccolors/add'); ?>"><i class="fa fa-circle-o"></i> <?= lang('ADD FABRIC COLORS'); ?></a></li>
                     <li class="divider"></li>
                     <li id="bandcolors_index"><a href="<?= site_url('bandcolors'); ?>"><i class="fa fa-circle-o"></i> <?= lang('LIST BAND COLORS'); ?></a></li>
                     <li id="bandcolors_add"><a href="<?= site_url('bandcolors/add'); ?>"><i class="fa fa-circle-o"></i> <?= lang('ADD BAND COLORS'); ?></a></li>
                     <li class="divider"></li>
                        <li id="coupons_index"><a href="<?= site_url('coupons'); ?>"><i class="fa fa-circle-o"></i> <?= lang('LIST COUPONS'); ?></a></li>
                     <li id="coupons_add"><a href="<?= site_url('coupons/add'); ?>"><i class="fa fa-circle-o"></i> <?= lang('ADD COUPONS'); ?></a></li>
                    </ul>
                </li>



				<li class="treeview mm_retailcustomers mm_businesscustomers">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span><?= lang('CUSTOMERS'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li id="retailcustomers_index"><a href="<?= site_url('retailcustomers'); ?>"><i class="fa fa-circle-o"></i> <?= lang('RETAIL CUSTOMERS'); ?></a></li>
                        <li id="businesscustomers_index"><a href="<?= site_url('businesscustomers'); ?>"><i class="fa fa-circle-o"></i> <?= lang('BUSINESS CUSTOMERS'); ?></a></li>
                    </ul>
                </li>

                    <li class="treeview mm_reports">
                    <a href="#">
                        <i class="fa fa-bookmark-o"></i>
                        <span><?= lang('REPORTS'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                       <li id="reports_index"><a href="<?= site_url('reports'); ?>"><i class="fa fa-circle-o"></i> <?= lang('DAILY SALES REPORTS'); ?></a></li>
                       <li id="reports_reports_io"><a href="<?= site_url('reports/reports_io'); ?>"><i class="fa fa-circle-o"></i> <?= lang('DAILY SALES-I/O'); ?></a></li>
                       <li id="reports_product_sales"><a href="<?= site_url('reports/product_sales'); ?>"><i class="fa fa-circle-o"></i> <?= lang('PRODUCT SALES'); ?></a></li>
                    </ul>
                </li>

                <li class="treeview mm_cartitems mm_unplacedorders mm_editshippingorders">
                    <a href="#">
                        <i class="fa fa-bar-chart-o"></i>
                        <span><?= lang('SUPER USER'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                    <li id="cartitems_index"><a href="<?= site_url('cartitems'); ?>"><i class="fa fa-circle-o"></i> <?= lang('CART ITEMS'); ?></a></li>
                    <li id="unplacedorders_index"><a href="<?= site_url('unplacedorders'); ?>"><i class="fa fa-circle-o"></i> <?= lang('UNPLACED ORDERS'); ?></a></li>
                    <li id="editshippingorders_index"><a href="<?= site_url('editshippingorders'); ?>"><i class="fa fa-circle-o"></i> <?= lang('EDIT SHIPPING ADDRESS'); ?></a></li>
                    </ul>
                </li>


                <?php } ?>
            </ul>
        </section>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <h1><?= $page_title; ?></h1>
            <ol class="breadcrumb">
                <li><a href="<?= site_url(); ?>"><i class="fa fa-dashboard"></i> <?= lang('home'); ?></a></li>
                <?php
                foreach ($bc as $b) {
                    if ($b['link'] === '#') {
                        echo '<li class="active">' . $b['page'] . '</li>';
                    } else {
                        echo '<li><a href="' . $b['link'] . '">' . $b['page'] . '</a></li>';
                    }
                }
                ?>
            </ol>
        </section>

        <div class="col-lg-12 alerts">
            <div id="custom-alerts" style="display:none;">
                <div class="alert alert-dismissable">
                    <div class="custom-msg"></div>
                </div>
            </div>
            <?php if ($error) { ?>
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4><i class="icon fa fa-ban"></i> <?= lang('error'); ?></h4>
                <?= $error; ?>
            </div>
            <?php } if ($warning) { ?>
            <div class="alert alert-warning alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4><i class="icon fa fa-warning"></i> <?= lang('warning'); ?></h4>
                <?= $warning; ?>
            </div>
            <?php } if ($message) { ?>
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4>    <i class="icon fa fa-check"></i> <?= lang('Success'); ?></h4>
                <?= $message; ?>
            </div>
            <?php } ?>
        </div>
        <div class="clearfix"></div>
