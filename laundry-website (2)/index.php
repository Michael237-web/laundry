<?php
// No PHP logic needed for the frontend - just serving the HTML
// The backend APIs handle all database operations
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, viewport-fit=cover">
  <title>FreshClean Laundry - Professional Dry Cleaning & Wash & Fold</title>
  <style>
    /* ===== CSS RESET & BASE STYLES ===== */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: system-ui, -apple-system, 'Inter', 'Segoe UI', sans-serif;
      background: #f8f9fa;
      min-height: 100vh;
      line-height: 1.5;
      overflow-x: hidden;
    }

    /* ===== TYPOGRAPHY ===== */
    h1, h2, h3, h4, h5, h6 {
      font-weight: 700;
      line-height: 1.2;
    }

    /* ===== NAVBAR ===== */
    .navbar {
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      position: sticky;
      top: 0;
      z-index: 1000;
      width: 100%;
    }

    .nav-container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 0 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      min-height: 60px;
      height: auto;
    }

    @media (min-width: 768px) {
      .nav-container {
        padding: 0 2rem;
        min-height: 70px;
      }
    }

    /* Logo */
    .logo {
      font-size: 1.4rem;
      font-weight: 800;
      background: linear-gradient(135deg, #2196F3, #00BCD4);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.3rem;
      cursor: pointer;
      flex-shrink: 0;
    }

    .logo::before {
      content: "🧺";
      font-size: 1.4rem;
      background: none;
      -webkit-background-clip: unset;
      background-clip: unset;
      color: #2196F3;
    }

    @media (min-width: 768px) {
      .logo {
        font-size: 1.8rem;
      }
      .logo::before {
        font-size: 1.8rem;
      }
    }

    /* Desktop Menu */
    .nav-links {
      display: flex;
    }

    .nav-menu {
      display: flex;
      list-style: none;
      gap: 0.25rem;
    }

    .nav-item {
      position: relative;
    }

    .nav-link, .dropdown-toggle {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 0.75rem;
      color: #2c3e50;
      text-decoration: none;
      font-weight: 600;
      font-size: 0.85rem;
      background: none;
      border: none;
      cursor: pointer;
      font-family: inherit;
      transition: all 0.2s;
      border-radius: 8px;
    }

    @media (min-width: 1024px) {
      .nav-link, .dropdown-toggle {
        padding: 0.75rem 1.25rem;
        font-size: 0.95rem;
      }
    }

    .nav-link:hover, .dropdown-toggle:hover {
      background: #e3f2fd;
      color: #2196F3;
    }

    /* Dropdown arrow */
    .dropdown-arrow {
      width: 14px;
      height: 14px;
      transition: transform 0.2s;
    }

    /* ===== MEGA MENU - CENTERED & VISIBLE (NO MOVEMENT) ===== */
    .mega-menu {
      position: absolute;
      top: calc(100% + 10px);
      left: 50%;
      transform: translateX(-50%) translateY(-10px);
      width: 90vw;
      max-width: 850px;
      background: white;
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
      opacity: 0;
      visibility: hidden;
      transition: all 0.25s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      z-index: 100;
    }

    .dropdown:hover .mega-menu {
      opacity: 1;
      visibility: visible;
      transform: translateX(-50%) translateY(0);
    }

    .mega-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1rem;
      padding: 1.5rem;
    }

    @media (min-width: 768px) {
      .mega-grid {
        gap: 1.5rem;
        padding: 2rem;
      }
    }

    .mega-column {
      text-align: center;
    }

    .mega-column h4 {
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #2196F3;
      margin-bottom: 0.75rem;
      font-weight: 700;
      text-align: center;
    }

    @media (min-width: 768px) {
      .mega-column h4 {
        font-size: 0.85rem;
        margin-bottom: 1rem;
      }
    }

    .mega-column a {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      padding: 0.5rem 0.75rem;
      margin: 0.25rem 0;
      color: #2c3e50;
      text-decoration: none;
      font-size: 0.85rem;
      transition: background-color 0.2s ease;
      border-radius: 8px;
      cursor: pointer;
      background: #f8f9fa;
      text-align: center;
    }

    @media (min-width: 768px) {
      .mega-column a {
        padding: 0.6rem 0.75rem;
        font-size: 0.9rem;
        gap: 0.75rem;
        margin: 0.3rem 0;
      }
    }

    /* Clean hover effect - NO MOVEMENT */
    .mega-column a:hover {
      color: white;
      background: linear-gradient(135deg, #2196F3, #00BCD4);
    }

    .mega-column a .icon {
      font-size: 1.1rem;
    }

    .mega-cta {
      background: linear-gradient(135deg, #2196F3, #00BCD4);
      color: white !important;
      padding: 0.75rem !important;
      border-radius: 12px !important;
      margin-top: 0.5rem;
      justify-content: center;
    }

    .mega-cta:hover {
      background: linear-gradient(135deg, #00BCD4, #2196F3);
    }

    /* ===== DROPDOWN MENU ===== */
    .dropdown-menu {
      position: absolute;
      top: calc(100% + 10px);
      left: 0;
      background: white;
      min-width: 220px;
      border-radius: 16px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      padding: 0.5rem 0;
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: all 0.2s;
      list-style: none;
    }

    .dropdown:hover .dropdown-menu {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .dropdown-link {
      display: block;
      padding: 0.6rem 1.2rem;
      color: #2c3e50;
      text-decoration: none;
      font-size: 0.85rem;
      transition: all 0.2s;
      cursor: pointer;
    }

    @media (min-width: 768px) {
      .dropdown-link {
        padding: 0.7rem 1.5rem;
        font-size: 0.9rem;
      }
    }

    .dropdown-link:hover {
      background: #e3f2fd;
      padding-left: 1.5rem;
      color: #2196F3;
    }

    /* Nested Dropdown */
    .nested-dropdown {
      position: relative;
    }

    .nested-menu {
      position: absolute;
      top: 0;
      left: 100%;
      background: white;
      min-width: 200px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      padding: 0.5rem 0;
      opacity: 0;
      visibility: hidden;
      transform: translateX(-10px);
      transition: all 0.2s;
      list-style: none;
    }

    .nested-dropdown:hover .nested-menu {
      opacity: 1;
      visibility: visible;
      transform: translateX(0);
    }

    .nested-link {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.6rem 1.2rem;
      color: #2c3e50;
      text-decoration: none;
      font-size: 0.85rem;
      cursor: pointer;
    }

    /* ===== MOBILE MENU ===== */
    .mobile-menu-btn {
      display: none;
      background: none;
      border: none;
      cursor: pointer;
      padding: 0.5rem;
      z-index: 300;
      font-size: 1.6rem;
    }

    .mobile-close-btn {
      position: absolute;
      top: 0.75rem;
      right: 0.75rem;
      background: none;
      border: none;
      font-size: 1.8rem;
      cursor: pointer;
      color: #2c3e50;
      padding: 0.5rem;
      line-height: 1;
      transition: all 0.3s;
      z-index: 1001;
      display: none;
    }

    .nav-links.open .mobile-close-btn {
      display: block;
    }

    /* Mobile Styles */
    @media (max-width: 767px) {
      .mobile-menu-btn {
        display: block;
      }

      .nav-links {
        position: fixed;
        top: 0;
        right: -100%;
        width: 85%;
        max-width: 320px;
        height: 100vh;
        background: white;
        padding: 4rem 1rem 2rem;
        transition: right 0.3s ease;
        z-index: 1000;
        overflow-y: auto;
        box-shadow: -5px 0 30px rgba(0,0,0,0.1);
      }

      .nav-links.open {
        right: 0;
      }

      .nav-menu {
        flex-direction: column;
        gap: 0.25rem;
        width: 100%;
      }

      .nav-item {
        width: 100%;
      }

      .nav-link, .dropdown-toggle {
        width: 100%;
        justify-content: flex-start;
        padding: 0.7rem 0.75rem;
        font-size: 1rem;
      }

      .dropdown-toggle {
        justify-content: space-between;
      }

      .mega-menu, .dropdown-menu, .nested-menu {
        position: static;
        opacity: 1;
        visibility: visible;
        transform: none;
        width: 100%;
        box-shadow: none;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
        background: #f8f9fa;
        margin-top: 0.25rem;
        border-radius: 10px;
        padding: 0;
      }

      .mega-menu.open, .dropdown-menu.open, .nested-menu.open {
        max-height: 800px;
        padding: 0.75rem;
      }

      .mega-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
        padding: 0;
      }

      .mega-column {
        margin-bottom: 0.5rem;
      }

      .mega-column h4 {
        font-size: 1rem;
        margin-bottom: 0.5rem;
        padding-bottom: 0.3rem;
        border-bottom: 2px solid #2196F3;
        display: inline-block;
        text-align: center;
        width: auto;
      }

      .mega-column a {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 0.5rem;
        margin: 0.3rem 0;
        font-size: 0.95rem;
        min-height: 48px;
        background: #f8f9fa;
        border-radius: 10px;
        text-align: center;
        transition: background-color 0.2s ease;
      }

      .mega-column a:active {
        background: linear-gradient(135deg, #2196F3, #00BCD4);
        color: white;
      }

      .mega-column a .icon {
        font-size: 1.2rem;
      }

      .dropdown-link {
        padding: 0.6rem 0.75rem;
        font-size: 0.9rem;
      }

      .nested-menu {
        margin-left: 0.75rem;
      }

      .nested-link {
        padding: 0.6rem 0.75rem;
      }
    }

    /* Tablet Styles */
    @media (min-width: 768px) and (max-width: 1023px) {
      .nav-link, .dropdown-toggle {
        padding: 0.5rem 0.8rem;
        font-size: 0.85rem;
      }
      
      .mega-menu {
        width: 700px;
      }
      
      .mega-grid {
        gap: 1rem;
        padding: 1.25rem;
      }
    }

    /* Overlay */
    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 999;
      opacity: 0;
      visibility: hidden;
      transition: 0.3s;
    }

    .overlay.open {
      opacity: 1;
      visibility: visible;
    }

    /* ===== MAIN CONTENT ===== */
    .main-content {
      min-height: 70vh;
      transition: opacity 0.3s ease;
    }

    .page {
      display: none;
      animation: fadeIn 0.5s ease;
    }

    .page.active-page {
      display: block;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* ===== HERO SECTION ===== */
    .hero {
      background: linear-gradient(135deg, #2196F3 0%, #00BCD4 100%);
      color: white;
      padding: 3rem 1rem;
      text-align: center;
    }

    @media (min-width: 768px) {
      .hero {
        padding: 5rem 2rem;
      }
    }

    @media (min-width: 1024px) {
      .hero {
        padding: 6rem 2rem;
      }
    }

    .hero-content {
      max-width: 800px;
      margin: 0 auto;
    }

    .hero h1 {
      font-size: 1.8rem;
      margin-bottom: 0.75rem;
    }

    @media (min-width: 480px) {
      .hero h1 {
        font-size: 2.2rem;
      }
    }

    @media (min-width: 768px) {
      .hero h1 {
        font-size: 3rem;
      }
    }

    @media (min-width: 1024px) {
      .hero h1 {
        font-size: 3.5rem;
      }
    }

    .hero p {
      font-size: 0.95rem;
      margin-bottom: 1.5rem;
      opacity: 0.95;
    }

    @media (min-width: 768px) {
      .hero p {
        font-size: 1.2rem;
        margin-bottom: 2rem;
      }
    }

    .cta-button {
      display: inline-block;
      padding: 0.75rem 1.5rem;
      background: white;
      color: #2196F3;
      text-decoration: none;
      border-radius: 50px;
      font-weight: 700;
      transition: all 0.3s;
      cursor: pointer;
      border: none;
      font-size: 0.9rem;
    }

    @media (min-width: 768px) {
      .cta-button {
        padding: 1rem 2rem;
        font-size: 1rem;
      }
    }

    .cta-button:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    /* ===== FEATURES SECTION ===== */
    .features {
      padding: 3rem 1rem;
      background: white;
    }

    @media (min-width: 768px) {
      .features {
        padding: 5rem 2rem;
      }
    }

    .section-title {
      text-align: center;
      font-size: 1.8rem;
      margin-bottom: 2rem;
      color: #2c3e50;
    }

    @media (min-width: 768px) {
      .section-title {
        font-size: 2.5rem;
        margin-bottom: 3rem;
      }
    }

    .features-grid {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr;
      gap: 1rem;
    }

    @media (min-width: 480px) {
      .features-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
      }
    }

    @media (min-width: 768px) {
      .features-grid {
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
      }
    }

    .feature-card {
      text-align: center;
      padding: 1.5rem;
      background: #f8f9fa;
      border-radius: 20px;
      transition: transform 0.3s;
    }

    @media (min-width: 768px) {
      .feature-card {
        padding: 2rem;
      }
    }

    .feature-card:hover {
      transform: translateY(-5px);
    }

    .feature-icon {
      font-size: 2.5rem;
      margin-bottom: 0.75rem;
    }

    @media (min-width: 768px) {
      .feature-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
      }
    }

    .feature-card h3 {
      font-size: 1.1rem;
      margin-bottom: 0.5rem;
      color: #2c3e50;
    }

    @media (min-width: 768px) {
      .feature-card h3 {
        font-size: 1.25rem;
      }
    }

    .feature-card p {
      font-size: 0.85rem;
      color: #7f8c8d;
    }

    @media (min-width: 768px) {
      .feature-card p {
        font-size: 0.95rem;
      }
    }

    /* ===== PRICING SECTION ===== */
    .pricing {
      padding: 3rem 1rem;
      background: #f0f7ff;
    }

    @media (min-width: 768px) {
      .pricing {
        padding: 5rem 2rem;
      }
    }

    .pricing-grid {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr;
      gap: 1.5rem;
    }

    @media (min-width: 640px) {
      .pricing-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (min-width: 1024px) {
      .pricing-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
      }
    }

    .pricing-card {
      background: white;
      border-radius: 20px;
      padding: 1.5rem;
      text-align: center;
      transition: transform 0.3s;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    @media (min-width: 768px) {
      .pricing-card {
        padding: 2rem;
      }
    }

    .pricing-card:hover {
      transform: translateY(-5px);
    }

    .pricing-card.popular {
      border: 2px solid #2196F3;
      position: relative;
    }

    .popular-badge {
      position: absolute;
      top: -12px;
      left: 50%;
      transform: translateX(-50%);
      background: #2196F3;
      color: white;
      padding: 0.25rem 0.75rem;
      border-radius: 20px;
      font-size: 0.7rem;
      font-weight: 600;
      white-space: nowrap;
    }

    @media (min-width: 768px) {
      .popular-badge {
        padding: 0.3rem 1rem;
        font-size: 0.8rem;
      }
    }

    .price {
      font-size: 2rem;
      color: #2196F3;
      margin: 0.75rem 0;
    }

    @media (min-width: 768px) {
      .price {
        font-size: 3rem;
        margin: 1rem 0;
      }
    }

    .pricing-card ul {
      list-style: none;
      margin: 1.5rem 0;
    }

    @media (min-width: 768px) {
      .pricing-card ul {
        margin: 2rem 0;
      }
    }

    .pricing-card li {
      padding: 0.4rem 0;
      font-size: 0.85rem;
      color: #7f8c8d;
    }

    @media (min-width: 768px) {
      .pricing-card li {
        padding: 0.5rem 0;
        font-size: 0.95rem;
      }
    }

    .pricing-btn {
      display: inline-block;
      padding: 0.6rem 1.25rem;
      background: #2196F3;
      color: white;
      text-decoration: none;
      border-radius: 50px;
      font-weight: 600;
      transition: all 0.3s;
      cursor: pointer;
      border: none;
      font-size: 0.85rem;
    }

    @media (min-width: 768px) {
      .pricing-btn {
        padding: 0.8rem 1.5rem;
        font-size: 1rem;
      }
    }

    /* ===== HOW IT WORKS ===== */
    .how-it-works {
      padding: 3rem 1rem;
      background: white;
    }

    @media (min-width: 768px) {
      .how-it-works {
        padding: 5rem 2rem;
      }
    }

    .steps {
      max-width: 1000px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr;
      gap: 1.5rem;
    }

    @media (min-width: 480px) {
      .steps {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (min-width: 768px) {
      .steps {
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
      }
    }

    .step {
      text-align: center;
    }

    .step-number {
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, #2196F3, #00BCD4);
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.3rem;
      font-weight: bold;
      margin: 0 auto 0.75rem;
    }

    @media (min-width: 768px) {
      .step-number {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
        margin-bottom: 1rem;
      }
    }

    .step h3 {
      font-size: 1rem;
      margin-bottom: 0.25rem;
    }

    @media (min-width: 768px) {
      .step h3 {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
      }
    }

    .step p {
      font-size: 0.8rem;
      color: #7f8c8d;
    }

    @media (min-width: 768px) {
      .step p {
        font-size: 0.9rem;
      }
    }

    /* ===== SERVICE DETAIL ===== */
    .service-detail {
      padding: 2rem 1rem;
      background: white;
    }

    @media (min-width: 768px) {
      .service-detail {
        padding: 4rem 2rem;
      }
    }

    .service-header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .service-icon {
      font-size: 3rem;
      margin-bottom: 0.75rem;
    }

    @media (min-width: 768px) {
      .service-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
      }
    }

    .service-description {
      max-width: 800px;
      margin: 0 auto;
      line-height: 1.6;
      color: #5a6c7e;
      font-size: 0.9rem;
      padding: 0 1rem;
    }

    @media (min-width: 768px) {
      .service-description {
        font-size: 1rem;
        line-height: 1.8;
        padding: 0;
      }
    }

    /* ===== BOOKING FORM ===== */
    .booking-form {
      max-width: 600px;
      margin: 0 auto;
      background: white;
      padding: 1.5rem;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    @media (min-width: 768px) {
      .booking-form {
        padding: 2rem;
      }
    }

    .form-group {
      margin-bottom: 1rem;
    }

    @media (min-width: 768px) {
      .form-group {
        margin-bottom: 1.5rem;
      }
    }

    .form-group label {
      display: block;
      margin-bottom: 0.3rem;
      font-weight: 600;
      color: #2c3e50;
      font-size: 0.85rem;
    }

    @media (min-width: 768px) {
      .form-group label {
        margin-bottom: 0.5rem;
        font-size: 1rem;
      }
    }

    .form-group input, .form-group select, .form-group textarea {
      width: 100%;
      padding: 0.6rem;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 0.9rem;
      font-family: inherit;
    }

    @media (min-width: 768px) {
      .form-group input, .form-group select, .form-group textarea {
        padding: 0.75rem;
        font-size: 1rem;
      }
    }

    .submit-btn {
      width: 100%;
      padding: 0.75rem;
      background: linear-gradient(135deg, #2196F3, #00BCD4);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: transform 0.2s;
    }

    @media (min-width: 768px) {
      .submit-btn {
        padding: 1rem;
        font-size: 1.1rem;
      }
    }

    /* ===== CONTACT PAGE ===== */
    .contact-info {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1rem;
      max-width: 1200px;
      margin: 0 auto;
      padding: 1rem;
    }

    @media (min-width: 480px) {
      .contact-info {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (min-width: 768px) {
      .contact-info {
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        padding: 2rem;
      }
    }

    @media (min-width: 1024px) {
      .contact-info {
        grid-template-columns: repeat(4, 1fr);
      }
    }

    .contact-card {
      text-align: center;
      padding: 1.5rem;
      background: #f8f9fa;
      border-radius: 20px;
    }

    @media (min-width: 768px) {
      .contact-card {
        padding: 2rem;
      }
    }

    .contact-card[style*="grid-column: span 3"] {
      grid-column: span 1 !important;
    }

    @media (min-width: 768px) {
      .contact-card[style*="grid-column: span 3"] {
        grid-column: span 3 !important;
      }
    }

    .contact-icon {
      font-size: 2.5rem;
      margin-bottom: 0.75rem;
    }

    @media (min-width: 768px) {
      .contact-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
      }
    }

    /* ===== LOCATIONS PAGE ===== */
    .locations-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1rem;
      max-width: 1200px;
      margin: 0 auto;
      padding: 1rem;
    }

    @media (min-width: 480px) {
      .locations-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (min-width: 768px) {
      .locations-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        padding: 2rem;
      }
    }

    .location-card {
      padding: 1.5rem;
      background: #f8f9fa;
      border-radius: 20px;
      text-align: center;
    }

    @media (min-width: 768px) {
      .location-card {
        padding: 2rem;
      }
    }

    /* ===== FOOTER ===== */
    .footer {
      background: #1a1a2e;
      color: white;
      padding: 2rem 1rem 1rem;
    }

    @media (min-width: 768px) {
      .footer {
        padding: 3rem 2rem 1rem;
      }
    }

    .footer-content {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr;
      gap: 1.5rem;
      margin-bottom: 1.5rem;
    }

    @media (min-width: 480px) {
      .footer-content {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (min-width: 768px) {
      .footer-content {
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
        margin-bottom: 2rem;
      }
    }

    .footer-section h4 {
      font-size: 1rem;
      margin-bottom: 0.75rem;
    }

    @media (min-width: 768px) {
      .footer-section h4 {
        font-size: 1.1rem;
        margin-bottom: 1rem;
      }
    }

    .footer-section a, .footer-section p {
      color: #ccc;
      text-decoration: none;
      display: block;
      margin-bottom: 0.4rem;
      cursor: pointer;
      font-size: 0.8rem;
    }

    @media (min-width: 768px) {
      .footer-section a, .footer-section p {
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
      }
    }

    .footer-section a:hover {
      color: #2196F3;
    }

    .copyright {
      text-align: center;
      padding-top: 1rem;
      border-top: 1px solid #333;
      color: #888;
      font-size: 0.7rem;
    }

    @media (min-width: 768px) {
      .copyright {
        padding-top: 2rem;
        font-size: 0.8rem;
      }
    }

    /* Loading spinner */
    .loading {
      display: inline-block;
      width: 16px;
      height: 16px;
      border: 2px solid rgba(255,255,255,.3);
      border-radius: 50%;
      border-top-color: white;
      animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
</head>
<body>

<nav class="navbar">
  <div class="nav-container">
    <a class="logo" data-page="home">FreshClean</a>

    <button class="mobile-menu-btn" id="mobileMenuBtn">☰</button>

    <div class="nav-links" id="navLinks">
      <button class="mobile-close-btn" id="mobileCloseBtn">✕</button>
      
      <ul class="nav-menu">
        <li class="nav-item"><a class="nav-link" data-page="home">🏠 Home</a></li>

        <li class="nav-item dropdown">
          <button class="dropdown-toggle">
            🧺 Services
            <svg class="dropdown-arrow" viewBox="0 0 20 20" fill="currentColor" width="14" height="14">
              <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
            </svg>
          </button>
          
          <div class="mega-menu">
            <div class="mega-grid">
              <div class="mega-column">
                <h4>👕 Wash & Fold</h4>
                <a data-service="everyday-laundry"><span class="icon">👕</span> Everyday Laundry</a>
                <a data-service="dress-shirts"><span class="icon">👔</span> Dress Shirts</a>
                <a data-service="denim-jeans"><span class="icon">👖</span> Denim & Jeans</a>
                <a data-service="socks-underwear"><span class="icon">🧦</span> Socks & Underwear</a>
              </div>
              <div class="mega-column">
                <h4>✨ Dry Cleaning</h4>
                <a data-service="dresses-gowns"><span class="icon">👗</span> Dresses & Gowns</a>
                <a data-service="coats-jackets"><span class="icon">🧥</span> Coats & Jackets</a>
                <a data-service="suits-blazers"><span class="icon">👔</span> Suits & Blazers</a>
                <a data-service="wedding-dresses"><span class="icon">👰</span> Wedding Dresses</a>
              </div>
              <div class="mega-column">
                <h4>🏠 Home & More</h4>
                <a data-service="bed-sheets"><span class="icon">🛏️</span> Bed Sheets</a>
                <a data-service="towels"><span class="icon">🚿</span> Towels</a>
                <a data-service="curtains"><span class="icon">🪑</span> Curtains</a>
                <a class="mega-cta" data-page="booking">🎁 Schedule Pickup →</a>
              </div>
            </div>
          </div>
        </li>

        <li class="nav-item dropdown">
          <button class="dropdown-toggle">
            💰 Pricing
            <svg class="dropdown-arrow" viewBox="0 0 20 20" fill="currentColor" width="14" height="14">
              <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
            </svg>
          </button>
          
          <ul class="dropdown-menu">
            <li><a class="dropdown-link" data-page="pricing">💰 Standard Pricing</a></li>
            <li><a class="dropdown-link" data-page="pricing">⭐ Premium Plans</a></li>
            <li class="nested-dropdown">
              <a class="dropdown-link nested-link">
                📦 Special Offers ⭢
              </a>
              <ul class="nested-menu">
                <li><a class="dropdown-link" data-offer="first-order">🎉 First Order 20% Off</a></li>
                <li><a class="dropdown-link" data-offer="family-plan">👨‍👩‍👧‍👦 Family Plan</a></li>
                <li class="nested-dropdown">
                  <a class="dropdown-link nested-link">
                    🎓 Student Discount ⭢
                  </a>
                  <ul class="nested-menu">
                    <li><a class="dropdown-link" data-offer="high-school">High School</a></li>
                    <li><a class="dropdown-link" data-offer="college">College</a></li>
                    <li><a class="dropdown-link" data-offer="university">University</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a class="dropdown-link" data-page="pricing">🏪 Commercial</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <button class="dropdown-toggle">
            📍 Locations
            <svg class="dropdown-arrow" viewBox="0 0 20 20" fill="currentColor" width="14" height="14">
              <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
            </svg>
          </button>
          
          <ul class="dropdown-menu">
            <li><a class="dropdown-link" data-location="downtown">📍 Downtown</a></li>
            <li><a class="dropdown-link" data-location="uptown">📍 Uptown</a></li>
            <li><a class="dropdown-link" data-location="westside">📍 Westside</a></li>
            <li><a class="dropdown-link" data-location="eastside">📍 Eastside</a></li>
            <li><a class="dropdown-link" data-location="pickup-zone">🚚 Free Pickup Zone</a></li>
          </ul>
        </li>

        <li class="nav-item"><a class="nav-link" data-page="contact">📞 Contact</a></li>
        <li class="nav-item"><a class="nav-link" data-page="booking" style="background: #2196F3; color: white; border-radius: 50px;">🚀 Book Now</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="overlay" id="overlay"></div>

<div class="main-content">
  
  <!-- HOME PAGE -->
  <div id="home-page" class="page active-page">
    <section class="hero">
      <div class="hero-content">
        <h1>Fresh & Clean Laundry<br>Delivered to Your Door</h1>
        <p>Professional dry cleaning, wash & fold, and home pickup. We handle your clothes with care.</p>
        <button class="cta-button" data-page="booking">🚀 Schedule Free Pickup →</button>
      </div>
    </section>

    <section class="features">
      <h2 class="section-title">Why Choose FreshClean?</h2>
      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon">🚚</div>
          <h3>Free Pickup & Delivery</h3>
          <p>We come to your door, no extra charge</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">⚡</div>
          <h3>24-Hour Service</h3>
          <p>Get your laundry back the next day</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">🌿</div>
          <h3>Eco-Friendly</h3>
          <p>Biodegradable detergents & energy efficient</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">🔒</div>
          <h3>100% Guaranteed</h3>
          <p>Stain removal or we redo it free</p>
        </div>
      </div>
    </section>

    <section class="pricing">
      <h2 class="section-title">Simple, Transparent Pricing</h2>
      <div class="pricing-grid">
        <div class="pricing-card">
          <h3>Wash & Fold</h3>
          <div class="price">$1.99/lb</div>
          <ul>
            <li>✓ Free pickup & delivery</li>
            <li>✓ Same-day service</li>
            <li>✓ Hypoallergenic detergent</li>
            <li>✓ Folded & bagged</li>
          </ul>
          <button class="pricing-btn" data-page="booking">Choose Plan</button>
        </div>
        <div class="pricing-card popular">
          <div class="popular-badge">Most Popular</div>
          <h3>Dry Cleaning</h3>
          <div class="price">$4.99/item</div>
          <ul>
            <li>✓ Professional pressing</li>
            <li>✓ Stain treatment included</li>
            <li>✓ Eco-friendly solvents</li>
            <li>✓ Hanging & bagged</li>
          </ul>
          <button class="pricing-btn" data-page="booking">Choose Plan</button>
        </div>
        <div class="pricing-card">
          <h3>Subscription</h3>
          <div class="price">$49<span style="font-size:0.8rem">/mo</span></div>
          <ul>
            <li>✓ 30lbs wash & fold</li>
            <li>✓ 5 dry cleaning items</li>
            <li>✓ Priority support</li>
            <li>✓ Save 25%</li>
          </ul>
          <button class="pricing-btn" data-page="booking">Choose Plan</button>
        </div>
      </div>
    </section>

    <section class="how-it-works">
      <h2 class="section-title">How It Works</h2>
      <div class="steps">
        <div class="step">
          <div class="step-number">1</div>
          <h3>Schedule Pickup</h3>
          <p>Choose a time that works for you</p>
        </div>
        <div class="step">
          <div class="step-number">2</div>
          <h3>We Collect</h3>
          <p>Driver picks up from your door</p>
        </div>
        <div class="step">
          <div class="step-number">3</div>
          <h3>We Clean</h3>
          <p>Professional care for your clothes</p>
        </div>
        <div class="step">
          <div class="step-number">4</div>
          <h3>Delivered Back</h3>
          <p>Fresh & folded to your door</p>
        </div>
      </div>
    </section>
  </div>

  <!-- BOOKING PAGE -->
  <div id="booking-page" class="page">
    <section class="hero" style="padding: 2rem 1rem;">
      <div class="hero-content">
        <h1>📅 Schedule Your Pickup</h1>
        <p>Fill out the form below and we'll collect your laundry</p>
      </div>
    </section>
    <section class="service-detail">
      <div class="booking-form">
        <form id="bookingForm">
          <div class="form-group">
            <label>Full Name *</label>
            <input type="text" id="name" required>
          </div>
          <div class="form-group">
            <label>Email *</label>
            <input type="email" id="email" required>
          </div>
          <div class="form-group">
            <label>Phone Number *</label>
            <input type="tel" id="phone" required>
          </div>
          <div class="form-group">
            <label>Address *</label>
            <input type="text" id="address" required>
          </div>
          <div class="form-group">
            <label>Service Type *</label>
            <select id="service">
              <option value="Wash & Fold">Wash & Fold ($1.99/lb)</option>
              <option value="Dry Cleaning">Dry Cleaning ($4.99/item)</option>
              <option value="Subscription">Subscription ($49/month)</option>
            </select>
          </div>
          <div class="form-group">
            <label>Pickup Date *</label>
            <input type="date" id="date" required>
          </div>
          <div class="form-group">
            <label>Special Instructions</label>
            <textarea id="instructions" rows="3" placeholder="Any special requests?"></textarea>
          </div>
          <button type="submit" class="submit-btn" id="bookingSubmitBtn">✅ Confirm Booking</button>
        </form>
      </div>
    </section>
  </div>

  <!-- CONTACT PAGE -->
  <div id="contact-page" class="page">
    <section class="hero" style="padding: 2rem 1rem;">
      <div class="hero-content">
        <h1>📞 Contact Us</h1>
        <p>We're here to help 24/7</p>
      </div>
    </section>
    <div class="contact-info">
      <div class="contact-card">
        <div class="contact-icon">📞</div>
        <h3>Phone</h3>
        <p>+254 740463326</p>
        <p>Mon-Sun: 7am-8pm</p>
      </div>
      <div class="contact-card">
        <div class="contact-icon">✉️</div>
        <h3>Email</h3>
        <p>hello@freshclean.com</p>
        <p>support@freshclean.com</p>
      </div>
      <div class="contact-card">
        <div class="contact-icon">💬</div>
        <h3>Live Chat</h3>
        <p>Click the chat icon</p>
        <p>Available 24/7</p>
      </div>
      <div class="contact-card" style="grid-column: span 3;">
        <div class="contact-icon">✉️</div>
        <h3>Send us a Message</h3>
        <form id="contactForm" style="margin-top: 1rem;">
          <div class="form-group">
            <input type="text" id="contactName" placeholder="Your Name" required>
          </div>
          <div class="form-group">
            <input type="email" id="contactEmail" placeholder="Your Email" required>
          </div>
          <div class="form-group">
            <input type="text" id="contactSubject" placeholder="Subject" required>
          </div>
          <div class="form-group">
            <textarea id="contactMessage" rows="4" placeholder="Your Message" required></textarea>
          </div>
          <button type="submit" class="submit-btn" id="contactSubmitBtn">Send Message →</button>
        </form>
      </div>
    </div>
  </div>

  <!-- PRICING PAGE -->
  <div id="pricing-page" class="page">
    <section class="hero" style="padding: 2rem 1rem;">
      <div class="hero-content">
        <h1>💰 Our Pricing Plans</h1>
        <p>Simple, transparent pricing for all your laundry needs</p>
      </div>
    </section>
    <section class="pricing">
      <div class="pricing-grid">
        <div class="pricing-card">
          <h3>Wash & Fold</h3>
          <div class="price">$1.99/lb</div>
          <ul>
            <li>✓ Free pickup & delivery</li>
            <li>✓ Same-day service</li>
            <li>✓ Hypoallergenic detergent</li>
            <li>✓ Folded & bagged</li>
          </ul>
          <button class="pricing-btn" data-page="booking">Choose Plan</button>
        </div>
        <div class="pricing-card popular">
          <div class="popular-badge">Most Popular</div>
          <h3>Dry Cleaning</h3>
          <div class="price">$4.99/item</div>
          <ul>
            <li>✓ Professional pressing</li>
            <li>✓ Stain treatment included</li>
            <li>✓ Eco-friendly solvents</li>
            <li>✓ Hanging & bagged</li>
          </ul>
          <button class="pricing-btn" data-page="booking">Choose Plan</button>
        </div>
        <div class="pricing-card">
          <h3>Subscription</h3>
          <div class="price">$49<span style="font-size:0.8rem">/mo</span></div>
          <ul>
            <li>✓ 30lbs wash & fold</li>
            <li>✓ 5 dry cleaning items</li>
            <li>✓ Priority support</li>
            <li>✓ Save 25%</li>
          </ul>
          <button class="pricing-btn" data-page="booking">Choose Plan</button>
        </div>
      </div>
    </section>
  </div>

  <!-- LOCATION PAGE -->
  <div id="location-page" class="page">
    <section class="hero" style="padding: 2rem 1rem;">
      <div class="hero-content">
        <h1 id="location-title">📍 Our Locations</h1>
        <p id="location-description">Visit us at any of our convenient locations</p>
      </div>
    </section>
    <div class="locations-grid" id="locations-grid"></div>
  </div>

  <!-- SERVICE DETAIL PAGE -->
  <div id="service-page" class="page">
    <section class="service-detail">
      <div class="service-header">
        <div class="service-icon" id="service-icon">👕</div>
        <h1 id="service-name">Service Name</h1>
        <div class="service-description" id="service-description">
          Service description will appear here.
        </div>
        <button class="cta-button" data-page="booking" style="margin-top: 1.5rem;">Book This Service →</button>
      </div>
    </section>
  </div>

</div>

<footer class="footer">
  <div class="footer-content">
    <div class="footer-section">
      <h4>🧺 FreshClean Laundry</h4>
      <p>Professional laundry & dry cleaning since 2020</p>
    </div>
    <div class="footer-section">
      <h4>Quick Links</h4>
      <a data-page="home">Home</a>
      <a data-page="pricing">Pricing</a>
      <a data-page="contact">Contact</a>
      <a data-page="booking">Book Now</a>
    </div>
    <div class="footer-section">
      <h4>Contact</h4>
      <a>📞 (+254) 740463326</a>
      <a>✉️ hello@freshclean.com</a>
      <a>📍 Kenyatta Avenue, Nairobi, Kenya</a>
    </div>
    <div class="footer-section">
      <h4>Hours</h4>
      <p>Mon-Fri: 7am - 8pm</p>
      <p>Sat: 8am - 6pm</p>
      <p>Sun: 9am - 5pm</p>
    </div>
  </div>
  <div class="copyright">
    © FreshClean Laundry. All rights reserved.
  </div>
</footer>

<script>
  // DOM Elements
  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  const mobileCloseBtn = document.getElementById('mobileCloseBtn');
  const navLinks = document.getElementById('navLinks');
  const overlay = document.getElementById('overlay');
  
  function closeMobileMenu() {
    navLinks.classList.remove('open');
    overlay.classList.remove('open');
    document.body.style.overflow = '';
  }
  
  function openMobileMenu() {
    navLinks.classList.add('open');
    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
  }
  
  if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', openMobileMenu);
  if (mobileCloseBtn) mobileCloseBtn.addEventListener('click', closeMobileMenu);
  if (overlay) overlay.addEventListener('click', closeMobileMenu);
  
  // Mobile dropdowns
  document.querySelectorAll('.dropdown, .nested-dropdown').forEach(dropdown => {
    const toggle = dropdown.querySelector('.dropdown-toggle, .nested-link');
    const menu = dropdown.querySelector('.mega-menu, .dropdown-menu, .nested-menu');
    
    if (toggle && menu) {
      toggle.addEventListener('click', (e) => {
        if (window.innerWidth <= 767) {
          e.preventDefault();
          e.stopPropagation();
          document.querySelectorAll('.mega-menu.open, .dropdown-menu.open, .nested-menu.open').forEach(openMenu => {
            if (openMenu !== menu) openMenu.classList.remove('open');
          });
          menu.classList.toggle('open');
        }
      });
    }
  });
  
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && navLinks.classList.contains('open')) closeMobileMenu();
  });
  
  // Data
  const services = {
    'everyday-laundry': { name: 'Everyday Laundry', icon: '👕', desc: 'Your regular laundry done with care. We separate whites, colors, and delicates. Machine wash with premium detergents, dried to perfection, and folded neatly.' },
    'dress-shirts': { name: 'Dress Shirts', icon: '👔', desc: 'Professional pressing for your dress shirts. We starch on request and hang them to prevent wrinkles.' },
    'denim-jeans': { name: 'Denim & Jeans', icon: '👖', desc: 'Special care for your denim. Inside-out washing, air drying when requested, and folded to maintain shape.' },
    'socks-underwear': { name: 'Socks & Underwear', icon: '🧦', desc: 'Hygienic cleaning for your intimates. We use hypoallergenic detergents.' },
    'dresses-gowns': { name: 'Dresses & Gowns', icon: '👗', desc: 'Expert dry cleaning for formal wear. We inspect each garment and use gentle solvents.' },
    'coats-jackets': { name: 'Coats & Jackets', icon: '🧥', desc: 'Professional cleaning for outerwear. We remove winter salt stains and refresh insulation.' },
    'suits-blazers': { name: 'Suits & Blazers', icon: '👔', desc: 'Full suit service including jacket, trousers, and vest. Expert pressing and shaping.' },
    'wedding-dresses': { name: 'Wedding Dresses', icon: '👰', desc: 'Preservation-quality cleaning for your special gown.' },
    'bed-sheets': { name: 'Bed Sheets', icon: '🛏️', desc: 'Fresh, crisp sheets. High-temperature wash to kill allergens.' },
    'towels': { name: 'Towels', icon: '🚿', desc: 'Fluffy, absorbent towels. No fabric softeners to maintain absorption.' },
    'curtains': { name: 'Curtains', icon: '🪑', desc: 'Delicate curtain cleaning. We remove dust and allergens without shrinking.' }
  };
  
  const locations = {
    'downtown': { name: 'Downtown Location', hours: 'Mon-Sat: 8am-7pm', address: '123 Main Street, Downtown' },
    'uptown': { name: 'Uptown Location', hours: 'Mon-Sun: 9am-8pm', address: '456 Oak Avenue, Uptown' },
    'westside': { name: 'Westside Location', hours: 'Mon-Fri: 7am-6pm', address: '789 Pine Road, Westside' },
    'eastside': { name: 'Eastside Location', hours: 'Mon-Sat: 9am-7pm', address: '321 Elm Street, Eastside' },
    'pickup-zone': { name: 'Free Pickup Zone', hours: '7 days a week', address: 'We come to your door! Free pickup within 5 miles' }
  };
  
  function navigateTo(page) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active-page'));
    const targetPage = document.getElementById(`${page}-page`);
    if (targetPage) targetPage.classList.add('active-page');
    closeMobileMenu();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
  
  function showService(serviceId) {
    const service = services[serviceId];
    if (service) {
      document.getElementById('service-icon').textContent = service.icon;
      document.getElementById('service-name').textContent = service.name;
      document.getElementById('service-description').innerHTML = `<p>${service.desc}</p><p style="margin-top: 1rem;"><strong>Price:</strong> Starting at $4.99</p><p><strong>Turnaround:</strong> 24-48 hours</p>`;
      navigateTo('service');
    }
  }
  
  function showLocation(locationId) {
    const location = locations[locationId];
    if (location) {
      document.getElementById('location-title').innerHTML = `📍 ${location.name}`;
      document.getElementById('location-description').innerHTML = `${location.hours}<br>${location.address}`;
      
      const gridHtml = Object.entries(locations).map(([id, loc]) => `
        <div class="location-card">
          <div class="feature-icon">📍</div>
          <h3>${loc.name}</h3>
          <p>${loc.hours}</p>
          <p>${loc.address}</p>
          <button class="pricing-btn" style="margin-top: 1rem;" data-location="${id}">View Details</button>
        </div>
      `).join('');
      
      document.getElementById('locations-grid').innerHTML = gridHtml;
      document.querySelectorAll('[data-location]').forEach(el => {
        el.addEventListener('click', (e) => showLocation(el.getAttribute('data-location')));
      });
      navigateTo('location');
    }
  }
  
  function showOffer(offerId) {
    const offers = {
      'first-order': { title: '🎉 First Order 20% Off', desc: 'Use code: FRESH20 on your first order! Minimum $20 purchase.' },
      'family-plan': { title: '👨‍👩‍👧‍👦 Family Plan', desc: 'Save 15% on all services for families of 4+. Call us to enroll.' },
      'high-school': { title: 'High School Discount', desc: '10% off with valid student ID.' },
      'college': { title: 'College Discount', desc: '15% off for college students. Show your .edu email.' },
      'university': { title: 'University Discount', desc: '20% off for university students. Bulk pickup available for dorms.' }
    };
    const offer = offers[offerId];
    if (offer) alert(`${offer.title}\n\n${offer.desc}`);
  }
  
  // Form submissions
  const bookingForm = document.getElementById('bookingForm');
  if (bookingForm) {
    bookingForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const name = document.getElementById('name')?.value.trim();
      const email = document.getElementById('email')?.value.trim();
      const phone = document.getElementById('phone')?.value.trim();
      const address = document.getElementById('address')?.value.trim();
      const date = document.getElementById('date')?.value;
      
      if (!name || !email || !phone || !address || !date) {
        alert('❌ Please fill in all required fields.');
        return;
      }
      if (!email.includes('@')) {
        alert('❌ Please enter a valid email address.');
        return;
      }
      
      const submitBtn = document.getElementById('bookingSubmitBtn');
      const originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = '<span class="loading"></span> Processing...';
      submitBtn.disabled = true;
      
      try {
        const response = await fetch('backend/save_booking.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            name, email, phone, address,
            service_type: document.getElementById('service')?.value,
            pickup_date: date,
            special_instructions: document.getElementById('instructions')?.value || ''
          })
        });
        const result = await response.json();
        if (result.success) {
          alert(`✅ Booking Confirmed!\n\nBooking ID: #${result.booking_id}`);
          bookingForm.reset();
          navigateTo('home');
        } else {
          alert('❌ Error: ' + (result.error || 'Unknown error'));
        }
      } catch (error) {
        alert('❌ Unable to complete booking. Please try again.');
      } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
      }
    });
  }
  
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const name = document.getElementById('contactName')?.value.trim();
      const email = document.getElementById('contactEmail')?.value.trim();
      const subject = document.getElementById('contactSubject')?.value.trim();
      const message = document.getElementById('contactMessage')?.value.trim();
      
      if (!name || !email || !subject || !message) {
        alert('❌ Please fill in all fields.');
        return;
      }
      
      const submitBtn = document.getElementById('contactSubmitBtn');
      const originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = '<span class="loading"></span> Sending...';
      submitBtn.disabled = true;
      
      try {
        const response = await fetch('backend/save_contact.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ name, email, subject, message })
        });
        const result = await response.json();
        if (result.success) {
          alert('✅ Message sent successfully! We\'ll get back to you within 24 hours.');
          contactForm.reset();
        } else {
          alert('❌ Error sending message.');
        }
      } catch (error) {
        alert('❌ Unable to send message. Please try again.');
      } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
      }
    });
  }
  
  // Navigation clicks
  document.addEventListener('click', (e) => {
    const pageLink = e.target.closest('[data-page]');
    const serviceLink = e.target.closest('[data-service]');
    const locationLink = e.target.closest('[data-location]');
    const offerLink = e.target.closest('[data-offer]');
    
    if (pageLink) { e.preventDefault(); navigateTo(pageLink.getAttribute('data-page')); }
    else if (serviceLink) { e.preventDefault(); showService(serviceLink.getAttribute('data-service')); }
    else if (locationLink) { e.preventDefault(); showLocation(locationLink.getAttribute('data-location')); }
    else if (offerLink) { e.preventDefault(); showOffer(offerLink.getAttribute('data-offer')); }
  });
</script>

</body>
</html>