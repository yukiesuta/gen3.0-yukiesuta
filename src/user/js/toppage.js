'use strict';

for (let i = 1; i < 100; i++) {
    if (document.getElementById('agency_flexCheckDefault' + i)) {
        let checkbox = document.getElementById('agency_flexCheckDefault' + i)
        let rightContent = document.getElementById('rightContent' + i)
        checkbox.addEventListener('change', function() {
            if (checkbox.checked == true) {

                console.log('選択されました')

                rightContent.classList.remove('display-none')
            } else if (checkbox.checked == false) {
                console.log('解除されました')

                rightContent.classList.add('display-none')
            }
        }, false)
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