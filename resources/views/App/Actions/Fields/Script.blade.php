<link href="{{asset('public/3rdparty/dropdown/jquery.dropdown.min.css' . App\Logic\Helpers::production("version"))}}"
      rel="stylesheet">
<script
    src="{{asset('public/3rdparty/dropdown/jquery.dropdown.min.js' . App\Logic\Helpers::production("version"))}}"></script>
<script>
    let data = [
            @php($i = 0)
            @php($customId = 0)
            @php($customName = 0)
            @foreach($form as $label => $inputs)
            @php($i++)
            @foreach($inputs as $key => $input)
            @foreach($input as $section => $data)
        {
            disabled: false,
            groupId: {{$i}},
            groupName: "{{$label}}",
            id: "[{{$key}}]{{$data['id']}}",
            name: "{{$data['name']}}"
        },
        @if("[$key]".$data['id'] == '[custom]custom')@php($customId = $i)@endif
        @if("[$key]".$data['id'] == '[custom]custom')@php($customName = $data['name'])@endif
        @endforeach
        @endforeach
        @endforeach
    ];

    function createDropdown() {
       $('.dropdown-mul-1{{$id}}').dropdown({
            data: data,
            limitCount: 40,
            input: '<input type="text" maxLength="20" placeholder="Search">',
            multipleMode: 'label',
            choice: function () {
                makeCustom{{$id}}(arguments);
            }
        });
    }
    function makeCustom{{$id}}(arguments) {
        if (arguments[1]) {
            if (arguments[1]['id'] === "[custom]custom") {
                showPrompt("{{\App\Logic\translate('Add Custom')}}", "{{\App\Logic\translate($labelName)}}");
                setPromptFunc(addCustom{{$id}});
            }
        }
    }

    function createInput{{$id}}(name, value) {
        let random = Math.floor(Math.random() * 10000000000000);
        html = `
<div id="ad10d`+random+`" class="orchona">
        <label for="input`+random+`">
<input class="w3-dnskll" name="string{{$id}}{{$labelId}}[]" value="`+value+`" id="input`+random+`">
</label>
<div class="button_alosonga" onclick="rmvd1d10('ad10d`+random+`')">
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.29 6.29001L12 10.59L7.71004 6.29001L6.29004 7.71001L10.59 12L6.29004 16.29L7.71004 17.71L12 13.41L16.29 17.71L17.71 16.29L13.41 12L17.71 7.71001L16.29 6.29001Z" fill="#2D2E2E"></path></svg>
</div>
</div>
        `;

        return html;
    }

    function addCustom{{$id}}(datas) {
        let rm = "[custom]custom";
        $(".del[data-id='" + rm + "']").click();
        let html = createInput{{$id}}("[string]" + datas, datas);
        $('.dropdown-mul-1{{$id}}').after(html);

    }
    function rmvd1d10(data){
        $("#"+data).remove();
    }

    createDropdown();
</script>
