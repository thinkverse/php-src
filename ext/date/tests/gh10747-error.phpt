--TEST--
Bug GH-10747 (Private fields in serialized DateTimeImmutable objects throw)
--XFAIL--
--FILE--
<?php
class I extends DateTimeImmutable
{
	private   int $var1 = 1;
	private       $var2 = 0;
	protected int $var3 = 3;
	protected     $var4;

	function __construct()
	{
		parent::__construct();
		$this->var2 = 2;
		$this->var4 = 4;
	}
}

$s = 'O:1:"I":7:{s:4:"date";s:26:"2023-03-09 17:03:11.123456";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";s:7:" I var1";i:1;s:7:" I var2";i:2;s:7:" * var3";i:3;s:7:" * var4";i:4;}';
$u = unserialize($s);
var_dump($s, $u);

$s = 'O:1:"I":7:{s:4:"date";s:26:"2023-03-09 17:03:11.123456";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";s:7:" J var1";i:1;s:7:" K var2";i:2;s:7:" * var3";i:3;s:7:" * var4";i:4;}';
$u = unserialize($s);
var_dump($s, $u);

?>
--EXPECTF--
object(I)#%d (7) {
  ["var1":"I":private]=>
  int(1)
  ["var2":"I":private]=>
  int(2)
  ["var3":protected]=>
  int(3)
  ["var4":protected]=>
  int(4)
  ["date"]=>
  string(%d) "%s"
  ["timezone_type"]=>
  int(3)
  ["timezone"]=>
  string(3) "UTC"
}
