<?php global $setting;?>
@extends('front.__template')
@section('title','مشاريعي')
@section('content')
    <section class="s_404">
        <div class="container">
            <div class="heade_div404">
                <div class="heade_div2">
                    <h2>المشاريع الخاصة بي</h2>
                    <div class="left_item_header hidden">
                        <a href="#" class="red"><i class="icon-search"></i>بحث سريع</a>
                    </div>
                </div>
                <div class="item_div2">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="search">
                            <form action="{{$url}}" class='Ajaxsearch'>
                                <div class="input_ad_search">
                                    <input type="text"  name="q" value="{{$q}}" placeholder="البحث في المشاريع الخاصة بي ..">
                                    <button><i class="icon-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="item_myfav">
                    <div class="item_myfaves">
                        <ul>
                            <?php $f=(isset($fillter))?$fillter:0 ?>
                            <li><a class="{{($f===0)?'active':''}}" href="{{($f===0)?'javascript:;':'/myProjects'}}">كل المشاريع</a></li>
                            <li ><a class="{{($f==1)?'active':''}}" href="{{($f===1)?'javascript:;':'/myProjects/1'}}">بإنتظار الموافقة</a></li>
                            <li><a  class="{{($f==2)?'active':''}}" href="{{($f===2)?'javascript:;':'/myProjects/2'}}">يستقبل العروض</a></li>
                            <li><a  class="{{($f==3)?'active':''}}" href="{{($f===3)?'javascript:;':'/myProjects/3'}}">قيد التنفيذ</a></li>
                             <li ><a  class="{{($f==4)?'active':''}}" href="{{($f===4)?'javascript:;':'/myProjects/4'}}">الملغاة</a></li>
                            <li><a  class="{{($f==5)?'active':''}}" href="{{($f===5)?'javascript:;':'/myProjects/5'}}">المغلقة</a></li>
                             <li><a  class="{{($f==6)?'active':''}}" href="{{($f===6)?'javascript:;':'/myProjects/6'}}">المكتملة</a></li>
                             <li><a  class="{{($f==7)?'active':''}}" href="{{($f===7)?'javascript:;':'/myProjects/7'}}">محظور</a></li>
                        </ul>
                        <div class="tabl_myfacv">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>المشاريع</th>
                                    <th class="hidden-xs">العروض</th>
                                    <th>الميزانية</th>
                                    <th class="hidden-xs">مدة التنفيذ</th>
                                </tr>
                                </thead>
                                <tbody class='publicContent'>
                                  @include('my.ajaxProject')

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @if(!sizeof($projects))
                    <div class="searchError pagi">
                        <span class="">لا يوجد أي مشاريع </span>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <section class="s_profile">
        <div class="container">
                    @include('pagination.limit_links', ['paginator' => $projects])
        </div>
    </section>
@endsection
@section('script')
    <script>

    </script>
@endsection