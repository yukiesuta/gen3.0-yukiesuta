'use strict';

for (let i = 1; i < 100; i++) {
    if (document.getElementById('agency_flexCheckDefault' + i)) {
        let checkbox = document.getElementById('agency_flexCheckDefault' + i);
        let rightContent = document.getElementById('rightContent' + i);
        let comparisonContent = document.getElementById('comparison_agency' + i);
        let comparisonDelete = document.getElementById('comparisonDelete' + i);
        checkbox.addEventListener('change', function () {
            if (checkbox.checked == true) {
                rightContent.classList.remove('display-none');
                comparisonContent.classList.remove('display-none');
            } else
                if (checkbox.checked == false) {
                    rightContent.classList.add('display-none');
                    comparisonContent.classList.add('display-none');
                }
        }, false);
        comparisonDelete.addEventListener('click', function () {
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

let formButton = document.getElementById("form-button")
let submitButton = document.getElementById("submit-button")
let name = document.getElementById("name")
let birthday = document.getElementById("birthday")
let university = document.getElementById("university")
let phone = document.getElementById("phone-number")
let address = document.getElementById("address")
let email = document.getElementById("email")


let check = function () {
    // if (typeof(name.value) == "string" && typeof(birthday.value) == "string" && typeof(university.value) == "string" && typeof(phone.value) == "string" && typeof(address.value) == "string" && typeof(email.value) == "string") {
    //     // alert("未入力の内容があります");
    //     console.log('確認')
    //     formButton.classList.remove('unclick')
    // }
    if (name.value === ""|| birthday.value === "" || university.value === "" || phone==="" || address.value === "" || email.value==="") {
        // alert("未入力の内容があります");
        console.log('確認')
        formButton.classList.add('unclick')
    }
    else{
        formButton.classList.remove('unclick')
    }
}


name.addEventListener('keyup',check,false)
birthday.addEventListener('keyup',check,false)
university.addEventListener('keyup',check,false)
phone.addEventListener('keyup',check,false)
address.addEventListener('keyup',check,false)
email.addEventListener('keyup',check,false)