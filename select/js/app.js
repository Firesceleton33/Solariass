document.addEventListener('DOMContentLoaded', function () {
    const selectButtons = document.querySelectorAll('.select-button');

    selectButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            alert('Character selected!');
        });
    });
});
