<?php

namespace App\Mail;

use App\setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmEmail extends Mailable
{

    use Queueable, SerializesModels;

    public $link;
    public $site_name;
    public $title;
    public $copy_right;
    public $setting;
    public $type;
    public $msg;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link_code, $type = 1)
    {

        $this->setting = $setting = setting::siteSettings(['siteName', 'copyRights', 'siteTitle', 'cu_email', 'cu_email_cc']);
        $this->site_name = $setting['siteName'];
        $this->title = $setting['siteTitle'];
        $this->type = $type;
        $this->copy_right = $setting['copyRights'];
        $link_to_href = url('/') . '/confirmEmail/' . $link_code;
        if ($type == 3) {
            $link_to_href = url('/') . '/resetPass/' . $link_code;
            $this->link = '<a href="' . $link_to_href . '" style="text-decoration: blink; background: #d04d39; padding: 10px 15px; color: #fff;">لإعادة تعين كلمة المرور اضغط هنا</a>';
        } else if ($type == 1) {
            $this->link = '<a href="' . $link_to_href . '" style="text-decoration: blink; background: #d04d39; padding: 10px 15px; color: #fff;">لتأكيد البريد الإلكتروني اضغط هنا</a>';
        } else if ($type == 5) {
            $link_to_href = url('/') . '/resetPass/' . $link_code;
            $this->link = '<a href="' . $link_to_href . '" style="text-decoration: blink; background: #d04d39; padding: 10px 15px; color: #fff;">تعين كلمةالمرور</a>';
            $this->msg = 'لقد تم تسجيل حسابك من قبل الإدارة اضغط على الرابط ادناه لتعين كلمة المرور';
        } else if ($type == 6) {
            $link_to_href = url('/') . '/resetPass/' . $link_code;
            $this->link = '<a href="' . $link_to_href . '" text-decoration: blink; background: #d04d39; padding: 10px 15px; color: #fff;">تعين كلمةالمرور</a>';
            $this->msg = 'لقد تم انشاء حساب vip خاص بك في موقع انجزلي ,' . 'اضغط على الرابط ادناه لتعين كلمة المرور';
        } else {
            $this->link = '<a href="' . $link_to_href . '" style="text-decoration: blink; background: #d04d39; padding: 10px 15px; color: #fff;">' . $link_to_href . '</a>';
        }
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
        $title = 'تأكيد البريد الإكتروني';
        switch ($this->type) {
            case 1:
                $title = 'تأكيد البريد الإكتروني';
                break;
            case 3:
                $title = 'نسيت كلمة المرور';
                break;
            case 4:
                $title = 'نسيت كلمة المرور';
                break;
            case 5:
                $title = 'تعين كلمة المرور';
                break;
        }
        $set = \App\Setting::siteSettings(array('siteTitle', 'cu_email'));
        $data['welcome'] = 'مرحبا،';
        $data['welcomeDesc'] = 'لقد تلقينا طلبك لإعادة تعيين كلمة المرور. يمكنك النقر على الزر أدناه';
        $data['pass'] = 'pass';
        if($this->type == 1){
            $data['welcomeDesc'] = 'لقد تلقينا طلبك   لتأكيد البريد الإلكتروني للتأكيد اضغط هنا. يمكنك النقر على الزر أدناه';
        }

        return $this->from($from_mail, $title . ' -' . $set['siteTitle'])
            ->subject($title . ' -' . $set['siteTitle'])
            ->view('mails.contact', $data);
    }
}
