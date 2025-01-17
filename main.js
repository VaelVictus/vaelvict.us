import './css/style.css'

import anime from 'animejs'

document.addEventListener('DOMContentLoaded', function () {
  let textWrapper = document.querySelector('#vael_victus');
  textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

  document.getElementById('vael_victus').style.display = 'block';

  let content_delay = 1100;

  // fade in each section
  document.querySelectorAll('section').forEach((el, i) => {
    setTimeout(() => {
      el.style.opacity = 1;
      el.style.transform = 'translateY(0px)';
    }, content_delay + i*350)
  });

  anime.timeline({loop: false})
  .add({
    targets: '#vael_victus .letter',
    translateX: [40, 0],
    translateZ: 0,
    opacity: [0, 1],
    easing: "easeOutCubic",
    duration: 2000,
    delay: (el, i) => 100 + (70 * i)
  });
    
  // setTimeout(() => {
  //   document.querySelectorAll("section").forEach(eh => eh.classList.add('fadeIn'));
  // }, 0);

  setTimeout(() => {
    document.getElementById("web_dev").classList.add('fadeIn');
  }, 500);

  setTimeout(() => {
    document.getElementById("game_dev").classList.add('fadeIn');
  }, 650);

  setTimeout(() => {
    document.getElementById("writer").classList.add('fadeIn');
  }, 800);
});

document.getElementById('view_pets').addEventListener('click', function() {
    const petsSection = document.getElementById('pets_section');
    
    if (petsSection.classList.contains('hidden')) {
        petsSection.classList.remove('hidden');
        petsSection.classList.add('fade-in');
    } else {
        petsSection.classList.remove('fade-in');
        petsSection.classList.add('hidden');
    }
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
  