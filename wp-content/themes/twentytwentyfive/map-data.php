<?php

$localize_data = array(
    'ajax_url' => admin_url('admin-ajax.php'),
    'postTitle' => 'my post title',
  );

  header('Content-Type: application/json');

  echo json_encode($localize_data);