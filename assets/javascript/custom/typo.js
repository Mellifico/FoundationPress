window.fitText(document.getElementById("fattext"),0.8, { minFontSize: "20px"});
window.fitText(document.getElementById("fattext-bis"),0.8, { minFontSize: "20px"});

// Magellan instances
var $items = new Foundation.Magellan(element, options);
$items.imagesLoaded().progress( function() {
  // Sticky functions
$('#items .sticky').foundation('_calc', true);
});