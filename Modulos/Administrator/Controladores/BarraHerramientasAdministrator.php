<?php
require_once BASE_PATH . 'LibQ' . DS . 'BarraHerramientas.php';
require_once 'BotonesAdministrator.php';
require_once BASE_PATH . 'LibQ' . DS . 'Fechas.php';

/**
 * Description of BarraHerramientasPacientes
 *
 * @author WERD
 */
class BarraHerramientasAdministrator
{
    protected $_bh;
    protected $_id;
    protected $_bt;


    public function __construct($id='')
    {
        $this->_id = $id;
        $this->_bh = new LibQ_BarraHerramientas();;
        $this->_bt = new BotonesAdministrator();
    }

    
    public function getBarraHerramientasIndex()
    {
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());
        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
        $this->_bh->addBoton('Iva', $this->_bt->getParamBotonIva());
        $this->_bh->addBoton('Modulos', $this->_bt->getParamBotonModulos());
        $this->_bh->addBoton('Puestos', $this->_bt->getParamBotonPuestos());
        return $this->_bh->render();
    }
    
    public function getBarraHerramientasIva()
    {
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());
        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
        $this->_bh->addBoton('Nuevo', $this->_bt->getParamBotonNuevo());
        $this->_bh->addBoton('Editar', $this->_bt->getParamBotonEditar());        
        $this->_bh->addBoton('Eliminar', $this->_bt->getParamBotonEliminar());
        $this->_bh->addBoton('Lista', $this->_bt->getParamBotonLista());        
        $this->_bh->addBoton('Imprimir', $this->_bt->getParamBotonImprimirIva());                        
        return $this->_bh->render();
    }
    
    public function getBarraHerramientasModulos()
    {
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());
        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
        $this->_bh->addBoton('Nuevo', $this->_bt->getParamBotonNuevoModulo());
        $this->_bh->addBoton('Editar', $this->_bt->getParamBotonEditarModulo());        
        $this->_bh->addBoton('Eliminar', $this->_bt->getParamBotonEliminarModulo());
        $this->_bh->addBoton('Lista', $this->_bt->getParamBotonListaModulo());        
        $this->_bh->addBoton('Imprimir', $this->_bt->getParamBotonImprimirModulos());                        
        return $this->_bh->render();
    }
    
    public function getBarraHerramientasPuestos()
    {
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());        
        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
        $this->_bh->addBoton('Nuevo', $this->_bt->getParamBotonNuevoPuesto());
        $this->_bh->addBoton('Editar', $this->_bt->getParamBotonEditarPuesto());        
        $this->_bh->addBoton('Eliminar', $this->_bt->getParamBotonEliminarPuesto());
        $this->_bh->addBoton('Lista', $this->_bt->getParamBotonListaPuestos());        
        $this->_bh->addBoton('Imprimir', $this->_bt->getParamBotonImprimirPuestos());                        
        return $this->_bh->render();
    }
}
