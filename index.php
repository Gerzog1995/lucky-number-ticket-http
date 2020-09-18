<?php

require_once 'vendor/autoload.php';

use Core\LuckyNumber;

$modelLuckyNumber = new LuckyNumber();
$listLuckyNumbers = $modelLuckyNumber->gettingLuckyNumber($_GET);
?>
<h3>Количество счастливых билетов: <?= $modelLuckyNumber->getCountLuckyTicket($listLuckyNumbers) ?></h3>

<pre>
<?php print_r($listLuckyNumbers); ?>
</pre>