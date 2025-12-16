<?php
/**
 * Template: Donations with Tabs and ACF Accordion
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
            <!-- Tabs Navigation -->
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
                        <?php
                        $givewp_form_id = get_field( 'givewp_form_id' );
                        
                        if ( $givewp_form_id ) {
                            echo do_shortcode( '[give_form id="' . intval( $givewp_form_id ) . '"]' );
                        } else {
                            echo '<p class="notice">' . esc_html__( 'GiveWP form not configured. Please set the form ID in ACF.', 'textdomain' ) . '</p>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Crypto Donation Tab -->
                <div 
                    id="tab-panel-crypto"
                    class="tab-panel" 
                    role="tabpanel" 
                    aria-labelledby="tab-crypto"
                    data-testid="panel-crypto-form"
                >
                    <div class="crypto-widget" id="crypto-widget">
                        <!-- Step 1: Donation Amount -->
                        <div class="crypto-step" id="step-donation" data-step="1">
                            <div class="crypto-card">
                                <h3 class="crypto-card-title">Make a Donation</h3>
                                
                                <!-- Coin Selection Buttons -->
                                <div class="coin-buttons">
                                    <button type="button" class="coin-button active" data-currency="BTC" data-testid="button-btc">
                                        <span class="coin-icon btc">₿</span>
                                        <span>BTC</span>
                                    </button>
                                    <button type="button" class="coin-button" data-currency="ETH" data-testid="button-eth">
                                        <span class="coin-icon eth">Ξ</span>
                                        <span>ETH</span>
                                    </button>
                                    <button type="button" class="coin-button" data-currency="USDC" data-testid="button-usdc">
                                        <span class="coin-icon usdc">$</span>
                                        <span>USDC</span>
                                    </button>
                                </div>

                                <!-- Currency Dropdown -->
                                <div class="form-field">
                                    <select id="crypto-currency" class="crypto-select" data-testid="select-currency">
                                        <option value="BTC">Bitcoin (BTC)</option>
                                        <option value="ETH">Ethereum (ETH)</option>
                                        <option value="USDC">USD Coin (USDC)</option>
                                        <option value="USDT">Tether (USDT)</option>
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
                                            min="0"
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
                                        </div>
                                        <div class="form-field">
                                            <input type="text" id="last-name" placeholder="Last name" data-testid="input-lastName" />
                                        </div>
                                    </div>

                                    <div class="form-field">
                                        <input type="email" id="donor-email" placeholder="Email" data-testid="input-email" />
                                    </div>

                                    <div class="form-field">
                                        <input type="text" id="address1" placeholder="Address 1" data-testid="input-address1" />
                                    </div>

                                    <div class="form-field">
                                        <input type="text" id="address2" placeholder="Address 2" data-testid="input-address2" />
                                    </div>

                                    <div class="form-row two-col">
                                        <div class="form-field">
                                            <input type="text" id="country" placeholder="Country" data-testid="input-country" />
                                        </div>
                                        <div class="form-field">
                                            <input type="text" id="state" placeholder="State/Province" data-testid="input-state" />
                                        </div>
                                    </div>

                                    <div class="form-row two-col">
                                        <div class="form-field">
                                            <input type="text" id="city" placeholder="City" data-testid="input-city" />
                                        </div>
                                        <div class="form-field">
                                            <input type="text" id="zip" placeholder="ZIP/Postal Code" data-testid="input-zip" />
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

                <?php
                $accordion_items = get_field( 'ways_to_give_accordion' );
                
                if ( $accordion_items ) :
                    ?>
                    <div class="accordion">
                        <?php foreach ( $accordion_items as $index => $item ) : ?>
                            <div class="accordion-item" data-testid="accordion-item-<?php echo $index; ?>">
                                <button 
                                    class="accordion-button" 
                                    aria-expanded="false"
                                    aria-controls="accordion-content-<?php echo $index; ?>"
                                    data-testid="button-accordion-<?php echo $index; ?>"
                                >
                                    <span class="accordion-item-title" data-testid="text-accordion-title-<?php echo $index; ?>">
                                        <?php echo esc_html( $item['title'] ?? '' ); ?>
                                    </span>
                                    <span class="accordion-icon">∨</span>
                                </button>

                                <div 
                                    id="accordion-content-<?php echo $index; ?>"
                                    class="accordion-content"
                                    role="region"
                                    data-testid="content-accordion-body-<?php echo $index; ?>"
                                >
                                    <div class="accordion-body">
                                        <?php echo wp_kses_post( $item['content'] ?? '' ); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php
                else :
                    ?>
                    <div class="no-accordion" data-testid="text-no-accordion">
                        <p><?php esc_html_e( 'Accordion sections not configured.', 'textdomain' ); ?></p>
                    </div>
                    <?php
                endif;
                ?>
            </div>
        </aside>
    </div>
</div>

<style>
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
        font-size: 1rem;
        color: #555;
        line-height: 1.6;
        max-width: 600px;
        margin: 0;
    }

    .donations-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 2rem;
    }

    /* Tabs */
    .donation-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #e0e0e0;
    }

    .tab-button {
        background: none;
        border: none;
        padding: 1rem 0;
        font-size: 1rem;
        font-weight: 600;
        color: #999;
        cursor: pointer;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
        position: relative;
        bottom: -2px;
    }

    .tab-button:hover {
        color: #333;
    }

    .tab-button.active {
        color: #000;
        border-bottom-color: #000;
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
        from { opacity: 0; }
        to { opacity: 1; }
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
        font-size: 1.25rem;
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

    /* Form Fields */
    .form-field {
        margin-bottom: 1rem;
    }

    .form-field input,
    .form-field select {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 1rem;
        transition: border-color 0.2s;
    }

    .form-field input:focus,
    .form-field select:focus {
        outline: none;
        border-color: #333;
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
        font-size: 1rem;
        background: #fff;
        cursor: pointer;
    }

    /* Amount Row */
    .amount-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .amount-input-wrapper {
        position: relative;
        flex: 1;
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
        font-size: 1.125rem;
        font-weight: 600;
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
        font-size: 1rem;
        font-weight: 600;
        color: #666;
        white-space: nowrap;
    }

    /* Buttons */
    .donate-btn {
        width: 100%;
        padding: 1rem;
        border-radius: 12px;
        font-size: 1.125rem;
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
        font-size: 0.875rem;
        color: #333;
    }

    .copy-button {
        background: none;
        border: none;
        font-size: 1.25rem;
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
        font-size: 0.875rem;
        color: #8B6914;
        line-height: 1.5;
    }

    .info-icon {
        font-size: 0.875rem;
        color: #999;
        margin-left: 0.5rem;
    }

    /* GiveWP wrapper */
    .givewp-form-wrapper {
        background: #f9f9f9;
        border: 2px solid #000;
        border-radius: 24px;
        padding: 2rem;
    }

    /* Sidebar */
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
        font-size: 1.125rem;
        font-weight: 700;
        margin: 0 0 1rem 0;
        color: #000;
    }

    .accordion-main-title .icon {
        font-size: 1.25rem;
    }

    /* Accordion */
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
        font-size: 0.95rem;
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
        font-size: 0.75rem;
        transition: transform 0.3s;
        color: #666;
    }

    .accordion-button[aria-expanded="true"] .accordion-icon {
        transform: scaleY(-1);
    }

    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s;
    }

    .accordion-button[aria-expanded="true"] ~ .accordion-content {
        max-height: 500px;
    }

    .accordion-body {
        padding: 1rem;
        color: #555;
        font-size: 0.9rem;
        line-height: 1.6;
    }

    .accordion-body p {
        margin: 0 0 0.5rem 0;
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

        .accordion-container {
            position: static;
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

<script>
document.addEventListener( 'DOMContentLoaded', function() {
    // Exchange rates: 1 unit of crypto = X NZD
    const exchangeRates = {
        BTC: 130000,
        ETH: 4500,
        USDT: 1.65,
        USDC: 1.65
    };

    const blockchainNames = {
        BTC: 'Bitcoin',
        ETH: 'Ethereum',
        USDT: 'Ethereum',
        USDC: 'Ethereum'
    };

    let currentStep = 1;
    let selectedCurrency = 'BTC';
    let nzdAmount = 100;
    let isAnonymous = false;
    let formData = {};
    let taxEmail = '';

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
                content.style.maxHeight = isExpanded ? '0px' : content.scrollHeight + 'px';
            }
        } );
    } );

    // Update conversion display
    function updateConversion() {
        const crypto = ( nzdAmount / exchangeRates[ selectedCurrency ] ).toFixed( 8 );
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
            nzdAmount = parseFloat( this.value ) || 0;
            updateConversion();
        } );
    }

    // Anonymous checkbox
    if ( anonymousCheckbox ) {
        anonymousCheckbox.addEventListener( 'change', function() {
            isAnonymous = this.checked;
            if ( personalFields ) {
                personalFields.style.display = isAnonymous ? 'none' : 'block';
            }
        } );
    }

    // Step navigation
    function showStep( step ) {
        currentStep = step;
        document.querySelectorAll( '.crypto-step' ).forEach( s => {
            s.classList.toggle( 'hidden', parseInt( s.getAttribute( 'data-step' ) ) !== step );
        } );

        // Update wallet step with correct values
        if ( step === 4 ) {
            const cryptoAmount = ( nzdAmount / exchangeRates[ selectedCurrency ] ).toFixed( 8 );
            const finalAmountEl = document.getElementById( 'final-amount' );
            const warningCurrency = document.getElementById( 'warning-currency' );
            const warningBlockchain = document.getElementById( 'warning-blockchain' );
            if ( finalAmountEl ) finalAmountEl.textContent = cryptoAmount + ' ' + selectedCurrency;
            if ( warningCurrency ) warningCurrency.textContent = selectedCurrency;
            if ( warningBlockchain ) warningBlockchain.textContent = blockchainNames[ selectedCurrency ];
        }
    }

    // Back buttons
    document.querySelectorAll( '.back-button' ).forEach( btn => {
        btn.addEventListener( 'click', function() {
            showStep( parseInt( this.getAttribute( 'data-back' ) ) );
        } );
    } );

    // Step 1: Donate button
    const btnDonate = document.getElementById( 'btn-donate-crypto' );
    if ( btnDonate ) {
        btnDonate.addEventListener( 'click', function() {
            showStep( 2 );
        } );
    }

    // Step 2: Next button
    const btnNextPersonal = document.getElementById( 'btn-next-personal' );
    if ( btnNextPersonal ) {
        btnNextPersonal.addEventListener( 'click', function() {
            // Collect form data
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
            showStep( 3 );
        } );
    }

    // Step 3: Skip / Get Receipt
    const btnSkip = document.getElementById( 'btn-skip-tax' );
    const btnGetReceipt = document.getElementById( 'btn-get-receipt' );
    if ( btnSkip ) {
        btnSkip.addEventListener( 'click', function() {
            showStep( 4 );
        } );
    }
    if ( btnGetReceipt ) {
        btnGetReceipt.addEventListener( 'click', function() {
            taxEmail = document.getElementById( 'tax-email' )?.value || '';
            showStep( 4 );
        } );
    }

    // Step 4: Copy button
    const btnCopy = document.getElementById( 'btn-copy' );
    if ( btnCopy ) {
        btnCopy.addEventListener( 'click', function() {
            const walletInput = document.getElementById( 'wallet-address' );
            if ( walletInput ) {
                navigator.clipboard.writeText( walletInput.value );
                this.textContent = '✓';
                setTimeout( () => { this.textContent = '📋'; }, 2000 );
            }
        } );
    }

    // Step 4: Start Over
    const btnStartOver = document.getElementById( 'btn-start-over' );
    if ( btnStartOver ) {
        btnStartOver.addEventListener( 'click', async function() {
            // Submit donation
            const cryptoAmount = ( nzdAmount / exchangeRates[ selectedCurrency ] ).toFixed( 8 );
            try {
                await fetch( '/api/donations/crypto', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify( {
                        donationType: 'crypto',
                        amount: cryptoAmount,
                        currency: selectedCurrency,
                        isAnonymous: isAnonymous,
                        ...formData,
                        taxReceiptEmail: taxEmail,
                        walletAddress: document.getElementById( 'wallet-address' )?.value || ''
                    } )
                } );
            } catch ( err ) {
                console.error( 'Error submitting donation:', err );
            }

            // Reset
            selectedCurrency = 'BTC';
            nzdAmount = 100;
            isAnonymous = false;
            formData = {};
            taxEmail = '';
            if ( nzdInput ) nzdInput.value = '100';
            if ( currencySelect ) currencySelect.value = 'BTC';
            if ( anonymousCheckbox ) anonymousCheckbox.checked = false;
            if ( personalFields ) personalFields.style.display = 'block';
            coinButtons.forEach( btn => {
                btn.classList.toggle( 'active', btn.getAttribute( 'data-currency' ) === 'BTC' );
            } );
            updateConversion();
            showStep( 1 );
        } );
    }

    // Initial conversion
    updateConversion();
} );
</script>

<?php
get_footer();
?>
