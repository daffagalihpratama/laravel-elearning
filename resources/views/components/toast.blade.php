@if(session('success'))
<div class="toast-success">
    ✅ {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="toast-error">
    ❌ {{ session('error') }}
</div>
@endif

<style>
.toast-success, .toast-error {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);

    padding: 12px 18px;
    color: white;
    border-radius: 8px;
    font-size: 14px;
    z-index: 9999;

    box-shadow: 0 4px 12px rgba(0,0,0,0.2);

    animation: slideDown 0.4s ease;
}

/* warna */
.toast-success { background: #28a745; }
.toast-error { background: #dc3545; }

/* animasi masuk */
@keyframes slideDown {
    from {
        transform: translate(-50%, -30px);
        opacity: 0;
    }
    to {
        transform: translate(-50%, 0);
        opacity: 1;
    }
}
</style>

<script>
setTimeout(() => {
    let toast = document.querySelector('.toast-success, .toast-error');
    if (toast) {
        toast.style.transition = '0.5s';
        toast.style.opacity = '0';
        toast.style.transform = 'translate(-50%, -20px)';
        setTimeout(() => toast.remove(), 500);
    }
}, 3000);
</script>
