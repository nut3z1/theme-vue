<?php
/**
 * Login Form - Custom Override
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_before_customer_login_form' );

$logo = get_custom_logo();
$site_title = get_bloginfo( 'name' );
$home_url   = home_url( '/' );
?>

<style>
.hl-login-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    background: #f8f9fb;
}
.hl-login-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 8px 40px rgba(0,0,0,0.08);
    overflow: hidden;
    width: 100%;
    max-width: 900px;
    display: flex;
    min-height: 520px;
}
.hl-login-left {
    background: linear-gradient(135deg, #1565C0 0%, #1976D2 50%, #2196F3 100%);
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem 2rem;
    position: relative;
    overflow: hidden;
}
.hl-login-left::before {
    content: '';
    position: absolute;
    top: -60px; left: -60px;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(255,255,255,0.07);
}
.hl-login-left::after {
    content: '';
    position: absolute;
    bottom: -80px; right: -40px;
    width: 280px; height: 280px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}
.hl-login-left-logo img {
    height: 70px;
    width: auto;
    object-fit: contain;
    filter: brightness(0) invert(1);
    margin-bottom: 1.5rem;
}
.hl-login-left h2 {
    color: #fff;
    font-size: 1.6rem;
    font-weight: 700;
    text-align: center;
    margin-bottom: 0.75rem;
    position: relative;
    z-index: 1;
}
.hl-login-left p {
    color: rgba(255,255,255,0.8);
    font-size: 0.875rem;
    text-align: center;
    line-height: 1.6;
    position: relative;
    z-index: 1;
}
.hl-login-left-features {
    margin-top: 2rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    width: 100%;
    position: relative;
    z-index: 1;
}
.hl-feature-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: rgba(255,255,255,0.9);
    font-size: 0.8rem;
}
.hl-feature-icon {
    width: 28px; height: 28px;
    background: rgba(255,255,255,0.15);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.hl-login-right {
    flex: 1;
    padding: 3rem 2.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.hl-login-right h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 0.4rem;
}
.hl-login-right .hl-subtitle {
    color: #6b7280;
    font-size: 0.875rem;
    margin-bottom: 2rem;
}
.hl-form-group {
    margin-bottom: 1.25rem;
}
.hl-form-group label {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.4rem;
}
.hl-input-wrap {
    position: relative;
}
.hl-input-icon {
    position: absolute;
    left: 12px; top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    width: 18px; height: 18px;
}
.hl-form-group input[type="text"],
.hl-form-group input[type="email"],
.hl-form-group input[type="password"] {
    width: 100%;
    padding: 0.7rem 1rem 0.7rem 2.5rem;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9rem;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    background: #f9fafb;
    color: #111827;
    box-sizing: border-box;
}
.hl-form-group input:focus {
    border-color: #2196F3;
    box-shadow: 0 0 0 3px rgba(33,150,243,0.12);
    background: #fff;
}
.hl-form-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}
.hl-remember {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.8rem;
    color: #6b7280;
    cursor: pointer;
}
.hl-remember input[type="checkbox"] {
    accent-color: #2196F3;
    width: 15px; height: 15px;
}
.hl-forgot {
    font-size: 0.8rem;
    color: #2196F3;
    text-decoration: none;
    font-weight: 500;
}
.hl-forgot:hover { text-decoration: underline; }

.hl-btn-login {
    width: 100%;
    padding: 0.85rem;
    background: linear-gradient(135deg, #1565C0, #2196F3);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: opacity 0.2s, transform 0.1s;
    letter-spacing: 0.3px;
}
.hl-btn-login:hover { opacity: 0.92; transform: translateY(-1px); }
.hl-btn-login:active { transform: translateY(0); }

.hl-divider {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin: 1.25rem 0;
    color: #d1d5db;
    font-size: 0.75rem;
}
.hl-divider::before,
.hl-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #e5e7eb;
}

.hl-admin-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.7rem 1rem;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    color: #374151;
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
    background: #fff;
}
.hl-admin-link:hover {
    border-color: #2196F3;
    color: #2196F3;
    background: #f0f7ff;
}
.hl-admin-link svg {
    width: 16px; height: 16px;
    flex-shrink: 0;
}

@media (max-width: 640px) {
    .hl-login-card { flex-direction: column; }
    .hl-login-left { padding: 2rem 1.5rem; min-height: 180px; }
    .hl-login-left-features { display: none; }
    .hl-login-right { padding: 2rem 1.5rem; }
}
</style>

<div class="hl-login-page">
  <div class="hl-login-card">

    <!-- Left Panel -->
    <div class="hl-login-left">
      <div class="hl-login-left-logo">
        <?php if ( has_custom_logo() ) : ?>
          <a href="<?php echo esc_url( $home_url ); ?>"><?php echo $logo; ?></a>
        <?php else : ?>
          <a href="<?php echo esc_url( $home_url ); ?>" style="color:#fff;font-size:1.5rem;font-weight:700;text-decoration:none;"><?php echo esc_html( $site_title ); ?></a>
        <?php endif; ?>
      </div>
      <h2>Chào mừng trở lại!</h2>
      <p>Đăng nhập để quản lý đơn hàng,<br>theo dõi tình trạng và nhiều hơn nữa.</p>
      <div class="hl-login-left-features">
        <div class="hl-feature-item">
          <div class="hl-feature-icon">
            <svg fill="none" stroke="white" viewBox="0 0 24 24" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
          </div>
          <span>Theo dõi đơn hàng dễ dàng</span>
        </div>
        <div class="hl-feature-item">
          <div class="hl-feature-icon">
            <svg fill="none" stroke="white" viewBox="0 0 24 24" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
          </div>
          <span>Lưu sản phẩm yêu thích</span>
        </div>
        <div class="hl-feature-item">
          <div class="hl-feature-icon">
            <svg fill="none" stroke="white" viewBox="0 0 24 24" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
          </div>
          <span>Bảo mật tài khoản tuyệt đối</span>
        </div>
      </div>
    </div>

    <!-- Right Panel -->
    <div class="hl-login-right">
      <h2>Đăng nhập</h2>
      <p class="hl-subtitle">Nhập thông tin tài khoản của bạn</p>

      <?php wc_print_notices(); ?>

      <form class="woocommerce-form woocommerce-form-login login" method="post" novalidate>
        <?php do_action( 'woocommerce_login_form_start' ); ?>

        <div class="hl-form-group">
          <label for="username">Tên đăng nhập hoặc Email <span style="color:#ef4444">*</span></label>
          <div class="hl-input-wrap">
            <svg class="hl-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
              name="username" id="username" autocomplete="username"
              value="<?php echo ( ! empty( $_POST['username'] ) && is_string( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>"
              placeholder="admin hoặc email@example.com" required aria-required="true" />
          </div>
        </div>

        <div class="hl-form-group">
          <label for="password">Mật khẩu <span style="color:#ef4444">*</span></label>
          <div class="hl-input-wrap">
            <svg class="hl-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            <input class="woocommerce-Input woocommerce-Input--text input-text"
              type="password" name="password" id="password" autocomplete="current-password"
              placeholder="••••••••" required aria-required="true" />
          </div>
        </div>

        <?php do_action( 'woocommerce_login_form' ); ?>

        <div class="hl-form-row">
          <label class="hl-remember">
            <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
            <span>Ghi nhớ đăng nhập</span>
          </label>
          <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="hl-forgot">Quên mật khẩu?</a>
        </div>

        <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>

        <button type="submit" class="hl-btn-login" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>">
          Đăng nhập
        </button>

        <?php do_action( 'woocommerce_login_form_end' ); ?>
      </form>

      <div class="hl-divider">hoặc</div>

      <a href="<?php echo esc_url( admin_url() ); ?>" class="hl-admin-link">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        Vào trang quản trị WordPress
      </a>
    </div>

  </div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
