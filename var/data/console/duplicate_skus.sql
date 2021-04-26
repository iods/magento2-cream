select p.entity_id, p.sku, v.value as name
from catalog_product_entity p
left join catalog_product_entity_varchar v on p.entity_id = v.entity_id and v.attribute_id = 73 and v.store_id = 0
where p.sku in (select p.sku from catalog_product_entity p group by sku having count(*) > 1) ORDER BY `p`.`sku` ASC