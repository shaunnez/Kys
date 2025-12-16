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
            <?php echo do_shortcode( '[kys_donate_accordions]' ); ?>
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
        font-size: 1rem;
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
        position: relative;
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
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(8px);
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
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

<script>
document.addEventListener( 'DOMContentLoaded', function() {
    // Exchange rates: 1 unit of crypto = X NZD (matching React version)
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
            if ( finalAmountEl ) finalAmountEl.textContent = cryptoAmount + ' ' + selectedCurrency;
            if ( warningCurrency ) warningCurrency.textContent = selectedCurrency;
            if ( warningBlockchain ) warningBlockchain.textContent = blockchainNames[ selectedCurrency ];
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

    // Step 1: Donate button
    const btnDonate = document.getElementById( 'btn-donate-crypto' );
    if ( btnDonate ) {
        btnDonate.addEventListener( 'click', function() {
            showStep( 2 );
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

    // Step 4: Start Over (matching React logic)
    const btnStartOver = document.getElementById( 'btn-start-over' );
    if ( btnStartOver ) {
        btnStartOver.addEventListener( 'click', async function() {
            // Submit donation (matching React)
            const cryptoAmount = getCryptoAmount();
            try {
                await fetch( '/api/donations/crypto', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify( {
                        donationType: 'crypto',
                        amount: cryptoAmount,
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
                        walletAddress: document.getElementById( 'wallet-address' )?.value || ''
                    } )
                } );
                console.log( 'Crypto donation created' );
            } catch ( err ) {
                console.error( 'Error submitting crypto donation:', err );
            }

            // Reset and go back to step 1
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
