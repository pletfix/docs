# Authentication

_Making sure you build secure applications_

[Since 0.5.0]

<i class="fa fa-wrench fa-2x" aria-hidden="true"></i> Not implemented yet! - Planned release: 0.7.2

See also:
- <https://www.php-einfach.de/experte/php-sicherheit/authentifizierung-und-autorisierung-in-php/>

<!--
Authentication is the mechanism by which callers prove that they are acting on behalf of specific users or systems. 
Authentication answers the question, "Who are you?" using credentials such as username/password combinations.

In WebLogic Server, Authentication providers are used to prove the identity of users or system processes. 
Authentication providers also remember, transport, and make that identity information available to various components 
of a system (via subjects) when needed. During the authentication process, a Principal Validation provider provides 
additional security protections for the principals (users and groups) contained within the subject by signing and 
verifying the authenticity of those principals. (For more information, see Chapter 6, "Principal Validation Providers.")

The following sections describe Authentication provider concepts and functionality, and provide step-by-step 
instructions for developing a custom Authentication provider:

- Authentication Concepts
- The Authentication Process
- Do You Need to Develop a Custom Authentication Provider?
- How to Develop a Custom Authentication Provider

Quelle: <https://docs.oracle.com/cd/E15523_01/web.1111/e13718/atn.htm#DEVSP205>
-->

## Configuration

`config/auth.php`:

    return [
    
        /**
         * ----------------------------------------------------------------
         * User Roles
         * ----------------------------------------------------------------
         *
         * Here you may specify the available user roles.
         */
    
        'roles' => [
            // 'guest'  => 'Gast',
            'user'   => 'Benutzer',
            'editor' => 'Redakteur',
            'admin'  => 'Administrator',
        ],
    
        /**
         * ----------------------------------------------------------------
         * Access Control List
         * ----------------------------------------------------------------
         *
         * To control the access you may define the user abilities.
         */
    
        'acl' => [
            // 'login'              => ['guest'],
            'save-comment'       => ['admin', 'editor', 'user'],
            'delete-own-comment' => ['admin', 'editor', 'user'],
            'manage'             => ['admin', 'editor'],
            'manage-blog'        => ['admin', 'editor'],
            'manage-user'        => ['admin'],
        ],
    ];

### Model

    /**
     * @property integer $id
     * @property string $name
     * @property string $email
     * @property string $password
     * @property string $role
     * @property string $confirmation_token
     * @property string $remember_token
     * @property DateTime $created_at
     * @property DateTime $updated_at
     */
    class User extends Model
    {
        /**
         * The attributes that aren't mass assignable.
         *
         * @var array
         */
        protected static $guarded = ['id', 'role', 'confirmation_token', 'remember_token', 'created_at', 'updated_at'];
    }
    
    
## General Usage
    

### Auth-Service
    
    interface Auth
    {
        /**
         * Authenticate and log a user into the application.
         *
         * @param array $credentials
         * @return bool
         */
        public function login(array $credentials);
    
        /**
         * Log the user out of the application.
         */
        public function logout();
    
        /**
         * Determine if the current user is authenticated.
         *
         * @return bool
         */
        public function isVerified(); // or check? or isValid? or ...?
    
        /**
         * Get the id of the current user.
         *
         * @return int|null
         */
        public function id();
    
        /**
         * Get the display name of the current user.
         *
         * @return string|null
         */
        public function name();
    
        /**
         * Get the role of the current user.
         *
         * @return string|null
         */
        public function role();
    
        /**
         * Get the abilities of the current user.
         *
         * @return array|null
         */
        public function abilities();
    
        /**
         * Determine if the current user is the given role.
         *
         * @param string|array $role
         * @return bool
         */
        public function is($role);
    
        /**
         * Determine if the user has the given ability.
         *
         * @param $ability
         * @return bool
         */
        public function can($ability);
    
        /**
         * Change the display name of the current user.
         *
         * @param string $name
         */
        public function changeName($name);
    
        /**
         * Change the role of the current user.
         *
         * @param string $role
         */
        public function changeRole($role);
    }
        
        
### Middleware
    
    
### View

    @is('admin')
        I'm the admin.
    @elseis('user')
        I'm a user.
    @elseis
        I'm a guest.
    @endis
        
    @can('manage-user')
        I can manage the user.
    @elsecan
        I cannot manage the user.
    @endcan
    
        
## Login

- rate limiting
- Authorize

### Routes

    // Authentication Routes
    $route->get('auth/login',            'Auth\LoginController@showForm'); // showLoginForm
    $route->post('auth/login',           'Auth\LoginController@login');
    $route->post('auth/logout',          'Auth\LoginController@logout', 'Auth');

### Angemeldet bleiben-Funktion


## Registration

### Routes

    // Registration Routes
    $route->get('auth/register',         'Auth\RegisterController@showForm'); // showRegistrationForm
    $route->post('auth/register',        'Auth\RegisterController@register');
    $route->get('auth/register/{token}', 'Auth\RegisterController@confirm');
    $route->get('auth/register/resend',  'Auth\RegisterController@resend', 'Auth');

    
## Password Reset

Passwort-Vergessen-Funktion

### Routes

    // Password Reset Routes
    $route->get('auth/reset',            'Auth\ResetController@showForgotForm');
    $route->post('auth/reset/send',      'Auth\ResetController@send');
    $route->get('auth/reset/{token}',    'Auth\ResetController@showResetForm');
    $route->post('auth/reset',           'Auth\ResetController@reset');


## Passwort Change

### Routes

    // Password Change Routes
    $route->middleware('Auth', function(Route $route) {
        $route->get('auth/password',     'Auth\PasswordController@showForm'); // showChangeForm
        $route->post('auth/password',    'Auth\PasswordController@change');
    });


## User Profile

### Routes
    
    // Profile
    $route->middleware('Auth', function(Route $route) {
        $route->get('profile',           'ProfileController@index');
        $route->get('profile/edit',      'ProfileController@edit');
        $route->patch('profile/save',    'ProfileController@save');
    });


## User Management

### Routes

    // User Management
    $route->middleware('Ability:manage-user', function(Route $route) {
        $route->get('admin/users/{user}/replicate', 'Admin\UserController@replicate');
        $route->get('admin/users/{user}/confirm',   'Admin\UserController@confirm');
        $route->resource('admin/users', 'Admin\UserController');
    });
