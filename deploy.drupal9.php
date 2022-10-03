<?php
namespace Deployer;

require 'recipe/drupal8.php';

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

//Drupal 8 shared dirs
set('shared_dirs', [
  'web/sites/{{drupal_site}}/files',
  'private',
]);

//Drupal 8 shared files
set('shared_files', [
  'web/sites/{{drupal_site}}/settings.php',
  'web/sites/{{drupal_site}}/services.yml',
  '.env',
]);

//Drupal 8 Writable dirs
set('writable_dirs', [
  'web/sites/{{drupal_site}}/files',
]);

set('writable_mode', 'chmod');

set('clear_paths', [
  'README.md',
  'COPYRIGHT.md',
  'deploy.php',
  '.editorconfig',
  'phpunit.xml.dist',
  'export',
  '.gitattributes',
  '.gitignore',
  'phpunit.xml.dist',
  '.env.example',
  '.lando.yml',
  'web/sites/development.services.yml',
  'web/sites/sites.local.php',
  'web/sites/{{drupal_site}}/settings.local.php',
]);

task('deploy:update_code', function () {
  run('git clone {{repository}} --depth=1 -b {{branch}} {{release_path}} && rm -rf {{release_path}}/.git');
});

set('bin/drush', function () {
  return '{{bin/php}} {{release_path}}/vendor/bin/drush';
});

task('deploy:vendors', function () {
  run('cd {{release_path}} && {{bin/composer}} install');
});

task('drupal:config:import', function () {
  run('cd {{release_path}} && {{bin/drush}} cim -y');
});

task('drupal:cache:rebuild', function () {
  run('cd {{release_path}} && {{bin/drush}} cr');
});

/**
 * We replace the default release_name with a date based.
 */
set('release_name', function () {
  return date('Y-m-d-H-i-s');
});

task('deploy', [
  'deploy:info',
  'deploy:lock',
  'deploy:release',
  'deploy:update_code',
  'deploy:vendors',
  'deploy:shared',
  'deploy:writable',
  'deploy:clear_paths',
  'deploy:symlink',
  'drupal:config:import',
  'drupal:cache:rebuild',
  'deploy:unlock',
  'deploy:cleanup'
]);

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
