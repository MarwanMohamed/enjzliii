<?php global $setting; ?>

@extends('front.__template')
@section('title','إعدادات التنبيهات')

@section('content')

<style>
    .info_perfs .slideTows{
        width: 100%;
    }
</style>

<section class="s_protfolio">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="/notifcationSetting" id="editProfile" method="post">
                    <div id="msg"></div>
                    {{csrf_field()}}
                    <div class="all_item_profsingle">
                        <div class="heade_div2">
                            <h2>ادارة التنبيهات</h2>
                        </div>
                        <div class="item_profile">
                            <h2>تنبيهات البريد الإلكتروني</h2>
                            <div class="info_perfs">



                                <div class="slideTows">

                                    <input type="checkbox"  value="1" id="slideTows" {{(isset($notiPerms[1]))?'checked':''}} name="notiPerms[]"  />
                                    <label for="slideTows">تنبيهات ادارية</label>
                                </div>
                                <div class="slideTows">
                                    <input type="checkbox" value="2"  id="slideTows2"  {{(isset($notiPerms[2]))?'checked':''}} name="notiPerms[]" />
                                    <label for="slideTows2">دعوة منجز مشروع</label>
                                </div>


                                <div class="slideTows">
                                    <input type="checkbox"  value="3" id="slideTows3" {{(isset($notiPerms[3]))?'checked':''}} name="notiPerms[]"  />
                                    <label for="slideTows3">اضافة عرض مشروعك</label>
                                </div>
                                <div class="slideTows">
                                    <input type="checkbox" value="4"  id="slideTows4"  {{(isset($notiPerms[4]))?'checked':''}} name="notiPerms[]" />
                                    <label for="slideTows4"  >الموافقة على عرضك</label>
                                </div>

                                <div class="slideTows">
                                    <input type="checkbox"  value="5" id="slideTows5" {{(isset($notiPerms[5]))?'checked':''}} name="notiPerms[]"  />
                                    <label for="slideTows5">اضافة نقاش على المشروع</label>
                                </div>
                                <div class="slideTows">
                                    <input type="checkbox" value="7"  id="slideTows7"  {{(isset($notiPerms[7]))?'checked':''}} name="notiPerms[]" />
                                    <label for="slideTows7"  >طلب انهاء مشروع</label>
                                </div>
                                <div class="slideTows">
                                    <input type="checkbox"  value="8" id="slideTows8" {{(isset($notiPerms[8]))?'checked':''}} name="notiPerms[]"  />
                                    <label for="slideTows8">انهاء المشروع</label>
                                </div>
                                <div class="slideTows">
                                    <input type="checkbox" value="9"  id="slideTows9"  {{(isset($notiPerms[9]))?'checked':''}} name="notiPerms[]" />
                                    <label for="slideTows9"  >تقيم جديد</label>
                                </div>

                                <div class="slideTows">
                                    <input type="checkbox"  value="10" id="slideTows10" {{(isset($notiPerms[10]))?'checked':''}} name="notiPerms[]"  />
                                    <label for="slideTows10">اضافة مشروع خاص</label>
                                </div>
                                <div class="slideTows">
                                    <input type="checkbox" value="11"  id="slideTows11"  {{(isset($notiPerms[11]))?'checked':''}} name="notiPerms[]" />
                                    <label for="slideTows11"  >رسالة جديدة</label>
                                </div>


                            </div>

                        </div>

                        <div class="item_profile">
                            <h2>تنبيهات داخلية</h2>
                            <div class="info_perfs">



                                <div class="slideTows">
                                    <input type="checkbox"  value="23" id="slideTows21" {{(isset($notiPerms[23]))?'checked':''}} name="notiPerms[]"  />
                                    <label for="slideTows21">اضافة عرض</label>
                                </div>
                                <div class="slideTows">
                                    <input type="checkbox" value="26"  id="slideTows22"  {{(isset($notiPerms[26]))?'checked':''}} name="notiPerms[]" />
                                    <label for="slideTows22">تعديل عرض</label>
                                </div>



                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="btn_ok">
                                <button type="submit"> حفظ <i class="fa fa-spin fa-spinner hidden" id="formLoader"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                {{-- @include('front.sidePortfolio') --}}
                {{-- @include('front.userSteps') --}}

            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
<script src="/panel/js/toggles.min.js"></script>

<script>

</script>
@endsection