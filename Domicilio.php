<?php
/**
 * @version v2020_2
 * @author Martin Mata
 */
namespace Clases\Domicilio;

use Clases\MySql\Query;

class Domicilio extends Query
{
        
	function __construct($base_datos = BD_GENERAL)
	{
	    $this->base_datos = $base_datos;
		parent::__construct($base_datos);
		$this->selecionaBD($base_datos);
		try 
		{	
		    $url = __DIR__;
		    if ($resultado = $this->conexion->query("SHOW TABLES LIKE 'paises'"))
		    {
		        if ($resultado->num_rows == 0) $this->conexion->multi_query(file_get_contents($url."/Datos/paises.sql"));
		    }
		    if ($resultado = $this->conexion->query("SHOW TABLES LIKE 'estados'"))
		    {
		        if ($resultado->num_rows == 0) $this->conexion->multi_query(file_get_contents($url."/Datos/estados.sql"));
		    }
		    if ($resultado = $this->conexion->query("SHOW TABLES LIKE 'municipios'"))
		    {
		        if ($resultado->num_rows == 0) $this->conexion->multi_query(file_get_contents($url."/Datos/municipios.sql"));
		    }
		    if ($resultado = $this->conexion->query("SHOW TABLES LIKE 'colonias'"))
		    {
		        if ($resultado->num_rows == 0)
		        {
		            $this->conexion->multi_query(file_get_contents($url."/Datos/colonias.sql"));
		            $this->conexion->multi_query(file_get_contents($url."/Datos/colonias2.sql"));		           
		            $this->conexion->multi_query(file_get_contents($url."/Datos/colonias3.sql"));		            
		            $this->conexion->multi_query(file_get_contents($url."/Datos/colonias4.sql"));		            
		            $this->conexion->multi_query(file_get_contents($url."/Datos/colonias5.sql"));		            
		            $this->conexion->multi_query(file_get_contents($url."/Datos/colonias6.sql"));		            
		            $this->conexion->multi_query(file_get_contents($url."/Datos/colonias7.sql"));		            
		            $this->conexion->multi_query(file_get_contents($url."/Datos/colonias8.sql"));		            
		            $this->conexion->multi_query(file_get_contents($url."/Datos/colonias9.sql"));		            
		            $this->conexion->multi_query(file_get_contents($url."/Datos/colonias10.sql"));		            
		            $this->conexion->multi_query(file_get_contents($url."/Datos/colonias11.sql"));		            
		            $this->conexion->multi_query(file_get_contents($url."/Datos/colonias12.sql"));		            
		            $this->conexion->multi_query(file_get_contents($url."/Datos/colonias13.sql"));		            
		            $this->conexion->multi_query(file_get_contents($url."/Datos/colonias14.sql"));
		            
		        }
		    }
		}
		catch (\Exception $e) 
		{
		}			
	
	}
	/**
	 *
	 * @param string $cp
	 * 
	 */
	public function cp($cp)
	{
		$codigos = $this->consulta("*", "codigos", "CodCodigo = '$cp'");
		if(count($codigos)>0)
		    return $codigos[0];
		else return 0;
	}
    
    /**
     * 
     * 
     * @return string
     */
    public function paises()
    {       
        return $this->options("PaiCodigo as id, PaiNombre as nombre", 
            "paises","id","MEX");
    }
    
    /**
     *
     * @param string $pais
     * 
     * @return string
     */
    public function estados($pais)
    {
        return $this->options("EstCodigo as id, EstNombre as nombre", "estados","id", "0","EstPais = '$pais'");
    }

    /**
     * 
     * @param string $estado
     * @param string $municipio
     *  
     * @return string
     */
    public function municipios($estado, $municipio = 0)
    {
        return $this->options("MunCodigo as id, MunNombre as nombre", "municipios",
            "id","$municipio","MunEstado = '$estado'");
    }
    
    /**
     * 
     * @param string $estado
     * @param string $municipio
     * 
     * @return string
     */
    public function colonia($estado, $municipio)
    {        
        return $this->options("distinct ColCodigo as id, ColNombre as nombre",
            "municipios inner join codigos on MunCodigo = CodMunicipio inner join colonias on ColCp = CodCodigo",
            "id","0", "CodEstado = '$estado' AND MunCodigo = '$municipio'");
    }
    
    /**
     * regresa las colonias con el mismo codigo
     * @param string $cp
     *  
     * @return string
     */
    public function localidad($cp)
    {
        
        return $this->options("ColCp,ColCodigo as id, ColNombre as nombre", "colonias",
            "id",$cp,"ColCp like '$cp%'");
    }
    
    /**
     * 
     * @param string $codigo codigo de la colonia
     * @param string $nombre nombre de la colonia
     * 
     */
    public function coloniaCp($codigo,$nombre)
    {        
        $resultado = $this->consulta("ColCp","colonias",
            "ColCodigo = '$codigo' AND ColNombre = '$nombre'");
        if(count($resultado)>0)
            return $resultado[0]->ColCp;
        else return 0;
    }     
        
}