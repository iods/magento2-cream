 ----------------------------------------------------------------------------- #
 -- Version 0.1

 -- Updates the URL settings across various stores and services.
 --     * web/unsecure/base_url
 --     * web/secure/base_url
 --     * web/unsecure/base_media_url
 --     * web/cookie/cookie_domain
 ----------------------------------------------------------------------------- #

/* Set the vars for each website scope */
SET @url_lippert = 'lci1magento2.test',
    @url_aquatrainingbag = 'atbmagento2.test',
    @url_taylormade = 'tmcmagento2.test'
    @protocol = 'https://';  -- set this to http:// if no cert is installed locally

/* Update the values for LCI Store */
UPDATE core_config_data
   SET value = CONCAT('http://', @url_lippert, '/')
 WHERE path = 'web/unsecure/base_url';

 UPDATE core_config_data
   SET value = CONCAT(@protocol, @url_lippert, '/')
 WHERE path = 'web/secure/base_url';

 UPDATE core_config_data
   SET value = CONCAT('http://', @url_lippert, '/media/')
 WHERE path = 'web/unsecure/base_media_url';

 UPDATE core_config_data
   SET value = @url_lippert
 WHERE path = 'web/cookie/cookie_domain';

/* Update the values for Aqua Training Bag */
UPDATE core_config_data
   SET value = CONCAT('http://', @url_aquatrainingbag, '/')
 WHERE path = 'web/unsecure/base_url';

 UPDATE core_config_data
   SET value = CONCAT(@protocol, @url_aquatrainingbag, '/')
 WHERE path = 'web/secure/base_url';

 UPDATE core_config_data
   SET value = CONCAT('http://', @url_aquatrainingbag, '/media/')
 WHERE path = 'web/unsecure/base_media_url';

 UPDATE core_config_data
   SET value = @url_lippert
 WHERE path = 'web/cookie/cookie_domain';

/* Update the values for Taylor Made */
UPDATE core_config_data
   SET value = CONCAT('http://', @url_taylormade, '/')
 WHERE path = 'web/unsecure/base_url';

 UPDATE core_config_data
   SET value = CONCAT(@protocol, @url_taylormade, '/')
 WHERE path = 'web/secure/base_url';

 UPDATE core_config_data
   SET value = CONCAT('http://', @url_taylormade, '/media/')
 WHERE path = 'web/unsecure/base_media_url';

 UPDATE core_config_data
   SET value = @url_lippert
 WHERE path = 'web/cookie/cookie_domain';