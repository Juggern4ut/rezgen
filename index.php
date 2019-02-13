<?php
	include 'rezgen/rezgen.php';
	$rez = new rezgen();
	$rez->setRecipient('Fabienne Müller', 'Teststrasse 23a', '5013 Niedergösgen', 'Müller GmbH');
	$rez->setPayer('Markus Test', 'Beispielweg 8', '5012 Schönenwerd');
	$rez->setAccount('25-9034-2');
	$rez->setAmount(199.95);
	$rez->setPaymentReason("Auftragsnummer 126342, hier ist der auf Ihrer Rechnung geforderte Betrag, wenn der Text noch viel viel länger wird, wird es erst richtig interessant");
	$rez->generate();
?>