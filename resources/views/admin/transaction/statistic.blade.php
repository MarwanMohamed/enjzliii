@extends('admin._layout2')
<?php global $setting; ?>

@section('title','الدفعات المالية')
@section('subTitle','احصائيات')

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
  
  <?php
        global $setting;
        $now = \Carbon\Carbon::now()->subDays($setting['open_project_day']);
  ?>
  
</style>
     
   <div class="row">
        
        <h2 class='title-head'>صادرات</h2>
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-success panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                   <img width=60 src="/panel/images/is-money.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">آخر يوم</small>
                    <h1>{{intval ($day->where('process_type',1)->sum('amount_send'))}} </h1> دولار
                  </div>
                </div><!-- row -->
                
               
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-primary panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                     <img width=60 src="/panel/images/is-money.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">اخر اسبوع</small>
                    <h1>{{intval ($week->where('process_type',1)->sum('amount_send'))}}</h1> دولار
                  </div>
                </div><!-- row -->
                
              
                  
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-info panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                     <img width=60 src="/panel/images/is-money.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">اخر شهر</small>
                    <h1>{{intval ($month->where('process_type',1)->sum('amount_send'))}}</h1> دولار
                  </div>
                </div><!-- row -->
                
             
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-dark panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                     <img width=60 src="/panel/images/is-money.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">الكل</small>
                    <h1>{{intval ($all->where('process_type',1)->sum('amount_send'))}}</h1> دولار
                  </div>
                </div><!-- row -->
                
               
                </div><!-- row -->
                  
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        
    


 
   <div class="row">
        
        <h2 class='title-head'>واردات</h2>
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-success panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                     <img width=60 src="/panel/images/is-money.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">آخر يوم</small>
                    <h1>{{intval ($day->where('process_type',2)->sum('amount_recieve'))}} </h1>دولار
                  </div>
                </div><!-- row -->
                
               
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-primary panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                     <img width=60 src="/panel/images/is-money.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">اخر اسبوع</small>
                    <h1>{{intval ($week->where('process_type',2)->sum('amount_recieve'))}}</h1> دولار
                  </div>
                </div><!-- row -->
                
              
                  
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-info panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                     <img width=60 src="/panel/images/is-money.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">اخر شهر</small>
                    <h1>{{intval ($month->where('process_type',2)->sum('amount_recieve'))}}</h1> دولار
                  </div>
                </div><!-- row -->
                
             
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-dark panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                     <img width=60 src="/panel/images/is-money.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">الكل</small>
                    <h1>{{intval ($all->where('process_type',2)->sum('amount_recieve'))}}</h1> دولار
                  </div>
                </div><!-- row -->
                
               
                </div><!-- row -->
                  
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
    




   <div class="row">
        
        <h2 class='title-head'>رصيد انجزلي</h2>
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-success panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                     <img width=60 src="/panel/images/is-money.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">آخر يوم</small>
                    <h1>{{intval ($day->sum('amount_send')-$day->sum('amount_recieve'))}} </h1> دولار
                  </div>
                </div><!-- row -->
                
               
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-primary panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                     <img width=60 src="/panel/images/is-money.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">اخر اسبوع</small>
                    <h1>{{intval ($week->sum('amount_send')-$week->sum('amount_recieve'))}} </h1> دولار
                  </div>
                </div><!-- row -->
                
              
                  
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-info panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                     <img width=60 src="/panel/images/is-money.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">اخر شهر</small>
                    <h1>{{intval ($month->sum('amount_send')-$month->sum('amount_recieve'))}} </h1> دولار
                  </div>
                </div><!-- row -->
                
             
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-dark panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                     <img width=60 src="/panel/images/is-money.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">الكل</small>
                    <h1>{{intval ($all->sum('amount_send')-$all->sum('amount_recieve'))}} </h1> دولار
                  </div>
                </div><!-- row -->
                
               
                </div><!-- row -->
                  
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        
    




   <div class="row">
        
        <h2 class='title-head'>رصيد المستخدمين</h2>
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-success panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                     <img width=60 src="/panel/images/is-money.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">الرصيد الكلي</small>
                    <h1>{{intval ($balanceU)}} </h1> دولار
                  </div>
                </div><!-- row -->
                
               
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-primary panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                     <img width=60 src="/panel/images/is-money.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">الرصيد المعلق</small>
                    <h1>{{intval ($suspended_balanceU)}}</h1> دولار
                  </div>
                </div><!-- row -->
                
              
                  
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-info panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                     <img width=60 src="/panel/images/is-money.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">الرصيد القابل للسحب</small>
                    <h1>{{intval ($balanceU-$suspended_balanceU)}}</h1> دولار
                  </div>
                </div><!-- row -->
                
             
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->

        </div><!-- col-sm-6 -->
        
     

@endsection


@section('script')
<!-- <script src="/panel/js/morris.min.js"></script>
<script src="/panel/js/raphael-2.1.0.min.js"></script> -->
<script src="/panel/js/bootstrap.min.js"></script>
<script src="/panel/js/modernizr.min.js"></script>
<script src="/panel/js/jquery.sparkline.min.js"></script>
<script src="/paneljs/toggles.min.js"></script>
<script src="/panel/js/jquery.cookies.js"></script>
<script src="/panel/js/flot/jquery.flot.min.js"></script>
<script src="/panel/js/flot/jquery.flot.min.js"></script>
<script src="/panel/js/flot/jquery.flot.resize.min.js"></script>
<script src="/panel/js/flot/jquery.flot.spline.min.js"></script>
<script src="/panel/js/morris.min.js"></script>
<script src="/panel/js/raphael-2.1.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>

<script>
    // Donut Chart
//    var m1 = new Morris.Donut({
//         element: 'donut-chart2',
//         data: [
//           {label: "متصل", value: ,
//           {label: "غير متصل", value: },
         
//         ],
//         colors: ['#1CAF9A','#D9534F']
//     });
  
  
  
//    var m2 = new Morris.Line({
//         // ID of the element in which to draw the chart.
//         element: 'line-chart',
//         // Chart data records -- each entry in this array corresponds to a point on
//         // the chart.
//         data: data,
//         xkey: 'y',
//         ykeys: ['a'],
//      xLabels:'year',
//      xLabelFormat: function (x) {console.log(x) },
//         gridTextColor: 'rgba(255,255,255,0.5)',
//         lineColors: ['#fff', '#fdd2a4'],
//         lineWidth: '2px',
//         hideHover: 'always',
//         smooth: true,
//         grid: false
//    });
	
</script>
@endsection
