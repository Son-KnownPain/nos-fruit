const eyes = document.querySelectorAll('.eye');

eyes.forEach(item => {
    item.onclick = (e) => {
        if (item.classList.contains('fa-eye')) {
            document.querySelector(item.dataset.for).setAttribute('type', 'text');
            item.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            document.querySelector(item.dataset.for).setAttribute('type', 'password');
            item.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
});