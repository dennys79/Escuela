<?php
require_once LIB_PATH . 'Esc_pdf.php';
require_once MODS_PATH . 'Administrator' . DS . 'Modelos' . DS . 'IndexModelo.php';
require_once 'BarraHerramientasAdministrator.php';

/**
 * Controlador de Administrator
 *
 * @author WERD
 */
class Administrator_Controladores_indexControlador extends App_Controlador
{

    protected $_bd;
    protected $_bh;

    public function __construct()
    {
        parent::__construct();
        $this->isAutenticado();
        $this->_bd = new Administrator_Modelos_indexModelo();
        $this->_bh = new BarraHerramientasAdministrator();
    }

    public function index()
    {
        $this->_vista->titulo = TITULO_LISTA_ADMINISTRADOR;
//        $this->_vista->lista = $this->_bd->getErrorAll();
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasIndex();
        $this->_vista->renderizar('index');
    }

    public function iva()
    {
        $this->_vista->setVistaCss(array('dataTables.bootstrap.min', 'select.dataTables.min'));
        $this->_vista->setVistaJs(array('dataTables.bootstrap.min', 'dataTables.select.min', 'lista_iva'));
        $this->_vista->titulo = TITULO_LISTA_IVA;
        $this->_vista->listaIva = $this->_bd->getTipoContribuyentes();
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasIva();
        $this->_vista->renderizar('IndexIva');
    }

    public function editarIva()
    {
        $this->_vista->titulo = TITULO_EDITAR_IVA;
        $id = filter_input(INPUT_GET, 'id');
        $iva = $this->_bd->getTipoContribuyente('id=' . $id);
        $this->_vista->iva = $iva;
        if ($this->getIntPost('editar') == 1) {
            $contribuyente = $this->getTextoPost('contribuyente');
            $this->_editarIva($id, $contribuyente);
        }
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasIva();
        $this->_vista->renderizar('editar_iva');
    }

    public function nuevoIva()
    {
        $this->_vista->titulo = TITULO_NUEVO_IVA;
        if ($this->getIntPost('guardar') == 1) {
            $contribuyente = $this->getTextoPost('contribuyente');
            $this->_nuevoIva($contribuyente);
        }
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasIva();
        $this->_vista->renderizar('nuevo_iva');
    }

    private function _editarIva($id, $contribuyente)
    {
        return $this->_bd->editarIva($id, $contribuyente);
    }

    private function _nuevoIva($contribuyente)
    {
        return $this->_bd->nuevoIva($contribuyente);
    }

    /**
     * Elimina un tipo de contriuyente
     */
    public function eliminarIva()
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        if (is_null($id)) {
            echo 'es null' . $id;
        }

        if (!$id) {
            echo 'es falso' . $id;
        }
        echo $this->_bd->eliminarIva('id=' . $id);
    }
    
    /**
     * Elimina un modulo 
     * @param int $id 
     */
    public function eliminarModulo()
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        if (is_null($id)) {
            echo 'es null' . $id;
        }

        if (!$id) {
            echo 'es falso' . $id;
        }
        echo $this->_bd->eliminarModulo('id=' . $id);
    }

    public function modulos()
    {
        $this->_vista->setVistaCss(array('dataTables.bootstrap.min', 'select.dataTables.min'));
        $this->_vista->setVistaJs(array('dataTables.bootstrap.min', 'dataTables.select.min', 'lista_modulos'));
        $this->_vista->titulo = TITULO_LISTA_MODULOS;
        $this->_vista->listaModulos = $this->_bd->getAllModulos();
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasModulos();
        $this->_vista->renderizar('IndexModulos');
    }

    public function editarModulo()
    {
        $this->_vista->titulo = TITULO_EDITAR_MODULO;
        $id = filter_input(INPUT_GET, 'id');
        $modulo = $this->_bd->getModulo('id=' . $id);
        $this->_vista->modulo = $modulo;
        $this->_vista->tiposModulo = array('Aplicación','Sistema');
        if ($this->getIntPost('editar') == 1) {            
            $this->_guardarModulo();
        }
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasModulos();
        $this->_vista->renderizar('editar_modulo');
    }

    public function nuevoModulo()
    {
        $this->_acl->acceso('nuevo_modulo');
        $this->_vista->titulo = TITULO_NUEVO_MODULO;
        if ($this->getIntPost('guardar') == 1) {
            $this->_guardarModulo();
        }
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasModulos();
        $this->_vista->renderizar('nuevo_modulo');
    }

    private function _editarModulo($id, $contribuyente)
    {
        return $this->_bd->editarIva($id, $contribuyente);
    }

    private function _guardarModulo()
    {
        $rtdo = '';
        $datos = $this->_limpiarDatosModulo();
        $aGuardar = array(
            'modulo' => $datos['modulo'],
            'tipo' => $datos['tipo'],
            'habilitado' => $datos['habilitado'],
            'visible' => $datos['visible']
        );
        if (isset($datos['editar'])) {
            $rtdo = $this->_bd->editarModulo('id=' . $datos['id'],$aGuardar);
        } else {
            $rtdo = $this->_bd->insertarModulo($aGuardar);
        }
        if ($rtdo) {
            $this->_vista->_mensaje = 'DATOS_GUARDADOS';
        } else {
            $this->_vista->_mensaje = 'DATOS_NO_GUARDADOS';
        }
        return $rtdo;
    }

    /**
     * Limpia los datos que vienen del Post
     * @return array $datos
     */
    private function _limpiarDatosModulo()
    {
        $datos['guardar'] = filter_input(INPUT_POST, 'guardar', FILTER_SANITIZE_NUMBER_INT);
        $datos['editar'] = filter_input(INPUT_POST, 'editar', FILTER_SANITIZE_NUMBER_INT);
        $datos['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $datos['modulo'] = filter_input(INPUT_POST, 'modulo', FILTER_SANITIZE_STRING);
        $datos['tipo'] = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING);
        $datos['habilitado'] = filter_input(INPUT_POST, 'habilitado');
        if ($datos['habilitado'] == 'habilitado'){
            $datos['habilitado'] = 1;
        }  else {
            $datos['habilitado'] = 0;
        }
        $datos['visible'] = filter_input(INPUT_POST, 'visible');
        if ($datos['visible'] == 'visible'){
            $datos['visible'] = 1;
        }  else {
            $datos['visible'] = 0;
        }
        return $datos;
    }

    public function puestos()
    {
        $this->_vista->setVistaCss(array('dataTables.bootstrap.min', 'select.dataTables.min'));
        $this->_vista->setVistaJs(array('dataTables.bootstrap.min', 'dataTables.select.min', 'lista_puestos'));
        $this->_vista->titulo = TITULO_LISTA_PUESTOS;
        $this->_vista->listaPuestos = $this->_bd->getPuestos();
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasPuestos();
        $this->_vista->renderizar('IndexPuestos');
    }
    
    public function nuevoPuesto()
    {
        $this->_vista->titulo = TITULO_NUEVO_PUESTO;
        if ($this->getIntPost('guardar') == 1) {
            $puesto = $this->getTextoPost('puesto');
            $this->_nuevoPuesto($puesto);
        }
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasPuestos();
        $this->_vista->renderizar('nuevo_puesto');
    }
    
    private function _nuevoPuesto($puesto)
    {
        return $this->_bd->nuevoPuesto($puesto);
    }
    
    public function editarPuesto()
    {
        $this->_vista->titulo = TITULO_EDITAR_PUESTO;
        $id = filter_input(INPUT_GET, 'id');
        if ($this->getIntPost('editar') == 1) {            
            $this->_guardarPuesto();
        }
        $puesto = $this->_bd->getPuesto($id);
        $this->_vista->puesto = $puesto;
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasPuestos();
        $this->_vista->renderizar('editar_puesto');
    }
    
    private function _guardarPuesto()
    {
        $rtdo = '';
        $datos = $this->_limpiarDatosPuesto();
        $aGuardar = array('puesto' => $datos['puesto']);
        if (isset($datos['editar'])) {
            $rtdo = $this->_bd->editarPuesto('id=' . $datos['id'],$aGuardar);
        } else {
            $rtdo = $this->_bd->insertarPuesto($aGuardar);
        }
        if ($rtdo) {
            $this->_vista->_mensaje = 'DATOS_GUARDADOS';
        } else {
            $this->_vista->_mensaje = 'DATOS_NO_GUARDADOS';
        }
        return $rtdo;
    }
    
    /**
     * Limpia los datos que vienen del Post
     * @return array $datos
     */
    private function _limpiarDatosPuesto()
    {
        $datos['guardar'] = filter_input(INPUT_POST, 'guardar', FILTER_SANITIZE_NUMBER_INT);
        $datos['editar'] = filter_input(INPUT_POST, 'editar', FILTER_SANITIZE_NUMBER_INT);
        $datos['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $datos['puesto'] = filter_input(INPUT_POST, 'puesto', FILTER_SANITIZE_STRING);
        return $datos;
    }
    
    /**
     * Elimina un puesto de trabajo 
     */
    public function eliminarPuesto()
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        if (is_null($id)) {
            echo 'es null' . $id;
        }

        if (!$id) {
            echo 'es falso' . $id;
        }
        echo $this->_bd->eliminarPuesto('id=' . $id);
    }
    
    public function imprimirListaIva() {
        $pdf = new Lib_Esc_pdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Lista Gral. de IVA',0,1,'C');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(20);
        $pdf->Cell(12, 10, 'Nro',0,0);
        $pdf->Cell(100, 10, 'Contribuyente',0,1);
//        $pdf->Cell(0, 10, 'DNI',0,1);
        $pdf->SetFont('Arial', '', 12);        
        $datos = $this->_bd->getTipoContribuyentes();
        $i = 1;
        foreach ($datos as $iva) {
            $pdf->Cell(20);
            $pdf->Cell(12, 10, $i,0,0);
            $pdf->Cell(100, 10, utf8_decode($iva->getContribuyente()),0,1);
//            $pdf->Cell(0, 10, $personal->getNro_doc(),0,1);
            $i++;
        }        
        $pdf->Output();
    }
    
    public function imprimirListaModulos() {
        $pdf = new Lib_Esc_pdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, utf8_decode('Lista Gral. de Módulos del Sistema'),0,1,'C');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(20);
        $pdf->Cell(12, 10, 'Nro',0,0);
        $pdf->Cell(100, 10, utf8_decode('Módulo'),0,0);
        $pdf->Cell(0, 10, 'Tipo',0,1);
        $pdf->SetFont('Arial', '', 12);        
        $datos = $this->_bd->getAllModulos();
        $i = 1;
        foreach ($datos as $modulo) {
            $pdf->Cell(20);
            $pdf->Cell(12, 10, $i,0,0);
            $pdf->Cell(100, 10, utf8_decode($modulo->getModulo()),0,0);
            $pdf->Cell(0, 10, utf8_decode($modulo->getTipo()),0,1);
            $i++;
        }        
        $pdf->Output();
    }
    
    public function imprimirListaPuestos() {
        $pdf = new Lib_Esc_pdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Lista Gral. de Puestos',0,1,'C');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(20);
        $pdf->Cell(12, 10, 'Nro',0,0);
        $pdf->Cell(100, 10, 'Puesto',0,1);
//        $pdf->Cell(0, 10, 'DNI',0,1);
        $pdf->SetFont('Arial', '', 12);        
        $datos = $this->_bd->getPuestos();
        $i = 1;
        foreach ($datos as $puesto) {
            $pdf->Cell(20);
            $pdf->Cell(12, 10, $i,0,0);
            $pdf->Cell(100, 10, utf8_decode($puesto->getPuesto()),0,1);
//            $pdf->Cell(0, 10, $personal->getNro_doc(),0,1);
            $i++;
        }        
        $pdf->Output();
    }

}
