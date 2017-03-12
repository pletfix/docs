# Models

_What are they, and how are they used?_

[Since 0.5.0]

--  IN ARBEIT!! --

Planned release: 0.6.0

- [Introduction](#introduction1)
- [Defining Models](#defining)
    - [Naming Conventions](#naming-conventions)
    - [General Settings](#general-settings)
    - [Attributes](#attributes)
    - [Getter and Setter](#getter-and-setter)
    - [Relationships](#relationships)
    - [Validations](#validations)    
    - [Events](#events)    
- [Retrieving Models](#retrieving)
    - [Retrieving All Models](#all)
    - [Retrieving a Single Model](#find)
    - [Using Query Builder](#queries)
    - [Eager Loading](#eager-loading)
- [Modification Models](#modification)
    - [Inserting](#inserting)
    - [Updating](#updating)
    - [Deleting](#deleting)
    
<a name="introduction"></a>
## Introduction

Pletfix provides a simple ActiveRecord implementation for working with your database. 
It is inspirated by [Ruby On Rails](http://guides.rubyonrails.org/active_record_basics.html).

Each database table has a corresponding "Model" which is used to interact with that table. Models allow you to query 
for data in your tables, as well as insert new records into the table.

Before getting started, be sure to [configure a database connection](database#configuration) in `config/database.php`. 

<a name="defining"></a>
## Defining Models

A Pletfix model extends the `Core\Services\Contracts\Model` contract and is stored in the `app/Models` directory.
Here is an minimal example of what such a model class might look like:

    class Flight extends Model
    {
    }
    
Yes, that's all!    
    
<a name="naming-conventions"></a>
### Naming Conventions

By default, Pletfix uses the following naming conventions:

- Database Table:  Plural with underscores separating words (snake_case, e.g., `book_clubs`).
- Model Class:     Singular with the first letter of each word capitalized (PascalCase, e.g., `BookClub`).
- Foreign keys:    These fields should be named following the pattern singularized_table_name_id (e.g., `item_id`, `order_id`). 
- Primary keys:    By default, the model will use an integer column named `id` as the table's primary key. 
- Table Column:    Underscores separating words (snake_case, e.g. `created_at`).
- Model Attribute: Like the bounded table column (snake_case, e.g. `created_at`).
- N:M Relationship Table: Singular with an underscore separated table names, alphabetical ordered (e.g. `role_user`)

<a name="general-settings"></a>
### General Settings

<div class="method-list" markdown="1">

[Database Store](#store)
[Database Table](#table)
[Identity Field](#identity)
[Timestamps](#timestamps)
[Create and Updater](#creater-and-updater)

</div>

<a name="store"></a>
#### Database Store

By default, all models will use the default database store configured for your application. 
If you would like to specify a different store for the model, use the `$store` property:

    class Flight extends Model
    {
        /**
         * The database store name for the model.
         *
         * @var string
         */
        protected $store = 'store-name';
    }    

<a name="table"></a>
#### Database Table

Note that we did not set which table to use for our `Flight` model. 
By convention, the "snake case", plural name of the class will be used as the table name unless another name is 
explicitly specified. So, in this case, Eloquent will assume the `Flight` model stores records in the `flights` table. 
You may specify a custom table by defining a `table` property on your model:

    class Flight extends Model
    {
        /**
         * The table associated with the model.
         *
         * @var string
         */
        protected $table = 'flights';
    }

<a name="identity"></a>
#### Identity Field

The Model will also assume that each table has a primary key column named `id`. You may define a `$primaryKey` property 
to override this convention.

    class Flight extends Model
    {
        /**
         * The primary key for the model.
         *
         * @var string
         */
        protected $primaryKey = 'id';
    }

<a name="timestamps"></a>
#### Timestamps

By default, Pletfix expects `created_at` and `updated_at` columns to exist on your tables. If you do not wish to have 
these columns automatically managed by Pletfix, set the `$timestamps` property on your model to `false`.

If you need to customize the names of the columns used to store the timestamps, you may set the `CREATED_AT` and 
`UPDATED_AT` constants in your model:

    class Flight extends Model
    {
        /**
         * Indicates if the model should be timestamped.
         *
         * @var bool
         */
        public $timestamps = true;
        
        /**
         * The name of the "created at" column.
         *
         * @var string
         */
        const CREATED_AT = 'created_at';
    
        /**
         * The name of the "updated at" column.
         *
         * @var string
         */
        const UPDATED_AT = 'updated_at';
    }

<a name="creater-and-updater"></a>
#### Creater and Updater

If you wish to store the user automatically who created the model and who updated it last, set the `$creatorAndUpdater` 
property on your model to `true`. By default, this feature is disabled.

If you need to customize the names of the columns used to store the user, you may set the `CREATED_BY` and 
`UPDATED_BY` constants in your model:

    class Flight extends Model
    {
        /**
         * Indicates if the model should store the user who created the model and who updated it last.
         *
         * @var bool
         */
        protected $creatorAndUpdater = true;

        /**
         * The name of the "created by" column.
         *
         * @var string
         */
        const CREATED_BY = 'created_by';
    
        /**
         * The name of the "updated by" column.
         *
         * @var string
         */
        const UPDATED_BY = 'updated_by';
    }


<a name="attributes"></a>
### Attributes

The model automatically supplies all table columns of the tables as attributes, basically you don't have to do anything. 

<div class="method-list" markdown="1">

[Type Casting](#guarding)
[Guarding Attributes](#guarding)
[Searching Attributes](#searching)
[Accessors and Mutators](#accessors-and-mutators)

</div>

<a name="casting"></a>
#### Type Casting

To enjoy autocomplete of your IDE (e.g. PhpStorm) or to cast the type of the attribute, set the 
[PHPDoc's](https://www.phpdoc.org/docs/latest/references/phpdoc/tags/property.html) `@property` for each column:

    /**
     * @property integer $id Identifier
     * @property string $name Name of the flight
     */
    class Flight extends Model
    {
    }
        
The attributes types will be cast if you define it as above. The supported types are: 

`'int'`, `'float'`, `'string'`, `'boolean'`, `'object'`, `'array'`, `'collection'`, `'datetime'` and `'timestamp'`.

If you omit it, the attributes are treated as string.
       
<!--

TODO: Perhaps this is not needed because the type could be determine via reflection (s. "Attributes" above)

The `$casts` property lists the attributes that should be cast to native types. The supported cast types are: 

`'int'`, `'float'`, `'string'`, `'boolean'`, `'object'`, `'array'`, `'collection'`, `'datetime'` and `'timestamp'`.

    class Flight extends Model
    {
        /**
         * The attributes that should be cast to native types.
         *
         * @var array
         */
        protected $casts = [
            'foo' => 'int',
            'bar' => 'date',
        ];
    }
-->
    
<a name="guarding"></a>
#### Guarding Attributes
 
The `$guarded` property should contain an array of attributes that you do not want to be mass assignable. 
In the example below, all attributes except for 'id', 'created_by', 'updated_by', 'created_at' and 'updated_at' will 
be mass assignable via `update()` and `insert()`:

    class Flight extends Model
    {
        /**
         * The attributes that aren't mass assignable.
         *
         * @var array
         */
        protected $guarded = ['id', 'created_by', 'updated_by', 'created_at', 'updated_at'];
    }
        

<!--     
<a name="fillable"></a>
#### Fillable Attributes
 
The `$fillable` property should contain an array of attributes that you do not want to be mass assignable. 
In the example below, all attributes except for 'id', 'created_by', 'updated_by', 'created_at' and 'updated_at' will 
be mass assignable via `update()` and `insert()`:

    class Flight extends Model
    {
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = ['name'];
    }
-->  
      
<a name="searching"></a>
#### Searching Attributes
    
TODO

    /**
     * Searchable fields.
     *
     * @var array
     */
    protected $searchable = [
        'filename',
        'articles.id',
        'articles.title',
        'newsletters.id',
        'newsletters.subject',
    ];      
    
    
<a name="accessors-and-mutators"></a>
#### Accessors and Mutators

The model stores the values of the table columns in the protected `$attributes` property. 
Accessors and mutators allow you to modifier the attribute values when you retrieve or set them on model instances. 

To define an accessor, create a `getFooAttribute` method on your model where `Foo` is the "studly" cased name of the 
column you wish to access. In the same way to define a mutator, create a `setFooAttribute` method:

    /**
     * Get the user's first name.
     *
     * @return string
     */
    public function getFirstNameAttribute()
    {
        return ucfirst($this->attributes['first_name']);
    }
    
    /**
     * Set the user's first name.
     *
     * @param  string  $value
     */
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = strtolower($value);
    }  

To access the value of the accessor in the example above, you may simply access the `first_name` attribute on a model 
instance:

    $user = App\User::find(1);
    $user->first_name = 'Sally';
    echo $user->first_name;

      
<a name="relationships"></a>
### Relationships

<div class="method-list" markdown="1">

[One To One](#one-to-one)
[One To Many](#one-to-many)
[Many To Many](#many-to-many)
[Polymorphic Relations](#polymorphic)

</div>

<a name="one-to-one"></a>
#### 1:1 - One To One

A one-to-one relationship is a very basic relation. 

For example, each user in your application could define one own avatar. So you need the following table relationship:    

    suppliers.id <----> accounts.supplier_id
    users.id <----> avatars.user_id

And your models looks like this:

You'd declare the supplier model like this:

    class User extends Model
    {
        /**
         * Define one-to-one relationships.
         */
        protected $hasOne = [Avartar::class];
    }
    
    class Avartar extends Model
    {
        /**
         * Define inverse one-to-one or one-to-many relationships.
         *
        protected $belongsTo = [User::class];
    }
    
<a name="one-to-many"></a>
#### 1:N - One To Many

TODO

customers.id <----> articles.customer_id
 
    Customer->hasMany(Article)
    
    Article->belongsTo(Customer)


<a name="many-to-many"></a>
#### N:M - Many To Many

TODO

articles.id <----> article_category.article_id, 
article_category.category_id <----> categories.id

    Article->belongsToMany(Category)
    
    Category->belongsToMany(Article)


<a name="polymorphic"></a>
#### Polymorphic Relations

TODO

<a name="validations"></a>
### Validations

    /**
     * Validation rules.
     *
     * @var array
     */
    protected static $rules = [
    ];


<a name="events"></a>
### Events
    
TODO


<a name="retrieving"></a>
## Retrieving Models

<a name="all"></a>
### Retrieving All Models

The `all` method will return a [`Collection`](collections) with all of the results in the model's table:

    $flights = Flight::all();
    
<a name="find"></a>
### Retrieving a Single Model

The `find` method is useful when a model is searched for its ID. The method returns a single model instance, or `null` 
if the model does not exist:

    $flight = Flight::find(4711);

You may also call the `find` method with an array of primary keys, which will return a [`Collection`](collections) of 
the matching records:

    $flights = Flight::find([1, 2, 3]);

<a name="queries"></a>
### Using Query Builder

Since each `Model` serves as a [query builder](queries), you may add constraints to queries, and then use the `all`, 
`cursor`, `first` or `get` method to retrieve the results:

    $flights = Flight::where('active', 1)
       ->orderBy('name', 'desc')
       ->take(10)
       ->all();

You may also use the `count`, `sum`, `max`, and other [aggregate methods](queries#aggregates) provided by the 
query builder. These methods return the appropriate scalar value instead of a full model instance:

    $count = App\Flight::where('active', 1)->count();
    $max   = App\Flight::where('active', 1)->max('price');

See [Query Builder](queries) for more details.

<a name="eager-loading"></a>
### Eager Loading

TODO
 
The `with` method returns a [`QueryBuilder`](queries) instance.
 
- Difference between Lazy and Eager Loading


<a name="modification"></a>
## Modification Models

<a name="inserting"></a>
### Inserting

To create a new record in the database, simply create a new model instance, set attributes on the model, then call the 
`save` method:

    $flight = new Flight;
    $flight->name = 'Albatros';
    $flight->save();

When we call the `save` method, a record will be inserted into the database. 
The `created_at` and `updated_at` timestamps will automatically be set when the `save` method is called, so there is 
no need to set them manually.

You can also use the `create` method to insert a new record in the database. 

    $flight = Flight::create(['name' => 'Flight 10']);

The `create` method returns the saved model instance.

> <i class="fa fa-exclamation-circle fa-2x" aria-hidden="true"></i>
> If you use the `create` method, you will need to specify either a `fillable` or `guarded` attribute on the 
> model, as all Models protect against mass-assignment by default.

<a name="updating"></a>
### Updating

The `save` method may also be used to update models that already exist in the database. To update a model, you should 
retrieve it, set any attributes you wish to update, and then call the `save` method. Again, the `updated_at` timestamp 
will automatically be updated, so there is no need to manually set its value:

    $flight = Flight::find(1);
    $flight->name = 'New Flight Name';
    $flight->save();

You can also use the `update` method to update one or more model instances:

    $flights->update(['delayed' => 1]);

The `update` method expects an array of column and value pairs representing the columns that should be updated.

> <i class="fa fa-exclamation-circle fa-2x" aria-hidden="true"></i>
> If you use the `update` method, you will need to specify either a `fillable` or `guarded` attribute on the 
> model, as all Models protect against mass-assignment by default.

#### Fill Existing Model

If you already have a model instance, you may use the fill method to populate it with an array of attributes:

    $flight->fill(['name' => 'Flight 22']);

<a name="deleting"></a>
### Deleting

To delete a model, call the `delete` method on a model instance:

    $flight = Flight::find(1);
    $flight->delete();

In the example above, we are retrieving the model from the database before calling the `delete` method. However, if 
you know the primary key of the model, you may delete the model without retrieving it. To do so, call the `destroy` method:

    Flight::destroy(1);
    Flight::destroy([1, 2, 3]);
