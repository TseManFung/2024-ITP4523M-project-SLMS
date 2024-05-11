document.addEventListener('DOMContentLoaded', function() {
const body=document.body;
const eye=document.querySelector('.fa-regular');
const beam=document.querySelector('.beam');
const passwordInput=document.getElementById('password');
const accountInput=document.getElementById('account');
const btnLogin = document.getElementsByClassName("btn-login")[0];

body.addEventListener('mousemove',function(e){
    let rect=beam.getBoundingClientRect();
    let mouseX=rect.right+(rect.width/2);
    let mouseY=rect.top+(rect.height/2);
    let rad=Math.atan2(mouseX-e.pageX,mouseY-e.pageY);
    let deg=(rad*(20/Math.PI)*-1)-350;
    body.style.setProperty('--beam-deg',deg+'deg');
})

eye.addEventListener('click',function(e){
    e.preventDefault();
    body.classList.toggle('show-password');
    passwordInput.type=passwordInput.type==='password'?'text':'password';
    eye.className='fa-regular '+(passwordInput.type==='password'?'fa-eye-slash':'fa-eye');
    eye.style='color: '+(passwordInput.type==='password'?'':'white');
    passwordInput.focus();
})

btnLogin.addEventListener('click',function(e){
if(accountInput.value === 'D'){
    window.location.href = "pages/dealer/search_item.html";
}else if(accountInput.value === 'SM'){
    window.location.href = "pages/dealer/search_item.html";

}
});
})

/* 
// 构建要发送的数据对象
var data = {
  key1: 'value1',
  key2: 'value2'
};

// 发送POST请求
fetch('your_php_file.php', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify(data)
})
.then(function(response) {
  if (response.ok) {
    // 请求成功，重定向到目标页面
    window.location.href = 'target_page.php';
  } else {
    // 请求失败
    console.log('Error:', response.statusText);
  }
})
.catch(function(error) {
  console.log('Error:', error);
});
*/