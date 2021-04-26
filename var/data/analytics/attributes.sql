-- DEFAULT MAGENTO: REQUIRE FIRSTNAME, LASTNAME, EMAIL, TELEPHONE
	UPDATE `ma2_eav_attribute` SET is_required = 1 WHERE attribute_code = 'firstname';
	UPDATE `ma2_eav_attribute` SET is_required = 1 WHERE attribute_code = 'lastname';
	UPDATE `ma2_eav_attribute` SET is_required = 1 WHERE attribute_code = 'email';
	UPDATE `ma2_eav_attribute` SET is_required = 1 WHERE attribute_code =  'telephone';

-- DO NOT REQUIRE FIRSTNAME, LASTNAME, EMAIL, TELEPHONE
	UPDATE `ma2_eav_attribute` SET is_required = 0 WHERE attribute_code = 'firstname';
	UPDATE `ma2_eav_attribute` SET is_required = 0 WHERE attribute_code = 'lastname';
	UPDATE `ma2_eav_attribute` SET is_required = 0 WHERE attribute_code = 'email';
	UPDATE `ma2_eav_attribute` SET is_required = 0 WHERE attribute_code =  'telephone';