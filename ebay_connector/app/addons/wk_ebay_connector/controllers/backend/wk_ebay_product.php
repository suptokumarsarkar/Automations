
<?php

use Tygh\Registry;
use Tygh\Settings;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if($mode == 'import_products'){
        fn_redirect("wk_ebay_product.import_products?account_id=".$_REQUEST['account_id']);
    }

    if($mode == 'm_map_sync'){
        $account_id = $_REQUEST['account_id'];
        $dispatch = $_REQUEST['dispatch'];
		
		$map_ids = $_REQUEST['map_ids'];
		foreach($map_ids as $productId){
		        fn_wk_ebay_import_products($productId, $_REQUEST['account_id']);
		}
        
        $_REQUEST['dispatch'] = 'wk_ebay_product.manage&account_id='.$account_id;
        // fn_redirect('wk_shopify_product.manage&account_id='.$account_id.'&pro='.$product_id);
        return [CONTROLLER_STATUS_OK, 'wk_ebay_product.manage&account_id='.$account_id];
    }


    if($mode == 'map_sync'){
        $account_id = $_REQUEST['account_id'];
        $dispatch = $_REQUEST['dispatch'];
        fn_wk_ebay_import_products($_REQUEST['product_id'], $_REQUEST['account_id']);
        
        $_REQUEST['dispatch'] = 'wk_ebay_product.manage&account_id='.$account_id;
        // fn_redirect('wk_shopify_product.manage&account_id='.$account_id.'&pro='.$product_id);
        return [CONTROLLER_STATUS_OK, 'wk_ebay_product.manage&account_id='.$account_id];

    }

}

   if($mode == 'map_sync_api'){
        $account_id = $_REQUEST['account_id'];
        $dispatch = $_REQUEST['dispatch'];
	   
        fn_wk_ebay_import_products($_REQUEST['product_id'], $_REQUEST['account_id']);
        echo json_encode(["status"=>200, "message"=>"imported"]);
	   exit();
        $_REQUEST['dispatch'] = 'wk_ebay_product.manage&account_id='.$account_id;
        // fn_redirect('wk_shopify_product.manage&account_id='.$account_id.'&pro='.$product_id);
        return [CONTROLLER_STATUS_OK, 'wk_ebay_product.manage&account_id='.$account_id];

    }


if($mode == 'manage'){
      if(isset($_REQUEST['account_id']) && !empty($_REQUEST['account_id'])){
        Registry::get('view')->assign('account_id',$_REQUEST['account_id']);
        list($product_list,$search) = fn_get_ebay_products_list($_REQUEST['account_id'],$_REQUEST);
        Registry::get('view')->assign('product_list',$product_list);
        Registry::get('view')->assign('search',$search);
    }else{
        return array(CONTROLLER_STATUS_DENIED, 'wk_ebay.manage');
    }
}



if($mode == 'import_products'){
    $merchant_data = fn_get_ebay_account_data($_REQUEST['account_id']);
    if(!empty($_REQUEST['account_id'])){

        $product_arr = [];
        $_REQUEST['redirect_url'] = '';
        $cscartProductIds = $search = array();

        list($product_arr, $search, $cscartProductIds) = fn_wk_ebay_list_products($merchant_data, $_REQUEST);
		
        Tygh::$app['view']->assign('account_id', $_REQUEST['account_id']);
        Tygh::$app['view']->assign('cscartProductIds', $cscartProductIds);
        Tygh::$app['view']->assign('product_arr', $product_arr);
        Tygh::$app['view']->assign('search', $search);
        fn_set_notification('N', 'Notice', 'Your Product Is Listed Here, Please Select Product To Import');
        } else {
            return [CONTROLLER_STATUS_OK, 'wk_shopify_product.manage'];
        }
    
}