import './src/style.css'

import { createTimeline } from 'animejs'

document.addEventListener('DOMContentLoaded', () => {
  const text_wrapper = document.querySelector('#vael_victus');
  if (text_wrapper) {
    text_wrapper.innerHTML = text_wrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");
    document.getElementById('vael_victus').style.display = 'block';
  }

  const content_delay = 900;

  // fade in each section
  document.querySelectorAll('section').forEach((el, i) => {
    setTimeout(() => {
      el.style.opacity = 1;
      el.style.transform = 'translateY(0px)';
    }, content_delay + i*300)
  });

  createTimeline({loop: false})
  .add('#vael_victus .letter', {
    translateX: [40, 0],
    translateZ: 0,
    opacity: [0, 1],
    easing: "easeOutCubic",
    duration: 2000,
    delay: (_el, i) => 0 + (75 * i)
  });
    
  setTimeout(() => {
    document.getElementById("web_dev").classList.add('fadeIn');
    document.getElementById("game_dev").classList.add('fadeIn');
    document.getElementById("writer").classList.add('fadeIn');
  }, 750);
});

const pets_section = document.getElementById('pets_section');

document.getElementById('view_pets').addEventListener('click', () => {
  const view_pets_text = document.getElementById('view_pets');

  if (pets_section.classList.contains('vael-show')) {
      // hide the section
      pets_section.classList.remove('vael-show');
      view_pets_text.setAttribute('aria-expanded', 'false');
      view_pets_text.innerHTML = 'show<span class="arrow">&#9662;</span>';

      // wait for transition to complete before hiding
      setTimeout(() => {
          pets_section.style.display = 'none';
      }, 450);
  } else {
      // show the section
      pets_section.style.display = 'block';
      
      // force a reflow and then start transition
      requestAnimationFrame(() => {
          pets_section.classList.add('vael-show');
          view_pets_text.setAttribute('aria-expanded', 'true');
          view_pets_text.innerHTML = 'hide<span class="arrow">&#9652;</span>';
      });
  }
});

// helpers
window.copyToClipboard = (message) => {
  const update_status = (html) => {
    const el = document.getElementById('click2copy');
    if (!el) return;
    el.innerHTML = html;
    setTimeout(() => {
      el.innerHTML = 'click to copy';
    }, 3000);
  };

  if (navigator.clipboard?.writeText) {
    navigator.clipboard.writeText(message)
      .then(() => update_status('<b style="color: #228C22">✔ copied</b>'))
      .catch((err) => {
        console.log('clipboard api failed, falling back: ' + err.message);
        const text_area = document.createElement('textarea');
        text_area.value = message;
        text_area.style.opacity = '0';
        document.body.appendChild(text_area);
        text_area.focus();
        text_area.select();
        try {
          document.execCommand('copy');
          update_status('<b style=\"color: #228C22\">✔ copied</b>');
        } catch (e) {
          console.log('unable to copy value , error : ' + e.message);
        }
        document.body.removeChild(text_area);
      });
  } else {
    const text_area = document.createElement('textarea');
    text_area.value = message;
    text_area.style.opacity = '0';
    document.body.appendChild(text_area);
    text_area.focus();
    text_area.select();
    try {
      document.execCommand('copy');
      update_status('<b style="color: #228C22">✔ copied</b>');
    } catch (e) {
      console.log('unable to copy value , error : ' + e.message);
    }
    document.body.removeChild(text_area);
  }
}
  
