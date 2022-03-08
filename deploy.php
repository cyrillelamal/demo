<?php
namespace Deployer;

require 'recipe/symfony4.php';

// Project name
set('application', 'Demo');

// Project repository
set('repository', 'git@github.com:cyrillelamal/demo.git');

set('http_user', 'www-data');

// Hosts
host('80.249.145.124')
   ->set('remote_user', 'www-data')
   ->set('deploy_path', '/var/www/demo')
   ->set('writable_mode', 'chmod')
   ->user('root')
   ->identityFile('~/.ssh/key')
   ->addSshOption('StrictHostKeyChecking', 'no');

// Tasks
task('php-fpm:restart', function() {
    run('systemctl restart php8.0-fpm.service');
});

before('deploy:symlink', 'database:migrate');
after('deploy:symlink', 'php-fpm:restart');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
