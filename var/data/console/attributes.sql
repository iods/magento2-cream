Magento 1-2.x, How to clean up attributes not in attribute set in SQL
clean-attributes1.sql
-- source: https://stackoverflow.com/a/19404477/158325

CREATE TABLE catalog_product_entity_int_old LIKE catalog_product_entity_int;
INSERT INTO catalog_product_entity_int_old SELECT * FROM catalog_product_entity_int;

DELETE FROM catalog_product_entity_int
    WHERE value_id IN
        (SELECT cpei.value_id
            FROM catalog_product_entity_int_old cpei
            WHERE cpei.attribute_id NOT IN
                (SELECT eea.attribute_id
                    FROM eav_entity_attribute eea
                        JOIN catalog_product_entity cpe ON eea.attribute_set_id = cpe.attribute_set_id
                    WHERE cpe.entity_id = cpei.entity_id)
        ORDER BY cpei.entity_id)
clean-attributes2.sql
DELETE FROM catalog_product_index_eav WHERE
attribute_id NOT IN (
    (SELECT eea.attribute_id
    FROM eav_entity_attribute eea
        JOIN catalog_product_entity cpe ON eea.attribute_set_id = cpe.attribute_set_id
    WHERE cpe.entity_id = catalog_product_index_eav.entity_id)
);