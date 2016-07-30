@servers(['moongate' => 'timegrid'])

@task('deploy', ['on' => 'moongate'])
    sudo su deploy -c "/usr/local/bin/deploy.sh {{ $environment }}"
@endtask
