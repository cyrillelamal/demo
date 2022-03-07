<?php
namespace Deployer;

require 'recipe/symfony4.php';

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
   ->set('remote_user', 'root')
   ->set('deploy_path', '/var/www/demo')
   ->user('root')
   ->identityFile('~/.ssh/key')
   ->addSshOption('StrictHostKeyChecking', 'no');

// Tasks
desc('Deploy');
task('deploy', function () {
    run('export APP_ENV=prod');
    run('/usr/local/bin/composer install --no-dev');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'database:migrate');
