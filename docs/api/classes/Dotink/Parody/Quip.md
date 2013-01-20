# Quip

## Static Methods

### __callStatic()

Handle missing static calls

Static calls are always looked up on the most recently instantiated Quip, so if you
need to mimick their functionality you should create a mime and add them first.

`static public function __callStatic()`


##### Parameters

<table>
	<thead>
		<th>Param</th>
		<th>Type</th>
		<th>Description</th>
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
				The static method we are trying to call
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
				The arguments that were passed to the method
			</td>
		</tr>
		
	</tbody>
</table>



## Object Methods

### __call()

Handle missing instance calls

This method will look for the value assigned via Mime::onCall which whose expectations
match the arguments provided.  If the value is a Closure the return value of the closure
will be returned, but the Quip's mime will be passed as the first and only argument
so that future behavior can be modified based on the call.

`public function __call()`


##### Parameters

<table>
	<thead>
		<th>Param</th>
		<th>Type</th>
		<th>Description</th>
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
				The method we are trying to call
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
				The arguments that were passed to the method
			</td>
		</tr>
		
	</tbody>
</table>

### __construct()

Instantiate a new Quip.

This method will look through the list of registered factories created with the
Mime::onNew() method.  The factory is passed a new mime wrapper with this quip as
it's first and only argument for post-instantiation modification.

`public function __construct()`

### __get()

Handle missing instance properties

This method will return the value assigned via Mime::onGet.  It is possible that a user
is attempting to mimic a magic property which would normally be accessed and provided
via the __get() method on the actual class.  Since this method can contain logic, it
is also possible to have a Closure registered with Mime::give() on a property.  As with
other mimicking, the Closure will be passed the mime object as the first and only
argument.

`public function __get()`


##### Parameters

<table>
	<thead>
		<th>Param</th>
		<th>Type</th>
		<th>Description</th>
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
				The property we are trying to get
			</td>
		</tr>
		
	</tbody>
</table>

### __isset()

Handle checking whether or not properties are set

`public function __isset()`


##### Parameters

<table>
	<thead>
		<th>Param</th>
		<th>Type</th>
		<th>Description</th>
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
				The property to check if it is set
			</td>
		</tr>
		
	</tbody>
</table>

### __set()

Handle setting properties

`public function __set()`


##### Parameters

<table>
	<thead>
		<th>Param</th>
		<th>Type</th>
		<th>Description</th>
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
				THe property to set
			</td>
		</tr>
			
		<tr>
			<td>
				$value
			</td>
			<td>
				mixed
			</td>
			<td>
				The value to set it to
			</td>
		</tr>
		
	</tbody>
</table>

### __unset()

Handle unsetting a property

`public function __unset()`


##### Parameters

<table>
	<thead>
		<th>Param</th>
		<th>Type</th>
		<th>Description</th>
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
				The property to check if it is set
			</td>
		</tr>
		
	</tbody>
</table>

