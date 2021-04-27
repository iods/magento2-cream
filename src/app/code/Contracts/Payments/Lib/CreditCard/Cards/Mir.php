<?php

namespace Dholi\Payment\Lib\CreditCard\Cards;

use Dholi\Payment\Lib\CreditCard\Contracts\CreditCard;

/**
 * Class Mir.
 * @link https://nspk.com/
 * @author eugene.sazykin@gmail.com
 */
class Mir extends Card implements CreditCard {
	/**
	 * Regular expression for card number recognition.
	 *
	 * @var string
	 */
	public static $pattern = '/^220/';

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
	protected $name = 'mir';

	/**
	 * Brand name.
	 *
	 * @var string
	 */
	protected $brand = 'Mir';

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
