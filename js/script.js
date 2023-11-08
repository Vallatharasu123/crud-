$(".hamburger").click(function() {
    // Toggle classes for sidebar, sidebar ul, and main-area
    $(".sidebar").toggleClass("open close");
    $(".sidebar ul").toggleClass("open close");
    
    $(".main-area").toggleClass("open close");

    // Check if the sidebar is in the "close" state
    if ($(".sidebar ul").hasClass("close")) {
        // Add tooltips to the li elements
        $(".sidebar ul li").each(function() {
            var menuText = $(this).find("span.menu-text").text();
            $(this).attr('data-bs-toggle', 'tooltip');
            $(this).attr('data-bs-placement', 'right');
            $(this).attr('data-bs-original-title', menuText);
        });
        
        // Initialize the tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
    } else {
        // alert("ok");
        $(".sidebar ul li").each(function() {
            // alert("ok");
            $(this).removeAttr('data-bs-toggle');
            $(this).removeAttr('data-bs-placement');
            $(this).removeAttr('data-bs-original-title');
        });
    }
});
  $(document).ready(function() {
     // Initialize the tooltips
 $('[data-bs-toggle="tooltip"]').tooltip();
  });

