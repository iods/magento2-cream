
<script src="https://gist.github.com/Nolwennig/af9945944b8f027151f0cdde5ace523f.js"></script>
Cannot gather stats! Warning!stat(): stat failed for pub/media/catalog/product/i/m/image.jpg
readme.sql.md
Please run below sql code

SET @file = '/i/m/image.jpg';
START TRANSACTION;
DELETE FROM catalog_product_entity_media_gallery WHERE value = @file;
DELETE FROM catalog_product_entity_varchar WHERE value = @file;
COMMIT;
source: https://magento.stackexchange.com/a/165204/24845
author: https://magento.stackexchange.com/users/36750/gelanivishal


Magento 2 - Raw DB Query
<?php
//use a raw query to fid the row or rows
$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
$connection = $resource->getConnection();

$sql = " select * from `eav_attribute_option_swatch` where option_id in(".$option_img_id.") " ;
$result = $connection->fetchAll($sql);
