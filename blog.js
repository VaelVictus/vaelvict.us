document.addEventListener('DOMContentLoaded', () => {
  const content_delay = 150;

  document.querySelectorAll('[data_blog_reveal]').forEach((el, i) => {
    setTimeout(() => {
      el.classList.add('is_visible');
    }, content_delay + i * 250);
  });
});
