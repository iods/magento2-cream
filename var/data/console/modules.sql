FROM `magento`.`store_website`;SELECT `setup_module`.`module`,
    `setup_module`.`schema_version`,
    `setup_module`.`data_version`
FROM `magento`.`setup_module`;