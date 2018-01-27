<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class contact extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $title;
    public $msg;
    public $email;
    public $problem;
    public $urlTo;

    public function __construct($email,$problem,$title,$msg,$urlTo='')
    {
        //
        
        $this->title = $title;
        $this->msg = $msg;
        $this->email = $email;
        $this->problem = $problem;
        $this->urlTo = $urlTo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data['setting'] = \App\Setting::siteSettings();
        $set = \App\Setting::siteSettings(array('siteTitle','cu_email'));
        $data['msg'] = $this->msg;

        return $this->from($set['cu_email'], $set['siteTitle'])
            ->subject($this->title?:$set['siteTitle'])
            ->view('mails.contact',$data);
    }
}
