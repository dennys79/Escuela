<?php
require_once BASE_PATH . 'LibQ' . DS . 'BarraHerramientas.php';
require_once 'BotonesAcl.php';
require_once BASE_PATH . 'LibQ' . DS . 'Fechas.php';

/**
 * Description of BarraHerramientasPacientes
 *
 * @author WERD
 */
class BarraHerramientasAcl
{
    protected $_bh;
    protected $_id;
    protected $_bt;


    public function __construct($id='')
    {
        $this->_id = $id;
        $this->_bh = new LibQ_BarraHerramientas();;
        $this->_bt = new BotonesAcl();
    }

    public function getBarraHerramientasNuevo()
    {
        $this->_bh->addBoton('DropDown', $this->_crearBotonLista());
        $this->_bh->addBoton('Nuevo', $this->_bt->getParamBotonNuevo());
        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());
        return $this->_bh->render();
    }
    
    
    public function getBarraHerramientasRoles()
    {
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());
        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
        $this->_bh->addBoton('Nuevo', $this->_bt->getParamBotonNuevoRole());
        $this->_bh->addBoton('Permisos', $this->_bt->getParamBotonPermisos());
        $this->_bh->addBoton('Editar', $this->_bt->getParamBotonEditarRole());        
        return $this->_bh->render();
    }
    
    public function getBarraHerramientasPermisos()
    {
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());
        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
        $this->_bh->addBoton('Nuevo', $this->_bt->getParamBotonNuevoPermiso());
        $this->_bh->addBoton('Editar', $this->_bt->getParamBotonEditarPermiso());        
        return $this->_bh->render();
    }
    
    public function getBarraHerramientasIndex()
    {
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());
        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
        $this->_bh->addBoton('Roles', $this->_bt->getParamBotonRoles());
        $this->_bh->addBoton('Permisos', $this->_bt->getParamBotonPermisosIndex());
//        $this->_bh->addBoton('Eliminar', $this->_bt->getParamBotonEliminar());
//        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
//        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());
        return $this->_bh->render();
    }
    
    public function getBarraHerramientasEditar($id=null)
    {
        $this->_id = $id;
        $this->_bh->addBoton('DropDown', $this->_crearBotonImprimir());
        $this->_bh->addBoton('DropDown', $this->_crearBotonLista());
        $this->_bh->addBoton('Nuevo', $this->_bt->getParamBotonNuevo());
        $this->_bh->addBoton('Eliminar', $this->_bt->getParamBotonEliminar());
        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());
        return $this->_bh->render();
    }
    
    public function getBarraHerramientasPermisosRoles()
    {
        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());
        return $this->_bh->render();
    }
    
    private function _crearBotonImprimir()
    {
        $fecha = new LibQ_Fecha();
        if (intval($fecha->time_details->m) >= 12) {
            $fechaImpresion = '01/' . intval($fecha->getAnio() + 1);
        } else {
            $fechaImpresion = $fecha->getMes() . '/' . $fecha->getAnio();
        }
        if ($this->_id != null) {
            $_paramBotonImprimir = array(
                'class' => 'btn dropdown-toggle btn-primary',
                'titulo' => 'Imprimir',
                'icono' => 'glyphicon glyphicon-print',
                'children' => array(0 => $this->_botonNotaPedido($fechaImpresion, $this->_id),
                    1 => $this->_botonConstanciaRehabilitacion($this->_id)),
            );
        } else {
            $_paramBotonImprimir = array(
                'class' => 'btn dropdown-toggle btn-primary',
                'titulo' => 'Imprimir',
                'icono' => 'glyphicon glyphicon-print',
                'children' => array(0 => $this->_botonNotaPedido($fechaImpresion, $this->_id))
            );
        }
        return $_paramBotonImprimir;
    }
    
    private function _crearBotonLista()
    {
        $fechaImpresion='';
        $_paramBotonLista = array(
                'class' => 'btn dropdown-toggle btn-primary',
                'titulo' => 'Listas',
                'icono' => 'glyphicon glyphicon-th-list',
                'classIcono' => 'icono-imprimir32 dropdown',
                'children' => array(0 => $this->_bt->getParamBotonDirOSociales(),
                    1 => $this->_bt->getParamBotonDirTelefonico(),
                    2 => $this->_bt->getParamBotonLista()),
        ); 
        return $_paramBotonLista;
    }
    
    private function _botonNotaPedido($fechaImpresion, $id)
    {
        if ($this->_id == null) {
            $href_pedido = "index.php?option=pdf&sub=pedidosIps&getV=$fechaImpresion";
        } else {
            $href_pedido = "index.php?option=pdf&sub=pedidoIps&id=$id&getV=$fechaImpresion";
        }
        $retorno = array(
            'titulo' => 'NOTA PEDIDO IPS',
            'href' => $href_pedido,
            'icono' => 'glyphicon glyphicon-pencil',
            'children' => Array(),
        );
        return $retorno;
    }
    
    private function _botonConstanciaRehabilitacion($id)
    {
        $retorno = array(
                'titulo' => 'CONSTANCIA DE REHABILITACION',
                'href' => "index.php?option=pdfphsrl&sub=constanciaAsistenciaRegular&id=$id",
                'children' => Array(),
                'icono' => 'glyphicon glyphicon-file',
        );
        return $retorno;
    }
}
