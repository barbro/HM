<?php
$server = "localhost";
$username = "root";
$password = "pifpaf";
$database_name = "HangedMan";

// 1 - database connection
$connection = mysql_connect($server, $username, $password);
if (!$connection) {
  die('cant connecto to the database' . mysql_error());
}
// Hebrew need this:  
mysql_query("SET NAMES 'utf8'");
// 2 Select the database to use
$db = mysql_select_db($database_name, $connection);
if (!$db) {
  die('database connction failed' . mysql_error());
}

// cach the get and print 
$result = "none";
if(isset($_POST["new_word"])){
var_dump($_POST); 
$sent_word=false;
$result = mysql_query(
            "INSERT INTO `HangedMan`.`words` ( `word`, `discription`, `status` )
             VALUES ('".$_POST['new_word']."', '".$_POST['discription']."', '0');"
            , $connection);
} 
if($result != "none"){
	$ad_word = $_POST['new_word'];
	$sent_word = true;
	unset($_POST);
} else {

	$sent_word = false;

}

?>

<html DIR="RTL">

	<head>
		<meta charset="utf-8">
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
		<title>6 נסיונות נשארו</title>
		<style>
		input {font-size:50px;}
		.ss {
		width: 800px;
		height: 400;
		margin: -200 -400;
		position:absolute;
		top: 50%;
		left: 50%;
		font-size:80px;
		}
		#win{background-color: #33FF33; z-index:2;}
		#fail{background-color: #FF0000; z-index:3;}
		</style>
	</head>

	<?php
    // 3 database query 
    $result = mysql_query(
            "SELECT * FROM words"
            , $connection);
    if (!$result) {
      die(' database query failed: ' . mysql_error());
    }
     
    // see what $result is with var_dump
    //  var_dump($result);
    
    // 4 -  get the resource and put it in to array

    $bar_words = array();

    while ($row = mysql_fetch_array($result , MYSQL_ASSOC)) {
      // echo $row["id"] . "<br>";
     // echo $row["word"] . "<br>";
      // echo $row["content"] . "<br>";
    	 array_push($bar_words, $row);
    }

    // var_dump($bar_words);
    ?>

	<body style="font-size:15px; font-family: Arial;">




		<br><table align="center" style="font-size:50px;"><tr style="font-size:50px;" id="table"></tr></table><br>
		
		<p align="center" style="font-size:50px;">אותיות משומשות: <a id="used"></a>

		</p>
		<br>

		<div id="VirtualKey" align="center">
    <input id="א" value="א" type="button" onclick="letter(this.id);" class="le"/>
    <input id="ב" value="ב" type="button" onclick="letter(this.id);" class="le"/>
    <input id="ג" value="ג" type="button" onclick="letter(this.id);" class="le"/>
	<input id="ד" value="ד" type="button" onclick="letter(this.id);" class="le"/>
    <input id="ה" value="ה" type="button" onclick="letter(this.id);" class="le"/>
    <input id="ו" value="ו" type="button" onclick="letter(this.id);" class="le"/>
	<input id="ז" value="ז" type="button" onclick="letter(this.id);" class="le"/>
    <br />                                                          
    <input id="ח" value="ח" type="button" onclick="letter(this.id);" class="le"/>
    <input id="ט" value="ט" type="button" onclick="letter(this.id);" class="le"/>
    <input id="י" value="י" type="button" onclick="letter(this.id);" class="le"/>
	<input id="כ" value="כ" type="button" onclick="letter(this.id);" class="le"/>
    <input id="ל" value="ל" type="button" onclick="letter(this.id);" class="le"/>
    <input id="מ" value="מ" type="button" onclick="letter(this.id);" class="le"/>
	<input id="נ" value="נ" type="button" onclick="letter(this.id);" class="le"/>
	<input id="ס" value="ס" type="button" onclick="letter(this.id);" class="le"/>
    <br />                                                           
    <input id="ע" value="ע" type="button" onclick="letter(this.id);" class="le"/>
    <input id="פ" value="פ" type="button" onclick="letter(this.id);" class="le"/>
    <input id="צ" value="צ" type="button" onclick="letter(this.id);" class="le"/>
	<input id="ק" value="ק" type="button" onclick="letter(this.id);" class="le"/>
    <input id="ר" value="ר" type="button" onclick="letter(this.id);" class="le"/>
    <input id="ש" value="ש" type="button" onclick="letter(this.id);" class="le"/>
	<input id="ת" value="ת" type="button" onclick="letter(this.id);" class="le"/>
</div>



<div align="center"><img src="6.jpg" id="photo" width="200" height="auto"></div>
<div id="win" class="ss" align="center">
<br>ניצחת!!<br>
	<input value="נסה שוב?" type="button" onClick="location.reload()" /> <br>
	<input value="שלח מילה למאגר המילים" type="button" id="poop" onClick="send()" />
</div>
<div id="fail" class="ss" align="center">
<form method="post" action="#" id="less">
			המילה: <input type="text" name="new_word" > <br>
			התיאור שלה: <input type="text" name="discription" > <br>
			<input type="submit" value="הוספה">

		</form><br><br>

	<input value="נסה שוב?" type="button" onClick="location.reload()" />
</div>
<div id="send" style="font-size:30;" class="ss" align="center">
<br>הפסדת, לא נורא...<br><br>

	<input value="נסה שוב?" type="button" onClick="location.reload()" />
</div>

			<?php 
				$string_of_words = "[";

				foreach ($bar_words as $key => $value) {

					if(is_array($value)){

						$valueq = array_reverse($value);
						//var_dump($valueq);
						//die;

						foreach ( $valueq as $k => $v) {
							if($k == 'status' ) { 
								if($v == '0') {
									
								break;

								}
							}
							if($k == 'word'){
								$string_of_words .= "'$v',";
							}
						}	
					}
				}

				$string_of_words = chop($string_of_words,",");



				$string_of_words .= "]";

				//var_dump($string_of_words);
				
				if($sent_word == true){
				
					echo "BBQ";
				
				}

			?>

		<script>

			var words = <?php echo $string_of_words ; ?>;
			var corr = 0; 
			var tries = 6 ;
			var x = document.getElementById("table");
			var used = [] ;
			var tmp_l = 0 ;
			
			var word = words[Math.floor(Math.random()*words.length)];
			
			var word_arr = word.split("");
			var word_arrs = word.split("");
			
			$(".ss").hide()
			
			function repit(f, l){
				tmp_l=0
				
				do {	
					
					word_arrs[word_arrs.indexOf(f)]=l;
					tmp_l=word_arrs.indexOf(f)
			
				}
				while(tmp_l != -1)
			}
			
			repit("ם", "מ")
			repit("ך", "כ")
			repit("ץ", "צ")
			repit("ף", "פ")
			
			function unique(list) {
				var result = [];
				$.each(list, function(i, e) {
					if ($.inArray(e, result) == -1) result.push(e);
				});
				if(result.indexOf(" ") != -1){
					result.splice(result.indexOf(" "), 1)
				}
				return result;
			}
			
			var word_uni=unique(word_arrs);
			
			function gameStart() {
				
				for(var i=0; i<word_arr.length; i++) {
				
					if(word_arr[i]==" ") {
					
						x.insertCell(-1).innerHTML="-";
					
					} else {
						
						x.insertCell(-1).innerHTML="_";
				
					}
					
				}
				
			}
			
			function letter(l) {
			
				document.getElementById(l).disabled=true
				used.push(l)
				document.getElementById("used").innerHTML = document.getElementById("used").innerHTML+l+", "
					
				if(word_uni.indexOf(l) != -1) {
				
					tmp_l=-1
					corr++
					
					if(corr == word_uni.length) {
					
						$("#win").show();
						$(".le").prop('disabled', true);
					
					}
			
					do {	
						
						x.cells[word_arrs.indexOf(l, tmp_l+1)].innerHTML=word_arr[word_arrs.indexOf(l, tmp_l+1)];
						tmp_l=word_arrs.indexOf(l, tmp_l+1)
				
					}
					while(tmp_l != -1)
					
				} else {
				
					tries--
					document.title = tries.toString()+" נסיונות נשארו"
					document.getElementById("photo").src = tries+'.jpg'
					
					if(tries == 0){
					
						$("#fail").show();
						$(".le").prop('disabled', true);
					
					}
				
				}
			
			}
			
			function send(){
			
$("#fail").show();
			
			}
			
			gameStart();
			
		</script>
	</body>
</html>

<?php




// 5 close connection
mysql_close($connection);
?>