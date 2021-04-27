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

use Dholi\Widgets\Helper\Data;
use Dholi\Widgets\Model\SliderFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Widget\Block\BlockInterface;

class MultipleCarousel extends AbstractSlider implements BlockInterface {

	public function __construct(Context $context,
	                            SliderFactory $sliderFactory,
	                            Data $sliderHelper,
	                            StoreManagerInterface $storeManager,
	                            array $data = []) {
		parent::__construct($context, $sliderFactory, $sliderHelper, $storeManager, $data);
	}

	public function getCssStyle() {
		$bgColor = $this->getData('bg_color');
		$color = $this->getData('color');

		$style = [];
		if(!empty($bgColor)) {
			$style[] = 'background-color:' . $bgColor;
		}
		if(!empty($color)) {
			$style[] = 'color:' . $color;
		}

		return implode(';', $style);
	}
}