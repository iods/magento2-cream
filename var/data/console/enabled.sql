SELECT `e`.*, IF(at_status.value_id > 0, at_status.value, at_status_default.value) AS `status`
FROM `catalog_product_entity` AS `e`
INNER JOIN `catalog_product_entity_int` AS `at_status_default`
 ON (`at_status_default`.`entity_id` = `e`.`entity_id`)
  AND (`at_status_default`.`attribute_id` = '98')
  AND `at_status_default`.`store_id` = 0
LEFT JOIN `catalog_product_entity_int` AS `at_status`
 ON (`at_status`.`entity_id` = `e`.`entity_id`)
  AND (`at_status`.`attribute_id` = '98')
  AND (`at_status`.`store_id` = 1)
WHERE (IF(at_status.value_id > 0, at_status.value, at_status_default.value) = '1');