@extends('admin._layout')

@section('title','الصلاحيات')
@section('subTitle','تعديل')
<style>
    .checkbox.block.child {
        margin-right: 27px;
    }
    .checkbox.block.depend {
        margin-right: 50px;
    }
</style>

@section('content')
    @if(session()->has('msg'))
        <div class="form-group">
            <div class="alert alert-info">{{session()->get('msg')}}</div>
        </div>
    @endif
    <form  method="post" class=" form-horizontal form-bordered" action="/admin/control/editGroup">
        <input type="hidden" name="id" value="{{$group->id}}">
		  <div class="form-group">
            <label class="col-sm-3 control-label">العنوان</label>
            <div class="col-sm-6">
                <input type="text" required class="form-control"  name="name"  value="{{$group->name}}" placeholder="ادخل عنوان المجموعة">
            </div>
        </div>

        <<div class="form-group">
            <label class="col-sm-3 control-label" for="checkbox">الصلاحيات</label>
            <div class="col-sm-6">
                @foreach($controllers as $controller)
                    <div class="controller">
                        <div class="checkbox block parent"><label><input type="checkbox" >{{$controller->name}}</label></div>
                        @foreach($controller->fun as $function)
                            @if(!$function->dependent)
                                <div class="checkbox block child"><label><input type="checkbox" {{($function->havePermission)?'checked':''}} name="functions[]" value="{{$function->id}}" >{{$function->name}}</label></div>
                            @else
                                <div class="checkbox block child depend"><label><input  {{($function->havePermission)?'checked':''}} type="checkbox" name="functions[]" value="{{$function->id}}" >{{$function->name}}</label></div>
                            @endif
                                @endforeach
                    </div>
                @endforeach

            </div>
        </div>

        {{csrf_field()}}
        <div class="form-group">
            <button type="submit"  class="btn btn-success col-xs-2 col-sm-offset-4">حفظ<span class="fa fa-spinner fa-spin hidden " id="my-spinner"></span></button>
        </div>
    </form>



@endsection
@section('script')
    <script>
        $('form').validate();
        $('.select2').select2();
        $('.parent input:checkbox').change(function () {
            $(this).parent().parent().parent().children('.child').children('label').children('input').prop('checked',$(this).prop('checked'));
        });

        $('.child input:checkbox').change(function () {
            var checkparent=true;
            $(this).parent().parent().parent().children('.child').children('label').children('input').each(function () {
                checkparent &=$(this).prop('checked');
            });
            $(this).parent().parent().parent().children('.parent').children('label').children('input').prop('checked',checkparent);
        });

        $('.child input:checkbox').change(function () {
            $(this).parent().parent().next('.depend').children('label').children('input').prop('checked',$(this).prop('checked'));
        });

        $('.depend input:checkbox').change(function () {
            $(this).parent().parent().prev('.child').children('label').children('input').prop('checked',$(this).prop('checked'));
        });

        $('.controller').each(function () {
            var checkparent=true;
            $(this).children('.child').children('label').children('input').each(function () {
                checkparent &=$(this).prop('checked');
            });
            $(this).children('.parent').children('label').children('input').prop('checked',checkparent);

        })
    </script>
@endsection