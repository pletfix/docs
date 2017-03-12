# Query Builder

_An object oriented Query Builder_

[Since 0.5.0]

- [Introduction](#introduction)
- [Create A Builder Instance](#creating)
- [Select Query Language](#sql)
    - [General Usage](#general-usage)
    - [Aggregate Methods](#aggregates)
- [Data Manipulation Language](#dml)
    - [Insert](#insert)
    - [Update](#update)
    - [Delete](#delete)

<!--
    - [Joins](#joins)
    - [Unions](#unions)
    - [Where Clauses](#where)
-->

> The Pletfix QueryBuilder is an adapter for [Aura.SqlQuery Factory](https://github.com/auraphp/Aura.SqlQuery)
> and therefore this manual based on Aura's original Documentation.
> It's open-sourced software licensed under the [BSD license](https://github.com/auraphp/Aura.SqlQuery/blob/3.x/LICENSE).

**Revision notice**

The QueryBuilder will be improved from 0.6.0: 
- The Builder will be based on Aura.SqlQuery Factory, but it is no longer an adapter. 
- insert(), Update() and delete() will be removed, only select() is still supported. 
- You may use the `select` member function of a [`Database`](database) instance to create a new builder:
         
        $builder = database()->select();
        
- Each [`Model`](models) serves also as a query builder:

        $users = User::orderBy('name')->get();
        $users = User::take('10')->get();
        $users = User::where('id = ?')->bind([4711])->first();  // same: User::find(4711);
        ...

- The argument from the `fromSubSelect` function is invoked (and equivalent `joinSubSelect` ). The closure receives an 
  instance of the current builder as a parameter and should return an instance of a builder too:
  
        $builder = database()
           ->select()
           ->fromSubSelect(function($builder) {
              return $builder->select(['id', name'])->from('users')->where('id', '=', 4711);
        })
        
   Maybe the function will be renamed to `from`, we will see.     

- You may execute the query against a database by calling the `get` function: 

        $users = database()
           ->select(['id', 'name'])
           ->from('users')
           ->where('id = ?') 
           ->bind([4711])
           ->as(User::class)
           ->get();

- You could also use `first`, `scalar` and `cursor` to get the data records. 
- `bindValue` and `bindValues` will be renamed to `bind`     
    
<a name="introduction"></a>
## Introduction

Pletfix provides a query builders for MySQL, Postgres, SQLite, and Microsoft SQL Server.
These builders are independent of any particular database drivers.

<a name="creating"></a>
## Create A Builder Instance

You may use the `query_builder()` function to access the `QueryBuilder` instance for the default database 
store:

    $builder = query_builder();
    
You can set the store name if you use an another store as the default. The store name should correspond to one of the 
stores listed in the `stores` configuration array in your `database` configuration file:
    
    $builder = query_builder('my-database-store');
    
> The `query_builder()` function is just a shortcut to get the `QueryBuilder` instance via the `QueryBuilderFactory` 
> supported by [Dependency Injector](di): 
>    
>       $builder = DI::getInstance()->get('query-builder-factory')->store($store);

Note, that the query builder object does not execute the query against a database!
When you are done building the query, you will need to pass it to a [database connection](database#queries) like this:

    $users = database()->query(
        query_builder()
            ->select()
            ->from('users')
            ->where('role = :role')
    ), ['role' => 'guest']);


<a name="sql"></a>
## Select Query Language

<a name="general-usage"></a>
### General Usage

Build a `SELECT` statement using the following methods. They do not need to be called in any particular order, and may 
be called multiple times.

    $sql = query_builder()
        ->select()
        ->distinct()                    // SELECT DISTINCT
        ->cols([                        // select these columns
            'id',                       // column name
            'name AS namecol',          // one way of aliasing
            'col_name' => 'col_alias',  // another way of aliasing
            'COUNT(foo) AS foo_count'   // embed calculations directly
        ])
        ->from('foo AS f')              // FROM these tables
        ->fromSubSelect(                // FROM sub-select AS my_sub
            'SELECT ...',
            'my_sub'
        )
        ->join(                         // JOIN ...
            'LEFT',                     // left/inner/natural/etc
            'doom AS d',                // this table name
            'foo.id = d.foo_id'         // ON these conditions
        )
        ->joinSubSelect(                // JOIN to a sub-select
            'INNER',                    // left/inner/natural/etc
            'SELECT ...',               // the subselect to join on
            'subjoin',                  // AS this name
            'sub.id = foo.id'           // ON these conditions
        )
        ->where('bar > :bar')           // AND WHERE these conditions
        ->where('zim = ?', 'zim_val')   // bind 'zim_val' to the ? placeholder
        ->orWhere('baz < :baz')         // OR WHERE these conditions
        ->groupBy(['dib'])              // GROUP BY these columns
        ->having('foo = :foo')          // AND HAVING these conditions
        ->having('bar > ?', 'bar_val')  // bind 'bar_val' to the ? placeholder
        ->orHaving('baz < :baz')        // OR HAVING these conditions
        ->orderBy(['baz'])              // ORDER BY these columns
        ->limit(10)                     // LIMIT 10
        ->offset(40)                    // OFFSET 40
        ->forUpdate()                   // FOR UPDATE
        ->union()                       // UNION with a followup SELECT
        ->unionAll()                    // UNION ALL with a followup SELECT
        ->bindValue('foo', 'foo_val')   // bind one value to a placeholder
        ->bindValues([                  // bind these values to named placeholders
            'bar' => 'bar_val',
            'baz' => 'baz_val',
        ]);

> The `*where()` and `*having()` methods take an arbitrary number of trailing arguments, each of which is a value to 
bind to a sequential question-mark placeholder in the condition clause.
>
> Similarly, the `*join*()` methods take an optional final argument, a sequential array of values to bind to sequential 
question-mark placeholders in the condition clause.

<div class="method-list" markdown="1">

[all](#all)
[cursor](#cursor)
[first](#first)
[get](#get)
[join](#join)
[where](#where)

</div>

<a name="queries-method-listing"></a>
### Method Listing

<a name="all"></a>
#### `all()`

The `all` method will return a [`Collection`](collections) with all of the results in the model's table:

    $flights = Flight::all();

<a name="cursor"></a>
#### `cursor()`

The `cursor` method returns a [generator](http://php.net/manual/de/language.generators.syntax.php) and allows you to 
iterate through your database records using a cursor, which will only execute a single query. When processing large 
amounts of data, the `cursor` method may be used to greatly reduce your memory usage:

    foreach (Flight::where('foo', 'bar')->cursor() as $flight) {
        //
    }

<a name="first"></a>
#### `first()`

The `first` method fetches the first model:

    $flight = Flight::first();

<a name="get"></a>
#### `get()`

The `get` method returns the value of the given attribute of the first model:

    $name = Flight::get('name');

<a name="join"></a>
#### `join()`

TODO

The `join` method returns a [`QueryBuilder`](queries) instance.

The current model will inherit the attributes of the joined model.

INNER, LEFT, RIGHT, OUTER

It's also possible to use a subselect.

<a name="where"></a>
#### `where()`

TODO

The `where` method returns a [`QueryBuilder`](queries) instance.

It's also possible to use a subselect.


#### Resetting Query Elements

The _Select_ class comes with the following methods to "reset" various clauses a blank state. This can be useful when 
reusing the same query in different variations (e.g., to re-issue a query to get a `COUNT(*)` without a `LIMIT`, to
find the total number of rows to be paginated over).

- `resetCols()` removes all columns
- `resetTable()` removes all `FROM` and `JOIN` clauses
- `resetWhere()`, `resetGroupBy()`, `resetHaving()`, and `resetOrderBy()` remove the respective clauses
- `resetUnions()` removes all `UNION` and `UNION ALL` clauses
- `resetFlags()` removes all database-engine-specific flags
- `resetBindValues()` removes all values bound to named placeholders

<a name="aggregates"></a>
### Aggregate Methods

Planned release: 0.6.0

TODO

<div class="method-list" markdown="1">

[count](#method-count)
[sum](#method-sum)

</div>

<a name="method-count"></a>
#### `count()`

TODO

<a name="method-sum"></a>
#### `sum()`

TODO    
    
<a name="dml"></a>
## Data Manipulation Language

<a name="insert"></a>
### Insert

Build an _insert_ query using the following methods. They do not need to be called in any particular order, and may be 
called multiple times.

    $sql = query_builder()
        ->insert()
        ->into('foo')                   // INTO this table
        ->cols([                        // bind values as "(col) VALUES (:col)"
            'bar',
            'baz',
        ])
        ->set('ts', 'NOW()')            // raw value as "(ts) VALUES (NOW())"
        ->bindValue('foo', 'foo_val')   // bind one value to a placeholder
        ->bindValues([                  // bind these values
            'bar' => 'foo',
            'baz' => 'zim',
        ]);

The `cols()` method allows you to pass an array of key-value pairs where the key is the column name and the value is a 
bind value (not a raw value):

    $sql = query_builder()
        ->insert()
        ->into('foo')                   // insert into this table
        ->cols([                        // insert these columns and bind these values
            'foo' => 'foo_value',
            'bar' => 'bar_value',
            'baz' => 'baz_value',
        ]);

<a name="update"></a>
### Update

Build an _update_ query using the following methods. They do not need to be called in any particular order, and may be 
called multiple times.

    $sql = query_builder()
        ->update()
        ->table('foo')                  // update this table
        ->cols([                        // bind values as "SET bar = :bar"
            'bar',
            'baz',
        ])
        ->set('ts', 'NOW()')            // raw value as "(ts) VALUES (NOW())"
        ->where('zim = :zim')           // AND WHERE these conditions
        ->where('gir = ?', 'doom')      // bind this value to the condition
        ->orWhere('gir = :gir')         // OR WHERE these conditions
        ->bindValue('bar', 'bar_val')   // bind one value to a placeholder
        ->bindValues([                  // bind these values to the query
            'baz' => 99,
            'zim' => 'dib',
            'gir' => 'doom',
        ]);

The `cols()` method allows you to pass an array of key-value pairs where the key is the column name and the value is a 
bind value (not a raw value):

    $sql = query_builder()
        ->update()
        ->table('foo')                  // update this table
        ->cols(array(                   // update these columns and bind these values
            'foo' => 'foo_value',
            'bar' => 'bar_value',
            'baz' => 'baz_value',
        ));

<a name="delete"></a>
### Delete

Build a _delete_ query using the following methods. They do not need to
be called in any particular order, and may be called multiple times.

    $sql = query_builder()
        ->delete()
        ->from('foo')                   // FROM this table
        ->where('zim = :zim')           // AND WHERE these conditions
        ->where('gir = ?', 'doom')      // bind this value to the condition
        ->orWhere('gir = :gir')         // OR WHERE these conditions
        ->bindValue('bar', 'bar_val')   // bind one value to a placeholder
        ->bindValues(array(             // bind these values to the query
            'baz' => 99,
            'zim' => 'dib',
            'gir' => 'doom',
        ));
