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

```
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

### Notification

### Processors vs Services

### Macros

### Advanced Seeder

### PHPUnit Test


