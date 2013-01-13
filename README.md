# Parody

Parody is an extremely simple library that can be used to mimic classes and objects as well as provide working results for method calls (both object and static), getting properties, instantiating objects, etc.  It uses sequential method chaining to make defining class structures and operation extremely quick.

This is most useful for testing.  You can see an example of it being used in inKWell 2.0 with Dotink's Lab framework [here](https://github.com/dotink/inKWellToo/blob/master/external/testing/tests/Core.php)

## Including it in a Project

```php
include 'Jest.php';
include 'Mime.php';
```

Obviously you will have to potentially change the name/location of the files, but the key point above is that `Jest` should be included before `Mime`.  Jest and Mime exist in the `Dotink\Parody` namespace, so if you're using namespaces in the surrounding context you may wish to alias/import.

```php
namespace Vendor\Project {

	use Dotink\Parody;
}
```

All examples that follow assume the `Parody` namespace is available.

## Defining a Class

```php
Parody\Mime::define('Vendor\Project\Class');
```

The example above shows the simplest way to define a class.  Using any definition based methods on `Mime`, you should keep in mind that you should always provide the full namespace however, you should not use the preceding `\` as all are assumed to be rooted in the global namespace.

### Defining an Inheriting Class

You can use the `extending()` method to provide a parent class to the defined class.

```php
Parody\Mime::define('Vendor\Project\Class')
	-> extending('Vendor\Project\BaseClass');
```

Using the extending method changes the chaining context to that class, so to create a whole chain
of inheretance you can do the following.

```php
Parody\Mime::define('Vendor\Project\Class')
	-> extending('Vendor\Project\ParentClass')
	-> extending('Vendor\Project\GrandParentClass')
```

### Implementing Interfaces

Using the `implementing()` method you can make defined classes implement arbitrary interfaces.

```php
Parody\Mime::define('Vendor\Project\Class')
	-> implementing('Vendor\Interfaces\CustomInterface')
	-> extending('Vendor\Project\BaseClass')
		-> implementing('Vendor\Interfaces\BasicInterface');
```

The above example shows the creation of a class implementing the `CustomInterface` which extends a `BaseClass` implementing `BasicInterface`.  As such, The original `Class` would respond as implementing both interfaces, and also would identify as a subclass of `BaseClass`.

You can implement more than a single interface directly on one class by passing multiple arguments to `implementing()`.

### Using Traits

Traits are done similar to interfaces, except they are defined with the `using()` method.

```php
Parody\Mime::define('Vendor\Project\Class')
	-> using('Vendor\Traits\SharedFunctionality');
```

## Creating Objects and Calling Methods

Once classes have been defined you can begin creating object instances of them or define certain properties, method calls, and their respective responses.  It is also possible to register a function to define these things for future instantiations.

### Basic Usage

```php
Parody\Mime::create('Vendor\Project\Class')
	-> onCall('method') -> give('response')
	-> onGet('booleanProperty') -> give(TRUE);
```

The `Mime::create()` method creates an internal object instance of the class requested.  This class, regardless of how many parent classes it has is inevitably a child of `Jest`.  `Jest` objects are very simple objects which are manipulated by `Mime`s to make parody possible.

### Resolving the Jest

You can get the `Jest` object by using the `resolve()` method.

```php
$jest = Parody\Mime::create('Vendor\Project\Class')
	-> onCall('method') -> give('response')
	-> onGet('booleanProperty') -> give(TRUE)
	-> resolve()
```

You can then use the `Jest` object to call the methods or get the properties you established.

```php
if ($jest->booleanProperty) {
	echo $jest->method();    // This would print 'response'
}
```

### Expecting Arguments

`Jest`s should not be taken the wrong way, but inevitably you will have to deal with arguments and vary your responses depending on what those are.  It's possible to `expect()` them.

```php
$jest = Parody\Mime::create('Vendor\Class\Project')
	-> onCall('method') -> expect('argument one') -> give('response one')
	-> onCall('method') -> expect('argument two') -> give('response two')
	-> resolve();
```

Now we're ready for some back and fourth!

```php
if ($jest->method('argument one') == 'response one') {
	echo 'I really wanted ' . $jest->method('argument two');
}
```
The above will output the string 'I really wanted argument two'.

### Static Methods

It doesn't matter how a method is called:

```php
if (Vendor\Class\Project::method('argument one') == $jest->method('argument one')) {
	echo 'So the parody is useful for static dependencies too.';
}
```

### I Still Have Serious Dependency Issues!

For those who don't always do `new` things at the right time, you may be worried that Parody won't do much for your non injected dependencies.  But it can:

```php
Parody\Mime::create('Vendor\Class\Project')
	-> onNew(function($mime) {
		$mime->onCall('method')->give('results');
	});
```

We could even fall a-`sleep()` for 10 minutes at this point and then do the following...

```php
$non_injected_dependency = new Vendor\Class\Project();

echo '... and still get our ' . $non_injected_dependency->method();
```

Or in other words, '... and still get our results'.

## Conclusion

`Mime`s use `Jest`s to conduct `Parody`.
