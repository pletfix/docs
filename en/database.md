# Database Access Layer

[Since 0.5.0]

- [Introduction](#introduction)
- [Configuration](#configuration)
- [Connections](#connections)
- [Data Queries](#queries)
- [Data Manipulation](#manipulation)
- [Transactions](#transactions)
- [Schema](#schema)
- [Miscellanea Functions](#misc)


<a name="introduction"></a>
## Introduction

Pletfix's Database Access Layer takes care of the connection setup and abstracts access to the database engine.
Furthermore, field types are abstracted over all supported database providers to translation to PHP data-types.

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

</div>

<a name="method-query"></a>
#### `query()` {.method .first-method}

You may run queries using the `query` method:

    $users = database()->query('SELECT * FROM users WHERE role = ?', ['guest']);
    
The first argument passed to the select method is the raw SQL query.

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
> Because the SQL syntax of database systems varies in detail, maybe you can not easily change the database system later 
> if you write raw SQL directly. Therefore, it is advisable to use a [QueryBuilder](queries) to generate the SQL syntax.  

The second argument is any parameter bindings that need to be bound to the query. 

Instead of using `?` to represent your parameter bindings, you may execute a query using named bindings:

    $users = database()->query('SELECT * FROM users WHERE role = :role', ['role => 'guest]);

> <i class="fa fa-info fa-2x" aria-hidden="true"></i>
> No matter how, it is highly recommended to use parameter binding because its provides protection against 
> [SQL injection](http://php.net/manual/en/security.database.sql-injection.php).

The `query` method will always return an `array` of records. If you net set a third argument for the `query` function, 
each record within the array will be an associative array:

    foreach ($users as $user) {
        echo $user['id'] . ':' . $user['role'] . '<br/>';    
    }

If you set a class name of a Model as the third argument, each record will be an instance of this class.

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

<a name="method-singe"></a>
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

    $count = database()->single('SELECT COUNT(*) FROM users WHERE role = :role', ['role => 'guest]);

<a name="method-cursor"></a>
#### `cursor()` {.method}

The `cursor` method runs a select statement against the database and returns a 
[generator](http://php.net/manual/de/language.generators.syntax.php). 
With the cursor you could iterate the rows (via foreach) without fetch all the data at one time.
This method is useful to handle big data.

    foreach (database()->cursor('SELECT * FROM users WHERE role = ?', ['guest'], User::class) as $row) {
        echo $user->id . ':' . $user->role . '<br/>';
    };


<a name="manipulation"></a>
## Data Manipulation

### Available Methods

<div class="method-list" markdown="1">

[exec](#method-exec)
[insert](#method-insert)
[update](#method-update)
[delete](#method-delete)
[truncate](#method-truncate)

</div>

<a name="method-exec"></a>
#### `exec()` {.method .first-method}

If you want to manipulate data, you could use the `exec` method, which is faster as `query` because no record have to 
be fetched to an array.

    database()->exec('INSERT INTO users (firstname, lastname) VALUES (?, ?)', ['Stephen', 'Hawking']);

> <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
> However, you should prefer the following functions to manipulate the data, because they do not use raw SQL and 
> are therefore independent of the database system!

<a name="method-insert"></a>
#### `insert()` {.method}

The `insert` method creates a new record to the given table:

    $affected = database()->insert('users', ['firstname' => 'Stephen', 'lastname' => 'Hawking']);

Bulk inserting is possible too, `insert()` returns the number of affected rows:

    $affected = database()->insert('users', [
        ['firstname' => 'Stephen', 'lastname' => 'Hawking']
        ['firstname' => 'Albert', 'lastname' => 'Einstein'],
    ]);

The `lastInsertId` function returns the last inserted autoincrement sequence value:
 
    $userId = database()->lastInsertId 

<a name="method-update"></a>
#### `update()` {.method}
    
The `update` function updates a table with th given data and returns the number of affected rows.

    $affected = database()->update('users', ['lastname' => 'Hawking'], 'role=?', ['guest']);

<a name="method-delete"></a>
#### `delete()` {.method}
    
The `delete` function deletes records rom a table and returns the number of affected rows:

    $affected = database()->delete('users', 'role=?', ['guest']);

<a name="method-truncate"></a>
#### `truncate()` {.method}
    
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
    
Pletfix also offers the `transaction` method which executes a closure function within a transaction:

    $db->transaction(function(Database $db) {
        $db->insert('users', ['firstname' => 'Stephen', 'lastname' => 'Hawking']);
        $db->insert('users', ['firstname' => 'Albert',  'lastname' => 'Einstein']);
    });

If an exception is thrown within the transaction closure, the transaction will automatically be rolled back. 
And of course, if the closure executes successfully, the transaction will automatically be committed. 


<a name="schema"></a>
## Schema

The `schema` function returns an instance of `Schema` that allows you to change the structure of the database.

    $schema = database()->schema();
    
Normally you don't need the schema functions directly. Rather, you should use [migration files](migrations) to define 
or modify the database schema.

<a name="type-mapping"></a>
### Field Type Mapping
    
The following table shows an overview of the Pletfix's type abstraction for the database schema and migrations files. 
The matrix contains the mapping information for how a specific abstract type is mapped to the database and back to PHP.
The Table based on [Doctrine's Mapping Matrix](http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/types.html#mapping-matrix).
    
| Abstract    | PHP      | MySql                                            | PostgreSQL                     | SQL Server                                | SQLite                                     |
|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| identity    | integer  | INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT | SERIAL                         | INT NOT NULL IDENTITY(1,1) PRIMARY KEY    | INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL | 
| bigidentity | integer  | BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT       | BIGSERIAL                      | BIGINT NOT NULL IDENTITY(1,1) PRIMARY KEY | INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL | 
| smallint    | integer  | SMALLINT                                         | SMALLINT                       | SMALLINT                                  | INTEGER                                    | 
| integer     | integer  | INT                                              | INTEGER                        | INT                                       | INTEGER                                    | 
| unsigned    | integer  | INT UNSIGNED                                     | INTEGER                        | INT                                       | INTEGER UNSIGNED                           | 
| bigint      | string   | BIGINT                                           | BIGINT                         | BIGINT                                    | INTEGER                                    | 
| numeric     | string   | DECIMAL(p, s)                                    | NUMERIC(p, s)                  | NUMERIC(p, s)                             | NUMERIC(p, s)                              |
| float       | float    | DOUBLE                                           | DOUBLE PRECISION               | FLOAT                                     | DOUBLE PRECISION                           | 
| string      | string   | VARCHAR(n)                                       | VARCHAR(n)                     | NVARCHAR(n), NCHAR(n)                     | CHAR(n)                                    |
| text        | string   | TINYTEXT, TEXT, MEDIUMTEXT, LONGTEXT             | TEXT                           | TEXT, VARCHAR(MAX)                        | CLOB                                       |
| guid        | string   | VARCHAR(36)                                      | UUID                           | UNIQUEIDENTIFIER                          | VARCHAR(36)                                | 
| binary      | resource | VARBINARY(n)                                     | BYTEA                          | VARBINARY(n), BINARY(n)                   | BLOB                                       |
| blob        | resource | TINYBLOB, BLOB, MEDIUMBLOB, LONGBLOB             | BYTEA                          | IMAGEVARBINARY(MAX)                       | BLOB                                       |
| boolean     | boolean  | TINYINT(1)                                       | BOOLEAN                        | BIT                                       | BOOLEAN                                    | 
| date        | DateTime | DATE                                             | DATE                           | DATE (#1)                                 | DATE                                       |
| datetime    | DateTime | DATETIME                                         | TIMESTAMP(0) WITHOUT TIME ZONE | DATETIME                                  | DATETIME                                   | 
| timestamp   | DateTime | TIMESTAMP (#2)                                   | TIMESTAMP(0) WITH TIME ZONE    | DATETIMEOFFSET(6) (#1)                    | DATETIME                                   |
| time        | DateTime | TIME                                             | TIME(0) WITHOUT TIME ZONE      | TIME(0) (#1)                              | TIME                                       |
| array       | array    | TINYTEXT, TEXT, MEDIUMTEXT, LONGTEXT             | TEXT                           | TEXT, VARCHAR(MAX)                        | CLOB                                       |
| json        | array    | JSON (#3)                                        | JSONB  (#4)                    | TEXT, VARCHAR(MAX)                        | CLOB                                       |
| object      | object   | TINYTEXT, TEXT, MEDIUMTEXT, LONGTEXT             | TEXT                           | TEXT, VARCHAR(MAX)                        | CLOB                                       |

- (#1) Before SQL Server 2008: DATETIME 
- (#2) Extra: ON UPDATE CURRENT_TIMESTAMP; Default: CURRENT_TIMESTAMP
- (#3) Before MxSql 5.7.8: TINYTEXT, TEXT, MEDIUMTEXT, LONGTEXT 
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
[addColumn](#method-add-column)
[dropColumn](#method-drop-column)
[renameColumn](#method-rename-column)
[addIndex](#method-add-index)
[dropIndex](#method-drop-index)
[zero](#method-zero)

</div>

<a name="method-tables"></a>
#### `tables()` {.method .first-method}

    /**
     * Returns aa array of tables in the database.
     *
     * Each return item is a array with the following values:
     * - name:      (string) The table name
     * - collation: (string) The default collation of the table.
     * - comment:   (string) A hidden comment.
     *
     * @return array An associative array where the key is the table name and the value is the table attributes.
     */
    public function tables();

<a name="method-columns"></a>
#### `columns()` {.method}

The `columns` method returns an associative array of information about the columns of the table. 

    $columns = database()->schema()->columns($table);

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

    /**
     * Returns an array of indexes in a table.
     *
     * Each return item is a array with the following values:
     * - name:      (string) The index name.
     * - columns:   (array)  The list of column names.
     * - unique:    (bool)   Is the index a unique index?
     * - primary:   (bool)   Is the index the primary key?
     *
     * @param string $table Name of the table.
     * @return array An associative array where the key is the index name and the value is the index attributes.
     */
    public function indexes($table);

<a name="method-createTable"></a>
#### `create-table()` {.method}

    /**
     * Create a new table on the schema.
     *
     * Parameter $columns is an associative array where the key is the column name and the value is the column attributes.
     * A column attribute is a array with the following values:
     * - type:      (string) The column data type. Data types are as reported by the database.
     * - size:      (int)    The column size (the maximum number of digits).
     * - scale:     (int)    The number of digits to the right of the numeric point. It must be no larger than size.
     * - nullable:  (bool)   Is the column is not marked as NOT NULL.
     * - default:   (mixed)  The default value for the column.
     * - collation: (string) The collation of the column.
     * - comment:   (string) A hidden comment.
     *
     * Options have following values:
     * - temporary: (bool)   The table is temporary.  todo kann raus!
     * - collation: (string) The default collation of the table.
     * - comment:   (string) A hidden comment.
     *
     * @param  string $table
     * @param array $columns
     * @param array $options
     */
    public function createTable($table, array $columns, array $options = []);

The column type should be given as an abstract type, see also [Field Type Mapping](#type-mapping). 

<a name="method-drop-table"></a>
#### `dropTable()` {.method}

    /**
     * Drop a table from the schema.
     *
     * @param string $table
     */
    public function dropTable($table);

<a name="method-rename-table"></a>
#### `renameTable()` {.method}

    /**
     * Rename a table on the schema.
     *
     * @param string $from old table name
     * @param string $to new table name
     */
    public function renameTable($from, $to);

<a name="method-add-column"></a>
#### `addColumn()` {.method}

    /**
     * Add a new column on the table.
     *
     * Options have following values:
     * - type:      (string) The column data type. Data types are as reported by the database.
     * - size:      (int)    The column size (the maximum number of digits).
     * - scale:     (int)    The number of digits to the right of the numeric point. It must be no larger than size.
     * - nullable:  (bool)   The column is not marked as NOT NULL.
     * - default:   (mixed)  The default value for the column.
     * - collation: (string) The collation of the column.
     * - comment:   (string) A hidden comment.
     *
     * @param string $table
     * @param string $column
     * @param array $options
     */
    public function addColumn($table, $column, array $options);

The column type should be given as an abstract type, see also [Field Type Mapping](#type-mapping).

<a name="method-drop-column"></a>
#### `dropColumn()` {.method}

    /**
     * Drop a column from the table
     *
     * @param string $table
     * @param string $column
     */
    public function dropColumn($table, $column);

<a name="method-rename-column"></a>
#### `renameColumn()` {.method}

    /**
     * Rename a column for the table.
     *
     * @param string $table
     * @param string $from
     * @param string $to
     */
    public function renameColumn($table, $from, $to);

<a name="method-add-index"></a>
#### `addIndex()` {.method}

    /**
     * Create an index on the table.
     *
     * Options have following values:
     * - columns    (string[])  List of column names.
     * - unique:    (bool)      The index is a unique index.
     * - primary:   (bool)      The index is the primary key.
     *
     * @param string $table Name of the table which the index is for.
     * @param string|null $name The name of the index. It will be generated automatically if not set and will be ignored by a primary key.
     * @param array $options
     */
    public function addIndex($table, $name, array $options = []);

<a name="method-drop-index"></a>
#### `dropIndex()` {.method}

    /**
     * Drop a index from the table.
     *
     * Options have following values:
     * - columns    (string[])  List of column names. Could be null if the index name is given or it's the primary index.
     * - unique:    (bool)      The index is a unique index. It's needed to generate the name.
     * - primary:   (bool)      The index is the primary key.
     *
     * @param string $table
     * @param string|null $name The name of the index. It will be generated automatically if not set.
     * @param array $options
     */
    public function dropIndex($table, $name, array $options = []);

<a name="method-zero"></a>
#### `zero()` {.method}

    /**
     * Get a Zero-Value by given column type.
     * @param string $type Column Type supported by Database Access Layer
     * @return string
     */
    public function zero($type);

    
<a name="misc"></a>
## Miscellanea Functions

<div class="method-list" markdown="1">

[config](#method-config)
[connect](#method-connect)
[errorCode](#method-error-code)
[errorInfo](#method-error-info)
[disconnect](#method-disconnect)
[quote](#method-quote)
[quoteName](#method-quote-name)
[reconnect](#method-reconnect)
[version](#method-version)

</div>

<a name="method-config"></a>
#### `config()` {.method .first-method}

    /**
     * Gets the database configuration.
     *
     * @param string|null $key
     * @return array|mixed
     */
    public function config($key = null);


<a name="method-connect"></a>
#### `connect()` {.method}

    /**
     * Connects to the database.
     */
    public function connect();

<a name="method-errorCode"></a>
#### `errorCode()` {.method}

    /**
     * Gets the most recent error code.
     *
     * @return mixed
     */
    public function errorCode();

<a name="method-errorInfo"></a>
#### `errorInfo()` {.method}

    /**
     * Gets the most recent error info.
     *
     * @return array
     */
    public function errorInfo();    
    
<a name="method-disconnect"></a>
#### `disconnect()` {.method}

    /**
     * Disconnects from the database.
     */
    public function disconnect();

<a name="method-quote"></a>
#### `quote()` {.method}

    /**
     * Quotes a value for use in an SQL statement.
     *
     * This differs from `PDO::quote()` in that it will convert an array into a string of comma-separated quoted values.
     *
     * @param mixed $value The value to quote.
     * @param int $type PDO type
     * @return string The quoted value.
     */
    public function quote($value, $type = PDO::PARAM_STR);

<a name="method-quote-name"></a>
#### `quoteName()` {.method}

    /**
     * Quotes a single identifier name (e.g. table, column or index name).
     * @param string $name
     * @return string
     */
    public function quoteName($name);
    
<a name="method-reconnect"></a>
#### `reconnect()` {.method}

    /**
     * Reconnect to the database.
     *
     * @return void
     *
     * @throws \LogicException
     */
    public function reconnect();

<a name="method-version"></a>
#### `version()` {.method}

    /**
     * Return server version.
     *
     * Returns FALSE if the driver does not support getting attributes.
     *
     * @return string|false
     */
    public function version();
    
