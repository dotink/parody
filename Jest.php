<?php namespace Dotink\Parody {

	/**
	 * Mime provides a simple API for defining and crafting mock classes and objects, called
	 * "Jests".
	 *
	 * @copyright Copyright (c) 2012 - 2013, Matthew J. Sahagian
	 * @author Matthew J. Sahagian [mjs] <gent@dotink.org>
	 *
	 * @license Please reference the LICENSE.txt file at the root of this distribution
	 *
	 * @package Parody
	 */
	class Jest
	{
		/**
		 *
		 */
		static protected $objects = array();


		/**
		 *
		 */
		static protected $factories = array();


		/**
		 *
		 */
		protected $expectation  = array();


		/**
		 *
		 */
		protected $methods      = array();


		/**
		 *
		 */
		protected $properties   = array();





		/**
		 *
		 */
		public function __construct()
		{
			$class = get_class($this);
			$args  = func_get_args();

			if (isset(self::$factories[$class])) {
				foreach (self::$factories[$class] as $i => $jest) {
					if ($args == $jest['expectation']) {
						unset(self::$factories[$class][$i]);

						return call_user_func($jest['factory'], new Mime($this));
					}
				}
			}
		}


		/**
		 *
		 */
		public function __call($method, $args)
		{
			if (isset($this->methods[$method])) {
				foreach ($this->methods[$method] as $jest) {
					if ($args == $jest['expectation']) {
						return $jest['value'];
					}
				}
			} else {
				throw new \Exception(sprintf(
					'The method %s was never mimicked',
					$method
				));
			}
		}


		/**
		 *
		 */
		static public function __callStatic($method, $args)
		{
			$called_class = get_called_class();
			$object       = self::$objects[$called_class];

			return call_user_func_array([$object, $method], $args);
		}


		/**
		 *
		 */
		public function __get($property)
		{
			return $this->properties[$property];
		}


		/**
		 *
		 */
		public function __set($property, $value)
		{

		}
	}
}
