import { ref, computed, watch } from 'vue';
import axios from 'axios';

/**
 * Composable: WooCommerce Cart Management
 * Uses WooCommerce Store API for cart operations
 */

// Shared cart state (singleton pattern)
const cartItems = ref([]);
const cartTotals = ref({});
const cartLoading = ref(false);
const cartError = ref(null);
const cartOpen = ref(false);

export function useCart() {
  const restUrl = window.wpVueTheme?.restUrl || '/wp-json/';

  /**
   * Get Nonce header for Store API
   */
  function getHeaders() {
    return {
      'Nonce': window.wpVueTheme?.nonce || '',
    };
  }

  /**
   * Fetch current cart
   */
  async function fetchCart() {
    cartLoading.value = true;
    cartError.value = null;

    try {
      const response = await axios.get(`${restUrl}wc/store/v1/cart`, {
        headers: getHeaders(),
      });

      cartItems.value = (response.data.items || []).map(formatCartItem);
      cartTotals.value = formatTotals(response.data.totals || {});
    } catch (err) {
      console.error('Failed to fetch cart:', err);
      // Silently fail - cart might not be available without WooCommerce
    } finally {
      cartLoading.value = false;
    }
  }

  /**
   * Add item to cart
   */
  async function addToCart(productId, quantity = 1) {
    cartLoading.value = true;
    cartError.value = null;

    try {
      const response = await axios.post(
        `${restUrl}wc/store/v1/cart/add-item`,
        {
          id: productId,
          quantity: quantity,
        },
        { headers: getHeaders() }
      );

      cartItems.value = (response.data.items || []).map(formatCartItem);
      cartTotals.value = formatTotals(response.data.totals || {});

      // Open cart drawer
      cartOpen.value = true;

      return { success: true };
    } catch (err) {
      cartError.value = 'Không thể thêm sản phẩm vào giỏ hàng.';
      console.error('Failed to add to cart:', err);
      return { success: false, error: cartError.value };
    } finally {
      cartLoading.value = false;
    }
  }

  /**
   * Update cart item quantity
   */
  async function updateCartItem(itemKey, quantity) {
    cartLoading.value = true;
    cartError.value = null;

    try {
      const response = await axios.post(
        `${restUrl}wc/store/v1/cart/update-item`,
        {
          key: itemKey,
          quantity: quantity,
        },
        { headers: getHeaders() }
      );

      cartItems.value = (response.data.items || []).map(formatCartItem);
      cartTotals.value = formatTotals(response.data.totals || {});
    } catch (err) {
      cartError.value = 'Không thể cập nhật giỏ hàng.';
      console.error('Failed to update cart:', err);
    } finally {
      cartLoading.value = false;
    }
  }

  /**
   * Remove item from cart
   */
  async function removeCartItem(itemKey) {
    cartLoading.value = true;
    cartError.value = null;

    try {
      const response = await axios.post(
        `${restUrl}wc/store/v1/cart/remove-item`,
        { key: itemKey },
        { headers: getHeaders() }
      );

      cartItems.value = (response.data.items || []).map(formatCartItem);
      cartTotals.value = formatTotals(response.data.totals || {});
    } catch (err) {
      cartError.value = 'Không thể xóa sản phẩm khỏi giỏ hàng.';
      console.error('Failed to remove from cart:', err);
    } finally {
      cartLoading.value = false;
    }
  }

  /**
   * Format cart item
   */
  function formatCartItem(item) {
    const prices = item.prices || {};
    const currencyMinorUnit = prices.currency_minor_unit || 0;
    const divisor = Math.pow(10, currencyMinorUnit);

    return {
      key: item.key,
      id: item.id,
      name: item.name,
      quantity: item.quantity,
      price: parseFloat(prices.price || '0') / divisor,
      regularPrice: parseFloat(prices.regular_price || '0') / divisor,
      lineTotal: parseFloat(item.totals?.line_total || '0') / divisor,
      image: item.images?.[0]?.src || '',
      imageThumbnail: item.images?.[0]?.thumbnail || '',
      permalink: item.permalink || '#',
      currencySymbol: prices.currency_symbol || '₫',
    };
  }

  /**
   * Format cart totals
   */
  function formatTotals(totals) {
    const currencyMinorUnit = totals.currency_minor_unit || 0;
    const divisor = Math.pow(10, currencyMinorUnit);

    return {
      subtotal: parseFloat(totals.total_items || '0') / divisor,
      shipping: parseFloat(totals.total_shipping || '0') / divisor,
      discount: parseFloat(totals.total_discount || '0') / divisor,
      tax: parseFloat(totals.total_tax || '0') / divisor,
      total: parseFloat(totals.total_price || '0') / divisor,
      currencySymbol: totals.currency_symbol || '₫',
    };
  }

  /**
   * Format price for display
   */
  function formatPrice(price, symbol = '₫') {
    if (!price && price !== 0) return '';
    return new Intl.NumberFormat('vi-VN').format(price) + symbol;
  }

  /**
   * Toggle cart sidebar
   */
  function toggleCart() {
    cartOpen.value = !cartOpen.value;
  }

  function openCart() {
    cartOpen.value = true;
  }

  function closeCart() {
    cartOpen.value = false;
  }

  // Computed
  const cartCount = computed(() => {
    return cartItems.value.reduce((sum, item) => sum + item.quantity, 0);
  });

  const cartSubtotal = computed(() => {
    return cartItems.value.reduce((sum, item) => sum + item.lineTotal, 0);
  });

  const isCartEmpty = computed(() => cartItems.value.length === 0);

  return {
    cartItems,
    cartTotals,
    cartLoading,
    cartError,
    cartOpen,
    cartCount,
    cartSubtotal,
    isCartEmpty,
    fetchCart,
    addToCart,
    updateCartItem,
    removeCartItem,
    toggleCart,
    openCart,
    closeCart,
    formatPrice,
  };
}
