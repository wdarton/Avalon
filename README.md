# Avalon plugin for CakePHP

## Installation

Clone git repo into plugins folder

# Post Install Config


## Database
Import included .sql file.

### Encrypted fields
For fields that should be encrypted at rest, modify the table file as follows:

Add `use Cake\Database\Schema\TableSchemaInterface;`

Create a new function at the top:

```
protected function _initializeSchema(TableSchemaInterface $schema): TableSchemaInterface
{
    $schema->setColumnType('email', 'crypted');
    $schema->setColumnType('address_line1', 'crypted');
    $schema->setColumnType('address_line2', 'crypted');
    $schema->setColumnType('city', 'crypted');
    $schema->setColumnType('state', 'crypted');
    $schema->setColumnType('zipcode', 'crypted');

    return $schema;
}
```


## Core App Settings

### composer.json
Add to "autoload" under "psr-4":

`"Avalon\\": "plugins/Avalon/src/"'`

### config\bootstrap.php
Add:

`use Cake\Database\Type;`

`Type::map('crypted', 'Avalon\Database\Type\CryptedType');`

### src\Application.php
Add:
```
// Authentication
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Cake\Routing\Router;
use Psr\Http\Message\ServerRequestInterface;
```

Change class to be:

`class Application extends BaseApplication implements AuthenticationServiceProviderInterface`

Insert into the middleware() before the last entry
```
// Add the AuthenticationMiddleware. It should be after routing and body parser.
->add(new AuthenticationMiddleware($this))
```

Add a function at the bottom:

```
public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
{
    $authenticationService = new AuthenticationService([
        'unauthenticatedRedirect' => Router::url('/login'),
        'queryParam' => 'redirect',
    ]);

    // Load identifiers, ensure we check email and password fields
    $authenticationService->loadIdentifier('Authentication.Password', [
        'fields' => [
            'username' => 'username',
            'password' => 'password',
        ],
        'resolver' => [
            'className' => 'Authentication.Orm',
            'userModel' => 'Avalon.Users',
            // 'finder' => 'active',
        ]
    ]);

    // Load the authenticators, you want session first
    $authenticationService->loadAuthenticator('Authentication.Session');
    // Configure form data check to pick email and password
    $authenticationService->loadAuthenticator('Authentication.Form', [
        'fields' => [
            'username' => 'username',
            'password' => 'password',
        ],
        'loginUrl' => Router::url('/login'),
    ]);

    return $authenticationService;
}
```

Under bootstrap():

`$this->addPlugin('Avalon', ['routes' => true]);`

bootstrapCli() should look like:
```
protected function bootstrapCli(): void
{
    $this->addOptionalPlugin('Cake/Repl');
    
    Configure::write('Bake.theme', 'Avalon');
    $this->addOptionalPlugin('Bake');

    $this->addPlugin('Migrations');

    // Load more plugins here
}
```

### src/Controller/AppController.php
Merge with included file.



### Refresh composer autoload cache
`composer dumpautoload`
