<?php
$host = '160.153.133.196';
$user = 'webservice_user';
$pass = 'Eco12345';
$data = 'webservice_db';

try {
  $pdo = new PDO('mysql:host='.$host.';dbname='.$data.';charset=utf8', $user, $pass);
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage();
}
?>

<html>
<head>
<title>...</title>
<style type="text/css">
  body{
    padding-left: 40px;
    margin-top: 60px;

    font-size: 40px;
  }


table {
margin: 8px;
}

td,th {
border: 1px solid #ddd;
padding: 8px;
}
tr{
  font-size: 20px;
}

tr:nth-child(even){background-color: #f2f2f2;}
tr:hover {
background-color: #357C3C;
color:#fff;
}
th {
padding-top: 12px;
padding-bottom: 12px;
text-align: left;
background-color: #2c3e50;
color: white;
}



</style>
</head>
<body style="background-color: #C5D8A4;">




<table style="margin-left:auto; 
margin-right:auto; ">
  <tr style="background-color: #357C3C">
      
      <td >Marka</td>
      <td>Ürün Bilgisi</td>
      <td>İndirimli Fiyat</td>
      <td>Fiyat(TL)</td>

</tr>

<?php
function ara($bas, $son, $yazi)
    {
      @preg_match_all('/' . preg_quote($bas, '/') .
      '(.*?)'. preg_quote($son, '/').'/i', $yazi, $m);
      return @$m[1];
    }

$site=file_get_contents("https://www.morhipo.com/kadin-dis-giyim");
$category = ara('<h1 id="productListVisibleName">','</h1>',$site);
$brand= ara('<span class="brand">','</span>',$site);
$type = ara('<span class="type">','</span>',$site);
$discounted_price = ara('<span class="text-danger">','</span>',$site);
$price = ara('<span class="act_price text-muted ">','</span>',$site);








echo "<div><tr  >".$category[0]."</tr></div>";

$adet = count($price);
$category=$category[0];
for ($i=0; $i <$adet ; $i++) { 


echo "<tr>";
echo "<td>".$brand[$i]."</td>";
echo "<td>".$type[$i]."</td>";
echo "<td>".$discounted_price[$i]."</td>";
echo "<td>".$price[$i]."</td>";

$brand=$brand[$i];
$type=$type[$i];
$discounted_price=$discounted_price[$i];
$price=$price[$i];
/*
SELECT*  FROM tbl_Morhibo WHERE brand="Fabrika" GROUP BY brand ORDER BY discounted_price LIMIT 5
SELECT Max(discounted_price) AS Pahali,brand,type FROM tbl_Morhibo
*/


$stmt = $pdo->prepare("INSERT INTO `tbl_morhibo`(`category`,`brand`,`type`,`discounted_price`,`price`) VALUES ('$category','$brand','$type',`discounted_price`,`price`)");
      $sonuc_2 = $stmt-> execute();

}

?>
</table>
</body>
</html>