// init Isotope
var $grid = $('.grid-isotope-seals').isotope({
    itemSelector: '.seal',
    stamp: '.stamp'
});
// layout Isotope after each image loads
$grid.imagesLoaded().progress( function() {
  $grid.isotope('layout');
});