<?php

namespace Mission4\Supporter\Jobs;

use Zttp\Zttp;
use Illuminate\Bus\Queueable;
use Mission4\Supporter\Supporter;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SupporterAnomaly implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $exception;
    protected $request;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($exception, $request)
    {
        $this->exception = (string) $exception;
        $this->request = json_encode($request);
        $this->user = json_encode($request->user());
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Supporter::handleException($this->exception, $this->request, $this->user);
    }
}