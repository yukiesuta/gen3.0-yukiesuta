"use strict";

for (let i = 1; i < 100; i++) {
    if (document.getElementById("agency_flexCheckDefault" + i)) {
        let checkbox = document.getElementById("agency_flexCheckDefault" + i);
        let rightContent = document.getElementById("rightContent" + i);
        let comparisonContent = document.getElementById("comparison_agency" + i);
        let comparisonDelete = document.getElementById("comparisonDelete" + i);
        checkbox.addEventListener(
            "change",
            function () {
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
            function () {
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

let formButton = document.getElementById("form-button");
let submitButton = document.getElementById("submit-button");
let name = document.getElementById("name");
let birthday = document.getElementById("birthday");
let university = document.getElementById("university");
let phone = document.getElementById("phone-number");
let address = document.getElementById("address");
let email = document.getElementById("email");

let check = function () {
    // if (typeof(name.value) == "string" && typeof(birthday.value) == "string" && typeof(university.value) == "string" && typeof(phone.value) == "string" && typeof(address.value) == "string" && typeof(email.value) == "string") {
    //     // alert("未入力の内容があります");
    //     console.log('確認')
    if (
        name.value === "" ||
        birthday.value === "" ||
        university.value === "" ||
        phone === "" ||
        address.value === "" ||
        email.value === ""
    ) {
        // alert("未入力の内容があります");
        console.log("確認");
        formButton.classList.add("unclick");
    } else {
        formButton.classList.remove("unclick");
    }
};

for (let i = 1; i < 100; i++) {
    let toCompare = document.getElementById("toCompare")
    let agency_flexCheckDefault = document.getElementById("agency_flexCheckDefault" + i)
    checkbox.addEventListener("load", function () {
        if (agency_flexCheckDefault == false) {
            toCompare.classList.add("display-none")
        }
    }, false
    )
}
name.addEventListener("keyup", check, false);
birthday.addEventListener("keyup", check, false);
university.addEventListener("keyup", check, false);
phone.addEventListener("keyup", check, false);
address.addEventListener("keyup", check, false);
email.addEventListener("keyup", check, false);




// アコーディオン
//アコーディオンをクリックした時の動作
$('.title').on('click', function() {//タイトル要素をクリックしたら
    var findElm = $(this).next(".box");//直後のアコーディオンを行うエリアを取得し
    $(findElm).slideToggle();//アコーディオンの上下動作
      
    if($(this).hasClass('close')){//タイトル要素にクラス名closeがあれば
      $(this).removeClass('close');//クラス名を除去し
    }else{//それ以外は
      $(this).addClass('close');//クラス名closeを付与
    }
  });
  
  //ページが読み込まれた際にopenクラスをつけ、openがついていたら開く動作※不必要なら下記全て削除
  $(window).on('load', function(){
    $('.accordion-area li:first-of-type section').addClass("open"); //accordion-areaのはじめのliにあるsectionにopenクラスを追加
    $(".open").each(function(index, element){ //openクラスを取得
      var Title =$(element).children('.title'); //openクラスの子要素のtitleクラスを取得
      $(Title).addClass('close');       //タイトルにクラス名closeを付与し
      var Box =$(element).children('.box'); //openクラスの子要素boxクラスを取得
      $(Box).slideDown(500);          //アコーディオンを開く
    });
  });