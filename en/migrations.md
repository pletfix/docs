# Migrations

_List and run migrations_

[Since 0.5.0]

- [Introduction](#introduction)
- [Writing Migrations](#writing)
- [Running Migrations](#running)


<a name="introduction"></a>
## Introduction

Migrations are like a version control for your database, allowing your team to modify and share the application's 
database schema easily. 


<a name="writing"></a>
## Writing Migrations

### Migration Files

The migrations are stored in the `resources/migrations` directory. 

The name of the migration file have to contains first a timestamp which is used to determine the order of the 
migrations and second the name of the migration class. In fact, the expected format is `<timestamp>_<classname>.php`, 
e.g. `20170118123000_CreateTestTable.php`.

### Migration Classes

A migration class contains two methods: `up` and `down`. The `up` method is used to modify the schema or records of the 
database, while the `down` method should simply reverse the operations performed by the `up` method.

E.g., this migration example creates a `books` table:
    
    use Core\Services\Contracts\Database;
    use Core\Services\Contracts\Migration;
    
    class CreateBookTable implements Migration
    {
        public function up(Database $db)
        {
            $db->schema()->createTable('books', [
                'id'           => ['type' => 'identity'],
                'title'        => ['type' => 'string'],
                'author_id'    => ['type' => 'integer'],
                'published_at' => ['type' => 'datetime'],
            ]);
        }
    
        public function down(Database $db)
        {
            $db->schema()->dropTable('books');
        }
    }

Of course, you could seeding your database with records on the same way:

    use Core\Services\Contracts\Database;
    use Core\Services\Contracts\Migration;
    
    class SeedBooks implements Migration
    {
        public function up(Database $db)
        {
            $db->insert('books', [
                ['title' => 'The Principle of Relativity', 'author_id' => 1],
                ['title' => 'A Brief History of Time',     'author_id' => 2],
            ]);
        }
    
        public function down(Database $db)
        {
            $db->delete('books', [
                ['title' => 'The Principle of Relativity', 'author_id' => 1],
                ['title' => 'A Brief History of Time',     'author_id' => 1],
            ]);
        }
    }
    
### Available Methods
    
Read the chapter "[database](database#schema)" to learn which methods are provided by the database schema.

You may also find there the description how you may [insert](database#method-insert), [update](database#method-update) 
or [delete](database#method-delete) records. 


<a name="running"></a>
## Running Migrations

To run all of your outstanding migrations, execute the Pletfix `migrate` command:

    php console migrate

To rollback the latest migration operation, you may use the `--rollback` option. This command rolls back the last 
"batch" of migrations, which may include multiple migration files:

    php console migrate --rollback

The `--reset` option will roll back all of your application's migrations:

    php console migrate --reset
