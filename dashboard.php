<?php
require_once __DIR__ . '/includes/functions.php';
require_login();

switch (current_role()) {
    case 'admin':
        redirect('admin/dashboard.php');
        break;
    case 'staff':
        redirect('staff/dashboard.php');
        break;
    default:
        redirect('staff/inventory.php'); // viewers land on the read-only inventory view
}
