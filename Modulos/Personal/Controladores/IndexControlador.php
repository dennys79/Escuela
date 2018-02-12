<?php
require_once MODS_PATH . 'Personal' . DS . 'Modelos' . DS . 'IndexModelo.php';
require_once BASE_PATH . 'LibQ' . DS . 'BarraHerramientas.php';
require_once BASE_PATH . 'LibQ' . DS . 'ArchivosYcarpetas.php';
require_once 'BarraHerramientasPersonal.php';
require_once 'BotonesPersonal.php';
require_once BASE_PATH . 'LibQ' . DS . 'ValidarFormulario.php';
require_once LIB_PATH . 'Esc_pdf.php';
/**
 * Clase Personal Controlador 
 */
class Personal_Controladores_indexControlador extends App_Controlador
{

    private $_personal;
    private $_datosLaborales;
    private $_datosContacto;
    private $_bhp;
    private $_listaSexos;
    

    public function __construct()
    {
        parent::__construct();
        $this->_personal = new Personal_Modelos_IndexModelo();
        $this->_datosLaborales = new Personal_Modelos_laboralModelo();
        $this->_datosContacto = $this->cargarModelo('contacto');
        $this->_bhp = new BarraHerramientasPersonal();
        $this->_listaSexos = array('VARON', 'MUJER');
    }

    public function index()
    {
        $this->isAutenticado();
        $this->_vista->_barraHerramientas = $this->_bhp->getBarraHerramientasIndex();
        $datos = $this->_personal->getTodoPersonal();
        $this->_vista->datos = $datos;
        $this->_vista->varones = $this->_personal->getPersonalBySexo("VARON");
        $this->_vista->mujeres = $this->_personal->getPersonalBySexo("MUJER");
        $this->_vista->titulo = TITULO_PERSONAL;
        $this->_vista->setVistaCss(
                array('dataTables.bootstrap.min','select.dataTables.min'));        
        
        $this->_vista->setVistaJs(
                array(
                    'dataTables.bootstrap.min',
                    'dataTables.select.min',
                    'lista_personal'
                    )
                );
        $this->_vista->renderizar('index', 'personal');
    }    

    public function nuevo()
    {
        $this->isAutenticado();
        $this->_acl->acceso('nuevo_personal');
        $this->_vista->_barraHerramientas = $this->_bhp->getBarraHerramientasNuevo();
        $this->_vista->titulo = TITULO_NUEVO_PERSONAL;
        $this->_vista->setJs(array('tinymce/jscripts/tiny_mce/tiny_mce'));        
        $this->_vista->setVistaJs(
                array(
                    'jquery.validate.min', 'validarNuevo',
                    'util', 'lista_personal',
                    'iniciarTinyMce'));
        $this->_vista->listaSexos = $this->_listaSexos;
        $this->_vista->datos = INPUT_POST;
        if ($this->getIntPost('guardar') == 1) {
            $this->_guardar();
        }
        $this->_vista->renderizar('nuevo', 'personal');
    }
    
    private function _guardar()
    {
        $rtdo = '';
        $datos = $this->_limpiarDatos();
        $errores = $this->_validarPost($datos);
        $aGuardarPersonal = $this->_prepararDatosPersonal($datos);
        if ($errores->getRetEval() or $errores->getErrString()<>'') {
            $this->_vista->_msj_error = $errores->getErrString();
        } else {
            if (isset($datos['editar'])) {
                $id = $aGuardarPersonal['id'];
                unset($aGuardarPersonal['id']);
                $rtdo = $this->_personal->editarPersonal($aGuardarPersonal, 'id=' . $id);
            } else {
                unset($aGuardarPersonal['id']);
                $rtdo = $this->_personal->insertarPersonal($aGuardarPersonal);
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
    private function _limpiarDatos()
    {
        $datos['guardar'] = filter_input(INPUT_POST, 'guardar', FILTER_SANITIZE_NUMBER_INT);
        $datos['editar'] = filter_input(INPUT_POST, 'editar', FILTER_SANITIZE_NUMBER_INT);
        $datos['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $datos['apellidos'] = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING);
        $datos['nombres'] = filter_input(INPUT_POST, 'nombres', FILTER_SANITIZE_STRING);
        $datos['nro_doc'] = filter_input(INPUT_POST, 'nro_doc', FILTER_SANITIZE_STRING);
        $datos['cuil'] = filter_input(INPUT_POST, 'cuil', FILTER_SANITIZE_NUMBER_INT);
        $datos['calle'] = filter_input(INPUT_POST, 'calle', FILTER_SANITIZE_STRING);
        $datos['casa_nro'] = filter_input(INPUT_POST, 'casa_nro', FILTER_SANITIZE_STRING);
        $datos['barrio'] = filter_input(INPUT_POST, 'barrio', FILTER_SANITIZE_STRING);
        $datos['id_domicilio'] = filter_input(INPUT_POST, 'id_domicilio', FILTER_SANITIZE_NUMBER_INT);
        return $datos;
    }
    
    private function _prepararDatosPersonal()
    {
        $datosPaciente = array(
            'id' => parent::getPostParam('id'),
            'apellidos' => parent::getPostParam('apellidos'),
            'nombres' => parent::getPostParam('nombres'),
            'nacionalidad' => parent::getPostParam('nacionalidad'),
            'tipo_doc' => parent::getIntPost('tipo_doc'),
            'nro_doc' => parent::getPostParam('nro_doc'),
            'cuil' => parent::getPostParam('cuil'),
            'sexo' => parent::getPostParam('sexo'),
            'fecha_nac' => parent::getPostParam('fechaNac')
        );
        return $datosPaciente;
    }
    
    /**
     * Validar los datos del POST
     * @param array $datos
     * @return \ValidarFormulario
     */
    private function _validarPost($datos)
    {
        $validar = new LibQ_ValidarFormulario();
        $validar->ValidField($datos['apellidos'], 'text', 'El Apellido no es válido');
        $validar->ValidField($datos['nombres'], 'text', 'El Nombre no es válido');
        $existe = $this->_personal->existePersonal('nro_doc='.$this->getIntPost('nro_doc'));
        if ($existe AND $datos['guardar']) {
            $validar->SetError('El DNI ya existe');
        }
        return $validar;
    }

    public function editar($id)
    {
        $this->isAutenticado();
        $this->_acl->acceso('editar_personal');
        $this->_vista->_barraHerramientas = $this->_bhp->getBarraHerramientasEditar();
        $idPer = $this->_controlId($id);
        $this->_vista->titulo = TITULO_EDITAR_PERSONAL;
        $this->_vista->setCss(array('flags'));
        /** Cargo los archivos js */
        $this->_vista->setJs(array('tinymce/jscripts/tiny_mce/tiny_mce'));
        $this->_vista->setVistaJs(
                array('jquery.validate.min', 'validarNuevo', 'util',
                    'iniciarTinyMce'));
        
        if ($this->getIntPost('editar') == 1) {
            $this->_guardar();
        }
        $personal = $this->_personal->getPersonal("id = " . $idPer);
        $this->_vista->directorio_fotos = 'Personal'.DS.$idPer;
        $this->_vista->fotos = LibQ_ArchivosYcarpetas::listarArchivos("Public/Img/Fotos/Personal/".$idPer);
        $this->_vista->datos = $personal;
        $this->_vista->domicilio = $personal->getDomicilio();
        $this->_vista->datosContacto = $personal->getContactos($this->filtrarInt($id));
        $this->_vista->datosLaborales = $personal->getDatosLaborales();
        $this->_vista->listaOcupaciones = $this->_personal->getAllOcupaciones();
        $this->_vista->listaSexos = $this->_listaSexos;
        $this->_vista->listaCountries = $this->_getCountries();
        $this->_vista->listaNacionalidades = $this->_getNacionalidades();
        $this->_vista->listaTipoDoc = array(0=>'DNI',1=>'CI');
        $this->_cargarMapa($personal->getDomicilio());        
        $this->_vista->renderizar('editar', 'Personal');
    }
    
    private function _cargarMapa($domicilio)
    {
        require_once BASE_PATH . 'LibQ' . DS . 'Google' . DS . 'nxgooglemapsapi.php';
        $api = new NXGoogleMapsAPI(); 
        $this->_vista->setBodyOnLoad($api->getOnLoadCode());
        $this->_vista->setJs(array('http://maps.google.com/maps?file=api&v=2&key='.GOOGLEMAPSKEY),FALSE);
        $api->setWidth(400); 
        $api->setHeight(300); 
        $api->setZoomFactor(16); 
        $api->addControl(GLargeMapControl); 
        $api->addControl(GMapTypeControl); 
        $api->addControl(GOverviewMapControl); 
        $direccion = $domicilio->getCasa_nro() . ' ' . $domicilio->getCalle() . ' ' .
                $domicilio->getBarrio() . ' ' . $domicilio->getLocalidad() . ' ' .
                $domicilio->getProvincia() . ' ' . $domicilio->getPais();
        $api->addAddress($direccion, true); 
        $this->_vista->maps = $api;
        $this->_vista->jsMaps = $api->getHeadCode();
    }
    
    private function _controlId($id)
    {
        /** Si no viene id en el POST envío al Index */
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('option=Personal');
        }
        /** Si no encuentro el paciente envío al Index */
        $idPer = $this->filtrarInt($id);
        if (!$this->_personal->existePersonal("id = " . $idPer)) {
            $this->redireccionar('option=Personal');
        }
        return $idPer;
    }
    
    /**
     * Elimina los datos de un personal
     */
    public function eliminar()
    {    
        $this->_acl->acceso('eliminar_personal');
        $id = filter_input(INPUT_POST, 'idPersonal', FILTER_SANITIZE_NUMBER_INT);
        if (is_null($id)) {
            echo 'es null'.$id;
//            $this->redireccionar('option=Personal');
        }

        if (!$id) {
            echo 'es falso'.$id;
//            $this->redireccionar('option=Personal');
        }
        
        if ($this->_personal->eliminarPersonal('id = ' . $id)>0){
            echo 'Datos Eliminados';
        }else{
            echo 'No se pudo eliminar el registro';
        }
//        $this->redireccionar('option=Personal');
    }
    
    public function imprimirLista() {
        $pdf = new Lib_Esc_pdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Lista Gral. de Personal',0,1,'C');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(20);
        $pdf->Cell(12, 10, 'Nro',0,0);
        $pdf->Cell(100, 10, 'Apellido y Nombre',0,0);
        $pdf->Cell(0, 10, 'DNI',0,1);
        $pdf->SetFont('Arial', '', 12);        
        $datos = $this->_personal->getTodoPersonal();
        $i = 1;
        foreach ($datos as $personal) {
            $pdf->Cell(20);
            $pdf->Cell(12, 10, $i,0,0);
            $pdf->Cell(100, 10, utf8_decode($personal->getAyN()),0,0);
            $pdf->Cell(0, 10, $personal->getNro_doc(),0,1);
            $i++;
        }        
        $pdf->Output();
    }
    
    public function imprimirFicha() {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $alumno = $this->_personal->getPersonal('id='.$id);
        $pdf = new Lib_Esc_pdf();
        $pdf->AddPage();
        $fotos = LibQ_ArchivosYcarpetas::listarArchivos("Public/Img/Fotos/Personal/" . $id);        
        if(is_array($fotos) and count($fotos) > 0){
            $foto = IMAGEN_PUBLICA . 'Fotos/Personal/' . $id . '/' . $fotos[2];
        } else {
            $foto = IMAGEN_PUBLICA . 'Fotos/Alumno/Idsin_imagen.png';
        }               
        $pdf->imagen_con_borde($foto, 141, 60, 55, 0);        
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(10);
        $pdf->Cell(0, 10, 'Ficha del Personal',1,1,'C');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 12);        
        $pdf->Cell(20);
        $pdf->Cell(38, 10, 'Apellido:',0,0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 10, utf8_decode($alumno->getApellidos()),0,1);        

        $pdf->SetFont('Arial', '', 12);        
        $pdf->Cell(20);
        $pdf->Cell(38, 10, 'Nombres:',0,0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 10, utf8_decode($alumno->getNombres()),0,1);        
        
        $pdf->SetFont('Arial', '', 12);        
        $pdf->Cell(20);
        $pdf->Cell(38, 10, 'DNI:',0,0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 10, utf8_decode($alumno->getNro_doc()),0,1);        
        
        $pdf->SetFont('Arial', '', 12);        
        $pdf->Cell(20);
        $pdf->Cell(30, 10, 'CUIL:',0,0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 10, utf8_decode($alumno->getCuil()),0,1);        


        $pdf->SetFont('Arial', '', 12);        
        $pdf->Cell(20);
        $pdf->Cell(38, 10, 'Nacionalidad:',0,0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 10, utf8_decode($alumno->getNacionalidad()),0,1);        

        $pdf->SetFont('Arial', '', 12);        
        $pdf->Cell(20);
        $pdf->Cell(38, 10, 'Sexo:',0,0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 10, utf8_decode($alumno->getSexo()),0,1);        

        $pdf->SetFont('Arial', '', 12);        
        $pdf->Cell(20);
        $pdf->Cell(38, 10, 'Fecha Nacimiento:',0,0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 10, utf8_decode($alumno->getFecha_nac()),0,1);          
        
        $pdf->Output();
    }
       
    private function _getCountries() {
        require_once BASE_PATH . 'LibQ' . DS . 'Countries' .DS . 'ModeloCountries.php';
        $country = new LibQ_Countries_ModeloCountries();
        return $country->getCountries();
    }
    
    private function _getNacionalidades() {
        $alumno = $this->_personal->getNacionalidadesPersonal();
        return $alumno;
    }   

}