-- Update all dev settings to false
UPDATE `core_config_data`
SET `value` = 0
WHERE (`path` REGEXP '^dev.*')
AND `value` = 1;

-- Update Sphinx when using Mirasvit Sphinx Search
UPDATE `core_config_data`
SET `value` = 'mysql2'
WHERE `value` = 'sphinx';

-- Remove staging urls
UPDATE `core_config_data`
SET `value` = replace(`value`, 'https://staging.', 'https://')
WHERE (`path` REGEXP '^web/.*/base.*url$');

-- Update base_urls from www to non www
UPDATE `core_config_data`
SET `value` = replace(`value`, 'https://www.', 'https://')
WHERE (`path` REGEXP '^web/.*/base.*url$');

-- Update base_urls file extensions to .test
UPDATE core_config_data
SET value =
CASE
WHEN value REGEXP '.*.co.uk/' THEN replace(value, '.co.uk', '.test')
WHEN value REGEXP '.*.co.uk' THEN replace(value, '.co.uk', '.test/')
ELSE replace(value, substring_index(value, '.', -1), 'test/')
END
WHERE (path REGEXP '^web/.*/base.*url$')
AND value REGEXP 'http.*';

-- Update Elastic host to localhost
UPDATE `core_config_data`
SET `value` = 'localhost:9200'
WHERE `path` = 'smile_elasticsuite_core_base_settings/es_client/servers';

-- Update Elastic hostname to localhost
UPDATE `core_config_data`
SET `value` = 'localhost'
WHERE `path` = 'catalog/search/elasticsearch6_server_hostname';

-- Set caching application to 1
UPDATE `core_config_data`
SET `value` = 1
WHERE `path` = 'system/full_page_cache/caching_application';

-- Disable MSP admin restriction
UPDATE `core_config_data`
SET `value` = '0'
WHERE `path` = 'msp_securitysuite_adminrestriction/general/enabled';

-- Disable MSP recaptcha
UPDATE `core_config_data`
SET `value` = 0
WHERE `path` = 'msp_securitysuite_recaptcha/backend/enabled';

-- Disable MSP recaptcha
UPDATE `core_config_data`
SET `value` = 0
WHERE `path` = 'msp_securitysuite_recaptcha/backend/enabled';

-- Disable TFA
UPDATE `core_config_data`
SET `value` = 0
WHERE `path` = 'msp_securitysuite_twofactorauth/google/enabled';