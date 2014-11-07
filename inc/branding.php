<?php 
//*************************
//*****CUSTOMIZE:**********
//*************************

$ch3_theme_page_menu_name = 'CH3'; // Name show in the menu
$ch3_theme_page_slug = 'ch3'; // URL of the page, it will appear "wp-admin/admin.php?page=SLUGOFYOURPAGE"
$ch3_theme_page_title = 'This is the <title> of the page';
$ch3_theme_page_favicon_path = '/img/panel-icon.ico'; // add the path of the favicon
$ch3_theme_page_position = 

//function that create the page
add_action('admin_menu', 'ch3_theme_admin_page');

//hook to register the admin page 
function ch3_theme_admin_page(){
    add_menu_page('Información de sitio ', 'CH3', 'administrator', 'ch3', 'ch3_admin_page', 'http://ch3.es/favicon.ico', '3.11');
//more info: http://codex.wordpress.org/Function_Reference/add_menu_page
}

//feel free to edit within this function
function ch3_admin_page(){
//from this line
?>

<h2>Hello World!</h2>
<h3>Thanks for using the CH3_WP utilities.</h3>
<p>Go to /inc/ch3/branding to customize this page.</p>


<?php //up to this line
}
?>