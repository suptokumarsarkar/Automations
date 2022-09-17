@if(isset($input) && $input == true)
    <div class="css-1faxqwt-PopularTemplatesSection__dropdown" style="width: 100%">
        <div class="dropdown-mul-1{{$id}}">
            <input type="hidden" name="id[]" value="{{$id}}">
            <label for="ds2d1ds{{$id}}">{{$label}} {!! (isset($required) && $required == true) ? "<span class='required'>*</span>" : "" !!}</label>
            <input class="form-control" style='margin-top:5px; margin-bottom: 5px' name="{{$form['id']}}[]" id="ds2d1ds{{$id}}"
                    placeholder="">
        </div>
        @if(isset($form['description']))
            <p class="des154">{!! $form['description'] !!}</p>
        @endif
    </div>
@else
    <div class="css-1faxqwt-PopularTemplatesSection__dropdown" style="width: 100%">
        <div class="dropdown-mul-1{{$id}}">
            <input type="hidden" name="id[]" value="{{$id}}">
            <label for="ds2d1ds{{$id}}">{{$label}} {!! (isset($required) && $required == true) ? "<span class='required'>*</span>" : "" !!}</label>
            <select style="display:none" name="label{{$id}}[]" id="ds2d1ds{{$id}}" multiple
                    placeholder="Select"> </select>
        </div>

        @if(isset($form['description']))
            <p class="des154">{!! $form['description'] !!}</p>
        @endif
    </div>
@endif
