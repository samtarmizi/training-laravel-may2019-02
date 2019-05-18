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

### Processors vs Services

### Macros

### Advanced Seeder

### PHPUnit Test

### Event & Listener

### Middleware

### Notification


