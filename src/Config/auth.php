<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Connection
    |--------------------------------------------------------------------------
    |
    | The LDAP connection to use for laravel authentication.
    |
    | You must specify connections in your `config/adldap.php` configuration file.
    |
    | This must be a string.
    |
    */

    'connection' => env('ADLDAP_CONNECTION', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Provider
    |--------------------------------------------------------------------------
    |
    | The LDAP authentication provider to use depending
    | if you require database synchronization.
    |
    | For synchronizing LDAP users to your local applications database, use the provider:
    |
    | Adldap\Laravel\Auth\DatabaseUserProvider::class
    |
    | Otherwise, if you just require LDAP authentication, use the provider:
    |
    | Adldap\Laravel\Auth\NoDatabaseUserProvider::class
    |
    */

    'provider' => Adldap\Laravel\Auth\DatabaseUserProvider::class,

    /*
    |--------------------------------------------------------------------------
    | Rules
    |--------------------------------------------------------------------------
    |
    | Rules allow you to control user authentication requests depending on scenarios.
    |
    | You can create your own rules and insert them here.
    |
    | All rules must extend from the following class:
    |
    |   Adldap\Laravel\Validation\Rules\Rule
    |
    */

    'rules' => [

        // Denys deleted users from authenticating.

        Adldap\Laravel\Validation\Rules\DenyTrashed::class,

        // Allows only manually imported users to authenticate.

        // Adldap\Laravel\Validation\Rules\OnlyImported::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    |
    | Scopes allow you to restrict the LDAP query that locates
    | users upon import and authentication.
    |
    | All scopes must implement the following interface:
    |
    |   Adldap\Laravel\Scopes\ScopeInterface
    |
    */

    'scopes' => [

        // Only allows users with a user principal name to authenticate.
        // Remove this if you're using OpenLDAP.
        Adldap\Laravel\Scopes\UpnScope::class,

        // Only allows users with a uid to authenticate.
        // Uncomment if you're using OpenLDAP.
        // Adldap\Laravel\Scopes\UidScope::class,

    ],

    'usernames' => [

        /*
        |--------------------------------------------------------------------------
        | LDAP
        |--------------------------------------------------------------------------
        |
        | Discover:
        |
        |   The discover value is the users attribute you would
        |   like to locate LDAP users by in your directory.
        |
        |   For example, using the default configuration below, if you're
        |   authenticating users with an email address, your LDAP server
        |   will be queried for a user with the a `userprincipalname`
        |   equal to the entered email address.
        |
        | Authenticate:
        |
        |   The authenticate value is the users attribute you would
        |   like to use to bind to your LDAP server.
        |
        |   For example, when a user is located by the above 'discover'
        |   attribute, the users attribute you specify below will
        |   be used to bind to your LDAP server.
        |
        */

        'ldap' => [

            'discover' => 'userprincipalname',

            'authenticate' => 'userprincipalname',

        ],

        /*
        |--------------------------------------------------------------------------
        | Eloquent
        |--------------------------------------------------------------------------
        |
        | The value you enter is used for locating the local
        | database record of the authenticating user.
        |
        | If you're using a `username` field instead, change this to `username`.
        |
        | This option is only applicable to the DatabaseUserProvider.
        |
        */

        'eloquent' => 'email',

        /*
        |--------------------------------------------------------------------------
        | Windows Authentication (SSO)
        |--------------------------------------------------------------------------
        |
        | Discover:
        |
        |   The discover value is the users attribute you would
        |   like to locate LDAP users by in your directory.
        |
        |   For example, if 'samaccountname' is the value, then your LDAP server is
        |   queried for a user with the 'samaccountname' equal to the value of
        |   $_SERVER['AUTH_USER'].
        |
        |   If a user is found, they are imported (if using the DatabaseUserProvider)
        |   into your local database, then logged in.
        |
        | Key:
        |
        |    The key value represents the 'key' of the $_SERVER
        |    array to pull the users account name from.
        |
        |    For example, $_SERVER['AUTH_USER'].
        |
        */

        'windows' => [

            'discover' => 'samaccountname',

            'key' => 'AUTH_USER',

        ],

    ],

    'passwords' => [

        /*
        |--------------------------------------------------------------------------
        | Password Sync
        |--------------------------------------------------------------------------
        |
        | The password sync option allows you to automatically synchronize
        | users AD passwords to your local database. These passwords are
        | hashed natively by laravel using the bcrypt() method.
        |
        | Enabling this option would also allow users to login to their
        | accounts using the password last used when an AD connection
        | was present.
        |
        | If this option is disabled, the local user account is applied
        | a random 16 character hashed password, and will lose access
        | to this account upon loss of AD connectivity.
        |
        | This option must be true or false and is only applicable
        | to the DatabaseUserProvider.
        |
        */

        'sync' => env('ADLDAP_PASSWORD_SYNC', false),

        /*
        |--------------------------------------------------------------------------
        | Column
        |--------------------------------------------------------------------------
        |
        | This is the column of your users database table
        | that is used to store passwords.
        |
        | Set this to `null` if you do not have a password column.
        |
        */

        'column' => 'password',

    ],

    /*
    |--------------------------------------------------------------------------
    | Login Fallback
    |--------------------------------------------------------------------------
    |
    | The login fallback option allows you to login as a user located on the
    | local database if active directory authentication fails.
    |
    | Set this to true if you would like to enable it.
    |
    | This option must be true or false and is only
    | applicable to the DatabaseUserProvider.
    |
    */

    'login_fallback' => env('ADLDAP_LOGIN_FALLBACK', false),

    /*
    |--------------------------------------------------------------------------
    | Sync Attributes
    |--------------------------------------------------------------------------
    |
    | Attributes specified here will be added / replaced on the user model
    | upon login, automatically synchronizing and keeping the attributes
    | up to date.
    |
    | The array key represents the Laravel model key, and the value
    | represents the users LDAP attribute.
    |
    | This option must be an array and is only applicable
    | to the DatabaseUserProvider.
    |
    */

    'sync_attributes' => [

        'email' => 'userprincipalname',

        'name' => 'cn',

    ],

];
