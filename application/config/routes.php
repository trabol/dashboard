<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['404_override']         = 'error404';
$route['default_controller']   = 'consultapagos';
$route['login']                = 'welcome/login';
$route['logout']               = 'welcome/logout';
$route['ajax/login']           = 'welcome/validarUser';
//$route['documentos']           = 'documentos';

$route['consultapagos']                = 'consultapagos';
$route['consultapagos/setExcel']       = 'consultapagos/setExcel';
$route['consultapagos/ver-traza']      = 'consultapagos/get_traza_proceso';
$route['consultapagos/login/(:any)']   = 'consultapagos/loginBPM/$1';

$route['tareas/expiradas']             = 'consultapagos/tareaExpiradas';
$route['tareas/expiradas/reemplazo']   = 'consultapagos/tareaExpiradasRemplazo';
$route['tareas/expiradas/update']      = 'consultapagos/UpdateTareaExpirada';

/*********************************************************************/

$route['mantenedor']                      = 'mantenedorController';
$route['mantenedor/centro-costos']        = 'mantenedorController/centroCostos';
$route['mantenedor/cargar-distribucion']  = 'mantenedorController/cargarDistribucion';
$route['mantenedor/cargar-distribucion/(:any)']  = 'mantenedorController/cargarDistribucion/$1';

/***************************************************************************************/

/**************************************************************************************/
$route['mantenedor/centro-costos/carga-masiva']        = 'mantenedorController/cargaMasiva';
$route['mantenedor/centro-costos/carga-masiva/(:any)'] = 'mantenedorController/cargaMasiva/$1';
$route['mantenedor/centro-costos/(:any)']              = 'mantenedorController/centroCostos/$1';

/***********************************************************************************************/
$route['mantenedor/cuentas-contables'] 		    		   = 'mantenedorController/cuentaContables';
$route['mantenedor/cuentas-contables/carga-masiva']        = 'mantenedorController/cuentas_cargaMasiva';
$route['mantenedor/cuentas-contables/carga-masiva/(:any)'] = 'mantenedorController/cuentas_cargaMasiva/$1';
$route['mantenedor/cuentas-contables/(:any)']              = 'mantenedorController/cuentaContables/$1';

/******************************************************************************************************/
$route['mantenedor/usuarios-bpm'] 			    = 'mantenedorController/usuariosBpm';
$route['mantenedor/usuarios-bpm/(:any)']        = 'mantenedorController/usuariosBpm/$1';
/******************************************************************************************************/
$route['mantenedor/proveedores/(:any)/(:any)'] 	        = 'mantenedorController/proveedores/$1/$2';
$route['mantenedor/proveedores/(:any)'] 		        = 'mantenedorController/proveedores/$1/';
$route['mantenedor/proveedores'] 			            = 'mantenedorController/proveedores';

$route['mantenedor/eliminar-casos'] 			        = 'mantenedorController/eliminarCasos';
$route['mantenedor/eliminar-casos/(:any)'] 			    = 'mantenedorController/eliminarCasos/$1';




/******************************************************************************************************/
$route['administracion/permisos/(:any)/(:any)'] = 'administracionController/permisos/$1/$2';
$route['administracion/permisos/(:any)']        = 'administracionController/permisos/$1';
$route['administracion/permisos']               = 'administracionController/permisos';
$route['administracion']                        = 'administracionController';

/*******************************************************************************************************/

$route['contabilidad/tarea-por-hacer/(:any)/(:any)/(:any)']  = 'contabilidadController/tareasPorHacer/$1/$2/$3';
$route['contabilidad/tarea-por-hacer/delegar'] 				 = 'contabilidadController/AJAX_delegarCasoBPM';
$route['contabilidad/tarea-por-hacer/(:any)']        	     = 'contabilidadController/tareasPorHacer/$1';
$route['contabilidad/tarea-por-hacer']               	     = 'contabilidadController/tareasPorHacer';


$route['contabilidad/historial-casos/(:any)/(:any)']   	     = 'contabilidadController/histotial_casos/$1/$2';
$route['contabilidad/historial-casos']               	     = 'contabilidadController/histotial_casos';
$route['contabilidad']                              		 = 'contabilidadController';

$route['mergeMasivo']                              		     = 'mergeMasivo';


/*******************************************************************************************************/
$route['translate_uri_dashes'] = FALSE;

