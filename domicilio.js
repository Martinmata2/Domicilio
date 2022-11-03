$(document).ready(function()
{
	var url = INICIO+"../Cabeca/Domicilio/Ajax/index.php";
	obtenerPaises("MEX");
	obtenerEstados("MEX");	    
	$("#CliCp").change(function()
	{
		$("#CliCp").addClass("loading_input");
		ajax_call(url,
				{
					cp : $("#CliCp").val()
				},				
			function(respuesta)
			{
				var datos = $.parseJSON(respuesta);				
				if(respuesta == 0)
	            {
					$("#CliCp").notify("El CP no se encuentra en la base de datos","info");
	            	$("#CliCp").addClass("errors");
	            	$("#CliCp").removeClass("loading_input");
	            }
	            else
	            {
	            	$("#CliCp").removeClass("loading_input");
	        		$("#CliCp").removeClass("errors");
		            $("#CliEstado").val(datos.CodEstado);	
		            obtenerMunicipios(datos.CodEstado,datos.CodMunicipio);
		            obtenerLocalidad( datos.CodCodigo);
		            	            				           
	            }
			},error,true);
	});

	function obtenerMunicipios(estado,municipio)
	{
		ajax_call(url,
				{estado:estado,municipio:municipio},				
				llenamunicipio, error, 	true);
	}
	function obtenerColonia(estado,municipio)
	{
		
		ajax_call(url,
				{colonia:0,estado:estado,municipio:municipio},		
				llenacolonia,error,true);		
	}
	function obtenerLocalidad(codigo)
	{
		ajax_call(url,
				{localidad:codigo},					
				llenalocalidades,error,true);
	}

	function obtenerCp(colonia, nombre)
	{	
		ajax_call(url,
				{codigo:colonia, nombre:nombre},					
				asignacp,error,true);
	}

	$("#CliPais").change(function()
	{
		obtenerEstados($(this).val());			 
	 });

	$("#CliEstado").change(function()
  	{		
	 		var estado = $(this).val();
    	 	var pais = $("#CliPais").val();
    	 	if(pais == "MEX")
    	 	{
    	 		obtenerMunicipios(estado,0);
    	 	}	    	
    });

	$("#CliMunicipio").change(function()
    {
		$("#CliMunicipio").addClass("loading_input");
		$("#CliMunicipio2").val($("#CliMunicipio option:selected").text());  	
			var pais = $("#CliPais").val();
    	 	var estado = $("#CliEstado").val();
    	 	var municipio = $(this).val();
    	 	if(pais == "MEX")
    	 	{
    	 		obtenerColonia(estado,municipio);
    	 	}	  
    	 	   
    });

	$("#CliColonia").change(function()
    {
    	var colonia = $(this).val();
    	var nombre = $("#CliColonia option:selected").text();
    	obtenerCp(colonia, nombre);		  
    	$("#CliColonia2").val(nombre); 
     });

   	function obtenerPaises(seleccionado)
   	{
   	   	ajax_call(url,
   	   		{pais : seleccionado},
   	 		llenapaises, error, true);
   	}

	function obtenerEstados(pais)
   	{
   	   	ajax_call(url,
   	   		{estado : pais},
   	 		llenaestados, error,true);
   	}     
   	function llenapaises(respuesta)
   	{   	      	   	
   		$("#CliPais").append(respuesta);
   	}
	function llenaestados(respuesta)
	{
		$("#CliEstado").find('option')
        .remove()
        .end()
        .append(respuesta);             
        $("#CliMunicipio").show();
        $("label[for='CliMunicipio']").text("Municipio");
       
        $("#CliMunicipio").show();
        $("#CliColonia").show();
           
	}
	function llenamunicipio(respuesta)
	{
		$("#CliMunicipio").find('option')
        .remove()
        .end()
        .append(respuesta);		
        
	}
	function llenacolonia(respuesta)
	{
		$("#CliCp").removeClass("errors");
        $("#CliColonia").find('option')
        .remove()
        .end()
        .append(respuesta);    
        $("#CliMunicipio").removeClass("loading_input");  
	}
	function llenalocalidades(respuesta)
	{
		$("#CliCp").removeClass("errors");
        $("#CliColonia").find('option')
        .remove()
        .end()
        .append(respuesta);           
	}
	
	function asignacp(respuesta)
	{
		$("#CliCp").val(respuesta);		
	}
	  
 
	function error(respuesta)
   	{
   		archiva_error(respuesta,"Domicilio", INICIO);
   	}   
   	
});