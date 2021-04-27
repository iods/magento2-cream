<?php

namespace Dholi\Payment\Lib\CreditCard;

use Dholi\Payment\Lib\CreditCard\Exceptions\CreditCardChecksumException;
use Dholi\Payment\Lib\CreditCard\Exceptions\CreditCardException;
use Dholi\Payment\Lib\CreditCard\Exceptions\CreditCardLengthException;

class CardNumber {
	const MSG_CARD_INVALID = 'Invalid Credit Card Number';
	const MSG_CARD_LENGTH_INVALID = 'Invalid Credit Card Number';
	const MSG_CARD_CHECKSUM_INVALID = 'Invalid Credit Card Number';

	protected $message = '';

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function passes($value) {
		try {
			return Factory::makeFromNumber($value)->isValidCardNumber();
		} catch (CreditCardLengthException $ex) {
			$this->message = self::MSG_CARD_LENGTH_INVALID;

			return false;
		} catch (CreditCardChecksumException $ex) {
			$this->message = self::MSG_CARD_CHECKSUM_INVALID;

			return false;
		} catch (CreditCardException $ex) {
			$this->message = self::MSG_CARD_INVALID;

			return false;
		}
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message() {
		return __($this->message);
	}
}
