#  Back up Database first 

TRUNCATE `admin_passwords`;
TRUNCATE `admin_user`;
TRUNCATE `admin_user_session`;
TRUNCATE `authorization_role`;
TRUNCATE `authorization_rule`;

INSERT INTO `authorization_role` (`role_id`, `parent_id`, `tree_level`, `sort_order`, `role_type`, `user_id`, `user_type`, `role_name`, `gws_is_all`, `gws_websites`, `gws_store_groups`) VALUES (NULL, ''0'', ''1'', ''1'', ''G'', ''0'', ''2'', ''Administrators'', ''1'', NULL, NULL);

INSERT INTO `authorization_rule` 
    (`rule_id`, `role_id`, `resource_id`, `privileges`, `permission`) 
VALUES (1, 1, ''Magento_Backend::all'', NULL, ''allow'')