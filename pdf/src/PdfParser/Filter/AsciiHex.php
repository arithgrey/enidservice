<?php
/**
 * This file is part of FPDI
 *
 * @package   setasign\Fpdi
 * @copyright Copyright (c) 2017 Setasign - Jan Slabon (https://www.setasign.com)
 * @license   http://opensource.org/licenses/mit-license The MIT License
 * @version   2.0.3
 */

namespace setasign\Fpdi\PdfParser\Filter;

use function current;
use function pack;
use function preg_replace;
use function rtrim;
use function strlen;
use function unpack;

/**
 * Class for handling ASCII hexadecimal encoded data
 *
 * @package setasign\Fpdi\PdfParser\Filter
 */
class AsciiHex implements FilterInterface
{
	/**
	 * Converts an ASCII hexadecimal encoded string into its binary representation.
	 *
	 * @param string $data The input string
	 * @return string
	 */
	public function decode($data)
	{
		$data = preg_replace('/[^0-9A-Fa-f]/', '', rtrim($data, '>'));
		if ((strlen($data) % 2) === 1) {
			$data .= '0';
		}

		return pack('H*', $data);
	}

	/**
	 * Converts a string into ASCII hexadecimal representation.
	 *
	 * @param string $data The input string
	 * @param boolean $leaveEOD
	 * @return string
	 */
	public function encode($data, $leaveEOD = false)
	{
		$t = unpack('H*', $data);
		return current($t)
			. ($leaveEOD ? '' : '>');
	}
}
