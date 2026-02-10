/**
 * Admin JavaScript for CoffeeShop Theme
 * Reorder meta boxes in the admin
 */

document.addEventListener('DOMContentLoaded', function() {
    // Move Menu Item Image box to top of sidebar
    var sidebarArea = document.getElementById('side-sortables');
    if (!sidebarArea) return;

    var imageBox = document.getElementById('postimagediv');
    if (!imageBox) return;

    // Move the image box to be the first child of side-sortables
    sidebarArea.insertBefore(imageBox, sidebarArea.firstChild);
});
