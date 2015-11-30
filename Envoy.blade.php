@servers(['demo' => 'timegrid'])

@task('check', ['on' => 'demo'])
    cd /var/www/timegrid.io/dev/htdocs
    phpunit
@endtask

@task('deploy', ['on' => 'demo'])
    sudo /usr/local/bin/deploy.sh development
@endtask

@task('seed', ['on' => 'demo'])
    {{-- Target the project directory --}}
    cd /var/www/timegrid.io/demo/htdocs
    {{-- If there is anything to migrate, migrate it --}}
    php artisan db:seed --class="CategoriesSeeder"
@endtask

@task('refresh', ['on' => 'demo'])
    {{-- Target the project directory --}}
    cd /var/www/timegrid.io/dev/htdocs    
    {{-- If there is anything to migrate, migrate it --}}
    php artisan migrate:refresh --seed
@endtask