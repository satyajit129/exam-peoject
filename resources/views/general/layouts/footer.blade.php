<footer class="footer mt-auto">
    @php
        $settings = App\Models\GeneralSetting::first();
        $copyright = $settings->website_copy_right_text ?? '© My Edu Platform. All rights reserved.';
    @endphp

    <div class="copyright bg-white">
        <p>
            <span id="copy-year"></span> {{ $copyright }}
        </p>
    </div>

    <script>
        var d = new Date();
        var year = d.getFullYear();
        document.getElementById("copy-year").innerHTML = year;
    </script>
</footer>
