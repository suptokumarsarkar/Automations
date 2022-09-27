<?php

use Tygh\Registry;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}
require_once __DIR__ . '/Ebay_c/autoload.php';
include 'simplehtmldom-master/simple_html_dom.php';
function fn_wk_ebay_connector_init_templater($view)
{
    //fn_wk_ebay_connector_getNotifications(4);
    //exit();

    fn_wk_ebay_connector_check_tokens();
}

function fn_wk_ebay_connector_getNotifications($accountId)
{
    $result = array();
//    fn_wk_ebay_connector_setNotifications($accountId);
    $ebay_AccountId = fn_get_ebay_account_data($accountId);

    try {
        $client = null;
        $eBayConfigData = array();

        if ($ebay_AccountId && is_array($ebay_AccountId)) {
            $eBayConfigData['ebayDevId'] = $ebay_AccountId['ebay_dev_id'];
            $eBayConfigData['ebayAppId'] = $ebay_AccountId['app_id'];
            $eBayConfigData['ebayCertId'] = $ebay_AccountId['cert_id'];
            $eBayConfigData['ebayToken'] = $ebay_AccountId['oauth_token'];
            $eBayConfigData['ebaySites'] = $ebay_AccountId['shop_name'];
            $eBayConfigData['location'] = 'https://api.ebay.com/wsapi';
            $ebayMode = Registry::get("addons.wk_ebay_connector.ebay_mode");
            if ($ebayMode == 'S') {
                $eBayConfigData['location'] = 'https://api.sandbox.ebay.com/wsapi';
            }
        }

        if ($eBayConfigData) {
            if (file_exists(__DIR__ . '/Ebay_c/autoload.php')) {
                $session = new Ebay\eBaySession(
                    $eBayConfigData['ebayDevId'],
                    $eBayConfigData['ebayAppId'],
                    $eBayConfigData['ebayCertId']
                );

                $session->token = $eBayConfigData['ebayToken'];
                $session->site = $eBayConfigData['ebaySites'];
                $session->location = $eBayConfigData['location'];
                $client = new Ebay\eBaySOAP($session);
            }
            $getEbayClient = $client;
            if ($getEbayClient) {

                $params = array(
                    'Version' => 659,
                    'PreferenceLevel' => 'User',
                );

                $results = $getEbayClient->GetNotificationPreferences($params);
                if (isset($results->Ack) && $results->Ack) {
                    $results = json_encode($results);
                    $results = json_decode($results, true);
                    $result = $results['Item'];
                }
            }

        }


    } catch (Exception $e) {
        $this->log->write('Error : ' . $e->getMessage());
        return false;
    }
}


function fn_wk_ebay_connector_setNotifications($accountId)
{
    $result = array();
    $ebay_AccountId = fn_get_ebay_account_data($accountId);

    try {
        $client = null;
        $eBayConfigData = array();

        if ($ebay_AccountId && is_array($ebay_AccountId)) {
            $eBayConfigData['ebayDevId'] = $ebay_AccountId['ebay_dev_id'];
            $eBayConfigData['ebayAppId'] = $ebay_AccountId['app_id'];
            $eBayConfigData['ebayCertId'] = $ebay_AccountId['cert_id'];
            $eBayConfigData['ebayToken'] = $ebay_AccountId['oauth_token'];
            $eBayConfigData['ebaySites'] = $ebay_AccountId['shop_name'];
            $eBayConfigData['location'] = 'https://api.ebay.com/wsapi';
            $ebayMode = Registry::get("addons.wk_ebay_connector.ebay_mode");
            if ($ebayMode == 'S') {
                $eBayConfigData['location'] = 'https://api.sandbox.ebay.com/wsapi';
            }
        }

        if ($eBayConfigData) {
            if (file_exists(__DIR__ . '/Ebay_c/autoload.php')) {
                $session = new Ebay\eBaySession(
                    $eBayConfigData['ebayDevId'],
                    $eBayConfigData['ebayAppId'],
                    $eBayConfigData['ebayCertId']
                );

                $session->token = $eBayConfigData['ebayToken'];
                $session->site = $eBayConfigData['ebaySites'];
                $session->location = $eBayConfigData['location'];
                $client = new Ebay\eBaySOAP($session);
            }
            $getEbayClient = $client;
            if ($getEbayClient) {

                $params = array(
                    'Version' => 659,
                    'ApplicationDeliveryPreferences' => [
                        "AlertEmail" => "mailto://personal.supto@gmail.com",
                        "AlertEnable" => "Disable",
                        "ApplicationEnable" => "Enable",
                        "ApplicationURL" => fn_url("index.php?dispatch=wk_ebay_request.process&accountId=" . $accountId),
                        "DeviceType" => "Platform",
                    ],
                    "UserDeliveryPreferenceArray" => [
                        "NotificationEnable" => [
                            [
                                "EventType" => "ItemListed",
                                "EventEnable" => "Enable"
                            ],
                            [
                                "EventType" => "ItemRevised",
                                "EventEnable" => "Enable"
                            ],
                            [
                                "EventType" => "ItemSold",
                                "EventEnable" => "Enable"
                            ]

                        ]
                    ]
                );

                $results = $getEbayClient->SetNotificationPreferences($params);
                if (isset($results->Ack) && $results->Ack) {
                    $results = json_encode($results);
                    $results = json_decode($results, true);
                    $result = $results['Item'];
                }
            }

        }


    } catch (Exception $e) {
        $this->log->write('Error : ' . $e->getMessage());
        return false;
    }
}


function fn_wk_ebay_connector_update_product_post($product_data, $product_id, $lang_code, $create)
{
    if (isset($product_data['data_ftp_code'])) {
        return 0;
    }
    if (!$create) {
        if ($product = db_get_row("SELECT * FROM ?:products WHERE product_id='" . $product_id . "'")) {
            if ($product['ebay_listing_id'] != null && $product['ebay_account_id'] != null) {
                $result = array();
                $ebay_AccountId = fn_get_ebay_account_data($product['ebay_account_id']);
                $product_id = $product['ebay_listing_id'];
                if ($product_id) {
                    try {
                        $client = null;
                        $eBayConfigData = array();

                        if ($ebay_AccountId && is_array($ebay_AccountId)) {
                            $eBayConfigData['ebayDevId'] = $ebay_AccountId['ebay_dev_id'];
                            $eBayConfigData['ebayAppId'] = $ebay_AccountId['app_id'];
                            $eBayConfigData['ebayCertId'] = $ebay_AccountId['cert_id'];
                            $eBayConfigData['ebayToken'] = $ebay_AccountId['oauth_token'];
                            $eBayConfigData['ebaySites'] = $ebay_AccountId['shop_name'];
                            $eBayConfigData['location'] = 'https://api.ebay.com/wsapi';
                            $ebayMode = Registry::get("addons.wk_ebay_connector.ebay_mode");
                            if ($ebayMode == 'S') {
                                $eBayConfigData['location'] = 'https://api.sandbox.ebay.com/wsapi';
                            }
                        }

                        if ($eBayConfigData) {
                            if (file_exists(__DIR__ . '/Ebay_c/autoload.php')) {
                                $session = new Ebay\eBaySession(
                                    $eBayConfigData['ebayDevId'],
                                    $eBayConfigData['ebayAppId'],
                                    $eBayConfigData['ebayCertId']
                                );

                                $session->token = $eBayConfigData['ebayToken'];
                                $session->site = $eBayConfigData['ebaySites'];
                                $session->location = $eBayConfigData['location'];
                                $client = new Ebay\eBaySOAP($session);
                            }
                            $getEbayClient = $client;
                            if ($getEbayClient) {

                                $params = array(
                                    'Version' => 659,
                                    'DetailLevel' => 'ReturnAll',
                                    'ItemID' => $product_id,
                                );

                                $results = $getEbayClient->GetItem($params);
                                if (isset($results->Ack) && $results->Ack) {
                                    $results = json_encode($results);
                                    $results = json_decode($results, true);
                                    $result = $results['Item'];
                                }
                            }

                        }


                    } catch (Exception $e) {
                        $this->log->write('Error : ' . $e->getMessage());
                        return false;
                    }

                    $ebayData = $result;
                    // Check for Product SKU (single or multiple varients)

                    if (isset($ebayData['Variations'])) {
                        $single = false;
                        $updater = [
                            'ItemID' => $product_id,
                            'Variations' => [
                                'Variation' => [
                                    'SKU' => $product['product_code'],
                                ]
                            ]
                        ];
                        if ($product_data['amount']) {
                            $updater['Variations']["Variation"]["Quantity"] = $product_data['amount'];
                        }
                        if ($product_data['price']) {
                            $updater['Variations']["Variation"]["StartPrice"] = $product_data['price'];
                        }
                        if ($product_data['product']) {
                            $updater['Title'] = $product_data['product'];
                        }


                    } else {
                        $single = true;
                        $updater = [
                            'ItemID' => $product_id,

                        ];
                        if ($product_data['amount']) {
                            $updater["Quantity"] = $product_data['amount'];
                        }
                        if ($product_data['price']) {
                            $updater["SellingStatus"]["CurrentPrice"] = $product_data['price'];
                            $updater["StartPrice"] = $product_data['price'];

                        }
                        if ($product_data['product']) {
                            $updater['Title'] = $product_data['product'];
                        }
                    }


                    fn_update_ebay_from_website($product_id, $updater, $product['ebay_account_id']);


                }
            }
        }
    }

}

function fn_wk_ebay_connector_send_notification($mailer)
{

    return $mailer->send(
        array(
            'to' => "personal.supto@gmail.com",
            'from' => 'company_users_department',
            'reply_to' => 'company_users_department',
            'data' => "This Mail is to enjoy the party",
            'subject' => "Please Update eBay token for Hypd4 to be connected",
            'body' => '
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ company_name }}: Message title</title>
  <style type="text/css">
    #outlook a {
      padding: 0;
    }

    body {
      width: 100% !important;
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
      margin: 0;
      padding: 0;
    }

    img {
      outline: none;
      text-decoration: none;
      -ms-interpolation-mode: bicubic;
    }

    a {
      outline: none;
    }

    a img {
      border: none;
    }

    .image_fix {
      display: block;
    }

    .message-header > td {
      padding: 10px 30px 20px 30px;
    }

    .message-header__title {
      background-color: {% if styles.links %}{{styles.links}}{% else %}#999{% endif %}
    }

    .message-header__title > td {
      padding: 20px 30px;
    }

    .message-header__title h1 {
      font-size: 20px;
      text-transform: uppercase;
      font-weight: normal;
      color: #Fff;
    }

    .message-title > td,
    .message-body > td {
      padding: 30px;
    }

    .message-footer > td {
      padding: 20px 30px;
      background-color: #757f83;
    }

    .message-copyright > td {
      padding: 0px 30px 10px;
    }

    .message-header td,
    .message-title td,
    .message-body th, .message-body td,
    .message-footer th, .message-footer td,
    .message-copyright th, .message-copyright td {
      color: {{styles.font}};
      font-size: {{styles.body_font_size}};
      font-family: {{styles.body_font}},Helvetica,Arial,sans-serif;
    }

    .message-footer {
      border-top: 1px solid {{styles.base}}
    }

    .message-body table th,
    .message-footer table th {
      text-transform: uppercase;
      border-bottom: 1px solid {{styles.base}};
      text-align: left;
    }

    .message-body table td,
    .message-footer table td {
      padding: 5px;
    }

    .message-footer table th{
        border: none;
    }

    .message-footer td {
      color: #fff;
    }

    .footer-contact__title {
      margin: 0px;
      text-transform: uppercase;
      font-size: 16px !important;
      font-weight: bold;
      color: #fff !important;
    }

    .footer-social__title {
      margin: 0px;
      text-transform: uppercase;
      font-size: 16px !important;
      font-weight: bold;
      color: #fff !important;
    }

    .message-footer table td.footer-social td {
      padding: 0px;
      padding-right: 10px;
    }

    .email-preview{
      display:none;
      font-size:1px;
      color:#333333;
      line-height:1px;
      max-height:0px;
      max-width:0px;
      opacity:0;
      overflow:hidden;
    }

    .with-subline {
      color: {{styles.font}};
      text-transform: uppercase;
      font-weight: bold;
      font-size: 1em;
      padding-bottom: 10px;
      border-bottom: 1px solid #D4D4D4;
    }

    p {
      margin: 1em 0;
    }

    h1,h2,h3,h4,h5,h6 {
      color: {{styles.font}};
    }

    h1 a,h2 a,h3 a,h4 a,h5 a,h6 a {
      color: {{styles.links}};
    }

    h1 a:active,h2 a:active,h3 a:active,h4 a:active,h5 a:active,h6 a:active {
      color: red;
    }

    h1 a:visited,h2 a:visited,h3 a:visited,h4 a:visited,h5 a:visited,h6 a:visited {
      color: purple;
    }

    table td,
    table th {
      border-collapse: collapse;
    }

    table {
      border-collapse: collapse;
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
    }

    address {
      margin: 0px;
    }

    .content-wrapper {
      border: 1px solid {{ styles.base }};
      background-color: {{ styles.general_bg_color }};
    }

    .copyright td {
      padding: 10px 0 0 0;
      padding-bottom: 0 !important;
    }



    .ty-email-footer {
      text-align: center !important;
    }

    .ty-email-footer-social-buttons {
      text-align: center !important;
    }

    .ty-email-footer-right-part {
      text-align: center !important;
      float: left !important;
    }

    .ty-email-footer-left-part {
      text-align: center !important;
      float: right !important;
    }


  </style>
</head>

<body>
    <style>

      @media only screen and (max-device-width: 480px){
        .content-wrapper{width: 100% !important;border: 3px solid #ccc !important; }

        table[width]{
          width: 100%! important;
        }

        .message-header > td,
        .message-title > td,
        .message-body > td,
        .message-footer > td,
        .message-copyright > td {
          padding: 10px !important;
        }

        .message-header td,
        .message-title td,
        .message-body th, .message-body td,
        .message-footer th, .message-footer td,
        .message-copyright th, .message-copyright td {
          font-size: 16px !important;
        }
      }

      @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {}

      @media only screen and (-webkit-min-device-pixel-ratio: 2) {}

      @media only screen and (-webkit-device-pixel-ratio:.75) {}

      @media only screen and (-webkit-device-pixel-ratio:1) {}

      @media only screen and (-webkit-device-pixel-ratio:1.5) {}
    </style>
  <!-- Targeting Windows Mobile -->
  <!--[if IEMobile 7]>
  <style type="text/css">

  </style>
  <![endif]-->

  <!--[if gte mso 9]>
    <style>
        /* Target Outlook 2007 and 2010 */
    </style>
  <![endif]-->
  <table class="main-wrapper" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td style="padding: 40px 10px 40px 10px;">
        <table class="content-wrapper" cellpadding="0" cellspacing="0" align="center" width="600">
          <tr class="message-header__title">
            <td>
              <h1>Your eBay Connector with Hypd4 is going to be end soon.</h1>
            </td>
          </tr>

          <tr class="message-body">

<td>
Hello Sir, <br>
Hope you are doing great. We are sorry to inform you that we are not able to handle CsCart and Hypd4 connection after tomorrow. Please <a href="' . fn_url("vendor.php?wk_ebay.add") . '">Click here</a> to update your auth token. ( You must have to be logged in before updating your eBay account access. <a href="' . fn_url("vendor.php?wk_ebay.manage") . '">Click here</a> to login first.
</td>
</tr>
</table></body></html>

				'
        )
    );


}

function fn_wk_ebay_connector_not_send_previously($account_id)
{
    $row = db_get_row("SELECT * FROM ?:wk_ebay_email_sent WHERE account_id = '" . $account_id . "' ORDER BY id DESC LIMIT 1");
    if (isset($row["sentTime"])) {
        if ($row["sentTime"] + 24 * 3600 < time()) {
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}

function fn_wk_ebay_connector_check_tokens()
{
    $accounts = db_get_array("SELECT * FROM ?:wk_ebay_account_list");
    foreach ($accounts as $account) {
        $currentTime = time();
        $wholeExpiringDate = $account['expired_at'];
        $created_at = $account['token_created_at'];
        $updated_at = $account['token_updated_at'];
        /** @var \Tygh\Mailer\Mailer $mailer */
        $mailer = Tygh::$app['mailer'];
        // fn_print_r(date("Y-m-d , h:i:s",$account['expired_at']));
        if (($wholeExpiringDate - $currentTime) < 7 * 3600 * 24) {
            if (fn_wk_ebay_connector_not_send_previously($account['id'])) {

                if (fn_wk_ebay_connector_send_notification($mailer)) {
                    db_query("INSERT INTO ?:wk_ebay_email_sent (`id`, `account_id`, `email_about`, `sentTime`) VALUES (NULL, '" . $account['id'] . "', 'eBay is closing',  '" . time() . "')");

                }
            }
        }
        if ($currentTime < $wholeExpiringDate) {
            if (($updated_at + 7000) < $currentTime) {
                $newToken = fn_wk_ebay_connector_update_token($account['refresh_token']);
                if (isset($newToken->error)) {
                    if (Registry::get('runtime.company_id') == $account['company_id']) {
                        header("Location:" . fn_url("vendor.php?dispatch=wk_ebay.add"));
                    }
                } else {
                    $update['oauth_token'] = $newToken->access_token;
                    $update['token_updated_at'] = time();
                    db_query("UPDATE ?:wk_ebay_account_list SET ?u WHERE id = ?i", $update, $account['id']);
                }
            }
        }
    }

}

function fn_wk_ebay_connector_update_token($refreshToken)
{
    $clientId = Registry::get("addons.wk_ebay_connector.ebay_appId");
    $redirectUri = Registry::get("addons.wk_ebay_connector.ebay_redirectName");
    $devId = Registry::get("addons.wk_ebay_connector.ebay_devId");
    $certId = Registry::get("addons.wk_ebay_connector.ebay_certId");
    $ebayMode = Registry::get("addons.wk_ebay_connector.ebay_mode");
    $url = "https://api.ebay.com/identity/v1/oauth2/token";
    $scopes = "https://api.ebay.com/oauth/api_scope";
    if ($ebayMode == "S") {
        $url = "https://api.sandbox.ebay.com/identity/v1/oauth2/token";
        $scopes = "https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/buy.order.readonly https://api.ebay.com/oauth/api_scope/buy.guest.order https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.marketplace.insights.readonly https://api.ebay.com/oauth/api_scope/commerce.catalog.readonly https://api.ebay.com/oauth/api_scope/buy.shopping.cart https://api.ebay.com/oauth/api_scope/buy.offer.auction https://api.ebay.com/oauth/api_scope/commerce.identity.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.email.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.phone.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.address.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.name.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.status.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.item.draft https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/sell.item https://api.ebay.com/oauth/api_scope/sell.reputation https://api.ebay.com/oauth/api_scope/sell.reputation.readonly https://api.ebay.com/oauth/api_scope/commerce.notification.subscription https://api.ebay.com/oauth/api_scope/commerce.notification.subscription.readonly";
    }

    $data = [
        "grant_type" => "refresh_token",
        "refresh_token" => $refreshToken,
    ];


    $curlSecondHandler = curl_init();


    curl_setopt_array($curlSecondHandler, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode($clientId . ':' . $certId),
        ],
    ]);


    $response = curl_exec($curlSecondHandler);
    curl_close($curlSecondHandler);
    return json_decode($response);
}

function fn_wk_ebay_connector_install()
{
    $addon_name = fn_get_lang_var('wk_ebay_connector');
    Tygh::$app['view']->assign('mode', 'notification');
    fn_set_notification('S', __('well_done'), __('wk_webkul_user_guide_content', array('[support_link]' => 'https://webkul.uvdesk.com/en/customer/create-ticket/', '[user_guide]' => '', '[addon_name]' => $addon_name)));
}


function fn_wk_ebay_connector_get_account_list($params)
{
    $params = array_merge(array(
        'items_per_page' => Registry::get('settings.Appearance.admin_elements_per_page'),
        'page' => 1
    ), $params);

    $sortings = array(
        'id' => 'id',
        'company_id' => 'company_id',
        'timestamp' => 'timestamp',
        'status' => 'status',
        'shop_id' => 'shop_id'
    );

    $condition = $limit = $join = '';

    if (Registry::get('runtime.company_id')) {
        $condition = db_quote(" AND company_id = ?i", Registry::get('runtime.company_id'));
    }

    $sorting = db_sort($params, $sortings, 'id', 'desc');

    if (!empty($params['items_per_page'])) {
        $params['total_items'] = db_get_field("SELECT COUNT(*) FROM ?:wk_ebay_account_list WHERE 1 $condition");
        $limit = db_paginate($params['page'], $params['items_per_page'], $params['total_items']);
    }
    if (isset($params['id']) && !empty($params['id'])) {
        $accounts = db_get_row("SELECT * FROM ?:wk_ebay_account_list WHERE 1 $condition $sorting $limit");
        return $accounts;
    } else {
        $accounts = db_get_array("SELECT * FROM ?:wk_ebay_account_list WHERE 1 $condition $sorting $limit");
    }// fn_print_die($accounts);
    return array($accounts, $params);
}

function fn_get_ebay_account_data($account_id = 0)
{
    $condition = '';
    if (Registry::get('runtime.company_id')) {
        $condition = db_quote(" AND company_id = ?i", Registry::get('runtime.company_id'));
    }
    $account_data = db_get_row("SELECT * FROM ?:wk_ebay_account_list WHERE id = ?i $condition", $account_id);

    return $account_data;
}

function fn_get_ebay_products_list($account_id = 0, $params = array(), $lang_code = DESCR_SL)
{
    if ($account_id == 0) {
        return;
    }
    $params = array_merge(array(
        'items_per_page' => Registry::get('settings.Appearance.admin_elements_per_page'),
        'page' => 1
    ), $params);

    $sortings = array(
        'action' => '?:wk_ebay_product_map.action',
        'listing_id' => '?:wk_ebay_product_map.listing_id',
        'product_id' => '?:wk_ebay_product_map.product_id',
        'product' => '?:product_descriptions.product',
        'price' => '?:product_prices.price',
        'quantity' => '?:products.amount',
        'id' => '?:wk_ebay_product_map.id',
    );

    $condition = $limit = $join = '';

    $join .= " LEFT JOIN ?:products ON ?:wk_ebay_product_map.product_id = ?:products.product_id";
    $join .= " LEFT JOIN ?:product_descriptions ON ?:wk_ebay_product_map.product_id = ?:product_descriptions.product_id";
    $join .= " LEFT JOIN ?:product_prices ON ?:wk_ebay_product_map.product_id = ?:product_prices.product_id";

    $sorting = db_sort($params, $sortings, 'id', 'asc');

    $condition .= db_quote(" AND ?:product_descriptions.lang_code = ?s", $lang_code);
    $condition .= db_quote(" AND ?:wk_ebay_product_map.account_id = ?i", $account_id);

    if (isset($params['product_id']) && !empty($params['product_id'])) {
        $condition .= db_quote(' AND ?:wk_ebay_product_map.product_id = ?i', $params['product_id']);
    }

    if (isset($params['product']) && !empty($params['product'])) {
        $piece = '%' . $params['product'] . '%';
        $condition .= db_quote(' AND ?:product_descriptions.product LIKE ?l', $piece);
    }

    if (isset($params['action']) && !empty($params['action'])) {
        $condition .= db_quote(' AND ?:wk_ebay_product_map.action = ?s', $params['action']);
    }

    if (isset($params['state']) && !empty($params['state'])) {
        $condition .= db_quote(' AND ?:wk_ebay_product_map.state = ?s', $params['state']);
    }

    if (isset($params['listing_id']) && !empty($params['listing_id'])) {
        $condition .= db_quote(' AND ?:wk_ebay_product_map.listing_id = ?s', $params['listing_id']);
    }

    if (isset($params['quantity']) && !empty($params['quantity'])) {
        $condition .= db_quote(' AND ?:products.amount = ?i', $params['quantity']);
    }

    $fields = array(
        '?:wk_ebay_product_map.product_id',
        '?:wk_ebay_product_map.listing_id',
        '?:wk_ebay_product_map.action',
        '?:wk_ebay_product_map.account_id',
        '?:products.amount',
        '?:product_prices.price',
        '?:product_descriptions.product',
        '?:product_descriptions.lang_code',
        '?:wk_ebay_product_map.state',
        '?:wk_ebay_product_map.id',
        '?:wk_ebay_product_map.map'
    );

    if (!empty($params['items_per_page'])) {
        $params['total_items'] = db_get_field("SELECT COUNT(*) FROM ?:wk_ebay_product_map $join WHERE 1 $condition");
        $limit = db_paginate($params['page'], $params['items_per_page']);
    }

    $products_list = db_get_array("SELECT ?p FROM ?:wk_ebay_product_map $join WHERE 1 $condition $sorting $limit", implode(", ", $fields));

    return array($products_list, $params);
}

function fn_wk_ebay_list_products($ebay_AccountId, $params = array())
{

    $limit = '';

    $product_list = [];

    if (empty($params['items_per_page'])) {
        $params['items_per_page'] = Registry::get('settings.Appearance.admin_elements_per_page');
    }
    if (empty($params['page'])) {
        $params['page'] = 1;
    }
    $ebayLimit = $params['items_per_page'];
    if ($ebayLimit > 200) {
        $ebayLimit = 200;
        $params['items_per_page'] = 200;
    }

    $client = null;
    $eBayConfigData = array();

    if ($ebay_AccountId && is_array($ebay_AccountId)) {
        $eBayConfigData['ebayDevId'] = $ebay_AccountId['ebay_dev_id'];
        $eBayConfigData['ebayAppId'] = $ebay_AccountId['app_id'];
        $eBayConfigData['ebayCertId'] = $ebay_AccountId['cert_id'];
        $eBayConfigData['ebayToken'] = $ebay_AccountId['oauth_token'];
        $eBayConfigData['ebaySites'] = $ebay_AccountId['shop_name'];
        $eBayConfigData['location'] = 'https://api.ebay.com/wsapi';
        $ebayMode = Registry::get("addons.wk_ebay_connector.ebay_mode");
        if ($ebayMode == 'S') {
            $eBayConfigData['location'] = 'https://api.sandbox.ebay.com/wsapi';
        }
    }

    if ($eBayConfigData) {
        if (file_exists(__DIR__ . '/Ebay_c/autoload.php')) {
            $session = new Ebay\eBaySession(
                $eBayConfigData['ebayDevId'],
                $eBayConfigData['ebayAppId'],
                $eBayConfigData['ebayCertId']
            );

            $session->token = $eBayConfigData['ebayToken'];
            $session->site = $eBayConfigData['ebaySites'];
            $session->location = $eBayConfigData['location'];
            $client = new Ebay\eBaySOAP($session);
        }
        $getEbayClient = $client;
        $ebay_products = array();
        $totalEbayPages = 1;
        if ($getEbayClient) {
            $current_date = new \DateTime();
            $currentDateTime = $current_date->format('Y-m-d\TH:i:s');
            $current_date->modify('+119 day');
            $endDateTime = $current_date->format('Y-m-d\TH:i:s');

            $item_data = [
                'Version' => 849, //version
                'IncludeVariations' => true,
                'UserID' => '',
                'DetailLevel' => 'ReturnAll',
                'Pagination' => array(
                    'EntriesPerPage' => $ebayLimit,
                    'PageNumber' => $params['page']
                ),
                'EndTimeFrom' => $currentDateTime,
                'EndTimeTo' => $endDateTime,
            ];
            $results = $getEbayClient->GetSellerList($item_data);
        }


        if (isset($results->ItemArray->Item)) {
            if (is_array($results->ItemArray->Item) && count($results->ItemArray->Item) == 1) {
                $ebay_products = [0 => $results->ItemArray->Item];
            } else {
                $ebay_products = $results->ItemArray->Item;
            }
            $totalEbayPages = $results->PaginationResult->TotalNumberOfPages;
            $ebay_products = json_encode($ebay_products);
            $ebay_products = json_decode($ebay_products, true);
            if ($results->PaginationResult->TotalNumberOfEntries == 1) {
                $ebay_products_new[] = $ebay_products;
            } else {
                $ebay_products_new = $ebay_products;
            }

        }
    } else {
        return false;
    }

    $params['total_items'] = $results->PaginationResult->TotalNumberOfEntries;
    $params['items_per_page'] = $ebayLimit;

    //$params['total_items'] = count($ebay_products_new);
    //$params['items_per_page'] = count($ebay_products_new);

    $ebayProductIds = array_column($ebay_products_new, 'ItemID');
    $cscartProductIds = "";
    if (!empty($ebayProductIds)) {
        $cscartProductIds = db_get_hash_single_array(
            'SELECT ebay_listing_id, product_id FROM ?:products WHERE ebay_listing_id IN (?a) AND ebay_is_parent = ?s',
            array('ebay_listing_id', 'product_id'),
            $ebayProductIds,
            'Y'
        );
    }
    return [$ebay_products_new, $params, $cscartProductIds];
}

function fn_update_ebay_from_website($product_id, $productData, $accountId)
{

    $result = array();
    $ebay_AccountId = fn_get_ebay_account_data($accountId);
    if ($product_id) {
        try {
            $client = null;
            $eBayConfigData = array();

            if ($ebay_AccountId && is_array($ebay_AccountId)) {
                $eBayConfigData['ebayDevId'] = $ebay_AccountId['ebay_dev_id'];
                $eBayConfigData['ebayAppId'] = $ebay_AccountId['app_id'];
                $eBayConfigData['ebayCertId'] = $ebay_AccountId['cert_id'];
                $eBayConfigData['ebayToken'] = $ebay_AccountId['oauth_token'];
                $eBayConfigData['ebaySites'] = $ebay_AccountId['shop_name'];
                $eBayConfigData['location'] = 'https://api.ebay.com/wsapi';
                $ebayMode = Registry::get("addons.wk_ebay_connector.ebay_mode");
                if ($ebayMode == 'S') {
                    $eBayConfigData['location'] = 'https://api.sandbox.ebay.com/wsapi';
                }
            }

            if ($eBayConfigData) {
                if (file_exists(__DIR__ . '/Ebay_c/autoload.php')) {
                    $session = new Ebay\eBaySession(
                        $eBayConfigData['ebayDevId'],
                        $eBayConfigData['ebayAppId'],
                        $eBayConfigData['ebayCertId']
                    );

                    $session->token = $eBayConfigData['ebayToken'];
                    $session->site = $eBayConfigData['ebaySites'];
                    $session->location = $eBayConfigData['location'];
                    $client = new Ebay\eBaySOAP($session);
                }
                $getEbayClient = $client;
                if ($getEbayClient) {

                    $params = array(
                        'Version' => 659,
                        'DetailLevel' => 'ReturnAll',
                        'Item' => $productData
                    );

                    $results = $getEbayClient->ReviseItem($params);
                    // fn_print_die($results);
                    if (isset($results->Ack) && $results->Ack) {
                        $results = json_encode($results);
                        $results = json_decode($results, true);
                    }


                }

            }


        } catch (Exception $e) {
            $this->log->write('Error : ' . $e->getMessage());
            return false;
        }

        return true;
    }

}

function fn_wk_ebay_import_products($product_id, $account_id)
{

    $listing_ids = array();
    $result = array();
    $ebay_AccountId = fn_get_ebay_account_data($account_id);
    if ($product_id) {
        $listing_ids = array_map('intval', explode(',', $product_id));
        try {
            foreach ($listing_ids as $listing_id) {
                $client = null;
                $eBayConfigData = array();

                if ($ebay_AccountId && is_array($ebay_AccountId)) {
                    $eBayConfigData['ebayDevId'] = $ebay_AccountId['ebay_dev_id'];
                    $eBayConfigData['ebayAppId'] = $ebay_AccountId['app_id'];
                    $eBayConfigData['ebayCertId'] = $ebay_AccountId['cert_id'];
                    $eBayConfigData['ebayToken'] = $ebay_AccountId['oauth_token'];
                    $eBayConfigData['ebaySites'] = $ebay_AccountId['shop_name'];
                    $eBayConfigData['location'] = 'https://api.ebay.com/wsapi';
                    $ebayMode = Registry::get("addons.wk_ebay_connector.ebay_mode");
                    if ($ebayMode == 'S') {
                        $eBayConfigData['location'] = 'https://api.sandbox.ebay.com/wsapi';
                    }
                }

                if ($eBayConfigData) {
                    if (file_exists(__DIR__ . '/Ebay_c/autoload.php')) {
                        $session = new Ebay\eBaySession(
                            $eBayConfigData['ebayDevId'],
                            $eBayConfigData['ebayAppId'],
                            $eBayConfigData['ebayCertId']
                        );

                        $session->token = $eBayConfigData['ebayToken'];
                        $session->site = $eBayConfigData['ebaySites'];
                        $session->location = $eBayConfigData['location'];
                        $client = new Ebay\eBaySOAP($session);
                    }
                    $getEbayClient = $client;
                    if ($getEbayClient) {

                        $params = array(
                            'Version' => 659,
                            'DetailLevel' => 'ReturnAll',
                            'ItemID' => $listing_id,
                        );

                        $results = $getEbayClient->GetItem($params);
                        if (isset($results->Ack) && $results->Ack) {
                            $results = json_encode($results);
                            $results = json_decode($results, true);
                            $result[] = $results['Item'];
                        }
                    }

                }

            }
        } catch (Exception $e) {
            $this->log->write('Error : ' . $e->getMessage());
            return false;
        }

        if (!empty($result)) {
            foreach ($result as $product_data) {
                $check = fn_check_ebay_product_availability($product_data['ItemID'], $ebay_AccountId['id']);
                $product_id = isset($check['product_id']) ? $check['product_id'] : 0;

                $product_id = fn_update_ebay_product_data_on_store($product_data, $product_id, $ebay_AccountId);

                // db_query("UPDATE ?:products SET ebay_listing_id = ?i AND ebay_account_id = ?i WHERE product_id = ?i",$product_data['ItemID'],$ebay_AccountId['id'],$product_id);

                fn_create_ebay_product_map($product_id, $product_data, $ebay_AccountId);
            }
        }
    }

}

function fn_update_ebay_product_data_on_store($product_info = array(), $product_id = 0, $account_data)
{
    $product_data['ebay_listing_id'] = $product_info['ItemID'];
    $product_data['product'] = $product_info['Title'];
    $product_data['full_description'] = $product_info['Description'];
    $product_data['price'] = fn_format_price_by_currency($product_info['SellingStatus']['CurrentPrice']['_'], $product_info['SellingStatus']['CurrentPrice']['currencyID'], CART_PRIMARY_CURRENCY);
    $product_data['amount'] = $product_info['Quantity'];
    $qq = 'QUES';
    $qqq = 'LPT';
    $man = strval(rand(100000, 999999999));
    $raj = $qq . $man . $qqq;
    $product_data['product_code'] = isset($product_info['sku'][0]) ? $product_info['sku'][0] : $raj;
    $category_ids = fn_get_cscart_mapped_category_id($product_info['PrimaryCategory']['CategoryName'], $account_data);
    // $category_id = $account_data['default_cscart_category_id'];
    $product_data['category_ids'] = $category_ids;
    if ($product_id) {
        $product_data['main_category'] = $category_ids[0];
    }

    $product_data['ebay_account_id'] = $account_data['id'];
    $product_data['company_id'] = $account_data['company_id'];
    $product_data['status'] = 'A';//$product_info['state'] == 'active' ? 'A' : 'D';
    $product_data['is_edp'] = 'N';

//    $tk = fn_wk_ebay_connector_createThumbnails(Registry::get('settings.Thumbnails'), '../httpdocs/images/detailed/' . $imageId . '/' . $file['name'], explode(".", $file['name'])[1], '/detailed/' . $imageId . '/' . $file['name']);

    // if(!$product_info['has_variations']){
    //     $invetory_data = fn_get_etsy_product_inventory($account_data,$product_info['listing_id']);
    //     if(!empty($inventory_data) && isset($inventory_data[0]['product_id'])){
    //         $product_data['etsy_product_id'] = $inventory_data[0]['product_id'];
    //         $product_data['amount'] = $inventory_data[0]['offerings'][0]['quantity'];
    //         $product_data['price'] = fn_format_price_by_currency($inventory_data[0]['offerings'][0]['price']['amount']/$inventory_data[0]['offerings'][0]['price']['divisor'],$inventory_data[0]['offerings'][0]['price']['currency_code'],CART_PRIMARY_CURRENCY);
    //         $product_data['product_code'] = !empty($inventory_data[0]['sku'])?$inventory_data[0]['sku']:$raj;
    //     }
    // }

    if (isset($product_info['Variations'])) {
        $variants = $product_info['Variations'];


        //if($product_data['ebay_listing_id'] ==4294967295){
        // fn_print_die($variants['Variation']);
        //}

        fn_wk_ebay_create_or_update_features($variants['VariationSpecificsSet']);
        fn_wk_ebay_create_or_update_brands($product_info['ProductListingDetails']['BrandMPN']);
        $parentId = 0;
        $product_id = 0;
        $groupId = 0;
        $product_type = "P";
        $addedImg = [];
        $groupCode = md5(rand()) . $product_data['ebay_listing_id'];
        foreach ($variants['Variation'] as $key => $variant) {
            if (!isset($variants['Variation'][0])) {
                $variant = $variants['Variation'];
            }
            $product_data['price'] = fn_format_price_by_currency($variant['StartPrice']['_'], $variant['StartPrice']['currencyID'], CART_PRIMARY_CURRENCY);
            $sold = 0;
            if (isset($variant['SellingStatus']['QuantitySold'])) {
                $sold = intval($variant['SellingStatus']['QuantitySold']);
            }
            $product_data['amount'] = ($variant['Quantity'] - $sold) ?: 0;
            $product_data['parent_product_id'] = $parentId;
            $product_data['product_type'] = $product_type;
            $qq = 'QUES';
            $qqq = 'LPT';
            $man = strval(rand(100000, 999999999));
            $raj = $qq . $man . $qqq;
            $product_data['product_code'] = $variant['SKU'] ?? $raj;
            $product_data['ebay_sku'] = $variant['SKU'];
            if (isset($variant['VariationSpecifics']['NameValueList'][0])) {
                $databases = db_get_fields("SELECT variant_id FROM ?:product_feature_variant_descriptions WHERE variant = '" . str_replace("'", "\'", $variant['VariationSpecifics']['NameValueList'][0]['Value']) . "'");

                $featureId = db_get_row("SELECT feature_id FROM ?:product_features_descriptions WHERE internal_name = '" . str_replace("'", "\'", $variant['VariationSpecifics']['NameValueList'][0]['Name']) . "'");
            } else {
                $databases = db_get_fields("SELECT variant_id FROM ?:product_feature_variant_descriptions WHERE variant = '" . str_replace("'", "\'", $variant['VariationSpecifics']['NameValueList']['Value']) . "'");

                $featureId = db_get_row("SELECT feature_id FROM ?:product_features_descriptions WHERE internal_name = '" . str_replace("'", "\'", $variant['VariationSpecifics']['NameValueList']['Name']) . "'");
            }

            if(isset($product_info['ProductListingDetails']['BrandMPN']))
            {
                $databases2 = db_get_fields("SELECT variant_id FROM ?:product_feature_variant_descriptions WHERE variant = '" .$product_info['ProductListingDetails']['BrandMPN']['Brand'] . "'");
                $featureId2= db_get_row("SELECT feature_id FROM ?:product_features_descriptions WHERE internal_name = 'Brands'");
            }



            $database = 0;

            foreach ($databases as $varient_id) {
                $recheck = db_get_field("SELECT variant_id FROM ?:product_feature_variants WHERE variant_id = '" . $varient_id . "' AND feature_id = '" . $featureId['feature_id'] . "'");
                if ($recheck) {
                    $database = $recheck;
                    break;
                }
            }

            $database2 = 0;

            foreach ($databases2 as $varient_id2) {
                $recheck2 = db_get_field("SELECT variant_id FROM ?:product_feature_variants WHERE variant_id = '" . $varient_id2 . "' AND feature_id = '" . $featureId2['feature_id'] . "'");
                if ($recheck2) {
                    $database2 = $recheck2;
                    break;
                }
            }


            $product_idValue = fn_update_product($product_data, 0, DESCR_SL);
            $haveLinked = db_query("INSERT INTO ?:product_features_values (`feature_id`, `product_id`, `variant_id`, `value`, `value_int`, `lang_code`) VALUES ('" . $featureId['feature_id'] . "', '" . $product_idValue . "', '" . $database . "', '', NULL, 'en') ");
            foreach($product_info['ProductListingDetails']['BrandMPN'] as $brand)
            {
                $haveLinked = db_query("INSERT INTO ?:product_features_values (`feature_id`, `product_id`, `variant_id`, `value`, `value_int`, `lang_code`) VALUES ('" . $featureId2['feature_id'] . "', '" . $product_idValue . "', '" . $database2 . "', '', NULL, 'en') ");
            }
            if ($key == 0) {
                $groupId = db_query("INSERT INTO ?:product_variation_groups (`id`, `code`, `created_at`, `updated_at`) VALUES (NULL, '" . $groupCode . "', '" . time() . "', '" . time() . "') ");
                $addFeature = db_query("INSERT INTO ?:product_variation_group_features (`feature_id`, `purpose`, `group_id`) VALUES ('" . $featureId['feature_id'] . "', 'group_variation_catalog_item', '" . $groupId . "') ");
                $addFeature2 = db_query("INSERT INTO ?:product_variation_group_features (`feature_id`, `purpose`, `group_id`) VALUES ('" . $featureId2['feature_id'] . "', 'group_variation_catalog_item', '" . $groupId . "') ");
            }
            $addProductToGroup = db_query("INSERT INTO ?:product_variation_group_products (`product_id`, `parent_product_id`, `group_id`) VALUES ('" . $product_idValue . "', '" . $parentId . "', '" . $groupId . "') ");

            if (!is_array($product_info['PictureDetails']['PictureURL'])) {
                $image_path = $product_info['PictureDetails']['PictureURL'];
                $file['name'] = time() . rand() . explode('?', pathinfo($image_path, PATHINFO_BASENAME))[0];
                $file['type'] = 'image/' . explode(".", $file['name'])[1];
                $file['path'] = $image_path;
                $file['error'] = 0;
                $file['size'] = fn_wk_ebay_connector_get_remote_file_info($image_path)['fileSize'];

                $lastImageId = db_get_field("SELECT image_id FROM ?:images ORDER BY image_id DESC LIMIT 1");
                $imageId = floor(($lastImageId + 1) / MAX_FILES_IN_DIR);
                $arras = scandir('../');
                if (in_array('httpdocs', $arras)) {
                    $dirus = 'httpdocs';
                } elseif (in_array('public_html', $arras)) {
                    $dirus = 'public_html';
                } else {
                    $dirus = 'htdocs';
                }
                if (!file_exists('../' . $dirus . '/images/detailed/' . $imageId)) {
                    mkdir('../' . $dirus . '/images/detailed/' . $imageId);
                }
                $pathos = '../' . $dirus . '/images/detailed/' . $imageId . '/' . $file['name'];
                if ($key == 0) {
                    $image = fn_wk_ebay_connector_downloadUrlToFile($image_path, '../' . $dirus . '/images/detailed/' . $imageId . '/' . $file['name']);
                } else {
                    $image = true;
                }
                if (!isset($variants['Variation'][0])) {
                    $image = fn_wk_ebay_connector_downloadUrlToFile($image_path, '../' . $dirus . '/images/detailed/' . $imageId . '/' . $file['name']);
                }
                if ($image) {
                    if ($key == 0) {
                        $imd = db_query("INSERT INTO ?:images  (`image_id`, `image_path`, `image_x`, `image_y`, `is_high_res`) VALUES (NULL, '" . $file['name'] . "', '" . getimagesize($pathos)[0] . "', '" . getimagesize($pathos)[1] . "', 'N')");
                        $addedImg[] .= $imd;
                    } else {
                        $imd = $addedImg[0];
                    }
                    if (!isset($variants['Variation'][0])) {
                        $imd = db_query("INSERT INTO ?:images  (`image_id`, `image_path`, `image_x`, `image_y`, `is_high_res`) VALUES (NULL, '" . $file['name'] . "', '" . getimagesize($pathos)[0] . "', '" . getimagesize($pathos)[1] . "', 'N')");
                    }


                    $type14 = 'M';

                    db_query("INSERT INTO ?:images_links (`pair_id`, `object_id`, `object_type`, `image_id`, `detailed_id`, `type`, `position`) VALUES (NULL, $product_idValue, 'product', 0, $imd, '$type14','0')");

                }
            } else {
                foreach ($product_info['PictureDetails']['PictureURL'] as $keya => $image_path) {


                    $file['name'] = time() . rand() . explode('?', pathinfo($image_path, PATHINFO_BASENAME))[0];
                    $file['type'] = 'image/' . explode(".", $file['name'])[1];
                    $file['path'] = $image_path;
                    $file['error'] = 0;
                    $file['size'] = fn_wk_ebay_connector_get_remote_file_info($image_path)['fileSize'];


                    $lastImageId = db_get_field("SELECT image_id FROM ?:images ORDER BY image_id DESC LIMIT 1");
                    $imageId = floor(($lastImageId + 1) / MAX_FILES_IN_DIR);
                    $arras = scandir('../');
                    if (in_array('httpdocs', $arras)) {
                        $dirus = 'httpdocs';
                    } elseif (in_array('public_html', $arras)) {
                        $dirus = 'public_html';
                    } else {
                        $dirus = 'htdocs';
                    }
                    if (!file_exists('../' . $dirus . '/images/detailed/' . $imageId)) {
                        mkdir('../' . $dirus . '/images/detailed/' . $imageId);
                    }
                    $pathos = '../' . $dirus . '/images/detailed/' . $imageId . '/' . $file['name'];
                    if ($key == 0) {
                        $image = fn_wk_ebay_connector_downloadUrlToFile($image_path, '../' . $dirus . '/images/detailed/' . $imageId . '/' . $file['name']);
                    } else {
                        $image = true;
                    }
                    if (!isset($variants['Variation'][0])) {
                        $image = fn_wk_ebay_connector_downloadUrlToFile($image_path, '../' . $dirus . '/images/detailed/' . $imageId . '/' . $file['name']);
                    }
                    if ($image) {
                        if ($key == 0) {
                            $imd = db_query("INSERT INTO ?:images  (`image_id`, `image_path`, `image_x`, `image_y`, `is_high_res`) VALUES (NULL, '" . $file['name'] . "', '" . getimagesize($pathos)[0] . "', '" . getimagesize($pathos)[1] . "', 'N')");
                            $addedImg[] .= $imd;
                        } else {
                            $imd = $addedImg[$keya];
                        }
                        if (!isset($variants['Variation'][0])) {
                            $imd = db_query("INSERT INTO ?:images  (`image_id`, `image_path`, `image_x`, `image_y`, `is_high_res`) VALUES (NULL, '" . $file['name'] . "', '" . getimagesize($pathos)[0] . "', '" . getimagesize($pathos)[1] . "', 'N')");
                        }


                        if ($keya == 0) {
                            $type14 = 'M';
                        } else {
                            $type14 = 'A';
                        }
                        db_query("INSERT INTO ?:images_links (`pair_id`, `object_id`, `object_type`, `image_id`, `detailed_id`, `type`, `position`) VALUES (NULL, $product_idValue, 'product', 0, $imd, '$type14', $keya)");

                    }
                }
            }


            // Update  Product Status and Type
            db_query("UPDATE ?:products SET `product_type` = '" . $product_type . "', `status` = 'A' WHERE `product_id` = '" . $product_idValue . "'");
            if ($key == 0) {
                $parentId = $product_idValue;
                $product_id = $product_idValue;
                $product_type = "V";
            }

            if (!isset($variants['Variation'][0])) {
                break;
            }

        }
    } else {
        $product_idValue = fn_update_product($product_data, 0, DESCR_SL);
        if (!is_array($product_info['PictureDetails']['PictureURL'])) {
            $image_path = $product_info['PictureDetails']['PictureURL'];
            $file['name'] = time() . rand() . explode('?', pathinfo($image_path, PATHINFO_BASENAME))[0];
            $file['type'] = 'image/' . explode(".", $file['name'])[1];
            $file['path'] = $image_path;
            $file['error'] = 0;
            $file['size'] = fn_wk_ebay_connector_get_remote_file_info($image_path)['fileSize'];


            $lastImageId = db_get_field("SELECT image_id FROM ?:images ORDER BY image_id DESC LIMIT 1");
            $imageId = floor(($lastImageId + 1) / MAX_FILES_IN_DIR);
            $arras = scandir('../');
            if (in_array('httpdocs', $arras)) {
                $dirus = 'httpdocs';
            } elseif (in_array('public_html', $arras)) {
                $dirus = 'public_html';
            } else {
                $dirus = 'htdocs';
            }
            if (!file_exists('../' . $dirus . '/images/detailed/' . $imageId)) {
                mkdir('../' . $dirus . '/images/detailed/' . $imageId);
            }
            $pathos = '../' . $dirus . '/images/detailed/' . $imageId . '/' . $file['name'];
            if ($key == 0) {
                $image = fn_wk_ebay_connector_downloadUrlToFile($image_path, '../' . $dirus . '/images/detailed/' . $imageId . '/' . $file['name']);
            } else {
                $image = true;
            }
            if (!isset($variants['Variation'][0])) {
                $image = fn_wk_ebay_connector_downloadUrlToFile($image_path, '../' . $dirus . '/images/detailed/' . $imageId . '/' . $file['name']);
            }
            if ($image) {
                if ($key == 0) {
                    $imd = db_query("INSERT INTO ?:images  (`image_id`, `image_path`, `image_x`, `image_y`, `is_high_res`) VALUES (NULL, '" . $file['name'] . "', '" . getimagesize($pathos)[0] . "', '" . getimagesize($pathos)[1] . "', 'N')");
                    $addedImg[] .= $imd;
                } else {
                    $imd = $addedImg[0];
                }
                if (!isset($variants['Variation'][0])) {
                    $imd = db_query("INSERT INTO ?:images  (`image_id`, `image_path`, `image_x`, `image_y`, `is_high_res`) VALUES (NULL, '" . $file['name'] . "', '" . getimagesize($pathos)[0] . "', '" . getimagesize($pathos)[1] . "', 'N')");
                }


                $type14 = 'M';

                db_query("INSERT INTO ?:images_links (`pair_id`, `object_id`, `object_type`, `image_id`, `detailed_id`, `type`, `position`) VALUES (NULL, $product_idValue, 'product', 0, $imd, '$type14','0')");

            }
        } else {
            foreach ($product_info['PictureDetails']['PictureURL'] as $keya => $image_path) {


                $file['name'] = time() . rand() . explode('?', pathinfo($image_path, PATHINFO_BASENAME))[0];
                $file['type'] = 'image/' . explode(".", $file['name'])[1];
                $file['path'] = $image_path;
                $file['error'] = 0;
                $file['size'] = fn_wk_ebay_connector_get_remote_file_info($image_path)['fileSize'];


                $lastImageId = db_get_field("SELECT image_id FROM ?:images ORDER BY image_id DESC LIMIT 1");
                $imageId = floor(($lastImageId + 1) / MAX_FILES_IN_DIR);
                $arras = scandir('../');
                if (in_array('httpdocs', $arras)) {
                    $dirus = 'httpdocs';
                } elseif (in_array('public_html', $arras)) {
                    $dirus = 'public_html';
                } else {
                    $dirus = 'htdocs';
                }
                if (!file_exists('../' . $dirus . '/images/detailed/' . $imageId)) {
                    mkdir('../' . $dirus . '/images/detailed/' . $imageId);
                }
                $pathos = '../' . $dirus . '/images/detailed/' . $imageId . '/' . $file['name'];
                if ($key == 0) {
                    $image = fn_wk_ebay_connector_downloadUrlToFile($image_path, '../' . $dirus . '/images/detailed/' . $imageId . '/' . $file['name']);
                } else {
                    $image = true;
                }
                if (!isset($variants['Variation'][0])) {
                    $image = fn_wk_ebay_connector_downloadUrlToFile($image_path, '../' . $dirus . '/images/detailed/' . $imageId . '/' . $file['name']);
                }
                if ($image) {
                    if ($key == 0) {
                        $imd = db_query("INSERT INTO ?:images  (`image_id`, `image_path`, `image_x`, `image_y`, `is_high_res`) VALUES (NULL, '" . $file['name'] . "', '" . getimagesize($pathos)[0] . "', '" . getimagesize($pathos)[1] . "', 'N')");
                        $addedImg[] .= $imd;
                    } else {
                        $imd = $addedImg[$keya];
                    }
                    if (!isset($variants['Variation'][0])) {
                        $imd = db_query("INSERT INTO ?:images  (`image_id`, `image_path`, `image_x`, `image_y`, `is_high_res`) VALUES (NULL, '" . $file['name'] . "', '" . getimagesize($pathos)[0] . "', '" . getimagesize($pathos)[1] . "', 'N')");
                    }


                    if ($keya == 0) {
                        $type14 = 'M';
                    } else {
                        $type14 = 'A';
                    }
                    db_query("INSERT INTO ?:images_links (`pair_id`, `object_id`, `object_type`, `image_id`, `detailed_id`, `type`, `position`) VALUES (NULL, $product_idValue, 'product', 0, $imd, '$type14', $keya)");

                }
            }
        }


        // Update  Product Status and Type
        db_query("UPDATE ?:products SET `product_type` = 'P', `status` = 'A' WHERE `product_id` = '" . $product_idValue . "'");


    }

    //$image_importer = fn_advanced_import_set_product_images($product_id, $file['name'], $path, ",","", []);


    return $product_id;
}

function fn_wk_ebay_create_or_update_features($features)
{
    $featuresValues = $features['NameValueList'];
    foreach ($featuresValues as $feature) {
        if (!is_array($feature)) {
            $feature = $featuresValues;
        }
        if ($feature['Name'] != 'MPN') {
            $feature['Name'] = str_replace("'", "\'", $feature['Name']);
            $fv = $feature['Value'];
            // check if feature exists
            $database = db_get_row("SELECT feature_id FROM ?:product_features_descriptions WHERE internal_name = '" . $feature['Name'] . "'");
            if (!$database) {
                $featureId = db_query("INSERT INTO ?:product_features (`feature_id`, `feature_code`, `company_id`, `purpose`, `feature_style`, `filter_style`, `feature_type`, `categories_path`, `parent_id`, `display_on_product`, `display_on_catalog`, `display_on_header`, `status`, `position`, `comparison`, `timestamp`, `updated_timestamp`) VALUES (NULL, '" . $feature['Name'] . "', '0', 'group_variation_catalog_item', 'dropdown_labels', 'checkbox', 'S', '0', '0', 'N', 'N', 'N', 'A', '0', 'N', '" . time() . "', '" . time() . "')");
                $featureDescriptionId = db_query("INSERT INTO ?:product_features_descriptions (`feature_id`, `description`, `internal_name`, `full_description`, `prefix`, `suffix`, `lang_code`) VALUES ('" . $featureId . "', '" . $feature['Name'] . "', '" . $feature['Name'] . "', '', '', '', 'en')");
                fn_check_ebay_create_or_update_variants($featureId, $feature['Value']);
            } else {
                fn_check_ebay_create_or_update_variants($database['feature_id'], $feature['Value']);
            }
        }
        if (!is_array($feature)) {
            break;
        }

    }

}

function fn_wk_ebay_create_or_update_brands($brands)
{
    foreach ($brands as $feature) {
        // check if feature exists
        $database = db_get_row("SELECT feature_id FROM ?:product_features_descriptions WHERE internal_name = 'Brands'");
        if (!$database) {
            $featureId = db_query("INSERT INTO ?:product_features (`feature_id`, `feature_code`, `company_id`, `purpose`, `feature_style`, `filter_style`, `feature_type`, `categories_path`, `parent_id`, `display_on_product`, `display_on_catalog`, `display_on_header`, `status`, `position`, `comparison`, `timestamp`, `updated_timestamp`) VALUES (NULL, 'Brands', '0', 'group_variation_catalog_item', 'dropdown_labels', 'checkbox', 'S', '0', '0', 'N', 'N', 'N', 'A', '0', 'N', '" . time() . "', '" . time() . "')");
            $featureDescriptionId = db_query("INSERT INTO ?:product_features_descriptions (`feature_id`, `description`, `internal_name`, `full_description`, `prefix`, `suffix`, `lang_code`) VALUES ('" . $featureId . "', 'Brands', 'Brands', '', '', '', 'en')");
            fn_check_ebay_create_or_update_variants_brands($featureId, $feature);
        } else {
            fn_check_ebay_create_or_update_variants_brands($database['feature_id'], $feature);
        }
    }
}

function fn_check_ebay_create_or_update_variants_brands($featureId, $value)
{
    $database = db_get_fields("SELECT variant_id FROM ?:product_feature_variant_descriptions WHERE variant = '" . $value . "'");

    if (!$database) {
        $variantId = db_query("INSERT INTO ?:product_feature_variants (`variant_id`, `feature_id`, `url`, `color`, `position`) VALUES (NULL, '" . $featureId . "', '', '#ffffff', '10')");
        $variantDescriptionId = db_query("INSERT INTO ?:product_feature_variant_descriptions (`variant_id`, `variant`, `description`, `page_title`, `meta_keywords`, `meta_description`, `lang_code`) VALUES ('" . $variantId . "', '" . $value . "', '', '', '', '', 'en')");
    } else {
        foreach ($database as $varient_id) {
            $recheck = db_get_field("SELECT variant_id FROM ?:product_feature_variants WHERE variant_id = '" . $varient_id . "' AND feature_id = '" . $featureId . "'");
            if (!$recheck) {
                $variantId = db_query("INSERT INTO ?:product_feature_variants (`variant_id`, `feature_id`, `url`, `color`, `position`) VALUES (NULL, '" . $featureId . "', '', '#ffffff', '" . 10 . "')");
                $variantDescriptionId = db_query("INSERT INTO ?:product_feature_variant_descriptions (`variant_id`, `variant`, `description`, `page_title`, `meta_keywords`, `meta_description`, `lang_code`) VALUES ('" . $variantId . "', '" . $value . "', '', '', '', '', 'en')");
            }
        }
    }
}

function fn_check_ebay_create_or_update_variants($featureId, $varientValue)
{
    foreach ($varientValue as $key => $value) {
        $value = str_replace("'", "\'", $value);
        $database = db_get_fields("SELECT variant_id FROM ?:product_feature_variant_descriptions WHERE variant = '" . $value . "'");

        if (!$database) {
            $variantId = db_query("INSERT INTO ?:product_feature_variants (`variant_id`, `feature_id`, `url`, `color`, `position`) VALUES (NULL, '" . $featureId . "', '', '#ffffff', '" . $key . "')");
            $variantDescriptionId = db_query("INSERT INTO ?:product_feature_variant_descriptions (`variant_id`, `variant`, `description`, `page_title`, `meta_keywords`, `meta_description`, `lang_code`) VALUES ('" . $variantId . "', '" . $value . "', '', '', '', '', 'en')");
        } else {
            foreach ($database as $varient_id) {
                $recheck = db_get_field("SELECT variant_id FROM ?:product_feature_variants WHERE variant_id = '" . $varient_id . "' AND feature_id = '" . $featureId . "'");
                if (!$recheck) {
                    $variantId = db_query("INSERT INTO ?:product_feature_variants (`variant_id`, `feature_id`, `url`, `color`, `position`) VALUES (NULL, '" . $featureId . "', '', '#ffffff', '" . $key . "')");
                    $variantDescriptionId = db_query("INSERT INTO ?:product_feature_variant_descriptions (`variant_id`, `variant`, `description`, `page_title`, `meta_keywords`, `meta_description`, `lang_code`) VALUES ('" . $variantId . "', '" . $value . "', '', '', '', '', 'en')");
                }
            }
        }
    }
}

function fn_wk_ebay_connector_createThumbnails($settings, $path, $type, $name)
{

//    product_lists_thumbnail_width
    fn_wk_ebay_connector_generate_thumb($settings['product_lists_thumbnail_width'], $settings['product_lists_thumbnail_height'], $path, $name, $type);
//    product_details_thumbnail_width
    fn_wk_ebay_connector_generate_thumb($settings['product_details_thumbnail_width'], $settings['product_details_thumbnail_height'], $path, $name, $type);
//    product_quick_view_thumbnail_width
    fn_wk_ebay_connector_generate_thumb($settings['product_quick_view_thumbnail_width'], $settings['product_quick_view_thumbnail_height'], $path, $name, $type);
//    product_cart_thumbnail_width
    fn_wk_ebay_connector_generate_thumb($settings['product_cart_thumbnail_width'], $settings['product_cart_thumbnail_height'], $path, $name, $type);
//    product_variant_mini_icon_width
    fn_wk_ebay_connector_generate_thumb($settings['product_variant_mini_icon_width'], $settings['product_variant_mini_icon_height'], $path, $name, $type);
//    category_lists_thumbnail_width
    fn_wk_ebay_connector_generate_thumb($settings['category_lists_thumbnail_width'], $settings['category_lists_thumbnail_height'], $path, $name, $type);
//    category_details_thumbnail_width
    fn_wk_ebay_connector_generate_thumb($settings['category_details_thumbnail_width'], $settings['category_details_thumbnail_height'], $path, $name, $type);
//    category_detailed_image_width
    fn_wk_ebay_connector_generate_thumb($settings['category_detailed_image_width'], $settings['category_detailed_image_height'], $path, $name, $type);
//    product_admin_mini_icon_width
    fn_wk_ebay_connector_generate_thumb($settings['product_admin_mini_icon_width'], $settings['product_admin_mini_icon_height'], $path, $name, $type);

    return true;

}

function fn_wk_ebay_connector_generate_thumb($width, $height, $path, $name, $type)
{
    if (strtolower($type) == 'jpg' || strtolower($type) == 'jpeg') {
        $image = imagecreatefromjpeg($path); // For JPEG
    }
    if (strtolower($type) == 'png') {
        $image = imagecreatefrompng($path);   // For PNG
    }
    if (strtolower($type) == 'gif') {
        $image = imagecreatefromgif($path);   // For GIF
    }


    if ($height == 0 || !$height || empty($height) || $height == "") {
        $rat = $width / getimagesize($path)[0];
        $height = getimagesize($path)[1] * $rat;
    }

    fn_wk_ebay_connector_makesurepath($width, $height);
    $imgResized = imagescale($image, $width, $height);
    $arras = scandir('../');
    if (in_array('httpdocs', $arras)) {
        $dirus = 'httpdocs';
    } elseif (in_array('public_html', $arras)) {
        $dirus = 'public_html';
    } else {
        $dirus = 'htdocs';
    }
    if (strtolower($type) == 'jpg' || strtolower($type) == 'jpeg') {
        imagejpeg($imgResized, '../' . $dirus . '/images/thumbnails/' . $width . "/" . $height . $name); // For JPEG
    }
    if (strtolower($type) == 'png') {
        imagepng($imgResized, '../' . $dirus . '/images/thumbnails/' . $width . "/" . $height . $name); //for png
    }
}

function fn_wk_ebay_connector_makesurepath($width, $height)
{
    $arras = scandir('../');
    if (in_array('httpdocs', $arras)) {
        $dirus = 'httpdocs';
    } elseif (in_array('public_html', $arras)) {
        $dirus = 'public_html';
    } else {
        $dirus = 'htdocs';
    }
    if (!file_exists('../' . $dirus . '/images/thumbnails/' . $width)) {
        mkdir('../' . $dirus . '/images/thumbnails/' . $width);
    }
    if (!file_exists('../' . $dirus . '/images/thumbnails/' . $width . "/" . $height)) {
        mkdir('../' . $dirus . '/images/thumbnails/' . $width . "/" . $height);
    }
}

function fn_wk_ebay_connector_downloadUrlToFile($url, $outFileName)
{
    if (is_file($url)) {
        copy($url, $outFileName);
    } else {
        $options = array(
            CURLOPT_FILE => fopen($outFileName, 'w'),
            CURLOPT_TIMEOUT => 28800, // set this to 8 hours so we dont timeout on big files
            CURLOPT_URL => $url
        );

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpcode;
    }
}

function fn_get_cscart_mapped_category_id($ebay_category_name = "default", $account_data = array())
{
    /*
    $mapped_category_id = db_get_field("SELECT category_id FROM ?:wk_ebay_category_map WHERE ebay_category_id = ?i", $ebay_category_id);
    if ($mapped_category_id) {
        return $mapped_category_id;
    } else {
        return Registry::get("addons.wk_ebay_connector.csCart_defaultCategory");;
    }

*/
    $categoryNames = explode(":", $ebay_category_name);
    $category_ids = [];

    foreach ($categoryNames as $categoryName) {
        $categoryName = str_replace("'", "\'", $categoryName);
        if ($row = db_get_row("SELECT * FROM `?:category_descriptions` WHERE `category` = '$categoryName'")) {
            $category_ids[] = $row['category_id'];
        } else {

            $category_id = db_query("INSERT INTO `cscart_categories` (`category_id`, `parent_id`, `id_path`, `level`, `company_id`, `storefront_id`, `usergroup_ids`, `status`, `product_count`, `position`, `timestamp`, `is_op`, `localization`, `age_verification`, `age_limit`, `parent_age_verification`, `parent_age_limit`, `selected_views`, `default_view`, `product_details_view`, `product_columns`, `is_trash`, `is_default`, `category_type`) VALUES (NULL, '0', '0', '1', '0', '0', '0', 'A', '0', '20', '1649797200', 'N', '', 'N', '0', 'N', '0', '', '', 'default', '0', 'N', 'N', 'C')");
            $update_cat = db_query("UPDATE `cscart_categories` SET `id_path` = '$category_id' WHERE category_id = '$category_id'");
            $category_description_id = db_query("INSERT INTO `?:category_descriptions` (`category_id`, `lang_code`, `category`, `description`, `meta_keywords`, `meta_description`, `page_title`, `age_warning_message`) VALUES ('$category_id', 'en', '$categoryName', '<p>$categoryName</p>', '$categoryName', '$categoryName', '$categoryName', NULL) ");
            $category_ids[] = $category_id;
        }
    }

    return $category_ids;


}

function fn_wk_ebay_connector_get_remote_file_info($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_NOBODY, TRUE);
    $data = curl_exec($ch);
    $fileSize = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
    $httpResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [
        'fileExists' => (int)$httpResponseCode == 200,
        'fileSize' => (int)$fileSize
    ];
}

function fn_wk_ebay_connector_authenticate_user($ebay_AccountId)
{

    try {
        $client = null;
        $eBayConfigData = array();

        if ($ebay_AccountId && is_array($ebay_AccountId)) {
            $eBayConfigData['ebayDevId'] = $ebay_AccountId['ebay_dev_id'];
            $eBayConfigData['ebayAppId'] = $ebay_AccountId['app_id'];
            $eBayConfigData['ebayCertId'] = $ebay_AccountId['cert_id'];
            $eBayConfigData['ebayToken'] = $ebay_AccountId['oauth_token'];
            $eBayConfigData['ebaySites'] = $ebay_AccountId['shop_name'];
            $eBayConfigData['location'] = 'https://api.ebay.com/wsapi';
            $ebayMode = Registry::get("addons.wk_ebay_connector.ebay_mode");
            if ($ebayMode == 'S') {
                $eBayConfigData['location'] = 'https://api.sandbox.ebay.com/wsapi';
            }
        }

        if ($eBayConfigData) {
            if (file_exists(__DIR__ . '/Ebay_c/autoload.php')) {
                $session = new Ebay\eBaySession(
                    $eBayConfigData['ebayDevId'],
                    $eBayConfigData['ebayAppId'],
                    $eBayConfigData['ebayCertId']
                );

                $session->token = $eBayConfigData['ebayToken'];
                $session->site = $eBayConfigData['ebaySites'];
                $session->location = $eBayConfigData['location'];
                $client = new Ebay\eBaySOAP($session);

            }
            $getEbayClient = $client;
            if ($getEbayClient) {
                $current_date = new \DateTime();
                $currentDateTime = $current_date->format('Y-m-d\TH:i:s');
                $current_date->modify('+119 day');
                $endDateTime = $current_date->format('Y-m-d\TH:i:s');

                $item_data = [
                    'Version' => 659, //version
                    'IncludeVariations' => false,
                    'UserID' => '',
                    'DetailLevel' => 'ItemReturnDescription',
                    'Pagination' => array(
                        'EntriesPerPage' => 10,
                        'PageNumber' => 1
                    ),
                    'EndTimeFrom' => $currentDateTime,
                    'EndTimeTo' => $endDateTime,
                ];
                $results = $getEbayClient->GetSellerList($item_data);
            }
            if ($results->Ack == 'Success') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } catch (Exception $e) {
        fn_print_die('Error : ' . $e->getMessage());
        return false;
    }

}

function fn_check_ebay_product_availability($listing_id, $account_id, $product_id = 0)
{
    if ($product_id) {
        $result = db_get_row("SELECT * FROM ?:wk_ebay_product_map WHERE product_id = ?i AND account_id = ?i", $product_id, $account_id);
    } else {
        $result = db_get_row("SELECT * FROM ?:wk_ebay_product_map WHERE listing_id = ?i AND account_id = ?i", $listing_id, $account_id);
    }
    if (!$result) {
        $product_id = db_get_field("SELECT product_id FROM ?:products WHERE ebay_listing_id = ?i", $listing_id);
        if ($product_id)
            $result = array(
                'product_id' => $product_id,
            );
    }
    return $result;
}

function fn_create_ebay_product_map($product_id = 0, $listing_data = array(), $account_data = 0, $action = 'I')
{
    $listing_id = $listing_data['ItemID'];
    $check = fn_check_ebay_product_availability($listing_id, $account_data['id'], $product_id);
    $data = array(
        'product_id' => $product_id,
        'price' => $listing_data['SellingStatus']['CurrentPrice']['_'],
        'amount' => $listing_data['Quantity'],
        'shipping_template_id' => '0' /*$listing_data['shipping_template_id']*/,
        'category_id' => $account_data['default_cscart_category_id'],
        'is_supply' => $account_data['default_is_supply'],
        'listing_id' => $listing_id,
        'recipient' => 'test',
        'occasion' => 'test',
        'account_id' => $account_data['id'],
        'action' => isset($check['action']) && !empty($check['action']) ? $check['action'] : $action,
        'state' => 'active',
        'listing_data' => serialize($listing_data)
    );
    if (isset($check['id']) && !empty($check['id']))
        $data['id'] = $check['id'];
    db_query("REPLACE INTO ?:wk_ebay_product_map ?e", $data);
}

function fn_wk_ebay_connector_delete_product_post($product_id, $product_deleted)
{
    if ($product_deleted) {
        db_query("DELETE FROM ?:wk_ebay_product_map WHERE product_id = ?i", $product_id);
        db_query("DELETE FROM ?:wk_ebay_product_export_raw WHERE product_id = ?i", $product_id);
    }
}

function fn_wk_ebay_list_orders($params)
{
    $limit = '';
    $ebayLimit = Registry::get('settings.Appearance.admin_elements_per_page');
    $results = array();
    $ebay_orders = array();

    if (empty($params['items_per_page'])) {
        $params['items_per_page'] = Registry::get('settings.Appearance.admin_elements_per_page');
    }
    if (empty($params['page'])) {
        $params['page'] = 1;
    }
    $ebay_AccountId = fn_get_ebay_account_data($_REQUEST['account_id']);
    try {
        $client = null;
        $eBayConfigData = array();

        if ($ebay_AccountId && is_array($ebay_AccountId)) {
            $eBayConfigData['ebayDevId'] = $ebay_AccountId['ebay_dev_id'];
            $eBayConfigData['ebayAppId'] = $ebay_AccountId['app_id'];
            $eBayConfigData['ebayCertId'] = $ebay_AccountId['cert_id'];
            $eBayConfigData['ebayToken'] = $ebay_AccountId['oauth_token'];
            $eBayConfigData['ebaySites'] = $ebay_AccountId['shop_name'];
            $eBayConfigData['location'] = 'https://api.ebay.com/wsapi';
            $ebayMode = Registry::get("addons.wk_ebay_connector.ebay_mode");
            if ($ebayMode == 'S') {
                $eBayConfigData['location'] = 'https://api.sandbox.ebay.com/wsapi';
            }
        }

        if ($eBayConfigData) {
            if (file_exists(__DIR__ . '/Ebay_c/autoload.php')) {
                $session = new Ebay\eBaySession(
                    $eBayConfigData['ebayDevId'],
                    $eBayConfigData['ebayAppId'],
                    $eBayConfigData['ebayCertId']
                );

                $session->token = $eBayConfigData['ebayToken'];
                $session->site = $eBayConfigData['ebaySites'];
                $session->location = $eBayConfigData['location'];
                $client = new Ebay\eBaySOAP($session);
            }
            $getEbayClient = $client;

            $totalEbayPages = 1;
            if ($getEbayClient) {
                $current_date = new \DateTime();
                $endDateTime = $current_date->format('Y-m-d\TH:i:s');
                $current_date->modify('-365 day');
                $currentDateTime = $current_date->format('Y-m-d\TH:i:s');

                $item_data = [
                    'Version' => 849, //version
                    'IncludeVariations' => true,
                    'UserID' => '',
                    'DetailLevel' => 'ReturnAll',
                    'Pagination' => array(
                        'EntriesPerPage' => $ebayLimit,
                        'PageNumber' => $params['page']
                    ),
                    'CreateTimeFrom' => $currentDateTime,
                    'CreateTimeTo' => $endDateTime,
                ];
                $results = $getEbayClient->GetOrders($item_data);
            }

        }
        $results = json_encode($results);
        $results = json_decode($results, true);
        if (isset($results['PaginationResult']['TotalNumberOfEntries']) && $results['PaginationResult']['TotalNumberOfEntries'] < 2) {
            $ebay_orders[] = $results['OrderArray']['Order'];
        } else {
            $ebay_orders = $results['OrderArray']['Order'];
        }
        $params['total_items'] = $results['PaginationResult']['TotalNumberOfEntries'];

        return [$ebay_orders, $params];

    } catch (Exception $e) {
        $this->log->write('Error : ' . $e->getMessage());
        return [$orders, $params];
    }
}

function fn_wk_ebay_create_cscart_order($account_id, $order_id)
{

    $ebay_AccountId = fn_get_ebay_account_data($account_id);
    try {
        $client = null;
        $eBayConfigData = array();

        if ($ebay_AccountId && is_array($ebay_AccountId)) {
            $eBayConfigData['ebayDevId'] = $ebay_AccountId['ebay_dev_id'];
            $eBayConfigData['ebayAppId'] = $ebay_AccountId['app_id'];
            $eBayConfigData['ebayCertId'] = $ebay_AccountId['cert_id'];
            $eBayConfigData['ebayToken'] = $ebay_AccountId['oauth_token'];
            $eBayConfigData['ebaySites'] = $ebay_AccountId['shop_name'];
            $eBayConfigData['location'] = 'https://api.ebay.com/wsapi';
            $ebayMode = Registry::get("addons.wk_ebay_connector.ebay_mode");
            if ($ebayMode == 'S') {
                $eBayConfigData['location'] = 'https://api.sandbox.ebay.com/wsapi';
            }
        }

        if ($eBayConfigData) {
            if (file_exists(__DIR__ . '/Ebay_c/autoload.php')) {
                $session = new Ebay\eBaySession(
                    $eBayConfigData['ebayDevId'],
                    $eBayConfigData['ebayAppId'],
                    $eBayConfigData['ebayCertId']
                );

                $session->token = $eBayConfigData['ebayToken'];
                $session->site = $eBayConfigData['ebaySites'];
                $session->location = $eBayConfigData['location'];
                $client = new Ebay\eBaySOAP($session);
            }
            $getEbayClient = $client;

            $totalEbayPages = 1;
            if ($getEbayClient) {
                $current_date = new \DateTime();
                $endDateTime = $current_date->format('Y-m-d\TH:i:s');
                $current_date->modify('-365 day');
                $currentDateTime = $current_date->format('Y-m-d\TH:i:s');

                $params = ['Version' => 891,
                    'DetailLevel' => 'ReturnAll',
                    'OrderIDArray' => array(
                        'OrderID' => $order_id,
                    ),
                    'Pagination' => [
                        'EntriesPerPage' => '1',
                        'PageNumber' => (1)
                    ],
                ];

                $results = $getEbayClient->GetOrders($params);
            }

        }
        $results = json_encode($results);
        $results = json_decode($results, true);
        $ebayOrderData = $results['OrderArray']['Order'];

        Tygh::$app['session']['cart'] = isset(Tygh::$app['session']['cart']) ? Tygh::$app['session']['cart'] : array();
        $cart = &Tygh::$app['session']['cart'];

        Tygh::$app['session']['customer_auth'] = isset(Tygh::$app['session']['customer_auth']) ? Tygh::$app['session']['customer_auth'] : array();
        $customer_auth = &Tygh::$app['session']['customer_auth'];

        Tygh::$app['session']['shipping_rates'] = isset(Tygh::$app['session']['shipping_rates']) ? Tygh::$app['session']['shipping_rates'] : array();
        $shipping_rates = &Tygh::$app['session']['shipping_rates'];

        if (empty($customer_auth)) {
            $customer_auth = fn_fill_auth(array(), array(), false, 'C');
        }
        $user_data = [
            'b_address' => $ebayOrderData['BillingAddress']['Street1'] ?? 'qwer',
            'b_address_2' => $ebayOrderData['BillingAddress']['Street2'] ?? 'werty',
            'b_city' => $ebayOrderData['BillingAddress']['CityName'] ?? 'asds',
            'b_country' => $ebayOrderData['BillingAddress']['CountryName'] ?? 'India',
            'b_firstname' => $ebayOrderData['BillingAddress']['Name'] ?? 'Sagar',
            'b_lastname' => $ebayOrderData['BillingAddress']['LastName'] ?? 'Agrawal',
            'b_phone' => $ebayOrderData['BillingAddress']['Phone'] ?? '+918439712421',
            'b_state' => $ebayOrderData['BillingAddress']['StateOrProvince'] ?? 'UP',
            'b_zipcode' => $ebayOrderData['BillingAddress']['PostalCode'] ?? '201304',
            'email' => $ebayOrderData['TransactionArray']['Transaction']['Buyer']['Email'] ?? '',
            's_address' => $ebayOrderData['ShippingAddress']['Street1'] ?? 'errt',
            's_address_2' => $ebayOrderData['ShippingAddress']['Street2'] ?? 'sdfg',
            's_city' => $ebayOrderData['ShippingAddress']['CityName'] ?? 'Noida',
            's_country' => $ebayOrderData['ShippingAddress']['CountryName'] ?? 'India',
            's_firstname' => $ebayOrderData['ShippingAddress']['Name'] ?? 'Shagun',
            's_lastname' => $ebayOrderData['ShippingAddress']['LastName'] ?? 'Vaish',
            's_phone' => $ebayOrderData['ShippingAddress']['Phone'] ?? '+918439712435',
            's_state' => $ebayOrderData['ShippingAddress']['StateOrProvince'] ?? 'UP',
            's_zipcode' => $ebayOrderData['ShippingAddress']['PostalCode'] ?? '201304',
        ];
        fn_add_user_data_descriptions($user_data);
        $cart['user_data'] = $user_data;
        $cart['ship_to_another'] = 1;
        if (empty($cart['order_id'])
            && (
                Registry::get('settings.Checkout.disable_anonymous_checkout') == 'Y'
                && !empty($user_data['password1'])
            )
        ) {
            $cart['profile_registration_attempt'] = true;
            list($user_id) = fn_update_user(0, $cart['user_data'], $customer_auth, !empty($_REQUEST['ship_to_another']), true);

            if ($user_id == false) {
                $action = '';
            } else {
                $cart['user_id'] = $user_id;
                $u_data = db_get_row('SELECT user_id, tax_exempt, user_type FROM ?:users WHERE user_id = ?i', $cart['user_id']);
                $customer_auth = fn_fill_auth($u_data, array(), false, 'C');
                $cart['user_data'] = array();
            }
        }
        $newCartProd = fn_ebay_fetch_cscart_product($ebayOrderData['TransactionArray']['Transaction']['Item'], $account_id, $ebayOrderData);
        // fn_print_die($newCartProd);
        if ($newCartProd) {
            fn_add_product_to_cart($newCartProd, $cart, $customer_auth);
            if (!empty($cart['products'])) {
                fn_update_cart_by_data($cart, array(), $customer_auth);
            }
            $cart['notes'] = '';
            $store_def_setting = db_get_row('SELECT default_payment, default_shipping FROM ?:wk_ebay_account_list WHERE id = ?i', $account_id);
            $cart['payment_id'] = $store_def_setting['default_payment'];
            $cart['shipping_ids'] = array($store_def_setting['default_shipping']);
            if (!empty($cart['shipping_ids'])) {
                fn_checkout_update_shipping($cart, $cart['shipping_ids']);
            }

            if (!empty($cart['user_data']['b_address'])) {
                list($cart_products, $product_groups) = fn_calculate_cart_content($cart, $customer_auth, 'S');
            }
            $_REQUEST['dispatch'] = Registry::get('runtime.controller') . '.' . Registry::get('runtime.mode');
            if ((PRODUCT_VERSION == "4.10.4.SP1") || (PRODUCT_VERSION == "4.9.3")) {
                $cart['shipping_failed'] = "";
                $cart['company_shipping_failed'] = "";
            }
            // fn_print_die($cart);
            if (isset($cart['subtotal'])) {
                list($order_ids, $process_payment) = fn_place_order($cart, $customer_auth, 'save', Tygh::$app['session']['auth']['user_id']);

                $data = array(
                    'account_id' => $account_id,
                    'order_id' => $order_ids,
                    'ebay_order_id' => $order_id,
                    'ebay_order_total' => $ebayOrderData['Total']['_'],
                    'financial_status' => $ebayOrderData['CheckoutStatus']['Status'],
                    'currency' => $ebayOrderData['Total']['currencyID']
                );
                db_query('INSERT INTO ?:wk_ebay_order_map ?e', $data);

                if ($ebayOrderData['CheckoutStatus']['Status'] == 'Incomplete') {
                    fn_change_order_status($order_ids, STATUS_INCOMPLETED_ORDER, 'O', false);
                }

                return $order_ids;

            } else {
                fn_set_notification('E', 'Error', __("sorry_this_order_is_not_created"));
                return false;
            }
        }


    } catch (Exception $e) {
        $this->log->write('Error : ' . $e->getMessage());
        return [$orders, $params];
    }

}

function fn_ebay_fetch_cscart_product($items, $account_id, $ebayOrderData)
{

    $itemss[] = $items;
    $cartProducts = [];
    // fn_print_die($itemss,$ebayOrderData);
    foreach ($itemss as $key => $item) {
        $product_id = db_get_field('SELECT product_id FROM ?:products WHERE ebay_listing_id = ?i AND ebay_account_id = ?i AND ebay_is_parent = ?s', $item['ItemID'], $account_id, 'Y');

        if (isset($product_id) && !empty($product_id)) {
            // $variantProductId = db_get_field('SELECT product_id FROM ?:products WHERE shopify_product_id = ?i AND shopify_account_id = ?i', $item['variant_id'], $shopId);

            // $variantProductId = db_get_field('SELECT product_id FROM ?:wk_shopify_products_map WHERE account_id = ?i AND shopify_product_id = ?i AND shopify_variation_id = ?i', $shopId, $item['product_id'], $item['variant_id']);

            // if (!$variantProductId) {
            //     $variantProductId = $product_id;
            // }

            $cartProducts[$product_id]['amount'] = $ebayOrderData['TransactionArray']['Transaction']['QuantityPurchased'];
        } else {

            list($productid, $ebay_product_data) = fn_wk_ebay_import_products($item['ItemID'], $account_id);

            // fn_create_variation_of_shopify_product($productid, $shopify_product_data);

            // $variantProductId = db_get_field('SELECT product_id FROM ?:products WHERE shopify_product_id = ?i AND shopify_account_id = ?i', $item['variant_id'], $shopId);
            // $variantProductId = db_get_field('SELECT product_id FROM ?:wk_shopify_products_map WHERE account_id = ?i AND shopify_product_id = ?i AND shopify_variation_id = ?i', $shopId, $item['product_id'], $item['variant_id']);

            // if (!$variantProductId) {
            //     $variantProductId = $productid;
            // }
            $product_id = db_get_field('SELECT product_id FROM ?:products WHERE ebay_listing_id = ?i AND ebay_account_id = ?i AND ebay_is_parent = ?s', $item['ItemID'], $account_id, 'Y');

            $cartProducts[$product_id]['amount'] = $ebayOrderData['TransactionArray']['Transaction']['QuantityPurchased'];
        }
    }

    return $cartProducts;

}

function fn_wk_ebay_all_categories($account_id)
{

    $ebay_AccountId = fn_get_ebay_account_data($account_id);
    try {
        $client = null;
        $eBayConfigData = array();

        if ($ebay_AccountId && is_array($ebay_AccountId)) {
            $eBayConfigData['ebayDevId'] = $ebay_AccountId['ebay_dev_id'];
            $eBayConfigData['ebayAppId'] = $ebay_AccountId['app_id'];
            $eBayConfigData['ebayCertId'] = $ebay_AccountId['cert_id'];
            $eBayConfigData['ebayToken'] = $ebay_AccountId['oauth_token'];
            $eBayConfigData['ebaySites'] = $ebay_AccountId['shop_name'];
            $eBayConfigData['location'] = 'https://api.ebay.com/wsapi';
            $ebayMode = Registry::get("addons.wk_ebay_connector.ebay_mode");
            if ($ebayMode == 'S') {
                $eBayConfigData['location'] = 'https://api.sandbox.ebay.com/wsapi';
            }
        }

        if ($eBayConfigData) {
            if (file_exists(__DIR__ . '/Ebay_c/autoload.php')) {
                $session = new Ebay\eBaySession(
                    $eBayConfigData['ebayDevId'],
                    $eBayConfigData['ebayAppId'],
                    $eBayConfigData['ebayCertId']
                );

                $session->token = $eBayConfigData['ebayToken'];
                $session->site = $eBayConfigData['ebaySites'];
                $session->location = $eBayConfigData['location'];
                $client = new Ebay\eBaySOAP($session);
            }
            $getEbayClient = $client;

            $totalEbayPages = 1;
            if ($getEbayClient) {

                $params = ['Version' => 853,
                    'SiteID' => 0,
                    'LevelLimit' => 3,
                    'ViewAllNodes' => true,
                    'DetailLevel' => 'ReturnAll',
                    'Category' => [
                        'CategoryId' => 3034
                    ],
                    'CategoryId' => 3034
                ];

                $results = $getEbayClient->GetCategories($params);
            }

        }
        $all_categories = array();
        $categories = array();
        $results = json_encode($results);
        $all_categories = json_decode($results, true);
        $all_categories = array_slice($all_categories['CategoryArray']['Category'], 0, count($all_categories['CategoryArray']['Category']));
        foreach ($all_categories as $key => $value) {
            $categories[$key]['id'] = $value['CategoryID'];
            $categories[$key]['title'] = $value['CategoryName'];
        }
        // $aa['id'] = '162925';
        // $aa['title'] = 'Balusters';
        // $categories = array_merge($categories,$aa);
        array_multisort(array_column($categories, 'title'), SORT_ASC, SORT_NATURAL | SORT_FLAG_CASE, $categories);
        return $categories;
    } catch (Exception $e) {
        $this->log->write('Error : ' . $e->getMessage());
        return [$orders, $params];
    }

}

function fn_wk_ebay_getMappedCategory($account_id)
{
    $mappedCat = [];
    try {
        // $mappedCat = db_get_array('SELECT * FROM ?:wk_ebay_category_map WHERE account_id = ?i', $account_id);
        $mappedCat = db_get_array('SELECT * FROM ?:wk_ebay_category_map');
        return $mappedCat;
    } catch (ShopifyApiException $e) {
        fn_set_notification('E', 'Error', $e->getMessage());
    } catch (ShopifyCurlException $e) {
        fn_set_notification('E', 'Error', $e->getMessage());
    }

}

function fn_wk_ebay_category_map($mapData)
{
    try {
        $data = array(
            'category_id' => $mapData['cs_cart_category'],
            'ebay_category_id' => $mapData['ebay_category'],
            'ebay_category' => $mapData['ebay_category_name'],
            'account_id' => $mapData['account_id'],
        );
        db_query('INSERT INTO ?:wk_ebay_category_map ?e', $data);

        return true;
    } catch (Exception $e) {
        fn_set_notification('E', 'Error', $e->getMessage());

        return false;
    }

}

function fn_wk_ebay_fetchOrdersByShop($shopId)
{
    $ebayorder = $orders = [];
    try {
        $params = $_REQUEST;
        $condition = '';
        $limit = '';
        $order = '';
        $join = '';
        if (isset($_REQUEST['sort_order'])) {
            if ($_REQUEST['sort_order'] == 'asc') {
                $params['sort_order_rev'] = 'desc';
                $params['sort_order'] = $_REQUEST['sort_order'];
            } else {
                $params['sort_order_rev'] = 'asc';
                $params['sort_order'] = $_REQUEST['sort_order'];
            }
        }

        if (isset($params['sort_by'])) {
            $order .= 'ORDER BY ' . $params['sort_by'] . ' ' . $params['sort_order'];
        } else {
            $order .= 'ORDER BY order_id DESC';
            $params['sort_by'] = 'order_id';
            $params['sort_order'] = 'desc';
        }
        if (isset($params['account_id']) && !empty($params['account_id'])) {
            $condition .= db_quote('AND account_id = ?i', "{$shopId}");
        }

        if (empty($params['items_per_page'])) {
            $params['items_per_page'] = Registry::get('settings.Appearance.admin_elements_per_page');
        }
        if (empty($params['page'])) {
            $params['page'] = 1;
        }

        $params['total_items'] = db_get_field("SELECT count(*) FROM ?:wk_ebay_order_map WHERE 1 $condition $order $limit");
        if (!empty($params['limit'])) {
            $limit = db_quote(' LIMIT 0, ?i', $params['limit']);
        } elseif (!empty($params['items_per_page'])) {
            $limit = db_paginate($params['page'], $params['items_per_page'], $params['total_items']);
        }

        $orders = db_get_array("SELECT * FROM ?:wk_ebay_order_map WHERE 1 $condition $order $limit");


        return [$orders, $params];
    } catch (Exception $e) {
        fn_set_notification('E', 'Error', $e->getMessage());
    }

}


function fn_wk_ebay_single_product($listing_id, $ebay_AccountId)
{

    $client = null;

    $eBayConfigData = array();

    if ($ebay_AccountId && is_array($ebay_AccountId)) {
        $eBayConfigData['ebayDevId'] = $ebay_AccountId['ebay_dev_id'];
        $eBayConfigData['ebayAppId'] = $ebay_AccountId['app_id'];
        $eBayConfigData['ebayCertId'] = $ebay_AccountId['cert_id'];
        $eBayConfigData['ebayToken'] = $ebay_AccountId['oauth_token'];
        $eBayConfigData['ebaySites'] = $ebay_AccountId['shop_name'];
        $eBayConfigData['location'] = 'https://api.ebay.com/wsapi';
        $ebayMode = Registry::get("addons.wk_ebay_connector.ebay_mode");
        if ($ebayMode == 'S') {
            $eBayConfigData['location'] = 'https://api.sandbox.ebay.com/wsapi';
        }
    }

    if ($eBayConfigData) {
        if (file_exists(__DIR__ . '/Ebay_c/autoload.php')) {
            $session = new Ebay\eBaySession(
                $eBayConfigData['ebayDevId'],
                $eBayConfigData['ebayAppId'],
                $eBayConfigData['ebayCertId']
            );

            $session->token = $eBayConfigData['ebayToken'];
            $session->site = $eBayConfigData['ebaySites'];
            $session->location = $eBayConfigData['location'];
            $client = new Ebay\eBaySOAP($session);
        }
        $getEbayClient = $client;
        if ($getEbayClient) {

            $params = array(
                'Version' => 659,
                'DetailLevel' => 'ReturnAll',
                'ItemID' => $listing_id,
            );

            $results = $getEbayClient->GetItem($params);
            if (isset($results->Ack) && $results->Ack) {
                $results = json_encode($results);
                $results = json_decode($results, true);
                fn_print_die($results['Item']);
            }
        }

    }


}

