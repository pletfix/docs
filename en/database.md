# Database Access Layer

[Since 0.5.0]

- [Introduction](#introduction)
- [Configuration](#configuration)
- [Connections](#connections)
- [Data Queries](#queries)
- [Transactions](#transactions)
- [Schema](#schema)
- [Table](#table)
- [Miscellanea Functions](#misc)


<a name="introduction"></a>
## Introduction

Pletfix's Database Access Layer takes care of the connection setup and abstracts access to the database engine.
Furthermore, field types are abstracted over all supported database providers to translation to PHP data-types.

Pletfix has studied these libraries, picked up ideas from them, and partly adopted codes:
- [Aura.Sql Extended PDO](https://github.com/auraphp/Aura.Sql/blob/3.x/src/AbstractExtendedPdo.php) ([MIT License](https://github.com/auraphp/Aura.Sql/blob/3.x/LICENSE)),
- [Aura.Sql Column Factory](https://github.com/auraphp/Aura.SqlSchema/blob/2.x/src/ColumnFactory.php) ([BSD 2-clause "Simplified" License](https://github.com/auraphp/Aura.SqlSchema/blob/2.x/LICENSE)),
- [Dontrine's Mapping Matrix](http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/types.html#mapping-matrix) ([MIT License](https://github.com/doctrine/dbal/blob/2.5/LICENSE)),
- [Doctrine's Schema Manager](https://github.com/doctrine/dbal/blob/2.5/lib/Doctrine/DBAL/Schema/AbstractSchemaManager.php) ([MIT License](https://github.com/doctrine/dbal/blob/2.5/LICENSE)) and
- [Laravel's Connection Class](https://github.com/illuminate/database/blob/5.3/Connection.php) ([MIT License](https://github.com/laravel/laravel/tree/5.3)).

Currently, Pletfix provides a Database Access Layer for the the following database driver: 

- MySQL
- Postgres
- SQLite
- SQL Server

<a name="configuration"></a>
## Configuration

The database configuration is located at `config/database.php`. 
As you can see, the most entries are environment variables. 

<div class="method-list" markdown="1">

### Available Database Drivers

[MySQL](#mysql)
[Postgres](#postgres)
[SQLite](#sqlite)
[SQL Server](#sqlserver)

</div>

<a name="mysql"></a>
#### MySQL {.method .first-method}

The required connection parameters for a MySQL database are:

    DB_STORE=mysql    
    DB_MYSQL_HOST=localhost
    DB_MYSQL_DATABASE=mydatabase
    DB_MYSQL_USERNAME=myusername
    DB_MYSQL_PASSWORD=mypassword

<a name="postgres"></a>
#### Postgres {.method}

Postgres requires the same information:

    DB_STORE=pgsql
    DB_PGSQL_HOST=localhost
    DB_PGSQL_DATABASE=mydatabase
    DB_PGSQL_USERNAME=myusername
    DB_PGSQL_PASSWORD=mypassword

<a name="sqlite"></a>
#### SQLite {.method}

Set the environment variables for SQLite like this:

    DB_STORE=sqlite
    DB_SQLITE_DATABASE=db/sqlite.db

The path for the database file is relative to the storage folder.

> You may enter this command into a terminal to create a new SQLite database:
>  
>     touch storage/db/sqlite.db
  
<a name="sqlserver"></a>
#### SQL Server {.method}

Microsoft SQL Server also requires the typical connection parameters:

    DB_STORE=sqlsrv
    DB_SQLSRV_HOST=127.0.0.1
    DB_SQLSRV_DATABASE=mydatabase
    DB_SQLSRV_USERNAME=sa
    DB_SQLSRV_PASSWORD=xxxx   


<a name="connections"></a>
## Connections

You may use the `database()` function to connect the default database store:

    $db = database();
    
You can set the store name if you use an another store as the default. The store name should correspond to one of the 
stores listed in the `stores` configuration array in your `database` configuration file:
    
    $db = database('my-database-store');

The `database` function returns a Database instance so you select could queries or manipulate the data.  

> The `database` function is just a shortcut to get a extended `AbstractDatabase` instance via the `DatabaseFactory` 
> supported by [Dependency Injector](di): 
>    
>       $builder = DI::getInstance()->get('database-factory')->store($store);

<a name="queries"></a>
## Data Queries

### Available Methods

<div class="method-list" markdown="1">

[query](#method-query)
[single](#method-single)
[scalar](#method-scalar)
[cursor](#method-cursor)
[exec](#method-exec)

</div>

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
> Note! Because this methods expect pure SQL as the first argument, but the SQL syntax in detail varies depending 
> on the database system, you should not call these methods directly and instead better use the [QueryBuilder](builder)!

<a name="method-query"></a>
#### `query()` {.method .first-method}

You may run queries using the `query` method:

    $users = database()->query('SELECT * FROM users WHERE role = ?', ['guest']);
    
The first argument passed to this method is raw SQL query. 
The second argument is any parameter bindings that need to be bound to the query. 

Instead of using `?` to represent your parameter bindings, you may execute a query using named bindings:

    $users = database()->query('SELECT * FROM users WHERE role = :role', ['role => 'guest]);

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
> No matter how, it is highly recommended to use parameter binding because its provides protection against 
> [SQL injection](http://php.net/manual/en/security.database.sql-injection.php).

The `query` method will always return an `array` of records. If you not set a third argument for the `query` function, 
each record within the array will be an associative array:

    foreach ($users as $user) {
        echo $user['id'] . ':' . $user['role'] . '<br/>';    
    }

If you set a class name as the third argument, each record will be an instance of this class:

    $users = database()->query('SELECT * FROM users WHERE id = ?', [4711], User::class);
    foreach ($users as $user) {
        echo $user->id . ':' . $user->role . '<br/>';    
    }

If you use a class, the query will be assigned to the corresponding class properties according to the following rules:
1. If there is a class property, which name is the same as a column name, the column value will be assigned to this property.<br/>
   Note, that the property could be private! Which is a bit unexpected but extremely useful.
2. If there is no such property, then a magic `__set()` method will be called.
3. If `__set()` method is not defined for the class, then a public property will be created and a column value assigned to it.<br/>
   You could create an empty `__set()` method if you like to avoid the automated property creation.

<a name="method-single"></a>
#### `single()` {.method}

Sometimes it's only possible to receive a single record. In this case it is more comfortable to use the `single` 
function unsteady the query function:  

    $user = database()->single('SELECT * FROM users WHERE id = ?', [4711], User::class);
    if ($user !== null) {
        echo $user->id . ':' . $user->role . '<br/>';
    }
    
<a name="method-scalar"></a>
#### `scalar()` {.method}

The `scalar` method fetches the first value (means the first column of the first record).

    $count = database()->scalar('SELECT COUNT(*) FROM users WHERE role = :role', ['role => 'guest]);

<a name="method-cursor"></a>
#### `cursor()` {.method}

The `cursor` method runs a select statement against the database and returns a 
[generator](http://php.net/manual/de/language.generators.syntax.php). 
With the cursor you could iterate the rows (via foreach) without fetch all the data at one time.
This method is useful to handle big data.

    foreach (database()->cursor('SELECT * FROM users WHERE role = ?', ['guest'], User::class) as $row) {
        echo $user->id . ':' . $user->role . '<br/>';
    };

<a name="method-exec"></a>
#### `exec()` {.method .first-method}

If you want to manipulate data, you could use the `exec` method, which is faster as `query` because no record have to 
be fetched to an array.

    database()->exec('INSERT INTO users (firstname, lastname) VALUES (?, ?)', ['Stephen', 'Hawking']);

<a name="Transactions"></a>
## Transactions

The `beginTransaction` method starts a database transaction, the `commit` function finished this one and the `rollback`
function will roll back the transaction.

    $db = database();
    $db->beginTransaction();
    try {
        $db->insert('users', ['firstname' => 'Stephen', 'lastname' => 'Hawking']);
        $db->insert('users', ['firstname' => 'Albert',  'lastname' => 'Einstein']);
        $db->commit();

    } catch (\Exception $e) {
        $db->rollback();
    }

The `supportsSavepoints` method determines if the database driver can marks the current point within a transaction.
If it's like that, transactions can also be nested. The `transactionLevel` method is then helpful to determine the 
number of active transactions:

    $db->beginTransaction();
    echo $db->transactionLevel(); // 1
    ...    
    $db->beginTransaction();
    echo $db->transactionLevel(); // 2
    ...
    $db->rollback();
    echo $db->transactionLevel(); // 1
    ...
    $db->commit();
    echo $db->transactionLevel(); // 0

    
#### Closures
    
Pletfix also offers the `transaction` method which executes a closure function within a transaction:

    database()->transaction(function(Database $db) {
        $db->insert('users', ['firstname' => 'Stephen', 'lastname' => 'Hawking']);
        $db->insert('users', ['firstname' => 'Albert',  'lastname' => 'Einstein']);
    });

If an exception is thrown within the transaction closure, the transaction will automatically be rolled back. 
And of course, if the closure executes successfully, the transaction will automatically be committed. 

<a name="schema"></a>
## Schema

The `schema` function returns an instance of `Schema` that allows you to change the structure of the database.

    $schema = database()->schema();
    
The schema functions are mainly used in [migration files](migrations).
    
<a name="type-mapping"></a>
### Field Type Mapping
    
The following table shows an overview of the Pletfix's type abstraction for the database schema and migrations files. 
The matrix contains the mapping information for how a specific abstract type is mapped to the database and back to PHP.
The Table based on [Doctrine's Mapping Matrix](http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/types.html#mapping-matrix).
    
| Abstract    | PHP      | MySql                                            | PostgreSQL                     | SQL Server                                | SQLite                                     |
|-------------|----------|--------------------------------------------------|--------------------------------|-------------------------------------------|--------------------------------------------|
| identity    | integer  | INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT | SERIAL                         | INT NOT NULL IDENTITY(1,1) PRIMARY KEY    | INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL | 
| bigidentity | integer  | BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT       | BIGSERIAL                      | BIGINT NOT NULL IDENTITY(1,1) PRIMARY KEY | INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL | 
| smallint    | integer  | SMALLINT                                         | SMALLINT                       | SMALLINT                                  | SMALLINT                                   | 
| integer     | integer  | INT                                              | INTEGER                        | INT                                       | INT                                        | 
| unsigned    | integer  | INT UNSIGNED                                     | INTEGER                        | INT                                       | INT UNSIGNED                               | 
| bigint      | string   | BIGINT                                           | BIGINT                         | BIGINT                                    | BIGINT                                     | 
| numeric     | string   | DECIMAL(p, s)                                    | NUMERIC(p, s)                  | NUMERIC(p, s)                             | NUMERIC(p, s)                              |
| float       | float    | DOUBLE                                           | DOUBLE PRECISION               | FLOAT                                     | DOUBLE                                     | 
| string      | string   | VARCHAR(n)                                       | VARCHAR(n)                     | NVARCHAR(n), NCHAR(n)                     | VARCHAR(n)                                 |
| text        | string   | TINYTEXT, TEXT, MEDIUMTEXT, LONGTEXT             | TEXT                           | TEXT, VARCHAR(MAX)                        | TEXT                                       |
| guid        | string   | VARCHAR(36)                                      | UUID                           | UNIQUEIDENTIFIER                          | UUID                                       |
| binary      | resource | VARBINARY(n)                                     | BYTEA                          | VARBINARY(n), BINARY(n)                   | VARBINARY(n)                               |
| blob        | resource | TINYBLOB, BLOB, MEDIUMBLOB, LONGBLOB             | BYTEA                          | IMAGEVARBINARY(MAX)                       | BLOB                                       |
| boolean     | boolean  | TINYINT(1)                                       | BOOLEAN                        | BIT                                       | BOOLEAN                                    | 
| date        | DateTime | DATE                                             | DATE                           | DATE (#1)                                 | DATE                                       |
| datetime    | DateTime | DATETIME                                         | TIMESTAMP(0) WITHOUT TIME ZONE | DATETIME                                  | DATETIME                                   | 
| timestamp   | DateTime | TIMESTAMP (#2)                                   | TIMESTAMP(0) WITH TIME ZONE    | DATETIMEOFFSET(6) (#1)                    | TIMESTAMP                                  |
| time        | DateTime | TIME                                             | TIME(0) WITHOUT TIME ZONE      | TIME(0) (#1)                              | TIME                                       |
| array       | array    | TINYTEXT, TEXT, MEDIUMTEXT, LONGTEXT             | TEXT                           | TEXT, VARCHAR(MAX)                        | TEXT                                       |
| json        | array    | JSON (#3)                                        | JSONB  (#4)                    | TEXT, VARCHAR(MAX)                        | TEXT                                       |
| object      | object   | TINYTEXT, TEXT, MEDIUMTEXT, LONGTEXT             | TEXT                           | TEXT, VARCHAR(MAX)                        | TEXT                                       |

- (#1) Before SQL Server 2008: DATETIME 
- (#2) Extra: ON UPDATE CURRENT_TIMESTAMP; Default: CURRENT_TIMESTAMP
- (#3) Before MySql 5.7.8: TINYTEXT, TEXT, MEDIUMTEXT, LONGTEXT 
- (#4) Before PostgreSQL 9.2: TEXT; before PostgreSQL 9.4: JSON 
  
  
<a name="schema-methods"></a>
### Available Methods

<div class="method-list" markdown="1">

[tables](#method-tables)
[columns](#method-columns)
[indexes](#method-indexes)
[createTable](#method-create-table)
[dropTable](#method-drop-table)
[renameTable](#method-rename-table)
[truncateTable](#truncate-table)
[addColumn](#method-add-column)
[dropColumn](#method-drop-column)
[renameColumn](#method-rename-column)
[addIndex](#method-add-index)
[dropIndex](#method-drop-index)
[zero](#method-zero)

</div>

<a name="schema-method-listing"></a>
### Method Listing

<a name="method-tables"></a>
#### `tables()` {.method .first-method}

The `tables` method returns an associative array of tables in the database.

    $tables = database()->schema()->tables();

The key of the returned array is the table name and the value lists following table attributes:

Each return item is a array with the following values:
- name:      (string) The table name
- collation: (string) The default collation of the table.
- comment:   (string) A hidden comment.

<a name="method-columns"></a>
#### `columns()` {.method}

The `columns` method returns an associative array of information about the columns of the table. 

    $columns = database()->schema()->columns('books');

The key of the returned array is the column name and the value lists following column attributes:

- name:      (string) The column name.
- type:      (string) The column data type.
- size:      (int)    The column size (the maximum number of digits).
- scale:     (int)    The number of digits to the right of the numeric point. It must be no larger than size.
- nullable:  (bool)   Is the column not marked as NOT NULL?
- default:   (mixed)  The default value for the column.
- collation: (string) The collation of the column.
- comment:   (string) A hidden comment.

The column type is mapped to an abstract type, see also [Field Type Mapping](#type-mapping). 

<a name="method-indexes"></a>
#### `indexes()` {.method}

The `indexes` method returns an associative array of indexes in the table:

    $indexes = database()->schema()->indexes('books');

The key of the returned array is the index name and the value lists following index attributes:

- name:      (string) The index name.
- columns:   (array)  The list of column names.
- unique:    (bool)   Is the index a unique index?
- primary:   (bool)   Is the index the primary key?

<a name="method-createTable"></a>
#### `create-table()` {.method}

The `createTable` method creates a new table on the schema:

    database()->schema()->createTable('books', [
        'id'        => ['type' => 'identity'],
        'title'     => ['type' => 'string'],
        'author_id' => ['type' => 'integer'],
    ], $options);
    
Argument $columns is an associative array where the key is the column name and the value is the column attributes.
A column attribute is a array with the following values:
- type:      (string) The column data type. It should be given as an abstract type, see also [Field Type Mapping](#type-mapping). 
- size:      (int)    The column size (the maximum number of digits).
- scale:     (int)    The number of digits to the right of the numeric point. It must be no larger than size.
- nullable:  (bool)   Is the column is not marked as NOT NULL.
- default:   (mixed)  The default value for the column.
- collation: (string) The collation of the column.
- comment:   (string) A hidden comment.

The third argument $options is optional and could have following values:
- temporary: (bool)   The table is temporary.  todo kann raus!
- collation: (string) The default collation of the table.
- comment:   (string) A hidden comment.

<a name="method-drop-table"></a>
#### `dropTable()` {.method}

The `dropTable` method drops a table from the schema:

    database()->schema()->dropTable('books');

<a name="method-rename-table"></a>
#### `renameTable()` {.method}

The `renameTable` method set a new name for a given table on the schema:

    database()->schema()->renameTable($from, $to);

<a name="method-truncate-table"></a>
#### `truncateTable()` {.method}

The `truncateTable` method truncates the table.

    database()->schema()->truncateTable('books');
        
<a name="method-add-column"></a>
#### `addColumn()` {.method}

The `addColumn` method adds a new column to the table. The example below adds a new column "genre_id" to the table "books":

    database()->schema()->addColumn('books', 'genre_id', $options);

Argument $options is an array and have following values:
- type:      (string) The column data type. It should be given as an abstract type, see also [Field Type Mapping](#type-mapping). 
- size:      (int)    The column size (the maximum number of digits).
- scale:     (int)    The number of digits to the right of the numeric point. It must be no larger than size.
- nullable:  (bool)   Is the column is not marked as NOT NULL.
- default:   (mixed)  The default value for the column.
- collation: (string) The collation of the column.
- comment:   (string) A hidden comment.

<a name="method-drop-column"></a>
#### `dropColumn()` {.method}

The `dropColumn` method deletes a column from the table:

    database()->schema()->dropColumn('books', 'genre_id');

<a name="method-rename-column"></a>
#### `renameColumn()` {.method}

The `renameColumn` method set a new name for a given column. The example below change in the table "books" the name of 
the column "caption" to "title":

    database()->schema()->renameColumn('books', 'caption', 'title');

<a name="method-add-index"></a>
#### `addIndex()` {.method}

The `addIndex` method creates an index for a given table, e.g. for table "books":

    database()->schema()->addIndex('books', null, [
        'columns' => ['title', 'author_id'], 'unique'  => true
    ]);

The second argument is the name of the index. It will be generated automatically if not set and will be ignored by a 
primary key.

The third argument is an array to specify the columns and other options for the index:
- columns    (string[])  List of column names.
- unique:    (bool)      The index is a unique index.
- primary:   (bool)      The index is the primary key.

<a name="method-drop-index"></a>
#### `dropIndex()` {.method}

The `dropIndex` method deletes a index from the table by given index name or options:

    database()->schema()->dropIndex('books', null, [
        'columns' => ['title', 'author_id'], 'unique'  => true
    ]);

The second argument is the name of the index. It will be generated automatically if not set.

The third argument is an array with index options and is only needed if the index name is not set: 
- columns    (string[])  List of column names. Could be null if the index name is given or it's the primary index.
- unique:    (bool)      The index is a unique index. It's needed to generate the name.
- primary:   (bool)      The index is the primary key.

<a name="method-zero"></a>
#### `zero()` {.method}

The `zero` method gets a Zero-Value by given column type.

    database()->schema()->zero('string');

The type should be given as an abstract type, see also [Field Type Mapping](#type-mapping).


<a name="misc"></a>
## Miscellanea Functions

<div class="method-list" markdown="1">

[builder](#method-builder)
[config](#method-config)
[connect](#method-connect)
[dump](#method-dump)
[disconnect](#method-disconnect)
[lastInsertId](#method-last-insert-id)
[quote](#method-quote)
[quoteName](#method-quote-name)
[reconnect](#method-reconnect)
[table](#method-table)
[version](#method-version)

<!--
[errorCode](#method-error-code)
[errorInfo](#method-error-info)
-->

</div>

<a name="misc-method-listing"></a>
### Method Listing

<a name="method-builder"></a>
#### `builder()` {.method .first-method}

The `builder` method creates a new [QueryBuilder](builder) instance:

    $builder = database()->builder();
    
<a name="method-config"></a>
#### `config()` {.method}

The `config` method gets the database configuration.

    $driver = database()->config('driver');    
    
<a name="method-connect"></a>
#### `connect()` {.method}

The `connect` method connects to the database.

    database()->connect();

<a name="method-dump"></a>
#### `dump()` {.method}

The method binds the given values to a SQL statement and print it out without executing:

    database->dump('SELECT * FROM users WHERE username = ?', [$username]);

If you set the third argument to true, the method will return the information rather than print it:
    
    $dump = database->dump('SELECT * FROM users WHERE username = ?', [$username], true);
    
<!--    
<a name="method-errorCode"></a>
#### `errorCode()` {.method}

The `errorCode` method gets the most recent error code:

    $errorCode = database()->errorCode();

<a name="method-errorInfo"></a>
#### `errorInfo()` {.method}

The `errorInfo` method  gets the most recent error info:

    $errorInfo = database()->errorInfo();    
-->
    
<a name="method-disconnect"></a>
#### `disconnect()` {.method}

The `disconnect` method disconnects from the database:

    database()->disconnect();
    
<a name="method-last-insert-id"></a>
#### `lastInsertId()` {.method}

The method returns the last inserted autoincrement sequence value.

If you don't insert any values before, the function returns 0.

If you insert multiple rows using a single insert() call, `lastInsertId()` returns dependency of the driver the first or 
last inserted row.

Set [PHP manuals](http://php.net/manual/en/pdo.lastinsertid.php) for more information.

<a name="method-quote"></a>
#### `quote()` {.method}

The `quote` method quotes a value for use in an SQL statement.  

    $quotedValue = database()->quote('Hello world!'); // "'Hello world!'"

<a name="method-quote-name"></a>
#### `quoteName()` {.method}

The `quoteName` method quotes a identifier name (e.g. table, column or index name):

    $quotedTableName = database()->quoteName('books'); // "`books`"
    
<a name="method-reconnect"></a>
#### `reconnect()` {.method}

The `reconnect` method reconnects to the database:

    database()->reconnect();

<a name="method-table"></a>
#### `table()` {.method}

The `table` method returns an instance of `QueryBuilder` for the given table.

    $builder = database()->table('books');

You could also define an alias for your table if you prefer it:
     
    $builder = database()->table('books', 't1');
  
> <i class="fa fa-lightbulb-o fa-2x" aria-hidden="true"></i>
> Note, this is equal with that:
>          
>     $builder = database()->builder()->from('books', 't1');

<a name="method-version"></a>
#### `version()` {.method}

The `version` method returns the server version:
     
    echo database()->version();

> <i class="fa fa-exclamation-circle fa-2x" aria-hidden="true"></i>
> The method returns FALSE if the driver does not support getting attributes.
    
