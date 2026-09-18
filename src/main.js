/**
 * VueCommerce - Vue 3 Entry Point
 *
 * Mounts Vue components vào các mount points trong WordPress templates.
 * WordPress xử lý routing, Vue chỉ handle UI components.
 */

import { createApp, h } from 'vue';
import './style.css';

// Components
import AppHeader from './components/AppHeader.vue';
import AppFooter from './components/AppFooter.vue';
import CartWidget from './components/CartWidget.vue';
import HeroSection from './components/HeroSection.vue';
import PostList from './components/PostList.vue';
import ContactForm from './components/ContactForm.vue';
import ProductGrid from './components/ProductGrid.vue';
import ProductDetail from './components/ProductDetail.vue';
import NewsletterSignup from './components/NewsletterSignup.vue';
import NewProducts from './components/NewProducts.vue';
import CategoryProducts from './components/CategoryProducts.vue';
import ProductSwiper from './components/ProductSwiper.vue';
import CategoryCarousel from './components/CategoryCarousel.vue';
import LatestPosts from './components/LatestPosts.vue';
import VideoContent from './components/VideoContent.vue';
import InstantSearch from './components/InstantSearch.vue';
import CustomerGallery from './components/CustomerGallery.vue';

/**
 * Mount a Vue component to a DOM element if it exists
 */
function mountComponent(selector, component, props = {}) {
  const el = document.querySelector(selector);
  if (!el) return null;

  const app = createApp({
    render() {
      return h(component, props);
    },
  });

  app.mount(el);
  return app;
}

/**
 * Initialize all Vue components when DOM is ready
 */
function init() {
  // Global components - always mount
  mountComponent('#vue-header', AppHeader);
  mountComponent('#vue-footer', AppFooter);

  // Cart Widget - mount to body for overlay
  const cartMountEl = document.createElement('div');
  cartMountEl.id = 'vue-cart-widget';
  document.body.appendChild(cartMountEl);
  mountComponent('#vue-cart-widget', CartWidget);

  // Page-specific components
  const wpData = window.wpVueTheme || {};

  // Home page
  if (wpData.isHome || document.querySelector('#vue-hero')) {
    mountComponent('#vue-hero', HeroSection);
    mountComponent('#vue-product-swiper', ProductSwiper);
    mountComponent('#vue-category-carousel', CategoryCarousel);
    mountComponent('#vue-new-products', NewProducts);
    mountComponent('#vue-category-products', CategoryProducts);
    mountComponent('#vue-latest-posts', LatestPosts);
    mountComponent('#vue-customer-gallery', CustomerGallery);
    mountComponent('#vue-newsletter', NewsletterSignup);
  }

  // Blog / Archive
  if (wpData.isBlog || document.querySelector('#vue-post-list')) {
    mountComponent('#vue-post-list', PostList);
  }

  // Contact
  if (wpData.isContact || document.querySelector('#vue-contact')) {
    mountComponent('#vue-contact', ContactForm);
  }

  // Shop - Product Grid
  if (wpData.isShop || document.querySelector('#vue-product-grid')) {
    mountComponent('#vue-product-grid', ProductGrid);
  }

  // Single Product - Product Detail
  if (wpData.isProduct || document.querySelector('#vue-product-detail')) {
    mountComponent('#vue-product-detail', ProductDetail);
  }

  // Video page
  if (document.querySelector('#vue-video')) {
    mountComponent('#vue-video', VideoContent);
  }

  // Instant Search Component
  if (document.querySelector('#vue-instant-search')) {
    mountComponent('#vue-instant-search', InstantSearch);
  }

  console.log('[VueCommerce] Theme initialized ✓');
}

// Wait for DOM
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
