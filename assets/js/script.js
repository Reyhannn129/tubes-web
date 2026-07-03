// assets/js/script.js

document.addEventListener("DOMContentLoaded", () => {
  // Navbar Scroll Effect
  const navbar = document.getElementById("navbar");
  if (navbar) {
    window.addEventListener("scroll", () => {
      if (window.scrollY > 50) {
        navbar.classList.add("scrolled");
      } else {
        navbar.classList.remove("scrolled");
      }
    });
  }

  // Scroll Reveal Animation
  const revealElements = document.querySelectorAll(".reveal");
  const revealFunc = () => {
    let windowHeight = window.innerHeight;
    revealElements.forEach((el) => {
      let elementTop = el.getBoundingClientRect().top;
      let elementVisible = 150;
      if (elementTop < windowHeight - elementVisible) {
        el.classList.add("active");
      }
    });
  };
  window.addEventListener("scroll", revealFunc);
  revealFunc(); // Trigger on load

  // Admin Login Modal
  const loginBtn = document.getElementById("adminLoginBtn");
  const loginModal = document.getElementById("adminLoginModal");
  const closeModal = document.getElementById("closeLoginModal");

  if (loginBtn && loginModal) {
    loginBtn.addEventListener("click", () => {
      loginModal.classList.add("active");
    });
  }
  if (closeModal && loginModal) {
    closeModal.addEventListener("click", () => {
      loginModal.classList.remove("active");
    });
  }
  if (loginModal) {
    window.addEventListener("click", (e) => {
      if (e.target == loginModal) {
        loginModal.classList.remove("active");
      }
    });
  }
});
