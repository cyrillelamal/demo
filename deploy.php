<?php
namespace Deployer;

require 'recipe/symfony.php';

// Project name
set('application', 'Demo');

// Project repository
set('repository', 'git@github.com:cyrillelamal/demo.git');


// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);

// Hosts
host('80.249.145.124')
   ->set('remote_user', 'www-data')
   ->set('deploy_path', '/var/www/demo')
   ->user('root')
   ->identityFile('~/.ssh/key')
   ->addSshOption('StrictHostKeyChecking', 'no');

// Tasks
desc('Deploy');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:clear_paths',
    'deploy:create_cache_dir',
    'deploy:shared',
    'deploy:assets',
    'deploy:vendors',
    'dependencies:install',
    'deploy:cache:clear',
    'deploy:cache:warmup',
    'deploy:writable',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);

task('dependencies:install', function() {
    run('export APP_ENV=prod');
    run('/usr/local/bin/composer install --no-dev');
});


// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'database:migrate');
