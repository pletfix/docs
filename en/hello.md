# Hello World - My first Application 

[Since 0.5.0]

- [First Steps](#first-steps)
- [Create a View](#view)
- [Create a Controller](#controller)
- [Create a Table](#table)
- [Create a Model](#model)

<a name="first-steps"></a>
## First Steps

Every software development tutorial starts with the ultimative Hello World programm, isn't it?

Ok, let's start like this with Pletfix:

1. Install a fresh [Pletfix Application](https://github.com/pletfix/app).

2. Open `boot/routes.php` and add a new route:

    ~~~php
    $route->get('welcome', function() {
       return 'Hello World';      
    });
    ~~~

3. Open your browser and enter the URL to your new route:
    
    ~~~
    http://localhost/my-first-app/public/welcome
    ~~~

    Voilà! You will see: "Hello World". What a surprise! 
    
<a name="view"></a>    
## Create a View

Pletfix is a MVC (Model-View-Controller) framework, so we will use a `View` for the greetings output.
 
4. Create a new file `welcome.blade.php` in the subfolder `resources/views` and add the following content:

    ~~~html
    @extends('app')
    
    @section('content')
    
        <h1>Hello World</h1>
    
    @endsection
    ~~~
 
5. Modify the route in `boot/routes.php` so that the view is called and the output string is not returned directly:
 
    ~~~php
    $route->get('welcome', function() {
        return view('welcome');
    });
    ~~~
        
6. Reload the browser and be happy:
    
    ~~~
    http://localhost/my-first-app/public/welcome
    ~~~
    
<a name="controller"></a>    
## Create a Controller

Our application is really simple - so it is ok adding the logic into the route file directly.
But as soon as more logic is added, it becomes quickly confusing. To prevent this let's add a controller:

7. Create a new Controller `WelcomeController` in `app/Controllers/WelcomeController.php`:

    ~~~
    <?php
    
    namespace App\Controllers;
    
    class WelcomeController extends Controller
    {
        public function index()
        {
            return view('welcome');
        }
    }
    ~~~
    
8. We modify the route once more so our controller is called:
 
    ~~~php
    $route->get('welcome', 'WelcomeController@index');
    ~~~
        
9. Reload the browser - the output is the same as the last time:
    
    ~~~
    http://localhost/my-first-app/public/welcome
    ~~~
    
## Create a Table

The next step for this tutorial is creating a table so that we can dynamically read the content of the view from the 
database.

<i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
By default, the Pletfix Application Skeleton creates a SQLite database, so we don't have to change the configuration.
You may check the database configuration in `config/database.php` are correctly. 

10. Create a new migration file `20171007141500_CreatePagesTable.php` in the folder `resources/migrations`:
    Note that normally you should use the current timestamp as prefix for the filename but for this tutorial it does not 
    matter. 
        
    ~~~
    <?php
    
    use Core\Services\Contracts\Database;
    use Core\Services\Contracts\Migration;
    
    class CreatePagesTable implements Migration
    {
        /**
         * @inheritdoc
         */
        public function up(Database $db)
        {
            $db->schema()->createTable('pages', [
                'id'      => ['type' => 'identity'],
                'name'    => ['type' => 'string'],
                'content' => ['type' => 'text'],
            ]);
            
            $db->table('pages')->insert([
                'name'    => 'welcome',
                'content' => 'Hello World',
            ]);
        }
    
        /**
         * @inheritdoc
         */
        public function down(Database $db)
        {
            $db->schema()->dropTable('pages');
        }
    }
    ~~~

11. Execute the Pletfix `migrate` command: 
  
    ~~~
    php console migrate  
    ~~~

    Now we have a new table `pages` with one record.
    
12. Modify the `index` method of the `WelcomeController` like below:
      
    ~~~php
    public function index()
    {
        $page = database()->table('pages')->where('name', 'welcome')->first();
        
        return view('welcome', ['conent' => $page['content']]);
    }
    ~~~  

13. Change set content section of the view:
 
    ~~~html
    @section('content')
     
        <h1>{{$content}}</h1>
     
    @endsection
    ~~~  

14. Reload the browser. The output is still the same as the last time, but the content comes from our database!
    
    ~~~
    http://localhost/my-first-app/public/welcome
    ~~~
        
## Create a Model 
    
The final step of this tutorial is using a Model to access the database table. 

15. Create a new Model `Page` in `app/Models/Page.php`:
   
    ~~~ 
    <?php
    
    namespace App\Models;
    
    use Core\Models\Model;
    
    /**
     * @property integer $id
     * @property string $name
     * @property string $content
     */
    class Page extends Model
    {
    }
    ~~~

    <i class="fa fa-hand-pointer-o fa-2x" aria-hidden="true"></i>
    Note that Pletfix assigns the model automatically, as long as the model is in the singular and the database table 
    in the plural.
    
16. Modify the `index` method of the `WelcomeController` ones more like below:
      
    ~~~php
    public function index()
    {
        /** @var \App\Models\Page $page */
        $page = \App\Models\Page::where('name', 'welcome')->first();
        
        return view('welcome', ['conent' => $page->content]);
    }
    ~~~  

17. Reload the browser. Hello World!
    
    ~~~
    http://localhost/my-first-app/public/welcome
    ~~~
    