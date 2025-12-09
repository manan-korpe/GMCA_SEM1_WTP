<?php
echo '<div class="toast-container" id="toastContainer"></div>';
echo '<script src="../js/toast.js"></script>';

if (!empty($_SESSION["toastMessage"]) && !empty($_SESSION["toastType"])) {
    echo '<script>';
    echo 'showToast("' . $_SESSION['toastType'] . '", "' . $_SESSION['toastMessage'] . '");';
    echo '</script>';

    unset($_SESSION["toastMessage"]);
    unset($_SESSION["toastType"]);
}
?>
