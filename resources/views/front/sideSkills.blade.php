<div class="all_item_prof">
    <div class="heade_div2">
        <h2>مهاراتي</h2>
    </div>
    @if(sizeof($skills))
    <div class="left_side_items">
        <ul>
            @foreach($skills as $skill)
                <li>#{{$skill->name}}</li>
            @endforeach
        </ul>
    </div>
        @else
        <p style="padding: 20px"> لم يتم اختيار اي مهارات</p>
    @endif
</div>