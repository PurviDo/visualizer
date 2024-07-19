<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject;
    public $html;

    public function __construct($subject, $html)
    {
        $this->subject = $subject;
        $this->html = $html;
    }

    public function build()
    {
        $subject = $this->subject;
        $html = $this->html;

        return $this->subject($subject)->html($html);
    }
}
