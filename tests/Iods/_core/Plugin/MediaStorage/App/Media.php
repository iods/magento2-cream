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

namespace Iods\Core\Plugin\Block;
namespace TFC\Core\Plugin\MediaStorage\App;
use Magento\MediaStorage\App\Media as Sb;
use Magento\MediaStorage\Model\File\Storage\Response;
use Magento\Framework\App\Filesystem\DirectoryList as DL;
# 2020-12-13 "`WeltPixel_OwlCarouselSlider`: properly size images": https://github.com/tradefurniturecompany/site/issues/158
final class Media {
	/**
	 * 2020-12-13
	 * @see \Magento\MediaStorage\App\Media::launch()
	 * @used-by \Magento\Framework\App\Bootstrap::run()
	 * @param Sb $sb
	 * @param \Closure $f
	 * @return Response
	 */
	function aroundLaunch(Sb $sb, \Closure $f) {
		$uriWithoutMedia = df_strip_media_from_request_uri(); /** @var string $uriWithoutMedia */
		$pathWeltPixel = 'weltpixel/owlcarouselslider/images/'; /** @var string $pathWeltPixel */
		if (!df_starts_with($uriWithoutMedia, $pathWeltPixel)) {
			$r = $f();
		}
		else {
			$pathLAC = df_explode_url($uriWithoutMedia);
			df_assert_eq('cache', $pathLAC[0]);
			$widthResized = df_int($pathLAC[1]); /** @var int $widthResized */
			$pathL = df_cc_path(array_slice($pathLAC, 2));	/** @var string $pathLA */
			$pathOriginal = df_media_path_absolute($pathWeltPixel . $pathL);
			df_assert(file_exists($pathOriginal));
			$rf = $pathOriginal; /** @var string $rf */
			if (df_img_is_jpeg($pathOriginal)) {
				list($w, $h) = getimagesize($pathOriginal); /** @var int $w */ /** @var int $h */
				if ($w > $widthResized) {
					try {
						$imgOriginal = imagecreatefromjpeg($pathOriginal);
						try {
							$imgResized = imagecreatetruecolor($widthResized, $heightResized = $h * $widthResized / $w);
							imagecopyresampled($imgResized, $imgOriginal, 0, 0, 0, 0, $widthResized, $heightResized, $w, $h);
							$pathResized = df_media_path_absolute($uriWithoutMedia); /** @var string $pathResized */
							imagejpeg($imgResized, $pathResized);
							$rf = $pathResized;
						}
						finally {
							imagedestroy($imgResized);
						}
					}
					finally {
						imagedestroy($imgOriginal);
					}
				}
			}
			$r = df_file_resp()->setFilePath($rf);
		}
		return $r;
	}
}
