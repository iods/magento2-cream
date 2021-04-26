
-- A series of MySQL statements to run to prepare your Magento 1.9.* install for running on
-- your development environment; for instance, after downloading a DB from production.

-- Make sure to replace :
--   PREFIX_
--   @base_url
--   @email

-- Variables
SET @base_url = 'http://yourlocalurl.dev/';
SET @email = 'your@email_here.com';

-- Set urls
UPDATE PREFIX_core_config_data SET value = @base_url WHERE path = 'web/unsecure/base_url';
UPDATE PREFIX_core_config_data SET value = @base_url WHERE path = 'web/secure/base_url';

-- Disable all caches
UPDATE PREFIX_core_cache_option SET value = 0;@

-- Set emails
UPDATE PREFIX_core_config_data SET value = @email WHERE path = 'trans_email/ident_general/email';
UPDATE PREFIX_core_config_data SET value = @email WHERE path = 'trans_email/ident_sales/email';
UPDATE PREFIX_core_config_data SET value = @email WHERE path = 'trans_email/ident_support/email';
UPDATE PREFIX_core_config_data SET value = @email WHERE path = 'trans_email/ident_custom1/email';
UPDATE PREFIX_core_config_data SET value = @email WHERE path = 'trans_email/ident_custom2/email';
UPDATE PREFIX_core_config_data SET value = @email WHERE path = 'system/log/error_email';

-- Logging
UPDATE PREFIX_core_config_data SET value = 1 WHERE path = 'dev/log/active';

-- Disable analytics
UPDATE PREFIX_core_config_data SET value = NULL WHERE path = 'google/analytics/account';
UPDATE PREFIX_core_config_data SET value = NULL WHERE path = 'google/tagmanager/snippet';

-- Enable Commercebug, if approppriate
UPDATE PREFIX_core_config_data SET value = 1 WHERE path = 'commercebug/options/show_interface';

-- Truncate tables containing environment specific content
SET FOREIGN_KEY_CHECKS = 0;

-- Log tables
TRUNCATE PREFIX_log_customer;
TRUNCATE PREFIX_log_quote;
TRUNCATE PREFIX_log_summary;
TRUNCATE PREFIX_log_summary_type;
TRUNCATE PREFIX_log_url;
TRUNCATE PREFIX_log_url_info;
TRUNCATE PREFIX_log_visitor;
TRUNCATE PREFIX_log_visitor_info;
TRUNCATE PREFIX_log_visitor_online;
TRUNCATE PREFIX_core_cache;
TRUNCATE PREFIX_core_cache_option;
TRUNCATE PREFIX_core_cache_tag;
TRUNCATE PREFIX_enterprise_logging_event;
TRUNCATE PREFIX_enterprise_logging_event_changes;
TRUNCATE PREFIX_index_event;
TRUNCATE PREFIX_index_process_event;
TRUNCATE PREFIX_report_event;
TRUNCATE PREFIX_report_viewed_product_index;
TRUNCATE PREFIX_dataflow_batch_export;
TRUNCATE PREFIX_dataflow_batch_import;
TRUNCATE PREFIX_core_session;

SET FOREIGN_KEY_CHECKS = 1;
