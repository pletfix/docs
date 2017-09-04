# Query Builder

_An object oriented Query Builder_

[Since 0.6.0]

- [Introduction](#introduction)
- [Create A Builder Instance](#creating)
- [Select Query Language](#sql)
    - [General Usage](#general-usage)
    - [SQL Clauses](#clauses)
    - [Execute Queries](#execute)
    - [Aggregate Functions](#aggregates)
    - [SQL Operators and Functions](#sql-functions)
- [Data Manipulation Language](#dml)
    - [Insert](#insert)
    - [Update](#update)
    - [Delete](#delete)
- [Miscellanea Functions](#misc)

<a name="introduction"></a>
## Introduction

Pletfix provides an easy to use and powerful QueryBuilder for 
- MySQL
- PostgreSQL
- SQLite and 
- Microsoft SQL Server.

Pletfix has studied these libraries, picked up ideas from them, and partly adopted codes:
- [CakePHP's Database Library](https://github.com/cakephp/database/tree/3.2) ([MIT License](https://cakephp.org/))
- [Aura's QueryFactory](https://github.com/auraphp/Aura.SqlQuery) ([BSD 2-clause "Simplified" License](https://github.com/auraphp/Aura.SqlQuery/blob/3.x/LICENSE))
- [Laravel's QueryBuilder](https://github.com/illuminate/database/blob/5.3/Query/Builder.php) ([MIT License](https://github.com/laravel/laravel/tree/5.3))

<a name="creating"></a>
## Create A Builder Instance

You may use the `builder` method of a [Database](database#method-builder) instance to create a new builder:
         
    $builder = database()->builder();

In most cases, the query will refer to a table. Therefore, [Database](database#method-table) also provides the  `table` 
method to create a builder:

    $builder = database()->table('books');

You could also define an alias for your table if you prefer it:
     
    $builder = database()->table('books', 't1');

> <i class="fa fa-lightbulb-o fa-2x" aria-hidden="true"></i>
> Note, the table method is just a shortcut for this:
>          
>     $builder = database()->builder()->from('books', 't1');
    
<a name="sql"></a>
## Select Query Language

<a name="general-usage"></a>
### General Usage

The QueryBuilder provides you with many methods to create an SQL statement. You can use the methods in any order and 
fluency. Some methods may also be called several times. 

    $sql = database()->builder()
        ->select('b.id, b.title, a.name AS author')   
        ->from('author', 'a)
        ->join('books', 'a.id = b.author_id', 'b')
        ->whereCondition('a.id = ?', [4711]);

#### Bindings

The most methods for specify a SQL clause pass binding values at the last argument.

    $users = $builder->whereCondition('role = ?', ['guest']);

Instead of using `?` to represent your parameter bindings, you may use named bindings:

    $users = $builder->whereCondition('role = :role', ['role => 'guest]);

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
> No matter how, it is highly recommended to use parameter binding because its provides protection against 
> [SQL injection](http://php.net/manual/en/security.database.sql-injection.php).

<a name="clauses"></a>
### SQL Clauses

<div class="method-list" markdown="1">

[select](#select)
[distinct](#distinct)
[from](#from)
[join](#join)
[leftJoin](#leftJoin)
[rightJoin](#rightJoin)
[where](#where)
[orWhere](#orWhere)
[whereCondition](#whereCondition)
[orWhereCondition](#orWhereCondition)
[whereSubQuery](#whereSubQuery)
[orWhereSubQuery](#orWhereSubQuery)
[whereExists](#whereExists)
[orWhereExists](#orWhereExists)
[whereNotExists](#whereNotExists)
[orWhereNotExists](#orWhereNotExists)
[whereIn](#whereIn)
[orWhereIn](#orWhereIn)
[whereNotIn](#whereNotIn)
[orWhereNotIn](#orWhereNotIn)
[whereBetween](#whereBetween)
[orWhereBetween](#orWhereBetween)
[whereNotBetween](#whereNotBetween)
[orWhereNotBetween](#orWhereNotBetween)
[whereNull](#whereNull)
[orWhereNull](#orWhereNull)
[whereNotNull](#whereNotNull)
[orWhereNotNull](#orWhereNotNull)
[groupBy](#groupBy)
[having](#having)
[orHaving](#orHaving)
[orderBy](#orderBy)
[limit](#limit)
[offset](#offset)

</div>

<a name="queries-method-listing"></a>
### Method Listing

<a name="method-select"></a>
#### `select()` {.method .first-method}

The `select` method adds columns to the query.

Multiple calls to select() will append to the list of columns, not overwrite the previous columns.

For computed columns, you should only use standard [SQL operators and functions](#sql-functions), so that the database 
drivers can translate the expression correctly.

Examples:

    // as comma-separated string list:
    $builder->select('column1, t1.column2 AS c2')
    
    // as array:
    $builder->select(['column1', 't1.column2 AS c2', 'c3' => 't1.column3'])
    
    // with calculated columns:
    $builder->select('COUNT(*) AS c1')
    $builder->select(['c1' => 'COUNT(*)'])
    
    // with subquery:
    $builder->select(['c1' => 'SELECT MAX(i) FROM table2'])
    $builder->select(['c1' => database()->createBuilder()->from('table2')->select('MAX(i)')])
    $builder->select(['c1' => function(Builder $builder2) { return $builder2->from('table2')->select('MAX(i)'); }])
    
    // with placeholders:
    $builder->select(['c1' => 'column2 * ?'], [$foo])

> <i class="fa fa-exclamation-circle fa-2x" aria-hidden="true"></i>
> Note, that subqueries are not quoted, because the Builder of the subquery should do this work.

<a name="method-distinct"></a>
#### `distinct()` {.method}

The `distinct` method makes the select DISTINCT.

    $builder->distinct();

<a name="method-from"></a>
#### `from()` {.method}

The `from` method adds a FROM clause to the query.

Multiple calls to from() will append to the list of sources, not overwrite the previous sources.

Examples:

    // from table
    $builder->from('table1')
    
    // with alias:
    $builder->from('table1', 't1')
    
    // from subquery:
    $builder->from('SELECT * FROM table1', 't1')
    $builder->from(database()->createBuilder()->from('table1'), 't1')
    $builder->from(function($builder2) { return $builder2->from('table1'); }, 't1')
    
    // from subquery with placeholders:
    $builder->from($builder2->from('table1')->whereCondition('column1 > ?'), 't1', [$foo])

> <i class="fa fa-exclamation-circle fa-2x" aria-hidden="true"></i>
> Note, that subqueries are not quoted, because the Builder of the subquery should do this work.

<a name="method-join"></a>
#### `join()` {.method}

The `join` method adds a INNER JOIN clause to the query.

You should only use standard [SQL operators and functions](#sql-functions) for the ON clause, so that the database 
drivers can translate the expression correctly.

Examples:

    // from table:
    $builder->join('table2', 'table1.id = table2.table1_id')
    
    // with alias:
    $builder->join('table2', 't1.id = t2.table1_id', 't2')
    
    // with subquery:
    $builder->join('SELECT * FROM table2', 't1.id = t2.table1_id', 't2')
    $builder->join(database()->createBuilder()->from('table2'), 't1.id = t2.table1_id', 't2')
    $builder->join(function(Builder $builder2) { return $builder2->from('table2'); }, 't1.id = t2.table1_id', 't2')
    
    // from subquery with placeholders:
    $builder->join($builder2->from('table2')->whereCondition('column1 > ?'), 't1.id = t2.table1_id', 't2', [$foo])

> <i class="fa fa-exclamation-circle fa-2x" aria-hidden="true"></i>
> Note, that subqueries are not quoted, because the Builder of the subquery should do this work.

<a name="method-leftJoin"></a>
#### `leftJoin()` {.method}

The `leftJoin` method adds a LEFT JOIN clause to the query. 

    $builder->leftJoin($source, $on, $alias, $bindings);

See the [join](#method-join) method for details and examples.

<a name="method-rightJoin"></a>
#### `rightJoin()` {.method}

The `rightJoin` method adds a RIGHT JOIN clause to the query.

    $builder->rightJoin($source, $on, $alias, $bindings);

See the [join](#method-join) method for details and examples.

<a name="method-where"></a>
#### `where()` {.method}

The `where` method adds a comparison operation into the WHERE clause.

The operator is the third argument and could be one of this: 
`'='`, `'<'`, `'>'`, `'<='`, `'>='`, `'<>'`, `'!='`, `'IN'`, `'NOT IN'`, `'LIKE'` or `'NOT LIKE'`. 
The default is `'='`.

    $builder->where('column1', 4711, '>')

<a name="method-orWhere"></a>
#### `orWhere()` {.method}

The `orWhere` method adds a comparison operation into the WHERE clause by OR.

    $builder->orWhere($column, $value, $operator);

See the [where](#method-where) method for details and examples.

<a name="method-whereCondition"></a>
#### `whereCondition()` {.method}

The `whereCondition` method adds a WHERE condition to the query.

You should only use standard [SQL operators and functions](#sql-functions), so that the database drivers can translate 
the expression correctly.

Examples:

    $builder->whereCondition('column1 = ? OR t1.column2 LIKE "%?%"', [$foo, $bar])
    $builder->whereCondition('column1 = (SELECT MAX(i) FROM table2 WHERE c1 = ?)', [$foo])
    $builder->whereCondition(function(Builder $builder2) { return $builder2->whereCondition('c1 = ?')->orWhereCondition('c2 = ?'); }, [$foo, $bar])

> <i class="fa fa-exclamation-circle fa-2x" aria-hidden="true"></i>
> Note, that subqueries are not quoted, because the Builder of the subquery should do this work.

<a name="method-orWhereCondition"></a>
#### `orWhereCondition()` {.method}

The `orWhereCondition` method adds a WHERE condition to the query by OR.

    $builder->orWhereCondition($condition, $bindings);

See the [whereCondition](#method-whereCondition) method for details and examples.

<a name="method-whereSubQuery"></a>
#### `whereSubQuery()` {.method}

The `whereSubQuery` method adds a subquery into the WHERE clause.

The operator is the third argument and could be one of this: 
`'='`, `'<'`, `'>'`, `'<='`, `'>='`, `'<>'`, `'!='`, `'IN'`, `'NOT IN'`, `'LIKE'` or `'NOT LIKE'`. 
The default is `'='`.

Examples:

    $builder->whereSubQuery('column1', 'SELECT MAX(i) FROM table2 WHERE c1 = ?', '<=', [$foo])
    $builder->whereSubQuery('column1', database()->createBuilder()->select('MAX(i)')->from('table2')->whereCondition('c1 = ?'), [$foo])
    $builder->whereSubQuery('column1', function(Builder $builder2) { return $builder2->select('MAX(i)')->from('table2')->whereCondition('c1 = ?'); }, [$foo])

> <i class="fa fa-exclamation-circle fa-2x" aria-hidden="true"></i>
> Note, that subqueries are not quoted, because the Builder of the subquery should do this work.

<a name="method-orWhereSubQuery"></a>
#### `orWhereSubQuery()` {.method}

The `orWhereSubQuery` method adds a subquery into the WHERE clause by OR.

    $builder->orWhereSubQuery($column, $query, $operator, $bindings);

See the [whereSubQuery](#method-whereSubQuery) method for details and examples.

<a name="method-whereExists"></a>
#### `whereExists()` {.method}

The `whereExists` method adds "WHERE EXISTS( SELECT... )" to the query.

Examples:

    $builder->whereSubQuery('column1', 'SELECT MAX(i) FROM table2 WHERE c1 = ?', [$foo])
    $builder->whereSubQuery('column1', database()->createBuilder()->select('MAX(i)')->from('table2')->whereCondition('c1 = ?'), [$foo])
    $builder->whereSubQuery('column1', function(Builder $builder) { return $builder->select('MAX(i)')->from('table2')->whereCondition('c1 = ?'); }, [$foo])

> <i class="fa fa-exclamation-circle fa-2x" aria-hidden="true"></i>
> Note, that subqueries are not quoted, because the Builder of the subquery should do this work.

<a name="method-orWhereExists"></a>
#### `orWhereExists()` {.method}

The `orWhereExists` method adds "WHERE EXISTS( SELECT... )" to the query by OR.

    $builder->orWhereExists($query, $bindings);

See the [whereExists](#method-whereExists) method for details and examples.

<a name="method-whereNotExists"></a>
#### `whereNotExists()` {.method}

The `whereNotExists` method add "WHERE NOT EXISTS( SELECT... )" to the query.

    $builder->whereNotExists($query, $bindings);

See the [whereExists](#method-whereExists) method for details and examples.

<a name="method-orWhereNotExists"></a>
#### `orWhereNotExists()` {.method}

The `orWhereNotExists` method adds "WHERE NOT EXISTS( SELECT... )" to the query by OR.

    $builder->orWhereNotExists($query, $bindings);

See the [whereExists](#method-whereExists) method for details and examples.

<a name="method-whereIn"></a>
#### `whereIn()` {.method}

The `whereIn` method adds "WHERE column IN (?,?,...)" to the query.

    $builder->whereIn('column1', [1, 2, 3])

<a name="method-orWhereIn"></a>
#### `orWhereIn()` {.method}

The `orWhereIn` method adds "WHERE column IN (?,?,...)" to the query by OR.

    $builder->orWhereIn($column, $values);

See the [whereIn](#method-whereIn) method for an example.

<a name="method-whereNotIn"></a>
#### `whereNotIn()` {.method}

The `whereNotIn` method adds "WHERE column NOT IN (?,?,...)" to the query.

    $builder->whereNotIn($column, array $values, $or = false);

See the [whereIn](#method-whereIn) method for an example.

<a name="method-orWhereNotIn"></a>
#### `orWhereNotIn()` {.method}

The `orWhereNotIn` method adds "WHERE column NOT IN (?,?,...)" to the query by OR.

    $builder->orWhereNotIn($column, array $values);

See the [whereIn](#method-whereIn) method for an example.

<a name="method-whereBetween"></a>
#### `whereBetween()` {.method}

The `whereBetween` method adds "WHERE column BETWEEN ? AND ?" to the query.

    $builder->whereBetween('column1', 123, 789)

<a name="method-orWhereBetween"></a>
#### `orWhereBetween()` {.method}

The `orWhereBetween` method adds "WHERE column BETWEEN ? AND ?" to the query by OR.

    $builder->orWhereBetween($column, $lowest, $highest);
    
See the [whereBetween](#method-whereBetween) method for an example.

<a name="method-whereNotBetween"></a>
#### `whereNotBetween()` {.method}

The `whereNotBetween` method adds "WHERE column NOT BETWEEN ? AND ?" to the query.

    $builder->whereNotBetween($column, $lowest, $highest);

See the [whereBetween](#method-whereBetween) method for an example.

<a name="method-orWhereNotBetween"></a>
#### `orWhereNotBetween()` {.method}

The `orWhereNotBetween` method adds "WHERE column NOT BETWEEN ? AND ?" to the query by OR.

    $builder->orWhereNotBetween($column, $lowest, $highest);

See the [whereBetween](#method-whereBetween) method for an example.

<a name="method-whereNull"></a>
#### `whereNull()` {.method}

The `whereNull` method adds "WHERE column IS NULL to the query.

    $builder->whereNull($column);

<a name="method-orWhereNull"></a>
#### `orWhereNull()` {.method}

The `orWhereNull` method adds "WHERE column IS NULL to the query by OR.

    $builder->orWhereNull($column);

<a name="method-whereNotNull"></a>
#### `whereNotNull()` {.method}

The `whereNotNull` method adds "WHERE column IS NOT NULL to the query.

    $builder->whereNotNull($column);

<a name="method-orWhereNotNull"></a>
#### `orWhereNotNull()` {.method}

The `orWhereNotNull` method adds "WHERE column IS NOT NULL to the query by OR.

    $builder->orWhereNotNull($column);

<a name="method-groupBy"></a>
#### `groupBy()` {.method}

The `groupBy` method adds GROUP BY clause to the SELECT query.

Examples:

    // as comma-separated string list:
    $builder->groupBy('column1, t2.column2')
    
    // as array:
    $builder->groupBy(['column1', 't2.column2'])

<a name="method-having"></a>
#### `having()` {.method}

The `having` method adds a HAVING condition to the SELECT query.

You should only use standard [SQL operators and functions](#sql-functions), so that the database drivers can translate 
the expression correctly.

Examples:

    $builder->having('column1 = ? OR t1.column2 LIKE "%?%"', [$foo, $bar])
    $builder->having('column1 = (SELECT MAX(i) FROM table2 WHERE c1 = ?)', [$foo])
    $builder->having(function(Builder $builder2) { return $builder2->having('c1 = ?')->orHaving('c2 = ?'); }, [$foo, $bar])

> <i class="fa fa-exclamation-circle fa-2x" aria-hidden="true"></i>
> Note, that subqueries are not quoted, because the Builder of the subquery should do this work.

<a name="method-orHaving"></a>
#### `orHaving()` {.method}

The `orHaving` method adds a HAVING condition to the SELECT query by OR.

    $builder->orHaving($condition, $bindings);

See the [having](#method-having) method for details and examples.

<a name="method-orderBy"></a>
#### `orderBy()` {.method}

The `orderBy` method adds a ORDER BY clause to the SELECT query.

Examples:

    // as comma-separated string list:
    $builder->orderBy('column1, column2 ASC, t1.column3 DESC')
    
    // as array:
    $builder->orderBy(['column1', 'column2 ASC', 't1.column3 DESC'])

<a name="method-limit"></a>
#### `limit()` {.method}

The `limit` method sets a limit count for the result set of the SELECT query.

    $builder->limit($limit);

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
> Note, that LIMIT does not see the query, it is just see the result set. Therefore, LIMIT has no effect on the 
> calculation of aggregate functions such like MIN or MAX.

<a name="method-offset"></a>
#### `offset()` {.method}

The `offset` method sets a limit offset for the result set of the SELECT query.

    $builder->offset($offset);

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
> Note, that OFFSET does not see the query, it is just see the result set. Therefore, OFFSET has no effect on the 
> calculation of aggregate functions such like MIN or MAX.
  
<a name="execute"></a>
### Execute Query

<div class="method-list" markdown="1">

[dump](#method-dump)
[find](#method-find)
[all](#method-all)
[cursor](#method-cursor)
[first](#method-first)
[value](#method-value)

</div>

<a name="queries-method-listing"></a>
### Method Listing

<a name="method-dump"></a>
#### `dump()` {.method .first-method}

The `dump` method binds the given values to the query and print the SQL statement out without executing.

    $builder->dump();
    
If the argument is used and set to true, `dump()` will return the variable representation instead of outputing it:

    $sql = $builder->dump(true);

<a name="method-find"></a>
#### `find()` {.method}

The `find` method find a single record by the primary key of the table.

    $result = $builder->find($id);
    
You could enter the name of the primary key as second argument (the default is 'id'):     

    $result = $builder->find($id, $key = 'id');

<a name="method-all"></a>
#### `all()` {.method}

The `all` method executes the query as a "select" statement and returns the result as a [`Collection`](collections).

    $result = $builder->all();

<a name="method-cursor"></a>
#### `cursor()` {.method}

> <i class="fa fa-lightbulb-o fa-2x" aria-hidden="true"></i>
> This method is useful to handle big data.

The `cursor` method executes the query as a "SELECT" statement and returns a [generator](http://php.net/manual/de/language.generators.syntax.php).

With the cursor you could iterate the rows (via foreach) without fetch all the data at one time.

    foreach ($builder->cursor() as $row) {
        // ...
    };

Note, this method ignores the "with" clause, because the data could not be [eager load](models#eager).

<a name="method-first"></a>
#### `first()` {.method}

The `first` method executes the query as a "SELECT" statement and return the first record.

    $result = $builder->first();

<a name="method-value"></a>
#### `value()` {.method}

The `value` method execute the query as a "SELECT" statement and return a single column's value from the first record.

    $value = $builder->value();

Note, this method ignores the "with" clause, because the data could not be [eager load](models#eager).

    
<a name="aggregates"></a>
### Aggregates Functions

<div class="method-list" markdown="1">

[count](#method-count)
[avg](#method-avg)
[sum](#method-max)
[sum](#method-min)
[sum](#method-sum)

</div>

<a name="queries-method-listing"></a>
### Method Listing

<a name="method-count"></a>
#### `count()` {.method}

The `count` method calculates the number of records.

    $count = $builder->count();

<a name="method-avg"></a>
#### `avg()` {.method .first-method}

The `avg` method calculates the average value of a given column.

    $avg = $builder->select('price')->avg();
    
    $avg = $builder->avg('price');

<a name="method-max"></a>
#### `max()` {.method}

The `max` method calculates the maximum value of a given column.

    $max = $builder->select('price')->max();
    
    $max = $builder->max('price');

<a name="method-min"></a>
#### `min()` {.method}

The `min` method calculates the minimum value of a given column.

    $min = $builder->select('price')->min();

    $min = $builder->min('price');

<a name="method-sum"></a>
#### `sum()` {.method}

The `sum` method calculates the total value of a given column.

    $sum = $builder->select('price')->sum();

    $sum = $builder->sum('price');
  
  
<a name="sql-functions"></a>
### SQL Operators and Functions

TODO
    
@see https://www.w3schools.com/sql/sql_operators.asp Standard SQL Operators
@see https://www.w3schools.com/sql/sql_functions.asp Standard SQL Aggregate Functions
@see https://www.w3schools.com/sql/sql_isnull.asp Standard SQL NULL Functions
    
    
<a name="dml"></a>
## Data Manipulation Language

<div class="method-list" markdown="1">

[insert](#method-insert)
[update](#method-update)
[delete](#method-delete)

</div>

<a name="queries-method-listing"></a>
### Method Listing

<a name="method-insert"></a>
#### `insert()` {.method .first-method}

The `insert` method inserts one or more records to the table and returns the inserted autoincrement sequence value.

    $id = database()
        ->table('users')
        ->insert['firstname' => 'Stephen', 'lastname' => 'Hawking']);

Bulk Mode:

    database()->table('users')->insert[
        ['firstname' => 'Stephen', 'lastname' => 'Hawking']
        ['firstname' => 'Albert', 'lastname' => 'Einstein'],
    ]);
    
> <i class="fa fa-exclamation-circle fa-2x" aria-hidden="true"></i>
> If you insert multiple rows, the method returns dependency of the driver the first or last inserted id!

The method returns FALSE if the operation was canceled by a [hook](models#hooks). You may disable this behavior via 
the [disableHooks](#method-disableHooks) method.

<a name="method-update"></a>
#### `update()` {.method}

The `update` method updates all records of the query result with the given data and returns the number of affected rows.

    database()
        ->table('users')
        ->whereCondition('role = ?', ['guest'])
        ->update(['lastname' => 'Hawking']);
    
The method returns FALSE, if the operation was canceled by a [hook](models#hooks). You may disable this behavior via 
the [disableHooks](#method-disableHooks) method.

<a name="method-delete"></a>
#### `delete()` {.method}

The `delete` method deletes all records of the query result and returns the number of affected rows.

    database()
        ->table('users')
        ->whereCondition('id = ?', [4711])
        ->delete();

The method returns FALSE, if the operation was canceled by a [hook](models#hooks). You may disable this behavior via 
the [disableHooks](#method-disableHooks) method.
        
<a name="misc"></a>
## Miscellanea Functions

<div class="method-list" markdown="1">

[asClass](#method-asClass)
[bindings](#method-bindings)
[copy](#method-copy)
[disableHooks](#method-disableHooks)
[enableHooks](#method-enableHooks)
[getClass](#method-getClass)
[getTable](#method-getTable)
[reset](#method-reset)
[toSql](#method-toSql)
[with](#method-with)

</div>

<a name="queries-method-listing"></a>
### Method Listing

<a name="method-asClass"></a>
#### `asClass()` {.method .first-method}

The `asClass` method sets the name of the class where the data are mapped to.

If null is passed, the data will be returned as an array (the default).

    $builder->asClass($class);
    
If the class implements the `Hookable` contract, the QueryBuilder bind the [hooks](models#hooks) that are provided by 
this class. You may disable this behavior via the [disableHooks](#method-disableHooks) method.
    
See also [getClass](#method-getClass) method.  

<a name="method-bindings"></a>
#### `bindings()` {.method}

The `bindings` method get the bindings of the query.

    $bindings = $builder->bindings();

<a name="method-copy"></a>
#### `copy()` {.method}

The `copy` method gets a copy of the instance.

    $builder = $builder->copy();

<a name="method-disableHooks"></a>
#### `disableHooks()` {.method}

The `disableHooks` method disables hooks. You may use this method if you have a class with hooks, but the hooks should 
be ignored.

    $sql = $builder->disableHooks();

See also the [enableHooks](#method-enableHooks), [asClass](#method-asClass) and [hooks](models#hooks) methods.

<a name="method-enableHooks"></a>
#### `enableHooks()` {.method}

The `enableHooks` method enables hooks. The hooks of the class you specified using method `asClass` will be invoke, 
presupposed that the class implements the `Hookable` contract.

    $sql = $builder->enableHooks();

Note, that hooks are enabled by default.

See also the [disableHooks](#method-disableHooks), [asClass](#method-asClass) and [hooks](models#hooks) methods.

<a name="method-getClass"></a>
#### `getClass()` {.method}

The `getClass` method gets the Class.

    $lcass = $builder->getClass();

See also [asClass](#method-asClass) method.  

<a name="method-getTable"></a>
#### `getTable()` {.method}

The `getTable` method gets the name of the table if specify.

    $builder->getTable();

<a name="method-reset"></a>
#### `reset()` {.method}

The `reset` method resets the query.

    $builder->reset();

<a name="method-toSql"></a>
#### `toSql()` {.method}

The `toSql` method get the SQL representation of the query.

    $sql = $builder->toSql();

<a name="method-with"></a>
#### `with()` {.method}

The `with` method gets the entities of given relationship via [eager load](models#eager).

    $builder
        ->asClass('App\Models\Author')
        ->with('books');

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
> Note, the class, that provides the given relationship, must be specified by the [asClass](#method-asClass) method.
          
See the [Model](models#relationships) class to learn how you could define the relationship method.         
      
   