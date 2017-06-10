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
            //'guest'=> 'Gast',
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
            // 'login'           => ['guest'],
            'save-comment'       => ['admin', 'editor', 'user'],
            'delete-own-comment' => ['admin', 'editor', 'user'],
            'manage'             => ['admin', 'editor'],
            'manage-blog'        => ['admin', 'editor'],
            'manage-user'        => ['admin'],
        ],
    
        /**
         * ----------------------------------------------------------------
         * Model
         * ----------------------------------------------------------------
         *
         * Here you may specify the model which stores the user accounts.
         *
         * If you omit this option, you need additional services such as LDAP, Twitter or Facebook, to authorize the user.
         */
    
        'model' => [
            'class'    => 'App\Models\User',
            'identity' => 'email', // Find the user by this column, usually "email" or "name".
        ]
    ];

### Model

    /**
     * @property integer $id
     * @property string $name
     * @property string $email
     * @property string $password
     * @property string $role
     * @property string $principal
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
     * Set the attributes of the principal and store it in the session.
     *
     * @param int $id
     * @param string $name
     * @param string $role
     */
    public function setPrincipal($id, $name, $role);

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function isLoggedIn();

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
        
        
### View

#### User Role Check

You can use the Blade directive `@is` to check the role within in the view:

    @is('admin')
        I'm the admin.
    @elseis('user')
        I'm a user.
    @elseis
        I'm a guest.
    @endis

Read the [Blade Quick Reference](blade#quick-role-check) to leran more about `@is` related directives. 

#### User Ability Check

You can check the abilities of the user within the view like this:
        
    @can('manage-user')
        I can manage the user.
    @elsecan
        I cannot manage the user.
    @endcan
    
Read the [Blade Quick Reference](blade#quick-ability-check) to leran more about `@can` related directives. 
  
        
### User Registration and Login

There is a [Authentication Plugin for Pletfix](https://github.com/pletfix/authentication) that provides forms that allow 
the user to register via Double opt-in process and to log in. The user can also reset or change their password. 
In addition, the plugin provides the "remember-me" functionality. 

![Login](https://raw.githubusercontent.com/pletfix/registration/master/docs/screenshot4.png)


### User Management

Furthermore, the plugin above contains a complete user administration.

![User Management](https://raw.githubusercontent.com/pletfix/user-manager/master/table.png)


<!--
### User Profile

if you install the ![Fresh Pletfix Application](https://raw.githubusercontent.com/pletfix/docs/master/images/pletfix_application.png),
a User Profile Page is generated by default.

TODO: Move to the plugin
-->