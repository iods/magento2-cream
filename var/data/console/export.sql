Here's a bit of SQL code to export all the configurable-simple product relations from a Magento database in a format that MAGMI can import!
gistfile1.sql
SELECT
    parent.sku as 'sku',
    eav.attribute_code as 'configurable_attribute',
    GROUP_CONCAT(child.sku SEPARATOR ',') as 'simples_skus'
FROM catalog_product_super_link
    INNER JOIN catalog_product_entity as child ON catalog_product_super_link.product_id = child.entity_id
    INNER JOIN catalog_product_entity as parent ON catalog_product_super_link.parent_id = parent.entity_id
    INNER JOIN catalog_product_super_attribute as super ON  super.product_id = parent.entity_id
    INNER JOIN eav_attribute as eav ON eav.attribute_id = super.attribute_id
Group By parent.sku
@groggu
Owner
Author
groggu commented on Oct 12, 2015
Output looks like this -

sku, configurable_attribute, simples_skus
1004845,bracelet_size,"1004845-21,1004845-19,1004845-23"
1004845-D,bracelet_size,"1004845-36,1004845-42,1004845-38,1004845-44"
1004845-T,bracelet_size,"1004845-54,1004845-60,1004845-65,1004845-57,1004845-63"
1004851,bracelet_size,"1004851-54,1004851-60,1004851-57,1004851-63"