@if(isset($input) && $input == true)
    <div class="css-1faxqwt-PopularTemplatesSection__dropdown" style="width: 100%">
        <div class="dropdown-mul-1{{$id}}">
            <input type="hidden" name="id[]" value="{{$id}}">
            <label
                for="ds2d1ds{{$id}}">{{$label}} {!! (isset($required) && $required == true) ? "<span class='required'>*</span>" : "" !!}</label>
            <input @if(isset($disabled)) disabled @endif class="form-control"
                   style='margin-top:5px; margin-bottom: 5px' name="{{$form['id']}}[]"
                   id="ds2d1ds{{$id}}"
                   placeholder="">
        </div>
        @if(isset($form['description']))
            <p class="des154">{!! $form['description'] !!}</p>
        @endif
    </div>
@elseif(isset($hidden) && $hidden == true)
    <input type="hidden" name="id[]" value="{{$id}}">
    <input type="hidden" value="{{$labelId}}" name="label{{$id}}[]">
@else
    @if(!isset($multiple))
        <div class="css-1faxqwt-PopularTemplatesSection__dropdown" style="width: 100%">
            <div class="dropdown-mul-1{{$id}}">
                <input type="hidden" name="id[]" value="{{$id}}">
                <label
                    for="ds2d1ds{{$id}}">{{$label}} {!! (isset($required) && $required == true) ? "<span class='required'>*</span>" : "" !!}</label>
                <select @if(isset($disabled)) disabled @endif style="display:none" name="label{{$id}}[]"
                        id="ds2d1ds{{$id}}" multiple
                        placeholder="Select"> </select>
            </div>

            @if(isset($form['description']))
                <p class="des154">{!! $form['description'] !!}</p>
            @endif
        </div>
    @else
        <div
            class="css-1faxqwt-PopularTemplatesSection__dropdown @if(isset($acceptDataLoad)) accpeter_dt_{{$acceptDataLoad}} @endif"
            style="width: 100%">
            <div class="dropdown-msul-1{{$id}}" style="display: block;margin: 10px 10px 57px;">
                <input type="hidden" name="id[]" value="{{$id}}">
                <label
                    for="ds2d1ds{{$id}}">{{$label}} {!! (isset($required) && $required == true) ? "<span class='required'>*</span>" : "" !!}</label>
                <select @if(isset($disabled)) disabled
                        @endif class="niceSelect full-width gwidth @if(isset($dataLoad)) adf15dss{{$id}} @endif"
                        style="display:none" name="label{{$id}}[]"
                        id="ds2d1ds{{$id}}"
                        placeholder="Select">
                    @foreach($form as $label => $inputs)
                        @foreach($inputs as $key => $input)
                            @foreach($input as $section => $data)
                                <option value="[{{$key}}]{{$data['id']}}"
                                        @if(isset($dataLoad)) data-load="{{$dataLoad}}"
                                        data-action="{{$dataAction}}" @endif>{{$data['name']}}</option>
                            @endforeach
                        @endforeach
                    @endforeach
                </select>
            </div>

            @if(isset($form['description']))
                <p class="des154">{!! $form['description'] !!}</p>
            @endif
        </div>
        <script>
            $("#ds2d1ds{{$id}}").niceSelect();
            @if(isset($dataLoad))
            $(".adf15dss{{$id}}").load(function () {
                alert("loaded");
            });
            $(".adf15dss{{$id}}").change(function () {
                let attr = $(this).find('option:selected').attr('data-load');
                let dataAction = $(this).find('option:selected').attr('data-action');
                if (typeof attr !== 'undefined' && attr !== false) {
                    $.ajax({
                        url: '{{route("getExtraDataField")}}/' + attr + "/" + dataAction,
                        method: 'POST',
                        data: $("#{{isset($formName) ? $formName : 'TriggerForm'}}").serialize(),
                        beforeSend: function () {
                            showLoader();
                        },
                        success: function (data) {
                            hideLoader();
                            $(".accpeter_dt_" + data.id).not(':first').remove();
                            $(".accpeter_dt_" + data.id).replaceWith(data.view);
                        },
                        error: function () {
                            hideLoader();
                        }
                    });
                }
            });
            $(".adf15dss{{$id}}").change();
            @endif
        </script>
    @endif
@endif
