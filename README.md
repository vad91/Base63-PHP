<h2>Base63-PHP</h2>
<p>Simple PHP class that helps encode and decode value.</p>
<blockquote>
It requires to use Math_BigInteger class, you can find it here https://pear.php.net/package/Math_BigInteger/
</blockquote>
<pre>
require_once 'BigInteger.php';
require_once 'Base63.php';

$val = 'FrSmp07irynw';

$int = Base63::decode($val);
$big_int = new Math_Biginteger($int, 10);
$hex_val = $big_int->toHex();

$res = Base63::encode($hex_val, 16);
echo $res; // $res is equal to 'FrSmp07irynw'
</pre>
