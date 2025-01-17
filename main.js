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
    delay: (el, i) => 50 + (75 * i)
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
        // Hide the section instantly
        petsSection.style.transition = 'none'; // Disable transition
        petsSection.classList.remove('vael-show');
        viewPetsText.setAttribute('aria-expanded', 'false');
        viewPetsText.innerHTML = 'show<span class="arrow">&#9662;</span>'; // Down arrow

        // Re-enable transition after hiding
        setTimeout(() => {
            petsSection.style.transition = 'max-height 0.4s ease, opacity 0.4s ease, transform 0.4s ease';
        }, 0);
    } else {
        // Show the section with transition
        petsSection.style.transition = 'max-height 0.4s ease, opacity 0.4s ease, transform 0.4s ease';
        petsSection.classList.add('vael-show');
        viewPetsText.setAttribute('aria-expanded', 'true');
        viewPetsText.innerHTML = 'hide<span class="arrow">&#9652;</span>'; // Up arrow
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
  