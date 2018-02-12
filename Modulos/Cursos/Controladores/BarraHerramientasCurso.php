<?php
require_once BASE_PATH . 'LibQ' . DS . 'BarraHerramientas.php';
require_once 'BotonesCurso.php';

/**
 * Description of BarraHerramientasCursos
 *
 * @author WERD
 */
class BarraHerramientasCurso
{
    protected $_bh;
    protected $_id;
    protected $_bt;


    public function __construct($id='')
    {
        $this->_id = $id;
        $this->_bh = new LibQ_BarraHerramientas();;
        $this->_bt = new BotonesCurso();
    }

    public function getBarraHerramientasNuevo()
    {
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());
        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
        $this->_bh->addBoton('Nuevo', $this->_bt->getParamBotonNuevo());
        $this->_bh->addBoton('Lista', $this->_bt->getParamBotonLista());
        $this->_bh->addBoton('Editar', $this->_bt->getParamBotonEditar());
        $this->_bh->addBoton('Eliminar', $this->_bt->getParamBotonEliminar());
        return $this->_bh->render();
    }
    
    public function getBarraHerramientasIndex()
    {
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());
        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
        $this->_bh->addBoton('Nuevo', $this->_bt->getParamBotonNuevo());
        $this->_bh->addBoton('Editar', $this->_bt->getParamBotonEditar());
        $this->_bh->addBoton('Eliminar', $this->_bt->getParamBotonEliminar());
        $this->_bh->addBoton('ListaAlumnos', $this->_bt->getParamBotonListaAlumnosJs());
        $this->_bh->addBoton('EditarLista', $this->_bt->getParamBotonEditarLista());
        $this->_bh->addBoton('Imprimir', $this->_bt->getParamBotonImprimir());                
        return $this->_bh->render();
    }
    
    public function getBarraHerramientasEditar($id=null)
    {
        $this->_id = $id;
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());
        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
        $this->_bh->addBoton('Nuevo', $this->_bt->getParamBotonNuevo());
        $this->_bh->addBoton('Lista', $this->_bt->getParamBotonLista());
        $this->_bh->addBoton('ListaAlumnos', $this->_bt->getParamBotonListaAlumnos($id));        
        $this->_bh->addBoton('Eliminar', $this->_bt->getParamBotonEliminar());
        $this->_bh->addBoton('Inscribir', $this->_bt->getParamBotonInscribir());        
        return $this->_bh->render();
    }
    
    public function getBarraHerramientasEditarLista()
    {
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());
        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
        $this->_bh->addBoton('Nuevo', $this->_bt->getParamBotonNuevo());
        $this->_bh->addBoton('Lista', $this->_bt->getParamBotonLista());
        $this->_bh->addBoton('Eliminar', $this->_bt->getParamBotonEliminar());
        $this->_bh->addBoton('Inscribir', $this->_bt->getParamBotonInscribir());        
        return $this->_bh->render();
    }
    
    public function getBarraHerramientasInscribir($id=null)
    {
        $this->_id = $id;
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());
        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
//        $this->_bh->addBoton('Nuevo', $this->_bt->getParamBotonNuevo());
//        $this->_bh->addBoton('Eliminar', $this->_bt->getParamBotonEliminar());
//        $this->_bh->addBoton('Inscribir', $this->_bt->getParamBotonInscribir());        
        return $this->_bh->render();
    }
    
    public function getBarraHerramientasListarAlumnos($id = null)
    {
        $this->_bh->addBoton('Inicio', $this->_bt->getParamBotonInicio());
        $this->_bh->addBoton('Volver', $this->_bt->getParamBotonVolver());
        $this->_bh->addBoton('Inscribir', $this->_bt->getParamBotonInscribir());        
//        $this->_bh->addBoton('Nuevo', $this->_bt->getParamBotonNuevo());
//        $this->_bh->addBoton('Editar', $this->_bt->getParamBotonEditar());
//        $this->_bh->addBoton('Eliminar', $this->_bt->getParamBotonEliminar());
//        $this->_bh->addBoton('ListaAlumnos', $this->_bt->getParamBotonListaAlumnosJs());
//        $this->_bh->addBoton('EditarLista', $this->_bt->getParamBotonEditarLista());
        $this->_bh->addBoton('Imprimir', $this->_bt->getParamBotonImprimirListaAlumnos($id));
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
