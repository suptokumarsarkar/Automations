<div class="render_block_250 gmail_trigger gmail_new_label">
    <h4 class="align-content-center">{{\App\Logic\Helpers::translate('Trigger Successfully')}}</h4>
    <p>{{\App\Logic\translate('We Found')}} {{count($labels)}} {{\App\Logic\Helpers::translate('Labels')}}</p>
    <ul>
        @foreach($labels as $label)
            <li>{{$label['name']}}</li>
        @endforeach
    </ul>
</div>
<style>
    .gmail_new_label h4, .gmail_new_label p {
        text-align: center;
    }
    .gmail_new_label ul {
        max-width: 500px;
        margin: 10px auto;
    }
    .gmail_new_label ul li{
        padding: 5px 10px;
        display: block;
        border: 1px solid #ccc;
        margin: 2px;
        background: #EEEFFF52;
        text-transform: uppercase;
    }
</style>
