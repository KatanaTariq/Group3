document.addEventListener('DOMContentLoaded', function () {
    const selects = document.querySelectorAll('.size-select');

    selects.forEach(select => {
        select.addEventListener('change', function () {
            const form = this.closest('form');

            if (form) {
                form.submit();
            }
        });
    });
});