<!-- Custom search form for resources library search page -->
<form role="search" method="get" class="search-form" action="<?php echo home_url('/resources/'); ?>">

    <input type="search" class="search-field form-control buscador" 
        aria-label="search"
        placeholder="key terms"
        id="buscar" 
        value="<?php echo get_search_query() ?>" 
        name="s" title="<?php echo esc_attr_x('Search for:', 'label') ?>" />
    <input type="hidden" value="inforepo_resource" name="post_type" id="post_type" />

</form>
