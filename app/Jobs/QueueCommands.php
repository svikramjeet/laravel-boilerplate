<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Artisan;

class QueueCommands implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::queue('signup_reminder:send');
        Artisan::queue('session-survey:send');
        Artisan::queue('session-register:send');
        Artisan::queue('complete:booking');
        Artisan::queue('mark-remote-attendence');
        Artisan::queue('weekly-report:generate');
        Artisan::queue('roi-month-report:generate');
    }
}
