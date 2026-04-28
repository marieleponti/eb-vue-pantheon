<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( 'Direct access forbidden.' );
}
?>

<main lang='en' class='library-outer-container'>

    <div class='container resource-list-container resources-archives-search-container'>

        <div class="card p-3 card-resource-list">
            <div class="card-body">
                <div id="primary">
                    <div class='container text-center grid-layout-content-list-right' id="content" role="main">
                        
                        <?php
                        get_template_part('template-parts/resource-search-results');
                        ?>
                    </div><!-- #content -->
                </div><!-- #primary -->

            </div>
        </div>

       

    </div> <!-- #grid-layout-container -->


</main>