<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    //
    protected $table = 'transaction';

    static function transfer($sender_id,$reciever_id,$cost,$dues,$process_type,$transactionType){
        $transaction=new transaction();
        $transaction->sender_id=$sender_id;
        $transaction->amount_send=$cost;
        $transaction->amount_recieve=$dues;
        $transaction->reciever_id=$reciever_id;
        $transaction->process_type=$process_type;
        $transaction->transaction_type=$transactionType;
        $transaction->created_at=\Carbon\Carbon::now();
        $transaction->save();
    }
    
    function sender(){
        return $this->hasOne('App\user','id','sender_id');
    }
    
    
    function reciever(){
        return $this->belongsTo('App\user','reciever_id','id');
    }

}
