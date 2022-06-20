<?php

namespace Core\Mail\Mail;

use Core\Mail\Models\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenerateEmail extends Mailable
{
    use Queueable, SerializesModels;

    private Mail $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Mail $email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from($this->email->sender)
            ->view('emails.general')
            ->subject($this->email->subject)
            ->with([
                'text' => $this->email->text ?? '',
                'html' => $this->email->html ?? '',
            ]);

        $attachments = $this->email->attachments->pluck('filepath');
        foreach ($attachments as $path) {
            $this->attachFromStorage($path);
        }

        return $this;
    }
}
