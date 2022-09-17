<?php

use Tygh\Registry;
use Tygh\Settings;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}
// fn_print_r($_REQUEST,$_POST,$_GET);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // fn_trusted_vars('shop_data', 'merchant_data');
    // $suffix = '';

    if ($mode == 'authenticate') {
        // fn_print_die($_REQUEST);
        // $suffix = 'add';
        $data['company_id'] =  Registry::get('runtime.company_id') ? Registry::get('runtime.company_id') : $_REQUEST['merchant_data']['company_id'];
        $data['ebay_dev_id'] = $_REQUEST['merchant_data']['ebay_dev_id']; //Registry::get('addons.wk_etsy_connector.etsy_api_key');
        $data['app_id'] =  $_REQUEST['merchant_data']['app_id']; //Registry::get('addons.wk_etsy_connector.etsy_shared_secret_key');
        $data['cert_id'] = isset($_REQUEST['merchant_data']['cert_id']) && !empty($_REQUEST['merchant_data']['cert_id']) ? $_REQUEST['merchant_data']['cert_id'] : '';
        $data['oauth_token'] = isset($_REQUEST['merchant_data']['oauth_token']) && !empty($_REQUEST['merchant_data']['oauth_token']) ? $_REQUEST['merchant_data']['oauth_token'] : '';
        $data['shop_name']=isset($_REQUEST['merchant_data']['shop_name']) && !empty($_REQUEST['merchant_data']['shop_name']) ? $_REQUEST['merchant_data']['shop_name'] : '';
        $data['mode']=isset($_REQUEST['merchant_data']['mode']) && !empty($_REQUEST['merchant_data']['mode']) ? $_REQUEST['merchant_data']['mode'] : '';
        $user_exists = db_get_field("SELECT `ebay_dev_id` FROM ?:wk_ebay_account_list WHERE ebay_dev_id = ?s ", $data['ebay_dev_id']);
        if ($user_exists) {
            fn_set_notification("N", __("notice"), __("account_already_exist_for_vendor"), 'S');
            return array(CONTROLLER_STATUS_REDIRECT, 'wk_ebay.add');
        } else {
            $authenticate = fn_wk_ebay_connector_authenticate_user($_REQUEST['merchant_data']);
            if($authenticate == true){
                $id=db_query("INSERT INTO ?:wk_ebay_account_list ?e", $data);
            }
            else{
                return array(CONTROLLER_STATUS_REDIRECT, 'wk_ebay.add');
            }

            return array(CONTROLLER_STATUS_REDIRECT, 'wk_ebay.update&id=' . $id);

        }
        // $ids = db_get_field("SELECT id FROM ?:wk_etsy_account_list WHERE company_id = ?i AND shop_id = ?s", $company_id, $shop_id);
    }
    if($mode == 'update')
    {
        $id = isset($_REQUEST['id']) && !empty($_REQUEST['id']) ?$_REQUEST['id']:0;
        if($id){
            $merchant_data = fn_get_ebay_account_data($id);
            if($merchant_data && isset($merchant_data['ebay_dev_id']) && !empty($merchant_data['ebay_dev_id'])){
                if(isset($_REQUEST['merchant_data']) && !empty($_REQUEST['merchant_data']) && $merchant_data){
                    $_REQUEST['merchant_data']['ebay_dev_id'] = $merchant_data['ebay_dev_id'];
                    $_REQUEST['merchant_data']['default_payment'] = $_REQUEST['merchant_data']['default_payment'];
                    $_REQUEST['merchant_data']['default_shipping'] = $_REQUEST['merchant_data']['default_shipping'];
                    db_query("UPDATE ?:wk_ebay_account_list SET ?u WHERE id = ?i",$_REQUEST['merchant_data'],$merchant_data['id']);
                }
                //fn_update_etsy_shop_info($merchant_data , $_REQUEST['shop_data']);
            }
        }
        return array(CONTROLLER_STATUS_REDIRECT, 'wk_ebay.update&id=' . $id);
    }

    if($mode == 'import_order'){
        unset(Tygh::$app['session']['cart']);
        if (!empty($_REQUEST['account_id']) && !empty($_REQUEST['order_id'])) {
            $shop_id = $_REQUEST['account_id'];
            if (!empty($_REQUEST['order_id'])) {
                $order_id = fn_wk_ebay_create_cscart_order($shop_id, $_REQUEST['order_id']);
                if(!empty($order_id)) {

                    fn_set_notification('N', 'notice', __('order_place'));
                }

            }


            return [CONTROLLER_STATUS_REDIRECT, 'wk_ebay.order_manage&account_id='.$shop_id];
        } else {
            return [CONTROLLER_STATUS_REDIRECT, 'wk_ebay.manage'];
        }

    }

    if($mode == 'm_import_orders'){
        unset(Tygh::$app['session']['cart']);
        if (!empty($_REQUEST['account_id']) && !empty($_REQUEST['map_ids'])) {
            $account_id = $_REQUEST['account_id'];
            $order_arr = $_REQUEST['map_ids'];
            $total_order = count($order_arr);
            foreach ($order_arr as $key => $orderId) {
                unset(Tygh::$app['session']['cart']);
                $order_id = @fn_wk_ebay_create_cscart_order($account_id, $orderId);

            }
            fn_set_notification('N', 'notice', __('order_place'));

            return array(CONTROLLER_STATUS_REDIRECT, 'wk_shopify.order_manage&account_id='.$account_id);
        } else {
            return [CONTROLLER_STATUS_REDIRECT, 'wk_shopify.manage'];
        }

    }

    if ($mode == 'category_map' && isset($_REQUEST['account_id']) && !empty($_REQUEST['account_id'])) {

        if(empty( $_REQUEST['category_name'] )){
            fn_set_notification('N', 'notice', __('please_select_the_category'));
        }else{
            $res = fn_wk_ebay_category_map($_REQUEST);
        }

            return [CONTROLLER_STATUS_REDIRECT, 'wk_ebay.category_map&account_id='.$_REQUEST['account_id']];
        }

    if ($mode == 'delete_category_map') {
        if (isset($_REQUEST['account_id']) && !empty($_REQUEST['account_id']) && isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
            db_query('DELETE FROM ?:wk_ebay_category_map WHERE account_id = ?i AND id = ?i', $_REQUEST['account_id'], $_REQUEST['id']);

            return [CONTROLLER_STATUS_REDIRECT, 'wk_ebay.category_map&account_id='.$_REQUEST['account_id']];
        } else {
              return [CONTROLLER_STATUS_REDIRECT, 'wk_ebay.manage'];
            }
    }


}
if($mode == "notify")
{
file_put_contents("request-".rand().".txt",json_encode($_REQUEST));
file_put_contents("post-".rand().".txt",json_encode($_POST));
file_put_contenst("get-".rand().".txt",json_encode($_GET));
	
}

if ($mode == 'authcheck'){
    $code = $_REQUEST['code'];
    $expires_in = $_REQUEST['expires_in'];

    $clientId = Registry::get("addons.wk_ebay_connector.ebay_appId");
    $redirectUri = Registry::get("addons.wk_ebay_connector.ebay_redirectName");
    $devId = Registry::get("addons.wk_ebay_connector.ebay_devId");
    $certId = Registry::get("addons.wk_ebay_connector.ebay_certId");
	$csCart_defaultCategory = Registry::get("addons.wk_ebay_connector.csCart_defaultCategory");
    $ebayMode = Registry::get("addons.wk_ebay_connector.ebay_mode");
    $url = "https://api.ebay.com/identity/v1/oauth2/token";
    if ($ebayMode == "S")
    {
        $url = "https://api.sandbox.ebay.com/identity/v1/oauth2/token";
    }

    $data = [
        "grant_type" => "authorization_code",
        "redirect_uri" => $redirectUri,
        "code" => $code
    ];

    $curlSecondHandler = curl_init();

    curl_setopt_array($curlSecondHandler, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode($clientId . ':' . $certId)
        ],
    ]);
	


    $response = curl_exec($curlSecondHandler);
    curl_close($curlSecondHandler);
    $tokens = json_decode($response);
    $access_token = $tokens->access_token;
    $refresh_token = $tokens->refresh_token;
    $refresh_token_expires_in = $tokens->refresh_token_expires_in;

    $data['company_id'] =  Registry::get('runtime.company_id') ? Registry::get('runtime.company_id') : 45455454545454545454;
    $data['ebay_dev_id'] = $devId;
    $data['app_id'] =  $clientId;
	$data['default_cscart_category_id'] =  $csCart_defaultCategory;
    $data['cert_id'] = $certId;
    $data['oauth_token'] = $access_token;
    $data['refresh_token'] = $refresh_token;
    $data['expired_at'] = time() + $refresh_token_expires_in;
    $data['token_created_at'] = time();
    $data['token_updated_at'] = time();
    $data['shop_name']="Shop ". rand();
    $data['mode']=$ebayMode;
    $user_exists = db_get_field("SELECT * FROM ?:wk_ebay_account_list WHERE company_id = ?s ", $data['company_id']);

    if ($user_exists) {

		$update['oauth_token'] = $access_token;
		
    $update['refresh_token'] = $refresh_token;
    $update['expired_at'] = time() + $refresh_token_expires_in;
		
                $update['token_updated_at'] = time();
		    $update['token_updated_at'] = time();

                if(db_query("UPDATE ?:wk_ebay_account_list SET ?u WHERE id = ?i",$update,$user_exists)){
				fn_set_notification("N", __("notice"), "Account Token Updated", 'S');
        			return array(CONTROLLER_STATUS_REDIRECT, 'wk_ebay.manage');
				}
	
        
    } else {
        $authenticate = fn_wk_ebay_connector_authenticate_user($data);
        if($authenticate == true){
            $id=db_query("INSERT INTO ?:wk_ebay_account_list ?e", $data);
            fn_set_notification("N", __("notice"), "You Account Is Connected With eBay. It will be connected till ". date("d M Y", time() + $refresh_token_expires_in), 'S');
			fn_wk_ebay_connector_setNotifications($id);
			echo "We are loading your products...";
            return array(CONTROLLER_STATUS_REDIRECT, 'wk_ebay.manage');
        }
        else{
            fn_set_notification("N", __("notice"), "Sorry The Token is failed during test. Please Try Again", 'S');
            return array(CONTROLLER_STATUS_REDIRECT, 'wk_ebay.manage');
        }

        return array(CONTROLLER_STATUS_REDIRECT, 'wk_ebay.update&id=' . $id);

    }




}

if($mode == 'response'){
	echo "This is reponse";
	var_dump($_REQUEST);
	exit();
}

if ($mode == 'check'){
	$listing_id = $_REQUEST['id'];
    $ebay_AccountId = fn_get_ebay_account_data($_REQUEST['account_id']);
		
	fn_wk_ebay_single_product($listing_id, $ebay_AccountId);
	
	fn_print_die("Checking Error");
}
if ($mode == 'add' || $mode == 'update') {
    Registry::set(
        'navigation.tabs', array(
            'wk_general' => array(
                'title' => __('general'),
                'js' => true,
            ),

        )
    );

    if($mode == 'add')
    {
        $clientId = Registry::get("addons.wk_ebay_connector.ebay_appId");
        $redirectUri = Registry::get("addons.wk_ebay_connector.ebay_redirectName");
        $ebayMode = Registry::get("addons.wk_ebay_connector.ebay_mode");
        $url = "https://auth.ebay.com/oauth2/authorize";
		$additional_scopes = "https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/commerce.identity.readonly https://api.ebay.com/oauth/api_scope/commerce.notification.subscription https://api.ebay.com/oauth/api_scope/commerce.notification.subscription.readonly";
        $data = "$url?client_id=$clientId&response_type=code&redirect_uri=$redirectUri&scope=$additional_scopes&prompt=login";
        if ($ebayMode == "S")
        {
            $url = "https://auth.sandbox.ebay.com/oauth2/authorize";
            $data = "$url?client_id=$clientId&response_type=code&redirect_uri=$redirectUri&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/buy.order.readonly https://api.ebay.com/oauth/api_scope/buy.guest.order https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.marketplace.insights.readonly https://api.ebay.com/oauth/api_scope/commerce.catalog.readonly https://api.ebay.com/oauth/api_scope/buy.shopping.cart https://api.ebay.com/oauth/api_scope/buy.offer.auction https://api.ebay.com/oauth/api_scope/commerce.identity.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.email.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.phone.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.address.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.name.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.status.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.item.draft https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/sell.item https://api.ebay.com/oauth/api_scope/sell.reputation https://api.ebay.com/oauth/api_scope/sell.reputation.readonly https://api.ebay.com/oauth/api_scope/commerce.notification.subscription https://api.ebay.com/oauth/api_scope/commerce.notification.subscription.readonly";

        }
        header("Location: $data");
    }


    if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
        $merchant_data = fn_wk_ebay_connector_get_account_list($_REQUEST);
        // fn_print_die($merchant_data);
        if ($mode == 'update' && empty($merchant_data)) {
            return [CONTROLLER_STATUS_REDIRECT, 'wk_ebay.manage'];
        }
        $account_id = $_REQUEST['id'];
        if (!empty($merchant_data)) {
            Registry::set(
                'navigation.tabs', array(
//                    'ebay_general' => array(
//                        'title' => __('general'),
//                        'js' => true,
//                    ),

                    'product_settings' => array(
                        'title' => __('product_settings'),
                        'js' => true,
                    ),
                    'order_settings' => array(
                        'title' => __('order_settings'),
                        'js' => true,
                    ),

                ));

            $currencies = Registry::get('currencies');
            Tygh::$app['view']->assign('currencies', $currencies);
            $payment_arr = fn_get_payments();
            $shipping_arr = fn_get_shippings(true);
            Tygh::$app['view']->assign('payment_arr', $payment_arr);
            Tygh::$app['view']->assign('shipping_arr', $shipping_arr);
            Registry::get('view')->assign('merchant_data', $merchant_data);
            Registry::get('view')->assign('account_id', $account_id);

        }

    }
}
if ($mode == 'manage') {
    list($merchant_accounts, $search) = fn_wk_ebay_connector_get_account_list($_REQUEST);
    Registry::get('view')->assign('merchant_accounts', $merchant_accounts);
    Registry::get('view')->assign('search', $search);
}

if($mode == 'delete'){
    db_query("DELETE FROM ?:wk_ebay_account_list WHERE id = ?i",$_REQUEST['id']);
    return array(CONTROLLER_STATUS_REDIRECT, 'wk_ebay.manage');
}

if($mode == 'get_ebay_products')
{

}

if($mode == 'list_orders'){
    if (isset($_REQUEST['account_id']) && !empty($_REQUEST['account_id'])) {
        $params = $_REQUEST;

        list($orders, $search) = fn_wk_ebay_list_orders($_REQUEST);
        $synced_orders = db_get_fields('SELECT ebay_order_id FROM ?:wk_ebay_order_map WHERE account_id = ?i', $_REQUEST['account_id']);
        Tygh::$app['view']->assign('account_id', $_REQUEST['account_id']);
        Tygh::$app['view']->assign('orders', $orders);
        Tygh::$app['view']->assign('search', $search);
        Tygh::$app['view']->assign('synced_orders', $synced_orders);
    } else {
        return [CONTROLLER_STATUS_REDIRECT, 'wk_ebay.manage'];
    }

}

if ($mode == 'category_map') {
    if (isset($_REQUEST['account_id']) && !empty($_REQUEST['account_id'])) {
        $categoryMapped = fn_wk_ebay_getMappedCategory($_REQUEST['account_id']);
        $account_ebay_categories = fn_wk_ebay_all_categories($_REQUEST['account_id']);
        Tygh::$app['view']->assign('categories_mapped', $categoryMapped);
		Tygh::$app['view']->assign('isVendor', Registry::get('runtime.company_id')?1:0);
        Tygh::$app['view']->assign('ebay_categories', $account_ebay_categories);
        Tygh::$app['view']->assign('account_id', $_REQUEST['account_id']);
    }
}

if ($mode == 'order_manage') {
    if (isset($_REQUEST['account_id']) && !empty($_REQUEST['account_id'])) {
        list($orders, $search) = fn_wk_ebay_fetchOrdersByShop($_REQUEST['account_id']);

        Tygh::$app['view']->assign('orders', $orders);
        Tygh::$app['view']->assign('search', $search);
        Tygh::$app['view']->assign('account_id', $_REQUEST['account_id']);

    }
}


