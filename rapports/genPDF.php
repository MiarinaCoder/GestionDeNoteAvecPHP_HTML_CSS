<?php
//connexion a la base de donnees
include_once "../config/db.php";

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
$Nom=$row_et['nom_et'];
$Prenoms=$row_et['prenoms_et'];

$query_p=mysqli_query($conn,"SELECT * FROM professeur WHERE (CONCAT(nom_prof,' ',prenoms_prof))='$president'");
$row_p=mysqli_fetch_assoc($query_p);
$grade_p=$row_p['grade'];
$civilite_p=$row_p['civilite'];

$query_ex=mysqli_query($conn,"SELECT * FROM professeur WHERE (CONCAT(nom_prof,' ',prenoms_prof))='$examinateur'");
$row_ex=mysqli_fetch_assoc($query_ex);
$grade_ex=$row_ex['grade'];
$civilite_ex=$row_ex['civilite'];

$query_rap=mysqli_query($conn,"SELECT * FROM professeur WHERE (CONCAT(nom_prof,' ',prenoms_prof))='$rapporteur_int'");
$row_rap=mysqli_fetch_assoc($query_rap);
$grade_rap=$row_rap['grade']; 
$civilite_rap=$row_rap['civilite'];

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
require('../assets/vendor/fpdf/fpdf.php');

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetMargins(25, 20, 25);
$pdf->SetAutoPageBreak(true, 20);

// --- Titre ---
$pdf->Ln(10);
$pdf->SetFont('Times', 'BU', 16);
$pdf->Cell(0, 10, utf8_decode("PROCÈS-VERBAL"), 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Times', 'B', 12);
$pdf->MultiCell(0, 7, utf8_decode($ni . "\nPROFESSIONNELLE"), 0, 'C');
$pdf->Ln(10);

// --- Informations ---
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(30, 8, utf8_decode("Parcours : "), 0, 0);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0, 8, utf8_decode($p), 0, 1);
$pdf->Ln(5);

// --- Corps du texte ---
$pdf->SetFont('Times', '', 12);
$pdf->MultiCell(0, 7, utf8_decode("Mr/Mlle " . $Nom . " " . $Prenoms . " a soutenu publiquement son mémoire de " . $nu . " le " . $jour . " " . $mois__ecrit . " " . $annee . "."), 0, 'J');
$pdf->Ln(5);

$pdf->Write(7, utf8_decode("Après la délibération, la commission des membres du Jury a attribué la note de "));
$pdf->SetFont('Times', 'B', 12);
$pdf->Write(7, utf8_decode($note . "/20 (" . $n . ")"));
$pdf->SetFont('Times', '', 12);
$pdf->Ln(15);

// --- Jury ---
$pdf->SetFont('Times', 'BU', 12);
$pdf->Cell(0, 10, utf8_decode("Membres du Jury :"), 0, 1);

$left_col_width = 40;

// Fonction pour ajouter un membre du jury avec retour à la ligne si nécessaire
function addJuryMember($pdf, $label, $content, $label_width) {
    $pdf->SetFont('Times', 'B', 12);
    $current_y = $pdf->GetY();
    $pdf->Cell($label_width, 8, utf8_decode($label), 0, 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->MultiCell(0, 8, utf8_decode($content), 0, 'L');
    
    // Si le MultiCell n'a pas fait de saut de ligne, on s'assure de passer à la ligne suivante manuellement
    if ($pdf->GetY() == $current_y) {
        $pdf->Ln(8);
    }
}

addJuryMember($pdf, "Président :", $civilite_p . " " . $president . ", " . $grade_p, $left_col_width);
addJuryMember($pdf, "Examinateur :", $civilite_ex . " " . $examinateur . ", " . $grade_ex, $left_col_width);
addJuryMember($pdf, "Rapporteurs :", $civilite_rap . " " . $rapporteur_int . ", " . $grade_rap, $left_col_width);

if (!empty($rapporteur_ext)) {
    $pdf->SetX(25 + $left_col_width); // 25 est la marge gauche
    $pdf->MultiCell(0, 8, utf8_decode($rapporteur_ext), 0, 'L');
}
$pdf->Ln(20);


$pdf->Output('proces_verbal.pdf','D');
?>