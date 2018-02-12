<?php
require_once 'ImprimirControlador.php';
require_once BASE_PATH . 'LibQ' . DS . 'ValidarFormulario.php';
require_once MODS_PATH . 'Alumno' . DS . 'Modelos' . DS . 'IndexModelo.php';
require_once 'BarraHerramientasAlumnos.php';
require_once BASE_PATH . 'LibQ' . DS . 'ArchivosYcarpetas.php';
require_once 'BotonesAlumnos.php';
require_once LIB_PATH . 'Esc_pdf.php';
require_once MODS_PATH . 'BloqueInfo' . DS . 'Controladores' . DS . 'IndexControlador.php';
/**
 * Clase Alumno Controlador 
 */
class Alumno_Controladores_IndexControlador extends App_Controlador {

    protected $_alumno;
    protected $_datosTerapia;
    protected $_datosContacto;
    protected $_datosFamilia;
    protected $_datosOSocial;
    protected $_listaSexos;
//    protected $_listaNacionalidades;
//    protected $_listaCountries;
    protected $_personal;
    protected $_estadoAlumno = array('PRE-INSCRIPTO', 'INSCRIPTO', 'REGULAR', 'BAJA');
    protected $_arrayEscuelas = Array(array('id' => '0476', 'denominacion' => 'Pequeño Hogar'));
    protected $_bt;
    protected $_bh;

    /**
     * Constructor de la clase Index
     * Inicializa los modelos 
     */
    public function __construct() {
        parent::__construct();
        $this->_alumno = new Alumno_Modelos_indexModelo();
        $this->_listaSexos = array('VARON', 'MUJER');
        $this->_vista->listaSexos = $this->_listaSexos;
        $this->_vista->listaNacionalidades = $this->_getNacionalidades();
        $this->_vista->listaCountries = $this->_getCountries();
        $this->_vista->listaDiagnosticos = $this->_getListaDiagnosticos();
        $this->_vista->estado = $this->_estadoAlumno;
        $this->_bh = new BarraHerramientasAlumnos();
    }

    /**
     * Método por defecto del módulo Alumno
     * Muestra una lista con los alumnos
     */
    public function index() {
        $this->isAutenticado();
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasIndex();
        $datos = $this->_alumno->getAlumnos();
        $this->_vista->datos = $datos;
        $this->_vista->info = $this->_crearBloqueInfo();
//        $this->_vista->varones = $this->_alumno->getAlumnosBySexo("VARON");
        $this->_vista->mujeres = $this->_alumno->getAlumnosBySexo("MUJER");
        $this->_vista->titulo = TITULO_ALUMNOS;
        $this->_vista->setVistaCss(
                array('dataTables.bootstrap.min', 'select.dataTables.min'));
        $this->_vista->setVistaJs(
                array(
                    'dataTables.bootstrap.min',
                    'dataTables.select.min',
                    'lista_alumnos'
                )
        );
        $this->_vista->renderizar('index', 'alumno');
    }
    
    private function _crearBloqueInfo(){
        $info = new BloqueInfo_Controladores_IndexControlador( 'Alumnos' );
        $info->setTitulo( 'Estadísticas' );
        $info->setItem(
                array(
                    'item'=>'TOTAL',
                    'valor'=>count($this->_alumno->getAlumnosRegulares()),
                    'class'=>'fa fa-group',
                    'textoValor'=>' Alumnos Regulares en la Base de Datos'
                )
            );
        $info->setItem(
                array(
                    'item'=>'VARONES',
                    'valor'=>count($this->_alumno->getAlumnosBySexo("VARON")),
                    'class'=>'fa fa-male',
                    'textoValor'=>' Varones en la Base de Datos'
                )
            );
        $info->setItem(
                array(
                    'item'=>'MUJERES',
                    'valor'=>count($this->_alumno->getAlumnosBySexo("MUJER")),
                    'class'=>'fa fa-female',
                    'textoValor'=>' Mujeres en la Base de Datos'
                )
            );
        return $info;
    }

    /**
     * Método para listar los contactos de los alumnos
     */
    public function dirTelefonico() {
        $this->isAutenticado();
        /** Barra de herramientas */
        $bh = new BarraHerramientasAlumnos();
        $this->_vista->_barraHerramientas = $bh->getBarraHerramientasDirTelefonico();
        $datos = $this->_alumno->getAlumnos();
        $this->_vista->datos = $datos;
        /** Establezco el titulo */
        $this->_vista->titulo = 'Directorio Telefónico de Alumnos';
        $this->_vista->setVistaJs(array('lista_telefonos'));
        $this->_vista->renderizar('dirTelefonico', 'alumno');
    }

    public function nuevo() {
        $this->isAutenticado();
        $this->_acl->acceso('nuevo_alumno');
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasNuevo();
//        $this->_vista->estadosAlumno = $this->_estadoAlumno;
        $this->_vista->titulo = TITULO_NUEVO_ALUMNOS;
        $this->_vista->setJs(array('tinymce/jscripts/tiny_mce/tiny_mce'));
        $this->_vista->setVistaJs(
                array(
                    'jquery.validate.min', 'validarNuevo',
                    'util', 'lista_alumnos',
                    'iniciarTinyMce'));

//        $this->_vista->listaSexos = $this->_listaSexos;
//        $this->_vista->listaNacionalidades = $this->_getNacionalidades();
        $this->_vista->datos = INPUT_POST;
        if ($this->getIntPost('guardar') == 1) {
            $this->_guardar();
        }
        $this->_vista->renderizar('nuevo', 'Alumno');
    }

    public function editar($id) {
        $this->isAutenticado();
        $this->_acl->acceso('editar_alumno');
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasEditar($id);
        $idPac = $this->_controlId($id);
        $this->_vista->titulo = TITULO_EDITAR_ALUMNOS;
        $this->_vista->estadosAlumno = $this->_estadoAlumno;
        /** Cargo los archivos js */
        $this->_vista->setCss(array('flags'));
        $this->_vista->setVistaJs(
                array(
                    'jquery.validate.min', 'validarNuevo',
                    'util', 'lista_alumnos'));
        /** Si el Post viene con editar = 1 */
        if ($this->getIntPost('editar') == 1) {
            $this->_guardar();
        }
        /** Si no es para guardar lleno el form con datos de la bd */
        $alumno = $this->_alumno->getAlumno("id = " . $idPac);
        $this->_vista->directorio_fotos = 'Alumno' . DS . $idPac;
        $this->_vista->fotos = LibQ_ArchivosYcarpetas::listarArchivos("Public/Img/Fotos/Alumno/" . $idPac);
        /** Envío los datos a la vista */
        $this->_vista->datos = $alumno;
        $this->_vista->datosSalud = $alumno->getObjSalud();
        $this->_vista->domicilio = $alumno->getDomicilio();
        $this->_vista->datosContacto = $alumno->getContactos($this->filtrarInt($id));
        $this->_vista->datosFamilia = $alumno->getFamilia();
//        $this->_vista->listaSexos = $this->_listaSexos;
//        $this->_vista->estado = $this->_estadoAlumno;
        $this->_vista->listaMedicos = $this->_obtenerListaMedicos();
//        $this->_vista->listaDiagnosticos = $this->_getListaDiagnosticos();
//        $this->_vista->listaCountries = $this->_listaCountries;
//        $this->_vista->listaNacionalidades = $this->_listaNacionalidades;
//        /** Envío otros datos */
        $this->_cargaDatosEducacion($alumno);
        $this->_cargarMapa($alumno->getDomicilio());
        $this->_vista->renderizar('editar', 'Alumno');
    }

    private function _cargaDatosEducacion($alumno) {
        if ($this->_modulos->ifExistModulo('Educacion')) {
            $this->_vista->datosEducacion = $alumno->getObjEducacion();
            $this->_vista->listaEscuelas = $this->_arrayEscuelas;
        }
    }

    private function _cargarMapa($domicilio) {
        require_once BASE_PATH . 'LibQ' . DS . 'Google' . DS . 'nxgooglemapsapi.php';
        $api = new NXGoogleMapsAPI();
        $this->_vista->setBodyOnLoad($api->getOnLoadCode());
        $this->_vista->setJs(array('http://maps.google.com/maps?file=api&v=2&key=' . GOOGLEMAPSKEY), FALSE);
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

    private function _controlId($id) {
        /** Si no viene id en el POST envío al Index */
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('option=Alumno');
        }
        /** Si no encuentro el alumno envío al Index */
        $idPac = $this->filtrarInt($id);
        if (!$this->_alumno->existeAlumno("id = " . $idPac)) {
            $this->redireccionar('option=Alumno');
        }
        return $idPac;
    }

    private function _guardar() {
        $rtdo = '';
        $datos = $this->_limpiarDatos();
        $errores = $this->_validarPost($datos);
        $aGuardarAlumno = $this->_prepararDatosAlumno($datos);
        if ($errores->getRetEval()) {
            $this->_vista->_msj_error = $errores->getErrString();
        } else {
            if (isset($datos['editar'])) {
                $rtdo = $this->_alumno->editarAlumno($aGuardarAlumno, 'id=' . $aGuardarAlumno['id']);
//                $this->_guardarDiagnostico($aGuardarAlumno);
            } else {
                unset($aGuardarAlumno['id']);
                $rtdo = $this->_alumno->insertarAlumno($aGuardarAlumno);
            }            
            if ($rtdo) {
                $this->_vista->_mensaje = 'DATOS_GUARDADOS';
            } else {
                $this->_vista->_mensaje = 'DATOS_NO_GUARDADOS';
            }
        }
        return $rtdo;
    }    

    private function _guardarDomicilio() {
        $rtdo = '';
        $datos = $this->_limpiarDatos();
        $errores = $this->_validarPost($datos);
        $aGuardarDomicilio = $this->_prepararDatosDomicilio($datos);
        if ($errores->getRetEval()) {
            $this->_vista->_msj_error = $errores->getErrString();
        } else {
            if (null != $datos['id_domicilio']) {
                $idPac = $aGuardarDomicilio['id_alumno'];
                unset($aGuardarDomicilio['id_alumno']);
                $rtdo = $this->_alumno->editarDomicilioAlumno($aGuardarDomicilio, 'id_alumno=' . $idPac);
            } else {
                $rtdo = $this->_alumno->insertarDomicilioAlumno($aGuardarDomicilio);
            }
            if ($rtdo) {
                $this->_vista->_mensaje = 'DATOS_GUARDADOS';
            } else {
                $this->_vista->_mensaje = 'DATOS_DOMICILIO_NO_GUARDADOS';
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

    /**
     * Validar los datos del POST
     * @param array $datos
     * @return \ValidarFormulario
     */
    private function _validarPost($datos) {
        $validar = new LibQ_ValidarFormulario();
        $validar->ValidField($datos['apellidos'], 'text', 'El Apellido no es válido');
        $validar->ValidField($datos['nombres'], 'text', 'El Nombre no es válido');
        /* Domicilio */
//        $validar->ValidField($datos['calle'], 'text', 'La Calle no es válida');
        return $validar;
    }

    private function _prepararDatosAlumno() {
        $datosAlumno = array(
            'id' => parent::getPostParam('id'),
            'estado' => parent::getPostParam('estado'),
            'apellidos' => parent::getPostParam('apellidos'),
            'nombres' => parent::getPostParam('nombres'),
            'nacionalidad' => parent::getPostParam('nacionalidad'),
            'tipo_doc' => parent::getIntPost('tipo_doc'),
            'nro_doc' => parent::getPostParam('nro_doc'),
            'cuil' => parent::getPostParam('cuil'),
            'sexo' => parent::getPostParam('sexo'),
            'fecha_nac' => parent::getPostParam('fechaNac'),
        );
        return $datosAlumno;
    }

    private function _prepararDatosDomicilio($datos) {
        $datosAlumno = array(
            'id_alumno' => parent::getPostParam('id'),
            'tipo_domicilio' => 'Real',
            'calle' => parent::getPostParam('calle'),
            'casa_nro' => parent::getPostParam('casa_nro'),
            'barrio' => parent::getPostParam('barrio'),
            'localidad' => parent::getPostParam('localidad'),
            'cp' => parent::getPostParam('cp'),
            'piso' => parent::getPostParam('piso'),
            'depto' => parent::getPostParam('depto'),
            'provincia' => parent::getPostParam('provincia'),
            'pais' => parent::getPostParam('pais')
        );
        return $datosAlumno;
    }

    private function _prepararDatosDiagnostico() {
        $datosDiagnostico = array(
            'id_alumno' => parent::getPostParam('id'),
            'id' => parent::getPostParam('id_diagnostico'),
            'diagnostico' => parent::getPostParam('diagnostico')
        );
        return $datosDiagnostico;
    }

    /**
     * Elimina los datos de un alumno
     * @param int $id 
     */
    public function eliminar() {
        $id = filter_input(INPUT_POST, 'idAlumno', FILTER_SANITIZE_NUMBER_INT);
        if (is_null($id)) {
            echo 'es null' . $id;
        }

        if (!$id) {
            echo 'es falso' . $id;
        }
        echo $this->_alumno->eliminarAlumno('id = ' . $id);
    }

    private function _datosEstadistica($datos) {
        $totalAlumnos = count($this->_alumno->getAlumnos());
        $alumnosVarones = count($this->_alumno->getAlumnosBySql(
                        "SELECT * FROM cronos_alumnos WHERE sexo='VARON' AND eliminado=false"));
        $alumnosMujeres = count($this->_alumno->getAlumnosBySql(
                        "SELECT * FROM cronos_alumnos WHERE sexo='MUJER' AND eliminado=false"));
        $estadisticas['total'] = $totalAlumnos . ' Alumnos';
        $estadisticas['varones'] = $alumnosVarones . ' Varones';
        $estadisticas['mujeres'] = $alumnosMujeres . ' Mujeres';
        $estadisticas['grafica'] = BASE_URL . '?option=Alumno&sub=grafico&met=graficaSexos&t=' .
                $totalAlumnos . '&v=' . $alumnosVarones . '&m=' . $alumnosMujeres;
        $listaOSociales = $this->_datosOSocial->getOSociales();
        $datosOSociales = array();
        foreach ($listaOSociales as $oSocial) {
//            print_r(count($this->_alumno->getAlumnosByOs($oSocial['id'])));
            array_push($datosOSociales, array($oSocial['denominacion'] => count($this->_alumno->getAlumnosByOs($oSocial['id']))));
            $estadisticas['obrasocial'] = $datosOSociales;
        }
        return $estadisticas;
    }

    public function getProfesionalesTerapia() {
        $retorno = '';
        $idTerapia = $this->getIntPost('idTerapia');
        $todos = $this->_alumno->getPersonalTerapia("puesto = $idTerapia");
        foreach ($todos as $personal) {
            $retorno .= '<option value="' . $personal->getId() . '" label="' .
                    $personal->getAyN() . '">' . $personal->getAyN() . '</option>';
        }
        echo $retorno;
    }

    public function imprimirLista() {
        $imp = new Alumno_Controladores_ImprimirControlador();
        $imp->imprimirLista();
    }

    public function imprimirFicha() {
        $imp = new Alumno_Controladores_ImprimirControlador();
        $imp->imprimirFicha();
    }

    private function _obtenerListaMedicos() {
        return array(
            array('id' => 1, 'apellido' => 'Galeano', 'nombre' => 'nose'),
            array('id' => 2, 'apellido' => 'Artigas', 'nombre' => 'fulana')
        );
    }

    private function _getCountries() {
        require_once BASE_PATH . 'LibQ' . DS . 'Countries' .DS . 'ModeloCountries.php';
        $country = new LibQ_Countries_ModeloCountries();
        return $country->getCountries();
    }
    
    private function _getNacionalidades() {
        $nacionalidades = $this->_alumno->getNacionalidadesAlumnos();
        return $nacionalidades;
    }
    
    private function _getListaDiagnosticos()
    {
        require_once MODS_PATH . 'Alumno' . DS . 'Modelos' . DS . 'SaludModelo.php';
        $modDiag = new Alumno_Modelos_saludModelo();
        $diagnosticos = $modDiag->getDiagnosticos();
        return $diagnosticos;
    }

}
