// StockWise Retail Solutions - shared site script
// handles: mobile nav toggle, gallery lightbox, contact form validation

// ---------- mobile nav toggle ----------

const navToggle = document.querySelector(".nav-toggle");
const navMenu = document.querySelector(".nav-menu");

if (navToggle && navMenu) {
  navToggle.addEventListener("click", () => {
    const isOpen = navMenu.classList.toggle("open");
    navToggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
  });

  // close the menu after a link is clicked (useful on mobile)
  const navLinks = navMenu.querySelectorAll("a");
  navLinks.forEach((link) => {
    link.addEventListener("click", () => {
      navMenu.classList.remove("open");
      navToggle.setAttribute("aria-expanded", "false");
    });
  });
}

// ---------- gallery lightbox ----------

const galleryItems = document.querySelectorAll(".gallery-item");
const lightbox = document.querySelector(".lightbox-overlay");

if (galleryItems.length > 0 && lightbox) {
  const lightboxImg = lightbox.querySelector("img");
  const lightboxCaption = lightbox.querySelector(".lightbox-caption");
  const closeBtn = lightbox.querySelector(".lightbox-close");

  galleryItems.forEach((item) => {
    item.addEventListener("click", () => {
      const img = item.querySelector("img");
      const caption = item.querySelector("figcaption");
      lightboxImg.src = img.getAttribute("data-large") || img.src;
      lightboxImg.alt = img.alt;
      lightboxCaption.textContent = caption ? caption.textContent : "";
      lightbox.classList.add("active");
    });
  });

  const closeLightbox = () => {
    lightbox.classList.remove("active");
  };

  closeBtn.addEventListener("click", closeLightbox);

  // click outside the image box closes it
  lightbox.addEventListener("click", (e) => {
    if (e.target === lightbox) {
      closeLightbox();
    }
  });

  // escape key closes it
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      closeLightbox();
    }
  });
}

// Contact form, login, registration, and admin forms are validated by
// js/validation.js (client-side, progressive enhancement) and always
// re-checked server-side in PHP before anything touches the database.
