<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $link;
    public $site_name;
    public $title;
    public $copy_right;
    public function __construct($config)
    {
        //
        $this->site_name = $config['site_name'];
        $this->title = $config['title'];
        $this->copy_right = $config['copyright'];
        if(isset($config['type']))
            $link_to_href = url('/').'/ar/api/resetPass/'.$config['link_code'];
        else
            $link_to_href = url('/').'/admin/resetPass/'.$config['link_code'];

        $this->link = '<a href="'.$link_to_href.'" style="background-color:#178f8f;border-radius:4px;color:#ffffff;display:inline-block;font-family:Helvetica, Arial, sans-serif;font-size:16px;font-weight:bold;line-height:50px;text-align:center;text-decoration:none;width:90%;-webkit-text-size-adjust:none;">'.$link_to_href.'</a>';

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $set = \App\Setting::siteSettings(array('cu_email'));
        if(!empty($set)){
            $from_mail = $set['cu_email'];
        }else{
            $from_mail = 'abedmq2@gmail.com';
        }

        return $this->from($from_mail, 'موقع عزيز')
            ->subject('موقع عزيز - إعادة تعيم كلمة المرور')
            ->view('mails.link_message');
    }
}
