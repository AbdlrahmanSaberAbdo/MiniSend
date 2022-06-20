<?php

namespace Core\Mail\Jobs;

use Core\Mail\Mail\GenerateEmail;
use Core\Mail\Models\Mail as MailModel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class sendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private MailModel $email;
    /**
     * Create a new job instance.
     *
     */
    public function __construct(MailModel $email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       Mail::to($this->email->recipient)->send(new GenerateEmail($this->email));
    }

    /**
     * If the jobs fails, set the status of the email as 'failed'.
     *
     * @return void
     */
    public function failed()
    {
        MailModel::where('id', $this->email->id)->update(['status' => 'failed']);
    }
}
