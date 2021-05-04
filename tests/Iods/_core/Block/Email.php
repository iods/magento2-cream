<?php
/**
 * Core module for extending and testing functionality across Magento 2
 *
 * @package   Iods_Core
 * @author    Rye Miller <rye@drkstr.dev>
 * @copyright Copyright (c) 2021, Rye Miller (https://ryemiller.io)
 * @license   See LICENSE for license details.
 */
declare(strict_types=1);

namespace Iods\Core\Block;

class Email extends Base
{

  protected $_blockProducts;

  protected $_emailTemplate;

  protected $_storeManager;

  public function __construct(
    \Magento\Catalog\Block\Product\Context $context,
    \Develodesign\Easymanage\Block\Email\Products $blockProducts,
    \Magento\Email\Model\Template $emailTemplate,
    array $data = array()
  ) {

    $this->_blockProducts = $blockProducts;
    $this->_emailTemplate = $emailTemplate;
    parent::__construct($context, $data);
  }

  public function getEmailTemplateText($type) {

    $data = (string) $this->_emailTemplate
      ->setForcedArea($type)
      ->setId($type)
      ->processTemplate();
    return $data;
  }

  public function getUnsubscribeLink($title = '') {
    return '<a href="' . $this->getUrl('iods/unsubscribe/index') . 'id/[$subscriberId]' . '" class="iodsunsubscribe">' . $title . '</a>';
  }

  public function getProductData($attrs) {
    return $this->_blockProducts->getProductData($attrs);
  }

  public function getCategoryData($attrs) {
    return $this->_blockProducts->getCategoryData($attrs);
  }

    protected $_blockCSS = [
        'margin' => '10px auto 0',
        'max-width' => '95%',
        'border-bottom' => '1px solid silver',
        'padding-bottom' => '10px'
    ];

    protected $_titleCSS = [
        'font-weight' => 'bold'
    ];

    protected $_imageContainerCSS = [
        'text-align' => 'center'
    ];

    protected $_imageCSS = [
        'max-width' => '90%',
        'display' => 'inline'
    ];

    protected $_skuCSS = [
        'font-style' => 'italic',
        'float' => 'right'
    ];

    protected $_priceCSS = [
        'color' => '#666666',
        'float' => 'left'
    ];

    protected $_buttonCSS = [
        'padding' => '14px 17px',
        'display' => 'block',
        'background' => '#1979c3',
        'border' => '1px solid #1979c3',
        'color' => '#ffffff !important',
        'text-decoration' => 'none !important',
        'font-size' => '25px',
        'text-align' => 'center'
    ];

    protected function parseStylesConf($stylesArr = []) {
        $string = '';
        foreach($stylesArr as $styleKey => $styleVal) {
            $string .= ' ' . $styleKey . ':' . $styleVal . ';';
        }

        return $string;
    }

    public function getBlockStyles() {
        return $this->parseStylesConf($this->_blockCSS);
    }

    public function getTitleStyles() {
        return $this->parseStylesConf($this->_titleCSS);
    }

    public function getImageContainerStyles() {
        return $this->parseStylesConf($this->_imageContainerCSS);
    }

    public function getImageStyles() {
        return $this->parseStylesConf($this->_imageCSS);
    }

    public function getSkuStyles() {
        return $this->parseStylesConf($this->_skuCSS);
    }

    public function getPriceStyles() {
        return $this->parseStylesConf($this->_priceCSS);
    }

    public function getButtonStyles() {
        return $this->parseStylesConf($this->_buttonCSS);
    }


    const DEFAULT_LIMIT = 4;

    protected $_product;

    protected $_layout;

    protected $_styles;

    protected $_helperPrice;

    protected $productRepository;

    protected $categoryFactory;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\View\LayoutInterface $layout,
        \Develodesign\Easymanage\Block\Email\Styles $styles,
        \Magento\Framework\Pricing\Helper\Data $helperPrice,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        array $data = array()
    ) {
        $this->productRepository = $productRepository;
        $this->_layout = $layout;
        $this->_styles = $styles;
        $this->_helperPrice = $helperPrice;
        $this->categoryFactory = $categoryFactory;
        parent::__construct($context, $data);
    }

    public function getProductData($attrs = []) {
        if(empty($attrs['product_id']) && empty($attrs['product_sku'])) {
            return __('Empty product id and sku params') . '!';
        }

        $productIdentifier = empty($attrs['product_sku']) ? $attrs['product_id'] : $attrs['product_sku'];
        $isSku = empty($attrs['product_sku']) ? false : true;
        $this->loadProduct($productIdentifier, $isSku);
        if(!$this->getProduct() || !$this->getProduct()->getId()) {
            return __('Cant find product with identifier %1 and is SKU %2', $productIdentifier, $isSku);
        }

        return $this->_getProductHtml();
    }

    public function getCategoryData($attrs = []) {

        if(empty($attrs['category_id'])) {
            return __('Empty category id') . '!';
        }
        $category = $this->categoryFactory->create()
            ->load($attrs['category_id']);
        if(!$category->getId()) {
            return __('Can not find category by it id') . ' ' . $attrs['category_id'];
        }
        $limit = empty($attrs['limit']) ? self::DEFAULT_LIMIT : intval($attrs['limit']);
        $collection = $category->getProductCollection()
        ;

        $output = '';
        $count = 0;

        foreach($collection as $productModel) {
            $this->loadProduct($productModel->getId());
            $output .= $this->_getProductHtml();
            $count++;
            if($count == $limit) {
                break;
            }
        }

        return $output;
    }

    public function getPrice() {
        return $this->_helperPrice->currency($this->getProduct()->getFinalPrice(), true, false);
    }

    protected function _getProductHtml() {
        $block = $this->_layout->createBlock(\Develodesign\Easymanage\Block\Email\Products::class);
        $block->setLayout($this->_layout);
        $block->setProduct($this->getProduct());
        $block->setTemplate('Develodesign_Easymanage::email/product.phtml');
        $html = $block->toHtml();


        return $html;

    }

    public function getStyles() {
        return $this->_styles;
    }

    public function getProduct() {
        return $this->_product;
    }

    protected function setProduct($product) {
        $this->_product = $product;
    }

    protected function loadProduct($productId, $isSku = false) {
        if($isSku) {
            $product = $this->productRepository->get($productId);
        }else{
            $product = $this->productRepository->getById($productId);
        }

        $this->setProduct( $product );
    }
}
