<?php

require_once LIB_PATH . 'Esc_pdf.php';

/**
 * Clase Imprimir Controlador 
 */
class Alumno_Controladores_ImprimirControlador extends App_Controlador {

    /**
     * Constructor de la clase Index
     * Inicializa los modelos 
     */
    public function __construct() {
        parent::__construct();
        $this->_alumno = new Alumno_Modelos_indexModelo();
        $this->_listaSexos = array('VARON', 'MUJER');
    }

    /**
     * Método por defecto del módulo Alumno
     * Muestra una lista con los alumnos
     */
    public function index() {
    }

    public function imprimirLista() {
        $pdf = new Lib_Esc_pdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Lista Gral. de Alumnos', 0, 1, 'C');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(20);
        $pdf->Cell(10, 10, 'Nro', 0, 0);
        $pdf->Cell(100, 10, 'Apellido y Nombre', 0, 0);
        $pdf->Cell(0, 10, 'DNI', 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $datos = $this->_alumno->getAlumnos();
        $i = 1;
        foreach ($datos as $alumno) {
            $pdf->Cell(20);
            $pdf->Cell(10, 10, $i, 0, 0);
            $pdf->Cell(100, 10, utf8_decode($alumno->getAyN()), 0, 0);
            $pdf->Cell(0, 10, $alumno->getNro_doc(), 0, 1);
            $i++;
        }

        $pdf->Output();
    }

    public function imprimirFicha() {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $alumno = $this->_alumno->getAlumno('id=' . $id);
        $pdf = new Lib_Esc_pdf();
        $pdf->AddPage();
        $fotos = LibQ_ArchivosYcarpetas::listarArchivos("Public/Img/Fotos/Alumno/" . $id);
        if (is_array($fotos) and count($fotos) > 0) {
            $foto = IMAGEN_PUBLICA . 'Fotos/Alumno/' . $id . '/' . $fotos[2];
        } else {
            $foto = IMAGEN_PUBLICA . 'Fotos/Alumno/Idsin_imagen.png';
        }
        $pdf->imagen_con_borde($foto, 141, 60, 56, 0);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Ficha Personal del Alumno', 1, 1, 'C');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20);
        $pdf->Cell(38, 10, 'Apellido:', 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 10, utf8_decode($alumno->getApellidos()), 0, 1);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20);
        $pdf->Cell(38, 10, 'Nombres:', 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 10, utf8_decode($alumno->getNombres()), 0, 1);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20);
        $pdf->Cell(38, 10, 'DNI:', 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 10, utf8_decode($alumno->getNro_doc()), 0, 1);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20);
        $pdf->Cell(30, 10, 'CUIL:', 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 10, utf8_decode($alumno->getCuil()), 0, 1);


        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20);
        $pdf->Cell(38, 10, 'Nacionalidad:', 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 10, utf8_decode($alumno->getNacionalidad()), 0, 1);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20);
        $pdf->Cell(38, 10, 'Sexo:', 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 10, utf8_decode($alumno->getSexo()), 0, 1);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20);
        $pdf->Cell(38, 10, 'Fecha Nacimiento:', 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 10, utf8_decode($alumno->getFecha_nac()), 0, 1);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20);
        $pdf->Cell(38, 10, 'Diagnostico:', 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 10, utf8_decode($alumno->getObjSalud()), 0, 1);

        $pdf->Output();
    }

}
