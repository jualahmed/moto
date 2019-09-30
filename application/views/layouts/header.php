<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>::~Dokani~:: </title>
  <link rel="icon" href="<?php echo base_url(); ?>images/dokani_small.png"  type="image/x-icon"/>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/dist/css/adminLTE.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/autocom/jquery-ui.css" >
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/plugins/select2/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/assets2/plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.scrollbar.css">
  
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <a href="<?php echo base_url();?>admin" class="logo">
      <span class="logo-mini"><img src="<?php echo base_url(); ?>images/dokani_small.png"></span>
      <span class="logo-lg"><img src="<?php echo base_url(); ?>images/top_logo2.png"></span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span><?php echo $this->tank_auth->get_shopname(); ?></span>
        <?php
          $this->load->config('custom_config'); 
        ?>
      </a>
      <div class="navbar-custom-menu">    
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url();?>images/avatar.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $user_name; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url();?>images/avatar.png" class="img-circle" alt="User Image">
                <p>
                  <?php echo $user_name; ?>
                  <small><?php echo ucfirst($user_type); ?></small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left" style="margin:0px 0px 0px 90px;">
                  <a href="<?php echo base_url();?>auth/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar scrollbar-outer">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
      </div>
    <div id="scrollbar">
      <ul class="sidebar-menu">
        <li class="treeview">
          <a href="<?php echo base_url();?>admin">
            <i class="fa fa-home"></i> <span>Home</span>
          </a>
        </li>
    <?php
    if($user_type!='seller')
    {
    ?>
      <li class="treeview <?php echo active_link_controller('pandingmamo') ?> <?php echo active_link_controller('config') ?> <?php echo active_link_controller('expense') ?>  <?php echo active_link_controller('damageproduct') ?><?php echo active_link_controller('bankcard') ?> <?php echo active_link_controller('comission') ?>  <?php echo active_link_controller('unit') ?> <?php echo active_link_controller('customer') ?> <?php echo active_link_controller('employee') ?> <?php echo active_link_controller('product') ?> <?php echo active_link_controller('distributor') ?> <?php echo active_link_controller('company') ?> <?php echo active_link_controller('category') ?>"  id="setup">
        <a href="#">
          <i class="fa fa-gear"></i>
          <span>Setup</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu common">
          <li class="<?php echo active_link_function('category','index') ?>">
            <a href="<?php echo base_url();?>category"><i class="fa fa-gear"></i>Category Setup</a>
          </li>
          <li class="<?php echo active_link_function('company','index') ?>">
            <a href="<?php echo base_url();?>company"><i class="fa fa-gear"></i>Company Setup</a>
          </li>
          <li class="<?php echo active_link_function('distributor','index') ?>">
            <a href="<?php echo base_url();?>distributor"><i class="fa fa-gear"></i>Distributor Setup</a>
          </li>
          <li class="<?php echo active_link_function('product','index') ?>"><a href="<?php echo base_url();?>product"><i class="fa fa-gear"></i>Product Setup</a></li>
          <!--li><a href="<?php echo base_url();?>setup/card_setup"><i class="fa fa-gear"></i>Card Setup</a></li-->
          <li class="<?php echo active_link_function('customer','index') ?>"><a href="<?php echo base_url();?>customer"><i class="fa fa-gear"></i>Customer Setup</a></li>
          <li class="<?php echo active_link_function('damageproduct','index') ?>"><a href="<?php echo base_url();?>damageproduct"><i class="fa fa-gear"></i>Damage Setup</a></li>
          <li class="<?php echo active_link_function('employee','index') ?>"><a href="<?php echo base_url();?>employee"><i class="fa fa-gear"></i>Employee Setup</a></li>
          <li class="<?php echo active_link_function('unit','index') ?>"><a href="<?php echo base_url();?>unit"><i class="fa fa-gear"></i>Unit Setup</a></li>
          <li class="<?php echo active_link_function('comission','index') ?>">
            <a href="<?php echo base_url();?>comission/index"><i class="fa fa-bank"></i>Commission Setup</a>
          </li>
          <li class="<?php echo active_link_function('bankcard','bank_entry') ?>">
            <a href="<?php echo base_url();?>bankcard/bank_entry"><i class="fa fa-bank"></i>Bank Entry</a>
          </li>
          <li class="<?php echo active_link_function('expense','index') ?>">
            <a href="<?php echo base_url();?>expense/index"><i class="fa fa-bank"></i>Expense Entry</a>
          </li>
          <li class="<?php echo active_link_function('expense','income_index') ?>">
            <a href="<?php echo base_url();?>expense/income_index"><i class="fa fa-bank"></i>Income Entry</a>
          </li>
          <li class="<?php echo active_link_function('product','searchBarcode'); ?>">
              <a href="<?php echo base_url();?>product/searchBarcode"><i class="fa fa-search-plus"></i>Barcode Print</a>
          </li>
          <li class="<?php echo active_link_function('config','index'); ?>">
              <a href="<?php echo base_url();?>config/index"><i class="fa fa-search-plus"></i>Config</a>
          </li>
          <li class="<?php echo active_link_function('pandingmamo','index'); ?>">
              <a href="<?php echo base_url();?>pandingmamo/index"><i class="fa fa-search-plus"></i>Pending mamo</a>
          </li>
        </ul>
      </li>
    <?php }?>

    <li class="treeview <?php echo active_link_controller('purchase') ?> <?php echo active_link_controller('purchaselisting') ?>">
        <a href="#">
          <i class="fa fa-truck"></i>
          <span>Purchase</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo active_link_function('purchase','index') ?>"><a href="<?php echo base_url();?>purchase"><i class="fa fa-truck"></i>Purchase Receipt Entry</a></li>
          <li class="<?php echo active_link_function('purchaselisting','index') ?>"><a href="<?php echo base_url();?>purchaselisting"><i class="fa fa-truck"></i>Purchase Listing </a></li>
          <li class="<?php echo active_link_function('purchase','purchase_return') ?>"><a href="<?php echo base_url();?>purchase/purchase_return"><i class="fa fa-truck"></i>Purchase Return</a></li>
        </ul>
    </li>
    
    <li class="treeview <?php echo active_link_function('sale','index') ?>">
        <a href="<?php echo base_url();?>sale">
          <i class="fa fa-shopping-cart"></i> <span>Sale</span>
        </a>
    </li>

     <li class="treeview <?php echo active_link_function('oldsale','index') ?>">
        <a href="<?php echo base_url();?>oldsale">
          <i class="fa fa-shopping-cart"></i> <span>Old Sale</span>
        </a>
    </li>

    <li class="treeview <?php echo active_link_function('sale','collection') ?>">
        <a href="<?php echo base_url();?>sale/collection">
          <i class="fa fa-shopping-cart"></i> <span>Collection</span>
        </a>
    </li>
    <li class="treeview <?php echo active_link_controller('salereturn'); ?>">
      <a href="<?php echo base_url();?>salereturn/cash_salereturn"><i class="fa fa-shopping-cart"></i><span>Sale Return</span></a>
    </li>
    <?php
    if($user_type!='seller')
    {
    ?>
    <li class="treeview <?php echo active_link_controller('account'); ?>">
      <a href="#">
        <i class="fa fa-bank"></i>
        <span>Accounts</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu common">
        <li class="<?php echo active_link_function('account','transactionreport') ?>">
          <a href="<?php echo base_url();?>account/transactionreport"><i class="fa fa-bank"></i>All Transactions</a>
        </li>
        <li class="<?php echo active_link_function('account','bank_transfer') ?>">
          <a href="<?php echo base_url();?>account/bank_transfer"><i class="fa fa-bank"></i>Bank Transfer</a>
        </li>
        <li class="<?php echo active_link_function('account','owner_transfer') ?>">
          <a href="<?php echo base_url();?>account/owner_transfer"><i class="fa fa-bank"></i>Owner Transfer</a>
        </li>
        <li class="<?php echo active_link_function('account','loan_transfer') ?>">
          <a href="<?php echo base_url();?>account/loan_transfer"><i class="fa fa-bank"></i>Loan Transfer</a>
        </li>
        <li class="<?php echo active_link_function('account','loan_transfer_report') ?>">
          <a href="<?php echo base_url();?>account/loan_transfer_report"><i class="fa fa-bank"></i>Loan Transfer Report</a>
        </li>
        <li class="<?php echo active_link_function('account','ledgers') ?>">
          <a href="<?php echo base_url();?>account/ledgers"><i class="fa fa-bank"></i>Ledger</a>
        </li>
        <li class="<?php echo active_link_function('account','cash_book_report') ?>">
          <a href="<?php echo base_url();?>account/cash_book_report"><i class="fa fa-bank"></i>Cash Book Report</a>
        </li>
        <li class="<?php echo active_link_function('account','cheque_status_report') ?>">
          <a href="<?php echo base_url();?>account/cheque_status_report"><i class="fa fa-bank"></i>Cheque Status Report</a>
        </li>
        <li class="<?php echo active_link_function('account','credit_collection_receipt') ?>">
          <a href="<?php echo base_url();?>account/credit_collection_receipt"><i class="fa fa-bank"></i>Credit Collection Receipt</a>
        </li>
        <li class="<?php echo active_link_function('account','purchase_payment_receipt') ?>">
          <a href="<?php echo base_url();?>account/purchase_payment_receipt"><i class="fa fa-bank"></i>Purchase Payment Receipt</a>
        </li>
        <li class="<?php echo active_link_function('account','expense_payment_receipt') ?>">
          <a href="<?php echo base_url();?>account/expense_payment_receipt"><i class="fa fa-bank"></i>Expense Payment Receipt</a>
        </li>
        <li class="<?php echo active_link_function('account','pay_reci_report') ?>">
          <a href="<?php echo base_url();?>account/pay_reci_report"><i class="fa fa-bank"></i>Payable & Receivable</a>
        </li>
      </ul>
    </li>
    <?php }?>
    <?php 
    if($user_type=='superadmin' || $user_type=='admin')
    {
    ?>
    <li class="treeview <?php echo active_link_controller('modify') ?>">
      <a href="#">
        <i class="fa fa-edit"></i>
        <span>Modify</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu common">
        <li class="<?php echo active_link_function('modify','invoice_modify_new') ?>">
            <a href="<?php echo base_url();?>modify/invoice_modify_new"><i class="fa fa-edit"></i>Sale Invoice</a>
        </li>
        <li class="<?php echo active_link_function('modify','transaction_modify') ?>">
            <a href="<?php echo base_url();?>modify/transaction_modify"><i class="fa fa-edit"></i>Transactions</a>
        </li>
        <li class="<?php echo active_link_function('modify','total_purchase_price_modify') ?>">
            <a href="<?php echo base_url();?>modify/total_purchase_price_modify"><i class="fa fa-edit"></i>Purchase Receipt</a>
        </li>
        <li class="<?php echo active_link_function('modify','expense_modify_new') ?>">
            <a href="<?php echo base_url();?>modify/expense_modify_new"><i class="fa fa-edit"></i>Expense Modify</a>
        </li>
      </ul>
    </li>
    <?php
    }
    ?>
    <?php
    if($user_type!='seller')
    {
    ?>
    <li class="treeview <?php echo active_link_controller('Report') ?>">
          <a href="#">
            <i class="fa fa-search-plus"></i>
            <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu common">
          <!--   <li class="<?php echo active_link_function('Report','scb_report'); ?>">
              <a href="<?php echo base_url();?>Report/scb_report"><i class="fa fa-search-plus"></i>SCB Report</a>
            </li> -->
            <li class="<?php echo active_link_function('Report','stock_report'); ?>">
              <a href="<?php echo base_url();?>Report/stock_report"><i class="fa fa-search-plus"></i>Stock Report</a>
            </li>
             <li class="<?php echo active_link_function('Report','stock_details'); ?>">
              <a href="<?php echo base_url();?>Report/stock_details"><i class="fa fa-search-plus"></i>Stock Details</a>
            </li>
            <li class="<?php echo active_link_function('Report','warranty_stock_report'); ?>" style="display: none;">
              <a href="<?php echo base_url();?>Report/warranty_stock_report"><i class="fa fa-search-plus"></i>Warranty Stock Report</a>
            </li>
            <li class="<?php echo active_link_function('Report','purchase_report'); ?>">
              <a href="<?php echo base_url();?>Report/purchase_report"><i class="fa fa-search-plus"></i>Purchase Report</a>
            </li>
            <li class="<?php echo active_link_function('Report','sale_report'); ?>">
              <a href="<?php echo base_url();?>Report/sale_report"><i class="fa fa-search-plus"></i>Sale Report</a>
            </li>
            <li class="<?php echo active_link_function('Report','installment_report'); ?>">
              <a href="<?php echo base_url();?>Report/installment_report"><i class="fa fa-search-plus"></i>Installment Report</a>
            </li>
            <li class="<?php echo active_link_function('Report','delivery_charge_report'); ?>">
              <a href="<?php echo base_url();?>Report/delivery_charge_report"><i class="fa fa-search-plus"></i>Delivery Charge Report</a>
            </li>
          
            <li class="<?php echo active_link_function('Report','credit_collection_report_new'); ?>">
              <a href="<?php echo base_url();?>Report/credit_collection_report_new"><i class="fa fa-search-plus"></i>Credit Collection Report </a>
            </li>
            <br><br>
          </ul>
        </li>
        <li class="treeview <?php echo active_link_controller('auth') ?> <?php echo active_link_controller('Registration') ?>">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>User</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php echo active_link_function('auth','register'); ?>"><a href="<?php echo base_url();?>auth/register"><i class="fa fa-user"></i>Register User</a></li>
            <li class="<?php echo active_link_function('Registration','user_modification'); ?>"><a href="<?php echo base_url();?>Registration/user_modification"><i class="fa fa-user"></i>Modify User</a></li>
            <li class="<?php echo active_link_function('auth','change_password'); ?>"><a href="<?php echo base_url();?>auth/change_password"><i class="fa fa-user"></i>Change Password</a></li>
          </ul>
        </li>
    <?php
    }
    ?>    
      </ul>
    </div>
    </section>
  </aside>
