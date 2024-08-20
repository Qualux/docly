<?php 

$logo_id = carbon_get_theme_option( 'docly_logo' );

if ( $logo_id ) {
    $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
    $logo_alt = get_post_meta( $logo_id, '_wp_attachment_image_alt', true );
    $logo_meta = wp_get_attachment_metadata( $logo_id );

    if ( $logo_meta ) {
        $logo_width = $logo_meta['width'];
        $logo_height = $logo_meta['height'];

        
    }
}

$docly_github_button = carbon_get_theme_option( 'docly_github_button' );
$github_url = carbon_get_theme_option( 'docly_github_url' );

?>


<html>
    <head>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>

    <header class="docly-header">
        <div class="docly-header__content">
            <div class="docly-logo">
                <?php 
                    if ( $logo_id && $logo_meta ) {
                        echo sprintf(
                            '<img src="%s" alt="%s" width="%d" height="%d">',
                            esc_url( $logo_url ),
                            esc_attr( $logo_alt ),
                            esc_attr( $logo_width ),
                            esc_attr( $logo_height )
                        );
                    } 
                ?>
                <?php if( !$logo_id || !$logo_meta ) { ?>
                    <svg class="docly-logo__icon" width="576" height="384" viewBox="0 0 576 384" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 16V368H37.7L41.8 362.9L185.8 186.9L192.4 178.9L198.5 187.3L244.1 250.1L345.8 123L352 115.2L358.2 123L550.2 363L554.2 368H560V16H16ZM58.3 368H149.7L153.7 363L233.7 263L191.6 205.1L58.3 368ZM170.2 368H533.7L352 140.8L250.1 268.2L170.2 368ZM0 0H16H560H576V16V368V384H560H16H0V368V16V0ZM128 160C136.487 160 144.626 156.629 150.627 150.627C156.629 144.626 160 136.487 160 128C160 119.513 156.629 111.374 150.627 105.373C144.626 99.3714 136.487 96 128 96C119.513 96 111.374 99.3714 105.373 105.373C99.3714 111.374 96 119.513 96 128C96 136.487 99.3714 144.626 105.373 150.627C111.374 156.629 119.513 160 128 160ZM128 80C140.73 80 152.939 85.0571 161.941 94.0589C170.943 103.061 176 115.27 176 128C176 140.73 170.943 152.939 161.941 161.941C152.939 170.943 140.73 176 128 176C115.27 176 103.061 170.943 94.0589 161.941C85.0571 152.939 80 140.73 80 128C80 115.27 85.0571 103.061 94.0589 94.0589C103.061 85.0571 115.27 80 128 80Z" fill="#4F4F4F"/>
                    </svg>
                <?php } ?>
            </div>
            <button class="docly-search-button">
                <span>
                    Search docs...
                </span>
            </button>
            <?php if( $docly_github_button ) { ?>
                <div class="docly-buttons">
                    <?php if( $github_url ) { ?>
                    <a class="docly-button" href="<?php echo $github_url; ?>">
                        <svg class="docly-button__icon" width="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3 .3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5 .3-6.2 2.3zm44.2-1.7c-2.9 .7-4.9 2.6-4.6 4.9 .3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3 .7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3 .3 2.9 2.3 3.9 1.6 1 3.6 .7 4.3-.7 .7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3 .7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3 .7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z"/></svg>
                    </a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </header>