<?php
/**
 * Template: Donations with Tabs and ACF Accordion
 * 
 * This template displays donation forms (Cash via GiveWP, Crypto via custom form)
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
                        // Display GiveWP form using shortcode
                        // Replace 'form_id' with your actual GiveWP form ID
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
                    <div class="crypto-form-wrapper">
                        <form id="crypto-donation-form" data-testid="form-crypto-donation">
                            <div class="form-group">
                                <label for="crypto-amount" data-testid="label-crypto-amount">
                                    Amount
                                </label>
                                <div class="input-group">
                                    <span class="currency-symbol">₿</span>
                                    <input 
                                        type="number" 
                                        id="crypto-amount" 
                                        name="amount"
                                        placeholder="0.00"
                                        step="0.00000001"
                                        min="0"
                                        required
                                        data-testid="input-crypto-amount"
                                    />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="crypto-currency" data-testid="label-crypto-currency">
                                    Cryptocurrency
                                </label>
                                <select 
                                    id="crypto-currency" 
                                    name="currency"
                                    required
                                    data-testid="select-crypto-currency"
                                >
                                    <option value="BTC">Bitcoin (BTC)</option>
                                    <option value="ETH">Ethereum (ETH)</option>
                                    <option value="USDT">Tether (USDT)</option>
                                    <option value="USDC">USD Coin (USDC)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="crypto-wallet" data-testid="label-crypto-wallet">
                                    Your Wallet Address
                                </label>
                                <input 
                                    type="text" 
                                    id="crypto-wallet" 
                                    name="walletAddress"
                                    placeholder="Enter your wallet address"
                                    required
                                    data-testid="input-crypto-wallet"
                                />
                            </div>

                            <div class="form-group">
                                <label for="crypto-email" data-testid="label-crypto-email">
                                    Email Address (for receipt)
                                </label>
                                <input 
                                    type="email" 
                                    id="crypto-email" 
                                    name="email"
                                    placeholder="your@email.com"
                                    required
                                    data-testid="input-crypto-email"
                                />
                            </div>

                            <div class="form-group checkbox">
                                <input 
                                    type="checkbox" 
                                    id="crypto-anonymous" 
                                    name="isAnonymous"
                                    data-testid="checkbox-crypto-anonymous"
                                />
                                <label for="crypto-anonymous" data-testid="label-crypto-anonymous-text">
                                    Make this donation anonymous
                                </label>
                            </div>

                            <button 
                                type="submit" 
                                class="donate-button"
                                data-testid="button-crypto-submit"
                            >
                                Donate Crypto
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Accordion -->
        <aside class="donations-sidebar">
            <div class="accordion-container" data-testid="container-ways-to-give">
                <h2 class="accordion-title">
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
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Forms */
    .givewp-form-wrapper,
    .crypto-form-wrapper {
        background: #f9f9f9;
        border: 2px solid #000;
        border-radius: 8px;
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
        color: #000;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-group input:not([type="checkbox"]),
    .form-group select {
        padding: 0.75rem;
        border: 2px solid #000;
        border-radius: 4px;
        font-size: 1rem;
        background: #fff;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
    }

    .input-group {
        position: relative;
        display: flex;
        align-items: center;
    }

    .currency-symbol {
        position: absolute;
        left: 0.75rem;
        font-weight: 600;
        color: #666;
    }

    .input-group input {
        padding-left: 2rem;
        width: 100%;
    }

    .form-group.checkbox {
        flex-direction: row;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .form-group.checkbox input {
        width: auto;
        margin: 0;
    }

    .form-group.checkbox label {
        margin: 0;
        text-transform: none;
        font-weight: 400;
        font-size: 0.95rem;
    }

    .donate-button {
        width: 100%;
        padding: 1rem;
        background: #fff;
        border: 2px solid #000;
        border-radius: 4px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .donate-button:hover {
        background: #000;
        color: #fff;
    }

    /* Sidebar */
    .donations-sidebar {
        display: flex;
        flex-direction: column;
    }

    .accordion-container {
        background: #fffef0;
        border: 2px solid #d4c89f;
        border-radius: 8px;
        padding: 1.5rem;
        position: sticky;
        top: 2rem;
    }

    .accordion-container .accordion-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1rem;
        font-weight: 700;
        margin: 0 0 1rem 0;
        color: #000;
    }

    .accordion-container .icon {
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
        border-radius: 4px;
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
        transition: background-color 0.3s ease;
    }

    .accordion-button:hover {
        background: #f5f5f5;
    }

    .accordion-button[aria-expanded="true"] {
        background: #f0f0f0;
    }

    .accordion-icon {
        font-size: 0.75rem;
        transition: transform 0.3s ease;
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
    }
</style>

<script>
    document.addEventListener( 'DOMContentLoaded', function() {
        // Tab functionality
        const tabButtons = document.querySelectorAll( '.tab-button' );
        const tabPanels = document.querySelectorAll( '.tab-panel' );

        tabButtons.forEach( button => {
            button.addEventListener( 'click', function() {
                const tabName = this.getAttribute( 'data-tab' );

                // Deactivate all tabs and panels
                tabButtons.forEach( btn => {
                    btn.classList.remove( 'active' );
                    btn.setAttribute( 'aria-selected', 'false' );
                } );
                tabPanels.forEach( panel => {
                    panel.classList.remove( 'active' );
                } );

                // Activate current tab and panel
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
                        content.style.maxHeight = content.scrollHeight + 'px';
                    } else {
                        content.style.maxHeight = '0px';
                    }
                }
            } );
        } );

        // Crypto form submission
        const cryptoForm = document.getElementById( 'crypto-donation-form' );
        if ( cryptoForm ) {
            cryptoForm.addEventListener( 'submit', async function( e ) {
                e.preventDefault();

                const formData = new FormData( this );
                const data = {
                    donationType: 'crypto',
                    amount: formData.get( 'amount' ),
                    currency: formData.get( 'currency' ),
                    email: formData.get( 'email' ),
                    walletAddress: formData.get( 'walletAddress' ),
                    isAnonymous: formData.get( 'isAnonymous' ) ? true : false,
                };

                try {
                    // Adjust this URL to match your backend
                    const response = await fetch( '/api/donations/crypto', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify( data ),
                    } );

                    if ( response.ok ) {
                        alert( 'Donation submitted successfully!' );
                        this.reset();
                    } else {
                        alert( 'Error submitting donation. Please try again.' );
                    }
                } catch ( error ) {
                    console.error( 'Error:', error );
                    alert( 'Error submitting donation. Please try again.' );
                }
            } );
        }
    } );
</script>

<?php
get_footer();
?>
