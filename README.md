## Web Development with Laravel (Intermediate)

### Helper

In `composer.json`, on `autoload` key, add the following:

```
    "files": [
        "app/Support/helper.php"
    ]
```

Create a file in `app/Support` called `helper.php`.

Then start write your helpers. 

Do check on function if exist or not before define the helper.

```php
<?php 

if(! function_exists('helloWorld'))
{
	function helloWorld($name = 'John Doe')
	{
		return 'Hi ' . $name;
	}
}
```

You can test your helper in tinker:

```
$ php artisan tinker
Psy Shell v0.9.9 (PHP 7.2.13 — cli) by Justin Hileman
>>> helloWorld()
=> "Hi John Doe"
>>> helloWorld('nasrul')
=> "Hi nasrul"
```

### Eloquent: Observer

```
$ php artisan make:observer UserObserver --model=User
```

Define the methods want to use, then register in `app/Providers/AppServiceProvider.php` in `boot` method.

```php
public function boot()
{
    \App\User::observe(\App\Observers\UserObserver::class);
}
```

### Event & Listener

Add in `app/Providers/EventServiceProvider.php`, add the following:
 
```php
protected $listen = [
    Registered::class => [
        \App\Listeners\SendWelcomeNotification::class,
        SendEmailVerificationNotification::class,
    ],
];
```

Then run `php artisan event:generate`.

This will generate new listener class located at `app/Listeners` directory.

In the `SendWelcomeNotification`, we can add our logic such as following:

```php
public function handle(Registered $event)
{
    // send welcome notification to user
    $event->user->notify(new \App\Notifications\WelcomeNotification($event->user));
}
```

Don't forget to create `WelcomeNotification`:

```
$ php artisan make:notification WelcomeNotification
```

Do update your `WelcomeNotification` class accordingly.

```php
<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeNotification extends Notification
{
    use Queueable;

    private $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Welcome to ' . config('app.name') . ' ' . $this->user->name)
                    ->action('Login', url('/login'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
```

### Middleware

Create middleware, in this case to minify HTML for performance:

```
$ php artisan make:middleware MinifyHtml
```

Open and update the `App/Http/Middleware/MinifyHtml` file:

```php 
<?php

namespace App\Http\Middleware;

use Closure;

class MinifyHtml
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        return $this->html($response);
    }

    public function html($response)
    {
        $buffer = $response->getContent();

        $replace = [
            '/<!--[^\[](.*?)[^\]]-->/s' => '',
            "/<\?php/"                  => '<?php ',
            "/\n([\S])/"                => '$1',
            "/\r/"                      => '',
            "/\n/"                      => '',
            "/\t/"                      => '',
            '/ +/'                      => ' ',
        ];

        if (false !== strpos($buffer, '<pre>')) {
            $replace = [
                '/<!--[^\[](.*?)[^\]]-->/s' => '',
                "/<\?php/"                  => '<?php ',
                "/\r/"                      => '',
                "/>\n</"                    => '><',
                "/>\s+\n</"                 => '><',
                "/>\n\s+</"                 => '><',
            ];
        }

        $buffer = preg_replace(array_keys($replace), array_values($replace), $buffer);

        $response->setContent($buffer);

        return $response;
    }
}
```

Then register in `app/Http/Kernel.php`, in `web` group middleware 

```php 
<?php 

protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        // \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \App\Http\Middleware\MinifyHtml::class,
    ],

    'api' => [
        'throttle:60,1',
        'bindings',
    ],
];
```

Now your application, should minify the HTML output when display to user.

Right click in browser, select `View Source`.

[Reference](https://blog.nasrulhazim.com/2018/02/laravel-minify-html/)

### Notification

Refer in [Event & Listener](#event-listener)

### Processors vs Services

**Processor**: Think of processes of getting something. It's like you are registering for company to SSM. You provide your company details and give to SSM to PROCESS. That PROCESS, is the process of the SSM have. In application terms, SSM = application, processing the company registration form is a Processor. 

**Service**: Think of service provider like TM Unifi, Celcom, McDonald. They provide services to end users. In application level, the application provide service to consumer, which the consumer is the other application that want to use the application services. 


```php
// helper
userProcessor($username, $email, $password);
// processor
\App\Processors\UserProcessor::make($username, $email, $password);

// services
\App\Services\UserService::make($username)->avatar();
// helper for services
avatar($username);
// api 
return response()->json([
	'avatar' => avatar(request()->username),
]);
```

### Macros

[How do I Create Laravel Macros](https://laracasts.com/series/how-do-i/episodes/21)

- [Response](https://blog.nasrulhazim.com/2017/12/laravel-response-macro/)
- [Route](https://blog.nasrulhazim.com/2017/12/laravel-route-macro/)
- [Blueprint](https://blog.nasrulhazim.com/2017/12/laravel-blueprint-macro/)

### Advanced Seeder

### PHPUnit Test


