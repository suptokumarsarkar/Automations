
    <div class="render_block_250 googleSheet_trigger googleSheet_new_label">
        <h4 class="align-content-center">{{\App\Logic\Helpers::translate('Trigger Successfully')}}</h4>
        <p>{{\App\Logic\translate('We Found')}} {{count($files)}} {{\App\Logic\Helpers::translate('Sheets')}}</p>
        <ul>
            @foreach($files as $file)
                <li>{{$file['name']}}</li>
            @endforeach
        </ul>
    </div>
    <style>
        .googleSheet_new_label h4, .googleSheet_new_label p {
            text-align: center;
        }
        .googleSheet_new_label ul {
            max-width: 500px;
            margin: 10px auto;
        }
        .googleSheet_new_label ul li{
            padding: 5px 10px;
            display: block;
            border: 1px solid #ccc;
            margin: 2px;
            background: #EEEFFF52;
            text-transform: uppercase;
        }
    </style>
