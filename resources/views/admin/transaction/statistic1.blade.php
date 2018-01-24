@extends('admin._layout')
<?php global $setting; ?>

@section('title','الدفعات المالية')
@section('subTitle','احصائيات الموقع')

@section('content')
@if(session()->has('msg'))
<div class="form-group">
    <div class="alert alert-info">{{session()->get('msg')}}</div>
</div>
@endif

<style>
    th a {
        width: 100%;
        height: 100%;
        color: #000;
        display: block;
        font-size: 16px;
    }
</style>
     
   <div class="row">
        
        
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-success panel-stat">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-4">
                    <img src="/panel/images/is-money.png" alt="" />
                  </div>
                  <div class="col-xs-8">
                    <small class="stat-label">رصيد الموقع</small>
                    <h1>{{$intTrans->sum('amount_send')-$intTrans->sum('amount_recieve')}}</h1>
                  </div>
                </div><!-- row -->
                
                <div class="mb15"></div> 
                
                <div class="row">
                  <div class="col-xs-6">
                    <small class="stat-label">أخر اسبوع</small>
                    <h4>{{$intTransLW->sum('amount_send')-$intTransLW->sum('amount_recieve')}}</h4>
                  </div>
                  
                  <div class="col-xs-6">
                    <small class="stat-label">أخر شهر</small>
                    <h4>{{$intTransLM->sum('amount_send')-$intTransLM->sum('amount_recieve')}}</h4>
                  </div>
                </div><!-- row -->
                  
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
            
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-primary panel-stat">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-4">
                    <img src="/panel/images/is-money.png" alt="" />
                  </div>
                  <div class="col-xs-8">
                    <small class="stat-label">واردات الموقع</small>
                    <h1>{{$inTrans->sum('amount_recieve')}}</h1>
                  </div>
                </div><!-- row -->
                
                <div class="mb15"></div> 
                
                <div class="row">
                  <div class="col-xs-6">
                    <small class="stat-label">أخر اسبوع</small>
                    <h4>{{$inTransLW->sum('amount_recieve')}}</h4>
                  </div>
                  
                  <div class="col-xs-6">
                    <small class="stat-label">أخر شهر</small>
                    <h4>{{$inTransLM->sum('amount_recieve')}}</h4>
                  </div>
                </div><!-- row -->
                  
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-info panel-stat">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-4">
                    <img src="/panel/images/is-money.png" alt="" />
                  </div>
                  <div class="col-xs-8">
                    <small class="stat-label">صادرات الموقع</small>
                    <h1>{{$outTrans->sum('amount_send')}}</h1>
                  </div>
                </div><!-- row -->
                
                <div class="mb15"></div> 
                
                <div class="row">
                  <div class="col-xs-6">
                    <small class="stat-label">أخر اسبوع</small>
                    <h4>{{$outTransLW->sum('amount_send')}}</h4>
                  </div>
                  
                  <div class="col-xs-6">
                    <small class="stat-label">أخر شهر</small>
                    <h4>{{$outTransLM->sum('amount_send')}}</h4>
                  </div>
                </div><!-- row -->
                  
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-dark panel-stat">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-4">
                    <img src="/panel/images/is-money.png" alt="" />
                  </div>
                  <div class="col-xs-8">
                    <small class="stat-label">ارصدة المستخدمين</small>
                    <h1>{{$user->sum('balance')}}</h1>
                  </div>
                </div><!-- row -->
                
                <div class="mb15"></div> 
                
                <div class="row">
                  <div class="col-xs-6">
                    <small class="stat-label">الرصيد المعلق</small>
                    <h4>{{$user->sum('suspended_balance')}}</h4>
                  </div>
                  
                  <div class="col-xs-6">
                    <small class="stat-label">الرصيد المتاح للسحب</small>
                    <h4>{{$user->sum('balance')-$user->sum('suspended_balance')}}</h4>
                  </div>
                </div><!-- row -->
                  
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        
      </div><!-- row -->


@endsection
