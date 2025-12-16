<div class="eb-records-requests-post-content">

        <!-- Post Title -->
        <h1 class="post-title"><?php the_title(); ?></h1> <!-- Display Post Title -->

        <!-- Post Meta (Date and Author) -->
        <div class="post-meta">
            <p><strong>Posted on:</strong> <?php the_date(); ?></p> <!-- Display Post Date -->
            <p><strong>By:</strong> <?php the_author(); ?></p> <!-- Display Author -->
        </div>

        <!-- Post Content -->
        <div class="post-content">
            <?php the_content(); ?> <!-- Display Post Content -->
        </div>
</div>


