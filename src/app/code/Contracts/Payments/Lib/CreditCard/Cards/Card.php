<?php

namespace Dholi\Payment\Lib\CreditCard\Cards;

use Dholi\Payment\Lib\CreditCard\Exceptions\CreditCardCharactersException;
use Dholi\Payment\Lib\CreditCard\Exceptions\CreditCardChecksumException;
use Dholi\Payment\Lib\CreditCard\Exceptions\CreditCardCvcException;
use Dholi\Payment\Lib\CreditCard\Exceptions\CreditCardException;
use Dholi\Payment\Lib\CreditCard\Exceptions\CreditCardLengthException;
use Dholi\Payment\Lib\CreditCard\Exceptions\CreditCardNameException;
use Dholi\Payment\Lib\CreditCard\Exceptions\CreditCardPatternException;
use Dholi\Payment\Lib\CreditCard\Exceptions\CreditCardTypeException;

abstract class Card {
	/**
	 * Regular expression for card number recognition.
	 *
	 * @var string
	 */
	public static $pattern;

	/**
	 * Credit card type: "debit", "credit".
	 *
	 * @var string
	 */
	protected $type;

	/**
	 * Credit card name.
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Brand name.
	 *
	 * @var string
	 */
	protected $brand;

	/**
	 * Card number length's.
	 *
	 * @var array
	 */
	protected $numberLength;

	/**
	 * CVC code length's.
	 *
	 * @var array
	 */
	protected $cvcLength;

	/**
	 * Test cvc code checksum against Luhn algorithm.
	 *
	 * @var bool
	 */
	protected $checksumTest;

	/**
	 * @var string
	 */
	private $cardNumber;

	/**
	 * Card constructor.
	 *
	 * @param string $cardNumber
	 *
	 * @throws CreditCardException
	 */
	public function __construct(string $cardNumber = '') {
		$this->checkImplementation();

		if ($cardNumber) {
			$this->setCardNumber($cardNumber);
		}
	}

	/**
	 * @throws CreditCardException
	 */
	protected function checkImplementation() {
		if (!$this->type || !is_string($this->type) || !in_array($this->type, ['debit', 'credit'])) {
			throw new CreditCardTypeException('Credit card type is missing');
		}

		if (!$this->name || !is_string($this->name)) {
			throw new CreditCardNameException('Credit card name is missing or is not a string');
		}

		if (!static::$pattern || !is_string(static::$pattern)) {
			throw new CreditCardPatternException(
				'Credit card number recognition pattern is missing or is not a string'
			);
		}

		if (empty($this->numberLength) || !is_array($this->numberLength)) {
			throw new CreditCardLengthException(
				'Credit card number length is missing or is not an array'
			);
		}

		if (empty($this->cvcLength) || !is_array($this->cvcLength)) {
			throw new CreditCardCvcException(
				'Credit card cvc code length is missing or is not an array'
			);
		}

		if ($this->checksumTest === null || !is_bool($this->checksumTest)) {
			throw new CreditCardChecksumException(
				'Credit card checksum test is missing or is not a boolean'
			);
		}
	}

	/**
	 * @param string $cardNumber
	 *
	 * @return $this
	 * @throws CreditCardPatternException
	 */
	public function setCardNumber(string $cardNumber) {
		$this->cardNumber = preg_replace('/\s+/', '', $cardNumber);

		$this->isValidCardNumber();

		if (!$this->validPattern()) {
			throw new CreditCardPatternException(
				sprintf('Wrong "%s" card pattern', $this->cardNumber)
			);
		}

		return $this;
	}

	/**
	 * @return bool
	 * @throws CreditCardChecksumException
	 * @throws CreditCardCharactersException
	 * @throws CreditCardException
	 * @throws CreditCardLengthException
	 */
	public function isValidCardNumber() {
		if (!$this->cardNumber) {
			throw new CreditCardException('Card number is not set');
		}

		if (!is_numeric(preg_replace('/\s+/', '', $this->cardNumber))) {
			throw new CreditCardCharactersException(
				sprintf('Card number "%s" contains invalid characters', $this->cardNumber)
			);
		}

		if (!$this->validLength()) {
			throw new CreditCardLengthException(
				sprintf('Incorrect "%s" card length', $this->cardNumber)
			);
		}

		if (!$this->validChecksum()) {
			throw new CreditCardChecksumException(
				sprintf('Invalid card number: "%s". Checksum is wrong', $this->cardNumber)
			);
		}

		return true;
	}

	/**
	 * @return bool
	 */
	protected function validLength() {
		return in_array(strlen($this->cardNumber), $this->numberLength, true);
	}

	/**
	 * @return bool
	 */
	protected function validChecksum() {
		return !$this->checksumTest || $this->checksumTest();
	}

	/**
	 * @return bool
	 */
	protected function checksumTest() {
		$checksum = 0;
		$len = strlen($this->cardNumber);
		for ($i = 2 - ($len % 2); $i <= $len; $i += 2) {
			$checksum += $this->cardNumber[$i - 1];
		}
		// Analyze odd digits in even length strings or even digits in odd length strings.
		for ($i = $len % 2 + 1; $i < $len; $i += 2) {
			$digit = $this->cardNumber[$i - 1] * 2;
			if ($digit < 10) {
				$checksum += $digit;
			} else {
				$checksum += $digit - 9;
			}
		}

		return ($checksum % 10) === 0;
	}

	/**
	 * @return bool
	 */
	protected function validPattern() {
		return (bool)preg_match(static::$pattern, $this->cardNumber);
	}

	/**
	 * @return string
	 */
	public function type() {
		return $this->type;
	}

	/**
	 * @return string
	 */
	public function name() {
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function brand() {
		return $this->brand;
	}

	/**
	 * @param $cvc
	 *
	 * @return bool
	 */
	public function isValidCvc($cvc) {
		return is_numeric($cvc) && self::isValidCvcLength($cvc, $this->cvcLength);
	}

	/**
	 * Check CVS length against possible lengths.
	 *
	 * @param string|int $cvc
	 *
	 * @param array $availableLengths
	 *
	 * @return bool
	 */
	public static function isValidCvcLength($cvc, array $availableLengths = [3, 4]) {
		return in_array(strlen($cvc), $availableLengths, true);
	}
}
