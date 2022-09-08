'use strict'
const openModalClassList = document.querySelectorAll('.modal-open')
const openAdminModalClassList=document.querySelectorAll('.admin-modal-open')
const closeModalClassList = document.querySelectorAll('.modal-close')
const overlay = document.querySelector('.modal-overlay')
const showParticipantsClassList=document.querySelectorAll('.show_participants')
const body = document.querySelector('body')
const modal = document.querySelector('.modal')
const modalInnerHTML = document.getElementById('modalInner')

for (let i = 0; i < openModalClassList.length; i++) {
  openModalClassList[i].addEventListener('click', (e) => {
    e.preventDefault()
    let eventId = parseInt(e.currentTarget.id.replace('event_', ''))
    openModal(eventId)
  }, false)
}
for(let i=0;i<openAdminModalClassList.length;i++){
  openAdminModalClassList[i].addEventListener('click',(e)=>{
    e.preventDefault()
    let eventId=parseInt(e.currentTarget.id.replace('event_',''))
    openAdminModal(eventId)
  })
}
for (var i = 0; i < closeModalClassList.length; i++) {
  closeModalClassList[i].addEventListener('click', closeModal)
}

overlay.addEventListener('click', closeModal)

for(let i=0;i<showParticipantsClassList.length;i++){
  showParticipantsClassList[i].addEventListener('click',(e)=>{
    e.preventDefault()
    let eventId=parseInt(e.currentTarget.id.replace('show_participants_',''))
    document.getElementById(`participants_${eventId}`).classList.toggle('hidden')
  })
}

async function openModal(eventId) {
  try {
    const url = '/api/getModalInfo.php?event_id=' + eventId
    const res = await fetch(url)
    const event = await res.json()
    const obj=JSON.parse(event.participants)
    let modalHTML = `
      <h2 class="text-md font-bold mb-3">${event.name}</h2>
      <p class="text-sm">${event.date}（${event.day_of_week}）</p>
      <p class="text-sm">${event.start_at} ~ ${event.end_at}</p>

      <hr class="my-4">

      <p class="text-md">
        ${event.message}
      </p>
      <hr class="my-4">

      <p id="show_modal_participants" class="text-sm"><span class="text-xl">${event.total_participants}</span>人参加 ></p>
      <div class="hidden" id="modal_participants">
    `;
    Object.keys(obj).forEach(function(key){
      modalHTML+='・'+obj[key]['user_name']+'<br>'
    })
    modalHTML+=`</div>
    <form action="./controllers/updateAttendancePostController.php" method="POST">
    <input hidden name="event_id" value="${eventId}">`
    
    switch (event.status) {
      case '0':
        modalHTML += `
          <div class="text-center mt-6">
            <p class="text-lg font-bold text-yellow-400">未回答</p>
            <p class="text-xs text-yellow-400">期限 ${event.deadline}</p>
          </div>
          <div class="flex mt-5">
            <input name="attendance" class="flex-1 bg-blue-500 py-2 mx-3 rounded-3xl text-white text-lg font-bold" value="参加する" type="submit">
            <input name="attendance" class="flex-1 bg-red-500 py-2 mx-3 rounded-3xl text-white text-lg font-bold" value="参加しない" type="submit">
            </div>
            `
        break;
      case '1':
        modalHTML += `
        <div class="text-center mt-10">
        <input disabled name="attendance" class="flex-1 bg-gray-300 py-2 mx-3 rounded-3xl text-white text-lg font-bold" value="参加する" type="submit">
        <input name="attendance" class="flex-1 bg-red-500 py-2 mx-3 rounded-3xl text-white text-lg font-bold" value="参加しない" type="submit">
        </div>
        `
        break;
      case '2':
        modalHTML += `
        <div class="text-center mt-10">
        <input name="attendance" class="flex-1 bg-blue-500 py-2 mx-3 rounded-3xl text-white text-lg font-bold" value="参加する" type="submit">
        <input disabled name="attendance" class="flex-1 bg-gray-300 py-2 mx-3 rounded-3xl text-white text-lg font-bold" value="参加しない" type="submit">
          </div>
        `
        break;
    }
    modalHTML += `</form>`
    modalInnerHTML.insertAdjacentHTML('afterbegin', modalHTML)
    document.getElementById('toggle_script').innerHTML=`document.getElementById('show_modal_participants').addEventListener('click',function(){
      document.getElementById('modal_participants').classList.toggle('hidden')
    })`
  } catch (error) {
    console.log(error)
  }
  toggleModal()
}



async function openAdminModal(eventId) {
  try {
    const url = '/api/getModalInfo.php?event_id=' + eventId
    const res = await fetch(url)
    const event = await res.json()
    const obj=JSON.parse(event.participants)
    let modalHTML = `
    <input class="border-solid border-black border" hidden name="event_id" value="${eventId}">
    <div>
    <label>イベント名</label>
    <input class="border-solid border-black border" value="${event.name}" name="event_name" type="name" class="w-full text-sm mb-3">
    </div>
    <div>
    <label>イベント詳細</label>
    <textarea class="border-solid border-black border w-full" name="detail" rows="2">${event.message.replace('<br />',"")}</textarea>
    </div>
    <div>
    <label>開催日時</label>
    <input min="${event.current_date}" class="border-solid border-black border" value="${event.start_at}" name="start_at" type="datetime-local" class="w-full p-4 text-sm mb-3">
    </div>
    <div>
    <label>終了日時</label>
    <input min="${event.current_date}" class="border-solid border-black border" value="${event.end_at}" name="end_at" type="datetime-local" class="w-full p-4 text-sm mb-3">
    </div>
    <input type="submit" value="編集完了" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
    


      <p id="show_admin_participants" class="text-sm"><span class="text-xl show_participants">${event.total_participants}</span>人参加 ></p>
      <div class="hidden" id="admin_participants">
    `;
    Object.keys(obj).forEach(function(key){
      modalHTML+='・'+obj[key]['user_name']+'<br>'
    })
    modalHTML+='</div>'
    modalInnerHTML.insertAdjacentHTML('afterbegin', modalHTML)
    document.getElementById('toggle_script').innerHTML=`document.getElementById('show_admin_participants').addEventListener('click',function(){
      document.getElementById('admin_participants').classList.toggle('hidden');
    })`
  } catch (error) {
    console.log(error)
  }
  toggleModal()
}

function closeModal() {
  modalInnerHTML.innerHTML = ''
  toggleModal()
  location.reload()
}

function toggleModal() {
  modal.classList.toggle('opacity-0')
  modal.classList.toggle('pointer-events-none')
  body.classList.toggle('modal-active')
}

async function participateEvent(eventId) {
  try {
    let formData = new FormData();
    formData.append('eventId', eventId)
    const url = '/api/postEventAttendance.php'
    await fetch(url, {
      method: 'POST',
      body: formData
    }).then((res) => {
      if(res.status !== 200) {
        throw new Error("system error");
      }
      return res.text();
    })
    closeModal()
    location.reload()
  } catch (error) {
    console.log(error)
  }
}

