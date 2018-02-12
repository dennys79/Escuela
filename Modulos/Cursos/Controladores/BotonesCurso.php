<?php

require_once BASE_PATH . 'LibQ' . DS . 'BotonesApp.php';

/**
 * Description of BotonesCursos
 *
 * @author WERD
 */
class BotonesCurso extends LibQ_BotonesApp {

    private $_paramBotonNuevo = array(
        'href' => '?mod=Cursos&cont=index&met=nuevo',
        'classIcono' => 'icono-nuevo32',
        'titulo' => 'Nuevo',
        'title' => 'Crear un nuevo curso',
        'icono' => 'glyphicon glyphicon-plus-sign',
        'class' => 'btn btn-danger',
        'data-toggle'=>'tooltip'
    );

    /**
     * Propiedad usada para configurar el boton ELIMINAR
     * @var type Array
     */
    private $_paramBotonEliminar = array(
        'href' => "javascript:void(0);",
        'id' => 'eliminar',
        'disabled' => 'disabled',
        'evento' => "onclick=\"javascript: eliminar()\"",
        'titulo' => 'Eliminar',
        'title' => 'Elimina el curso seleccionado',
        'icono' => 'glyphicon glyphicon-trash',
        'class' => 'btn btn-primary',
        'data-toggle'=>'tooltip'
    );

    /**
     * Propiedad usada para configurar el boton ELIMINAR
     * @var type Array
     */
    private $_paramBotonInscribir = array(
        'href' => "javascript:void(0);",
        'id' => 'inscribir',
        'evento' => "onclick=\"javascript: inscribir()\"",
        'titulo' => 'Inscribir',
        'title' => 'Inscribir alumnos en este curso',
        'icono' => 'glyphicon glyphicon-pencil',
        'class' => 'btn btn-warning',
        'data-toggle'=>'tooltip'
    );

    /**
     * Propiedad usada para configurar el botón LISTA por O. Social
     * @var type Array
     */
    private $_paramBotonImprimir = array(
        'href' => 'index.php?mod=Cursos&cont=index&met=imprimirLista',
        'titulo' => 'Imprimir Lista',
        'title' => 'Imprime la lista que está en pantalla',
        'classIcono' => 'icono-imprimir',
        'icono' => 'glyphicon glyphicon-print',
        'class' => 'btn btn-primary',
        'data-toggle'=>'tooltip'
    );
    
    /**
     * Propiedad usada para configurar el botón LISTA por O. Social
     * @var type Array
     */
    private $_paramBotonImprimirListaAlumnos = array(
        'href' => 'index.php?mod=Cursos&cont=index&met=imprimirListaAlumnos',
        'titulo' => 'Imprimir Lista',
        'title' => 'Imprime la lista de alumnnos del curso actual',
        'classIcono' => 'icono-imprimir',
        'icono' => 'glyphicon glyphicon-print',
        'class' => 'btn btn-primary',
        'data-toggle'=>'tooltip'
    );

    /**
     * Propiedad usa para configurar el botón GUARDAR
     * @var type Array
     */
    private $_paramBotonGuardar = array(
        'href' => "\"javascript:void(0);\"",
        'evento' => "onclick=\"javascript: submitbutton('Guardar')\"",
        'title' => 'Guarda los datos',
        'class' => 'btn btn-primary',
        'data-toggle'=>'tooltip'
    );
    private $_paramBotonEditar = array(
        'href' => "javascript:void(0);",
        'id' => 'editar',
        'disabled' => 'disabled',
        'evento' => "onclick=\"javascript: editar()\"",
        'titulo' => 'Editar',
        'title' => 'Editar los datos del curso seleccionado',
        'icono' => 'glyphicon glyphicon-edit',
        'class' => 'btn btn-primary',
        'data-toggle'=>'tooltip'
    );
    
    private $_paramBotonListaAlumnos = array(
        'href' => "javascript:void(0);",
        'id' => 'listaAlumnos',
        'disabled' => 'disabled',
        'evento' => "onclick=\"javascript: listarAlumnos()\"",
        'titulo' => 'Listar Alumnos',
        'title' => 'Listar los alumnos del curso selccionado',
        'icono' => 'glyphicon glyphicon-list',
        'class' => 'btn btn-primary',
        'data-toggle'=>'tooltip'
    );

    /**
     * Propiedad usada para configurar el botón LISTA
     * @var type Array
     */
    private $_paramBotonLista = array(
        'href' => 'index.php?mod=Cursos&cont=index',
        'classIcono' => 'icono-lista32',
        'titulo' => 'Lista de Cursos',
        'title' => 'Muestra la lista general de cursos',
        'icono' => 'glyphicon glyphicon-list',
        'class' => 'btn btn-primary',
        'data-toggle'=>'tooltip'
    );

    /**
     * Propiedad usada para configurar el botón EDITAR LISTA
     * @var type Array
     */
    private $_paramBotonEditarLista = array(
        'href' => 'index.php?mod=Cursos&cont=index&met=editarLista',
        'classIcono' => 'icono-lista32',
        'titulo' => 'Editar Lista',
        'title' => 'Editar la lista de cursos del ciclo lectivo actual',
        'icono' => 'glyphicon glyphicon-list-alt',
        'class' => 'btn btn-primary',
        'data-toggle'=>'tooltip'
    );

    public function __construct() {
        
    }

    public function getParamBotonNuevo() {
        return $this->_paramBotonNuevo;
    }

    public function getParamBotonEliminar() {
        return $this->_paramBotonEliminar;
    }

    public function getParamBotonInscribir() {
        return $this->_paramBotonInscribir;
    }

    public function getParamBotonGuardar() {
        return $this->_paramBotonGuardar;
    }

    public function getParamBotonEditar() {
        return $this->_paramBotonEditar;
    }

    public function getParamBotonLista() {
        return $this->_paramBotonLista;
    }

    public function getParamBotonListaAlumnos($id) {
        return array(
            'href' => 'index.php?mod=Cursos&cont=index&met=listarAlumnos&id=' . $id,
            'classIcono' => 'icono-lista32',
            'titulo' => 'Lista de Alumnos',
            'title' => 'Imprimir lista de alumnnos',
            'icono' => 'glyphicon glyphicon-list-alt',
            'class' => 'btn btn-primary',
            'data-toggle'=>'tooltip'
        );
    }
    
    public function getParamBotonListaAlumnosJs()
    {
        return $this->_paramBotonListaAlumnos;
    }

    public function getParamBotonEditarLista() {
        return $this->_paramBotonEditarLista;
    }

    public function getParamBotonDirTelefonico() {
        return $this->_paramBotonDirTelefonico;
    }

    public function getParamBotonImprimir() {
        return $this->_paramBotonImprimir;
    }

    public function getParamBotonImprimirListaAlumnos($id) {
        return array(
            'href' => 'index.php?mod=Cursos&cont=index&met=ImprimirListaAlumnos&id=' . $id,
            'classIcono' => 'icono-lista32',
            'titulo' => 'Imprimir Lista',
            'title' => 'Imprimir Lista de alumnos',
            'icono' => 'glyphicon glyphicon-print',
            'class' => 'btn btn-primary',
            'data-toggle'=>'tooltip'
        );
    }
    
}
