import './css/style.css'

import anime from 'animejs'

var textWrapper = document.querySelector('#vael_victus');
textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

anime.timeline({loop: false})
  .add({
    targets: '#vael_victus .letter',
    translateX: [40,0],
    translateZ: 0,
    opacity: [0,1],
    easing: "easeOutExpo",
    duration: 2500,
    delay: (el, i) => 100 + 30 * i
  });

// ! HELPERS
window.copyToClipboard = function(message) {
  var textArea = document.createElement("textarea");
  textArea.value = message;
  textArea.style.opacity = "0"; 
  document.body.appendChild(textArea);
  textArea.focus();
  textArea.select();

  try {
      document.execCommand('copy');

      // *yawn*
      document.getElementById('click2copy').innerHTML = '<b style="color: #228C22">✔ copied</b>';
      setTimeout(() => {
        document.getElementById('click2copy').innerHTML = 'click to copy';
      }, 3000);
  } catch (err) {
      console.log('Unable to copy value , error : ' + err.message);
  }

  document.body.removeChild(textArea);
}
  