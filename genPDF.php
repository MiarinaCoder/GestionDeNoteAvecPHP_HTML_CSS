<?php
//connexion a la base de donnees
include_once "connexion.php";

$matricule=mysqli_real_escape_string($conn,$_GET['matricule']);

//selection de tous les etudiants  

$query_sou=mysqli_query($conn,"SELECT * FROM soutenir WHERE matricule='$matricule'");
$query_et=mysqli_query($conn,"SELECT * FROM etudiant WHERE matricule='$matricule'");

$row_sou=mysqli_fetch_assoc($query_sou);
$row_et=mysqli_fetch_assoc($query_et);


$dt=$row_sou['date_soute'];
$rapporteur_int=$row_sou['rapporteur_int'];
$rapporteur_ext=$row_sou['rapporteur_ext'];
$examinateur=$row_sou['examinateur'];
$president=$row_sou['president'];
$Nom=$row_et['Nom_et'];
$Prenoms=$row_et['Prenoms_et'];

$query_p=mysqli_query($conn,"SELECT * FROM professeur WHERE (CONCAT(Nom_prof,' ',Prenoms_prof))='$president'");
$row_p=mysqli_fetch_assoc($query_p);
$grade_p=$row_p['Grade'];
$civilite_p=$row_p['Civilite'];

$query_ex=mysqli_query($conn,"SELECT * FROM professeur WHERE (CONCAT(Nom_prof,' ',Prenoms_prof))='$examinateur'");
$row_ex=mysqli_fetch_assoc($query_ex);
$grade_ex=$row_ex['Grade'];
$civilite_ex=$row_ex['Civilite'];

$query_rap=mysqli_query($conn,"SELECT * FROM professeur WHERE (CONCAT(Nom_prof,' ',Prenoms_prof))='$rapporteur_int'");
$row_rap=mysqli_fetch_assoc($query_rap);
$grade_rap=$row_rap['Grade']; 
$civilite_rap=$row_rap['Civilite'];

//condition pour le niveau
$niveau=$row_et['niveau'];
if($niveau=="L1"){
    $ni="PROJET DE FIN D'ANNEE POUR PASSAGE EN DEUXIEME ANNEE DE LA FORMATION  EN LICENCE";
    $nu="fin d'annee pour passage en deuxieme annee de Formation en License professionnelle";
}
elseif($niveau=="L2"){
    $ni="RAPPORT DE STAGE POUR LE PASSAGE EN TROISIEME ANNEE DE LA FORMATION  EN LICENCE";
    $nu=" passage en troisieme annee de la formation annee de la formation en Licence professionnelle";
}
elseif($niveau=="L3"){
   $ni="SOUTENANCE DE FIN D' ETUDES POUR L 'OBTENTION DU DIPLOME DE LICENCE ";
   $nu="fin d 'études pour l' obtention du diplôme de Licence professionnelle"; 
}
elseif($niveau=="M1"){
    $ni="PROJET DE FIN D'ANNEE POUR PASSAGE EN DEUXIEME ANNEE DE LA FORMATION  EN MASTER";
    $nu="fin d'annee pour passage en deuxieme annee de Formation  en Master professionnelle";
}
else{
    $ni="SOUTENANCE DE FIN D' ETUDES POUR L'OBTENTION DU DIPLOME DE MASTER";
    $nu="fin d ' études pour l' obtention du diplôme de Master professionnelle";
}

//condition pour le parcours
$parcours=$row_et['parcours'];
if($parcours=="GB"){
    $p='Genie Logiciel et Base de donnees';
}
elseif($parcours=="SR"){
    $p='Administration Systeme et Reseau';
}
else{
    $p='Informatique Generale';
}

//condition pour l'affichage des notes en ecritures
$note=$row_sou['note'];
switch($note)
{
case 0: $n='zero sur vingt';break;
case 1: $n='un sur vingt';break;
case 2: $n='deux sur vingt';break;
case 3: $n='trois sur vingt';break;
case 4: $n='quatre sur vingt';break;
case 5: $n='cinq sur vingt';break;
case 6: $n='six sur vingt';break;
case 7: $n='sept sur vingt';break;
case 8: $n='huit sur vingt';break;
case 9: $n='neuf sur vingt';break;
case 10: $n='dix sur vingt';break;
case 11: $n='onze sur vingt';break;
case 12: $n='douze sur vingt';break;
case 13: $n='treize sur vingt';break;
case 14: $n='quatorze sur vingt';break;
case 15: $n='quinze sur vingt';break;
case 16: $n='seize sur vingt';break;
case 17: $n='dix-sept sur vingt';break;
case 18: $n='dix-huit sur vingt';break;
case 19: $n='dix-neuf sur vingt';break;
case 20: $n='vingt sur vingt';break;
}

$date_parts=explode('-',$dt);
$annee=$date_parts[0];
$mois=$date_parts[1];
$jour=$date_parts[2];

switch($mois)
{
    case 1: $mois__ecrit='Janvier';break;
    case 2: $mois__ecrit='Fevrier';break;
    case 3: $mois__ecrit='Mars';break;
    case 4: $mois__ecrit='Avril';break;
    case 5: $mois__ecrit='Mai';break;
    case 6: $mois__ecrit='Juin';break;
    case 7: $mois__ecrit='Juillet';break;
    case 8: $mois__ecrit='Aout';break;
    case 9: $mois__ecrit='Septembre';break;
    case 10: $mois__ecrit='Octobre';break;
    case 11: $mois__ecrit='Novembre';break;
    case 12: $mois__ecrit='Decembre';break;
}

//affichage de pdf
header('content-type: text/html; charset=utf-8' );
require('fpdf\fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->Cell(190,20,utf8_decode("PROCES VERBAL"),0,1,'C');
$pdf->Ln(1);
$pdf->Cell(190,10,utf8_decode($ni),0,1,'C');
$pdf->Cell(190,10,utf8_decode("PROFESSIONNELLE "),0,1,'C');
$pdf->Ln(1);

$pdf->SetFont('Times','B',12);
$pdf->Cell(95,10,utf8_decode(" Mention : "),0,0,'R');
$pdf->SetFont('Times','',12);
$pdf->Cell(95,10,utf8_decode("Informatique "),0,1,'L');
$pdf->Ln(1);
$pdf->SetFont('Times','B',12);
$pdf->Cell(70,10,utf8_decode("Parcours : "),0,0,'R');
$pdf->SetFont('Times','',12);
$pdf->Cell(120,10,utf8_decode("$p"),0,1,'L');
$pdf->Cell(190,10,utf8_decode("Mr/Mlle $Nom $Prenoms"),0,0);
$pdf->Write(13,utf8_decode("
a soutenu publiquement son mémoire de $nu  le $jour $mois__ecrit $annee
")); 
//$pdf->cell(190,10,"",0,0);
$pdf->SetFont('Times','',12);
$pdf->Cell(140,10,utf8_decode("
Après la délibération, la commission des membres du Jury a attribué la note de"),0,0,'L');
$pdf->SetFont('Times','B',12);
$pdf->Cell(10,10,utf8_decode("$note"),0,0,'L');
$pdf->SetFont('Times','',12);
$pdf->Cell(40,10,utf8_decode("/20 ($n)"),0,1,'L');
$pdf->Ln(1);
$pdf->SetFont('Times','U',12);
$pdf->Cell(190,10,utf8_decode("Membres du Jury"),0,1,'');
$pdf->SetFont('Times','B',12);
$pdf->Cell(30,10,utf8_decode("Président :"),0,0,'L');
$pdf->SetFont('Times','',12);
$pdf->Cell(160,10,utf8_decode("$civilite_p $president, $grade_p"),0,1,'L');
$pdf->SetFont('Times','B',12);
$pdf->Cell(30,10,utf8_decode("Examinateur :"),0,0,'L');
$pdf->SetFont('Times','',12);
$pdf->Cell(160,10,utf8_decode(" $civilite_ex $examinateur, $grade_ex"),0,1,'L');
$pdf->SetFont('Times','B',12);
$pdf->Cell(30,10,utf8_decode("Rapporteurs :"),0,0,'L');
$pdf->SetFont('Times','',12);
$pdf->Cell(160,10,utf8_decode(" $civilite_rap $rapporteur_int, $grade_rap"),0,1,'L');
$pdf->Cell(190,10,utf8_decode("$rapporteur_ext " ));

$pdf->Output('proces_verbal.pdf','D');
?>