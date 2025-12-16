<?php
/**
 * Plugin Name: Crypto Donations API
 * Description: REST API endpoint for crypto donations with email notification
 * Version: 1.0.0
 * 
 * Add this file to your WordPress theme's functions.php or as a standalone plugin.
 * If using as a plugin, place in wp-content/plugins/crypto-donations-api/
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue script with nonce for crypto donation form
 */
add_action( 'wp_enqueue_scripts', function() {
    wp_localize_script( 'jquery', 'cryptoDonationAPI', array(
        'nonce'   => wp_create_nonce( 'crypto_donation_nonce' ),
        'ajaxUrl' => rest_url( 'crypto-donations/v1/submit' ),
    ) );
} );

/**
 * Register the REST API endpoint for crypto donations
 */
add_action( 'rest_api_init', function() {
    register_rest_route( 'crypto-donations/v1', '/submit', array(
        'methods'             => 'POST',
        'callback'            => 'handle_crypto_donation_submission',
        'permission_callback' => 'verify_crypto_donation_nonce',
    ) );
} );

/**
 * Verify the nonce for crypto donation submission
 * 
 * @param WP_REST_Request $request The request object
 * @return bool|WP_Error
 */
function verify_crypto_donation_nonce( WP_REST_Request $request ) {
    $nonce = $request->get_header( 'X-WP-Nonce' );
    
    // If nonce is provided, verify it
    if ( $nonce ) {
        if ( wp_verify_nonce( $nonce, 'crypto_donation_nonce' ) ) {
            return true;
        }
        return new WP_Error(
            'rest_forbidden',
            __( 'Invalid security token.' ),
            array( 'status' => 403 )
        );
    }
    
    // Allow without nonce only if request comes from same origin (basic CORS check)
    $origin = $request->get_header( 'Origin' );
    $referer = $request->get_header( 'Referer' );
    $site_url = site_url();
    
    if ( ( $referer && strpos( $referer, $site_url ) === 0 ) || 
         ( $origin && strpos( $origin, parse_url( $site_url, PHP_URL_HOST ) ) !== false ) ) {
        return true;
    }
    
    return new WP_Error(
        'rest_forbidden',
        __( 'Request origin not allowed.' ),
        array( 'status' => 403 )
    );
}

/**
 * Handle the crypto donation submission
 * 
 * @param WP_REST_Request $request The request object
 * @return WP_REST_Response
 */
function handle_crypto_donation_submission( WP_REST_Request $request ) {
    $params = $request->get_json_params();

    // Extract donation data
    $donation_data = array(
        'donation_type'     => sanitize_text_field( $params['donationType'] ?? 'crypto' ),
        'amount'            => sanitize_text_field( $params['amount'] ?? '' ),
        'nzd_amount'        => sanitize_text_field( $params['nzdAmount'] ?? '' ),
        'currency'          => sanitize_text_field( $params['currency'] ?? '' ),
        'is_anonymous'      => ! empty( $params['isAnonymous'] ),
        'first_name'        => sanitize_text_field( $params['firstName'] ?? '' ),
        'last_name'         => sanitize_text_field( $params['lastName'] ?? '' ),
        'email'             => sanitize_email( $params['email'] ?? '' ),
        'address1'          => sanitize_text_field( $params['address1'] ?? '' ),
        'address2'          => sanitize_text_field( $params['address2'] ?? '' ),
        'country'           => sanitize_text_field( $params['country'] ?? '' ),
        'state'             => sanitize_text_field( $params['state'] ?? '' ),
        'city'              => sanitize_text_field( $params['city'] ?? '' ),
        'zip'               => sanitize_text_field( $params['zip'] ?? '' ),
        'tax_receipt_email' => sanitize_email( $params['taxReceiptEmail'] ?? '' ),
        'wallet_address'    => sanitize_text_field( $params['walletAddress'] ?? '' ),
        'submitted_at'      => current_time( 'mysql' ),
    );

    // Store in WordPress options (could also use custom post type or custom table)
    $donations = get_option( 'crypto_donations_log', array() );
    $donation_data['id'] = uniqid( 'crypto_', true );
    $donations[] = $donation_data;
    update_option( 'crypto_donations_log', $donations );

    // Send email notification
    $email_sent = send_crypto_donation_email( $donation_data );

    return new WP_REST_Response( array(
        'success'    => true,
        'message'    => 'Donation recorded successfully',
        'email_sent' => $email_sent,
        'id'         => $donation_data['id'],
    ), 200 );
}

/**
 * Send email notification for crypto donation
 * 
 * @param array $donation_data The donation data
 * @return bool Whether the email was sent
 */
function send_crypto_donation_email( $donation_data ) {
    $admin_email = 'shaunnesbittuk@gmail.com';
    
    $subject = sprintf(
        '[Crypto Donation] %s %s donation received',
        $donation_data['amount'],
        $donation_data['currency']
    );

    $donor_name = $donation_data['is_anonymous'] 
        ? 'Anonymous Donor' 
        : trim( $donation_data['first_name'] . ' ' . $donation_data['last_name'] );

    $message = "A new crypto donation has been submitted:\n\n";
    $message .= "=== DONATION DETAILS ===\n";
    $message .= "Amount: {$donation_data['amount']} {$donation_data['currency']}\n";
    $message .= "NZD Amount: \${$donation_data['nzd_amount']} NZD\n";
    $message .= "Wallet Address: {$donation_data['wallet_address']}\n";
    $message .= "Submitted: {$donation_data['submitted_at']}\n\n";

    if ( ! $donation_data['is_anonymous'] ) {
        $message .= "=== DONOR INFORMATION ===\n";
        $message .= "Name: {$donor_name}\n";
        $message .= "Email: {$donation_data['email']}\n";
        $message .= "Address: {$donation_data['address1']}\n";
        if ( ! empty( $donation_data['address2'] ) ) {
            $message .= "         {$donation_data['address2']}\n";
        }
        $message .= "City: {$donation_data['city']}\n";
        $message .= "State: {$donation_data['state']}\n";
        $message .= "Zip: {$donation_data['zip']}\n";
        $message .= "Country: {$donation_data['country']}\n\n";
    } else {
        $message .= "=== DONOR INFORMATION ===\n";
        $message .= "Donor chose to remain anonymous.\n\n";
    }

    if ( ! empty( $donation_data['tax_receipt_email'] ) ) {
        $message .= "=== TAX RECEIPT ===\n";
        $message .= "Tax receipt requested for: {$donation_data['tax_receipt_email']}\n\n";
    }

    $message .= "---\n";
    $message .= "This email was sent automatically from your website.";

    $headers = array( 'Content-Type: text/plain; charset=UTF-8' );

    return wp_mail( $admin_email, $subject, $message, $headers );
}

/**
 * Admin page to view crypto donations (optional)
 */
add_action( 'admin_menu', function() {
    add_menu_page(
        'Crypto Donations',
        'Crypto Donations',
        'manage_options',
        'crypto-donations',
        'render_crypto_donations_admin_page',
        'dashicons-money-alt',
        30
    );
} );

/**
 * Render the admin page for viewing donations
 */
function render_crypto_donations_admin_page() {
    $donations = get_option( 'crypto_donations_log', array() );
    $donations = array_reverse( $donations ); // Show newest first
    ?>
    <div class="wrap">
        <h1>Crypto Donations</h1>
        
        <?php if ( empty( $donations ) ) : ?>
            <p>No crypto donations have been recorded yet.</p>
        <?php else : ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Currency</th>
                        <th>Donor</th>
                        <th>Email</th>
                        <th>Wallet</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $donations as $donation ) : ?>
                        <tr>
                            <td><?php echo esc_html( $donation['submitted_at'] ?? 'N/A' ); ?></td>
                            <td><?php echo esc_html( $donation['amount'] ?? 'N/A' ); ?></td>
                            <td><?php echo esc_html( $donation['currency'] ?? 'N/A' ); ?></td>
                            <td>
                                <?php 
                                if ( ! empty( $donation['is_anonymous'] ) ) {
                                    echo 'Anonymous';
                                } else {
                                    echo esc_html( trim( ( $donation['first_name'] ?? '' ) . ' ' . ( $donation['last_name'] ?? '' ) ) ?: 'N/A' );
                                }
                                ?>
                            </td>
                            <td><?php echo esc_html( $donation['email'] ?? 'N/A' ); ?></td>
                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                <?php echo esc_html( $donation['wallet_address'] ?? 'N/A' ); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php
}
