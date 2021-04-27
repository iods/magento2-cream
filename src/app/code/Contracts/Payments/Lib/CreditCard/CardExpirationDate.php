<?php

namespace Dholi\Payment\Lib\CreditCard;

use DateTime;
use DateTimeZone;
use Exception;
use InvalidArgumentException;

class CardExpirationDate {
	const MSG_CARD_EXPIRATION_DATE_INVALID = 'Please enter a valid credit card expiration date.';
	const MSG_CARD_EXPIRATION_DATE_FORMAT_INVALID = 'Please enter a valid credit card expiration date.';

	protected $message;

	/**
	 * CardExpirationDate constructor.
	 *
	 */
	public function __construct() {
		$this->message = static::MSG_CARD_EXPIRATION_DATE_INVALID;
	}

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function passes($value) {
		try {
			$timeZone = new DateTimeZone('America/Sao_Paulo');
			$date = DateTime::createFromFormat('Y/m', $value);
			$date->setTimezone($timeZone);

			return (new ExpirationDateValidator($date->format('Y'), $date->format('m')))->isValid();
		} catch (InvalidArgumentException $ex) {
			$this->message = static::MSG_CARD_EXPIRATION_DATE_FORMAT_INVALID;

			return false;
		} catch (Exception $ex) {
			$this->message = static::MSG_CARD_EXPIRATION_DATE_INVALID;

			return false;
		}

		return false;
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
