<?php
require_once BASE_PATH . 'LibQ' . DS . 'BarraHerramientas.php';
require_once 'BotonesUsuarios.php';
require_once BASE_PATH . 'LibQ' . DS . 'Fechas.php';

/**
 * Description of BarraHerramientasPacientes
 *
 * @author WERD
 */
class BarraHerramientasUsuarios
{
    protected $_bh;
    protected $_id;
    protected $_bt;


    public function __construct($id='')
    {
        $this->_id = $id;
        $this->_bh = new LibQ_BarraHerramientas();;
        $this->_bt = new BotonesUsuarios();
    }

    public function getBarraHerramientasNuevo()
    {
        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonLista());
        $this->_bh->addBoton('Nuevo', $this->_bt->getParamBotonNuevo());
        return $this->_bh->render();
    }
    
    public function getBarraHerramientasListaOSocial()
    {
        $this->_bh->addBoton('DropDown', $this->_crearBotonLista());
        $this->_bh->addBoton('Nuevo', $this->_bt->getParamBotonNuevo());
        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());
        return $this->_bh->render();
    }
    
    public function getBarraHerramientasIndex()
    {
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());
        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
        $this->_bh->addBoton('Nuevo', $this->_bt->getParamBotonNuevo());
        $this->_bh->addBoton('Nuevo', $this->_bt->getParamBotonEditar());
        $this->_bh->addBoton('Eliminar', $this->_bt->getParamBotonEliminar());
        $this->_bh->addBoton('Permisos', $this->_bt->getParamBotonPermisos());        
        $this->_bh->addBoton('Imprimir', $this->_bt->getParamBotonImprimir());        
        return $this->_bh->render();
    }
    
    public function getBarraHerramientasEditar($id=null)
    {
        $this->_id = $id;
        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());
        $this->_bh->addBoton('Nuevo', $this->_bt->getParamBotonNuevo());
        return $this->_bh->render();
    }
}
