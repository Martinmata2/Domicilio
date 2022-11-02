<?php


use Cabeca\Domicilio\Domicilio;

/**
 * @version v2020_2
 * @author Martin Mata
 */
set_include_path(get_include_path() . PATH_SEPARATOR . realpath(dirname(__FILE__) . "/../../../"));

include_once 'autoload.php';
@session_start();

$DOMICILIO = new Domicilio();

/**
 * Regresa lista de paises
 */
if(isset($_POST["pais"]))
{
    echo $DOMICILIO->paises();	
}
/**
 * Regresa lista de colonias en municipio estado
 */
elseif (isset($_POST["colonia"]))
{
    echo $DOMICILIO->colonia($_POST["estado"], $_POST["municipio"]);
}
/**
 * Regresa todos los municipios en estado
 */
elseif (isset($_POST["estado"]) && isset($_POST["municipio"]))
{
    echo $DOMICILIO->municipios($_POST["estado"],$_POST["municipio"]);
}
/**
 * Regresa lista de estados en pais
 */
elseif (isset($_POST["estado"]))
{
    echo $DOMICILIO->estados($_POST["estado"]);
}
/**
 * Regresa datos asociados a cp
 */
elseif (isset($_POST["cp"]))
{
    echo json_encode($DOMICILIO->cp($_POST["cp"]));    
}
/**
 * Regresa municipio y estado asociados a localidad 
 */
elseif (isset($_POST["localidad"]))
{
    echo $DOMICILIO->localidad($_POST["localidad"]);    
}
/**
 * Regresa cp asociado a localidad
 */
elseif (isset($_POST["codigo"]))
{
    echo $DOMICILIO->coloniaCp($_POST["codigo"], $_POST["nombre"]);
}
else
    echo 0;