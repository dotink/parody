# Mime

Mime objects are used to define, create, and modify classes and Quip object instances so that they will respond in certain ways when mimicking the real class they are supposed to replace.

| Information | Detail
|-------------|-------------------------------------------------------------------------------------
| Signature   | `static public function create($class)`
| Extends     | Quip

## Static Methods

### create()

Create a new quip (mocked object) of a particular class to work on.

| Information | Detail
|-------------|-------------------------------------------------------------------------------------
| Signature   | `static public function create($class)`

##### Parameters

| Type        | Name         | Description
|-------------|--------------|----------------------------------------------------------------------
| String      | $class       | The class to instantiate or object to modify (must extend Quip)

##### Returns

| Type        | Descripton
|-------------|-------------------------------------------------------------------------------------
| Mime        | The mime object for method chaining

### define()

Define a new quip (mocked class) to work on.

| Information | Detail
|-------------|-------------------------------------------------------------------------------------
| Signature   | `static public function define($class)`

##### Parameters

| Type        | Name         | Description
|-------------|--------------|----------------------------------------------------------------------
| String      | $class       | The class to define

##### Returns

| Type        | Descripton
|-------------|-------------------------------------------------------------------------------------
| Mime        | The mime object for method chaining

#### make()

Literally makes (evals) a class.

| Information | Detail
|-------------|-------------------------------------------------------------------------------------
| Signature   | `static private function make($class)`

##### Parameters

| Type        | Name         | Description
|-------------|--------------|----------------------------------------------------------------------
| String      | $class       | The class to make

##### Returns

| Type        | Descripton
|-------------|-------------------------------------------------------------------------------------
| String      | The qualified class which is the fully qualified class name minus the first (globa) namespace separator


## Instance Methods

###

