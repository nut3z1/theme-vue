import { ref, computed } from 'vue';
import axios from 'axios';

/**
 * Composable: Fetch & manage WooCommerce products
 * Uses WooCommerce Store API (no auth required for browsing)
 */
export function useProducts() {
  const products = ref([]);
  const product = ref(null);
  const loading = ref(false);
  const error = ref(null);
  const totalProducts = ref(0);
  const totalPages = ref(0);
  const currentPage = ref(1);
  const categories = ref([]);

  const restUrl = window.wpVueTheme?.restUrl || '/wp-json/';

  /**
   * Fetch products list
   */
  async function fetchProducts(params = {}) {
    loading.value = true;
    error.value = null;

    try {
      const response = await axios.get(`${restUrl}wc/store/v1/products`, {
        params: {
          per_page: params.perPage || 12,
          page: params.page || 1,
          search: params.search || undefined,
          category: params.category || undefined,
          orderby: params.orderby || 'date',
          order: params.order || 'desc',
          min_price: params.minPrice || undefined,
          max_price: params.maxPrice || undefined,
          featured: params.featured || undefined,
          on_sale: params.onSale || undefined,
        },
      });

      products.value = response.data.map(formatProduct);
      totalProducts.value = parseInt(response.headers['x-wp-total'] || '0');
      totalPages.value = parseInt(response.headers['x-wp-totalpages'] || '0');
      currentPage.value = params.page || 1;
    } catch (err) {
      error.value = 'Không thể tải sản phẩm. Vui lòng thử lại.';
      console.error('Failed to fetch products:', err);
    } finally {
      loading.value = false;
    }
  }

  /**
   * Fetch featured products
   */
  async function fetchFeaturedProducts(limit = 8) {
    loading.value = true;
    error.value = null;

    try {
      const response = await axios.get(`${restUrl}wc/store/v1/products`, {
        params: {
          per_page: limit,
          featured: true,
          orderby: 'date',
          order: 'desc',
        },
      });

      products.value = response.data.map(formatProduct);
    } catch (err) {
      // Fallback: fetch latest products if featured fails
      try {
        const response = await axios.get(`${restUrl}wc/store/v1/products`, {
          params: {
            per_page: limit,
            orderby: 'date',
            order: 'desc',
          },
        });
        products.value = response.data.map(formatProduct);
      } catch (fallbackErr) {
        error.value = 'Không thể tải sản phẩm.';
        console.error('Failed to fetch products:', fallbackErr);
      }
    } finally {
      loading.value = false;
    }
  }

  /**
   * Fetch single product by ID
   */
  async function fetchProduct(productId) {
    loading.value = true;
    error.value = null;

    try {
      const response = await axios.get(`${restUrl}wc/store/v1/products/${productId}`);
      product.value = formatProduct(response.data);
    } catch (err) {
      error.value = 'Không thể tải chi tiết sản phẩm.';
      console.error('Failed to fetch product:', err);
    } finally {
      loading.value = false;
    }
  }

  /**
   * Fetch product categories
   */
  async function fetchCategories() {
    try {
      const response = await axios.get(`${restUrl}wc/store/v1/products/categories`, {
        params: { per_page: 50 },
      });

      categories.value = response.data.map((cat) => ({
        id: cat.id,
        name: cat.name,
        slug: cat.slug,
        count: cat.count,
        image: cat.image?.src || null,
      }));
    } catch (err) {
      console.error('Failed to fetch categories:', err);
    }
  }

  /**
   * Format product data from Store API
   */
  function formatProduct(item) {
    const prices = item.prices || {};
    const currencyMinorUnit = prices.currency_minor_unit || 0;
    const divisor = Math.pow(10, currencyMinorUnit);

    return {
      id: item.id,
      name: item.name,
      slug: item.slug,
      permalink: item.permalink,
      description: item.description,
      shortDescription: item.short_description,
      price: prices.price ? parseFloat(prices.price) / divisor : 0,
      regularPrice: prices.regular_price ? parseFloat(prices.regular_price) / divisor : 0,
      salePrice: prices.sale_price ? parseFloat(prices.sale_price) / divisor : 0,
      currencySymbol: prices.currency_symbol || '₫',
      onSale: item.on_sale || false,
      images: (item.images || []).map((img) => ({
        id: img.id,
        src: img.src,
        thumbnail: img.thumbnail,
        alt: img.alt || item.name,
      })),
      categories: (item.categories || []).map((c) => ({
        id: c.id,
        name: c.name,
        slug: c.slug,
      })),
      averageRating: parseFloat(item.average_rating || '0'),
      reviewCount: item.review_count || 0,
      stockStatus: item.is_in_stock ? 'instock' : 'outofstock',
      isInStock: item.is_in_stock,
      sku: item.sku || '',
      attributes: item.attributes || [],
    };
  }

  /**
   * Format price with currency
   */
  function formatPrice(price, symbol = '₫') {
    if (!price && price !== 0) return '';
    return new Intl.NumberFormat('vi-VN').format(price) + symbol;
  }

  const hasProducts = computed(() => products.value.length > 0);
  const hasMorePages = computed(() => currentPage.value < totalPages.value);

  return {
    products,
    product,
    loading,
    error,
    totalProducts,
    totalPages,
    currentPage,
    categories,
    hasProducts,
    hasMorePages,
    fetchProducts,
    fetchFeaturedProducts,
    fetchProduct,
    fetchCategories,
    formatPrice,
  };
}
