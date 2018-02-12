<?php
require('fpdf.php');

class Lib_Esc_pdf extends FPDF
{
    protected $_leyenda1 = 'Instituo Pequeno Hogar 104076';
    protected $_leyenda2 = 'Instituto De Educación Pública De Gestión Privada';
    protected $_leyenda3 = 'Asociación Civil Santa Josefina Bakhita (A2565)';
    protected $_pie1 = 'Calle 65 N.º 5545 -  3300 -  Posadas -  Misiones - Cel. (376)4140101';


// Cabecera de página
function Header()
{
    // Logo
    $this->Image(IMAGEN_PUBLICA . 'logoph2.png',20,8,30);
    // Arial bold 15
    $this->SetFont('Arial','B',14);
    // Movernos a la derecha
    $this->Cell(43);
    // Título ancho, alto, texto, borde, posición actual debería ir antes de invocar, alineacion, fondo, link
    $this->Cell(0,10, utf8_decode($this->_leyenda1),0,1);
    $this->SetFont('Arial','',11);
    $this->Cell(43);
    $this->Cell(0,5, utf8_decode($this->_leyenda2),0,1);
    $this->Cell(43);
    $this->Cell(0,5, utf8_decode($this->_leyenda3),0,1);
    $this->Cell(10);
    $this->Cell(0,5,'','T',1);
    // Salto de línea
    $this->Ln(10);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,utf8_decode($this->_pie1),'T',0,'C');
}

function imagen_con_borde($foto, $x, $y, $w, $h)
{
    $dim = getimagesize($foto);
    if($w==0){
        $ancho = $dim[0]/3.779528 + 4;
    }else{
        $ancho = $w + 4;
    }
    if ($h == 0){
        $prop = $dim[0]/$w;
        $alto = $dim[1]/$prop + 4;
    }else{
        $alto = $h + 4;
    }
    $this->SetDrawColor(200);
    $this->Rect(139, 58, $ancho, $alto, 'D');
    $this->SetDrawColor(0);
    $this->Image($foto,$x,$y,$w,$h);
}
}

