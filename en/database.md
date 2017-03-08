# Database Access Layer

[Since 1.0.0]

TODO: Anpassen

- [Introduction](#introduction)
    - [Configuration](#configuration)
        - [MySQL](#mysql)
        - [Postgres](#postgres)
        - [SQLite](#sqlite)
        - [SQL Server](#sqlserver)
- [Connection](#connection)
- [Select Query](#select-query)
    - [query](#query)
    - [single](#single)
    - [scalar](#scalar)
    - [cursor](#cursor)
- [Data Manipulation](#data-manipulation)
    - [exec](#exec)
    - [insert](#insert)
    - [update](#update)
    - [delete](#delete)
    - [truncate](#truncate)
- [Transactions](#transactions)

<a name="introduction"></a>
## Introduction

Pletfix's Database Access Layer takes care of the connection setup and abstracts access to the database engine.
Furthermore, field types are abstracted over all supported database providers to translation to PHP data-types.

Currently, Pletfix provides a Database Access Layer for the the following database systems: 

- MySQL
- Postgres
- SQLite
- SQL Server


<a name="configuration"></a>
### Configuration

The database configuration is located at `config/database.php`. 
As you can see, the most entries are environment variables. 

<a name="mysql"></a>
#### MySQL

The required connection parameters for a MySQL database are:

    DB_STORE=mysql    
    DB_MYSQL_HOST=localhost
    DB_MYSQL_DATABASE=mydatabase
    DB_MYSQL_USERNAME=myusername
    DB_MYSQL_PASSWORD=mypassword

<a name="postgres"></a>
#### Postgres

Postgres requires the same information:

    DB_STORE=pgsql
    DB_PGSQL_HOST=localhost
    DB_PGSQL_DATABASE=mydatabase
    DB_PGSQL_USERNAME=myusername
    DB_PGSQL_PASSWORD=mypassword

<a name="sqlite"></a>
#### SQLite

Set the environment variables for SQLite like this:

    DB_STORE=sqlite
    DB_SQLITE_DATABASE=db/sqlite.db

The path for the database file is relative to the storage folder.

> You may enter this command into a terminal to create a new SQLite database:
>  
>     touch storage/db/sqlite.db
  
<a name="sqlserver"></a>
#### SQL Server

Microsoft SQL Server also requires the typical connection parameters:

    DB_STORE=sqlsrv
    DB_SQLSRV_HOST=127.0.0.1
    DB_SQLSRV_DATABASE=mydatabase
    DB_SQLSRV_USERNAME=sa
    DB_SQLSRV_PASSWORD=xxxx   


<a name="using-multiple-database-connections"></a>
## Connection

You may access each connection via the `database` function:
 
    $db = database('foo');

The argument of `database` method should correspond to one of the connections listed in your `config/database.php` 
configuration file. If you call the function without an argument, the default connection specified in the configuration 
file is established.

    $db = database();

The `database` function returns a `Database` instance so you select could queries or manipulate the data.  


<a name="select-query"></a>
## Select Query

<a name="method-query"></a>
#### `query()`

You may run queries using the `query` method:

    $users = database()->query('SELECT * FROM users WHERE role = ?', ['guest']);
    
The first argument passed to the select method is the raw SQL query, while the second argument is any parameter 
bindings that need to be bound to the query. Parameter binding provides protection against SQL injection.

Instead of using `?` to represent your parameter bindings, you may execute a query using named bindings:

    $users = database()->query('SELECT * FROM users WHERE role = :role', ['role => 'guest]);

The `query` method will always return an `array` of records. 

If you net set a third argument for the `query` function, each record within the array will be an associative array:

    foreach ($users as $user) {
        echo $user['id'] . ':' . $user['role'] . '<br/>';    
    }

If you net set a class name of a Model as the third argument, each record will be an instance of this class.

    $users = database()->query('SELECT * FROM users WHERE id = ?', [4711], User::class);
    foreach ($users as $user) {
        echo $user->id . ':' . $user->role . '<br/>';    
    }

<a name="method-singe"></a>
#### `single()`

Sometimes it's only possible to receive a single record. In this case it is more comfortable to use the `single` 
function unsteady the query function:  

    $user = database()->single('SELECT * FROM users WHERE id = ?', [4711], User::class);
    if ($user !== null) {
        echo $user->id . ':' . $user->role . '<br/>';
    }
    
<a name="method-scalar"></a>
#### `scalar()`

The `scalar` method fetches the first value (means the first column of the first record).

    $count = database()->single('SELECT COUNT(*) FROM users WHERE role = :role', ['role => 'guest]);

<a name="method-cursor"></a>
#### `cursor()`

The `cursor` method runs a select statement against the database and returns a 
[generator](http://php.net/manual/de/language.generators.syntax.php). 
With the cursor you could iterate the rows (via foreach) without fetch all the data at one time.
This method is useful to handle big data.

    foreach (database()->cursor('SELECT * FROM users WHERE role = ?', ['guest'], User::class) as $row) {
        echo $user->id . ':' . $user->role . '<br/>';
    };


<a name="data-manipulation"></a>
## Data Manipulation

<a name="method-exec"></a>
#### `exec()`

If you want to manipulate data, you could use the `exec` method.
`exec` is faster as `query` because no record will be fetched to an array.

    database()->exec('INSERT INTO users (firstname, lastname) VALUES (?, ?)', ['Stephen', 'Hawking']);

But Pletfix provides the following functions, which are more convenient than `exec`:

<a name="method-insert"></a>
#### `insert()`

The `insert` method insert a record to the given table:

    $affected = database()->insert('users', ['firstname' => 'Stephen', 'lastname' => 'Hawking']);

Bulk inserting is possible too, `insert()` returns the number of affected rows:

    $affected = database()->insert('users', [
        ['firstname' => 'Stephen', 'lastname' => 'Hawking']
        ['firstname' => 'Albert', 'lastname' => 'Einstein'],
    ]);

The `lastInsertId` function returns the last inserted autoincrement sequence value:
 
    $userId = database()->lastInsertId 

<a name="method-update"></a>
#### `update()`
    
The `update` function updates a table with th given data and returns the number of affected rows.

    $affected = database()->update('users', ['lastname' => 'Hawking'], 'role=?', ['guest']);

<a name="method-delete"></a>
#### `delete()`
    
The `delete` function deletes records rom a table and returns the number of affected rows:

    $affected = database()->delete('users', 'role=?', ['guest']);

<a name="method-truncate"></a>
#### `truncate()`
    
The `truncate` removes all records from a table:

    truncate('users);


<a name="Transactions"></a>
## Transactions

The `beginTransaction` method starts a database transaction, the `commit` function finished this one and the `rollback`
function will roll back the transaction.

    $db->beginTransaction();
    try {
        $db->insert('users', ['firstname' => 'Stephen', 'lastname' => 'Hawking']);
        $db->insert('users', ['firstname' => 'Albert',  'lastname' => 'Einstein']);
        $db->commit();

    } catch (\Exception $e) {
        $db->rollBack();
    }

The `supportsSavepoints` method determines if the database driver can marks the current point within a transaction.
If it's like that, transactions can also be nested. The `transactionLevel` method is then helpful to determine the 
number of active transactions:

    $db->beginTransaction();
    echo $db->transactionLevel(); // 1
    $db->insert('users', ['firstname' => 'Stephen', 'lastname' => 'Hawking']);
    $db->insert('users', ['firstname' => 'Albert',  'lastname' => 'Einstein']);
    
    $db->beginTransaction();
    echo $db->transactionLevel(); // 2
    $db->insert('users', ['firstname' => 'Carl', 'lastname' => 'Friedrich Gauß']);
    $db->insert('users', ['firstname' => 'Pierre-Simon', 'lastname' => 'Laplace']);
    $db->rollBack();

    $db->commit();

    $rows = $db->query('SELECT * FROM users');
    if ($db->supportsSavepoints()) {
        if (count($rows) != 2) {
            dd('Test failed!');
        }
    }
    else {
        if (count($rows) != 4) {
            dd('Test failed!');
        }
    }
    
#### Closures
    
Pletfix also offers the `transaction` method which executes a Closure within a transaction:

    $db->transaction(function(Database $db) {
        $db->insert('users', ['firstname' => 'Stephen', 'lastname' => 'Hawking']);
        $db->insert('users', ['firstname' => 'Albert',  'lastname' => 'Einstein']);
    });

If an exception is thrown within the transaction Closure, the transaction will automatically be rolled back. 
And of course, if the Closure executes successfully, the transaction will automatically be committed. 

