<?php namespace Dotink\Parody {

	/**
	 * Quip is the replacement for your actual classes.  It will respond to methods and actions
	 * configured by Mime.  Quips are verbal, Mimes are not.
	 *
	 * @copyright Copyright (c) 2012 - 2013, Matthew J. Sahagian
	 * @author Matthew J. Sahagian [mjs] <gent@dotink.org>
	 *
	 * @license Please reference the LICENSE.md file at the root of this distribution
	 *
	 * @package Parody
	 */
	class Quip
	{
		/**
		 * A list of the first created Quips keyed by class
		 *
		 * @static
		 * @access protected
		 * @var array
		 */
		static protected $objects = array();


		/**
		 * A list of availble factories for instantiating classes, keyed by class name
		 *
		 * @static
		 * @access protected
		 * @var array
		 */
		static protected $factories = array();


		/**
		 * The extended properties for this Quip
		 *
		 * @access protected
		 * @var array
		 */
		protected $extended = array();


		/**
		 * The registered methods on this Quip, keyed by method name
		 *
		 * @access protected
		 * @var array
		 */
		protected $methods = array();


		/**
		 * The registered properties on this Quip, keyed by property name
		 *
		 * @access protected
		 * @var array
		 */
		protected $properties = array();


		/**
		 * The mime associated with this object.  This value is only set in the Mime constructor.
		 *
		 * @access protected
		 * @var Mime
		 */
		protected $mime = NULL;


		/**
		 * Handle missing static calls
		 *
		 * Static calls are always looked up on the most recently instantiated Quip, so if you
		 * need to mimick their functionality you should create a mime and add them first.
		 *
		 * @static
		 * @access public
		 * @param string $method The static method we are trying to call
		 * @param array $args The arguments that were passed to the method
		 * @return mixed The value that the method should provide with matching expectations
		 */
		static public function __callStatic($method, $args)
		{
			$called_class = get_called_class();
			$object       = self::$objects[$called_class];

			return call_user_func_array([$object, $method], $args);
		}


		/**
		 * Instantiate a new Quip.
		 *
		 * This method will look through the list of registered factories created with the
		 * Mime::onNew() method.  The factory is passed a new mime wrapper with this quip as
		 * it's first and only argument for post-instantiation modification.
		 *
		 * @access public
		 * @return void
		 */
		public function __construct()
		{
			$class = get_class($this);
			$args  = func_get_args();

			if (isset(self::$factories[$class])) {
				foreach (self::$factories[$class] as $i => $quip) {
					if ($args == $quip['expectation']) {
						return call_user_func($quip['factory'], new Mime($this));
					}
				}
			}
		}


		/**
		 * Handle missing instance calls
		 *
		 * This method will look for the value assigned via Mime::onCall which whose expectations
		 * match the arguments provided.  If the value is a Closure the return value of the closure
		 * will be returned, but the Quip's mime will be passed as the first and only argument
		 * so that future behavior can be modified based on the call.
		 *
		 * @access public
		 * @param string $method The method we are trying to call
		 * @param array $args The arguments that were passed to the method
		 * @return mixed The value as mimicked by the call
		 */
		public function __call($method, $args)
		{
			if (isset($this->methods[$method])) {
				foreach ($this->methods[$method] as $i => $quip) {
					if ($args === $quip['expectation']) {
						return ($quip['value'] instanceof \Closure)
							? $quip['value']($this->mime)
							: $quip['value'];
					}
				}
			}

			throw new \Exception(sprintf(
				'The method %s was never mimicked with the provided expectations',
				$method
			));
		}


		/**
		 * Handle missing instance properties
		 *
		 * This method will return the value assigned via Mime::onGet.  It is possible that a user
		 * is attempting to mimic a magic property which would normally be accessed and provided
		 * via the __get() method on the actual class.  Since this method can contain logic, it
		 * is also possible to have a Closure registered with Mime::give() on a property.  As with
		 * other mimicking, the Closure will be passed the mime object as the first and only
		 * argument.
		 *
		 * @access public
		 * @param string $property The property we are trying to get
		 * @return mixed The value as mimicked by the property
		 */
		public function __get($property)
		{
			if (isset($this->properties[$property])) {
				$quip = $this->properties[$property];

				return ($quip instanceof \Closure)
					? $quip($this->mime)
					: $quip;
			}

			throw new \Exception(sprintf(
				'The property %s was never mimicked',
				$property
			));
		}


		/**
		 * Handle checking whether or not properties are set
		 *
		 * @access public
		 * @param string $property The property to check if it is set
		 * @return boolean TRUE if the mimicked property is set, FALSE otherwise
		 */
		public function __isset($property)
		{
			return isset($this->properties[$property]);
		}


		/**
		 * Handle unsetting a property
		 *
		 * @access public
		 * @param string $property The property to check if it is set
		 * @return void
		 */
		public function __unset($property)
		{
			if (isset($this->properties[$property])) {
				unset($this->properties[$property]);
			}
		}


		/**
		 * Handle setting properties
		 *
		 * @access public
		 * @param string $property THe property to set
		 * @param mixed $value The value to set it to
		 * @return void
		 */
		public function __set($property, $value)
		{
			throw new \Exception(sprintf(
				'Setting properties is not yet mimicked'
			));
		}
	}
}
