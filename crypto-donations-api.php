<?php
/**
 * Template Name: Donations with Tabs and ACF Accordion
 * 
 * This template displays donation forms (Cash via GiveWP, Crypto via multi-step form)
 * alongside a configurable ACF accordion with donation information.
 * 
 * @package WordPress
 */

get_header();
?>

<div class="donations-wrapper">
    <header class="donations-header">
        <h1><?php esc_html_e( 'DONATE', 'textdomain' ); ?></h1>
        <p class="donations-description">
            <?php 
            echo wp_kses_post( 
                __( 'You can donate to us using a credit or debit card, or by bank transfer. If you would like to continually support our work with a regular donation, the best way to do this is to set up an automatic payment through online banking.', 'textdomain' ) 
            ); 
            ?>
        </p>
    </header>

    <div class="donations-container">
        <!-- Left Column: Forms -->
        <div class="donations-forms">
            <!-- Tabs Navigation - Pill Style -->
            <div class="donation-tabs-wrapper">
                <div class="donation-tabs">
                    <button 
                        class="tab-button active" 
                        data-tab="cash"
                        data-testid="button-tab-cash"
                        aria-selected="true"
                        aria-controls="tab-panel-cash"
                    >
                        Donate Cash
                    </button>
                    <button 
                        class="tab-button" 
                        data-tab="crypto"
                        data-testid="button-tab-crypto"
                        aria-selected="false"
                        aria-controls="tab-panel-crypto"
                    >
                        Donate Crypto
                    </button>
                </div>
            </div>

            <!-- Tab Panels -->
            <div class="tab-panels">
                <!-- Cash Donation Tab -->
                <div 
                    id="tab-panel-cash"
                    class="tab-panel active" 
                    role="tabpanel" 
                    aria-labelledby="tab-cash"
                    data-testid="panel-cash-form"
                >
                    <div class="givewp-form-wrapper">
                        <?php echo do_shortcode( '[give_form id="315"]' ); ?>
                    </div>
                </div>

                <!-- Crypto Donation Tab -->
                <?php
                // Get crypto wallets from ACF
                $crypto_wallets = array();
                $wallet_data = array();
                if ( have_rows( 'crypto_wallets' ) ) {
                    while ( have_rows( 'crypto_wallets' ) ) {
                        the_row();
                        $crypto_name = get_sub_field( 'crypto_name' );
                        $wallet_address = get_sub_field( 'wallet_address' );
                        if ( $crypto_name && $wallet_address ) {
                            $crypto_wallets[] = $crypto_name;
                            $wallet_data[ $crypto_name ] = $wallet_address;
                        }
                    }
                }
                // Fallback if no ACF data
                if ( empty( $crypto_wallets ) ) {
                    $crypto_wallets = array( 'BTC', 'ETH', 'USDC', 'USDT' );
                    $wallet_data = array(
                        'BTC' => 'bc1qllutxxxkeyeh0dfj3m9twh35vydd67e0',
                        'ETH' => '0x1234567890abcdef1234567890abcdef12345678',
                        'USDC' => '0x1234567890abcdef1234567890abcdef12345678',
                        'USDT' => '0x1234567890abcdef1234567890abcdef12345678'
                    );
                }
                $coin_icons = array(
                    'BTC' => '₿',
                    'ETH' => 'Ξ',
                    'USDC' => '$',
                    'USDT' => '₮'
                );
                $coin_names = array(
                    'BTC' => 'Bitcoin (BTC)',
                    'ETH' => 'Ethereum (ETH)',
                    'USDC' => 'USD Coin (USDC)',
                    'USDT' => 'Tether (USDT)'
                );
                ?>
                <div 
                    id="tab-panel-crypto"
                    class="tab-panel" 
                    role="tabpanel" 
                    aria-labelledby="tab-crypto"
                    data-testid="panel-crypto-form"
                >
                    <!-- Pass wallet data to JavaScript -->
                    <script type="application/json" id="crypto-wallet-data">
                        <?php echo json_encode( $wallet_data ); ?>
                    </script>

                    <div class="crypto-widget" id="crypto-widget">
                        <!-- Step 1: Donation Amount -->
                        <div class="crypto-step" id="step-donation" data-step="1">
                            <div class="crypto-card">
                                <h3 class="crypto-card-title">Make a Donation</h3>
                                
                                <!-- Coin Selection Buttons -->
                                <div class="coin-buttons">
                                    <?php 
                                    $first = true;
                                    foreach ( $crypto_wallets as $coin ) : 
                                        $icon = isset( $coin_icons[ $coin ] ) ? $coin_icons[ $coin ] : '$';
                                        $active_class = $first ? 'active' : '';
                                        $first = false;
                                    ?>
                                        <button type="button" class="coin-button <?php echo $active_class; ?>" data-currency="<?php echo esc_attr( $coin ); ?>" data-testid="button-<?php echo strtolower( $coin ); ?>">
                                            <span class="coin-icon <?php echo strtolower( $coin ); ?>"><?php echo esc_html( $icon ); ?></span>
                                            <span><?php echo esc_html( $coin ); ?></span>
                                        </button>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Currency Dropdown -->
                                <div class="form-field">
                                    <select id="crypto-currency" class="crypto-select" data-testid="select-currency">
                                        <?php foreach ( $crypto_wallets as $coin ) : 
                                            $name = isset( $coin_names[ $coin ] ) ? $coin_names[ $coin ] : $coin;
                                        ?>
                                            <option value="<?php echo esc_attr( $coin ); ?>"><?php echo esc_html( $name ); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Amount Input with Conversion -->
                                <div class="amount-row">
                                    <div class="amount-input-wrapper">
                                        <span class="currency-prefix">$</span>
                                        <input 
                                            type="number" 
                                            id="nzd-amount" 
                                            class="amount-input"
                                            value="100"
                                            min="1"
                                            step="1"
                                            placeholder="100"
                                            data-testid="input-nzd-amount"
                                        />
                                        <span class="currency-suffix">NZD</span>
                                    </div>
                                    <div class="conversion-display">
                                        = <span id="crypto-conversion">0.00076923</span> <span id="crypto-currency-label">BTC</span>
                                    </div>
                                </div>

                                <!-- Amount Error -->
                                <div class="amount-error" id="amount-error"></div>

                                <!-- Donate Button -->
                                <button 
                                    type="button" 
                                    class="donate-btn primary"
                                    id="btn-donate-crypto"
                                    data-testid="button-donate"
                                >
                                    Donate
                                    <span class="heart-icon">♥</span>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Personal Info -->
                        <div class="crypto-step hidden" id="step-personal" data-step="2">
                            <div class="crypto-card">
                                <div class="card-header-row">
                                    <button type="button" class="back-button" data-back="1" data-testid="button-back">
                                        ← 
                                    </button>
                                    <h3 class="crypto-card-title">Personal Info</h3>
                                </div>

                                <!-- Anonymous Checkbox -->
                                <div class="anonymous-row">
                                    <input 
                                        type="checkbox" 
                                        id="is-anonymous" 
                                        data-testid="checkbox-anonymous"
                                    />
                                    <label for="is-anonymous">Make donation anonymous</label>
                                </div>

                                <!-- Personal Info Form -->
                                <div id="personal-info-fields">
                                    <div class="form-row two-col">
                                        <div class="form-field">
                                            <input type="text" id="first-name" placeholder="First name" data-testid="input-firstName" />
                                            <span class="field-error" id="error-firstName"></span>
                                        </div>
                                        <div class="form-field">
                                            <input type="text" id="last-name" placeholder="Last name" data-testid="input-lastName" />
                                            <span class="field-error" id="error-lastName"></span>
                                        </div>
                                    </div>

                                    <div class="form-field">
                                        <input type="email" id="donor-email" placeholder="Email" data-testid="input-email" />
                                        <span class="field-error" id="error-email"></span>
                                    </div>

                                    <div class="form-field">
                                        <input type="text" id="address1" placeholder="Address 1" data-testid="input-address1" />
                                        <span class="field-error" id="error-address1"></span>
                                    </div>

                                    <div class="form-field">
                                        <input type="text" id="address2" placeholder="Address 2" data-testid="input-address2" />
                                    </div>

                                    <div class="form-row two-col">
                                        <div class="form-field">
                                            <input type="text" id="country" placeholder="Country" data-testid="input-country" />
                                            <span class="field-error" id="error-country"></span>
                                        </div>
                                        <div class="form-field">
                                            <input type="text" id="state" placeholder="State/Province" data-testid="input-state" />
                                            <span class="field-error" id="error-state"></span>
                                        </div>
                                    </div>

                                    <div class="form-row two-col">
                                        <div class="form-field">
                                            <input type="text" id="city" placeholder="City" data-testid="input-city" />
                                            <span class="field-error" id="error-city"></span>
                                        </div>
                                        <div class="form-field">
                                            <input type="text" id="zip" placeholder="ZIP/Postal Code" data-testid="input-zip" />
                                            <span class="field-error" id="error-zip"></span>
                                        </div>
                                    </div>
                                </div>

                                <button 
                                    type="button" 
                                    class="donate-btn primary"
                                    id="btn-next-personal"
                                    data-testid="button-next"
                                >
                                    Next
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Tax Receipt -->
                        <div class="crypto-step hidden" id="step-tax" data-step="3">
                            <div class="crypto-card">
                                <div class="card-header-row">
                                    <button type="button" class="back-button" data-back="2" data-testid="button-back-tax">
                                        ← 
                                    </button>
                                    <h3 class="crypto-card-title">Want A Tax Receipt?</h3>
                                </div>

                                <p class="tax-description">
                                    If you would like to receive a tax receipt while remaining anonymous, enter your email below. This email will only be used for the purpose of issuing your tax receipt.
                                </p>

                                <div class="form-field">
                                    <input 
                                        type="email" 
                                        id="tax-email" 
                                        placeholder="Enter email for tax receipt"
                                        data-testid="input-tax-email"
                                    />
                                </div>

                                <div class="button-row">
                                    <button 
                                        type="button" 
                                        class="donate-btn secondary"
                                        id="btn-skip-tax"
                                        data-testid="button-skip"
                                    >
                                        Skip
                                    </button>
                                    <button 
                                        type="button" 
                                        class="donate-btn primary"
                                        id="btn-get-receipt"
                                        data-testid="button-get-receipt"
                                    >
                                        Get receipt
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Wallet Address & QR -->
                        <div class="crypto-step hidden" id="step-wallet" data-step="4">
                            <div class="crypto-card">
                                <div class="card-header-row">
                                    <button type="button" class="back-button" data-back="3" data-testid="button-back-wallet">
                                        ← 
                                    </button>
                                    <h3 class="crypto-card-title">
                                        <span id="final-amount">0.00076923 BTC</span>
                                        <span class="info-icon">ℹ</span>
                                    </h3>
                                </div>

                                <p class="wallet-instruction">
                                    Use the address below to make a donation from your wallet.
                                </p>

                                <!-- QR Code -->
                                <div class="qr-container">
                                    <div class="qr-code" id="qr-code">
                                        <div class="qr-placeholder">
                                            <span>📱</span>
                                            <span>QR Code</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Wallet Address -->
                                <div class="wallet-address-box">
                                    <input 
                                        type="text" 
                                        id="wallet-address"
                                        value="bc1qllutxxxkeyeh0d...fj3m9twh35vydd67e0"
                                        readonly
                                        data-testid="input-wallet-address"
                                    />
                                    <button type="button" class="copy-button" id="btn-copy" data-testid="button-copy">
                                        📋
                                    </button>
                                </div>

                                <!-- Warning -->
                                <div class="wallet-warning">
                                    <p>
                                        <strong>Send only <span id="warning-currency">BTC</span> to this address using the <span id="warning-blockchain">Bitcoin</span> blockchain.</strong> 
                                        Sending other unsupported tokens or NFTs to this address may result in the loss of your donation. 
                                        The address will expire after 180 days of unused.
                                    </p>
                                </div>

                                <button 
                                    type="button" 
                                    class="donate-btn primary"
                                    id="btn-start-over"
                                    data-testid="button-start-over"
                                >
                                    Start Over
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Accordion -->
        <aside class="donations-sidebar">
            <div class="accordion-container" data-testid="container-ways-to-give">
                <h2 class="accordion-main-title">
                    <span class="icon">💡</span>
                    Ways to Give
                </h2>

                <?php if ( have_rows( 'kys_donate_accordions' ) ) : ?>
                    <div class="accordion">
                        <?php 
                        $index = 0;
                        while ( have_rows( 'kys_donate_accordions' ) ) : the_row(); 
                            $title = get_sub_field( 'title' );
                            $content = get_sub_field( 'content' );
                            $is_open = ( $index === 0 ) ? 'true' : 'false';
                        ?>
                            <div class="accordion-item" data-testid="accordion-item-<?php echo $index; ?>">
                                <button 
                                    class="accordion-button <?php echo $index === 0 ? 'open' : ''; ?>" 
                                    aria-expanded="<?php echo $is_open; ?>"
                                    aria-controls="accordion-content-<?php echo $index; ?>"
                                    data-testid="button-accordion-<?php echo $index; ?>"
                                >
                                    <span class="accordion-item-title" data-testid="text-accordion-title-<?php echo $index; ?>">
                                        <?php echo esc_html( $title ); ?>
                                    </span>
                                    <span class="accordion-icon">▼</span>
                                </button>

                                <div 
                                    id="accordion-content-<?php echo $index; ?>"
                                    class="accordion-content <?php echo $index === 0 ? 'open' : ''; ?>"
                                    role="region"
                                    aria-labelledby="accordion-button-<?php echo $index; ?>"
                                    data-testid="content-accordion-body-<?php echo $index; ?>"
                                    style="max-height: <?php echo $index === 0 ? 'auto' : '0'; ?>;"
                                >
                                    <div class="accordion-body">
                                        <?php echo wp_kses_post( $content ); ?>
                                    </div>
                                </div>
                            </div>
                        <?php 
                            $index++;
                        endwhile; 
                        ?>
                    </div>
                <?php else : ?>
                    <div class="no-accordion" data-testid="text-no-accordion">
                        <p><?php esc_html_e( 'Accordion sections not configured.', 'textdomain' ); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </aside>
    </div>

    <?php 
    // WordPress content area - allows content manager to add content below the donation components
    $content = get_the_content();
    if ( ! empty( trim( $content ) ) ) : 
    ?>
        <div class="donations-additional-content">
            <?php the_content(); ?>
        </div>
    <?php endif; ?>
</div>

<style>
    /* Additional Content Area */
    .donations-additional-content {
        max-width: 1200px;
        margin: 3rem auto 0;
        padding: 0 1rem;
    }

    .donations-additional-content h1,
    .donations-additional-content h2,
    .donations-additional-content h3,
    .donations-additional-content h4,
    .donations-additional-content h5,
    .donations-additional-content h6 {
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
    }

    .donations-additional-content p {
        margin-bottom: 1rem;
        line-height: 1.7;
    }

    .donations-additional-content ul,
    .donations-additional-content ol {
        margin-bottom: 1rem;
        padding-left: 1.5rem;
    }

    .donations-additional-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }

    * {
        box-sizing: border-box;
    }

    .donations-wrapper {
        background-color: #fff;
        padding: 3rem 1rem;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .donations-header {
        max-width: 1200px;
        margin: 0 auto 2rem;
    }

    .donations-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0 0 1rem 0;
        color: #000;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .donations-description {
        font-size: 18px;
        color: #555;
        line-height: 1.6;c
        max-width: 600px;
        margin: 0;
    }

    .donations-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 50%;
        gap: 2rem;
    }

    /* Pill-Style Tabs */
    .donation-tabs-wrapper {
        margin-bottom: 1.5rem;
    }

    .donation-tabs {
        display: inline-flex;
        background: rgba(0, 0, 0, 0.05);
        border-radius: 9999px;
        padding: 4px;
    }

    .tab-button {
        background: transparent;
        border: none;
        padding: 0.75rem 1.5rem;
        font-size: 18px;
        font-weight: 600;
        color: #666;
        cursor: pointer;
        border-radius: 9999px;
        transition: all 0.3s ease;
    }

    .tab-button:hover {
        color: #333;
    }

    .tab-button.active {
        background: #FCD535;
        color: #000;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Tab Panels */
    .tab-panels {
        position: relative;
    }

    .tab-panel {
        display: none;
        animation: fadeIn 0.3s ease;
    }

    .tab-panel.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Crypto Widget */
    .crypto-widget {
        max-width: 500px;
    }

    .crypto-step {
        animation: fadeIn 0.3s ease;
    }

    .crypto-step.hidden {
        display: none;
    }

    .crypto-card {
        background: #fff;
        border: 2px solid #000;
        border-radius: 24px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .crypto-card-title {
        font-size: 1.5rem;
        font-weight: 700;
        text-align: center;
        margin: 0 0 1.5rem 0;
        color: #2A254B;
    }

    .card-header-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .card-header-row .crypto-card-title {
        margin: 0;
        text-align: left;
        flex: 1;
    }

    .back-button {
        background: none;
        border: none;
        font-size: 18px;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 8px;
        transition: background 0.2s;
    }

    .back-button:hover {
        background: #f0f0f0;
    }

    /* Coin Buttons */
    .coin-buttons {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .coin-button {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        background: #fff;
        cursor: pointer;
        font-weight: 600;
        color: #333;
        transition: all 0.2s;
    }

    .coin-button:hover {
        background: #f5f5f5;
    }

    .coin-button.active {
        border-color: #F7931A;
        background: rgba(247, 147, 26, 0.05);
    }

    .coin-button[data-currency="ETH"].active {
        border-color: #627EEA;
        background: rgba(98, 126, 234, 0.05);
    }

    .coin-button[data-currency="USDC"].active {
        border-color: #2775CA;
        background: rgba(39, 117, 202, 0.05);
    }

    .coin-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        color: #fff;
    }

    .coin-icon.btc { background: #F7931A; }
    .coin-icon.eth { background: #627EEA; }
    .coin-icon.usdc { background: #2775CA; }
    .coin-icon.usdt { background: #84ea62; }

    /* Form Fields */
    .form-field {
        margin-bottom: 1rem;
        position: relative;
    }

    .form-field input,
    .form-field select {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 18px;
        transition: border-color 0.2s;
    }

    .form-field input:focus,
    .form-field select:focus {
        outline: none;
        border-color: #333;
    }

    .form-field input.error {
        border-color: #ef4444;
    }

    .field-error {
        display: block;
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        min-height: 1rem;
    }

    .form-row.two-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }

    .crypto-select {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 18px;
        background: #fff;
        cursor: pointer;
    }

    /* Amount Row */
    .amount-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }

    .amount-input-wrapper {
        position: relative;
        width: 250px;
        flex-shrink: 0;
    }

    .currency-prefix {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        font-weight: 600;
        color: #666;
    }

    .amount-input {
        width: 100%;
        padding: 0.875rem 3.5rem 0.875rem 2rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 18px;
        font-weight: 600;
        -moz-appearance: textfield;
    }

    .amount-input::-webkit-outer-spin-button,
    .amount-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .amount-input.error {
        border-color: #ef4444;
    }

    .currency-suffix {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
        font-weight: 500;
    }

    .conversion-display {
        font-size: 18px;
        font-weight: 600;
        color: #666;
        white-space: nowrap;
        min-width: 150px;
    }

    .amount-error {
        color: #ef4444;
        font-size: 1.1rem;
        margin-bottom: 1rem;
        min-height: 1.25rem;
    }

    /* Toast Notification */
    .crypto-toast {
        position: fixed;
        top: 1.5rem;
        right: 1.5rem;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 500;
        z-index: 10000;
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.3s ease;
        max-width: 350px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .crypto-toast.show {
        opacity: 1;
        transform: translateX(0);
    }

    .crypto-toast.success {
        background: #10b981;
        color: #fff;
    }

    .crypto-toast.error {
        background: #ef4444;
        color: #fff;
    }

    /* Buttons */
    .donate-btn {
        width: 100%;
        padding: 1rem;
        border-radius: 12px;
        font-size: 18px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .donate-btn.primary {
        background: #FCD535;
        border: none;
        color: #000;
    }

    .donate-btn.primary:hover {
        background: #e6c12f;
    }

    .donate-btn.secondary {
        background: #fff;
        border: 2px solid #ccc;
        color: #333;
    }

    .donate-btn.secondary:hover {
        background: #f5f5f5;
    }

    .heart-icon {
        font-size: 1.25rem;
    }

    .button-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }

    /* Anonymous */
    .anonymous-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: #f5f5f5;
        border-radius: 12px;
        margin-bottom: 1rem;
    }

    .anonymous-row input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .anonymous-row label {
        font-weight: 500;
        color: #333;
        cursor: pointer;
    }

    /* Tax Receipt */
    .tax-description {
        color: #666;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    /* Wallet Step */
    .wallet-instruction {
        text-align: center;
        color: #666;
        margin-bottom: 1.5rem;
    }

    .qr-container {
        display: flex;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .qr-code {
        width: 180px;
        height: 180px;
        background: #f5f5f5;
        border: 2px solid #e0e0e0;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .qr-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        color: #999;
    }

    .qr-placeholder span:first-child {
        font-size: 2.5rem;
    }

    .wallet-address-box {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem;
        background: #f5f5f5;
        border-radius: 12px;
        margin-bottom: 1rem;
    }

    .wallet-address-box input {
        flex: 1;
        background: transparent;
        border: none;
        font-family: monospace;
        font-size: 18px;
        color: #333;
    }

    .copy-button {
        background: none;
        border: none;
        font-size: 18px;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 8px;
        transition: background 0.2s;
    }

    .copy-button:hover {
        background: #e0e0e0;
    }

    .wallet-warning {
        padding: 1rem;
        background: #FFF8E6;
        border: 1px solid #F5D060;
        border-radius: 12px;
        margin-bottom: 1.5rem;
    }

    .wallet-warning p {
        margin: 0;
        font-size: 16px;
        color: #8B6914;
        line-height: 1.5;
    }

    .info-icon {
        font-size: 16px;
        color: #999;
        margin-left: 0.5rem;
    }

    /* GiveWP wrapper */
    .givewp-form-wrapper {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(8px);
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .givewp-form-wrapper p {
        color: #555;
    }
    
    form[id*=give-form] .give-donation-amount #give-amount, form[id*=give-form] .give-donation-amount #give-amount-text {
        width: calc(100% - 38px);
        padding: 0.875rem 3.5rem 0.875rem 2rem;
        border: 2px solid #e0e0e0;
        border-radius: 0px 12px 12px 0px;
        font-size: 18px;
        font-weight: 600;
    }

    /* Sidebar / Accordion */
    .donations-sidebar {
        display: flex;
        flex-direction: column;
    }

    .accordion-container {
        background: #fffef0;
        border: 2px solid #d4c89f;
        border-radius: 16px;
        padding: 1.5rem;
        position: sticky;
        top: 2rem;
    }

    .accordion-main-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 1rem 0;
        color: #000;
    }

    .accordion-main-title .icon {
        font-size: 18px;
    }

    .accordion {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .accordion-item {
        border: 2px solid #d4c89f;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
    }

    .accordion-button {
        width: 100%;
        padding: 1rem;
        background: #fff;
        border: none;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 16px;
        font-weight: 600;
        color: #000;
        transition: background-color 0.2s;
    }

    .accordion-button:hover {
        background: #f5f5f5;
    }

    .accordion-button[aria-expanded="true"] {
        background: #f0f0f0;
    }

    .accordion-icon {
        font-size: 16px;
        transition: transform 0.3s;
        color: #666;
    }

    .accordion-button[aria-expanded="true"] .accordion-icon {
        transform: scaleY(-1);
    }

    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .accordion-content.open {
        max-height: 1000px;
    }

    .accordion-body {
        padding: 1rem;
        color: #555;
        font-size: 16px;
        line-height: 1.6;
    }

    .accordion-body p {
        margin: 0 0 0.5rem 0;
        font-size: 16px;
    }

    .accordion-body p:last-child {
        margin-bottom: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .donations-container {
            grid-template-columns: 1fr;
        }

        .donations-header h1 {
            font-size: 2rem;
        }

        .amount-row {
            flex-direction: column;
            align-items: stretch;
        }

        .conversion-display {
            text-align: center;
        }
    }
</style>

<!-- QRCode.js library for generating QR codes -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
document.addEventListener( 'DOMContentLoaded', function() {
    // Exchange rates: 1 unit of crypto = X NZD (will be updated from API)
    let exchangeRates = {
        BTC: 130000,
        ETH: 4500,
        USDT: 1.65,
        USDC: 1.65
    };

    // Fetch live rates from CoinGecko API
    async function fetchLiveRates() {
        try {
            const response = await fetch(
                'https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,tether,usd-coin&vs_currencies=nzd'
            );
            if ( response.ok ) {
                const data = await response.json();
                if ( data.bitcoin?.nzd ) exchangeRates.BTC = data.bitcoin.nzd;
                if ( data.ethereum?.nzd ) exchangeRates.ETH = data.ethereum.nzd;
                if ( data.tether?.nzd ) exchangeRates.USDT = data.tether.nzd;
                if ( data['usd-coin']?.nzd ) exchangeRates.USDC = data['usd-coin'].nzd;
                console.log( 'Live rates loaded:', exchangeRates );
                updateConversion();
            }
        } catch ( err ) {
            console.warn( 'Failed to fetch live rates, using fallback:', err );
        }
    }

    // Fetch rates on page load
    fetchLiveRates();

    const blockchainNames = {
        BTC: 'Bitcoin',
        ETH: 'Ethereum',
        USDT: 'Ethereum',
        USDC: 'Ethereum'
    };

    // Load wallet data from PHP
    let walletData = {};
    try {
        const walletDataEl = document.getElementById( 'crypto-wallet-data' );
        if ( walletDataEl ) {
            walletData = JSON.parse( walletDataEl.textContent );
        }
    } catch ( e ) {
        console.error( 'Error parsing wallet data:', e );
    }

    // State management (matching React version)
    let currentStep = 1;
    let selectedCurrency = 'BTC';
    let nzdAmount = 100;
    let isAnonymous = false;
    let formData = {
        firstName: '',
        lastName: '',
        email: '',
        address1: '',
        address2: '',
        country: '',
        state: '',
        city: '',
        zip: ''
    };
    let taxEmail = '';
    let cryptoErrors = {};

    // Elements
    const tabButtons = document.querySelectorAll( '.tab-button' );
    const tabPanels = document.querySelectorAll( '.tab-panel' );
    const coinButtons = document.querySelectorAll( '.coin-button' );
    const currencySelect = document.getElementById( 'crypto-currency' );
    const nzdInput = document.getElementById( 'nzd-amount' );
    const conversionEl = document.getElementById( 'crypto-conversion' );
    const currencyLabel = document.getElementById( 'crypto-currency-label' );
    const anonymousCheckbox = document.getElementById( 'is-anonymous' );
    const personalFields = document.getElementById( 'personal-info-fields' );

    // Tab functionality
    tabButtons.forEach( button => {
        button.addEventListener( 'click', function() {
            const tabName = this.getAttribute( 'data-tab' );
            tabButtons.forEach( btn => {
                btn.classList.remove( 'active' );
                btn.setAttribute( 'aria-selected', 'false' );
            } );
            tabPanels.forEach( panel => panel.classList.remove( 'active' ) );
            this.classList.add( 'active' );
            this.setAttribute( 'aria-selected', 'true' );
            document.getElementById( 'tab-panel-' + tabName ).classList.add( 'active' );
        } );
    } );

    // Accordion functionality
    const accordionButtons = document.querySelectorAll( '.accordion-button' );
    accordionButtons.forEach( button => {
        button.addEventListener( 'click', function() {
            const isExpanded = this.getAttribute( 'aria-expanded' ) === 'true';
            const contentId = this.getAttribute( 'aria-controls' );
            const content = document.getElementById( contentId );
            
            if ( content ) {
                this.setAttribute( 'aria-expanded', !isExpanded );
                if ( !isExpanded ) {
                    content.classList.add( 'open' );
                    content.style.maxHeight = content.scrollHeight + 'px';
                } else {
                    content.classList.remove( 'open' );
                    content.style.maxHeight = '0px';
                }
            }
        } );
    } );

    // Calculate crypto amount (matching React logic)
    function getCryptoAmount() {
        return ( nzdAmount / exchangeRates[ selectedCurrency ] ).toFixed( 8 );
    }

    // Update conversion display
    function updateConversion() {
        const crypto = getCryptoAmount();
        if ( conversionEl ) conversionEl.textContent = crypto;
        if ( currencyLabel ) currencyLabel.textContent = selectedCurrency;
    }

    // Coin button click
    coinButtons.forEach( btn => {
        btn.addEventListener( 'click', function() {
            coinButtons.forEach( b => b.classList.remove( 'active' ) );
            this.classList.add( 'active' );
            selectedCurrency = this.getAttribute( 'data-currency' );
            if ( currencySelect ) currencySelect.value = selectedCurrency;
            updateConversion();
        } );
    } );

    // Currency dropdown change
    if ( currencySelect ) {
        currencySelect.addEventListener( 'change', function() {
            selectedCurrency = this.value;
            coinButtons.forEach( btn => {
                btn.classList.toggle( 'active', btn.getAttribute( 'data-currency' ) === selectedCurrency );
            } );
            updateConversion();
        } );
    }

    // Amount input change
    if ( nzdInput ) {
        nzdInput.addEventListener( 'input', function() {
            const val = this.value;
            if ( val === '' || parseFloat( val ) >= 0 ) {
                nzdAmount = parseFloat( val ) || 0;
                updateConversion();
            }
        } );
    }

    // Anonymous checkbox (matching React logic)
    if ( anonymousCheckbox ) {
        anonymousCheckbox.addEventListener( 'change', function() {
            isAnonymous = this.checked;
            if ( personalFields ) {
                personalFields.style.display = isAnonymous ? 'none' : 'block';
            }
            // Clear errors when toggling
            clearAllErrors();
        } );
    }

    // Clear all validation errors
    function clearAllErrors() {
        cryptoErrors = {};
        document.querySelectorAll( '.field-error' ).forEach( el => el.textContent = '' );
        document.querySelectorAll( '.form-field input.error' ).forEach( el => el.classList.remove( 'error' ) );
    }

    // Show field error
    function showError( fieldId, message ) {
        const input = document.getElementById( fieldId );
        const errorEl = document.getElementById( 'error-' + fieldId.replace( '-', '' ).replace( 'first-name', 'firstName' ).replace( 'last-name', 'lastName' ).replace( 'donor-email', 'email' ) );
        if ( input ) input.classList.add( 'error' );
        if ( errorEl ) errorEl.textContent = message;
    }

    // Validate personal info (matching React validateCryptoPersonalInfo)
    function validateCryptoPersonalInfo() {
        const newErrors = {};
        clearAllErrors();

        if ( !isAnonymous ) {
            const firstName = document.getElementById( 'first-name' )?.value?.trim() || '';
            const lastName = document.getElementById( 'last-name' )?.value?.trim() || '';
            const email = document.getElementById( 'donor-email' )?.value?.trim() || '';
            const address1 = document.getElementById( 'address1' )?.value?.trim() || '';
            const country = document.getElementById( 'country' )?.value?.trim() || '';
            const state = document.getElementById( 'state' )?.value?.trim() || '';
            const city = document.getElementById( 'city' )?.value?.trim() || '';
            const zip = document.getElementById( 'zip' )?.value?.trim() || '';

            if ( !firstName ) {
                newErrors.firstName = 'Required';
                showError( 'first-name', 'Required' );
            }
            if ( !lastName ) {
                newErrors.lastName = 'Required';
                showError( 'last-name', 'Required' );
            }
            if ( !email ) {
                newErrors.email = 'Required';
                showError( 'donor-email', 'Required' );
            } else if ( !email.includes( '@' ) ) {
                newErrors.email = 'Invalid email';
                showError( 'donor-email', 'Invalid email' );
            }
            if ( !address1 ) {
                newErrors.address1 = 'Required';
                showError( 'address1', 'Required' );
            }
            if ( !country ) {
                newErrors.country = 'Required';
                showError( 'country', 'Required' );
            }
            if ( !state ) {
                newErrors.state = 'Required';
                showError( 'state', 'Required' );
            }
            if ( !city ) {
                newErrors.city = 'Required';
                showError( 'city', 'Required' );
            }
            if ( !zip ) {
                newErrors.zip = 'Required';
                showError( 'zip', 'Required' );
            }
        }

        cryptoErrors = newErrors;
        return Object.keys( newErrors ).length === 0;
    }

    // Collect form data
    function collectFormData() {
        formData = {
            firstName: document.getElementById( 'first-name' )?.value || '',
            lastName: document.getElementById( 'last-name' )?.value || '',
            email: document.getElementById( 'donor-email' )?.value || '',
            address1: document.getElementById( 'address1' )?.value || '',
            address2: document.getElementById( 'address2' )?.value || '',
            country: document.getElementById( 'country' )?.value || '',
            state: document.getElementById( 'state' )?.value || '',
            city: document.getElementById( 'city' )?.value || '',
            zip: document.getElementById( 'zip' )?.value || ''
        };
    }

    // Step navigation
    function showStep( step ) {
        currentStep = step;
        document.querySelectorAll( '.crypto-step' ).forEach( s => {
            s.classList.toggle( 'hidden', parseInt( s.getAttribute( 'data-step' ) ) !== step );
        } );

        // Update wallet step with correct values
        if ( step === 4 ) {
            const cryptoAmount = getCryptoAmount();
            const finalAmountEl = document.getElementById( 'final-amount' );
            const warningCurrency = document.getElementById( 'warning-currency' );
            const warningBlockchain = document.getElementById( 'warning-blockchain' );
            const walletInput = document.getElementById( 'wallet-address' );
            const qrContainer = document.getElementById( 'qr-code' );

            if ( finalAmountEl ) finalAmountEl.textContent = cryptoAmount + ' ' + selectedCurrency;
            if ( warningCurrency ) warningCurrency.textContent = selectedCurrency;
            if ( warningBlockchain ) warningBlockchain.textContent = blockchainNames[ selectedCurrency ];

            // Get wallet address for selected currency
            const walletAddress = walletData[ selectedCurrency ] || '';
            if ( walletInput ) walletInput.value = walletAddress;

            // Generate QR code
            if ( qrContainer && walletAddress && typeof QRCode !== 'undefined' ) {
                qrContainer.innerHTML = '';
                new QRCode( qrContainer, {
                    text: walletAddress,
                    width: 150,
                    height: 150,
                    colorDark: '#000000',
                    colorLight: '#ffffff',
                    correctLevel: QRCode.CorrectLevel.H
                } );
            }
        }
    }

    // Reset all state (matching React logic)
    function resetState() {
        selectedCurrency = 'BTC';
        nzdAmount = 100;
        isAnonymous = false;
        formData = { firstName: '', lastName: '', email: '', address1: '', address2: '', country: '', state: '', city: '', zip: '' };
        taxEmail = '';
        cryptoErrors = {};

        // Reset UI
        if ( nzdInput ) nzdInput.value = '100';
        if ( currencySelect ) currencySelect.value = 'BTC';
        if ( anonymousCheckbox ) anonymousCheckbox.checked = false;
        if ( personalFields ) personalFields.style.display = 'block';

        // Reset form inputs
        [ 'first-name', 'last-name', 'donor-email', 'address1', 'address2', 'country', 'state', 'city', 'zip', 'tax-email' ].forEach( id => {
            const el = document.getElementById( id );
            if ( el ) el.value = '';
        } );

        // Reset coin buttons
        coinButtons.forEach( btn => {
            btn.classList.toggle( 'active', btn.getAttribute( 'data-currency' ) === 'BTC' );
        } );

        clearAllErrors();
        updateConversion();
    }

    // Back buttons
    document.querySelectorAll( '.back-button' ).forEach( btn => {
        btn.addEventListener( 'click', function() {
            showStep( parseInt( this.getAttribute( 'data-back' ) ) );
        } );
    } );

    // Amount validation
    function validateAmount() {
        const amountError = document.getElementById( 'amount-error' );
        if ( nzdAmount <= 0 ) {
            if ( nzdInput ) nzdInput.classList.add( 'error' );
            if ( amountError ) amountError.textContent = 'Amount must be greater than 0';
            return false;
        }
        if ( nzdInput ) nzdInput.classList.remove( 'error' );
        if ( amountError ) amountError.textContent = '';
        return true;
    }

    // Step 1: Donate button
    const btnDonate = document.getElementById( 'btn-donate-crypto' );
    if ( btnDonate ) {
        btnDonate.addEventListener( 'click', function() {
            if ( validateAmount() ) {
                showStep( 2 );
            }
        } );
    }

    // Step 2: Next button (with validation)
    const btnNextPersonal = document.getElementById( 'btn-next-personal' );
    if ( btnNextPersonal ) {
        btnNextPersonal.addEventListener( 'click', function() {
            if ( validateCryptoPersonalInfo() ) {
                collectFormData();
                showStep( 3 );
            }
        } );
    }

    // Toast notification function
    function showToast( message, type = 'success' ) {
        const toast = document.createElement( 'div' );
        toast.className = 'crypto-toast ' + type;
        toast.textContent = message;
        document.body.appendChild( toast );
        
        // Trigger animation
        setTimeout( () => toast.classList.add( 'show' ), 10 );
        
        // Remove after 4 seconds
        setTimeout( () => {
            toast.classList.remove( 'show' );
            setTimeout( () => toast.remove(), 300 );
        }, 4000 );
    }

    // Submit donation to API
    async function submitDonation() {
        const cryptoAmount = getCryptoAmount();
        const walletAddress = walletData[ selectedCurrency ] || '';
        
        // Get nonce from WordPress localized script
        // const nonce = ( typeof cryptoDonationAPI !== 'undefined' && cryptoDonationAPI.nonce ) 
        //     ? cryptoDonationAPI.nonce 
        //     : '';
        
        try {
            const headers = { 'Content-Type': 'application/json' };
            if ( nonce ) {
                headers['X-WP-Nonce'] = nonce;
            }
            
            const response = await fetch( '/wp-json/crypto-donations/v1/submit', {
                method: 'POST',
                headers: headers,
                body: JSON.stringify( {
                    donationType: 'crypto',
                    amount: cryptoAmount,
                    nzdAmount: String( nzdAmount ),
                    currency: selectedCurrency,
                    isAnonymous: isAnonymous,
                    firstName: formData.firstName,
                    lastName: formData.lastName,
                    email: formData.email,
                    address1: formData.address1,
                    address2: formData.address2,
                    country: formData.country,
                    state: formData.state,
                    city: formData.city,
                    zip: formData.zip,
                    taxReceiptEmail: taxEmail,
                    walletAddress: walletAddress
                } )
            } );
            
            if ( response.ok ) {
                const result = await response.json();
                console.log( 'Crypto donation submitted successfully:', result );
                showToast( 'Donation recorded! Thank you for your generosity.', 'success' );
                return true;
            } else {
                console.error( 'Error submitting donation:', response.status );
                showToast( 'There was an issue recording your donation.', 'error' );
                return false;
            }
        } catch ( err ) {
            console.error( 'Error submitting crypto donation:', err );
            showToast( 'There was an issue recording your donation.', 'error' );
            return false;
        }
    }

    // Step 3: Skip / Get Receipt - now submits donation
    const btnSkip = document.getElementById( 'btn-skip-tax' );
    const btnGetReceipt = document.getElementById( 'btn-get-receipt' );
    if ( btnSkip ) {
        btnSkip.addEventListener( 'click', async function() {
            await submitDonation();
            showStep( 4 );
        } );
    }
    if ( btnGetReceipt ) {
        btnGetReceipt.addEventListener( 'click', async function() {
            taxEmail = document.getElementById( 'tax-email' )?.value || '';
            await submitDonation();
            showStep( 4 );
        } );
    }

    // Step 4: Copy button (matching React handleCopyAddress)
    const btnCopy = document.getElementById( 'btn-copy' );
    if ( btnCopy ) {
        btnCopy.addEventListener( 'click', function() {
            const walletInput = document.getElementById( 'wallet-address' );
            if ( walletInput ) {
                navigator.clipboard.writeText( walletInput.value ).then( () => {
                    this.textContent = '✓';
                    setTimeout( () => { this.textContent = '📋'; }, 2000 );
                } );
            }
        } );
    }

    // Step 4: Start Over - just resets, no submission
    const btnStartOver = document.getElementById( 'btn-start-over' );
    if ( btnStartOver ) {
        btnStartOver.addEventListener( 'click', function() {
            resetState();
            showStep( 1 );
        } );
    }

    // Initialize with correct conversion
    updateConversion();
} );
</script>

<?php
get_footer();
?>
