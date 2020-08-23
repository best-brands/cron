# Cron

An addon to schedule cron jobs accordingly in CS-Cart.

## Registering

It is pretty straight forward, just use the 'cron_run' hook. Your handler
will have to look something like this:

```php
function fn_[my_addon]_cron_run(int $time) {
	// Using closures
	Tygh::$app['cron']->add("* * * * *", function () {
		...
	});
	
	// Using existing classes registered in the DI
	Tygh::$app['cron']->add("* * * * *", [Tygh::$app['addons.[my_addon].service'], 'method']);
	
	// Or just using an already existing function
	Tygh::$app['cron']->add("* * * * *", 'fn_[my_addon]_cron_handler');
}
```

Since the latest version in CS-Cart you can also register 'conditional',
hook handlers, so you can have compatibility with the add-on without
using janky if-else trees, just register as follows:

```php
fn_register_hooks([
    ['my_own_hook', '', 'cron']
]);
```

Your handler would look as follows:

```php
fn_cron_[my_own_hook](int $time) {
    ...
}
```

You can also use the new hook handler maps.

## Logic

Cron jobs will be dependent on their handlers. This means if your
job takes 1 hour and 5 minutes to complete, but runs every hour,
it won't run the second time as the previous job is still active.
This is to avoid any race conditions, because that just means you
maybe shouldn't use a cron job for what you are doing.

