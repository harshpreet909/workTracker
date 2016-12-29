<?php


$file = "tracker.list";
$version = "0.0.1";

if ( isset ( $_POST["submit"] )  ) {

	if ( $_POST["submit"] == "Add" && ! empty ( $_POST["data"]) ) {

		$fp = fopen ( $file, "a+" ) or die ("Cannot open $file ");

		fwrite ( $fp, stripslashes($_POST["date"].":".$_POST["data"])."\n" );
		fclose ( $fp ) ;

	} elseif ( $_POST["submit"] == "Remove" ) {

		$data = file ( $file );
		$fp = fopen ( $file , "w+" ) or die ("Cannot open $file ");
		$n = 0;

		foreach ( $data as $line ) {
				
			if ( empty ( $_POST["line"][$n] ) ) {
				fwrite ( $fp, $line );
			}

			$n++;
				
		}

		fclose ( $fp );

	} elseif ( $_POST["submit"] == "Complete" ) { 

		$data = file ( $file );
		$fp = fopen ( $file , "w+" ) or die ("Cannot open $file for writing, check permissions");
		$n = 0;

		foreach ( $data as $line ) {

			if ( empty ( $_POST["line"][$n] ) ) {
				fwrite ( $fp, $line );
			} else {

				if ( !strstr ( $line , "<strike>") ) {
					fwrite ( $fp, "<strike>" . trim($line) . "</strike>\n" );
				} else {
					$line = str_replace ( "<strike>","",$line );
					$line = str_replace ( "</strike>","",$line );
					fwrite ( $fp, $line );

				}
			}

			$n++;
				
		}

		fclose ( $fp );

	}

	
}

/* HEADER BEGINS */

echo "<html>


<body>";

/* HEADER ENDS */

?>
<b>TASK LIST v<?php echo $version?></b><br />
<hr />
<form action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST" name="todo">
<input type="hidden" name="ohash" value="<?php echo $hash ?>" />
<pre>

<!-- display-->
<?php

if ( isset ( $_POST["check"] ) AND $_POST["date1"] != null ){
	$file_handle = fopen("tracker.list", "rb");
	$t = 0;
while (!feof($file_handle) ) {

     $line_of_text = fgets($file_handle);
     $line[$t] = $line_of_text[$t] ;
     $parts = explode(':', $line_of_text,2);
        if($parts[0] === $_POST["date1"]){
			echo "<input type='checkbox' name='line[$t]' />";
		if ( ! isset($parts[1])) {
				$parts[1] = null;
        }
		echo "<strong>"." ".$parts[0]."</strong>"."   ".$parts[1]."\n" ;
        }
		$t++;

}
		
	}
elseif ( isset ( $_POST["check"] ) AND $_POST["date1"] == null){
	$file_handle = fopen("tracker.list", "rb");
	$p = 0;
while (!feof($file_handle) ) {

     $line_of_text = fgets($file_handle);
     $line[$p] = $line_of_text[$p] ;
     $parts = explode(':', $line_of_text,2);
       
			echo "<input type='checkbox' name='line[$p]' />";
		if ( ! isset($parts[1])) {
				$parts[1] = null;
        }
		echo "<strong>"." ".$parts[0]."</strong>"."   ".$parts[1]."\n" ;
        
		$p++;

}
		
	}	
else{
$file_handle = fopen("tracker.list", "rb");
$n = 0;

while (!feof($file_handle) ) {

     $line_of_text = fgets($file_handle);
     $line[$n] = $line_of_text[$n] ;
     $parts = explode(':', $line_of_text,2);
	 date_default_timezone_set("Asia/Bangkok");
	 $now = new DateTime('now');
	 //$now = date('Y-m-d');
	$abc=$now->format('Y-m-d');
	//echo $abc;
	 

        if($parts[0] === $abc){
			echo "<input type='checkbox' name='line[$n]' />";
		if ( ! isset($parts[1])) {
				$parts[1] = null;
        }
		echo "<strong>"." ".$parts[0]."</strong>"."   ".$parts[1]."\n" ;
        }
		$n++;

}

}
fclose($file_handle);


?>

</pre>
<hr />

<p1>Add Record</p1>
<?php echo "<br>" ?>
<?php
	date_default_timezone_set("Asia/Bangkok");
	$now = new DateTime();
	$abc=$now->format('Y-m-d');
?>
<input type="text" name="data" size="35" />
<input type="date" name="date" size="10" value= <?php echo $abc ?>  />
<input type="submit" name="submit" value="Add" />
<input type="submit" name="submit" value="Remove" /> 

<?php echo "<br>" ?>

<p1>Check Record</p1>
<?php echo "<br>" ?>
<input type="date" name="date1" size="10" value= <?php echo $abc ?>  />
<input type="submit" name="check" value="check" />
</form>

<?php
echo "</body></html>";
?>