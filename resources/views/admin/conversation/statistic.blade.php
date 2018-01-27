@extends('admin._layout2')
<?php global $setting; ?>

@section('title','المراسلات')
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
  
</style>
     
   <div class="row">
        
        <h2 class='title-head'>جديد</h2>
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-success panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                    <img src="/panel/images/is-document.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">اليوم</small>
                    <h1>{{$day}} </h1>محادثة
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
                    <img src="/panel/images/is-document.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">الاسبوع</small>
                    <h1>{{$week}}</h1>محادثة
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
                    <img src="/panel/images/is-document.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">الشهر</small>
                    <h1>{{$month}}</h1>محادثة
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
                    <img src="/panel/images/is-document.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">الكل</small>
                    <h1>{{$all}}</h1>محادثة
                  </div>
                </div><!-- row -->
                
               
                </div><!-- row -->
                  
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
  

<div class='row'>
    
   <div class="col-sm-6 col-md-8">
      <div class="panel panel-default">
            <div class="panel-body">
     <h5 class="title-head">المراسلات اخر شهر</h5>
              <div class='clearfix'>
              </div>

                  <div id="basicflot" style="width: 100%; height: 300px; margin-bottom: 20px"></div>
           
          </div><!-- panel -->
               </div>
          </div><!-- panel -->
          
      
<div class="col-sm-6 col-md-4">
          <div class="panel panel-default panel-alt widget-messaging">
          <div class="panel-heading">
              
              <h3 class="panel-title">المراسلات</h3>
            </div>
            <div class="panel-body">
              <ul>
                @foreach($last5 as $value)
                <li>
                  <a href='/admin/conversations/single/{{$value->id}}'>
                  <small class="pull-right">{{dateToString($value->lastMessage[0]->created_at)}}</small>
                  <h4 class="sender">{{$value->lastMessage[0]->sender->fullname()}}</h4>
                  <small>{{str_limit($value->lastMessage[0]->content,100) }} </small>
                  </a>
                </li>
             @endforeach
              </ul>
            </div><!-- panel-body -->
          </div><!-- panel -->
        </div>


  
</div>



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
  
  data=[];
  var d = new Date();
var n = d.getMonth();
  max=0;
  var statistic={!!json_encode($grouped)!!};
  days=new Date( d.getYear(),  d.getMonth(), 0).getDate();
  for(var i=1;i<=days;i++){
    var temp=statistic[i]?statistic[i]:0;
    if(max<temp){
      max=temp;
    }
    data.push( [ i, temp  ]);
  }

  
	var plot = jQuery.plot(jQuery("#basicflot"),
		[{ data: data,
         label: "عدد العروض",
         color: "#1CAF9A"
        },
      
      ],
      {
			series: {
				lines: {
					show: false
				},
				splines: {
					show: true,
					tension: 0.5,
					lineWidth: 1,
					fill: 0.45
				},
				shadowSize: 0
			},
			points: {
				show: true
			},
		  legend: {
          position: 'nw'
        },
		  grid: {
          hoverable: true,
          clickable: true,
          borderColor: '#ddd',
          borderWidth: 1,
          labelMargin: 10,
          backgroundColor: '#fff'
        },
		  yaxis: {
          min: 0,
          max: max,
          color: '#eee'
        },
        xaxis: {
          color: '#eee'
        }
		});
		
  
  
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
