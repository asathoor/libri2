<?php
/****
* Plugin Name: PETJ Libri
* Plugin URI: http://multimusen.dk/
* Description: Literature Review
* Version: 1.0
* Author: Per Thykjaer Jensen
* Author URI: http://www.multimusen.dk
* License: GPL3
****/

/* Add pages Libri to the Dashboard. */
function petj_libri_add_dashboard_widgets() {

	wp_add_dashboard_widget(
                 'petj_libri',         // Widget slug.
                 'Libri: Ny bog',        // Title.
                 'petj_libri_new' 	// Display function.
        );	
}

$add_widget = add_action( 'wp_dashboard_setup', 'petj_libri_add_dashboard_widgets' );


/* main function: form to add a book */
function petj_libri_new(){

	if(isset($_REQUEST['ok'])){

		/* sanitize input */
		$renset = $_REQUEST;

		/* insert */
		global $wpdb;

		$wpdb->show_errors();
		print_r($_REQUEST);

		/* sanitize input */
		$type = addslashes(strip_tags($_REQUEST['bogeller']));
		$forfatter = addslashes(strip_tags($_REQUEST['forfatter']));
		$titel  = addslashes(strip_tags($_REQUEST['titel']));
		$where = addslashes(strip_tags($_REQUEST['where'])); // trykkested
		$anno = addslashes(strip_tags($_REQUEST['anno']));
		$note = addslashes(strip_tags($_REQUEST['note']));
		$projekt = addslashes(strip_tags($_REQUEST['projekt']));
		$hvor = addslashes(strip_tags($_REQUEST['hvor'])); // fysisk eller url
		$month = addslashes(strip_tags($_REQUEST['month']));
		$day = addslashes(strip_tags($_REQUEST['day']));
		$issue = addslashes(strip_tags($_REQUEST['issue']));

		/* nulværdier */
		if($month == "") {
			$month = 0;
			}
			
		if($day == "") {
			$day = 0;
			}
			
		if($issue == "") {
			$issue = "0";
			}

/*
--- sql ---
INSERT INTO `database`.`libri` 
(`Id`, `Author`, `Title`, `Where`, `Year`, `Note`, 
`Projekt`, `Hvor`, `Month`, `Day`, `Issue`) 
VALUES (NULL, 'aaa', 'aaa', '0', '2012', 'aaa', 
'aaa', 'aaa', '0', '0', '12');
*/	
	
			
		/* insert a book */
		$wpdb->insert( 
			'libri', 
			array( 
				'Id' => NULL,
				'Author' => $forfatter,
				'Type' => $type, 
				'Title' => $titel,
				'Where' => $where,
				'Year' => $anno,
				'Note' => $note,
				'Projekt' => $projekt,
				'Hvor' => $hvor,
				'Month' => $month,
				'Day' => $day,
				'Issue' => $issue
			),  
			array('%s','%s','%s','%s','%s','%s','%s','%s','%s','%d','%d','%s' ) 
		);

?>
		<p>Tast ok, hvis du vil fortsætte med flere bøger.</p>

		<form action="#" method="get" enctype="application/x-www-form-urlencoded">
			<button name="ny" value="ny" type="submit">OK</button>
		</form>
		<?php

	}
	else {
	?>
	<form action="#" method="get" enctype="application/x-www-form-urlencoded">
		<p>Materialetype <input type="radio" name="bogeller" value="Book" required> Bog
		<input type="radio" name="bogeller" value="Book" required> Artikel
		<input type="radio" name="bogeller" value="Misc" required> Diverse</p>
		<input type="text" name="forfatter" required> Forfatter<br>
		<input type="text" name="titel" required> Titel<br>
		<input type="text" name="anno" required> Udgivelsesår<br>
		<input type="text" name="maaned"> ( evt. Måned )<br>
		<input type="text" name="dag"> ( evt. Dag )<br>
		<input type="text" name="issue"> ( evt. Ts. Nr. )<br>
		<input type="text" name="where" required> Hvor<br>
		<input type="text" name="hvor"> ( evt. URL / hylde )<br>
		<select name="projekt"> 
			<option value="FossCMS" label="FossCMS"> Open Source CMS</option>	
		</select> Projekt
		<p>
		<textarea name="note" rows="5" cols="35">Notat</textarea>
		</p>
		<button name="cncl" value="cncl" type="reset">Fortryd</button>	
		<button name="ok" value="ok" type="submit" class="btn btn-primary">OK</button>
	</form>

	<?php } // ends the else l. 28.
}
