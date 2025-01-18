import './css/style.css'

import anime from 'animejs'

document.addEventListener('DOMContentLoaded', function () {
  let textWrapper = document.querySelector('#vael_victus');
  textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

  document.getElementById('vael_victus').style.display = 'block';

  let content_delay = 900;

  // fade in each section
  document.querySelectorAll('section').forEach((el, i) => {
    setTimeout(() => {
      el.style.opacity = 1;
      el.style.transform = 'translateY(0px)';
    }, content_delay + i*300)
  });

  anime.timeline({loop: false})
  .add({
    targets: '#vael_victus .letter',
    translateX: [40, 0],
    translateZ: 0,
    opacity: [0, 1],
    easing: "easeOutCubic",
    duration: 2000,
    delay: (el, i) => 0 + (75 * i)
  });
    
  setTimeout(() => {
    document.getElementById("web_dev").classList.add('fadeIn');
    document.getElementById("game_dev").classList.add('fadeIn');
    document.getElementById("writer").classList.add('fadeIn');
  }, 750);
});

const petsSection = document.getElementById('pets_section');

document.getElementById('view_pets').addEventListener('click', function() {
  const viewPetsText = document.getElementById('view_pets');

  if (petsSection.classList.contains('vael-show')) {
      // Hide the section
      petsSection.classList.remove('vael-show');
      viewPetsText.setAttribute('aria-expanded', 'false');
      viewPetsText.innerHTML = 'show<span class="arrow">&#9662;</span>';

      // Wait for transition to complete before hiding
      setTimeout(() => {
          petsSection.style.display = 'none';
      }, 450);
  } else {
      // Show the section
      petsSection.style.display = 'block';
      
      // Force a reflow and then start transition
      requestAnimationFrame(() => {
          petsSection.classList.add('vael-show');
          viewPetsText.setAttribute('aria-expanded', 'true');
          viewPetsText.innerHTML = 'hide<span class="arrow">&#9652;</span>';
      });
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
  