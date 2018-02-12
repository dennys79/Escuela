<?php
require_once BASE_PATH . 'LibQ' . DS . 'BotonesApp.php';
/**
 * Description of BotonesInasistenciass
 *
 * @author WERD
 */
class BotonesInasistencias extends LibQ_BotonesApp
{
    
    private $_paramBotonAlumnos = array(
        'href' => '?mod=Inasistencias&cont=index&met=inasistenciaAlumnos',
        'classIcono' => 'icono-nuevo32',
        'titulo' => 'Alumnos',
//        'icono' => 'glyphicon glyphicon-plus-sign',
        'class' => 'btn btn-primary'
    );
    
    private $_paramBotonDocentes = array(
        'href' => '?mod=Inasistencias&cont=index&met=inasistenciaDocentes',
        'classIcono' => 'icono-nuevo32',
        'titulo' => 'Docentes',
//        'icono' => 'glyphicon glyphicon-plus-sign',
        'class' => 'btn btn-primary'
    );

    public function __construct()
    {
    }

    public function getParamBotonAlumnos()
    {
        return $this->_paramBotonAlumnos;
    }
    
    public function getParamBotonDocentes()
    {
        return $this->_paramBotonDocentes;
    }
    
}
