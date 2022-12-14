<?php
class all_file
{

	function menu($e, $db, $hal)
	{
		include_once("src/themes/menu.php");
		$menu = new menu();
		echo $menu->menu_view($e, $db, $hal);
	}

	function menu_top($e)
	{
		include_once("src/themes/menu.php");
		$menu = new menu();
		echo $menu->menu_top($e);
	}

	function hal_login($e)
	{
		include_once("src/login/login.php");
		$login = new login();
		echo $login->view_login($e);
	}

	function hal_home($db, $e, $library_class, $get, $view, $page)
	{
		include_once("src/home/home.php");
		$home = new home();
		echo $home->view_home($db, $e, $library_class, $view, $page);
	}

	function hal_settings($db, $e, $library_class, $get, $view, $page)
	{
		include_once("src/settings/settings.php");
		$settings = new settings_system();
		echo $settings->view_settings($db, $e);
	}

	function hal_rw($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'edit') {
				include_once("src/rw/edit.php");
				$edit = new edit_rw();
				echo $edit->edit_view($db, $e);
			} else {
				include_once("src/rw/rw.php");
				$rw = new rw();
				echo $rw->view_rw($db, $e);
			}
		} else {
			include_once("src/rw/rw.php");
			$rw = new rw();
			echo $rw->view_rw($db, $e);
		}
	}

	function hal_account($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/account/new.php");
				$account = new new_account();
				echo $account->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/account/edit.php");
				$edit = new edit_account();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/account/view.php");
				$view_data = new view_account();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/account/account.php");
				$account = new account();
				echo $account->view_account($db, $e, $view, $page);
			}
		} else {
			include_once("src/account/account.php");
			$account = new account();
			echo $account->view_account($db, $e, $library_class, $view, $page);
		}
	}

	function hal_account_balance($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'edit' && !empty($view)) {
				include_once("src/group_account/edit.php");
				$edit = new edit_group_account();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/group_account/view.php");
				$view_data = new view_group_account();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/report_bank_cash/report_bank_cash.php");
				$account_balance = new report_bank_cash();
				echo $account_balance->view_report_bank_cash($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/report_bank_cash/report_bank_cash.php");
			$account_balance = new report_bank_cash();
			echo $account_balance->view_report_bank_cash($db, $e, $library_class, $view, $page);
		}
	}

	function hal_group_account($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'edit' && !empty($view)) {
				include_once("src/group_account/edit.php");
				$edit = new edit_group_account();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/group_account/view.php");
				$view_data = new view_group_account();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/group_account/group_account.php");
				$group_account = new group_account();
				echo $group_account->view_group_account($db, $e, $view, $page);
			}
		} else {
			include_once("src/group_account/group_account.php");
			$group_account = new group_account();
			echo $group_account->view_group_account($db, $e, $library_class, $view, $page);
		}
	}

	function hal_type_of_item($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/type_of_item/new.php");
				$type_of_item = new new_type_of_item();
				echo $type_of_item->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/type_of_item/edit.php");
				$edit = new edit_type_of_item();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/type_of_item/view.php");
				$view_data = new view_type_of_item();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/type_of_item/type_of_item.php");
				$type_of_item = new type_of_item();
				echo $type_of_item->view_type_of_item($db, $e, $view, $page);
			}
		} else {
			include_once("src/type_of_item/type_of_item.php");
			$type_of_item = new type_of_item();
			echo $type_of_item->view_type_of_item($db, $e, $library_class, $view, $page);
		}
	}

	function hal_type_of_account($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'edit' && !empty($view)) {
				include_once("src/type_of_account/edit.php");
				$edit = new edit_type_of_account();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/type_of_account/view.php");
				$view_data = new view_type_of_account();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/type_of_account/type_of_account.php");
				$type_of_account = new type_of_account();
				echo $type_of_account->view_type_of_account($db, $e, $view, $page);
			}
		} else {
			include_once("src/type_of_account/type_of_account.php");
			$type_of_account = new type_of_account();
			echo $type_of_account->view_type_of_account($db, $e, $library_class, $view, $page);
		}
	}

	function hal_acn_purchasing($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'edit') {
				include_once("src/setting_account/acn_purchasing_edit.php");
				$edit = new edit_acn_purchasing();
				echo $edit->edit_view($db, $e, $view);
			} else {
				include_once("src/setting_account/acn_purchasing.php");
				$acn_purchasing = new acn_purchasing();
				echo $acn_purchasing->view_acn_purchasing($db, $e, $view, $page);
			}
		} else {
			include_once("src/setting_account/acn_purchasing.php");
			$acn_purchasing = new acn_purchasing();
			echo $acn_purchasing->view_acn_purchasing($db, $e, $library_class, $view, $page);
		}
	}

	function hal_fn_type_of_receipt($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'edit') {
				include_once("src/setting_account/fn_type_of_receipt_edit.php");
				$edit = new edit_fn_type_of_receipt();
				echo $edit->edit_view($db, $e, $view);
			} else {
				include_once("src/setting_account/fn_type_of_receipt.php");
				$fn_type_of_receipt = new fn_type_of_receipt();
				echo $fn_type_of_receipt->view_fn_type_of_receipt($db, $e, $view, $page);
			}
		} else {
			include_once("src/setting_account/fn_type_of_receipt.php");
			$fn_type_of_receipt = new fn_type_of_receipt();
			echo $fn_type_of_receipt->view_fn_type_of_receipt($db, $e, $library_class, $view, $page);
		}
	}

	function hal_fn_type_of_payment($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'edit') {
				include_once("src/setting_account/fn_type_of_payment_edit.php");
				$edit = new edit_fn_type_of_payment();
				echo $edit->edit_view($db, $e, $view);
			} else {
				include_once("src/setting_account/fn_type_of_payment.php");
				$fn_type_of_payment = new fn_type_of_payment();
				echo $fn_type_of_payment->view_fn_type_of_payment($db, $e, $view, $page);
			}
		} else {
			include_once("src/setting_account/fn_type_of_payment.php");
			$fn_type_of_payment = new fn_type_of_payment();
			echo $fn_type_of_payment->view_fn_type_of_payment($db, $e, $library_class, $view, $page);
		}
	}

	function hal_wh_type_of_receipt($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'edit') {
				include_once("src/setting_account/wh_type_of_receipt_edit.php");
				$edit = new edit_wh_type_of_receipt();
				echo $edit->edit_view($db, $e, $view);
			} else {
				include_once("src/setting_account/wh_type_of_receipt.php");
				$wh_type_of_receipt = new wh_type_of_receipt();
				echo $wh_type_of_receipt->view_wh_type_of_receipt($db, $e, $view, $page);
			}
		} else {
			include_once("src/setting_account/wh_type_of_receipt.php");
			$wh_type_of_receipt = new wh_type_of_receipt();
			echo $wh_type_of_receipt->view_wh_type_of_receipt($db, $e, $library_class, $view, $page);
		}
	}

	function hal_wh_type_of_out($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'edit') {
				include_once("src/setting_account/wh_type_of_out_edit.php");
				$edit = new edit_wh_type_of_out();
				echo $edit->edit_view($db, $e, $view);
			} else {
				include_once("src/setting_account/wh_type_of_out.php");
				$wh_type_of_out = new wh_type_of_out();
				echo $wh_type_of_out->view_wh_type_of_out($db, $e, $view, $page);
			}
		} else {
			include_once("src/setting_account/wh_type_of_out.php");
			$wh_type_of_out = new wh_type_of_out();
			echo $wh_type_of_out->view_wh_type_of_out($db, $e, $library_class, $view, $page);
		}
	}

	function hal_cluster($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/cluster/new.php");
				$cluster = new new_cluster();
				echo $cluster->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/cluster/edit.php");
				$edit = new edit_cluster();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/cluster/view.php");
				$view_data = new view_cluster();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/cluster/cluster.php");
				$cluster = new cluster();
				echo $cluster->view_cluster($db, $e, $view, $page);
			}
		} else {
			include_once("src/cluster/cluster.php");
			$cluster = new cluster();
			echo $cluster->view_cluster($db, $e, $library_class, $view, $page);
		}
	}

	function hal_rt($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/rt/new.php");
				$rt = new new_rt();
				echo $rt->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/rt/edit.php");
				$edit = new edit_rt();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/rt/view.php");
				$view_data = new view_rt();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/rt/rt.php");
				$rt = new rt();
				echo $rt->view_rt($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/rt/rt.php");
			$rt = new rt();
			echo $rt->view_rt($db, $e, $library_class, $view, $page);
		}
	}

	function hal_house_owner($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/house_owner/new.php");
				$house_owner = new new_house_owner();
				echo $house_owner->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/house_owner/edit.php");
				$edit = new edit_house_owner();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/house_owner/view.php");
				$view_data = new view_house_owner();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/house_owner/house_owner.php");
				$house_owner = new house_owner();
				echo $house_owner->view_house_owner($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/house_owner/house_owner.php");
			$house_owner = new house_owner();
			echo $house_owner->view_house_owner($db, $e, $library_class, $view, $page);
		}
	}

	function hal_population($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/population/new.php");
				$population = new new_population();
				echo $population->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/population/edit.php");
				$edit = new edit_population();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/population/view.php");
				$view_data = new view_population();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/population/population.php");
				$population = new population();
				echo $population->view_population($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/population/population.php");
			$population = new population();
			echo $population->view_population($db, $e, $library_class, $view, $page);
		}
	}

	function hal_dues_type($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/dues_type/new.php");
				$new = new new_dues_type();
				echo $new->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/dues_type/edit.php");
				$edit = new edit_dues_type();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/dues_type/view.php");
				$view_data = new view_dues_type();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/dues_type/dues_type.php");
				$dues_type = new dues_type();
				echo $dues_type->list_dues_type($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/dues_type/dues_type.php");
			$dues_type = new dues_type();
			echo $dues_type->list_dues_type($db, $e, $library_class, $view, $page);
		}
	}

	function hal_unit($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/unit/new.php");
				$unit = new new_unit();
				echo $unit->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/unit/edit.php");
				$edit = new edit_unit();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/unit/view.php");
				$view_data = new view_unit();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/unit/unit.php");
				$unit = new unit();
				echo $unit->view_unit($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/unit/unit.php");
			$unit = new unit();
			echo $unit->view_unit($db, $e, $library_class, $view, $page);
		}
	}

	function hal_type_of_receipt_wh($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/type_of_receipt_wh/new.php");
				$type_of_receipt_wh = new new_type_of_receipt_wh();
				echo $type_of_receipt_wh->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/type_of_receipt_wh/edit.php");
				$edit = new edit_type_of_receipt_wh();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/type_of_receipt_wh/view.php");
				$view_data = new view_type_of_receipt_wh();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/type_of_receipt_wh/type_of_receipt_wh.php");
				$type_of_receipt_wh = new type_of_receipt_wh();
				echo $type_of_receipt_wh->view_type_of_receipt_wh($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/type_of_receipt_wh/type_of_receipt_wh.php");
			$type_of_receipt_wh = new type_of_receipt_wh();
			echo $type_of_receipt_wh->view_type_of_receipt_wh($db, $e, $library_class, $view, $page);
		}
	}

	function hal_type_of_out_wh($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/type_of_out_wh/new.php");
				$type_of_out_wh = new new_type_of_out_wh();
				echo $type_of_out_wh->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/type_of_out_wh/edit.php");
				$edit = new edit_type_of_out_wh();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/type_of_out_wh/view.php");
				$view_data = new view_type_of_out_wh();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/type_of_out_wh/type_of_out_wh.php");
				$type_of_out_wh = new type_of_out_wh();
				echo $type_of_out_wh->view_type_of_out_wh($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/type_of_out_wh/type_of_out_wh.php");
			$type_of_out_wh = new type_of_out_wh();
			echo $type_of_out_wh->view_type_of_out_wh($db, $e, $library_class, $view, $page);
		}
	}

	function hal_house_size($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/house_size/new.php");
				$house_size = new new_house_size();
				echo $house_size->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/house_size/edit.php");
				$edit = new edit_house_size();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/house_size/view.php");
				$view_data = new view_house_size();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/house_size/house_size.php");
				$house_size = new house_size();
				echo $house_size->view_house_size($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/house_size/house_size.php");
			$house_size = new house_size();
			echo $house_size->view_house_size($db, $e, $library_class, $view, $page);
		}
	}

	function hal_position($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/position/new.php");
				$position = new new_position();
				echo $position->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/position/edit.php");
				$edit = new edit_position();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/position/view.php");
				$view_data = new view_position();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/position/position.php");
				$position = new position();
				echo $position->view_position($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/position/position.php");
			$position = new position();
			echo $position->view_position($db, $e, $library_class, $view, $page);
		}
	}

	function hal_type_of_receipt($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/type_of_receipt/new.php");
				$type_of_receipt = new new_type_of_receipt();
				echo $type_of_receipt->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/type_of_receipt/edit.php");
				$edit = new edit_type_of_receipt();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/type_of_receipt/view.php");
				$view_data = new view_type_of_receipt();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/type_of_receipt/type_of_receipt.php");
				$type_of_receipt = new type_of_receipt();
				echo $type_of_receipt->view_type_of_receipt($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/type_of_receipt/type_of_receipt.php");
			$type_of_receipt = new type_of_receipt();
			echo $type_of_receipt->view_type_of_receipt($db, $e, $library_class, $view, $page);
		}
	}

	function hal_type_of_payment($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/type_of_payment/new.php");
				$type_of_payment = new new_type_of_payment();
				echo $type_of_payment->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/type_of_payment/edit.php");
				$edit = new edit_type_of_payment();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/type_of_payment/view.php");
				$view_data = new view_type_of_payment();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/type_of_payment/type_of_payment.php");
				$type_of_payment = new type_of_payment();
				echo $type_of_payment->view_type_of_payment($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/type_of_payment/type_of_payment.php");
			$type_of_payment = new type_of_payment();
			echo $type_of_payment->view_type_of_payment($db, $e, $library_class, $view, $page);
		}
	}

	function hal_warehouse($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/warehouse/new.php");
				$warehouse = new new_warehouse();
				echo $warehouse->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/warehouse/edit.php");
				$edit = new edit_warehouse();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/warehouse/view.php");
				$view_data = new view_warehouse();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/warehouse/warehouse.php");
				$warehouse = new warehouse();
				echo $warehouse->view_warehouse($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/warehouse/warehouse.php");
			$warehouse = new warehouse();
			echo $warehouse->view_warehouse($db, $e, $library_class, $view, $page);
		}
	}

	function hal_item($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/item/new.php");
				$item = new new_item();
				echo $item->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/item/edit.php");
				$edit = new edit_item();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/item/view.php");
				$view_data = new view_item();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/item/item.php");
				$item = new item();
				echo $item->view_item($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/item/item.php");
			$item = new item();
			echo $item->view_item($db, $e, $library_class, $view, $page);
		}
	}

	function hal_bank_cash($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/bank_cash/new.php");
				$bank_cash = new new_bank_cash();
				echo $bank_cash->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/bank_cash/edit.php");
				$edit = new edit_bank_cash();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/bank_cash/view.php");
				$view_data = new view_bank_cash();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/bank_cash/bank_cash.php");
				$bank_cash = new bank_cash();
				echo $bank_cash->view_bank_cash($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/bank_cash/bank_cash.php");
			$bank_cash = new bank_cash();
			echo $bank_cash->view_bank_cash($db, $e, $library_class, $view, $page);
		}
	}

	function hal_input_saldo($db, $e, $library_class, $get, $view, $page)
	{
		include_once("src/input_saldo/input_saldo.php");
		$input_saldo = new input_saldo();
		echo $input_saldo->view_input_saldo();
	}

	function hal_type_of_work($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/type_of_work/new.php");
				$type_of_work = new new_type_of_work();
				echo $type_of_work->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/type_of_work/edit.php");
				$edit = new edit_type_of_work();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/type_of_work/view.php");
				$view_data = new view_type_of_work();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/type_of_work/type_of_work.php");
				$type_of_work = new type_of_work();
				echo $type_of_work->view_type_of_work($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/type_of_work/type_of_work.php");
			$type_of_work = new type_of_work();
			echo $type_of_work->view_type_of_work($db, $e, $library_class, $view, $page);
		}
	}

	function hal_employee($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/employee/new.php");
				$employee = new new_employee();
				echo $employee->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/employee/edit.php");
				$edit = new edit_employee();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/employee/view.php");
				$view_data = new view_employee();
				echo $view_data->data_view($db, $e, $view);
			} else if ($get == 'access' && !empty($view)) {
				include_once("src/employee/access.php");
				$access = new access_employee();
				echo $access->access_view($db, $e, $view);
			} else {
				include_once("src/employee/employee.php");
				$employee = new employee();
				echo $employee->view_employee($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/employee/employee.php");
			$employee = new employee();
			echo $employee->view_employee($db, $e, $library_class, $view, $page);
		}
	}

	function hal_coordinator($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/coordinator/new.php");
				$coordinator = new new_coordinator();
				echo $coordinator->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/coordinator/edit.php");
				$edit = new edit_coordinator();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/coordinator/view.php");
				$view_data = new view_coordinator();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/coordinator/coordinator.php");
				$coordinator = new coordinator();
				echo $coordinator->view_coordinator($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/coordinator/coordinator.php");
			$coordinator = new coordinator();
			echo $coordinator->view_coordinator($db, $e, $library_class, $view, $page);
		}
	}

	function hal_contractor($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/contractor/new.php");
				$contractor = new new_contractor();
				echo $contractor->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/contractor/edit.php");
				$edit = new edit_contractor();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/contractor/view.php");
				$view_data = new view_contractor();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/contractor/contractor.php");
				$contractor = new contractor();
				echo $contractor->view_contractor($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/contractor/contractor.php");
			$contractor = new contractor();
			echo $contractor->view_contractor($db, $e, $library_class, $view, $page);
		}
	}

	function hal_cash_receipt($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/cash_receipt/new.php");
				$cash_receipt = new new_cash_receipt();
				echo $cash_receipt->new_view($db, $e, $library_class);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/cash_receipt/edit.php");
				$edit = new edit_cash_receipt();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/cash_receipt/view.php");
				$view_data = new view_cash_receipt();
				echo $view_data->data_view($db, $e, $library_class, $view);
			} else if ($get == 'get_invoice') {
				include_once("src/cash_receipt/get_invoice.php");
				$view_data = new get_invoice();
				echo $view_data->view_get_invoice($db, $e, $library_class, $view, $page);
			} else if ($get == 'invoice' && !empty($view)) {
				include_once("src/cash_receipt/new_invoice.php");
				$new_invoice = new new_invoice_cash_receipt();
				echo $new_invoice->new_invoice_view($db, $e, $library_class, $view);
			} else if ($get == 'view_invoice' && !empty($view)) {
				include_once("src/cash_receipt/view_invoice.php");
				$view_data = new view_cash_receipt_invoice();
				echo $view_data->data_view($db, $e, $library_class, $view);
			} else if ($get == 'edit_ipl' && !empty($view)) {
				include_once("src/cash_receipt/edit_ipl.php");
				$edit_data = new edit_cash_receipt_ipl();
				echo $edit_data->data_edit($db, $e, $view);
			} else if ($get == 'view_ipl' && !empty($view)) {
				include_once("src/cash_receipt/view_ipl.php");
				$view_data = new view_cash_receipt_ipl();
				echo $view_data->data_view($db, $e, $library_class, $view);
			} else if ($get == 'upload') {
				include_once("src/cash_receipt/upload.php");
				$view_data = new view_upload();
				echo $view_data->data_view($db, $e, $library_class);
			} else {
				include_once("src/cash_receipt/cash_receipt.php");
				$cash_receipt = new cash_receipt();
				echo $cash_receipt->view_cash_receipt($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/cash_receipt/cash_receipt.php");
			$cash_receipt = new cash_receipt();
			echo $cash_receipt->view_cash_receipt($db, $e, $library_class, $view, $page);
		}
	}

	function hal_cash_payment($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/cash_payment/new.php");
				$cash_payment = new new_cash_payment();
				echo $cash_payment->new_view($db, $e, $library_class);
			} else if ($get == 'new_pembayaran') {
				include_once("src/cash_payment/new_pembayaran.php");
				$cash_payment = new new_pembayaran_cash_payment();
				echo $cash_payment->new_pembayaran_view($db, $e, $library_class);
			} else if ($get == 'new_payroll') {
				include_once("src/cash_payment/new_payroll.php");
				$cash_payment = new new_payroll_cash_payment();
				echo $cash_payment->new_payroll_view($db, $e, $library_class);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/cash_payment/edit.php");
				$edit = new edit_cash_payment();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/cash_payment/view.php");
				$view_data = new view_cash_payment();
				echo $view_data->data_view($db, $e, $library_class, $view);
			} else if ($get == 'get_purchasing') {
				include_once("src/cash_payment/get_purchasing.php");
				$view_data = new get_purchasing();
				echo $view_data->view_get_purchasing($db, $e, $library_class, $view, $page);
			} else if ($get == 'purchasing' && !empty($view)) {
				include_once("src/cash_payment/new_purchasing.php");
				$new_purchasing = new new_purchasing_cash_payment();
				echo $new_purchasing->new_purchasing_view($db, $e, $library_class, $view);
			} else if ($get == 'view_purchasing' && !empty($view)) {
				include_once("src/cash_payment/view_purchasing.php");
				$view_data = new view_cash_receipt_invoice();
				echo $view_data->data_view($db, $e, $library_class, $view);
			} else {
				include_once("src/cash_payment/cash_payment.php");
				$cash_payment = new cash_payment();
				echo $cash_payment->view_cash_payment($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/cash_payment/cash_payment.php");
			$cash_payment = new cash_payment();
			echo $cash_payment->view_cash_payment($db, $e, $library_class, $view, $page);
		}
	}

	function hal_invoice($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/invoice/new.php");
				$invoice = new new_invoice();
				echo $invoice->new_view($db, $e, $library_class);
			} else if ($get == 'new_all') {
				include_once("src/invoice/new_all.php");
				$invoice_all = new new_invoice_all();
				echo $invoice_all->new_view($db, $e, $library_class);
			} else if ($get == 'new_dues') {
				include_once("src/invoice/new_dues.php");
				$invoice_dues = new new_invoice_dues();
				echo $invoice_dues->new_view($db, $e, $library_class);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/invoice/edit.php");
				$edit = new edit_invoice();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/invoice/view.php");
				$view_data = new view_invoice();
				echo $view_data->data_view($db, $e, $library_class, $view);
			} else if ($get == 'oper_link' && !empty($view)) {
				include_once("src/invoice/oper_link.php");
				$view_data = new view_oper_link();
				echo $view_data->data_view($db, $e, $view);
			} else if ($get == 'upload') {
				include_once("src/invoice/upload_invoice.php");
				$upload_data = new upload_invoice();
				echo $upload_data->view_upload_invoice($db, $e, $view);
			} else {
				include_once("src/invoice/invoice.php");
				$invoice = new invoice();
				echo $invoice->view_invoice($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/invoice/invoice.php");
			$invoice = new invoice();
			echo $invoice->view_invoice($db, $e, $library_class, $view, $page);
		}
	}

	function hal_request($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/request/new.php");
				$request = new new_request();
				echo $request->new_view($db, $e, $library_class);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/request/edit.php");
				$edit = new edit_request();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/request/view.php");
				$view_data = new view_request();
				echo $view_data->data_view($db, $e, $library_class, $view);
			} else {
				include_once("src/request/request.php");
				$request = new request();
				echo $request->view_request($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/request/request.php");
			$request = new request();
			echo $request->view_request($db, $e, $library_class, $view, $page);
		}
	}

	function hal_maintenance($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/maintenance/new.php");
				$maintenance = new new_maintenance();
				echo $maintenance->new_view($db, $e, $library_class);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/maintenance/edit.php");
				$edit = new edit_maintenance();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/maintenance/view.php");
				$view_data = new view_maintenance();
				echo $view_data->data_view($db, $e, $library_class, $view);
			} else {
				include_once("src/maintenance/maintenance.php");
				$maintenance = new maintenance();
				echo $maintenance->view_maintenance($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/maintenance/maintenance.php");
			$maintenance = new maintenance();
			echo $maintenance->view_maintenance($db, $e, $library_class, $view, $page);
		}
	}

	function hal_purchasing($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new_manual') {
				include_once("src/purchasing/new_manual.php");
				$purchasing = new new_purchasing_manual();
				echo $purchasing->new_manual_view($db, $e, $library_class, $view);
			} else if ($get == 'new') {
				include_once("src/purchasing/new.php");
				$purchasing = new new_purchasing();
				echo $purchasing->new_view($db, $e, $library_class, $view);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/purchasing/edit.php");
				$edit = new edit_purchasing();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/purchasing/view.php");
				$view_data = new view_purchasing();
				echo $view_data->data_view($db, $e, $library_class, $view);
			} else if ($get == 'list_request') {
				include_once("src/purchasing/list_request.php");
				$list_request_data = new list_request_request();
				echo $list_request_data->data_list_request($db, $e, $library_class, $page);
			} else {
				include_once("src/purchasing/purchasing.php");
				$purchasing = new purchasing();
				echo $purchasing->view_purchasing($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/purchasing/purchasing.php");
			$purchasing = new purchasing();
			echo $purchasing->view_purchasing($db, $e, $library_class, $view, $page);
		}
	}

	function hal_inv_purchasing($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/inv_purchasing/new.php");
				$inv_purchasing = new new_inv_purchasing();
				echo $inv_purchasing->new_view($db, $e, $library_class, $view, $page);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/inv_purchasing/view.php");
				$view_data = new view_inv_purchasing();
				echo $view_data->data_view_inv_purchasing($db, $e, $library_class, $view);
			} else {
				include_once("src/inv_purchasing/inv_purchasing.php");
				$inv_purchasing = new  inv_purchasing();
				echo $inv_purchasing->view_inv_purchasing($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/inv_purchasing/inv_purchasing.php");
			$inv_purchasing = new inv_purchasing();
			echo $inv_purchasing->view_inv_purchasing($db, $e, $library_class, $view, $page);
		}
	}

	function hal_po_maintenance($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/po_maintenance/new.php");
				$po_maintenance = new new_po_maintenance();
				echo $po_maintenance->new_view($db, $e, $library_class);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/po_maintenance/edit.php");
				$edit = new edit_po_maintenance();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/po_maintenance/view.php");
				$view_data = new view_po_maintenance();
				echo $view_data->data_view($db, $e, $library_class, $view);
			} else {
				include_once("src/po_maintenance/po_maintenance.php");
				$po_maintenance = new po_maintenance();
				echo $po_maintenance->view_po_maintenance($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/po_maintenance/po_maintenance.php");
			$po_maintenance = new po_maintenance();
			echo $po_maintenance->view_po_maintenance($db, $e, $library_class, $view, $page);
		}
	}

	function hal_item_receipt($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/item_receipt/new.php");
				$item_receipt = new new_item_receipt();
				echo $item_receipt->new_view($db, $e, $library_class);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/item_receipt/edit.php");
				$edit = new edit_item_receipt();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/item_receipt/view.php");
				$view_data = new view_item_receipt();
				echo $view_data->data_view($db, $e, $library_class, $view);
			} else if ($get == 'get_item_receipt') {
				include_once("src/item_receipt/get_item_receipt.php");
				$view_data = new get_item_receipt();
				echo $view_data->view_get_item_receipt($db, $e, $library_class, $view, $page);
			} else if ($get == 'item_receipt' && !empty($view)) {
				include_once("src/item_receipt/new_item_receipt.php");
				$new_item_receipt = new new_item_receipt_item_receipt();
				echo $new_item_receipt->new_item_receipt_view($db, $e, $library_class, $view);
			} else if ($get == 'view_item_receipt' && !empty($view)) {
				include_once("src/item_receipt/view_item_receipt.php");
				$view_data = new view_cash_receipt_invoice();
				echo $view_data->data_view($db, $e, $library_class, $view);
			} else {
				include_once("src/item_receipt/item_receipt.php");
				$item_receipt = new item_receipt();
				echo $item_receipt->view_item_receipt($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/item_receipt/item_receipt.php");
			$item_receipt = new item_receipt();
			echo $item_receipt->view_item_receipt($db, $e, $library_class, $view, $page);
		}
	}

	function hal_item_out($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/item_out/new.php");
				$item_out = new new_item_out();
				echo $item_out->new_view($db, $e, $library_class);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/item_out/edit.php");
				$edit = new edit_item_out();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/item_out/view.php");
				$view_data = new view_item_out();
				echo $view_data->data_view($db, $e, $library_class, $view);
			} else if ($get == 'get_item_out') {
				include_once("src/item_out/get_item_out.php");
				$view_data = new get_item_out();
				echo $view_data->view_get_item_out($db, $e, $library_class, $view, $page);
			} else if ($get == 'item_out' && !empty($view)) {
				include_once("src/item_out/new_item_out.php");
				$new_item_out = new new_item_out_item_out();
				echo $new_item_out->new_item_out_view($db, $e, $library_class, $view);
			} else if ($get == 'view_item_out' && !empty($view)) {
				include_once("src/item_out/view_item_out.php");
				$view_data = new view_cash_out_invoice();
				echo $view_data->data_view($db, $e, $library_class, $view);
			} else {
				include_once("src/item_out/item_out.php");
				$item_out = new item_out();
				echo $item_out->view_item_out($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/item_out/item_out.php");
			$item_out = new item_out();
			echo $item_out->view_item_out($db, $e, $library_class, $view, $page);
		}
	}

	function hal_journal_voucher($db, $e, $library_class, $get, $view, $page)
	{
		if (!empty($get)) {
			if ($get == 'new') {
				include_once("src/journal_voucher/new.php");
				$journal_voucher = new new_journal_voucher();
				echo $journal_voucher->new_view($db, $e);
			} else if ($get == 'edit' && !empty($view)) {
				include_once("src/journal_voucher/edit.php");
				$edit = new edit_journal_voucher();
				echo $edit->edit_view($db, $e, $view);
			} else if ($get == 'view' && !empty($view)) {
				include_once("src/journal_voucher/view.php");
				$view_data = new view_journal_voucher();
				echo $view_data->data_view($db, $e, $view);
			} else {
				include_once("src/journal_voucher/journal_voucher.php");
				$journal_voucher = new journal_voucher();
				echo $journal_voucher->view_journal_voucher($db, $e, $library_class, $view, $page);
			}
		} else {
			include_once("src/journal_voucher/journal_voucher.php");
			$journal_voucher = new journal_voucher();
			echo $journal_voucher->view_journal_voucher($db, $e, $library_class, $view, $page);
		}
	}

	function hal_tutup_buku($db, $e, $library_class)
	{
		include_once("src/tutup_buku/tutup_buku.php");
		$tutup_buku = new tutup_buku();
		echo $tutup_buku->view_tutup_buku($db, $e, $library_class);
	}

	function hal_monitoring_purchasing($db, $e, $library_class, $get, $view, $page)
	{
		include_once("src/monitoring_purchasing/monitoring_purchasing.php");
		$monitoring_purchasing = new monitoring_purchasing();
		echo $monitoring_purchasing->view_monitoring_purchasing($db, $e, $library_class, $view, $page);
	}

	function hal_monitoring_invoice($db, $e, $library_class, $get, $view, $page)
	{
		include_once("src/monitoring_invoice/monitoring_invoice.php");
		$monitoring_invoice = new monitoring_invoice();
		echo $monitoring_invoice->view_monitoring_invoice($db, $e, $library_class, $view, $page);
	}

	function hal_report_finance_balance($db, $e, $library_class, $get, $view, $page)
	{
		include_once("src/report_finance_balance/report_finance_balance.php");
		$report_finance_balance = new report_finance_balance();
		echo $report_finance_balance->view_report_finance_balance($db, $e, $library_class, $view, $page);
	}

	function hal_report_bank_cash($db, $e, $library_class, $get, $view, $page)
	{
		include_once("src/report_bank_cash/report_bank_cash.php");
		$report_bank_cash = new report_bank_cash();
		echo $report_bank_cash->view_report_bank_cash($db, $e, $library_class, $view, $page);
	}

	function hal_report_cash_receipt($db, $e, $library_class, $get, $view, $page)
	{
		include_once("src/report_cash_receipt/report_cash_receipt.php");
		$report_cash_receipt = new report_cash_receipt();
		echo $report_cash_receipt->view_report_cash_receipt($db, $e, $library_class, $view, $page);
	}

	function hal_report_cash_payment($db, $e, $library_class, $get, $view, $page)
	{
		include_once("src/report_cash_payment/report_cash_payment.php");
		$report_cash_payment = new report_cash_payment();
		echo $report_cash_payment->view_report_cash_payment($db, $e, $library_class, $view, $page);
	}

	function hal_report_inventory($db, $e, $library_class, $get, $view, $page)
	{
		include_once("src/report_inventory/report_inventory.php");
		$report_inventory = new report_inventory();
		echo $report_inventory->view_report_inventory($db, $e, $library_class, $view, $page);
	}

	function hal_error_page($db, $e, $library_class, $get, $view, $page)
	{
		include_once("src/error_page/error_page.php");
		$error_page = new error_page();
		echo $error_page->view_error_page($db, $e);
	}

	function data_html_atas()
	{
		echo '<div id="main">';
	}

	function data_html_tengah()
	{
		echo '<div class="main-content container-fluid margin-top"><div class="row">';
	}

	function footer()
	{
		echo '';
	}

	function data_html_bawah()
	{
		echo '</div></div>';
	}
}
