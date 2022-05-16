'use strict';

for (let i = 1; i < 100; i++) {
    if (document.getElementById('agency_flexCheckDefault' + i)) {
        let checkbox = document.getElementById('agency_flexCheckDefault' + i);
        let rightContent = document.getElementById('rightContent' + i);
        let comparisonContent = document.getElementById('comparison_agency' + i);
        let comparisonDelete = document.getElementById('comparisonDelete' + i);
        checkbox.addEventListener('change', function() {
            if (checkbox.checked == true) {
                rightContent.classList.remove('display-none');
                comparisonContent.classList.remove('display-none');
            } else
            if (checkbox.checked == false) {
                rightContent.classList.add('display-none');
                comparisonContent.classList.add('display-none');
            }
        }, false);
        comparisonDelete.addEventListener('click', function() {
            checkbox.click();
        }, false);
    }
}

let targets = document.querySelectorAll('.form-check-input');

window.addEventListener('DOMContentLoaded', () => {
    for (const i of targets) {
        let checked_context = localStorage.getItem(i.id);
        if (checked_context === "true") {
            document.getElementById(i.id).click();
        }
    }
});

window.addEventListener('beforeunload', () => {
    for (const i of targets) {
        let checked_context = i.checked;
        localStorage.setItem(i.id, checked_context);
    }
})