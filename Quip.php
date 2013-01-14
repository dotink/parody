<?php namespace Dotink\Parody {

	/**
	 * Quip is the replacement for your actual classes.  It will respond to methods and actions
	 * configured by Mime.  Quips are verbal, Mimes are not.
	 *
	 * @copyright Copyright (c) 2012 - 2013, Matthew J. Sahagian
	 * @author Matthew J. Sahagian [mjs] <gent@dotink.org>
	 *
	 * @license Please reference the LICENSE.txt file at the root of this distribution
	 *
	 * @package Parody
	 */
	class Quip
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
		protected $methods      = array();


		/**
		 *
		 */
		protected $properties  = array();


		/**
		 *
		 */
		protected $mime = NULL;


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
		public function __construct()
		{
			$class = get_class($this);
			$args  = func_get_args();

			if (isset(self::$factories[$class])) {
				foreach (self::$factories[$class] as $i => $quip) {
					if ($args == $quip['expectation']) {
						unset(self::$factories[$class][$i]);

						return call_user_func($quip['factory'], new Mime($this));
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
				foreach ($this->methods[$method] as $quip) {
					if ($args == $quip['expectation']) {
						return ($quip['value'] instanceof \Closure)
							? $quip['value']($this->mime)
							: $quip['value'];
					}
				}
			}

			throw new \Exception(sprintf(
				'The method %s was never mimicked with the provide expectations',
				$method
			));
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
