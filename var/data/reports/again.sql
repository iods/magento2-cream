Useful SQL snippets for a Magento store.
000 - Magento SQL Snippets.md
Numerous SQL snippets to reference for pulling data straight from Magento's database.

All SQL snippets assume there is no database table name prefix configured. In the event that your database does have a table nameprefix, you should be able to simply update the original table names found in the "FROM" and "LEFT JOIN" declarations. All table names are aliased therefore a full revision of the SQL snippets would not be necessary.

001 - database.sql
# Show Size of tables in MB
SELECT
  table_name AS "Table",
  round(((data_length + index_length) / 1024 / 1024), 2) as "TABLE_SIZE (MB)"
FROM
  information_schema.TABLES
WHERE table_schema = "DATABASE_NAME" # <!-- Update this with DB name
002 - catalog_product.sql
# Select VARCHAR data type values from catalog products
SELECT `cpe`.`entity_id`, `cpe`.`sku`, `cpev`.`value`
FROM `catalog_product_entity`              AS `cpe`
LEFT JOIN `catalog_product_entity_varchar` AS `cpev` ON `cpev`.`entity_id`=`cpe`.`entity_id`
LEFT JOIN `eav_attribute`                  AS `ea`   ON `ea`.`attribute_id`=`cpev`.`attribute_id`
LEFT JOIN `eav_entity_type`                AS `eat`  ON `eat`.`entity_type_id`=`ea`.`entity_type_id`
WHERE `eat`.`entity_type_code` = 'catalog_product'
AND `ea`.`attribute_code` = 'name' # <-- REPLACE WITH YOUR ATTRIBUTE CODE
#AND `cpe`.`entity_id` = ''        # <-- UNCOMMENT TO FILTER BY PRODUCT ID
#AND `cpe`.`sku` = ''              # <-- UNCOMMENT TO FILTER BY SKU
ORDER BY `cpev`.`value`;

# Select TEXT data type values from catalog products
SELECT `cpe`.`entity_id`, `cpe`.`sku`, `cpet`.`value`
FROM `catalog_product_entity`           AS `cpe`
LEFT JOIN `catalog_product_entity_text` AS `cpet` ON `cpet`.`entity_id`=`cpe`.`entity_id`
LEFT JOIN `eav_attribute`               AS `ea`   ON `ea`.`attribute_id`=`cpet`.`attribute_id`
LEFT JOIN `eav_entity_type`             AS `eat`  ON `eat`.`entity_type_id`=`ea`.`entity_type_id`
WHERE `eat`.`entity_type_code` = 'catalog_product'
AND `ea`.`attribute_code` = 'description' # <-- REPLACE WITH YOUR ATTRIBUTE CODE
#AND `cpe`.`entity_id` = ''               # <-- UNCOMMENT TO FILTER BY PRODUCT ID
#AND `cpe`.`sku` = ''                     # <-- UNCOMMENT TO FILTER BY SKU
ORDER BY `cpet`.`value`;

# Select INT data type values from catalog products
SELECT `cpe`.`entity_id`, `cpe`.`sku`, `cpei`.`value`
FROM `catalog_product_entity`          AS `cpe`
LEFT JOIN `catalog_product_entity_int` AS `cpei` ON `cpei`.`entity_id`=`cpe`.`entity_id`
LEFT JOIN `eav_attribute`              AS `ea`   ON `ea`.`attribute_id`=`cpei`.`attribute_id`
LEFT JOIN `eav_entity_type`            AS `eat`  ON `eat`.`entity_type_id`=`ea`.`entity_type_id`
WHERE `eat`.`entity_type_code` = 'catalog_product'
AND `ea`.`attribute_code` = 'color' # <-- REPLACE WITH YOUR ATTRIBUTE CODE
#AND `cpe`.`entity_id` = ''         # <-- UNCOMMENT TO FILTER BY PRODUCT ID
#AND `cpe`.`sku` = ''               # <-- UNCOMMENT TO FILTER BY SKU
ORDER BY `cpei`.`value`;

# Select the media gallery information for a product
SELECT
    `cpe`.`entity_id`    AS `product_id`,
    `cpemgv`.`value_id`,
    `cpemg`.`value`      AS `file`,
    `cpemgv`.`label`     AS `label`
FROM `catalog_product_entity_media_gallery_value` AS `cpemgv`
LEFT JOIN `catalog_product_entity_media_gallery`  AS `cpemg` ON `cpemgv`.`value_id`=`cpemg`.`value_id`
LEFT JOIN `catalog_product_entity`                AS `cpe`   ON `cpe`.`entity_id`=`cpemg`.`entity_id`
#WHERE `cpe`.`entity_id` '0' # <!-- UNCOMMENT TO FILTER BY PRODUCT ID
ORDER BY `cpe`.`entity_id` ASC;
003 - catalog_category.sql
# Shows the sort order value of each attribute in a group.
SELECT
    `eav_attribute`.`attribute_code`,
    `eav_entity_attribute`.`sort_order`,
    `eav_attribute_group`.`attribute_group_name`
FROM
    `eav_entity_attribute`
LEFT JOIN
    `eav_attribute_group`
        ON `eav_attribute_group`.`attribute_group_id` = `eav_entity_attribute`.`attribute_group_id`
LEFT JOIN
    `eav_attribute`
        ON `eav_attribute`.`attribute_id` = `eav_entity_attribute`.`attribute_id`
WHERE
    `eav_attribute_group`.`attribute_group_name` = 'General Information' # Change this to your group name.
AND
    `eav_entity_attribute`.`entity_type_id` = '3'
ORDER BY
    `sort_order`;


# Show the order of Attribute Groups
SELECT * FROM `eav_attribute_group` WHERE `attribute_set_id` = '3' ORDER BY `sort_order`;
