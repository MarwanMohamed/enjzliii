<?php $user_id=session('user')['id']; ?>
<table class="table table-stripeds">
    <thead>
    <tr>
        <th>رقم العملية</th>
        <th>القيمة</th>
        <th class="hidden-xs">التفاصيل</th>
        <th>تاريخ العملية</th>
    </tr>
    </thead>
    <tbody id="transactionContent">
    @foreach($transactions as $transaction)
        @if($user_id==$transaction->reciever_id)
            <tr>
                <td>
                    <p>{{$transaction->id}}</p>
                </td>
                <td>
                    <span>${{$transaction->amount_send}}<i class="icon-plus"></i></span>
                </td>
                <td class="hidden-xs">
                    {{--<span>{{($transaction->sender_id)?'داخلي':'خارجي'.$transaction->id}}</span>--}}
                    <span>{{($transaction->process_type == 1)?($transaction->transaction_type==1?'سحب باي بال':'سحب فيزا'):(($transaction->process_type == 2)?($transaction->transaction_type==1?'شحن باي بال':'شحن فيزا'):($transaction->process_type == 3?($transaction->transaction_type==1?'دفع باي بال':'دفع فيزا'):'-'))}}</span>
                </td>
                <td>
                    <span>{{date('Y-m-d',strtotime($transaction->created_at))}}</span>
                </td>
            </tr>
        @else
            <tr>
                <td>
                    <p>{{$transaction->id}}</p>
                </td>
                <td>
                    <span class="minissaw">${{$transaction->amount_send}}<i class="icon-minus2"></i></span>
                </td>
                <td class="hidden-xs">
                    {{--<span>ANJZLY651675{{'  '.$transaction->id}}</span>--}}
                    <span>{{($transaction->process_type == 1)?($transaction->transaction_type==1?'سحب باي بال':'سحب فيزا'):(($transaction->process_type == 2)?($transaction->transaction_type==1?'شحن باي بال':'شحن فيزا'):($transaction->process_type == 3?($transaction->transaction_type==1?'دفع باي بال':'دفع فيزا'):'-'))}}</span>
                </td>
                <td>
                    <span>{{date('Y-m-d',strtotime($transaction->created_at))}}</span>
                </td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
<div class="text-center">
    {{--<i class="fa fa-spin fa-spinner Loader"></i>--}}
{{ $transactions->links() }}
</div>