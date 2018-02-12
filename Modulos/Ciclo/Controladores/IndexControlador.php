<?php

require_once BASE_PATH . 'LibQ' . DS . 'ValidarFormulario.php';
require_once MODS_PATH . 'Ciclo' . DS . 'Modelos' . DS . 'IndexModelo.php';
//require_once MODS_PATH . 'Personal' . DS . 'Modelos' . DS . 'IndexModelo.php';
require_once 'BarraHerramientasCiclo.php';
require_once 'BotonesCiclo.php';
require_once LIB_PATH . 'Esc_pdf.php';

/**
 * Clase Ciclo Controlador 
 */
class Ciclo_Controladores_IndexControlador extends App_Controlador {

    protected $_ciclo;
    protected $_bt;
    protected $_bh;

    /**
     * Constructor de la clase Index
     * Inicializa los modelos 
     */
    public function __construct() {
        parent::__construct();
        $this->_ciclo = new Ciclo_Modelos_indexModelo();
        $this->_bh = new BarraHerramientasCiclo();
    }

    /**
     * Método por defecto del módulo Alumno
     * Muestra una lista con los ciclos
     */
    public function index() {
        $this->isAutenticado();
        if (!$this->_ciclo->comprobarTabla('ciclos')) {
            $this->_vista->setBodyOnLoad('crearTabla()');
        }else{
            $datos = $this->_ciclo->getCiclos();
            $this->_vista->datos = $datos;
        }
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasIndex();        
        $this->_vista->titulo = TITULO_CICLOS;
        $this->_vista->setVistaCss(
                array('dataTables.bootstrap.min', 'select.dataTables.min'));
        $this->_vista->setVistaJs(
                array(
                    'dataTables.bootstrap.min',
                    'dataTables.select.min',
                    'lista_ciclos'
                )
        );        
        $this->_vista->renderizar('index', 'ciclo');
    }

    public function nuevo() {
        $this->isAutenticado();
        $this->_acl->acceso('nuevo_ciclo');
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasNuevo();
        $this->_vista->titulo = TITULO_NUEVO_CICLOS;
        $this->_vista->setVistaJs(
                array(
                    'jquery.validate.min', 'validarNuevo',
                    'util', 'lista_ciclos'));
        $this->_vista->datos = INPUT_POST;
        if ($this->getIntPost('guardar') == 1) {
            $this->_guardar();
        }
        $this->_vista->renderizar('nuevo', 'Ciclo');
    }

    public function editar($id) {
        $this->isAutenticado();
        $this->_acl->acceso('editar_ciclo');
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasEditar($id);
        $idPac = $this->_controlId($id);
        $this->_vista->titulo = TITULO_EDITAR_CICLO;
        /** Cargo los archivos js */
        $this->_vista->setJs(array('tinymce/jscripts/tiny_mce/tiny_mce'));
        $this->_vista->setVistaJs(
                array(
                    'jquery.validate.min', 'validarNuevo',
                    'util', 'lista_ciclos'));
        /** Si el Post viene con editar = 1 */
        if ($this->getIntPost('editar') == 1) {
            $this->_guardar();
        }
        /** Si no es para guardar lleno el form con datos de la bd */
        $ciclo = $this->_ciclo->getCiclo("id = " . $idPac);
        /** Envío los datos a la vista */
        $this->_vista->datos = $ciclo;
        $this->_vista->renderizar('editar', 'Ciclo');
    }

    private function _controlId($id) {
        /** Si no viene id en el POST envío al Index */
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('option=Ciclo');
        }
        /** Si no encuentro el ciclo envío al Index */
        $idCiclo = $this->filtrarInt($id);
        if (!$this->_ciclo->existeCiclo("id = " . $idCiclo)) {
            $this->redireccionar('option=Ciclo');
        }
        return $idCiclo;
    }

    private function _guardar() {
        $rtdo = '';
        $datos = $this->_limpiarDatos();
        $errores = $this->_validarPost($datos);
        $aGuardarCiclo = $this->_prepararDatosCiclo($datos);
        if ($errores->getRetEval()) {
            $this->_vista->_msj_error = $errores->getErrString();
        } else {
            if (isset($datos['editar'])) {
                $rtdo = $this->_ciclo->editarCiclo($aGuardarCiclo, 'id=' . $aGuardarCiclo['id']);
            } else {
                unset($aGuardarCiclo['id']);
                $rtdo = $this->_ciclo->insertarCiclo($aGuardarCiclo);
            }
            if ($rtdo) {
                $this->_vista->_mensaje = 'DATOS_GUARDADOS';
            } else {
                $this->_vista->_mensaje = 'DATOS_NO_GUARDADOS';
            }
        }
        return $rtdo;
    }

    /**
     * Limpia los datos que vienen del Post
     * @return array $datos
     */
    private function _limpiarDatos() {
        $datos['guardar'] = filter_input(INPUT_POST, 'guardar', FILTER_SANITIZE_NUMBER_INT);
        $datos['editar'] = filter_input(INPUT_POST, 'editar', FILTER_SANITIZE_NUMBER_INT);
        $datos['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $datos['ciclo'] = filter_input(INPUT_POST, 'ciclo', FILTER_SANITIZE_STRING);
        $datos['observaciones'] = filter_input(INPUT_POST, 'observaciones', FILTER_SANITIZE_STRING);
        return $datos;
    }

    /**
     * Validar los datos del POST
     * @param array $datos
     * @return \ValidarFormulario
     */
    private function _validarPost($datos) {
        $validar = new LibQ_ValidarFormulario();
        $validar->ValidField($datos['ciclo'], 'int', 'El Ciclo no es válido');
        return $validar;
    }

    private function _prepararDatosCiclo($datos) {
        $datosCiclo = array(
            'id' => $datos['id'],
            'ciclo' => $datos['ciclo'],
            'observaciones' => $datos['observaciones'],
        );
        return $datosCiclo;
    }

    /**
     * Elimina los datos de un alumno
     * @param int $id 
     */
    public function eliminar() {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        if (is_null($id)) {
            echo 'es null' . $id;
        }

        if (!$id) {
            echo 'es falso' . $id;
        }
        echo $this->_ciclo->eliminarCiclo('id = ' . $id);
    }

    public static function getCicloActual() {
        return $this->_ciclo->getCicloActual();
    }

    public function crearTabla() {
        $sql = "CREATE TABLE escuela_ciclos (
            id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            ciclo int(11) NOT NULL,
            actual tinyint(1) NOT NULL DEFAULT '0',
            observaciones varchar(255) 
            COLLATE utf8_spanish_ci NOT NULL);";
        $r = $this->_ciclo->crearTabla($sql);
        return $r;
    }
    
    public function setCicloActual(){
        $idCiclo = $this->getIntPost('idCiclo');
        $actual = $this->_ciclo->getCicloActual();
        if($idCiclo <> $actual->getId()){
            $q = $this->_ciclo->editarCiclo(array('actual'=>0), 'id='.$actual->getId());
            $s = $this->_ciclo->editarCiclo(array('actual'=>1), 'id='.$idCiclo);
        }
        echo $q . $s;
    }
    
    public function imprimirLista() {
        $pdf = new Lib_Esc_pdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Lista Gral. de Ciclos',0,1,'C');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(20);
        $pdf->Cell(12, 10, 'Nro',0,0);
        $pdf->Cell(90, 10, 'Ciclo',0,0);
        $pdf->Cell(0, 10, 'Observaciones',0,1);
        $pdf->SetFont('Arial', '', 12);        
        $datos = $this->_ciclo->getCiclos();
        $i = 1;
        foreach ($datos as $ciclo) {
            $pdf->Cell(20);
            $pdf->Cell(12, 10, $i,0,0);
            $pdf->Cell(90, 10, utf8_decode($ciclo->getCiclo()),0,0);
            $pdf->Cell(0, 10, utf8_decode($ciclo->getObservaciones()),0,1);
            $i++;
        }        
        $pdf->Output();
    }

}
