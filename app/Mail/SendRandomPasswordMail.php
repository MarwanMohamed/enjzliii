<?php

namespace App\Mail;

use App\setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendRandomPasswordMail extends Mailable
{

    use Queueable, SerializesModels;

    public $link;
    public $site_name;
    public $title;
    public $copy_right;
    public $setting;
    public $email;
    public $password;
    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $password)
    {

        $this->setting = $setting = setting::siteSettings(['siteName', 'copyRights', 'siteTitle', 'cu_email', 'cu_email_cc']);
        $this->site_name = $setting['siteName'];
        $this->email = $email;
        $this->password = $password;
        
        $this->title = $setting['siteTitle'];
        $this->copy_right = $setting['copyRights'];
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (($this->setting['cu_email'])) {
            $from_mail = $this->setting['cu_email'];
        } else {
            $from_mail = 'abedmq2@gmail.com';
        }
        $title = 'كلمه المرور الافتراضيه';
        
        $set = \App\Setting::siteSettings(array('siteTitle', 'cu_email'));
        $data['welcome'] = 'مرحبا،';
        $data['welcomeDesc'] = 'لقد تلقينا طلبكم لانشاء حساب من قبل الاداره و لتنفيذ طلبكم قم بنسخ و لصق البيانات الموضحه ادناه و بعد ذلك قم بتغيير كلمه المرور لشئ يسهل تذكره';
        $data['welcomeDesc'] .= '<hr><p><strong> الايميل </strong> ';   
        $data['welcomeDesc'] .= $this->email . '<br>';
        $data['welcomeDesc'] .= '<strong> الباسورد </strong>';
        $data['welcomeDesc'] .= $this->password.'</p>';
        

        return $this->from($from_mail, $title . ' -' . $set['siteTitle'])
            ->subject($title . ' -' . $set['siteTitle'])
            ->view('mails.random-password', $data);
    }
}