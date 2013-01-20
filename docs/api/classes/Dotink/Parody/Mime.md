# Mime

## Static Methods

### create()

Create a new quip (mocked object) of a particular class to work on.


### define()

Define a new quip (mocked class) to work on.


### qualify()

Qualifies a class for the global namespace by ensuring it has a \ in front.


### make()

Literally makes (evals) a class.




## Object Methods

### __call()

Handle missing calls which, in short, means we should be looking for an extension.

`public function __call()`


##### Parameters

<table>
	<thead>
		<td>Param</td>
		<td>Type</td>
		<td>Description</td>
	</thead>
	<tbody>
		
		<tr>
			<td>
				$method
			</td>
			<td>
				string
			</td>
			<td>
				The method we tried to call
			</td>
		</tr>
			
		<tr>
			<td>
				$args
			</td>
			<td>
				array
			</td>
			<td>
				The arguments we passed to it
			</td>
		</tr>
		
	</tbody>
</table>

### __construct()

Create a new Mime.

`public function __construct()`


##### Parameters

<table>
	<thead>
		<td>Param</td>
		<td>Type</td>
		<td>Description</td>
	</thead>
	<tbody>
		
		<tr>
			<td rowspan="1">
				$target
			</td>
			<td>
				string
			</td>
			<td rowspan="1">
				A class name or quip to work with.
			</td>
		</tr>
		
		<tr>
			<td>
				object
			</td>
		</tr>
				
	</tbody>
</table>

### expect()

Tell an open method what to expect

`public function expect()`


##### Parameters

<table>
	<thead>
		<td>Param</td>
		<td>Type</td>
		<td>Description</td>
	</thead>
	<tbody>
		
		<tr>
			<td>
				$value
			</td>
			<td>
				mixed
			</td>
			<td>
				The expected parameter value for the mocked method
			</td>
		</tr>
			
		<tr>
			<td colspan="3">...</td>
		</tr>
		
	</tbody>
</table>

### extending()

Tells the class we're defining to extend a parent class, creating it if it does not
exist.

`public function extending()`


##### Parameters

<table>
	<thead>
		<td>Param</td>
		<td>Type</td>
		<td>Description</td>
	</thead>
	<tbody>
		
		<tr>
			<td>
				$parent_class
			</td>
			<td>
				string
			</td>
			<td>
				The parent class to define
			</td>
		</tr>
		
	</tbody>
</table>

### give()

Define a value to give for the open method or property

`public function give()`


##### Parameters

<table>
	<thead>
		<td>Param</td>
		<td>Type</td>
		<td>Description</td>
	</thead>
	<tbody>
		
		<tr>
			<td>
				$value
			</td>
			<td>
				mixed
			</td>
			<td>
				The value to return for the open method or property
			</td>
		</tr>
		
	</tbody>
</table>

### implementing()

Tells the class we're defining to implement interfaces, creating it if it does not
exist.

`public function implementing()`


##### Parameters

<table>
	<thead>
		<td>Param</td>
		<td>Type</td>
		<td>Description</td>
	</thead>
	<tbody>
		
		<tr>
			<td>
				$interface
			</td>
			<td>
				string
			</td>
			<td>
				The interface to implement
			</td>
		</tr>
		
	</tbody>
</table>

### onCall()

Opens a method on the quip object

`public function onCall()`


##### Parameters

<table>
	<thead>
		<td>Param</td>
		<td>Type</td>
		<td>Description</td>
	</thead>
	<tbody>
		
		<tr>
			<td>
				$method
			</td>
			<td>
				string
			</td>
			<td>
				The name of the method to open
			</td>
		</tr>
		
	</tbody>
</table>

### onGet()

Opens a property on the quip object

`public function onGet()`


##### Parameters

<table>
	<thead>
		<td>Param</td>
		<td>Type</td>
		<td>Description</td>
	</thead>
	<tbody>
		
		<tr>
			<td>
				$property
			</td>
			<td>
				string
			</td>
			<td>
				The name of the property to open
			</td>
		</tr>
		
	</tbody>
</table>

### onNew()

Register a factory for adding methods/property mocks to objects instantiated later.

This is useful if the code you are testing has a call such as new Class().  Since the
code is dependent on that object, but it is not injected we essentially want to delay
our method/property configuration for the mock till after that call.  Once the factory
is run it is removed from the stack automatically.

`public function onNew()`


##### Parameters

<table>
	<thead>
		<td>Param</td>
		<td>Type</td>
		<td>Description</td>
	</thead>
	<tbody>
		
		<tr>
			<td>
				An
			</td>
			<td>
				mixed
			</td>
			<td>
				optional expected constructor parameter
			</td>
		</tr>
			
		<tr>
			<td>
				...
			</td>
			<td>
				mixed
			</td>
			<td>
				
			</td>
		</tr>
			
		<tr>
			<td>
				A
			</td>
			<td>
				Closure
			</td>
			<td>
				closure which will be passed the newly instantiated quip to work with
			</td>
		</tr>
		
	</tbody>
</table>

### resolve()

Gets the current working quip object (for injection)

`public function resolve()`

### using()

Tell the class we're defining to use a given trait and if it doesn't exist, create it

`public function using()`


##### Parameters

<table>
	<thead>
		<td>Param</td>
		<td>Type</td>
		<td>Description</td>
	</thead>
	<tbody>
		
		<tr>
			<td>
				$trait
			</td>
			<td>
				string
			</td>
			<td>
				The trait to use
			</td>
		</tr>
			
		<tr>
			<td colspan="3">...</td>
		</tr>
		
	</tbody>
</table>

