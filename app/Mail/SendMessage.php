<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $msg;
    public $site_name;
    public $title;
    public $copy_right;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($msg, $site_name, $title, $copy_right) {

        $this->site_name = $site_name;
        $this->title = $title;
        $this->copy_right = $copy_right;
        $this->msg = $msg;

    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $set = \App\Setting::siteSettings(array('siteTitle','cu_email'));
        $data['msg'] = $this->msg;
        return $this->from($set['cu_email'], $set['siteTitle'])
            ->subject($set['siteTitle'])
            ->view('mails.message',$data);
    }
}
