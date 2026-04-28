<?php
if (! defined('ABSPATH')) {
    die('Direct access forbidden.');
}
?>

<div class="submission-received-section">
    <h3>
        Submission successful!
    </h3>
<p>Thank you for contributing to this project. Your submission will now be reviewed by an administrator and published pending prior approval.</p>
    <div>
        <p>
            You can now return <a class="submission-received-link" href=<?php echo home_url(); ?>>home</a> or
            <a class="submission-received-link" href=<?php echo home_url() . '/submit-resource'; ?>>submit another resource</a>. 
        </p>
    </div>
</div>
</main>