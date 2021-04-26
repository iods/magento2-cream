UPDATE `magento`.`core_config_data` SET `value` = 'http://yoursite.com' WHERE `core_config_data`.`path` ='web/unsecure/base_url';
UPDATE `magento`.`core_config_data` SET `value` = 'https://yoursite.com' WHERE `core_config_data`.`path` ='web/secure/base_url';
UPDATE `magento`.`core_config_data` SET `value` = 1 WHERE `core_config_data`.`path` ='web/secure/use_in_frontend';
UPDATE `magento`.`core_config_data` SET `value` = 1 WHERE `core_config_data`.`path` ='web/secure/use_in_adminhtml';