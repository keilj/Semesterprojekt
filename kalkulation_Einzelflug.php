<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Kalkulation EINZELFLUG</title>
</head>
<body>
		<?php
//BERECHNUNG ENTFERNUNG:
//Berechnung mit positiven Werten für NORD OST, für SÜD & WEST müssen negative Angaben in der Datenbank vorliegen!!
		//Äquatorradius, Annahme dass Erde eine Kugel ist. Keine 100 % Berechnung
		
		$rad = 6378.137;
		//start, ziel, breiten & längen --> sql datenbank flughäfen
			
		$start = "Frankfurt";
		$ziel = "Rio de Janero";
		$breit1 = 50.0333;
		$lang1 = 08.57055;
		$breit2 = -22.8089;
		$lang2 = -43.2436; 
		
		//Umrechnung der Gradzahl in RAD
		$rbreit1=($breit1/180)*pi();
		$rbreit2=($breit2/180)*pi();
		$rlang1=($lang1/180)*pi();
		$rlang2=($lang2/180)*pi();
		$diflan = ($rlang2-$rlang1);

		$sinbreit1 = sin($rbreit1);
		$sinbreit2 = sin($rbreit2);
		$cosbreit1 = cos ($rbreit1);
		$cosbreit2 = cos ($rbreit2);
		$cosdiflan = cos ($diflan);
		
		$nrsin = ($sinbreit1*$sinbreit2);
		$nrcos = ($cosbreit1*$cosbreit2*$cosdiflan);
		
		$acos = (acos($nrsin+$nrcos));
		
		$entf = round(($acos*$rad),3);
		
//BERECHNUNG FLUGZEIT:
		//Flugzeugdaten Daten Beispiel mit Cessna Citation CJ1
		$range = 2408; //Range aus Tabelle
		$anzzw = floor($entf/$range); //abrunden auf ganzstellige Zahl
//individuelle config zusätzliche Minuten pro Zwischenlandung
		$flitimeup = 45;
		
		$cruisesp = 720/60; //cruise speed aus Tabelle; kmh teilen durch 60 min, Entfernung pro minute
		$flitime_net = round(($entf/$cruisesp),2); //netto flugzeit ohne zwischenlandungen
		
		$flitime_brut = $flitime_net+($anzzw*$flitimeup);

//FLUGZEUGKOSTEN BERECHNEN:		
		//Berechnungsgrundlage fixkosten: Annual fixes cost bei 2000 h / jahr
		$planefixan = 218000; //jährliche fixkosten aus Tabelle
		$planevaran = 727; //stündliche variable Kosten aus Tabelle
		$planefixcostmin = round((($planefixan/2000)/60),2);
		$planevarcostmin = round(($planevaran/60),2);
		$planecost = round((($planefixcostmin+$planevarcostmin)*$flitime_brut),2);

// PERSONALKOSTEN BERECHNEN:

		
//AUSGABE BILDSCHIRM ZU TESTZWECKEN
		echo "von \n"; echo $start; echo "\n nach \n"; echo $ziel; 
		echo "<p>Die Entfernung beträgt km \n"; echo $entf;
		echo "<br />\n";
		echo "Die Netto Flugzeit beträgt \n"; echo $flitime_net; echo "\n Minuten";
		echo "<br />\n";
		echo "Anzahl Zwischenlandungen: \n"; echo $anzzw;
		echo "<br />\n"; 
		echo "Die Brutto Flugzeit inkl. Zwischenlandungen beträgt \n"; echo $flitime_brut; echo "\n Minuten";
		echo "<br />\n";
		echo "<p>Flugkostenberechnung:</p>";
		echo "fixe Flugzeugkosten je Minute € \n"; echo $planefixcostmin;
		echo "<br />\n";
		echo "variable Flugzeugkosten je Minute € \n"; echo $planevarcostmin;
		echo "<br />\n";
		echo "Flugzeugkosten für Brutto Flugzeit fix und variabel € \n"; echo $planecost;
		echo "<br />\n";
		echo "<p>Die Personalkosten betragen € \n"; echo "123456</p>";
		echo "<p> GESAMTKOSTEN € \n"; echo "gesamtkosten</p>";		
		?>
</body>
</html>