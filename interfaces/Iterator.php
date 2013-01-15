<?php namespace Dotink\Parody {

	/**
	 * An Iterator interface implementation which can be patched onto Mimed classes
	 *
	 * @copyright Copyright (c) 2012 - 2013, Matthew J. Sahagian
	 * @author Matthew J. Sahagian [mjs] <gent@dotink.org>
	 *
	 * @license Please reference the LICENSE.txt file at the root of this distribution
	 *
	 * @package Parody
	 */
	trait Iterator
	{
		/**
		 * Gets the current value of the traversableValue
		 *
		 * @access public
		 * @return mixed
		 */
		public function current()
		{
			return current($this->extended['traversableValue']);
		}

		/**
		 * Gets the current key of the traversableValue
		 *
		 * @access public
		 * @return mixed
		 */
		public function key()
		{
			return key($this->extended['traversableValue']);
		}

		/**
		 * Moves the current element of the traversableValue forward one
		 *
		 * @access public
		 * @return void
		 */
		public function next()
		{
			next($this->extended['traversableValue']);
		}

		/**
		 * Moved the current element of the traversableValue back to the beginning
		 *
		 * @access public
		 * @return void
		 */
		public function rewind()
		{
			reset($this->extended['traversableValue']);
		}


		/**
		 * Determine if the current key of an array is Valid
		 *
		 * @access public
		 * @return boolean TRUE if the current key is valid, FALSE otherwise
		 */
		public function valid()
		{
			return key($this->extended['traversableValue']) !== NULL;
		}
	}

	/**
	 * The Mime extension definition is an array of keys to callbacks.  The key represents the
	 * method name which should be added to Mime and the callback represents the functionality.
	 *
	 * The callback should return an array of extended property values after whatever modification
	 * logic is required.
	 */
	return [

		/**
		 * Adds the traversing method to Mime for setting traversable value.
		 *
		 * @param array $value The value to traverse on iteration
		 * @return array The map of properties to overload with values
		 */
		'traversing' => function($value) {
			if (!is_array($value)) {
				throw new \Exception(sprintf(
					'Mime cannot add traversing across for non-array value %s',
					$value
				));
			}

			return ['traversableValue' => $value];
		}
	];
}
