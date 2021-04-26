SELECT `admin_passwords`.`password_id`,
    `admin_passwords`.`user_id`,
    `admin_passwords`.`password_hash`,
    `admin_passwords`.`expires`,
    `admin_passwords`.`last_updated`
FROM `magento`.`admin_passwords`;

SELECT `admin_user`.`user_id`,
    `admin_user`.`firstname`,
    `admin_user`.`lastname`,
    `admin_user`.`email`,
    `admin_user`.`username`,
    `admin_user`.`password`,
    `admin_user`.`created`,
    `admin_user`.`modified`,
    `admin_user`.`logdate`,
    `admin_user`.`lognum`,
    `admin_user`.`reload_acl_flag`,
    `admin_user`.`is_active`,
    `admin_user`.`extra`,
    `admin_user`.`rp_token`,
    `admin_user`.`rp_token_created_at`,
    `admin_user`.`interface_locale`,
    `admin_user`.`failures_num`,
    `admin_user`.`first_failure`,
    `admin_user`.`lock_expires`,
    `admin_user`.`refresh_token`
FROM `magento`.`admin_user`;