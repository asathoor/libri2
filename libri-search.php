<?php 
/*
* Plugin Name: PETJ Libri Search Module
* Plugin URI: http://multimusen.dk/
* Description: Find a book in the Libri table
* Version: 1.0
* Author: Per Thykjaer Jensen
* Author URI: http://www.multimusen.dk
* License: GPL3
****/

/* Add pages Libri to the Dashboard. */
function petj_libri_search_add_dashboard_widgets() {

	wp_add_dashboard_widget(
                 'petj_libri_search',         // Widget slug.
                 'Libri: Search',        // Title.
                 'petj_libri_search' 	// Display function.
        );	
}

$add_widget = add_action( 'wp_dashboard_setup', 'petj_libri_search_add_dashboard_widgets' );

/* function: form to add a book */

function petj_libri_search(){
	if(isset($_REQUEST['seeker'])) {
	
	
			/* seeker */
		$what = $_REQUEST['what'];
		$searchfor = $_REQUEST['searchfor'];
	
		$sql = "SELECT `Author`, ': \"' , `Title`, '\" (' , `Year` , ').'  FROM `libri` WHERE `".$what."` LIKE '%".$searchfor."%' ORDER BY `Author` ASC";
		
		
		global $wpdb;
		$wpdb->show_errors();


		$found = $wpdb->get_results($sql,OBJECT);		
		
		/* nested arrays */
		foreach($found as $row){
		    echo "<div>";
		    
			foreach ($row as $ord){
			    echo $ord . " ";
			}
			
			echo  "</div>";
		}

	
		?>
		<div style="padding-top:1.2345em;">
		<form action="#" method="get" enctype="application/x-www-form-urlencoded">
			<button name="well" value="wellwell" type="submit">Try again?</button>
		</form>
		</div>
		<?php
	//print_r($_REQUEST);		
		
	}
 else {
?>
<!-- search form -->
<form action="#" method="get" enctype="application/x-www-form-urlencoded">
	<input type="radio" name="what" value="Author" required=""> Author
	<input type="radio" name="what" value="Title" required=""> Title<br>
	<input type="text" name="searchfor" required> Search for ...<br>	
	<button name="nope" value="nope" type="reset">Cancel</button>
	<button name="seeker" value="seeker" type="submit">Go!</button>
</form>

<?php

//var_dump($_REQUEST);

} // ends else clause
} // ends search function
