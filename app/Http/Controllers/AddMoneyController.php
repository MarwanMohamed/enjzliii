<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\user;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use URL;
use Session;
use Redirect;
use Illuminate\Support\Facades\Input;
/** All Paypal Details class * */
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class AddMoneyController extends Controller
{

    private $_api_context;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        /** setup PayPal api context * */
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    /**
     * Show the application paywith paypalpage.
     *
     * @return \Illuminate\Http\Response
     */
    public function payout(Request $request)
    {
        
        $withdrawRequest = \App\withdrawRequest::find($request->id);
        if ($withdrawRequest) {
            if ($withdrawRequest->status == 1) {
                // dd($withdrawRequest->amount );
                $user = user::find($withdrawRequest->user_id);
                $id = $request->id;
                if ($user) {
                    if (($user->balance - $user->suspended_balance) >= $withdrawRequest->amount) {
                        $payouts = new \PayPal\Api\Payout();
                        
                        $senderBatchHeader = new \PayPal\Api\PayoutSenderBatchHeader();

                        $senderBatchHeader->setSenderBatchId(uniqid())
                            ->setEmailSubject("تحويل من موقع انجزلي");

                        $senderItem = new \PayPal\Api\PayoutItem();
                        $senderItem->setRecipientType('email')
                            ->setNote('نشكر ثقتك بنا')
                            ->setReceiver($withdrawRequest->paypalEmail)
                            ->setSenderItemId($withdrawRequest->id)
                            ->setAmount(new \PayPal\Api\Currency('{
                        "value":"' . $withdrawRequest->amount . '",
                        "currency":"USD"
                    }'));
            
                        $payouts->setSenderBatchHeader($senderBatchHeader)
                            ->addItem($senderItem);
                           
                       // $request = clone $payouts;
                        
//==================================================== Ahmed Gad Was Here ;)  ==========================================================

                        /*try {
                            
                            //$payouts->create([],$this->_api_context);
                            $payouts->create(["sync_mode"=>"false" ],$this->_api_context);
                        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
                            echo $ex->getCode(); // Prints the Error Code
                            echo $ex->getData(); // Prints the detailed error message 
                            die($ex);
                        } catch (Exception $ex) {
                            die($ex);
                        }*/
                        
//==================================================== And Gone From Here ;)  ==========================================================


                        try {
                           $output = $payouts->create(null,$this->_api_context);
                           // dd($output);
                        } catch (Exception $ex) {
                            
                            dd('yesss '.$ex);
                        }

                        $status = ($output->getItems()[0]->transaction_status);

                        if ($status == 'SUCCESS') {
                            \App\withdrawRequest::where('id', $id)->update(['status' => 2]);
                            session()->flash('msg', 'تمت عملية التحويل بنجاح');
                            $transactionInfo['payout_item_id'] = $output->getItems()[0]->payout_item_id;
                            $transactionInfo['transaction_id'] = $output->getItems()[0]->transaction_id;
                            \App\transaction::insert(['transaction_type'=>1,'process_type'=>1,'sender_id' => 0, 'reciever_id' => $withdrawRequest->user_id, 'amount_send' => $withdrawRequest->amount, 'transactionInfo' => json_encode($transactionInfo),'created_at'=>\Carbon\Carbon::now()]);
                            user::where('id', $withdrawRequest->user_id)->update(['balance' => \DB::raw('balance-' . $withdrawRequest->amount)]);
                            \App\notifcation::addNew(11, 0,  $withdrawRequest->user_id, 'رسالة ادارية', 'تم الموافقة على عملية سحب الرصيد لمبلغ وقدره :' . "$withdrawRequest->amount $" , 0);

                        } else {
                            session()->flash('error', 'حصل خطأ أثناء عملية التحويل' . $output->getItems()[0]->errors->message);

                        }
                    } else {
                        session()->flash('error', 'لا يوجد لدى المستخدم رصيد كافي');


                    }
                    return redirect()->back();
                } else {
                    abort(404);
                }
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function payWithPaypal()
    {
        return view('paywithpaypal');
    }

    function requestVisa()
    {
        $url = "https://test.oppwa.com/v1/checkouts";
        $data = "authentication.userId=8a8294174d0595bb014d05d829e701d1" .
            "&authentication.password=9TnJPc2n9h" .
            "&authentication.entityId=8a8294174d0595bb014d05d82e5b01d2" .
            "&currency=USD";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }

        curl_close($ch);
        $response = json_decode($responseData);
        $checkoutId = $response->id;
        return view('my/visa', compact('checkoutId'));
    }


    function visaReturn(Request $request)
    {
        global $setting;
        $rs = verify_payment($request->payment_reference);
        if ($rs->response_code == 100) {
            $amountAfter = ((100*$rs->amount ) / ($setting['site_rate_external']+100));
            $transactionType = 2;
            \App\transaction::transfer(0, session('user')['id'],$amountAfter,$amountAfter,2,$transactionType);
            
            /** it's all right * */
            /** Here Write your database logic like that insert record or value in database if you want * */
            \Session::flash('paySuccess', $amountAfter.'لقد تم بنجاح شحن حسابكم فى موقع انجزلي بمبلغ قدره ');
            \Session::flash('paySuccessTitle','تم عملية الشحن');
            \Session::flash('amount', $amountAfter);
            user::where('id', session('user')['id'])->update(['balance' => DB::raw('balance+' .($amountAfter))]);
        } else if ($rs->response_code == 481 || $rs->response_code == 481) {
            \Session::flash('payErrorTitle', 'فشلت عملية الدفع');
            \Session::flash('payError', 'حصل خطأ أثناء عملية الدفع سيتم مراجعة العملية والرد عليك');
        } else if ($rs->response_code == 0) {
            \Session::flash('canceledPayment', $rs->result);
        }  else if ($rs->response_code == 804) {
            \Session::flash('payErrorTitle', 'فشلت عملية الدفع');
            \Session::flash('payError', 'بيانات البطاقة الائتمانية غير صالحة , يرجى محاولة الدفع من بطاقة أخرى');
        } else {
            \Session::flash('paySuccess', $rs);

        }

        return redirect('/balance');

    }


    function VisaReturn1(Request $request)
    {
        $url = "https://test.oppwa.com/v1/checkouts/" . $request->id . "/payment";
        $url .= "?authentication.userId=8a8294174d0595bb014d05d829e701d1";
        $url .= "&authentication.password=9TnJPc2n9h";
        $url .= "&authentication.entityId=8a8294174d0595bb014d05d82e5b01d2";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            \Session::flash('payErrorTitle', 'عذراً..العملية مرفوضة');
            \Session::flash('payError', 'حصل خطأ غير معروف اثناء عملية الشحن الرجاء المحاولة لاحقا');
            return redirect('/balance');

        }
        /** dd($result);exit; /** DEBUG RESULT, remove it later * */
        global $setting;
        $responseData = json_decode($responseData);
// $amountAfter = ($responseData->amount * (100 -       $setting['site_rate_external']) / 100);
        $amountAfter = ((100*$responseData->amount) / ($setting['site_rate_external']+100));

        $transactionType = 2;
        \App\transaction::transfer(0, session('user')['id'], $responseData->amount, $amountAfter,2, $transactionType);
        /** it's all right * */
        /** Here Write your database logic like that insert record or value in database if you want * */
        \Session::flash('paySuccess', $responseData->amount.'لقد تم بنجاح شحن حسابكم على انجزلي بمبلغ قدره ');
        \Session::flash('paySuccessTitle','تم عملية الشحن');
        \Session::flash('amount', $responseData->amount);
        user::where('id', session('user')['id'])->update(['balance' => DB::raw('balance+' . $responseData->amount)]);

        return redirect('/balance');
    }


    /**
     * Store a details of payment with paypal.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postPaymentWithpaypal(Request $request)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName('شحن')/** item name * */
        ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->get('amount'));
        /** unit price * */
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request->get('amount'));
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('دفع عن طريق موقع انجزلي');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('payment.status'))/** Specify return URL * */
        ->setCancelUrl(URL::route('payment.status'));
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; * */
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                return Redirect::route('addmoney.paywithpaypal');
                /** echo "Exception: " . $ex->getMessage() . PHP_EOL; * */
                /** $err_data = json_decode($ex->getData(), true); * */
                /** exit; * */
            } else {
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::route('addmoney.paywithpaypal');
                /** die('Some error occur, sorry for inconvenient'); * */
            }
        }catch (Exception $ex) {
            die($ex);
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session * */
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal * */
            return Redirect::away($redirect_url);
        }
        \Session::put('error', 'Unknown error occurred');
        return Redirect::route('addmoney.paywithpaypal');
    }

    public function postPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'method' => 'required|integer|between:1,2',
            'amount' => 'required|integer|min:1',
        ], [
            'amount.min' => 'اقل مبلغ يمكن اضافته هو 10 دولار'
        ]);
        if ($validator->fails()) {
            $json = [
                'status' => 0,
                'msg' => implode(',', $validator->errors()->all())
            ];
        } else {
            global $setting;
            $json['method'] = $request->get('method');
            $amountAddFee = $request->amount + ($request->amount * 0.029);
// 	dd($request->amount*$setting['site_rate_external']);
            if ($request->get('method') === "1") {
                $payer = new Payer();
                $payer->setPaymentMethod('paypal');
                $item_1 = new Item();
                $item_1->setName('شحن رصيد')/** item name * */
                ->setCurrency('USD')
                    ->setQuantity(1)
                    ->setPrice($amountAddFee);
                /** unit price * */
                $item_list = new ItemList();
                $item_list->setItems(array($item_1));
                $amount = new Amount();
                $amount->setCurrency('USD')
                    ->setTotal($amountAddFee);
                $transaction = new Transaction();
                $transaction->setAmount($amount)
                    ->setItemList($item_list)
                    ->setDescription('اضافة رصيد الى حسابك في موقع انجزلي');
                $redirect_urls = new RedirectUrls();
                $redirect_urls->setReturnUrl(URL::route('payment.successPayment'))/** Specify return URL * */
                ->setCancelUrl(URL::route('payment.successPayment'));
                $payment = new Payment();
                $payment->setIntent('Sale')
                    ->setPayer($payer)
                    ->setRedirectUrls($redirect_urls)
                    ->setTransactions(array($transaction));
                /** dd($payment->create($this->_api_context));exit; * */
                try {
                    $payment->create($this->_api_context);
                } catch (\PayPal\Exception\PPConnectionException $ex) {
                    if (\Config::get('app.debug')) {
                        \Session::put('error', 'Connection timeout');
                        $json['status'] = 0;
                        $json['msg'] = 'فشل الإتصال بخادم paypal';
                        /** echo "Exception: " . $ex->getMessage() . PHP_EOL; * */
                        /** $err_data = json_decode($ex->getData(), true); * */
                        /** exit; * */
                    } else {
                        \Session::put('error', 'Some error occur, sorry for inconvenient');
                        $json['status'] = 0;
                        $json['msg'] = 'حصل خطأ اثناء اعداد الإتصال';
                        /** die('Some error occur, sorry for inconvenient'); * */
                    }
                }
                foreach ($payment->getLinks() as $link) {
                    if ($link->getRel() == 'approval_url') {
                        $redirect_url = $link->getHref();
                        break;
                    }
                }
                /** add payment ID to session * */
                $json['approval_url'] = $redirect_url;
                $json['approval_urls'] = implode(',', $payment->getLinks());
                Session::put('paypal_payment_id', $payment->getId());
                if (isset($redirect_url)) {
                    /** redirect to paypal * */
                    $json['status'] = 1;
                    $json['msg'] = 'سيتم تحويلك الى صفحة paypal لاكمال عملية الدفع';
                    $json['url'] = $redirect_url;
                } else {
                    $json['status'] = 0;
                    $json['msg'] = 'حصل خطأ غير متوقع الرجاء المحاولة مرة اخرى';
                }
            } else {
                $user = session('user');


                $rs = get_payment_link($user['fname'], $user['lname'], $user['email'], 'شحن رصيد', $request->amount, $currency = 'SAR');
                if ($rs->response_code == 4012) {
                    $json['msg'] = 'سيتم تحويلك الى صفحة paytabs لاكمال عملية الدفع';
                    $json['status'] = 1;
                    $json['url'] = $rs->payment_url;
                } else {
                    $json['msg'] = $rs->result;
                    $json['status'] = 0;
                }
                return response($json);
            }
        }
        return response()->json($json);
    }


    function successPayment(Request $request)
    {
    
   
        /** Get the payment ID before session clear * */
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID * */
        Session::forget('paypal_payment_id');
        //if ((!$request['PayerID']) || (!$request['token'])) {
        if(empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::flash('payErrorTitle', 'عذراً..العملية مرفوضة');
            \Session::flash('payError', 'حصل خطأ غير معروف اثناء عملية الشحن الرجاء المحاولة لاحقا');
            return redirect('/balance');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        /** PaymentExecution object includes information necessary * */
        /** to execute a PayPal account payment. * */
        /** The payer_id is added to the request query parameters * */
        /** when the user is redirected from paypal back to your site * */
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /** Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        if($result == null) {
            \Session::flash('payErrorTitle', 'عذراً..العملية مرفوضة');
            \Session::flash('payError', 'حصل خطأ غير معروف اثناء عملية الشحن الرجاء المحاولة لاحقا');
            return redirect('/balance');
        }
        /** DEBUG RESULT, remove it later **/
        if ($result->getState() == 'approved') {
            //global $setting;
            $amountAfter = ((100*$result->transactions[0]->amount->total ) / (2.9+100));

            $transactionType = 1;
           \App\transaction::transfer(0, session('user')['id'], $amountAfter, $amountAfter,2,$transactionType);
           
            /** it's all right $result->transactions[0]->amount->total* */
            /** Here Write your database logic like that insert record or value in database if you want * */
            
            \Session::flash('paySuccess', 'لقد تم بنجاح شحن حسابكم على انجزلي بمبلغ قدره ');
            \Session::flash('paySuccessTitle','تم عملية الشحن');
            \Session::flash('amount', $amountAfter);
            
           user::where('id', session('user')['id'])->update(['balance' => DB::raw('balance+' . ($amountAfter))]);
            
            return redirect('/balance');
        }
            
        \Session::flash('payErrorTitle', 'عذراً..العملية مرفوضة');
        \Session::flash('payError', 'حصل خطأ غير معروف اثناء عملية الشحن الرجاء المحاولة لاحقا');
        return redirect('/balance');
    }

    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear * */
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID * */
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::flash('error', 'Payment failed');
            return Redirect::route('addmoney.paywithpaypal');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        /** PaymentExecution object includes information necessary * */
        /** to execute a PayPal account payment. * */
        /** The payer_id is added to the request query parameters * */
        /** when the user is redirected from paypal back to your site * */
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /** Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        /** dd($result);exit; /** DEBUG RESULT, remove it later * */
        //dd($result);
        if ($result->getState() == 'approved') {

            /** it's all right * */
            /** Here Write your database logic like that insert record or value in database if you want **/
            
            \Session::flash('success', 'Payment success');
            return Redirect::route('addmoney.paywithpaypal');
        }
        \Session::flash('error', 'Payment failed');
        return Redirect::route('addmoney.paywithpaypal');
    }

}
