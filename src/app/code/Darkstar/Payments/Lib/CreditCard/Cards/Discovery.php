<?php

namespace Dholi\Payment\Lib\CreditCard\Cards;

use Dholi\Payment\Lib\CreditCard\Contracts\CreditCard;

class Discovery extends Card implements CreditCard {
	/**
	 * Regular expression for card number recognition.
	 *
	 * @var string
	 */
	public static $pattern = '/^6(011|22126|22925|4[4-9]|5)/';

	/**
	 * Credit card type.
	 *
	 * @var string
	 */
	protected $type = 'credit';

	/**
	 * Credit card name.
	 *
	 * @var string
	 */
	protected $name = 'discover';

	/**
	 * Brand name.
	 *
	 * @var string
	 */
	protected $brand = 'Discover';

	/**
	 * Card number length's.
	 *
	 * @var array
	 */
	protected $numberLength = [16];

	/**
	 * CVC code length's.
	 *
	 * @var array
	 */
	protected $cvcLength = [3];

	/**
	 * Test cvc code checksum against Luhn algorithm.
	 *
	 * @var bool
	 */
	protected $checksumTest = true;
}
