"use strict";

for (let i = 1; i < 100; i++) {
    if (document.getElementById("agency_flexCheckDefault" + i)) {
        let checkbox = document.getElementById("agency_flexCheckDefault" + i);
        let rightContent = document.getElementById("rightContent" + i);
        let comparisonContent = document.getElementById("comparison_agency" + i);
        let comparisonDelete = document.getElementById("comparisonDelete" + i);
        checkbox.addEventListener(
            "change",
            function() {
                console.log(document.getElementById("hidden_checkbox" + i));
                document.getElementById("hidden_checkbox" + i).click();
                if (checkbox.checked == true) {
                    rightContent.classList.remove("display-none");
                    comparisonContent.classList.remove("display-none");
                } else if (checkbox.checked == false) {
                    rightContent.classList.add("display-none");
                    comparisonContent.classList.add("display-none");
                }
            },
            false
        );
        comparisonDelete.addEventListener(
            "click",
            function() {
                checkbox.click();
            },
            false
        );
    }
}

for (let i = 1; i < 9; i++) {
    document
        .getElementById("ph_industry_flexCheckDefault" + i)
        .addEventListener("change", () => {
            document.getElementById("pc_industry_flexCheckDefault" + i).click();
        });
}
for (let i = 1; i < 3; i++) {
    document
        .getElementById("ph_major_flexCheckDefault" + i)
        .addEventListener("change", () => {
            document.getElementById("pc_major_flexCheckDefault" + i).click();
        });
}
for (let i = 1; i < 6; i++) {
    document
        .getElementById("ph_feature_flexCheckDefault" + i)
        .addEventListener("change", () => {
            document.getElementById("pc_feature_flexCheckDefault" + i).click();
        });
}

let click_targets = document.querySelectorAll(".form-check-input-click");

window.addEventListener("DOMContentLoaded", () => {
    for (const i of click_targets) {
        let checked_context = localStorage.getItem(i.id);
        if (checked_context === "true") {
            document.getElementById(i.id).click();
        }
    }
});

let not_click_targets = document.querySelectorAll(".form-check-input-not-click");

window.addEventListener("DOMContentLoaded", () => {
    for (const i of not_click_targets) {
        let checked_context = localStorage.getItem(i.id);
        if (checked_context === "true") {
            document.getElementById(i.id).checked = "true";
        }
    }
});

let targets = document.querySelectorAll(".form-check-input");

window.addEventListener("beforeunload", () => {
    for (const i of targets) {
        let checked_context = i.checked;
        localStorage.setItem(i.id, checked_context);
    }
});


for (let i = 1; i < 100; i++) {
    let toCompare = document.getElementById("toCompare")
    let agency_flexCheckDefault = document.getElementById("agency_flexCheckDefault" + i)
    checkbox.addEventListener("load", function() {
        if (agency_flexCheckDefault == false) {
            toCompare.classList.add("display-none")
        }
    }, false)
}