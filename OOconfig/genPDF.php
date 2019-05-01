<?php
require '../php/FPDF/fpdf.php';
class PDF extends FPDF
{
// Page header
    function Header()
    {
        //UMSL Logo in the corner
        $this->Image('umsl_type_red_152r_30g_50b.jpg',10,10,30);
        // Arial bold 24
        $this->SetFont('Arial','B',24);
        // Centers header
        $this->Cell(80);
        // Title text
        $this->Cell(30,10,'UMSL Enrichment Transcript',0,0,'C');
        // Line break to start non-header
        $this->Ln(20 );
    }
}
//$SSOID = $_POST["student"];
////Array of student data passed by SSOID key
//$passedArray=array(
//    array('Name', 'Degree', 'Date', 'Title', 'Desc', 'Cat', '4'),
//    array('Name', 'Degree', 'Date', 'Title', 'Desc', 'Cat', '4'),
//    array('Name', 'Degree', 'Date', 'Title', 'Desc', 'Cat', '4'));
//$DASize = count($passedArray);
////creates printable array filled with empty strings, filled in later loop
//$printingArray=array_fill(0, $DASize-1, array_fill(0, 4, ""));
//$stdName= $passedArray[0][0];
//$stdDegree = $passedArray[0][1];
////Array-filling loop
////Might be unnecesary, depending on how the initial array works
////This is just asserting control over the data
//for($i=0; $i< $DASize;$i++){
//    //Event Date
//    $printingArray[$i][0] = $passedArray[$i][2];
//    //Event Title
//    $printingArray[$i][1] = $passedArray[$i][3];
//    //Event Description
//    $printingArray[$i][2] = $passedArray[$i][4];
//    //Event Category
//    $printingArray[$i][3] = $passedArray[$i][5];
//    //Hours spent on event
//    $printingArray[$i][4] = $passedArray[$i][6];
//}
//
//$pdf = new PDF();
//$pdf->AddPage();
//$pdf->SetFont('Courier','',12);
//$pdf->Cell(0,10, 'Name: ' . $stdName,0,1);
//$pdf->Cell(0,10, 'Degree: ' . $stdDegree,0,1);
////Loop prints every entry in the array
////Text is tentatively set to wrap
////If it doesn't work, FPDF's documentation will help
//for($i=0; $i< $DASize; $i++)
//    $pdf->MultiCell(0,10, $printingArray[$i][0] .' | ' .$printingArray[$i][1] .' | ' .$printingArray[$i][2] .' | ' .$printingArray[$i][3] .' | ' .$printingArray[$i][4],0,1);
//$pdf->Output();
//?>