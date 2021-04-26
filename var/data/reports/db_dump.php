<?php

$options = getopt('h:u:p:d:');

//if (!isset($options['h']) || !isset($options['u']) || !isset($options['p']) || !isset($options['d'])) {
//    die(PHP_EOL . 'Usage: php light-db-dump.php -h{db_host} -u{db_user} -p{db_pass} -d{db_name}' . PHP_EOL . PHP_EOL);
//}

$dbName = 'Magento';
//$dbUser = 'root';
//$dbPass = '123123q';
//$dbHost = 'localhost';

//$dbName = $options['d'];
//$dbUser = $options['u'];
//$dbPass = $options['p'];
//$dbHost = $options['h'];

//tables will be installed with no data
$noDataTables = array(
    'enterprise_customer_sales_flat_order',
    'enterprise_customer_sales_flat_order_address',
    'enterprise_customer_sales_flat_quote',
    'enterprise_customer_sales_flat_quote_address',
    'enterprise_reminder_rule_coupon',
    'enterprise_sales_order_grid_archive',
    'enterprise_sales_shipment_grid_archive',
    'sales_flat_order',
    'sales_flat_order_address',
    'sales_flat_order_grid',
    'sales_flat_order_item',
    'sales_flat_order_payment',
    'sales_flat_order_status_history',
    'sales_flat_shipment',
    'sales_flat_shipment_comment',
    'sales_flat_shipment_grid',
    'sales_flat_shipment_item',
    'sales_flat_shipment_track',
    'sales_order_aggregated_created',
    'sales_order_aggregated_updated',
    'sales_order_coupon',
    'sales_order_status',
    'sales_order_status_label',
    'sales_order_status_state',
    'sales_order_tax',
    'sales_order_tax_item',
    'sales_payment_transaction',
    'sales_shipping_aggregated',
    'sales_shipping_aggregated_order',
    'salesrule',
    'salesrule_coupon',
    'salesrule_coupon_usage',
    'salesrule_customer',
    'salesrule_customer_group',
    'salesrule_label',
    'salesrule_product_attribute',
    'salesrule_website',
    'sales_bestsellers_aggregated_daily',
    'sales_bestsellers_aggregated_monthly',
    'sales_bestsellers_aggregated_yearly',
    'sales_flat_quote',
    'sales_flat_quote_address',
    'sales_flat_quote_address_item',
    'sales_flat_quote_item',
    'sales_flat_quote_item_option',
    'sales_flat_quote_payment',
    'sales_flat_quote_shipping_rate',
    'customer_address_entity',
    'customer_address_entity_datetime',
    'customer_address_entity_decimal',
    'customer_address_entity_int',
    'customer_address_entity_text',
    'customer_address_entity_varchar',
    'customer_entity',
    'customer_entity_datetime',
    'customer_entity_decimal',
    'customer_entity_int',
    'customer_entity_text',
    'customer_entity_varchar',
    'customer_flowpassword',
    'captcha_log',
    'catalog_compare_item',
    'catalog_product_entity_text', //FOR THIS TABLE ONLY NON-EMPTY, NON-NULL VALUES WILL BE DUMPED IN THE LAST STEP
    'catalogsearch_query',
    'catalogsearch_fulltext',
    'core_cache',
    'core_cache_tag',
    'core_email_queue',
    'core_session',
    'coupon_aggregated',
    'coupon_aggregated_order',
    'coupon_aggregated_updated',
    'cron_schedule',
    'custom_quote_visitor_log',
    'dataflow_batch_export',
    'dataflow_batch_import',
    'enterprise_cms_page_revision',
    'enterprise_logging_event',
    'enterprise_logging_event_changes',
    'enterprise_reminder_rule_log',
    'index_event',
    'index_process_event',
    'log_customer',
    'log_quote',
    'log_summary',
    'log_summary_type',
    'log_url',
    'log_url_info',
    'log_visitor',
    'log_visitor_info',
    'log_visitor_online',
    'newsletter_subscriber',
    'report_compared_product_index',
    'report_event',
    'report_viewed_product_aggregated_daily',
    'report_viewed_product_aggregated_monthly',
    'report_viewed_product_aggregated_yearly',
    'report_viewed_product_index',
    'review_detail',
    'review_store',
    'review_entity_summary',
    'tax_order_aggregated_created',
    'tax_order_aggregated_updated',
    'wishlist',
    'wishlist_item',
    'wishlist_item_option',
);

//tables that will not be installed
$ignoreTables = array(
);

$firstPart = '';
foreach (array_merge($noDataTables, $ignoreTables) as $table) {
    $firstPart .= "--ignore-table='{$dbName}'.'{$table}' ";
}

$secondPart = '';
foreach ($noDataTables as $table) {
    $secondPart .= "{$table} ";
}

echo exec("mysqldump --single-transaction --skip-lock-tables -f {$firstPart} {$dbName} > db-copy.sql");
echo exec("mysqldump --single-transaction --skip-lock-tables -f --no-data {$dbName} {$secondPart} >> db-copy.sql");

echo exec("mysqldump --single-transaction --skip-lock-tables -f {$dbName} catalog_product_entity_text --no-create-info --where=\"value is not null and value <> ''\" >> db-copy.sql");

exec("env GZIP=-9 tar cvzf db-copy.tar.gz db-copy.sql");
