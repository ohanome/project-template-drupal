# Project template: Drupal

This project template should provide a kickstart for new Drupal projects.

## Installation

Run the following command to initialize the project:
```shell
composer create-project ohanome/project-template-drupal PROJECT_NAME
```

## Contents

### Lando

A preconfigured Lando configuration is included. To start Lando, modify the `name` entry inside [.lando.yml](./.lando.yml) and run the following command:
```shell
lando start
```

This configuration will create a Lando environment with the following services:
- appserver, using apache2 and PHP 8.1
- database, using MariaDB
- mailhog, to catch outgoing emails
- phpmyadmin, to access the database via a web interface
- testdb, a second database for testing purposes
- testdb_phpmyadmin, a web interface for the test database

### Deployer

A preconfigured Deployer configuration is included. To use the configuration, copy the file [deploy.php.dist](./deploy.php.dist) to `deploy.php` and modify the contents of the file.

Afterwards you can run
```shell
/vendor/bin/dep deploy <STAGE>
```
where `<STAGE>` is the selected stage specified in your `deploy.php` as parameter to the defined `host()` calls.

### ENV file support

Based on the discontinued project `drupal-composer/drupal-project`, this project template supports the use of `.env` files. To use this feature, copy the file [.env.example](./.env.example) to `.env` and modify the values to your needs.

The file `web/sites/default.settings.php` for example will automatically load the values from the `.env` file.

### Preconfigured settings.php

The following settings have been preconfigured in `web/sites/default.settings.php`:
- Database connection:
  - The database credentials are loaded from the `.env` file
- `config_sync_directory`: The directory for the configuration sync is set to `../config/default` (at project root)
- `file_private_path`: The private file path is set to `../private` (at project root)
- `file_temporary_path`: The temporary file path is set to `../tmp` (at project root)
- The `settings.local.php` file is loaded if it exists (by Drupals default, that part is commented out)
