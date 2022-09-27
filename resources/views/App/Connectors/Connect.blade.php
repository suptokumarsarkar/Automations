<div class="body_md_part" style="max-width: 1000px; width: 100%; margin: 0 auto;">
    @includeIf('App.Connectors.Trigger', ['app' => $firstApp])
    @includeIf('App.Connectors.Action', ['app' => $secondApp, 'first' => $firstApp])
</div>
@push('headerScript')
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css"
          integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
          integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
@endpush
@includeIf('App.Components.Modal')
@includeIf('App.Components.Prompt')
@includeIf('App.Components.Loader')
@push("MasterScript")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"
            integrity="sha512-NqYds8su6jivy1/WLoW8x1tZMRD7/1ZfhWG/jcRQLOzV1k1rIODCpMgoBnar5QXshKJGV7vi0LXLNXPoFsM5Zg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
            integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function () {
            $(".niceSelect").niceSelect();
        });

        function changeMode(th, cls) {
            const name = $(th).find('option:selected').attr("name");
            const desc = $(th).find('option:selected').attr("title");
            $("." + cls + " h2").html(name);
            $("." + cls + " h6").html(desc);
        }

        toastr.options.timeOut = 5000; // 1.5s
        toastr.options.progressBar = true;
        toastr.optionsOverride = 'positionclass:toast-bottom-full-width';

        function displayInfoToaster(message) {
            toastr.info(message);
        }

        function displaySuccessToaster(message) {
            toastr.success(message);
        }

        function displayErrorToaster(message) {
            toastr.error(message);
        }

        function displayWarningToaster(message) {
            toastr.warning(message);
        }
    </script>
@endpush
