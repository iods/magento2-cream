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

class Carousel extends AbstractSlider implements BlockInterface {

	private $sliderHtmlId;

	private $sliderHtmlIdWrapper;

	public function __construct(Context $context,
	                            SliderFactory $sliderFactory,
	                            Data $sliderHelper,
	                            StoreManagerInterface $storeManager,
	                            array $data = []) {

		parent::__construct($context, $sliderFactory, $sliderHelper, $storeManager, $data);
	}

	public function toHtml() {
		$this->sliderHtmlId = "widget-carousel-_{$this->getAlias()}";
		$this->sliderHtmlIdWrapper = "{$this->sliderHtmlId}_wrapper";

		$width = $this->getData('width');
		$height = $this->getData('height');

		$sliderWrapperClass = 'block widget widget-carousel';
		$sliderClass = 'owl-carousel owl-theme';

		$sliderType = $this->getData('layout');
		$bannerStyle = '';
		$containerStyle = '';

		switch ($sliderType) {
			default:
			case 'fixed':
				$bannerStyle .= "height:{$height}px;width:{$width}px;";
				$containerStyle .= "height:{$height}px;width:{$width}px;";
				break;
			case 'fullwidth':
				$sliderWrapperClass .= ' fullwidthbanner-container';
				$sliderClass .= ' fullwidthabanner';
				$bannerStyle .= "max-height:{$height}px;height:{$height}px;";
				$containerStyle .= "max-height:{$height}px;";
				break;
			case 'fullscreen':
				$sliderWrapperClass .= ' fullscreen-container';
				$sliderClass .= ' fullscreenbanner';
				$bannerStyle .= "min-height:100vh";
				break;
		}

		$output = '';
		$output .= "<div id='{$this->sliderHtmlIdWrapper}' class='{$sliderWrapperClass}' style='{$containerStyle}'>";
		$output .= "<div id='{$this->sliderHtmlId}' class='{$sliderClass}' style='{$bannerStyle}'>";
		$output .= $this->renderSlides($bannerStyle);
		$output .= "</div>";
		$output .= "</div>";
		$output .= $this->renderJs();

		return $output;
	}


	private function renderSlides($bannerStyle = '') {
		$html = '';
		foreach ($this->getItensCollection() as $item) {
			$imgUrl = $this->getItemImageUrl($item);

			$html .= "<div class='item overlay' style='{$bannerStyle}'>
				<img class='bg-image' src='{$imgUrl}' loading='lazy'/>
				<a href='{$item->getUrl()}' target='{$item->getTargetUrl()}'>
					<div class='container-fluid'>
						<div class='row'>
							<div>
								<h2>{$item->getTitle()}</h2>
								<div class='description'>{$item->getDescription()}</div>
							</div>
						</div>
					</div>
				</a>
			</div>";
		}

		return $html;
	}

	private function renderJs() {
		$html = "
			<script type='text/javascript'>
				require([
					'jquery',
					'DholiOwlCarousel'
				], function($, owlCarousel) {
				$(document).ready(function() {
					$('#{$this->sliderHtmlId}').owlCarousel({
						items: 1,
						loop: true,
						margin: 0,
						smartSpeed: 500,
						navText: ['', ''],
						rewindNav: true,
						responsiveClass: true,
						responsive: {
						0: {
							items: 1,
								nav: false,
								dots: true
							},
							600: {
							items: 1,
								nav: false,
								dots: true
							},
							1120: {
							items: 1,
								nav: false,
								dots: true
							}
						},
	
						onRefresh: function () {
							$(this).find('.item').height('');
						},
						onRefreshed: function () {
							var maxHeight = 0;
							var items = $(this).find('.item');
							items.each(function () {
								var itemHeight = $(this).height();
								if (itemHeight > maxHeight) {
									maxHeight = itemHeight;
								}
							});
							items.height(maxHeight);
						}
					});
				});
			});
		</script>";

		return $html;
	}
}