@servers(['moongate' => 'timegrid'])

@task('deploy', ['on' => 'moongate'])
    sudo /usr/local/bin/deploy.sh {{ $environment }}
@endtask
