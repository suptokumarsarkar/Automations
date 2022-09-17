<?php
$schema['controllers']['wk_ebay'] = array (
    'permissions' => true,
);
$schema['controllers']['wk_ebay_order'] = array (
    'permissions' => true,
);

$schema['controllers']['wk_ebay_product'] = array (
    'permissions' => true,
);

$schema['controllers']['tools']['modes']['update_status']['param_permissions']['table']['wk_ebay_account_list'] = true;

return $schema;