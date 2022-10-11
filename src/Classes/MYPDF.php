<?php


namespace App\Classes;


use TCPDF;

class MYPDF extends TCPDF
{
    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'logo-01.jpg';
        $this->Image($image_file, 15, 10, 36, '', 'JPG', '', 'T', false, 300, 'R', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
//        $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-40);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 30, 'Address: Hawally block 63b, building 5 office 12, kuwait', 0, 0, 'C', 0, '', 1, false, 'T', 'M');
        $this->SetY(-35);
        $this->Cell(0, 30, 'Email: info@foodshackkw.com', 0, 0, 'C', 0, '', 1, false, 'T', 'M');
        $this->SetY(-30);
        $this->Cell(0, 30, 'Tel: 90932663, 22286866', 0, 0, 'C', 0, '', 1, false, 'T', 'M');

    }
}