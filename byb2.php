<?php 
/**
 * file: byb2.php
 * purpose: Create a BibTex file.
*/

header("Content-type: text/html; charset=iso-8859-1"); // danish etc. charset ?>

<h1>Libri Modue: Create New BibTex File</h1>

<?php 
/* Create the BibTex file */
$filename = "libri_".date('YmdHi').".bib";
$intro = "comment{This BibTex File Created by Per Thykjaer Jensen's Libri Module}\n\n";
$file = fopen($filename, "w") or die("Could not create the file!"); // open the file

print "<p>Download: <a href='".$filename."'>".$filename."</a></p>";

fwrite($file,$intro) or die("Could not write" . $intro . "to the file");

/* MySQL */
include_once "db.php"; // database connection ($mysqli)
$sql = "SELECT * FROM `libri` order by `Author`";

$result = $mysqli->query($sql);

while($row = $result->fetch_assoc()){
    
    $author = strtoupper( substr(stripslashes($row['Author']), 0,3)); // remove , and - from the slug.
    $author = mb_ereg_replace("-","X", $author);
    $author = mb_ereg_replace(",","Y", $author);
    
    $books[] = "\n@". stripslashes($row['Type']) ."{" . $author . "_" . $row['Year']
     . ",\n Author={" . stripslashes($row['Author']) . "},\n"
     . "Title={" . stripslashes($row['Title']) . "},\n"
     . "Publisher={" . stripslashes($row['Where']) . "},\n"
     . "Year=" . stripslashes($row['Year']) . "}\n";
   }

/* write all to the file */
foreach($books as $book){
    fwrite($file,$book) or die("Could not write to the file<br>");
    //file_put_contents($filename, $book, FILE_APPEND | LOCK_EX) or die("Shit Microsoft error " . rand(245452,474744777));
    echo "$book \n\n";
}

/* tidy up */
fclose($file); // that's it
?>