'use strict';

var flag = false;


for (let i = 1; i < 3; i++) {
    let checkbox = document.getElementById('flexCheckDefault' + i)
    let rightContent = document.getElementById('rightContent' + i)
    checkbox.addEventListener('change',function(){
        if (checkbox.checked == true) {

            console.log('選択されました')

            rightContent.classList.remove('display-none')
        }
        else if (checkbox.checked == false){
            console.log('解除されました')

            rightContent.classList.add('display-none')
        }
    }
    ,false
    )
}