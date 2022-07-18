<?php

namespace Qruto\LaravelWave\Commands;

use Illuminate\Console\Command;
use Qruto\LaravelWave\Events\SsePingEvent;

class Ping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sse:ping {--interval= : interval in seconds}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ping server sent event connections';

    public function handle()
    {
        $interval = $this->option('interval');

        if ($interval) {
            while (true) {
                event(new SsePingEvent());

                $this->info('Pinged: '.now());

                sleep($interval);
            }
        } else {
            $this->info('Pinged: '.now());

            event(new SsePingEvent());
        }
    }
}
