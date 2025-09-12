<footer class="footer mt-auto">
    @php
        $settings = App\Models\Setting::first(); // Fetch the settings
    @endphp

    <div class="copyright bg-white">
        <p>
            &copy; <span id="copy-year"></span> {{ $settings->website_copy_right_text }}
        </p>
    </div>
    <script>
        var d = new Date();
        var year = d.getFullYear();
        document.getElementById("copy-year").innerHTML = year;
    </script>
</footer>