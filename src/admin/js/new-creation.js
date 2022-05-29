const industrys = document.querySelectorAll(".industry");
for (const i of industrys) {
    i.onclick = function() {
        if (
            document.getElementById("flexCheckDefault11").checked ||
            document.getElementById("flexCheckDefault12").checked ||
            document.getElementById("flexCheckDefault13").checked ||
            document.getElementById("flexCheckDefault14").checked ||
            document.getElementById("flexCheckDefault15").checked ||
            document.getElementById("flexCheckDefault16").checked ||
            document.getElementById("flexCheckDefault17").checked ||
            document.getElementById("flexCheckDefault18").checked
        ) {
            document.getElementById("flexCheckDefault1").checked = true;
        } else {
            document.getElementById("flexCheckDefault1").checked = false;
        }
    };
}

const majors = document.querySelectorAll(".major");
for (const i of majors) {
    i.onclick = function() {
        if (
            document.getElementById("flexCheckDefault21").checked ||
            document.getElementById("flexCheckDefault22").checked
        ) {
            document.getElementById("flexCheckDefault2").checked = true;
        } else {
            document.getElementById("flexCheckDefault2").checked = false;
        }
    };
}

const supports = document.querySelectorAll(".support");
for (const i of supports) {
    i.onclick = function() {
        if (
            document.getElementById("flexCheckDefault31").checked ||
            document.getElementById("flexCheckDefault32").checked ||
            document.getElementById("flexCheckDefault33").checked ||
            document.getElementById("flexCheckDefault34").checked ||
            document.getElementById("flexCheckDefault35").checked
        ) {
            document.getElementById("flexCheckDefault3").checked = true;
        } else {
            document.getElementById("flexCheckDefault3").checked = false;
        }
    };
}

const maxFileSize = 1048576;
$("input[type=file]").change(function() {
    $(".error_msg").remove();
    let uploaded_file = $(this).prop("files")[0];
    if (maxFileSize < uploaded_file.size) {
        $(this).val("");
        $(this).after(
            "<p class='error_msg'>アップロードできる画像の最大サイズは1MBです</p>"
        );
    }
});

function previewImage(obj) {
    var fileReader = new FileReader();
    fileReader.onload = function() {
        document.getElementById("preview").src = fileReader.result;
    };
    fileReader.readAsDataURL(obj.files[0]);
}