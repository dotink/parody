# `Quip`
##Quip is the replacement for your actual classes.  It will respond to methods and actions
configured by Mime.  Quips are verbal, Mimes are not.

_Copyright (c) 2012 - 2013, Matthew J. Sahagian_.
  _Please reference the LICENSE.txt file at the root of this distribution_
#### Authors

<table>
	<thead>
		<th>Name</th>
		<th>Handle</th>
		<th>Email</th>
	</thead>
	<tbody>
			<tr>
			<td>
				Matthew J. Sahagian
			</td>
			<td>
				mjs
			</td>
			<td>
				gent@dotink.org
			</td>
		</tr>
	
	</tbody>
</table>

## Properties

### Static Properties

#### <span style="color:#6a6e3d;">$objects</span>

A list of the first created Quips keyed by class

#### <span style="color:#6a6e3d;">$factories</span>

A list of availble factories for instantiating classes, keyed by class name


### Instance Properties
#### <span style="color:#6a6e3d;">$extended</span>

The extended properties for this Quip

#### <span style="color:#6a6e3d;">$methods</span>

The registered methods on this Quip, keyed by method name

#### <span style="color:#6a6e3d;">$properties</span>

The registered properties on this Quip, keyed by property name

#### <span style="color:#6a6e3d;">$mime</span>

The mime associated with this object.  This value is only set in the Mime constructor.



## Methods

### Static Methods
<hr />

#### <span style="color:#3e6a6e;">__callStatic()</span>

Handle missing static calls

##### Details

Static calls are always looked up on the most recently instantiated Quip, so if you
need to mimick their functionality you should create a mime and add them first.

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
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

###### Returns

<dl>
	
		<dt>
			mixed
		</dt>
		<dd>
			The value that the method should provide with matching expectations
		</dd>
	
</dl>


### Instance Methods
<hr />

#### <span style="color:#3e6a6e;">__construct()</span>

Instantiate a new Quip.

##### Details

This method will look through the list of registered factories created with the
Mime::onNew() method.  The factory is passed a new mime wrapper with this quip as
it's first and only argument for post-instantiation modification.

###### Returns

<dl>
	
		<dt>
			void
		</dt>
		<dd>
			Provides no return value.
		</dd>
	
</dl>

<hr />

#### <span style="color:#3e6a6e;">__call()</span>

Handle missing instance calls

##### Details

This method will look for the value assigned via Mime::onCall which whose expectations
match the arguments provided.  If the value is a Closure the return value of the closure
will be returned, but the Quip's mime will be passed as the first and only argument
so that future behavior can be modified based on the call.

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
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

###### Returns

<dl>
	
		<dt>
			mixed
		</dt>
		<dd>
			The value as mimicked by the call
		</dd>
	
</dl>

<hr />

#### <span style="color:#3e6a6e;">__get()</span>

Handle missing instance properties

##### Details

This method will return the value assigned via Mime::onGet.  It is possible that a user
is attempting to mimic a magic property which would normally be accessed and provided
via the __get() method on the actual class.  Since this method can contain logic, it
is also possible to have a Closure registered with Mime::give() on a property.  As with
other mimicking, the Closure will be passed the mime object as the first and only
argument.

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
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

###### Returns

<dl>
	
		<dt>
			mixed
		</dt>
		<dd>
			The value as mimicked by the property
		</dd>
	
</dl>

<hr />

#### <span style="color:#3e6a6e;">__isset()</span>

Handle checking whether or not properties are set

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
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

###### Returns

<dl>
	
		<dt>
			boolean
		</dt>
		<dd>
			TRUE if the mimicked property is set, FALSE otherwise
		</dd>
	
</dl>

<hr />

#### <span style="color:#3e6a6e;">__unset()</span>

Handle unsetting a property

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
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

###### Returns

<dl>
	
		<dt>
			void
		</dt>
		<dd>
			Provides no return value.
		</dd>
	
</dl>

<hr />

#### <span style="color:#3e6a6e;">__set()</span>

Handle setting properties

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
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

###### Returns

<dl>
	
		<dt>
			void
		</dt>
		<dd>
			Provides no return value.
		</dd>
	
</dl>



