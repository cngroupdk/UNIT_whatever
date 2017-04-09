# UnIT test

## Installation

1. Clone the repository.

2. Make directories `log` and `temp` writable.

3. Create file `app/config/config.local.neon`. You can use config.local.template.neon as a template.

4. Run migrations using `php www/index.php migrations:continue`.

## Running

You can use this command to run the web server:

`php -S localhost:3000 -t www`

And this command to run the broadcast consumer:

`php www/index.php broadcast-consumer`

## Guest user credentials

Email: guest@example.com

Password: guest
