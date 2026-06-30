// Mobile menu toggle
const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const navLinks = document.getElementById('navLinks');
let overlay = document.querySelector('.overlay');

// Create overlay if not exists
if (!overlay) {
  overlay = document.createElement('div');
  overlay.className = 'overlay';
  document.body.appendChild(overlay);
}

function toggleMobileMenu() {
  const isOpen = navLinks.classList.contains('active');
  navLinks.classList.toggle('active');
  mobileMenuBtn.classList.toggle('active');
  overlay.classList.toggle('active');
  document.body.style.overflow = isOpen ? '' : 'hidden';
}

mobileMenuBtn.addEventListener('click', toggleMobileMenu);
overlay.addEventListener('click', toggleMobileMenu);

// Handle dropdown toggles on mobile
const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

dropdownToggles.forEach(toggle => {
  toggle.addEventListener('click', (e) => {
    // Only handle click toggles on mobile
    if (window.innerWidth <= 768) {
      e.preventDefault();
      const parent = toggle.closest('.dropdown');
      const dropdownMenu = parent.querySelector('.dropdown-menu');
      
      // Toggle current dropdown
      dropdownMenu.classList.toggle('active');
      
      // Update aria-expanded
      const isExpanded = dropdownMenu.classList.contains('active');
      toggle.setAttribute('aria-expanded', isExpanded);
      
      // Close other dropdowns (optional, for cleaner UX)
      document.querySelectorAll('.dropdown-menu').forEach(menu => {
        if (menu !== dropdownMenu) {
          menu.classList.remove('active');
          const otherToggle = menu.closest('.dropdown')?.querySelector('.dropdown-toggle');
          if (otherToggle) otherToggle.setAttribute('aria-expanded', 'false');
        }
      });
    }
  });
});

// Close mobile menu on window resize above breakpoint
window.addEventListener('resize', () => {
  if (window.innerWidth > 768 && navLinks.classList.contains('active')) {
    toggleMobileMenu();
    // Reset all mobile dropdowns
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
      menu.classList.remove('active');
    });
    dropdownToggles.forEach(toggle => {
      toggle.setAttribute('aria-expanded', 'false');
    });
  }
});

// Keyboard accessibility: close on Escape
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape' && navLinks.classList.contains('active')) {
    toggleMobileMenu();
  }
});