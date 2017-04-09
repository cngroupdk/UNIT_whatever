# UnIT test

## Installation

1. Clone the repository.

2. Make directories `log` and `temp` writable.

3. Create file `app/config/config.local.neon`. You can use config.local.template.neon as a template.

4. Run migrations using `php www/index.php migrations:continue`.

## Running

You can run the application by running this command:

`php -S localhost:3000 -t www`

## Guest user credentials

Email: guest@example.com

Password: guest
