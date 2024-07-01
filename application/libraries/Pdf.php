<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . '/third_party/fpdf/fpdf.php');

class PDF extends FPDF
{
    protected $widths;
    protected $aligns;

    function SetWidths($w)
    {
        // Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        // Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data)
    {
        // Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 5 * $nb;
        // Issue a page break first if needed
        $this->CheckPageBreak($h);
        // Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Draw the border
            $this->Rect($x, $y, $w, $h);
            // Print the text
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            // Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        // Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        // If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        // Compute the number of lines a MultiCell of width w will take
        if (!isset($this->CurrentFont))
            $this->Error('No font has been set');
        $cw = $this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', (string)$txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

    // Page header
    function Header()
    {
        // Logo
        $this->Image('assets/img/kop.png', -1, 0, 211, 30);
        // Line break
        $this->Ln(30);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->Cell(0, 9, date('d M Y h:i:s'), 0, 0, 'R');
    }
}

// Database Connection 
$conn = new mysqli($_REQUEST['hostname'],  $_REQUEST['username'],  $_REQUEST['password'],  $_REQUEST['db']);
//Check for connection error
if ($conn->connect_error) {
    die("Error in DB connection: " . $conn->connect_errno . " : " . $conn->connect_error);
}

// Select data from MySQL database
$session = $_SESSION['idAkun'];
$user = $_SESSION['tipeAkun'];
if ($user !== "Admin") {
    $select = "SELECT * FROM `artikel` WHERE id_user = '$session' ORDER BY 'tgl_post' DESC";
} else {
    $select = "SELECT * FROM `artikel` ORDER BY 'tgl_post' DESC";
}
$result = $conn->query($select);
// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
//judul
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 7, 'DAFTAR ARTIKEL', 0, 1, 'C');
$pdf->Cell(10, 7, '', 0, 1);
//tabel
$pdf->SetLeftMargin(18);
$pdf->SetFont('Times', '', 12);
$pdf->SetWidths(array(10, 120, 40));
$pdf->Cell(10, 6, 'No', 1, 0, 'C');
$pdf->Cell(120, 6, 'Judul Artikel', 1, 0, 'C');
$pdf->Cell(40, 6, 'Status', 1, 1, 'C');
//isi tabel
if ($result->num_rows > 0) {
    $no = 0;
    while ($row = $result->fetch_assoc()) {
        $no++;
        $pdf->Row(array('   ' . $no, $row['judul'], $row['status']));
    }
} else {
    $pdf->Row(array('   -', 'Artikel tidak ditemukan', 'Tidak ditemukan'));
}
$pdf->Output();
