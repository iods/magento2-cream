<?php
/**
* 
* Widgets para Magento 2
* 
* @category     Dholi
* @package      Modulo Widgets
* @copyright    Copyright (c) 2021 dholi (https://www.dholi.dev)
* @version      1.0.0
* @license      https://www.dholi.dev/license/
*
*/
declare(strict_types=1);

namespace Dholi\Widgets\Block\Widget;

use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\Widget\Html\Pager;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Pricing\Price\FinalPrice;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Pricing\Render;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Url\EncoderInterface;
use Magento\Framework\View\LayoutFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Widget\Block\BlockInterface;
use Magento\Framework\View\Element\AbstractBlock;

class ProductsByCategory extends AbstractProduct implements BlockInterface {
	
	const DISPLAY_TYPE = 'products_by_category';
	
	/**
	 * Default value for products per page
	 */
	const DEFAULT_PRODUCTS_PER_PAGE = 10;
	
	/**
	 * Default value whether show pager or not
	 */
	const DEFAULT_SHOW_PAGER = true;
	
	/**
	 * Instance of pager block
	 *
	 * @var Pager
	 */
	protected $pager;
	
	/**
	 * @var Json
	 */
	private $serializer;
	
	/**
	 * @var LayoutFactory
	 */
	private $layoutFactory;
	
	/**
	 * @var EncoderInterface|null
	 */
	private $urlEncoder;
	
	private $categoryFactory;
	
	/**
	 * @var StoreManagerInterface
	 */
	private $storeManager;
	
	public function __construct(Context $context,
	                            StoreManagerInterface $storeManager,
	                            CategoryFactory $categoryFactory,
	                            array $data = [],
	                            Json $serializer = null,
	                            LayoutFactory $layoutFactory = null,
	                            EncoderInterface $urlEncoder = null) {
		parent::__construct($context, $data);
		
		$this->storeManager = $storeManager;
		$this->categoryFactory = $categoryFactory;
		$this->serializer = $serializer ?: ObjectManager::getInstance()->get(Json::class);
		$this->layoutFactory = $layoutFactory ?: ObjectManager::getInstance()->get(LayoutFactory::class);
		$this->urlEncoder = $urlEncoder ?: ObjectManager::getInstance()->get(EncoderInterface::class);
	}
	
	/**
	 * Prepare collection with new products
	 *
	 * @return AbstractBlock
	 */
	protected function _beforeToHtml() {
		$this->setProductCollection($this->_getProductCollection());
		return parent::_beforeToHtml();
	}
	
	/**
	 * Get key pieces for caching block content
	 *
	 * @return array
	 */
	public function getCacheKeyInfo() {
		return array_merge(
			parent::getCacheKeyInfo(),
			[
				self::DISPLAY_TYPE,
				(int)$this->getRequest()->getParam($this->getData('page_var_name'), 1),
				$this->serializer->serialize($this->getRequest()->getParams())
			]
		);
	}
	
	private function getStoreId() {
		return $this->storeManager->getStore()->getId();
	}
	
	public function getTitle() {
		return $this->getData('title');
	}
	
	/**
	 * Return HTML block with price
	 *
	 * @param Product $product
	 * @param string $priceType
	 * @param string $renderZone
	 * @param array $arguments
	 * @return string
	 * @SuppressWarnings(PHPMD.NPathComplexity)
	 */
	public function getProductPriceHtml(Product $product, $priceType = null, $renderZone = Render::ZONE_ITEM_LIST, array $arguments = []) {
		if (!isset($arguments['zone'])) {
			$arguments['zone'] = $renderZone;
		}
		$arguments['zone'] = isset($arguments['zone'])
			? $arguments['zone']
			: $renderZone;
		$arguments['price_id'] = isset($arguments['price_id'])
			? $arguments['price_id']
			: 'old-price-' . $product->getId() . '-' . $priceType;
		$arguments['include_container'] = isset($arguments['include_container'])
			? $arguments['include_container']
			: true;
		$arguments['display_minimal_price'] = isset($arguments['display_minimal_price'])
			? $arguments['display_minimal_price']
			: true;
		
		/** @var Render $priceRender */
		$priceRender = $this->getLayout()->getBlock('product.price.render.default');
		
		$price = '';
		if ($priceRender) {
			$price = $priceRender->render(FinalPrice::PRICE_CODE, $product, $arguments);
		}
		return $price;
	}
	
	/**
	 * Retrieve how many products should be displayed
	 *
	 * @return int
	 */
	public function getProductsCount() {
		if (!$this->hasData('products_count')) {
			return parent::getProductsCount();
		}
		
		return $this->getData('products_count');
	}
	
	/**
	 * Render pagination HTML
	 *
	 * @return string
	 * @throws LocalizedException
	 */
	public function getPagerHtml() {
		if ($this->showPager() && $this->getProductCollection()->getSize() > $this->getProductsPerPage()) {
			if (!$this->pager) {
				$this->pager = $this->getLayout()->createBlock(Pager::class, 'widget.category.product.list.pager');
				
				$this->pager->setUseContainer(true)
					->setShowAmounts(true)
					->setShowPerPage(false)
					->setPageVarName($this->getData('page_var_name'))
					->setLimit($this->getProductsPerPage())
					->setTotalLimit($this->getProductsCount())
					->setCollection($this->getProductCollection());
			}
			if ($this->pager instanceof AbstractBlock) {
				return $this->pager->toHtml();
			}
		}
		
		return '';
	}
	
	/**
	 * @inheritdoc
	 */
	protected function getDetailsRendererList() {
		if (empty($this->rendererListBlock)) {
			/** @var $layout LayoutInterface */
			$layout = $this->layoutFactory->create(['cacheable' => false]);
			$layout->getUpdate()->addHandle('catalog_widget_product_list')->load();
			$layout->generateXml();
			$layout->generateElements();
			
			$this->rendererListBlock = $layout->getBlock('category.product.type.widget.details.renderers');
		}
		
		return $this->rendererListBlock;
	}
	
	/**
	 * Get post parameters.
	 *
	 * @param Product $product
	 * @return array
	 */
	public function getAddToCartPostParams(Product $product) {
		$url = $this->getAddToCartUrl($product);
		return [
			'action' => $url,
			'data' => [
				'product' => $product->getEntityId(),
				ActionInterface::PARAM_NAME_URL_ENCODED => $this->urlEncoder->encode($url),
			]
		];
	}
	
	/**
	 * Return flag whether pager need to be shown or not
	 *
	 * @return bool
	 */
	public function showPager() {
		if (!$this->hasData('show_pager')) {
			$this->setData('show_pager', self::DEFAULT_SHOW_PAGER);
		}
		return (bool)$this->getData('show_pager');
	}
	
	/**
	 * Retrieve how many products should be displayed on page
	 *
	 * @return int
	 */
	protected function getPageSize() {
		return $this->showPager() ? $this->getProductsPerPage() : $this->getProductsCount();
	}
	
	/**
	 * Retrieve how many products should be displayed
	 *
	 * @return int
	 */
	public function getProductsPerPage() {
		if (!$this->hasData('products_per_page')) {
			$this->setData('products_per_page', self::DEFAULT_PRODUCTS_PER_PAGE);
		}
		
		return $this->getData('products_per_page');
	}
	
	/**
	 * Product collection initialize process
	 *
	 * @return \Magento\Catalog\Model\ResourceModel\Product\Collection|Object|\Magento\Framework\Data\Collection
	 */
	protected function _getProductCollection() {
		if (!$this->getData('id_path')) {
			throw new \RuntimeException('Parameter id_path is not set.');
		}
		$rewriteData = $this->parseIdPath($this->getData('id_path'));
		
		$category = $this->categoryFactory->create()->load($rewriteData[1]);
		$collection = $category->getProductCollection();
		$collection->addMinimalPrice()
			->addFinalPrice()
			->addTaxPercents()
			->addAttributeToSelect('*')
			->addAttributeToFilter('status', Status::STATUS_ENABLED)
			->addAttributeToFilter('visibility', 4)
			->addStoreFilter($this->getStoreId())->setPageSize($this->getPageSize());
		
		return $collection;
	}
	
	protected function parseIdPath($idPath) {
		$rewriteData = explode('/', $idPath);
		
		if (!isset($rewriteData[0]) || !isset($rewriteData[1])) {
			throw new \RuntimeException('Wrong id_path structure.');
		}
		return $rewriteData;
	}
	
	public function getAlias() {
		return md5(uniqid('', true));
	}
}