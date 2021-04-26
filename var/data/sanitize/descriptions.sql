-- Search products descriptions

SELECT
cpe.entity_id,
cpe.sku,
cs.name as store,
cpet_d.value as description,
cpet_sd.value as short_description

FROM `catalog_product_entity` as cpe

LEFT JOIN `eav_attribute` as ea
	ON ea.attribute_code = 'description' AND ea.entity_type_id = 4
	OR ea.attribute_code = 'short_description' AND ea.entity_type_id = 4


LEFT JOIN `catalog_product_entity_text` as	cpet_d
	ON cpe.entity_id = cpet_d.entity_id
		AND  cpet_d.attribute_id = ea.attribute_id
			AND ea.attribute_code = 'description'

LEFT JOIN `catalog_product_entity_text` as	cpet_sd
	ON cpe.entity_id = cpet_sd.entity_id
		AND  cpet_sd.attribute_id = ea.attribute_id
			AND ea.attribute_code = 'short_description'

LEFT JOIN  `core_store` as cs
 ON cpet_d.store_id = cs.store_id