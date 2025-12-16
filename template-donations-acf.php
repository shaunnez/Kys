<?php
/**
 * Template: Donations with ACF Accordion
 * 
 * This template displays donation information using Advanced Custom Fields (ACF)
 * accordion component for organized content display.
 * 
 * @package WordPress
 */

get_header();
?>

<div class="donations-container">
    <header class="donations-header">
        <h1><?php the_title(); ?></h1>
        <p class="donations-subtitle">
            <?php the_excerpt(); ?>
        </p>
    </header>

    <main class="donations-main">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                
                <div class="donations-content">
                    <!-- ACF Accordion Field -->
                    <?php
                    $accordion = get_field( 'donations_accordion' );
                    
                    if ( $accordion ) :
                        ?>
                        <div class="acf-accordion-wrapper">
                            <?php foreach ( $accordion as $index => $item ) : ?>
                                <div class="accordion-item" data-testid="accordion-item-<?php echo $index; ?>">
                                    <button 
                                        class="accordion-header" 
                                        aria-expanded="false"
                                        aria-controls="accordion-panel-<?php echo $index; ?>"
                                        data-testid="button-accordion-header-<?php echo $index; ?>"
                                    >
                                        <span class="accordion-title" data-testid="text-accordion-title-<?php echo $index; ?>">
                                            <?php echo esc_html( $item['title'] ?? 'Section Title' ); ?>
                                        </span>
                                        <span class="accordion-icon" aria-hidden="true">+</span>
                                    </button>
                                    
                                    <div 
                                        id="accordion-panel-<?php echo $index; ?>"
                                        class="accordion-panel" 
                                        role="region"
                                        aria-labelledby="accordion-header-<?php echo $index; ?>"
                                        data-testid="content-accordion-panel-<?php echo $index; ?>"
                                    >
                                        <div class="accordion-content">
                                            <?php
                                            if ( isset( $item['content'] ) ) {
                                                echo wp_kses_post( $item['content'] );
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php
                    endif;
                    ?>
                </div>

                <!-- Post Content Fallback -->
                <div class="post-content" data-testid="content-post-body">
                    <?php the_content(); ?>
                </div>

                <!-- Navigation -->
                <nav class="post-navigation" data-testid="nav-post-navigation">
                    <?php
                    wp_link_pages( array(
                        'before'      => '<div class="page-links"><span>' . esc_html__( 'Pages:', 'textdomain' ) . '</span>',
                        'after'       => '</div>',
                        'link_before' => '<span>',
                        'link_after'  => '</span>',
                    ) );
                    ?>
                </nav>

            <?php endwhile; ?>
        <?php else : ?>
            <div class="no-content" data-testid="text-no-posts">
                <p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'textdomain' ); ?></p>
            </div>
        <?php endif; ?>
    </main>
</div>

<style>
    .donations-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .donations-header {
        margin-bottom: 2rem;
        text-align: center;
    }

    .donations-header h1 {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .donations-subtitle {
        font-size: 1.1rem;
        color: #666;
        line-height: 1.6;
    }

    .acf-accordion-wrapper {
        margin: 2rem 0;
    }

    .accordion-item {
        border: 1px solid #e0e0e0;
        margin-bottom: 0.5rem;
        border-radius: 4px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .accordion-item:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .accordion-header {
        width: 100%;
        padding: 1.25rem 1.5rem;
        background-color: #f5f5f5;
        border: none;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        transition: background-color 0.3s ease;
    }

    .accordion-header:hover {
        background-color: #efefef;
    }

    .accordion-header[aria-expanded="true"] {
        background-color: #e8f4f8;
    }

    .accordion-icon {
        font-size: 1.5rem;
        transition: transform 0.3s ease;
        color: #0066cc;
    }

    .accordion-header[aria-expanded="true"] .accordion-icon {
        transform: rotate(45deg);
    }

    .accordion-panel {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .accordion-panel[aria-expanded="true"] {
        max-height: 1000px;
    }

    .accordion-content {
        padding: 1.5rem;
        background-color: #fafafa;
        color: #555;
        line-height: 1.8;
    }

    .accordion-content p {
        margin: 0 0 1rem 0;
    }

    .accordion-content p:last-child {
        margin-bottom: 0;
    }

    .post-content {
        margin: 2rem 0;
        line-height: 1.8;
        color: #333;
    }

    .no-content {
        text-align: center;
        padding: 2rem;
        color: #999;
        font-size: 1.1rem;
    }
</style>

<script>
    document.addEventListener( 'DOMContentLoaded', function() {
        const accordionHeaders = document.querySelectorAll( '.accordion-header' );

        accordionHeaders.forEach( header => {
            header.addEventListener( 'click', function() {
                const isExpanded = this.getAttribute( 'aria-expanded' ) === 'true';
                const panelId = this.getAttribute( 'aria-controls' );
                const panel = document.getElementById( panelId );

                // Close other panels
                accordionHeaders.forEach( otherHeader => {
                    if ( otherHeader !== this ) {
                        otherHeader.setAttribute( 'aria-expanded', 'false' );
                        const otherPanelId = otherHeader.getAttribute( 'aria-controls' );
                        const otherPanel = document.getElementById( otherPanelId );
                        if ( otherPanel ) {
                            otherPanel.setAttribute( 'aria-expanded', 'false' );
                        }
                    }
                } );

                // Toggle current panel
                this.setAttribute( 'aria-expanded', !isExpanded );
                if ( panel ) {
                    panel.setAttribute( 'aria-expanded', !isExpanded );
                }
            } );
        } );
    } );
</script>

<?php
get_footer();
?>
