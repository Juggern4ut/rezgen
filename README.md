# rezgen
Generiert einen roten Einzalungsschein nach Vorlage der Schweiz

## Installation
Da die Klasse sehr simpel ist, geht auch die Installation schnell von statten.
1. Kopieren Sie den ganzen Inhalt des Ordners *rezgen* in Ihr Projekt.
2. Inkludieren Sie das File *rezgen.php* in Ihrem Projekt, wo Sie den Einzahlungsschein erstellen möchten.
3. (optional) Falls Sie den 'res'-Ordner an einen andern Ort in Ihrem Projekt verlegen möchten, müssen Sie im File *rezgen.php* die Variablen `$this->_imagePath` und `$this->_fontPath` entsprechend anpassen.

## Verwendung
Erstellen Sie ein neues Objekt mit `new rezgen()` und führen Sie die Funktionen `setRecipient`, `setPayer`, `setAccount`, `setAmount` und optional `setPaymentReason` aus.
Danach kann das Bild mit der Funktion `generate` erstellt werden.

```php
$rez = new rezgen();
$rez->setRecipient('Fabienne Müller', 'Teststrasse 23a', '5013 Niedergösgen', 'Müller GmbH');
$rez->setPayer('Markus Test', 'Beispielweg 8', '5012 Schönenwerd');
$rez->setAccount('25-9034-2');
$rez->setAmount(199.95);
$rez->setPaymentReason("Auftragsnummer 126342, hier ist der auf Ihrer Rechnung geforderte Betrag, wenn der Text noch viel viel länger wird, wird es erst richtig interessant");
$rez->generate();
```

### Ausgabe
Der generierte Einzahlungsschein sieht wie folgt aus:

<p align=center>
    <img style="border: 1px solid #000;" alt="Ein mit rezgen generierter roter Einzahlungsschein" src="https://i.imgur.com/fZIktRn.png">
</p>

### Hinweis
Die Klasse wird versuchen den Verwendungszweck (gesetzt in `setPaymentMethod`) wird versucht so gut wie möglich umgebrochen zu werden, aber zu lange Texte werden trotzdem zu Überlappugnen führen. 
