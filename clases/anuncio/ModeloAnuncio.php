<?php

class ModeloAnuncio{
    private $bd;
    private $tabla="anuncio";
    
    function __construct(BaseDatos $bd){
        $this->bd=$bd;
    }
    
    function add(Anuncio $objeto){
        $sql="insert into $this->tabla values(null, :titulo, :precio, :descripcion, :ciudad, :direccion, :habitaciones, :servicios, :longitud);";
        $parametros["titulo"]=$objeto->getTitulo();
        $parametros["precio"]=$objeto->getPrecio();
        $parametros["descripcion"]=$objeto->getDescripcion();
        $parametros["ciudad"]=$objeto->getCiudad();
        $parametros["direccion"]=$objeto->getDireccion();
        $parametros["habitaciones"]=$objeto->getHabitaciones();
        $parametros["servicios"]=$objeto->getServicios();
        $parametros["longitud"]=$objeto->getLongitud();
        $r=$this->bd->setConsulta($sql, $parametros);
        if(!$r){
            return -1;
        }
        return $this->bd->getNumeroFila();//0
    }
    
    function delete (Anuncio $objeto){
        $sql="delete from $this->tabla where idanuncio=:idanuncio";
        $parametros["idanuncio"]=$objeto->getIdanuncio();
        $r=$this->bd->setConsulta($sql, $parametros);
        if(!$r){
            return -1;
        }
        return $this->bd->getNumeroFila();//0
    }
    
    function deletePorIdanuncio($idanuncio){
        return $this->delete(new Anuncio($idanuncio));
    }
    
    function edit(Anuncio $objeto){
        $sql="update $this->tabla set titulo=:titulo, precio=:precio, descripcion=:descripcion, "
                . "ciudad=:ciudad, direccion=:direccion, habitaciones=:habitaciones, servicios=:servicios, longitud=:longitud "
                . "where idanuncio=:idanuncio;";
        $parametros["titulo"]=$objeto->getTitulo();
        $parametros["precio"]=$objeto->getPrecio();
        $parametros["descripcion"]=$objeto->getDescripcion();
        $parametros["ciudad"]=$objeto->getCiudad();
        $parametros["direccion"]=$objeto->getDireccion();
        $parametros["habitaciones"]=$objeto->getHabitaciones();
        $parametros["servicios"]=$objeto->getServicios();
        $parametros["longitud"]=$objeto->getLongitud();
        $parametros["idanuncio"]=$objeto->getIdanuncio();
        $r=$this->bd->setConsulta($sql, $parametros);
        if(!$r){
            return -1;
        }
        return $this->bd->getNumeroFila();//0
    }
    
    function editPK(Anuncio $objetoOriginal, Anuncio $objetoNuevo){
        $sql="update $this->tabla set titulo=:titulo, precio=:precio, descripcion=:descripcion, "
                . "ciudad=:ciudad, direccion=:direccion, habitaciones=:habitaciones, servicios=:servicios, longitud=:longitud "
                . "where idanuncio=:idanunciopk;";
        $parametros["titulo"]=$objeto->getTitulo();
        $parametros["precio"]=$objeto->getPrecio();
        $parametros["descripcion"]=$objeto->getDescripcion();
        $parametros["ciudad"]=$objeto->getCiudad();
        $parametros["direccion"]=$objeto->getDireccion();
        $parametros["habitaciones"]=$objeto->getHabitaciones();
        $parametros["servicios"]=$objeto->getServicios();
        $parametros["longitud"]=$objeto->getLongitud();
        $parametros["idanuncio"]=$objetoNuevo->getId();
        $parametros["idanunciopk"]=$objetoOriginal->getId();
        $r=$this->bd->setConsulta($sql, $parametros);
        if(!$r){
            return -1;
        }
        return $this->bd->getNumeroFila();//0
    }
    
    function get($idanuncio){
        $consultaSql = "select * from $this->tabla where idanuncio=:idanuncio";
        $arrayConsulta["idanuncio"]=$idanuncio;
        $resultado= $this->bd->setConsulta($consultaSql, $arrayConsulta);
        if($resultado){
            $anuncio= new Anuncio();
            $anuncio->set($this->bd->getFila());
            return $anuncio;
        }
        return null;
    }
    
    function count($condicion="1=1", $parametros=array()){
        $sql="select count(*) from $this->tabla where $condicion";
        $r=$this->bd->setConsulta($sql, $parametros);
        if(!$r){
            $variable = $this->bd->getFila();
            return $variable[0];
        }
        return -1;
    }
    
    function getAnuncios($pagina=0, $rpp=10, $condicion="1=1", $parametros=array(), $orderby=1){
        $list=array();
        $principio = $pagina*$rpp;
        $sql="select * from $this->tabla where $condicion order by $orderby limit $principio,$rpp";
        $r=$this->bd->setConsulta($sql, $parametros);
        if($r){
            while($fila=$this->bd->getFila()){
                $anuncio= new Anuncio();
                $anuncio->set($fila);
                $list[]=$anuncio;
            }
        } else{
            return null;
        }    
        return $list;
    }
    
    function selectHtml($idanuncio, $name, $condicion, $parametros, $valorSeleccionado="", $blanco=true, $textoBlanco="&nbsp;"){
        $select="<select name='$name' id='$id'>";
        if($blanco){
            $select.="<option value=''>$textoBlanco</option>";
        }
        $select.="</select>";
        return $select;
    }
    
}
