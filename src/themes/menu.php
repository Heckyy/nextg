  <?php
  class menu
  {
    function menu_top($e)
    {

  ?>
      <nav class="navbar navbar-header navbar-expand navbar-light fixed-top bg-white shadow">
        <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
        <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <span class="logo">
          MANAGEMENT RW 05
        </span>

        <div class="collapse navbar-collapse d-flex align-items-end " id="navbarSupportedContent">

          <ul class="navbar-nav d-flex align-items-center navbar-light ms-auto ">
            <div class="text-left ms-auto"><b>Hello, <?= $_SESSION['employee_name'] ?></b></div>
            <li class="dropdown nav-icon d-none">
              <a href="#" data-bs-toggle="dropdown" class="space_icons dropdown-toggle nav-link-lg nav-link-user">
                <div class="d-lg-inline-block">
                  <i class="bi bi-bell icons-size"></i>
                </div>
              </a>

              <!-- <div class="dropdown-menu dropdown-menu-end dropdown-menu-large">
                <h6 class='py-2 px-3'>Notifications</h6>
                <ul class="list-group rounded-none">
                  <li class="list-group-item border-0 align-items-start ">
                    <div>
                      <h6 class='text-bold'>
                        Notification coming soon
                      </h6>
                    </div>
                  </li>
                </ul>
              </div> -->
            </li>
            <li class="dropdown nav-icon me-2">
              <a href="#" data-bs-toggle="dropdown" class="space_icons dropdown-toggle nav-link-lg nav-link-user">
                <div class="d-lg-inline-block">
                  <i class="bi bi-gear icons-size"></i>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end">
                <?php
                if ($_SESSION['settings'] == 1) {
                ?>
                  <a class="dropdown-item" href="<?php echo $e; ?>/settings">Settings</a>
                <?php

                }
                ?>
                <a class="dropdown-item" href="#" onclick="change_password();">Change Password</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" onclick="logout();">Logout</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>
    <?php

    }
    function menu_view($e, $db, $hal)
    {

    ?>
      <style type="text/css">
        input {
          text-transform: uppercase;
        }
      </style>
      <div id="sidebar" class='active'>
        <div class="sidebar-wrapper active margin-top-bottom">
          <div class="sidebar-menu">
            <ul class="menu">

              <li class="sidebar-item sidebar-link space"></li>

              <li class="sidebar-item <?php if ($hal == 'home') {
                                        echo 'active';
                                      } ?>">
                <a href="<?php echo $e; ?>/home" class='sidebar-link'>
                  <i class="bi bi-house icons-size"></i>
                  <span>Dashboard</span>
                </a>
              </li>

              <?php
              if ($_SESSION['unit'] == 1 || $_SESSION['position'] == 1 || $_SESSION['employee'] == 1 || $_SESSION['coordinator'] == 1 || $_SESSION['contractor'] == 1 || $_SESSION['type_of_work'] == 1) {
              ?>
                <li class="sidebar-item has-sub <?php if ($hal == 'unit' || $hal == 'position' || $hal == 'employee' || $hal == 'coordinator' || $hal == 'contractor' || $hal == 'type_of_work') {
                                                  echo 'active';
                                                } ?>">
                  <a href="#" class="sidebar-link">
                    <i class="bi bi-card-checklist icons-size"></i>
                    <span>Data Pengurus</span>
                  </a>
                  <ul class="submenu <?php if ($hal == 'unit' || $hal == 'position' || $hal == 'employee' || $hal == 'coordinator' || $hal == 'contractor' || $hal == 'type_of_work') {
                                        echo 'active';
                                      } ?>">
                    <?php
                    if ($_SESSION['unit'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'unit') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/unit">
                          Jabatan
                        </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['position'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'position') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/position">
                          Poisisi
                        </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['type_of_work'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'type_of_work') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/type-of-work">
                          Tipe Pekerjaan
                        </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['employee'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'employee') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/employee">
                          Pengurus
                        </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['coordinator'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'coordinator') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/coordinator">
                          Kordinator
                        </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['contractor'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'contractor') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/contractor">
                          Kontraktor
                        </a>
                      </li>
                    <?php
                    }
                    ?>
                  </ul>
                </li>
              <?php
              }
              if ($_SESSION['rw'] == 1 || $_SESSION['rt'] == 1 || $_SESSION['cluster'] == 1 || $_SESSION['house_size'] == 1 || $_SESSION['house_owner'] == 1 || $_SESSION['population'] == 1 || $_SESSION['dues_type'] == 1) {
              ?>
                <li class="sidebar-item has-sub <?php if ($hal == 'rw' || $hal == 'rt' || $hal == 'cluster' || $hal == 'house_size' || $hal == 'house_owner' || $hal == 'population' || $hal == 'dues_type') {
                                                  echo 'active';
                                                } ?>">
                  <a href="#" class='sidebar-link'>
                    <i class="bi bi-card-list icons-size"></i>
                    <span>Owner Data</span>
                  </a>
                  <ul class="submenu <?php if ($hal == 'rw' || $hal == 'rt' || $hal == 'cluster' || $hal == 'house_size' || $hal == 'house_owner' || $hal == 'population' || $hal == 'dues_type') {
                                        echo 'active';
                                      } ?>">
                    <?php
                    if ($_SESSION['rw'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'rw') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/rw">Manager Position</a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['rt'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'rt') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/rt">Data RT</a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['cluster'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'cluster') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/cluster">Cluster</a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['house_size'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'house_size') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/house-size">House Size</a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['house_owner'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'house_owner') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/house-owner">Property Owner</a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['population'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'population') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/population">Resident</a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['dues_type'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'dues_type') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/dues-type">Types of Grants</a>
                      </li>
                    <?php
                    }
                    ?>
                  </ul>
                </li>
              <?php
              }

              if ($_SESSION['purchasing'] == 1 || $_SESSION['request'] == 1 || $_SESSION['maintenance'] == 1 || $_SESSION['po_maintenance'] == 1) {
              ?>
                <li class="sidebar-item has-sub <?php if ($hal == 'item' || $hal == 'purchasing' || $hal == 'request' || $hal == 'maintenance' || $hal == 'po_maintenance') {
                                                  echo 'active';
                                                } ?>">
                  <a href="#" class="sidebar-link">
                    <i class="bi bi-bag icons-size"></i>
                    <span>Purchasing</span>
                  </a>
                  <ul class="submenu <?php if ($hal == 'item' || $hal == 'purchasing' || $hal == 'request' || $hal == 'maintenance' || $hal == 'po_maintenance') {
                                        echo 'active';
                                      } ?>">
                    <?php
                    if ($_SESSION['item'] == 2) {
                    ?>
                      <li class="<?php if ($hal == 'item') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/item">
                          Item
                        </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['request'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'request') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/request">
                          <span>Request</span>
                        </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['purchasing'] == 1) {

                    ?>
                      <li class="<?php if ($hal == 'purchasingg') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/purchasing">
                          <span>Purchasing</span>
                        </a>
                      </li>


                      <?php if ($_SESSION['purchasing'] == 1) { ?>
                        <li class="<?php if ($hal == 'inv_purchasing') {
                                      echo 'active';
                                    } ?>">
                          <a href="<?php echo $e; ?>/inv_purchasing">
                            <span>Bills From Supplier</span>
                          </a>
                        </li>
                      <?php } ?>

                    <?php
                    }
                    if ($_SESSION['maintenance'] == 2 || $_SESSION['po_maintenance'] == 2) {
                    ?>
                      <li class="<?php if ($hal == 'maintenance' || $hal == 'po_maintenance') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/maintenance">
                          <span>Maintenance</span>
                        </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['monitoring_purchasing'] == 1 || $_SESSION['monitoring_invoice'] == 1) {
                    ?>
                      <li class="sidebar-item has-sub <?php if ($hal == 'monitoring_purchasing' || $hal == 'monitoring_invoice') {
                                                        echo 'active';
                                                      } ?>">
                        <a href="#" class='sidebar-link'>
                          <i class="bi bi-file-text icons-size"></i>
                          <span>Monitoring</span>
                        </a>

                        <ul class="submenu <?php if ($hal == 'monitoring_purchasing' || $hal == 'monitoring_invoice') {
                                              echo 'active';
                                            } ?>">
                          <?php
                          if ($_SESSION['monitoring_purchasing'] == 1) {
                          ?>
                            <li class="<?php if ($hal == 'monitoring_purchasing') {
                                          echo 'active';
                                        } ?>">
                              <a href="<?php echo $e; ?>/monitoring-purchasing">Purchasing</a>
                            </li>
                          <?php
                          }
                          if ($_SESSION['monitoring_invoice'] == 1) {
                          ?>
                            <li class="<?php if ($hal == 'monitoring_invoice') {
                                          echo 'active';
                                        } ?>">
                              <a href="<?php echo $e; ?>/monitoring-invoice">Invoice</a>
                            </li>
                          <?php
                          }
                          ?>
                        </ul>
                      </li>
                    <?php
                    }

                    ?>
                  </ul>
                </li>
              <?php
              }
              if ($_SESSION['warehouse'] == 1 || $_SESSION['type_of_receipt_wh'] == 1 || $_SESSION['type_of_out_wh'] == 1 || $_SESSION['item_out'] == 1 || $_SESSION['item_receipt'] == 1 || $_SESSION['report_inventory'] == 1) {
              ?>
                <li class="sidebar-item has-sub <?php if ($hal == 'warehouse' || $hal == 'type_of_receipt_wh' || $hal == 'type_of_out_wh' || $hal == 'item_out' || $hal == 'item_receipt' || $hal == 'report_inventory') {
                                                  echo 'active';
                                                } ?>">
                  <a href="#" class="sidebar-link">
                    <i class="bi bi-building icons-size"></i>
                    <span>Warehouse</span>
                  </a>
                  <ul class="submenu <?php if ($hal == 'warehouse' || $hal == 'type_of_receipt_wh' || $hal == 'type_of_out_wh' || $hal == 'item_out' || $hal == 'item_receipt' || $hal == 'report_inventory') {
                                        echo 'active';
                                      } ?>">
                    <?php
                    if ($_SESSION['warehouse'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'warehouse') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/warehouse">
                          Warehouse
                        </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['type_of_receipt_wh'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'type_of_receipt_wh') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/type-of-receipt-wh">
                          Type of Receipt
                        </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['type_of_out_wh'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'type_of_out_wh') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/type-of-out-wh">
                          Type of Out
                        </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['item_receipt'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'item_receipt') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/item-receipt">
                          Item Receipt
                        </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['item_out'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'item_out') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/item-out">
                          Item Out
                        </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['item_out'] == 2) {
                    ?>
                      <li class="<?php if ($hal == 'item_out') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/item-out">
                          Purchase Request
                        </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['report_inventory'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'report_inventory') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/report-inventory">Inventory</a>
                      </li>
                    <?php
                    }
                    ?>
                  </ul>
                </li>
              <?php
              }
              if ($_SESSION['report_finance_balance'] == 1 || $_SESSION['report_bank_cash'] == 1 || $_SESSION['report_cash_receipt'] == 1 || $_SESSION['report_cash_payment'] == 1 || $_SESSION['bank_cash'] == 1 || $_SESSION['type_of_receipt'] == 1 || $_SESSION['type_of_payment'] == 1 || $_SESSION['cash_receipt'] == 1 || $_SESSION['cash_payment'] == 1 || $_SESSION['invoice'] == 1) {
              ?>
                <li class="sidebar-item has-sub <?php if ($hal == 'report_finance_balance' || $hal == 'report_bank_cash' || $hal == 'report_cash_receipt' || $hal == 'report_cash_payment' || $hal == 'bank_cash' || $hal == 'type_of_receipt' || $hal == 'type_of_paym
                ent' || $hal == 'cash_receipt' || $hal == 'cash_payment' || $hal == 'invoice') {
                                                  echo 'active';
                                                } ?>">
                  <a href="#" class="sidebar-link">
                    <i class="bi bi-wallet icons-size"></i>
                    <span>Finance</span>
                  </a>
                  <ul class="submenu <?php if ($hal == 'report_finance_balance' || $hal == 'report_bank_cash' || $hal == 'report_cash_receipt' || $hal == 'report_cash_payment' || $hal == 'bank_cash' || $hal == 'type_of_receipt' || $hal == 'type_of_payment' || $hal == 'cash_receipt' || $hal == 'cash_payment' || $hal == 'invoice') {
                                        echo 'active';
                                      } ?>">
                    <?php
                    if ($_SESSION['bank_cash'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'bank_cash') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/bank-cash">
                          Bank / Cash
                        </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['type_of_receipt'] == 2) {
                    ?>
                      <li class="<?php if ($hal == 'type_of_receipt') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/type-of-receipt">
                          Type of Income
                        </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['type_of_payment'] == 2) {
                    ?>
                      <li class="<?php if ($hal == 'type_of_payment') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/type-of-payment">
                          Type of Payment
                        </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['cash_receipt'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'cash_receipt') {
                                    echo 'active';
                                  } ?>">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#cash_receipt_modal">Cash Receipt</a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['cash_payment'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'cash_payment') {
                                    echo 'active';
                                  } ?>">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#cash_payment_modal">Cash Payment</a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['invoice'] == 1) {
                    ?>

                    <?php
                    }
                    if ($_SESSION['report_finance_balance'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'report_finance_balance') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/report-finance-balance">Report Finance Balance</a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['report_bank_cash'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'report_bank_cash') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/report-bank-cash">Report Bank / Cash </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['report_cash_receipt'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'report_cash_receipt') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/report-cash-receipt">Report Cash Receipt </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['report_cash_payment'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'report_cash_payment') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/report-cash-payment">Report Cash Payment</a>
                      </li>
                    <?php
                    }
                    ?>
                  </ul>
                </li>
              <?php
              }

              if ($_SESSION['account'] == 1 || $_SESSION['type_of_item'] == 1 || $_SESSION['group_account'] == 1 || $_SESSION['type_of_account'] == 1 || $_SESSION['type_of_item'] == 1 || $_SESSION['fn_type_of_receipt'] == 1 || $_SESSION['wh_type_of_receipt'] == 1 || $_SESSION['wh_type_of_out'] == 1 || $_SESSION['fn_type_of_payment'] == 1 || $_SESSION['journal_voucher'] == 1 || $_SESSION['tutup_buku'] == 1 || $_SESSION['report_account_balance'] == 1 || $_SESSION['report_general_ledger'] == 1 || $_SESSION['report_balance_sheet'] == 1 || $_SESSION['report_cash_flow_statement'] == 1) {
              ?>
                <li class="sidebar-item has-sub <?php if ($hal == 'account' || $hal == 'group_account' || $hal == 'type_of_account' || $hal == 'type_of_item' || $hal == 'fn_type_of_receipt' || $hal == 'wh_type_of_receipt' || $hal == 'wh_type_of_out' || $hal == 'fn_type_of_payment' || $hal == 'journal_voucher' || $hal == 'tutup_buku' || $hal == 'report_account_balance' || $hal == 'report_general_ledger' || $hal == 'report_balance_sheet' || $hal == 'report_cash_flow_statement') {
                                                  echo 'active';
                                                } ?>">
                  <a href="#" class="sidebar-link">
                    <i class="bi bi-bank"></i>
                    <span>Accountancy</span>
                  </a>
                  <ul class="submenu <?php if ($hal == 'account' || $hal == 'group_account' || $hal == 'type_of_account' || $hal == 'type_of_item' || $hal == 'wh_type_of_receipt' || $hal == 'wh_type_of_out' || $hal == 'fn_type_of_receipt' || $hal == 'fn_type_of_payment' || $hal == 'journal_voucher' || $hal == 'tutup_buku' || $hal == 'report_account_balance' || $hal == 'report_general_ledger' || $hal == 'report_balance_sheet' || $hal == 'report_cash_flow_statement') {
                                        echo 'active';
                                      } ?>">
                    <?php
                    if ($_SESSION['account'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'account' || $hal == 'group_account' || $hal == 'type_of_account' || $hal == 'type_of_item' || $hal == 'wh_type_of_receipt' || $hal == 'wh_type_of_out' || $hal == 'fn_type_of_receipt' || $hal == 'fn_type_of_payment' || $hal == 'journal_voucher' || $hal == 'tutup_buku') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/account">
                          Account
                        </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['type_of_item'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'type_of_item') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/type-of-item">
                          Item Type
                        </a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['journal_voucher'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'journal_voucher') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/journal-voucher">Journal Voucher</a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['tutup_buku'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'tutup_buku') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/tutup-buku">Close Book</a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['report_account_balance'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'report_account_balance') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/report-account_balance">Report Account Balance</a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['report_general_ledger'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'report_general_ledger') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/report-general_ledger">Report General Ledger</a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['report_balance_sheet'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'report_balance_sheet') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/report-balance_sheet">Report Balance Sheet</a>
                      </li>
                    <?php
                    }
                    if ($_SESSION['report_cash_flow_statement'] == 1) {
                    ?>
                      <li class="<?php if ($hal == 'report_cash_flow_statement') {
                                    echo 'active';
                                  } ?>">
                        <a href="<?php echo $e; ?>/report-cash_flow_statement">Report Cash Flow Statement</a>
                      </li>
                    <?php
                    }
                    ?>

                  </ul>
                </li>
              <?php
              }



              ?>


            </ul>
          </div>
        </div>
      </div>
  <?php
    }
  }
  ?>