<div class="SoloAlert-mainer" style="display: none;">
    <div class="SoloAlert-wrapper">
        <div class="SoloAlert"><h3>Prompt Dialog</h3>
            <div class="SoloAlert-content">
                <div class="SoloAlert-prompt-input-wrapper">
                    <div><label for="SoloAlert-prompt-input" id="sd1f5sd1f20sd2fe565d45d">Input</label></div>
                    <input class="SoloAlert-prompt-input" autofocus onkeyup="submitwithdnsoe1(event)"></div>
            </div>
            <div class="SoloAlert-actions">
                <button class="SoloAlert-action-button" onclick="hidePrompt()">CANCEL</button>
                <button class="SoloAlert-action-button" onclick="submitPrompt()">OK</button>
            </div>
        </div>
    </div>
</div>

@push("MasterScript")
    <script>
        let func = null;
        function showPrompt(heading = '', label = '', refreshInput = true) {
            $(".SoloAlert h3").html(heading);
            $("#sd1f5sd1f20sd2fe565d45d").html(label);
            if(refreshInput)
            {
                $(".SoloAlert-prompt-input").val("");
            }
            $(".SoloAlert-mainer").show();
            $(".SoloAlert-prompt-input").click();
            $(".SoloAlert-prompt-input").focus();
        }
        function hidePrompt() {
            $(".SoloAlert-mainer").hide();
        }
        function submitwithdnsoe1(e)
        {
            if(e.which === 13) {
                submitPrompt();
            }
        }
        function submitPrompt() {
            $(".SoloAlert-mainer").hide();
            let val = $(".SoloAlert-prompt-input").val();
            if(func !== null)
            {
                func(val);
            }
        }
        function setPromptFunc(funcData)
        {
            func = funcData;
        }
    </script>
@endpush
