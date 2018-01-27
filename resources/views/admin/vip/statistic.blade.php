@extends('admin._layout2')
<?php global $setting; ?>

@section('title','مشاريع super')
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
        
        <h2 class='title-head'>طلبات</h2>
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-success  panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                   <img width=60 src="/panel/images/project.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">آخر يوم</small>
                    <h1>{{$dayP}} </h1>مشروع
                  </div>
                </div><!-- row -->
                
               
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-primary  panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                     <img width=60 src="/panel/images/project.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">اخر اسبوع</small>
                    <h1>{{$weekP}}</h1>مشروع
                  </div>
                </div><!-- row -->
                
              
                  
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-info  panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                     <img width=60 src="/panel/images/project.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">اخر شهر</small>
                    <h1>{{$monthP}}</h1>مشروع
                  </div>
                </div><!-- row -->
                
             
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-dark  panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                     <img width=60 src="/panel/images/project.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">الكل</small>
                    <h1>{{$allP}}</h1>مشروع
                  </div>
                </div><!-- row -->
                
               
                </div><!-- row -->
                  
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        
      </div><!-- row -->
      </div>


   <div class="panel panel-default">
            <div class="panel-body">
   <div class="row">
        
        <h2 class='title-head'>مشاريع super</h2>
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-success  panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                   <img width=60 src="/panel/images/project.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">آخر يوم</small>
                    <h1>{{$day->count()}} </h1>مشروع
                  </div>
                </div><!-- row -->
                
               
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-primary  panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                     <img width=60 src="/panel/images/project.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">اخر اسبوع</small>
                    <h1>{{$week->count()}}</h1>مشروع
                  </div>
                </div><!-- row -->
                
              
                  
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-info  panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                     <img width=60 src="/panel/images/project.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">اخر شهر</small>
                    <h1>{{$month->count()}}</h1>مشروع
                  </div>
                </div><!-- row -->
                
             
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        
        <div class="col-sm-6 col-md-3">
          <div class="panel panel-dark  panel-stat costum-panel">
            <div class="panel-heading">
              
              <div class="stat">
                <div class="row">
                  <div class="col-xs-12 first">
                     <img width=60 src="/panel/images/project.png" alt="" />
                  </div>
                  <div class="col-xs-12 second">
                    <small class="stat-label">الكل</small>
                    <h1>{{$all->count()}}</h1>مشروع
                  </div>
                </div><!-- row -->
                
               
                </div><!-- row -->
                  
              </div><!-- stat -->
              
            </div><!-- panel-heading -->
          </div><!-- panel -->
        </div><!-- col-sm-6 -->
        
        
      </div><!-- row -->
      </div>



<div class='row'>
    <div class="col-sm-12">
	<div class="table-responsive">
		<table class="table table-bordered mb30">
			<thead>
				<tr>
					<th>#</th>
					<th>البريد الإلكتروني	</th>
					<th>التخصص</th>
					<th>تاريخ الانشاء</th>
				</tr>
			</thead>
			<tbody>
				@foreach($last5 as $key=> $value)
				<tr>
					<td>{{$key+1}}</td>
					<td>{{str_limit($value->email,50)}}</td>
					<td>{{str_limit($value->specialization->name,50)}}</td>
					<td class=date>{{$value->created_at}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
   <div class="col-sm-6">
      <div class="panel panel-default">
            <div class="panel-body">
              <h5 class="title-head">المسجلين اخر شهر</h5>
              <div class='clearfix'>
              </div>

              <div id="basicflot" style="width: 100%; height: 300px; margin-bottom: 20px"></div>
           
           </div><!-- panel -->
       </div>
    </div><!-- panel -->
          
  
    
</div>


<!-- row -->
<!-- 
<div class='row'>
    
   <div class="col-sm-6">
      <div class="panel panel-default">
            <div class="panel-body">
     <h5 class="title-head">المشاريع في اخر شهر</h5>
              <div class='clearfix'>
              </div>

                  <div id="basicflot" style="width: 100%; height: 300px; margin-bottom: 20px"></div>
           
          </div><!-- panel -->
               </div>
          </div><!-- panel -->
          
      
  
<!--   <div class="col-sm-6">
          
          <div class="panel panel-default">
            <div class="panel-body">
            <h5 class="subtitle mb5">المتصلين حاليا</h5>
            <div id="donut-chart2" class="ex-donut-chart"></div>

            </div><!-- panel-body -->
          </div><!-- panel -->
          
        </div><!-- col-sm-3 --> -->
</div> -->


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
         label: "عدد المشاريع",
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
