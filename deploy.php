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
   ->set('remote_user', 'www-data')
   ->set('deploy_path', '/var/www/demo')
   ->user('root')
   ->identityFile('~/.ssh/key')
   ->addSshOption('StrictHostKeyChecking', 'no');

// Tasks


// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'database:migrate');
