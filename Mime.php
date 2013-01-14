<?php namespace Dotink\Parody {

	/**
	 * Mime provides a simple API for defining and crafting mock classes and objects.
	 *
	 * @copyright Copyright (c) 2012 - 2013, Matthew J. Sahagian
	 * @author Matthew J. Sahagian [mjs] <gent@dotink.org>
	 *
	 * @license Please reference the LICENSE.txt file at the root of this distribution
	 *
	 * @package Parody
	 */
	class Mime extends Quip
	{
		/**
		 * Parent class relationships for defined classes
		 *
		 * @static
		 * @access private
		 * @var array
		 */
		static private $parents = array();


		/**
		 * Interfaces for defined classes
		 *
		 * @static
		 * @access private
		 * @var array
		 */
		static private $interfaces = array();


		/**
		 * Traits for defined classes
		 *
		 * @static
		 * @access private
		 * @var array
		 */
		static private $traits = array();


		/**
		 * The class of the quip that mime is working on
		 *
		 * @access private
		 * @var string
		 */
		private $class  = NULL;


		/**
		 * The current expected arguments of the open Method
		 *
		 * @access private
		 * @var array
		 */
		private $expectation  = array();


		/**
		 * A representation of a "pretend" object which is manipulated
		 *
		 * @access private
		 * @var Quip
		 */
		private $quip = NULL;


		/**
		 * The currently open method
		 *
		 * @access private
		 * @var string
		 */
		private $openMethod   = FALSE;


		/**
		 * The currently open property
		 *
		 * @access private
		 * @var string
		 */
		private $openProperty = FALSE;


		/**
		 * Create a new quip (mocked object) of a particular class to work on.
		 *
		 * @static
		 * @access public
		 * @param string $class The class from which to build the object
		 * @return Mime The mime object for developing the object.
		 */
		static public function create($class)
		{
			if (!class_exists($class)) {
				self::make($class);
			}

			$class      = self::qualify($class);
			$quip       = new $class();
			$quip->mime = new self($quip);

			return $quip->mime;
		}


		/**
		 * Define a new quip (mocked class) to work on.
		 *
		 * @static
		 * @access public
		 * @param string $class The class to define
		 * @return Mime The mime object for defining the class
		 */
		static public function define($class)
		{
			return new self($class);
		}


		/**
		 * Literally makes (evals) a class.
		 *
		 * @static
		 * @access private
		 * @param string $class The class to make
		 * @return string The qualfied class
		 */
		static private function make($class)
		{
			//
			// We need to dequalify the class first
			//

			$class  = ltrim($class, '\\');
			$parent = isset(self::$parents[$class])
				? self::$parents[$class]
				: self::qualify(__NAMESPACE__ . '\Quip');

			if ($parent && !class_exists($parent)) {
				self::make($parent);
			}

			$interfaces = isset(self::$interfaces[$class])
				? self::$interfaces[$class]
				: array();

			$traits = isset(self::$traits[$class])
				? self::$traits[$class]
				: array();

			$ns_parts   = explode('\\', $class);
			$class      = array_pop($ns_parts);
			$ns         = implode('\\', $ns_parts);

			eval(call_user_func(function() use ($ns, $class, $parent, $interfaces, $traits) {
				ob_start() ?>
					namespace <?= $ns ?>
					{
						class <?= $class ?>

						<?php if ($parent) { ?>
							extends <?= $parent ?>
						<?php } ?>

						<?php if (count($interfaces)) { ?>
							implements <?= implode(', ', $interfaces) ?>
						<?php } ?>

						{

						}
					}
				<?php return ob_get_clean();
			}));
		}


		/**
		 * Qualifies a class for the global namespace by ensuring it has a \ in front.
		 *
		 * @static
		 * @access private
		 * @param string $class The class to qualify
		 * @return string The qualfied class
		 */
		static protected function qualify($class)
		{
			return $class[0] != '\\'
				? '\\' . $class
				: $class;
		}


		/**
		 * Create a new Mime.
		 *
		 * @access public
		 * @param string|object $target A class name or quip to work with.
		 * @return void
		 */
		public function __construct($target = NULL)
		{
			if (is_object($target)) {
				if (!is_subclass_of($target, get_parent_class(__CLASS__))) {
					throw new \Exception(sprintf(
						'Mime cannot work with non-Quip object of class %s',
						get_class($target)
					));
				}

				$this->class                 = get_class($target);
				$this->quip                  = $target;
				self::$objects[$this->class] = $target;

			} else {
				$this->class = $target;
			}
		}


		/**
		 * Tell an open method what to expect
		 *
		 * @access public
		 * @param mixed The expected parameter for the mocked method
		 * @param ...
		 * @return Mime The mime for method chaining
		 */
		public function expect()
		{
			if (!$this->openMethod) {
				throw new \Exception(sprintf(
					'Cannot set argument expectations without first opening a call'
				));
			}

			$this->expectation = func_get_args();

			return $this;
		}


		/**
		 * Tells the class we're defining to extend a parent class, creating it if it does not
		 * exist.
		 *
		 * @access public
		 * @param string $parent_class The parent class to define
		 * @return Mime A new mime for defining the parent
		 */
		public function extending($parent_class)
		{
			self::$parents[$this->class] = self::qualify($parent_class);

			return self::define($parent_class);
		}


		/**
		 * Define a value to give for the open method or property
		 *
		 * @access public
		 * @param mixed $value The value to return for the open method or property
		 * @return Mime For method chaining
		 */
		public function give($value = NULL)
		{
			if ($this->openMethod) {
				$this->quip->methods[$this->openMethod][] = [
					'expectation' => $this->expectation,
					'value'       => $value
				];

				//
				// Reset our expectation array and our openMethod
				//

				$this->openMethod  = FALSE;
				$this->expectation = array();

			} elseif ($this->openProperty) {
				$this->quip->properties[$this->openProperty] = $value;

				$this->openProperty = FALSE;

			} else {
				throw new \Exception(sprintf(
					'Cannot give() anything here.  There is no open method or property'
				));
			}

			return $this;
		}

		/**
		 * Tells the class we're defining to implement interfaces, creating it if it does not
		 * exist.
		 *
		 * @access public
		 * @param string $interface The interface to implement
		 * @return Mime The mime for method chaining
		 */
		public function implementing($interface)
		{
			foreach (func_get_args() as $interface) {

				//
				// We want to create the interface if it doesn't exist yet.  We don't want to
				// qualify the namespace until below.
				//

				if (!interface_exists($interface)) {
					eval(call_user_func(function() use ($interface) {
						ob_start() ?>
							interface <?= $interface ?> {}
						<?php return ob_get_clean();
					}));
				}

				self::$interfaces[$this->class][] = self::qualify($interface);
			}

			return $this;
		}


		/**
		 * Opens a method on the quip object
		 *
		 * @access public
		 * @param string $method The name of the method to open
		 * @return Mime The mime for method chaining
		 */
		public function onCall($method)
		{
			if ($this->quip && ($this->openMethod || $this->openProperty)) {
				throw new \Exception(sprintf(
					'Cannot open method %s without first give()-ing a return for %s',
					$method,
					$this->openMethod ?: $this->openProperty
				));
			}

			//
			// Allocate space for the method in the quip object and open
			// a method on it.
			//

			$this->quip->methods[$method] = array();
			$this->openMethod             = $method;

			return $this;
		}


		/**
		 * Opens a property on the quip object
		 *
		 * @access public
		 * @param string $property The name of the property to open
		 * @return Mime The mime for method chaining
		 */
		public function onGet($property)
		{
			if ($this->quip && ($this->openMethod || $this->openProperty)) {
				throw new \Exception(sprintf(
					'Cannot mimick property %s without first give()-ing a return for %s',
					$property,
					$this->openMethod ?: $this->openProperty
				));
			}

			$this->openProperty = $property;

			return $this;
		}


		/**
		 * Register a factory for adding methods/property mocks to objects instantiated later.
		 *
		 * This is useful if the code you are testing has a call such as new Class().  Since the
		 * code is dependent on that object, but it is not injected we essentially want to delay
		 * our method/property configuration for the mock till after that call.  Once the factory
		 * is run it is removed from the stack automatically.
		 *
		 * @access public
		 * @param mixed An optional expected constructor parameter
		 * @param mixed ...
		 * @param Closure A closure which will be passed the newly instantiated quip to work with
		 * @return Mime The mime for method chaining
		 */
		public function onNew()
		{
			$expectation = array_slice(func_get_args(), 0, -1);
			$factory     = array_slice(func_get_args(), -1)[0];

			if (!isset(self::$factories[$this->class])) {
				self::$factories[$this->class] = array();
			}

			self::$factories[$this->class][] = [
				'expectation' => $expectation,
				'factory'     => $factory
			];

			return $this;
		}


		/**
		 * Gets the current working quip object (for injection)
		 *
		 * @access public
		 * @return Quip The quip object, whose class will actually be whatever class you're mocking
		 */
		public function resolve()
		{
			return $this->quip;
		}


		/**
		 * Tell the class we're defining to use a given trait and if it doesn't exist, create it
		 *
		 * @access public
		 * @param string $trait The trait to use
		 * @param ...
		 * @return Mime The mime for method chaining
		 */
		public function using($trait)
		{
			foreach (func_get_args() as $trait) {

				//
				// We want to create the trait if it doesn't exist yet.  We don't want to
				// qualify the namespace until below.
				//

				if (!trait_exists($trait)) {
					eval(call_user_func(function() use ($trait) {
						ob_start() ?>
							trait <?= $trait ?> {}
						<?php return ob_get_clean();
					}));
				}

				self::$traits[$this->class][] = self::qualify($trait);
			}

			return $this;
		}
	}
}
