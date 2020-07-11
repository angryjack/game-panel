document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById("header-dropdown-toggle");
    const dropDown = document.getElementById("header-dropdown");

    toggle.addEventListener('click', (e) => {
        e.stopPropagation();
        dropDown.classList.toggle('show');
    });

    document.body.addEventListener('click', () => {
        dropDown.classList.remove('show');
    });
});
