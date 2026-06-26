@php
use Illuminate\Support\Facades\Vite;
@endphp

<!-- Helpers -->
@vite(['resources/assets/vendor/js/helpers.js'])

<!-- Config -->
@vite(['resources/assets/js/config.js'])

<!-- Bootstrap JS -->
@vite([
    'resources/assets/vendor/libs/jquery/jquery.js',
    'resources/assets/vendor/js/bootstrap.js'
])

<!-- Github Button -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
