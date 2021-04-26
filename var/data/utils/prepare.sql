/*
 * Prepare SQL Queries for Magento Development Environment
 *
 * 1. Update URLS for default store
 * 2. Update Elasticsearch Host Information
 * 3. Disables CSS/JS Merging/Minifying/Signing
 * 4. Set Cache to FPC
 * 5. Update MSP & TFA configurations
 * 6. Deactivate any Marketing Accounts for tracking locally
 * 7. Set Demo Notice that developer is local
 */

SET @base_url = 'https://lci1magento2.test';
-- https://stackoverflow.com/a/46143816
-- replace "magento" with your database name
SELECT
    TABLE_NAME AS `Table`,
    ROUND(((DATA_LENGTH + INDEX_LENGTH) / 1024 / 1024),2) AS `Size (MB)`
FROM
    information_schema.TABLES
WHERE
        TABLE_SCHEMA = "magento"
ORDER BY
    (DATA_LENGTH + INDEX_LENGTH)
    DESC;


/*
 * Update URLS for default store
 */
UPDATE core_config_data
   SET value = @base_url
 WHERE path = 'web/unsecure/base_url';

UPDATE core_config_data
   SET value = @base_url
 WHERE path = 'web/secure/base_url';

UPDATE core_config_data
   SET value = @base_url
 WHERE path = 'web/secure/use_in_frontend';

UPDATE core_config_data
   SET value = @base_url
 WHERE path = 'web/secure/use_in_adminhtml';


/*
 * Update Elasticsearch Host Information
 */
UPDATE core_config_data
   SET value = 'localhost:9200'
 WHERE path = 'smile_elasticsuite_core_base_settings/es_client/servers';

UPDATE core_config_data
   SET value = 'localhost'
 WHERE path = 'catalog/search/elasticsearch6_server_hostname';


/*
 * Disables CSS/JS Merging/Minifying/Signing (here for profiling)
 * * First query will show status
 * * Following queries update values to 0
 */
SELECT *
  FROM core_config_data
 WHERE path
  LIKE 'dev/%';

UPDATE core_config_data
   SET value = 0
 WHERE path = 'dev/css/merge_css_files';

UPDATE core_config_data
   SET value = 0
 WHERE path = 'dev/css/minify_files';

UPDATE core_config_data
   SET value = 0
 WHERE path = 'dev/js/merge_files';

UPDATE core_config_data
   SET value = 0
 WHERE path = 'dev/js/enable_js_bundling';

UPDATE core_config_data
   SET value = 0
 WHERE path = 'dev/js/minify_files';

UPDATE core_config_data
   SET value = 0
 WHERE path = 'dev/static/sign';

/*
 * Set Cache to FPC
 */
UPDATE core_config_data
   SET value = 1
 WHERE path = 'system/full_page_cache/caching_application';


/*
 * Update MSP & TFA configurations
 */
UPDATE core_config_data
   SET value = 0
 WHERE path = 'msp_securitysuite_adminrestriction/general/enabled';

UPDATE core_config_data
   SET value = 0
 WHERE path = 'msp_securitysuite_recaptcha/backend/enabled';

UPDATE core_config_data
   SET value = 0
 WHERE path = 'msp_securitysuite_recaptcha/backend/enabled';

UPDATE core_config_data
   SET value = 0
 WHERE path = 'msp_securitysuite_twofactorauth/google/enabled';


/*
 * Deactivate any Marketing Accounts for tracking locally
 */
UPDATE core_config_data
   SET value = 0
 WHERE path = 'google/analytics/active';

UPDATE core_config_data
   SET value = NULL
 WHERE path = 'google/analytics/account';

/*
 * Finally, set Demo Notice that developer is local
 */
INSERT INTO core_config_data (scope, scope_id, path, value)
VALUES ('default', 0, 'design/head/demonotice', 1)
ON DUPLICATE KEY UPDATE value = 1;

UPDATE core_config_data
   SET value = 1
 WHERE path = 'design/head/demonotice';