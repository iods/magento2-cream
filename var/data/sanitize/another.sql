Magento Database Sanitizer
db_sanitize.sql
# these scripts run against the db and clear out sensitive information and make the db ready for develoeprs and staging.

#admin password
update admin_user set password = MD5('admin') where username = 'admin';

update core_config_data set value = '0' where path = 'admin/url/use_custom_path';
update core_config_data set value = '0' where path = 'admin/url/use_custom';

#newsletter subscriber emails
UPDATE newsletter_subscriber SET subscriber_email = CONCAT('subscriber_',subscriber_id, '@gosolid.net');

#consign quotes emails
UPDATE consign_quote SET email = CONCAT('customer_id_', customer_id, '@gosolid.net');

SET SQL_SAFE_UPDATES = 0;

#remove all log tables
TRUNCATE TABLE captcha_log;
TRUNCATE TABLE log_customer;
TRUNCATE TABLE log_quote;
TRUNCATE TABLE log_summary;
TRUNCATE TABLE log_summary_type;
TRUNCATE TABLE log_url;
TRUNCATE TABLE log_url_info;
TRUNCATE TABLE log_visitor;
TRUNCATE TABLE log_visitor_info;
TRUNCATE TABLE log_visitor_online;
TRUNCATE TABLE sendfriend_log;
TRUNCATE TABLE dataflow_batch_export;
TRUNCATE TABLE dataflow_batch_import;
TRUNCATE TABLE report_event;
TRUNCATE TABLE report_viewed_product_index;

#remove catalog searches
SET FOREIGN_KEY_CHECKS=0;
TRUNCATE `catalogsearch_query`;
TRUNCATE `catalogsearch_result`;
ALTER TABLE `catalogsearch_query` AUTO_INCREMENT=1;
ALTER TABLE `catalogsearch_result` AUTO_INCREMENT=1;
SET FOREIGN_KEY_CHECKS=1;


UPDATE sales_flat_order SET customer_email = CONCAT('order_id_',entity_id, '@gosolid.net');
UPDATE sales_flat_quote SET customer_email = CONCAT('order_id_',entity_id, '@gosolid.net');
# end sales


UPDATE customer_entity SET email = CONCAT('customer_id_',entity_id, '@gosolid.net');

SET FOREIGN_KEY_CHECKS=1;

SET SQL_SAFE_UPDATES = 0;