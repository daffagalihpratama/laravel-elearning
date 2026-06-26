@php
$containerFooter = !empty($containerNav) ? $containerNav : 'container-fluid';
@endphp

<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">

    <div class="{{ $containerFooter }}">

        <div class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">

            <div class="text-body">

                © <script>
                    document.write(new Date().getFullYear())
                </script>

                E-Learning Kampus

            </div>

            <div class="d-none d-lg-inline-block">

                <span class="text-muted">
                    Sistem Informasi Akademik
                </span>

            </div>

        </div>

    </div>

</footer>
<!-- / Footer -->
