<?php
class Academico_model extends CI_Model
{
	public function __construct() 
	{
		$this->load->database();
	}
	
	
	public function load_data()
	{
		require_once("assets/excel/Classes/PHPExcel/IOFactory.php");
		$nombreArchivo = 'C:\xampp\htdocs\ACADEMOS\assets\excel\libro.xlsx';
		// Cargo la hoja de cálculo
		$objPHPExcel = PHPExcel_IOFactory::load($nombreArchivo);
		//Asigno la hoja de calculo activa
		$objPHPExcel->setActiveSheetIndex(0);
		//Obtengo el numero de filas del archivo
		$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
		$id_carrera = 5;
		for($i = 2; $i <= $numRows; $i++){
			$nivel_materia=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
			$nombre_materia=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
			$carrera=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
			$codigo_materia=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
			$creditos_materia=$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
			//inserto primero en la tabla carrera
			$data = array();
			$data['NOMBRE'] = $nombre_materia;
			//$this->db->insert('acad_materia', $data);
			//$id_materia_generado = $this->db->insert_id();
			//inserto en carrera_materia
			$data1 = array();
			$data1['ID_MATERIA'] = $id_materia_generado;
			$data1['ID_CARRERA'] = $id_carrera;
			$data1['CREDITOS_MATERIA'] = $creditos_materia;
			$data1['CODIGO_MATERIA'] = $codigo_materia;
			$data1['NIVEL_MATERIA'] = $nivel_materia;
			//$this->db->insert('acad_carrera_materia', $data1);
		}
	}
	
	
	public function getpersona($idusuario)
	{
		$periodo= $this->academico_model->get_periodo_activado();
		$sql = "select ID_PERSONA ";
		$sql .= "from  admin_usuarios where ID_USUARIO=".$idusuario;
		$query = $this->db->query($sql);
		$ds = $query->row_array();
		return $ds['ID_PERSONA'];               
	}


	public function crearGrupoCarrera($nombreGrupo)
	{
		$existe = $this->buscarGrupoCarreraPorNombre($nombreGrupo);
		if($existe){
			return false;
		}else{
			$this->db->insert('acad_grupo_carrera', array('NOMBRE_GRUPO_CARRERA'=>$nombreGrupo));
			return true;
		}
	}


	public function buscarGrupoCarreraPorNombre($nombreGrupo)
	{
		$this->db->select('*');
		$this->db->from('acad_grupo_carrera');
		$this->db->where('NOMBRE_GRUPO_CARRERA', $nombreGrupo);
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)>0)
			return true;
		else
			return false;
	}
	

	public function buscarGruposCarrera() 
	{
		$this->db->select('*');
		$this->db->from('acad_grupo_carrera');
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)>0){
			$grupos="";
			for($i=0;$i<count($ds);$i++){
				$grupos.=$ds[$i]['NOMBRE_GRUPO_CARRERA']." - ";
			}
			$grupos = substr($grupos, 0, strlen($grupos)-2);
			return $grupos;
		}else{
			return false;
		}
	}
	
	// **************************************************************************************
	public function crearTipoCarrera($tipo)
	{
		$existe = $this->buscarTipoCarrera($tipo);
		if($existe){
			return false;
		}else{
			$this->db->insert('acad_tipo_carrera', array('TIPO_CARRERA'=>$tipo));
			return true;
		}
	}
	

	public function buscarTipoCarrera($tipo)
	{
		$this->db->select('*');
		$this->db->from('acad_tipo_carrera');
		$this->db->where('TIPO_CARRERA', $tipo);
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)>0)
			return true;
		else
			return false;
	}
	

	public function buscarTiposCarrera() 
	{
		$this->db->select('*');
		$this->db->from('acad_tipo_carrera');
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)>0){
			$tipos="";
			for($i=0;$i<count($ds);$i++){
				$tipos.=$ds[$i]['TIPO_CARRERA']." - ";
			}
			$tipos = substr($tipos, 0, strlen($tipos)-2);
			return $tipos;
		}else{
			return false;
		}
	}
	
	// **************************************************************************************
	public function crearModalidad($modalidad)
	{
		$existe = $this->buscarModalidadEstudio($modalidad);
		if($existe){
			return false;
		}else{
			$this->db->insert('acad_modalidad', array('MODALIDAD'=>$modalidad));
			return true;
		}
	}
	

	public function buscarModalidadEstudio($modalidad)
	{
		$this->db->select('*');
		$this->db->from('acad_modalidad');
		$this->db->where('MODALIDAD', $modalidad);
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)>0)
			return true;
		else
			return false;
	}
	

	public function buscarModalidadesEstudio() 
	{
		$this->db->select('*');
		$this->db->from('acad_modalidad');
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)>0){
			$modalidades="";
			for($i=0;$i<count($ds);$i++){
				$modalidades.=$ds[$i]['MODALIDAD']." - ";
			}
			$modalidades = substr($modalidades, 0, strlen($modalidades)-2);
			return $modalidades;
		}else{
			return false;
		}
	}
	
	// **************************************************************************************
	public function crearSistemaEstudio($sistema)
	{
		$existe = $this->buscarSistemaEstudio($sistema);
		if($existe){
			return false;
		}else{
			$this->db->insert('acad_sistema_estudio', array('SISTEMA_ESTUDIO'=>$sistema));
			return true;
		}
	}
	

	public function buscarSistemaEstudio($sistema)
	{
		$this->db->select('*');
		$this->db->from('acad_sistema_estudio');
		$this->db->where('SISTEMA_ESTUDIO', $sistema);
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)>0)
			return true;
		else
			return false;
	}
	

	public function buscarSistemasEstudio() 
	{
		$this->db->select('*');
		$this->db->from('acad_sistema_estudio');
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)>0){
			$sistemas="";
			for($i=0;$i<count($ds);$i++){
				$sistemas.=$ds[$i]['SISTEMA_ESTUDIO']." - ";
			}
			$sistemas = substr($sistemas, 0, strlen($sistemas)-2);
			return $sistemas;
		}else{
			return false;
		}
	}
	
	// **************************************************************************************
	public function crearSede($sede)
	{
		$existe = $this->buscarSede($sede);
		if($existe){
			return false;
		}else{
			$this->db->insert('acad_sede', array('SEDE'=>$sede));
			return true;
		}
	}
	

	public function buscarSede($sede)
	{
		$this->db->select('*');
		$this->db->from('acad_sede');
		$this->db->where('SEDE', $sede);
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)>0)
			return true;
		else
			return false;
	}
	

	public function buscarSedes() 
	{
		$this->db->select('*');
		$this->db->from('acad_sede');
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)>0){
			$sedes="";
			for($i=0;$i<count($ds);$i++){
				$sedes.=$ds[$i]['SEDE']." - ";
			}
			$sedes = substr($sedes, 0, strlen($sedes)-2);
			return $sedes;
		}else{
			return false;
		}
	}
	
	// **************************************************************************************
	public function crearArea($area)
	{
		$existe = $this->buscarArea($area);
		if($existe){
			return false;
		}else{
			$this->db->insert('acad_area_estudio', array('AREA_ESTUDIO'=>$area));
			return true;
		}
	}
	

	public function buscarArea($area)
	{
		$this->db->select('*');
		$this->db->from('acad_area_estudio');
		$this->db->where('AREA_ESTUDIO', $area);
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)>0)
			return true;
		else
			return false;
	}
	

	public function buscarAreas() 
	{
		$this->db->select('*');
		$this->db->from('acad_area_estudio');
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)>0){
			$areas="";
			for($i=0;$i<count($ds);$i++){
				$areas.=$ds[$i]['AREA_ESTUDIO']." - ";
			}
			$areas = substr($areas, 0, strlen($areas)-2);
			return $areas;
		}else{
			return false;
		}
	}
	
	// **************************************************************************************
	public function crearPeriodo($fecha_inicio, $fecha_fin)
	{
		$existe = $this->buscarPeriodo($fecha_inicio, $fecha_fin);
		if($existe){
			//return false;
			return 0;
		}else{
			$this->db->insert('acad_periodo_academico', array('FECHA_INICIO'=>$fecha_inicio,'FECHA_FIN'=>$fecha_fin));
			//return true;
			return $this->db->insert_id();
		}
	}
	

	public function buscarPeriodo($fecha_inicio, $fecha_fin)
	{
		$this->db->select('*');
		$this->db->from('acad_periodo_academico');
		$this->db->where('FECHA_INICIO', $fecha_inicio);
		$this->db->where('FECHA_FIN', $fecha_fin);
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)>0)
			return true;
		else
			return false;
	}
	

	public function perido_calificaciones_activo()
	{
		$this->db->select('VALOR');
		$this->db->from('acad_parametro');
		$this->db->where('ID_PARAMETRO', 10);
		$query = $this->db->get();
		$ds = $query->row_array();
		$valor = $ds['VALOR'];
		if(intval($valor)==1)
			return "activado";
		else
			return "desactivado";
	}
	

	public function buscarPeriodos() 
	{
		$this->db->select('*');
		$this->db->from('acad_periodo_academico');
		$this->db->order_by('FECHA_INICIO','ASC');
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)>0){
			$periodos="";
			$p_activado = $this->get_periodo_activado();
			for($i=0;$i<count($ds);$i++){
				$select='';
				if(($ds[$i]['ID_PERIODO_ACADEMICO']==$p_activado) or ($p_activado==false and $i==0)){
					$select='checked';
				}
				$periodos.='<label class="opcion"><input type="radio" value="'.$ds[$i]['ID_PERIODO_ACADEMICO'].'" name="period" '.$select.'> ';
				$periodos.= "<strong>Desde: </strong> ".$ds[$i]['FECHA_INICIO']." <strong>Hasta: </strong>".$ds[$i]['FECHA_FIN']."</label><br>";
			}	
			return $periodos;  
		}else{
			return false;
		}
	}
	
	// **************************************************************************************
	public function activarPeriodoCalificaciones($activar)
	{
		$data = array();
		$data['VALOR'] = $activar;
		$this->db->where('acad_parametro.ID_PARAMETRO', 10);
		$this->db->update('acad_parametro', $data);
	}
	

	public function activarPeriodo($id,$idm=0)
	{
		$data = array();
		$data['VALOR'] = $id;
		$this->db->where('acad_parametro.ID_PARAMETRO', 8);
		$this->db->update('acad_parametro', $data);
		
		$data['VALOR'] = $idm;
		$this->db->where('NOMBRE', 'id_periodo_matricula');
		$this->db->update('acad_parametro', $data);
		
		return true;
	}
	

	public function get_periodo_activado() 
	{
		$this->db->select('VALOR');
		$this->db->from('acad_parametro');
		$this->db->where('acad_parametro.ID_PARAMETRO', 8);
		$query = $this->db->get();
		$ds = $query->row_array();
		if($this->session->userdata('id_periodo')>0){
			return $this->session->userdata('id_periodo');
		}elseif (count($ds)>0){
			return $ds['VALOR'];
		}else{
			return false;
		}
	}


	public function get_periodos_academicos($m=0) 
	{
		if($m>0){
			$id_periodo_activado = $m;
		}else{
			$id_periodo_activado = $this->academico_model->get_periodo_activado();
		}
		$this->db->select('*');
		$this->db->from('acad_periodo_academico');
		if($id_periodo_activado!=false){
			$this->db->where('acad_periodo_academico.ID_PERIODO_ACADEMICO', $id_periodo_activado);
		}
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	

	public function get_niveles($id_nivel=null) 
	{
		$this->db->select('*');
		$this->db->from('acad_nivel');
		if($id_nivel!=null){
			$this->db->where('ID_NIVEL',$id_nivel);
		}
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	

	public function get_grupos_carrera() 
	{
		$this->db->select('*');
		$this->db->from('acad_grupo_carrera');
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}


	public function get_grupos_carrera_nivel($id_carrera, $id_nivel) 
	{
		$sql="SELECT ac.NOMBRE as CARRERA, an.NIVEL as NIVEL, ag.NOMBRE as NOMBRE, ac.ID_CARRERA as ID_CARRERA, an.ID_NIVEL as ID_NIVEL, ag.ID_NIVEL as ID_GRUPO from acad_grupo ag ";
		$sql.="INNER JOIN acad_carrera ac ON ac.ID_CARRERA= ag.ID_CARRERA ";
		$sql.="INNER JOIN acad_nivel an ON an.ID_NIVEL= ag.ID_NIVEL ";
		$sql.="WHERE ag.ID_CARRERA=".$id_carrera." and ag.ID_NIVEL=".$id_nivel;
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		return $ds;
	}
	

	public function get_tipos_carrera() 
	{
		$this->db->select('*');
		$this->db->from('acad_tipo_carrera');
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	

	public function get_areas_estudio() 
	{
		$this->db->select('*');
		$this->db->from('acad_area_estudio');
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	

	public function get_sedes() 
	{
		$this->db->select('*');
		$this->db->from('acad_sede');
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	

	public function get_sistemas_estudio() 
	{
		$this->db->select('*');
		$this->db->from('acad_sistema_estudio');
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	

	public function get_modalidades() 
	{
		$this->db->select('*');
		$this->db->from('acad_modalidad');
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	// **************************************************************************************
	// CARRERA
	public function obtener_datos_carrera($idCarrera)
	{
		$this->db->select('*');
		$this->db->from('acad_carrera');
		$this->db->where('ID_CARRERA', $idCarrera);
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds;
	}
	

	public function buscarCarrera($nombre, $codigo)
	{
		$this->db->select('*');
		$this->db->from('acad_carrera');
		if($nombre!="" && $nombre!=NULL){
			$this->db->where('NOMBRE like', '%'.$nombre.'%');
		}
		if($codigo!="" && $codigo!=NULL){
			$this->db->where('CODIGO like', '%'.$codigo.'%');
		}
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)>0)
			return $ds;
		else
			return false;
	}
	

	public function crearActualizarCarrera($data)
	{
		$this->db->trans_start();
		$data['PARAMETRO']=1;
		$menciones=$data['menciones'];
		unset($data['menciones']);
		if(isset($data['ID_CARRERA']) && $data['ID_CARRERA'] != NULL){
			//actualizo
			$this->db->where('acad_carrera.ID_CARRERA', $data['ID_CARRERA']);
			$this->db->update('acad_carrera', $data);
			$id_carrera=$data['ID_CARRERA'];
		}else{
			//la creo
			unset($data['ID_CARRERA']);
			$this->db->insert('acad_carrera', $data);
			$id_carrera=$this->db->insert_id();
		}
		//vincular carrera a grupos
		$grupos=$this->buscar_grupos_estudiantes();
		foreach($grupos as $g){
			for($i=1; $i<=$data['DURACION_EN_NIVELES'];$i++){
				$id_grupo=$this->get_id_grupo($g['NOMBRE'],$id_carrera,$i);
				if($id_grupo==0){
					$this->db->insert('acad_grupo', array('NOMBRE'=>$g['NOMBRE'],'ID_CARRERA'=>$id_carrera,'ID_NIVEL'=>$i,'ID_SEDE'=>$g['ID_SEDE']));
				}
			}
		} 
		//registrar menciones
		$this->borrar_mencion_carrera($id_carrera);
		if(isset($menciones)){
			foreach($menciones as $m){
				$this->crear_mencion_carrera(array('ID_CARRERA'=>$id_carrera,'ID_MENCION'=>$m));
			}
		}
		$this->db->trans_complete();
	}
	

	public function get_carreras($idCarrera=null,$ids_carrera=array(),$con_extracurricular=0)
	{
		$this->db->select('*');
		$this->db->from('acad_carrera');
		if($idCarrera!=NULL and $idCarrera>0){
			$this->db->where('ID_CARRERA',$idCarrera);
		}
		if(count($ids_carrera)>0){
			$this->db->where_not_in('ID_CARRERA',$ids_carrera);
		}
		if($con_extracurricular==1){
			$this->db->where('ID_CARRERA in (select ID_CARRERA from acad_carrera_materia where NIVEL_MATERIA=6)');
		}
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	// **************************************************************************************
	// MATERIA
	public function guardar_prerequisitos($id_materia, $data)
	{
		//elimino los prerequisitos que estaban asociados, y creo los q se marcaron en pantalla
		$this->db->where('ID_CARRERA_MATERIA', $id_materia);
		$this->db->delete('acad_prerequisito');
		for($i=0; $i<count($data);$i++){
			$id_carrera_materia_prerequisito = $data[$i];
			$data_aux = array();
			$data_aux['ID_CARRERA_MATERIA'] = $id_materia;
			$data_aux['ID_CARRERA_MATERIA_PREREQUISITO'] = $id_carrera_materia_prerequisito;
			$this->db->insert('acad_prerequisito', $data_aux);
		}
	}
	
	
	public function get_prerequisitos($id_carrera_materia)
	{
		/*$sql="SELECT p.ID_CARRERA_MATERIA_PREREQUISITO from acad_materia m ";
		$sql.=" inner join acad_carrera_materia cm on m.ID_MATERIA = cm.ID_MATERIA ";
		$sql.=" inner join acad_prerequisito p on p.ID_CARRERA_MATERIA = cm.ID_CARRERA_MATERIA ";
		$sql.=" where cm.ID_CARRERA_MATERIA=".$id_carrera_materia;*/
		$sql="SELECT p.ID_CARRERA_MATERIA_PREREQUISITO, m.NOMBRE as MATERIA from acad_prerequisito p ";
		$sql.=" inner join acad_carrera_materia cm on p.ID_CARRERA_MATERIA_PREREQUISITO = cm.ID_CARRERA_MATERIA ";
		$sql.=" inner join acad_materia m on m.ID_MATERIA = cm.ID_MATERIA ";
		$sql.=" where p.ID_CARRERA_MATERIA=".$id_carrera_materia;
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		return $ds;
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		return $ds;
	}
	
	
	public function obtener_materias_nivel_anterior($idMateria)
	{
		$sql="SELECT m.NOMBRE, cm.NIVEL_MATERIA,cm.CODIGO_MATERIA,cm.ID_CARRERA_MATERIA,cm.CREDITOS_MATERIA from acad_materia m ";
		$sql.="inner join acad_carrera_materia cm on m.ID_MATERIA = cm.ID_MATERIA ";
		$sql.="where cm.NIVEL_MATERIA<= ";
		$sql.="(SELECT cm.NIVEL_MATERIA from  ";
		$sql.="acad_materia m inner join acad_carrera_materia cm on m.ID_MATERIA = cm.ID_MATERIA ";
		$sql.="where cm.ID_CARRERA_MATERIA=".$idMateria.")-1 ";
		$sql.="and cm.ID_CARRERA = ";
		$sql.="(SELECT cm.ID_CARRERA from  ";
		$sql.="acad_materia m inner join acad_carrera_materia cm on m.ID_MATERIA = cm.ID_MATERIA ";
		$sql.="where cm.ID_CARRERA_MATERIA=".$idMateria.")";
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		return $ds;
	} 
	  

	public function obtener_datos_materia($idMateria)
	{
		$this->db->select('*');
		$this->db->from('acad_materia');
		$this->db->join('acad_carrera_materia', 'acad_materia.ID_MATERIA = acad_carrera_materia.ID_MATERIA');
		$this->db->where('acad_carrera_materia.ID_CARRERA_MATERIA', $idMateria);
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds;
	}
	

	public function crearActualizarMateria($data)
	{
		$this->db->trans_start();
		if(isset($data['ID_MATERIA']) && $data['ID_MATERIA'] != NULL){
			//actualizo primero en la tabla materia
			$data_materia = array();
			$data_materia['NOMBRE']=$data['NOMBRE'];
			$this->db->where('acad_materia.ID_MATERIA', $data['ID_MATERIA']);
			$this->db->update('acad_materia', $data_materia);
			//actualizo acad_carrera_materia
			unset($data['NOMBRE']);
			unset($data['PRE']);
			$this->db->where('acad_carrera_materia.ID_MATERIA', $data['ID_MATERIA']);
			$this->db->update('acad_carrera_materia', $data);
			$id_materia_generado=$data['ID_MATERIA'];
		}else{
			//la creo
			unset($data['ID_MATERIA']);
			unset($data['PRE']);
			//inserto primero en la tabla materia
			$data_acad_materia = array();
			$data_acad_materia['NOMBRE'] = $data['NOMBRE'];
			unset($data['NOMBRE']);
			$this->db->insert('acad_materia', $data_acad_materia);
			$id_materia_generado = $this->db->insert_id();
			//inserto en carrera_materia
			$data['ID_MATERIA'] = $id_materia_generado;
			$this->db->insert('acad_carrera_materia', $data);
		}
		$this->db->trans_complete();
		return $id_materia_generado;
	}
	

	public function buscarMateria($nombre, $codigo, $carrera)
	{
		$this->db->select('*');
		$this->db->from('acad_materia');
		$this->db->join('acad_carrera_materia', 'acad_materia.ID_MATERIA = acad_carrera_materia.ID_MATERIA');
		if($nombre!="" && $nombre!=NULL){
			$this->db->where('NOMBRE like', '%'.$nombre.'%');
		}
		if($codigo!="" && $codigo!=NULL){
			$this->db->where('CODIGO_MATERIA like', '%'.$codigo.'%');
		}
		if($carrera!="" && $carrera!=NULL){
			$this->db->where('acad_carrera_materia.ID_CARRERA', $carrera);
		}
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)>0)
			return $ds;
		else
			return false;
	}

	// **************************************************************************************
	// INSCRIPCION
	public function get_datos_inscripcion($id_cliente) 
	{
		$sql = "select CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as APELLIDOS, ";
		$sql .= "CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as NOMBRES, ";
		$sql .= "p.EST_COLEGIO_GRADUACION, p.EST_TITULO_BACHILLER ";
		$sql .= " from tab_personas p inner join tab_clientes_naturales cn on p.ID_PERSONA = cn.ID_PERSONA ";
		$sql .= " inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION where p.OCUPACION=1 and cn.ID_CLIENTE=".$id_cliente;
		$query = $this->db->query($sql);
		$ds = $query->row_array(); 
		return $ds;
	}
	

	public function obtener_datos_inscripcion($id_cliente)
	{
		$id_periodo_activado = $this->academico_model->get_periodo_activado();
		$sql = "select i.ID_CARRERA, i.ID_NIVEL, i.ID_MENCION, i.ID_PERIODO_ACADEMICO, i.ID_MODALIDAD, i.ID_INSCRIPCION, CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as APELLIDOS, i.ID_SEDE, ";
		$sql .= "CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as NOMBRES, ";
		$sql .= "p.EST_COLEGIO_GRADUACION, p.EST_TITULO_BACHILLER, i.OBSERVACIONES ";
		$sql .= " from tab_personas p inner join tab_clientes_naturales cn on p.ID_PERSONA = cn.ID_PERSONA ";
		$sql .= " inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION ";
		$sql .= " inner join acad_inscripcion i on i.ID_PERSONA = p.ID_PERSONA where p.OCUPACION=1 and cn.ID_CLIENTE=".$id_cliente;
		//$sql .= " and i.ID_CARRERA not in (select ID_CARRERA from acad_matricula where ID_PERSONA in (select ID_PERSONA from tab_clientes_naturales where ID_CLIENTE=".$id_cliente.") and ID_PERIODO_ACADEMICO=".$id_periodo_activado." and ESTADO<>3)";
		//$sql .= " and i.ID_PERIODO_ACADEMICO=".$id_periodo_activado;
		$query = $this->db->query($sql);
		$ds = $query->row_array(); 
		return $ds;
	}
	

	public function crearActualizarInscripcion($data)
	{
		$this->db->trans_start();
		//obtengo el id como persona
		$this->db->select('ID_PERSONA');
		$this->db->from('tab_clientes_naturales');
		$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
		$query = $this->db->get();
		$ds = $query->row_array();
		$id_persona = $ds['ID_PERSONA'];
		//la pongo como inscrita
		$data_persona = array();
		$data_persona['FUE_INSCRITA']=1;
		$this->db->where('tab_personas.ID_PERSONA', $id_persona);
		$this->db->update('tab_personas', $data_persona);
		//verifico si tiene asociado el rubro de inscripcion
		$this->db->select('*');
		$this->db->from('fac_clientes_rubros');
		$this->db->join('fac_rubros', 'fac_rubros.ID_RUBRO = fac_clientes_rubros.ID_RUBRO');
		$this->db->where('ID_TIPO_RUBRO', 1);
		$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)==0){
			$resultado = $this->obtener_rubros(1); //RUBROS de INSCRIPCION
			$this->load->model('facturacion/servicios_model');
			foreach ($resultado as $res){
				$this->servicios_model->asociarRubrosAClientes(array(
					'idRubro' => $res->ID_RUBRO,
					'idCliente' =>  $data['ID_CLIENTE'],
					'idPeriodo' => $this->get_periodo_activado(),
					'idPlan' => 4,
					'idCarrera' => $data['ID_CARRERA'],
					'idSemestre' => $data["ID_NIVEL"],
					'nroItems' => 1,
					'aplicarRecargoGeneracion' => FALSE
				));                    
			}            
		}else{
			for($i=0; $i < count($ds); $i++){ 
				$id_clte_rubro = $ds[$i]['ID_CLIENTE_RUBRO'];
				$this->db->where('ID_CLIENTE_RUBRO', $id_clte_rubro);
				$this->db->delete('fac_clientes_rubros_cuota'); 
				$this->db->where('ID_CLIENTE_RUBRO', $id_clte_rubro);
				$this->db->delete('fac_clientes_rubros');  
				$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
				$this->db->delete('fac_cuotas_generales');     
			}           
			$resultado = $this->obtener_rubros(1); //RUBROS de INSCRIPCION
			$this->load->model('facturacion/servicios_model');
			foreach($resultado as $res){
				$this->servicios_model->asociarRubrosAClientes(array(
					'idRubro' => $res->ID_RUBRO,
					'idCliente' =>  $data['ID_CLIENTE'],
					'idPeriodo' => $this->get_periodo_activado(),
					'idPlan' => 4,
					'idCarrera' => $data['ID_CARRERA'],
					'idSemestre' => $data["ID_NIVEL"],
					'nroItems' => 1,
					'aplicarRecargoGeneracion' => FALSE
				));                    
			} 
		}
		if(isset($data['ID_INSCRIPCION']) && $data['ID_INSCRIPCION'] != NULL){
			//actualizo 
			$data['ID_PERSONA']=$id_persona;
			$data['FECHA']= date("Y-m-d");
			unset($data['NOMBRES']);
			unset($data['APELLIDOS']);
			unset($data['COLEGIO']);
			unset($data['TITULO']);
			unset($data['ID_CLIENTE']);
			$this->db->where('acad_inscripcion.ID_INSCRIPCION', $data['ID_INSCRIPCION']);
			$this->db->update('acad_inscripcion', $data);
			$resultado="Inscripcion Actualizada";
		}else{
			//la creo
			$data['ID_PERSONA']=$id_persona;
			$data['FECHA']= date("Y-m-d");
			unset($data['NOMBRES']);
			unset($data['APELLIDOS']);
			unset($data['COLEGIO']);
			unset($data['TITULO']);
			unset($data['ID_CLIENTE']);
			unset($data['ID_INSCRIPCION']);
			$this->db->insert('acad_inscripcion', $data);
			$resultado="Inscripcion Creada";
		}
		$this->db->trans_complete();
		return $resultado;
	}
	

	public function buscarEstudiantes($ap, $am, $pn, $sn, $id_carrera, $id_nivel, $id_modalidad, $fi, $ff)
	{
		$id_periodo_activado = $this->academico_model->get_periodo_activado();
		$nd = trim($this->input->post('nd'));         
		$sql = "select i.PAGADA, p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE, p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,i.ID_PERSONA,cn.ID_CLIENTE ";
		$sql .= "from tab_personas p inner join tab_clientes_naturales cn on cn.ID_PERSONA = p.ID_PERSONA ";
		$sql .= "inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION left join acad_inscripcion i on i.ID_PERSONA = p.ID_PERSONA ";
		$sql.= " left join tab_clientes c on c.ID_CLIENTE = cn.ID_CLIENTE ";
		//$sql .= " where o.ID_OCUPACION=1 and (i.ID_PERIODO_ACADEMICO IS NULL or i.ID_PERIODO_ACADEMICO=".$id_periodo_activado.") ";
		$sql .= " where o.ID_OCUPACION=1";
		if($ap!="" && $ap!=null)
			$sql .=" and p.APELLIDO_PATERNO like '%".$ap."%' " ;
		if($am!="" && $am!=null)
			$sql .=" and p.APELLIDO_MATERNO like '%".$am."%' " ;
		if($pn!="" && $pn!=null)
			$sql .=" and p.PRIMER_NOMBRE like '%".$pn."%' " ;
		if($sn!="" && $sn!=null)
			$sql .=" and p.SEGUNDO_NOMBRE like '%".$sn."%' " ;		
		if($nd!="" && $nd!=null)
			$sql .=" and c.NRO_DOCUMENTO = '".$nd."' " ;
		if($id_carrera!="" && $id_carrera!=null)
			$sql .=" and i.ID_CARRERA=".$id_carrera;
		if($id_modalidad!="" && $id_modalidad!=null)
			$sql .=" and i.ID_MODALIDAD=".$id_modalidad;
		if($id_nivel!="" && $id_nivel!=null)
			$sql .=" and i.ID_NIVEL=".$id_nivel;
		if($fi!="") 
			 $sql .= " and DATE(i.FECHA) >= '".$fi."'";
		if($ff!="") 
			 $sql .= " and DATE(i.FECHA) <= '".$ff."'";
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		if(count($ds)>0)
			return $ds;
		else
			return false;
	}
	// **************************************************************************************
	// MATRICULA
   /* public function buscarEstudiantesMatriculados($ap, $am, $pn, $sn, $id_carrera, $id_nivel, $id_modalidad, $fi, $ff)
	{
		$id_periodo_activado = $this->academico_model->get_periodo_activado();
		 
		$sql ="select i.PAGADA, mat.ID_MATRICULA, p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE, p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,i.ID_PERSONA,cn.ID_CLIENTE ";
		$sql.= "from tab_personas p inner join tab_clientes_naturales cn on cn.ID_PERSONA = p.ID_PERSONA ";
		$sql.= "left join acad_inscripcion i on i.ID_PERSONA = p.ID_PERSONA  inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION ";
		$sql.= " left join acad_matricula mat on mat.ID_PERSONA = p.ID_PERSONA ";
		$sql.= " WHERE o.ID_OCUPACION=1 and p.FUE_INSCRITA=1 ";

		if($ap!="" && $ap!=null)
			$sql .=" and p.APELLIDO_PATERNO like '%".$ap."%' " ;
		if($am!="" && $am!=null)
			$sql .=" and p.APELLIDO_MATERNO like '%".$am."%' " ;
		if($pn!="" && $pn!=null)
			$sql .=" and p.PRIMER_NOMBRE like '%".$pn."%' " ;
		if($sn!="" && $sn!=null)
			$sql .=" and p.SEGUNDO_NOMBRE like '%".$sn."%' " ;

		if($id_carrera!="" && $id_carrera!=null)
			$sql .=" and mat.ID_CARRERA=".$id_carrera;
		if($id_modalidad!="" && $id_modalidad!=null)
			$sql .=" and mat.ID_MODALIDAD=".$id_modalidad;
		if($id_nivel!="" && $id_nivel!=null)
			$sql .=" and mat.ID_NIVEL=".$id_nivel;

		if($fi!="") 
			 $sql .= " and DATE(mat.FECHA) >= '".$fi."'";
		if($ff!="") 
			 $sql .= " and DATE(mat.FECHA) <= '".$ff."'";


		$query = $this->db->query($sql);
		$ds = $query->result_array(); 

		if(count($ds)>0)
			return $ds;
		else
			return false;
	}*/

	public function obtener_datos_matricula($id_cliente,$id_matricula=null,$id_periodo_activado=null,$id_carrera=null)
	{
		if($id_periodo_activado==null or $id_periodo_activado<=0){
			$id_periodo_activado = $this->academico_model->get_periodo_activado();
		}
		$sql = "select m.NUMERO,m.ID_PERSONA,m.ID_CARRERA, m.ID_NIVEL, m.ID_PERIODO_ACADEMICO, m.ID_RUBRO_OPCIONAL, m.ID_MODALIDAD, m.ESTADO, m.ID_MENCION, m.ID_MATRICULA,m.ID_BECA, m.ARCHIVO_PAGO, CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as APELLIDOS, c.NOMBRE as CARRERA, ";
		$sql .= "CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as NOMBRES, cli.NRO_DOCUMENTO, ";
		$sql .= "p.EST_COLEGIO_GRADUACION, p.EST_TITULO_BACHILLER, m.OBSERVACIONES, m.OPCION_PAGO, m.FECHA, CONCAT_WS(' / ',pa.FECHA_INICIO, pa.FECHA_FIN) as PERIODO, g.NOMBRE as GRUPO, n.NIVEL, p.ID_GRUPO, p.CORREO_INSTITUCIONAL ";
		$sql .= " from tab_personas p ";
		$sql .= " inner join tab_clientes_naturales cn on p.ID_PERSONA = cn.ID_PERSONA ";
		$sql .= " inner join tab_clientes cli on cli.ID_CLIENTE = cn.ID_CLIENTE ";
		$sql .= " inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION ";
		$sql .= " inner join acad_matricula m on m.ID_PERSONA = p.ID_PERSONA";
		$sql .= " inner join acad_carrera c on c.ID_CARRERA = m.ID_CARRERA";
		$sql .= " inner join acad_nivel n on n.ID_NIVEL = m.ID_NIVEL";
		$sql .= " left join acad_grupo g on g.ID_GRUPO = m.ID_GRUPO";
		$sql .= " inner join acad_periodo_academico pa on pa.ID_PERIODO_ACADEMICO = m.ID_PERIODO_ACADEMICO";
		$sql .= " where p.OCUPACION=1 ";
		$sql .= " and cn.ID_CLIENTE=".$id_cliente;
		
		if($id_matricula>0){
			$sql .= " and m.ID_MATRICULA=".$id_matricula;
		}else{
			$sql .= " and m.ID_PERIODO_ACADEMICO=".$id_periodo_activado;
		}
		if($id_carrera!=null){
			$sql .= " and m.ID_CARRERA=".$id_carrera;
		}
		$query = $this->db->query($sql);
		$ds = $query->row_array(); 
		return $ds;
	}
	
	
	public function obtener_matricula($data)
	{
		$this->db->select('*');
		$this->db->from('acad_matricula');
		if (isset($data['ID_PERSONA']) && $data['ID_PERSONA']!="") {
			$this->db->where('ID_PERSONA', $data['ID_PERSONA']);
		}
		if (isset($data['ID_PERIODO_ACADEMICO']) && $data['ID_PERIODO_ACADEMICO']!="") {
			$this->db->where('ID_PERIODO_ACADEMICO', $data['ID_PERIODO_ACADEMICO']);
		}
		if (isset($data['ID_NIVEL']) && $data['ID_NIVEL']!="") {
			$this->db->where('ID_NIVEL', $data['ID_NIVEL']);
		}
		if (isset($data['ID_CARRERA']) && $data['ID_CARRERA']!="") {
			$this->db->where('ID_CARRERA', $data['ID_CARRERA']);
		}
		if (isset($data['ID_MATRICULA']) && $data['ID_MATRICULA']!="") {
			$this->db->where('ID_MATRICULA', $data['ID_MATRICULA']);
		}
		if (isset($data['ESTADO']) && $data['ESTADO']!="") {
			$this->db->where('ESTADO', $data['ESTADO']);
		}
		$query = $this->db->get();
		return $query->row_array(); 
			
	}

	public function get_datos_matricula($id_cliente) 
	{
		$sql = "select CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as APELLIDOS, ";
		$sql .= "CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as NOMBRES, ";
		$sql .= "p.EST_COLEGIO_GRADUACION, p.EST_TITULO_BACHILLER, p.USUARIO, p.CONTRASENA, p.ESTADO, c.NRO_DOCUMENTO";
		$sql .= " from tab_personas p inner join tab_clientes_naturales cn on p.ID_PERSONA = cn.ID_PERSONA ";
		$sql .= " inner join tab_clientes c on c.ID_CLIENTE = cn.ID_CLIENTE ";
		$sql .= " inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION where p.OCUPACION=1 and cn.ID_CLIENTE=".$id_cliente;
		$query = $this->db->query($sql);
		$ds = $query->row_array(); 
		return $ds;
	}
	

	public function get_datos_cliente($id_cliente) 
	{
		$sql = "select CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as APELLIDOS, ";
		$sql .= "CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as NOMBRES ";
		$sql .= " from tab_personas p inner join tab_clientes_naturales cn on p.ID_PERSONA = cn.ID_PERSONA ";
		$sql .= " inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION where cn.ID_CLIENTE=".$id_cliente;
		$query = $this->db->query($sql);
		$ds = $query->row_array(); 
		return $ds;
	}
	
	
	public function homologarConvalidar($data)
	{
		$this->db->trans_start();
		//obtengo el id como persona
		$this->db->select('ID_PERSONA');
		$this->db->from('tab_clientes_naturales');
		$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
		$query      = $this->db->get();
		$ds         = $query->row_array();
		$id_persona = $ds['ID_PERSONA'];
		//elimino las materias convalidadas 
		/*$this->db->where('ID_PERSONA', $id_persona);
		$this->db->where('NIVEL_MATERIA', $data['ID_NIVEL']);
		$this->db->where('ID_CARRERA', $data['ID_CARRERA']);
		$this->db->where('FUE_HOMOLOGADA', 1);
		$this->db->delete('acad_estudiante_carrera_materia');*/
		//elimino las materiaS homologadas
		/*$this->db->where('ID_PERSONA', $id_persona);
		$this->db->where('NIVEL_MATERIA', $data['ID_NIVEL']);
		$this->db->where('ID_CARRERA', $data['ID_CARRERA']);
		$this->db->where('FUE_CONVALIDADA', 1);
		$this->db->delete('acad_estudiante_carrera_materia');*/
		$respuesta="";
		//asocio las nuevas materias HOMOLOGADAS al estudiante
		$precio_total_convalidadas_homologadas = 0;
		if(isset($data['MATERIAS_HOMOLOGADAS'])){
			$data_est_carr_mat                 = array();
			$data_est_carr_mat['ID_CARRERA']   = $data['ID_CARRERA']; 
			$data_est_carr_mat['ID_PERSONA']   = $id_persona;
			$data_est_carr_mat['ID_PERIODO_ACADEMICO'] = $data['ID_PERIODO_ACADEMICO'];
			$data_est_carr_mat['NIVEL_MATERIA']        = $data['ID_NIVEL'];  //TODO: este valor es temporal
			$data_est_carr_mat['FUE_HOMOLOGADA']       = 1;
			$materias_homologadas = $data['MATERIAS_HOMOLOGADAS'];
			unset($data['MATERIAS_HOMOLOGADAS']);
			$notas_homo           = $data['NOTAS_HOMO'];
			unset($data['NOTAS_HOMO']);
			$registros_homo       = $data['REGISTRO_HOMO'];
			unset($data['REGISTRO_HOMO']);
			//for($i=0; $i<count($materias_homologadas); $i++)
			foreach($materias_homologadas as $i=>$v){
				$data_est_carr_mat['ID_CARRERA_MATERIA']    = $materias_homologadas[$i];
				$data_est_carr_mat['NOTA_HOMOLOGACION']     = $notas_homo[$i];
				$data_est_carr_mat['REGISTRO_HOMOLOGACION'] = $registros_homo[$i];
				//busco los creditos de la materia y el precio
				$this->db->select('NIVEL_MATERIA,CREDITOS_MATERIA,PRECIO');
				$this->db->from('acad_carrera_materia');
				$this->db->where('ID_CARRERA_MATERIA', $materias_homologadas[$i]);
				$query = $this->db->get();
				$ds    = $query->row_array();
				$data_est_carr_mat['CREDITOS_MATERIA'] = $ds['CREDITOS_MATERIA'];  
				$data_est_carr_mat['PRECIO']           = $ds['PRECIO'];
				$data_est_carr_mat['NIVEL_MATERIA']    = $ds['NIVEL_MATERIA']; 
				//$precio_total_convalidadas_homologadas+=$ds['PRECIO'];
				//borro si es q fue asociada en la matricula, para q no esté repetida
				$materiasb = $this->borrar_materia_estudiante($id_persona,$data_est_carr_mat['NIVEL_MATERIA'],$data_est_carr_mat['ID_CARRERA'],$data_est_carr_mat['ID_PERIODO_ACADEMICO'],$data_est_carr_mat['ID_CARRERA_MATERIA']);				
				if($materiasb>0){//si materia se cobro en matricula sumo valor a descontar
					$precio_total_convalidadas_homologadas+=$ds['PRECIO'];
				}
				$this->db->insert('acad_estudiante_carrera_materia', $data_est_carr_mat);
			}
			if(isset($data['TIPO']) and $data['TIPO']!=''){
				$homologacion=$this->get_homologacion($data['ID_CARRERA'],$id_persona);
				$dh['ID_IES']=NULL;
				$dh['CARRERA_IES']=NULL;
				if($data['TIPO']==2){
					$dh['ID_IES']=$data['ID_IES'];
					$dh['CARRERA_IES']=$data['CARRERA_IES'];
				}
				if($homologacion==NULL){
					$dh['ID_MATRICULA']=$data['ID_MATRICULA'];
					$dh['FECHA']=date('Y-m-d H:i:s');
					$this->crearHomologacion($dh);
					
					//agregar homoogacion a tabla de amortizacion
					$num_homologadas=count($materias_homologadas);
					if($num_homologadas>0){
						if($num_homologadas>10){
							$num_homologadas=10;
						}
						$this->load->model('facturacion/servicios_model');
						$this->servicios_model->asociarRubrosAClientes(array(
							'idRubro' => 15,
							'idCliente' =>  $data['ID_CLIENTE'],
							'idPeriodo' => $data['ID_PERIODO_ACADEMICO'],
							'idPlan' => 4,
							'idCarrera' => $data['ID_CARRERA'],
							'idSemestre' => $data["ID_NIVEL"],
							'nroItems' => $num_homologadas,
							'aplicarRecargoGeneracion' => FALSE
						));
					}
					
				}else{
					$this->actualizarHomologacion($dh,$homologacion['ID_HOMOLOGACION']);
				}
			}
			
			$respuesta.="Homologacion Guardada<br>";           
		}
		//asocio las nuevas materias CONVALIDADAS al estudiante
		if(isset($data['MATERIAS_CONVALIDADAS'])){
			$data_est_carr_mat               = array();
			$data_est_carr_mat['ID_CARRERA'] = $data['ID_CARRERA']; 
			$data_est_carr_mat['ID_PERSONA'] = $id_persona;
			$data_est_carr_mat['ID_PERIODO_ACADEMICO'] = $data['ID_PERIODO_ACADEMICO'];
			$data_est_carr_mat['NIVEL_MATERIA']        = $data['ID_NIVEL'];  //TODO: este valor es temporal
			$data_est_carr_mat['FUE_CONVALIDADA']      = 1;
			$materias_convalidadas                     = $data['MATERIAS_CONVALIDADAS'];
			unset($data['MATERIAS_CONVALIDADAS']);
			$notas_conv = $data['NOTAS_CONV'];
			unset($data['NOTAS_CONV']);
			//for($i=0; $i<count($materias_convalidadas); $i++)
			foreach($materias_convalidadas as $i=>$v){
				$data_est_carr_mat['ID_CARRERA_MATERIA'] = $materias_convalidadas[$i];
				$data_est_carr_mat['NOTA_CONVALIDACION'] = $notas_conv[$i];
				//busco los creditos de la materia y el precio
				$this->db->select('NIVEL_MATERIA,CREDITOS_MATERIA,PRECIO');
				$this->db->from('acad_carrera_materia');
				$this->db->where('ID_CARRERA_MATERIA', $materias_convalidadas[$i]);
				$query = $this->db->get();
				$ds    = $query->row_array();
				$data_est_carr_mat['CREDITOS_MATERIA'] = $ds['CREDITOS_MATERIA'];  
				$data_est_carr_mat['PRECIO']           = $ds['PRECIO']; 
				$data_est_carr_mat['NIVEL_MATERIA']    = $ds['NIVEL_MATERIA'];
				//$precio_total_convalidadas_homologadas+=$ds['PRECIO'];
				//borro si es q fue asociada en la matricula, para q no esté repetida
				$materiasb = $this->borrar_materia_estudiante($id_persona,$data_est_carr_mat['NIVEL_MATERIA'],$data_est_carr_mat['ID_CARRERA'],$data_est_carr_mat['ID_PERIODO_ACADEMICO'],$data_est_carr_mat['ID_CARRERA_MATERIA']);
				if($materiasb>0){//sin materia se cobro en matricula sumo valor a descontar
					$precio_total_convalidadas_homologadas+=$ds['PRECIO'];
				}
				$this->db->insert('acad_estudiante_carrera_materia', $data_est_carr_mat);
			} 
			$respuesta.="Convalidación Guardada<br>";           
		}

			/*
		 	
				//descuento de la pension el valor de las materias homologadas o convalidadas
				$this->load->model('facturacion/servicios_model');
				$clte = $this->servicios_model->buscarPorcentajeDescuentoCliente($data['ID_CLIENTE']);
				$porcentajeDescuento = $clte['PORCENTAJE'];
				if($porcentajeDescuento!=NULL && $porcentajeDescuento!="")
				{
				  //$precio_total_convalidadas_homologadas = $precio_total_convalidadas_homologadas -($precio_total_convalidadas_homologadas* $porcentajeDescuento /100);  
				}
				
				//si no tiene cuotas generales
				$this->db->select("*");
				$this->db->from('fac_cuotas_generales');
				$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
				$this->db->where('ID_PERIODO_ACADEMICO', $data['ID_PERIODO_ACADEMICO']);

				$query= $this->db->get();
				$ds = $query->row_array();
				if(count($ds)==0)
				{
					//obtengo el id_clte_rubro del semestre
					$this->db->select("ID_CLIENTE_RUBRO");
					$this->db->from('fac_clientes_rubros');
					$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
					$this->db->where('PERIODO_VIGENTE', $data['ID_PERIODO_ACADEMICO']);
					$this->db->where('ID_RUBRO', 17);
					$query= $this->db->get();
					$ds = $query->row_array();

					$precio_total_convalidadas_homologadas=$precio_total_convalidadas_homologadas*6;
					$id_cliente_rubro = $ds['ID_CLIENTE_RUBRO'];
					//actualizo cliente-rubro: precio_unitario_rubro, precio_x_nro_items,subtotal estado 
					$sql = "update fac_clientes_rubros set PRECIO_UNITARIO_RUBRO=PRECIO_UNITARIO_RUBRO-".$precio_total_convalidadas_homologadas;
					$sql.= ",PRECIO_X_NRO_ITEMS=PRECIO_X_NRO_ITEMS-".$precio_total_convalidadas_homologadas;
					$sql.= ",SUBTOTAL=SUBTOTAL-".$precio_total_convalidadas_homologadas;
					$sql.=",ESTADO=0 where ID_CLIENTE_RUBRO=".$id_cliente_rubro;
					$this->db->query($sql);
				}
				else
				{ 
					//obtengo el id_clte_rubro del semestre
					$this->db->select("ID_CLIENTE_RUBRO");
					$this->db->from('fac_clientes_rubros');
					$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
					$this->db->where('PERIODO_VIGENTE', $data['ID_PERIODO_ACADEMICO']);
					$this->db->where('ID_CARRERA', $data['ID_CARRERA']);
					$this->db->where('ID_RUBRO', 17);
					$query= $this->db->get();
					$ds = $query->row_array();
					$id_cliente_rubro = $ds['ID_CLIENTE_RUBRO'];

					if(count($ds)>0) // si tiene asociado el rubro de semestre
					{
						//obtengo los id de las cuotas de semestre sin abonos
						$this->db->select("ID_CLIENTE_RUBRO_CUOTA");
						$this->db->from('fac_clientes_rubros_cuota');
						$this->db->where('ID_CLIENTE_RUBRO',$id_cliente_rubro);
						$this->db->where('VALOR_SALDADO_POR_PAGO',0);
						$query= $this->db->get();
						$ds = $query->result_array();

						$cantidad_cuotas_sin_abonos = count($ds);
						$cantidad_a_descontar = $precio_total_convalidadas_homologadas;

						//descuento en cada una de las cuotas
						for($i=0; $i<count($ds);$i++)
						{
							$id_cliente_rubro_cuota = $ds[$i]['ID_CLIENTE_RUBRO_CUOTA'] ;                     
							$sql = "update fac_clientes_rubros_cuota set PRECIO=PRECIO-".$cantidad_a_descontar;
							$sql.=" where ID_CLIENTE_RUBRO_CUOTA=".$id_cliente_rubro_cuota;
							$this->db->query($sql);
						}

						$cantidad_total_descontada =  $cantidad_a_descontar*$cantidad_cuotas_sin_abonos;
						//actualizo en cliente rubro
						$sql = "update fac_clientes_rubros set PRECIO_UNITARIO_RUBRO=PRECIO_UNITARIO_RUBRO-".$cantidad_total_descontada;
						$sql.= ",PRECIO_X_NRO_ITEMS=PRECIO_X_NRO_ITEMS-".$cantidad_total_descontada;
						$sql.= ",SUBTOTAL=SUBTOTAL-".$cantidad_total_descontada;
						$sql.=",ESTADO=0 where ID_CLIENTE_RUBRO=".$id_cliente_rubro;
						$this->db->query($sql);

						//recalculo las cuotas generales
						$this->load->model('automatica/automatica_model');
						$this->automatica_model->calcular_y_actualizar_cuotas_generales($data['ID_CLIENTE']);
					}
				}    
			*/  
		$this->db->trans_complete();		
		return $respuesta;		
	}

	  
/*

	   public function crearActualizarMatricula($data)
	{



		$periodo=$this->get_periodo_activado();
		$this->db->trans_start();


		  $plan=$this->seleccionado_plan_de_pago($data['ID_CLIENTE']);

		
		  if($plan==0)
{

		//obtengo el id como persona
		$this->db->select('ID_PERSONA');
		$this->db->from('tab_clientes_naturales');
		$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
		$query = $this->db->get();
		$ds = $query->row_array();
		$id_persona = $ds['ID_PERSONA'];

		//le asigno el user y pass generados
		if(isset($data['USUARIO']))
		{
			$data_credenciales = array();
			$data_credenciales['USUARIO']=$data['USUARIO'];
			$data_credenciales['CONTRASENA']=$data['CONTRASENA'];
			unset($data['USUARIO']);
			unset($data['CONTRASENA']);
			$this->db->where('ID_PERSONA', $id_persona);
			$this->db->update('tab_personas', $data_credenciales);            
		}

		//obtengo el grupo al que será asignado
		$this->db->select('ID_GRUPO');
		$this->db->from('acad_grupo');
		$this->db->where('NOMBRE', $data['GRUPO_ASIGNADO']);
		$this->db->where('ID_CARRERA', $data['ID_CARRERA']);
		$this->db->where('ID_NIVEL', $data['ID_NIVEL']);
		$query = $this->db->get();
		$ds = $query->row_array();
		$id_grupo_a_asignar=$ds['ID_GRUPO'];
		unset($data['GRUPO_ASIGNADO']);

		//le asigno el grupo a la persona, y el nivel
		$data_grupo_persona = array();
		$data_grupo_persona['ID_GRUPO']=$id_grupo_a_asignar;
		$data_grupo_persona['NIVEL']=$data['ID_NIVEL'];
		$this->db->where('ID_PERSONA', $id_persona);
		$this->db->update('tab_personas', $data_grupo_persona);


		//elimino las materias que tiene asignada el estudiante en el nivel de la carrera, q no hayan sido conv u homo
		$this->db->where('ID_PERSONA', $id_persona);
		$this->db->where('NIVEL_MATERIA', $data['ID_NIVEL']);
		$this->db->where('ID_CARRERA', $data['ID_CARRERA']);
		$this->db->where('FUE_CONVALIDADA !=', 1);
		$this->db->where('FUE_HOMOLOGADA !=', 1);
		$this->db->delete('acad_estudiante_carrera_materia'); 

		//asocio las nuevas materias asignadas al estudiante
		$precio_total_por_materias=0;
		$cantidad_de_arrastres=0;
			if(isset($data['MATERIAS_ASIGNADAS']))
			{
				$data_est_carr_mat=array();
				$data_est_carr_mat['ID_CARRERA']=$data['ID_CARRERA']; 
				$data_est_carr_mat['ID_PERSONA']=$id_persona;
				$data_est_carr_mat['ID_PERIODO_ACADEMICO']=$data['ID_PERIODO_ACADEMICO'];
				$data_est_carr_mat['ID_GRUPO']=$id_grupo_a_asignar;


				$materias_asignadas = $data['MATERIAS_ASIGNADAS'];
				if(isset($data['ES_ARRASTRE']))
				{
				  $arrastres = $data['ES_ARRASTRE']; //arreglo con los id de los materias q arrastra
				  $cantidad_de_arrastres=count($arrastres);
				}
				$docentes_asignados =  $data['DOCENTES_ASIGNADOS'];
				unset($data['MATERIAS_ASIGNADAS']);
				unset($data['DOCENTES_ASIGNADOS']);
				unset($data['ES_ARRASTRE']);

				for($i=0; $i<count($materias_asignadas); $i++)
				{
					$data_est_carr_mat['ID_CARRERA_MATERIA']=$materias_asignadas[$i];
					$data_est_carr_mat['ID_PERSONA_DOCENTE']=$docentes_asignados[$i];

					//busco los creditos de la materia,el precio y el nivel
					$this->db->select('CREDITOS_MATERIA,PRECIO,NIVEL_MATERIA');
					$this->db->from('acad_carrera_materia');
					$this->db->where('ID_CARRERA_MATERIA', $materias_asignadas[$i]);

					$query = $this->db->get();
					$ds = $query->row_array();
					$data_est_carr_mat['CREDITOS_MATERIA'] = $ds['CREDITOS_MATERIA']; 
					$data_est_carr_mat['NIVEL_MATERIA']= $ds['NIVEL_MATERIA']; 
					$data_est_carr_mat['PRECIO']=$ds['PRECIO']; 
					$precio_total_por_materias += $ds['PRECIO'];

					//verifico si será asociada como arrastre
					if (isset($arrastres))
					{
						if (in_array($materias_asignadas[$i], $arrastres)) 
						{
							$data_est_carr_mat['ES_ARRASTRE']=1;
						}
						else
						{
							$data_est_carr_mat['ES_ARRASTRE']=0;
						}
					}

					$this->db->insert('acad_estudiante_carrera_materia', $data_est_carr_mat);
				}          
			}


//queda abierta la uno


 //verifico si asocio el rubro de arrastre
		if ($cantidad_de_arrastres>0)
		{
			//verifico si tiene asociado el rubro de arrastre
			$this->db->select('fac_clientes_rubros.ID_CLIENTE_RUBRO');
			$this->db->from('fac_clientes_rubros');
			$this->db->join('fac_rubros', 'fac_rubros.ID_RUBRO = fac_clientes_rubros.ID_RUBRO');
			$this->db->where('fac_rubros.ID_RUBRO', 16); 
			$this->db->where('PERIODO_VIGENTE', $periodo);
			$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
			$query = $this->db->get();
			$ds = $query->row_array();  

			$id_clte_rubro = $ds['ID_CLIENTE_RUBRO'];
			$this->db->where('ID_CLIENTE_RUBRO', $id_clte_rubro);

			$this->db->delete('fac_clientes_rubros_cuota'); 
			$this->db->where('ID_CLIENTE_RUBRO', $id_clte_rubro);
			
		   $this->db->where('PERIODO_VIGENTE', $periodo);
			$this->db->delete('fac_clientes_rubros');  
			
		  //0 0 $this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
			//$this->db->where('ID_PERIODO_ACADEMICO', $periodo);
			//$this->db->delete('fac_cuotas_generales'); 
			

				$this->load->model('facturacion/servicios_model');
							$this->servicios_model->asociarRubrosAClientes(array(
								'idRubro' => 16,
								'idCliente' =>  $data['ID_CLIENTE'],
								'idPeriodo' => $this->get_periodo_activado(),
								'idPlan' => 4,
								'idCarrera' => $data['ID_CARRERA'],
								'idSemestre' => $data["ID_NIVEL"],
								'nroItems' => 1,
								'aplicarRecargoGeneracion' => FALSE
							));     
			}
			else
			{

					 $this->db->select('fac_clientes_rubros.ID_CLIENTE_RUBRO');
			$this->db->from('fac_clientes_rubros');
			$this->db->join('fac_rubros', 'fac_rubros.ID_RUBRO = fac_clientes_rubros.ID_RUBRO');
			$this->db->where('fac_rubros.ID_RUBRO', 16); 
			$this->db->where('PERIODO_VIGENTE', $periodo);
			$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
			$query = $this->db->get();
			$ds = $query->row_array(); 


			 $id_clte_rubro = $ds['ID_CLIENTE_RUBRO'];
			$this->db->where('ID_CLIENTE_RUBRO', $id_clte_rubro);

			$this->db->delete('fac_clientes_rubros_cuota'); 
			$this->db->where('ID_CLIENTE_RUBRO', $id_clte_rubro);
			
		   $this->db->where('PERIODO_VIGENTE', $periodo);
			$this->db->delete('fac_clientes_rubros');  
   
			}




//verifico si tiene asociado el rubro de matricula y asocio los rubros de semestre
		$this->db->select('fac_clientes_rubros.ID_CLIENTE_RUBRO');
		$this->db->from('fac_clientes_rubros');
		$this->db->join('fac_rubros', 'fac_rubros.ID_RUBRO = fac_clientes_rubros.ID_RUBRO');
		$this->db->where('fac_rubros.ID_RUBRO', 17);
//        $this->db->where('fac_clientes_rubros.PERIODO_VIGENTE', $periodo);
		$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
		$query = $this->db->get();
		$ds = $query->row_array();           

		if(count($ds)==0)
		{
			//asocio los rubros al estudiante
				$resultado = $this->obtener_rubros_semestre_del_nivel($data['ID_NIVEL']); //RUBROS de semestre, o sea de la colegiatura. 
				$this->load->model('facturacion/servicios_model');
				foreach ($resultado as $res) 
				{
					if($res['ID_RUBRO']!=16) //Excluyo el de arrastre porque arriba ya lo agregue
					{
						$this->servicios_model->asociarRubrosAClientes(array(
							'idRubro' => $res['ID_RUBRO'],
							'idCliente' =>  $data['ID_CLIENTE'],
							'idPeriodo' => $this->get_periodo_activado(),
							'idPlan' => 4,
							'idCarrera' => $data['ID_CARRERA'],
							'idSemestre' => $data["ID_NIVEL"],
							'nroItems' => 1,
							'aplicarRecargoGeneracion' => FALSE
						));                          
					}
			   
				}            
		}
		else // si ya tenía el rubro de semestre asociado, elimino en las cuotas sencillas, las generales, elimino en cliente rubro y asocio
		{







			$this->db->select("*");
			$this->db->from('fac_cuotas_generales');
			$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
		  // $this->db->where('ID_PERIODO_ACADEMICO', $periodo);
			$query2= $this->db->get();
			$ds2 = $query2->result_array();
		  
if(count($ds2)==6){


  $this->db->select('fac_clientes_rubros.ID_CLIENTE_RUBRO');
		$this->db->from('fac_clientes_rubros');
		$this->db->join('fac_rubros', 'fac_rubros.ID_RUBRO = fac_clientes_rubros.ID_RUBRO');
		$this->db->where('fac_rubros.ID_RUBRO', 17);
		 $this->db->where('fac_clientes_rubros.PERIODO_VIGENTE', $periodo);
		$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
  $query1 = $this->db->get();
		$ds1 = $query1->row_array(); 

	if(count($ds1)!=0){

			 $this->db->where('ID_CLIENTE_RUBRO', $ds1['ID_CLIENTE_RUBRO']);
			$this->db->delete('fac_clientes_rubros_cuota');
			$this->db->where('ID_CLIENTE_RUBRO', $ds1['ID_CLIENTE_RUBRO']);
			$this->db->delete('fac_clientes_rubros');  
			//$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
			//$this->db->where('ID_PERIODO_ACADEMICO', $periodo);
		   // $this->db->delete('fac_cuotas_generales'); 
$this->load->model('facturacion/servicios_model');
			$this->servicios_model->asociarRubrosAClientes(array(
							'idRubro' => 17,
							'idCliente' =>  $data['ID_CLIENTE'],
							'idPeriodo' => $this->get_periodo_activado(),
							'idPlan' => 4,
							'idCarrera' => $data['ID_CARRERA'],
							'idSemestre' => $data["ID_NIVEL"],
							'nroItems' => 1,
							'aplicarRecargoGeneracion' => FALSE
						));                     

			}


			else{

			$resultado = $this->obtener_rubros_semestre_del_nivel($data['ID_NIVEL']); //RUBROS de semestre, o sea de la colegiatura. 
				$this->load->model('facturacion/servicios_model');
				foreach ($resultado as $res) 
				{
					if($res['ID_RUBRO']!=16) //Excluyo el de arrastre porque arriba ya lo agregue
					{
						$this->servicios_model->asociarRubrosAClientes1(array(
							'idRubro' => $res['ID_RUBRO'],
							'idCliente' =>  $data['ID_CLIENTE'],
							'idPeriodo' => $this->get_periodo_activado(),
							'idPlan' => 4,
							'idCarrera' => $data['ID_CARRERA'],
							'idSemestre' => $data["ID_NIVEL"],
							'nroItems' => 1,
							'aplicarRecargoGeneracion' => FALSE
						));                          
					}
}
}

}else if(count($ds2)==12){

		$this->db->select('fac_clientes_rubros.ID_CLIENTE_RUBRO');
		$this->db->from('fac_clientes_rubros');
		$this->db->join('fac_rubros', 'fac_rubros.ID_RUBRO = fac_clientes_rubros.ID_RUBRO');
		$this->db->where('fac_rubros.ID_RUBRO', 17);
		 $this->db->where('fac_clientes_rubros.PERIODO_VIGENTE', $periodo);
		$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
  $query1 = $this->db->get();
		$ds1 = $query1->row_array(); 

	if(count($ds1)!=0){

			 $this->db->where('ID_CLIENTE_RUBRO', $ds1['ID_CLIENTE_RUBRO']);
			$this->db->delete('fac_clientes_rubros_cuota');
			$this->db->where('ID_CLIENTE_RUBRO', $ds1['ID_CLIENTE_RUBRO']);
			$this->db->where('PERIODO_VIGENTE', $periodo);
			$this->db->delete('fac_clientes_rubros');  
			$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
			$this->db->where('ID_PERIODO_ACADEMICO', $periodo);
			$this->db->delete('fac_cuotas_generales'); 
$this->load->model('facturacion/servicios_model');
			$this->servicios_model->asociarRubrosAClientes1(array(
							'idRubro' => 17,
							'idCliente' =>  $data['ID_CLIENTE'],
							'idPeriodo' => $this->get_periodo_activado(),
							'idPlan' => 4,
							'idCarrera' => $data['ID_CARRERA'],
							'idSemestre' => $data["ID_NIVEL"],
							'nroItems' => 1,
							'aplicarRecargoGeneracion' => FALSE
						));                     

			}
	  




}


}

		if (isset($data['ID_MATRICULA']) && $data['ID_MATRICULA'] != NULL) 
		{
			//actualizo 
			$data['ID_PERSONA']=$id_persona;
			$data['FECHA']= date("Y-m-d");
			unset($data['NOMBRES']);
			unset($data['APELLIDOS']);
			unset($data['COLEGIO']);
			unset($data['TITULO']);
			unset($data['ID_CLIENTE']);
			unset($data['PRECIO']);
			$data['OBSERVACIONES']=trim($data['OBSERVACIONES']);
			$this->db->where('acad_matricula.ID_MATRICULA', $data['ID_MATRICULA']);
			$this->db->update('acad_matricula', $data);
		}
		else
		{
			//la creo
			$data['ID_PERSONA']=$id_persona;
			$data['FECHA']= date("Y-m-d");

			unset($data['NOMBRES']);
			unset($data['APELLIDOS']);
			unset($data['COLEGIO']);
			unset($data['TITULO']);
			unset($data['ID_CLIENTE']);
			unset($data['ID_MATRICULA']);
			unset($data['PRECIO']);

			//incremento el ultimo numero de matricula
			$this->incrementarUltimoNumeroDeMatricula();
			$this->db->insert('acad_matricula', $data);
		}

}else{
//echo "juanchirulo";

  //obtengo el id como persona
		$this->db->select('ID_PERSONA');
		$this->db->from('tab_clientes_naturales');
		$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
		$query = $this->db->get();
		$ds = $query->row_array();
		$id_persona = $ds['ID_PERSONA'];


		//obtengo el grupo al que será asignado
		$this->db->select('ID_GRUPO');
		$this->db->from('acad_grupo');
		$this->db->where('NOMBRE', $data['GRUPO_ASIGNADO']);
		$this->db->where('ID_CARRERA', $data['ID_CARRERA']);
		$this->db->where('ID_NIVEL', $data['ID_NIVEL']);
		$query = $this->db->get();
		$ds = $query->row_array();
		$id_grupo_a_asignar=$ds['ID_GRUPO'];
		unset($data['GRUPO_ASIGNADO']);

		//le asigno el grupo a la persona, y el nivel
		$data_grupo_persona = array();
		$data_grupo_persona['ID_GRUPO']=$id_grupo_a_asignar;
	  //  $data_grupo_persona['NIVEL']=$data['ID_NIVEL'];
		$this->db->where('ID_PERSONA', $id_persona);
		$this->db->update('tab_personas', $data_grupo_persona);


		$precio_total_por_materias=0;
		$cantidad_de_arrastres=0;
		$data_est_carr_mat=array();
		$docentes_asignados =  $data['DOCENTES_ASIGNADOS'];
		$data_est_carr_mat['ID_GRUPO']=$id_grupo_a_asignar;
		$materias_asignadas = $data['MATERIAS_ASIGNADAS'];

			   for($i=0; $i<count($docentes_asignados); $i++)
				{
					$data_est_carr_mat['ID_PERSONA_DOCENTE']=$docentes_asignados[$i];

					//verifico si será asociada como arrastre
					 $this->db->where('ID_PERSONA', $id_persona);
					$this->db->where('id_periodo_academico', $periodo);
					 $this->db->where('nivel_materia', $data['ID_NIVEL']);
					$this->db->where('id_carrera_materia',   $materias_asignadas[$i]);
					$this->db->update('acad_estudiante_carrera_materia', $data_est_carr_mat);
				}            
		  
			   }


		$this->db->trans_complete();
	}

*/

	public function crearActualizarMatricula($data)
	{
		//$periodo=$this->get_periodo_activado();
		$this->db->trans_start();
		$plan=$this->seleccionado_plan_de_pago($data['ID_CLIENTE'],$data['ID_CARRERA'],$data['ID_PERIODO_ACADEMICO']);
		$ids_materias_estudiante=array();
		if(!isset($data['ESTADO'])){
			$data['ESTADO']=0;
		}
		$valor=0;
		if(isset($data['valor'])){
			$valor=$data['valor'];
			unset($data['valor']);
		}
		/*Aqui se encuentra la creacion de tipo de matriculas
		$tipo_matricula=$this->obtenertipoMatricula($data['ID_CLIENTE']);
		if($tipo_matricula==0){
			$id_cliente=$data['ID_CLIENTE'];
			$recargo=0;
			$rubro=27;
		}else{
			//echo  $EXTRAORDINARIA;
			// if($tipo_matricula['EXTRAORDINARIA'] )
			//echo 'actualizar matricula';
			$id_cliente=$data['ID_CLIENTE'];
			$recargo=$tipo_matricula[0]['RECARGO'];
			$rubro=$tipo_matricula[0]['RUBRO'];
		}
		*/
		//$especial=$tipo_matricula[0]['ESPECIAL'];
		//$extraordinaria=$tipo_matricula[0]['EXTRAORDINARIA'];
		//$especial=$tipo_matricula[0]['ESPECIAL'];
		//$valor_recargo_generacion=$tipo_matricula[0]['VALOR_RECARGO_GENERACION'];
		//$recargo_por_generacion_rubro=$tipo_matricula[0]['RECARGO_POR_GENERACION_RUBRO'];
		
		//obtengo el id como persona
		$this->db->select('ID_PERSONA');
		$this->db->from('tab_clientes_naturales');
		$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
		$query = $this->db->get();
		$ds = $query->row_array();
		$id_persona = $ds['ID_PERSONA'];
		//revisar si no tiene calificaciones para actualizar
		$this->db->select('c.ID_CALIFICACION');
		$this->db->from('acad_calificacion c');
		$this->db->join('acad_estudiante_carrera_materia ecm', 'ecm.ID_ESTUDIANTE_CARRERA_MATERIA = c.ID_ESTUDIANTE_CARRERA_MATERIA', 'Inner');
		$this->db->where('ecm.ID_PERIODO_ACADEMICO',$data['ID_PERIODO_ACADEMICO']);
		$this->db->where('ecm.ID_PERSONA',$id_persona);
		$this->db->where('ecm.ID_CARRERA',$data['ID_CARRERA']);
		$query = $this->db->get();
		$calificaciones = $query->row_array();
		
		//$data['NUMERO']='';
		if($plan==0 and $calificaciones==NULL){
			//le asigno el user y pass generados
			if(isset($data['USUARIO'])){
				$data_credenciales = array();
				$data_credenciales['USUARIO']=$data['USUARIO'];
				$data_credenciales['CONTRASENA']=$data['CONTRASENA'];
				unset($data['USUARIO']);
				unset($data['CONTRASENA']);
				$this->db->where('ID_PERSONA', $id_persona);
				$this->db->update('tab_personas', $data_credenciales);            
			}
			//obtengo el grupo al que será asignado
			$this->db->select('ID_GRUPO');
			$this->db->from('acad_grupo');
			$this->db->where('NOMBRE', $data['GRUPO_ASIGNADO']);
			$this->db->where('ID_CARRERA', $data['ID_CARRERA']);
			$this->db->where('ID_NIVEL', $data['ID_NIVEL']);
			if(isset($data['ID_SEDE_GRUPO'])){
				$this->db->where('ID_SEDE', $data['ID_SEDE_GRUPO']);
			}
			$query = $this->db->get();
			$ds = $query->row_array();
			$id_grupo_a_asignar=$ds['ID_GRUPO'];
			$data['ID_GRUPO']=$id_grupo_a_asignar;
			$nombre_grupo=$data['GRUPO_ASIGNADO'];
			//ubico el grupo anterior para el caso de que va actualizar
			$ds_grupo=$this->get_grupo_sede_asignado($data['ID_CLIENTE'], $data['ID_CARRERA'], $data['ID_PERIODO_ACADEMICO'], $data['ID_NIVEL']);
			$id_grupo_antiguo=0;
			if($ds_grupo!=NULL){
				$id_grupo_antiguo=$ds_grupo['ID_GRUPO'];
			}
			/*$this->db->select('ID_GRUPO');
			$this->db->from('tab_personas');
			$this->db->where('ID_PERSONA', $id_persona);
			$query = $this->db->get();
			$ds_grupo = $query->row_array();
			$id_grupo_antiguo=$ds_grupo['ID_GRUPO'];*/
			//le asigno el grupo a la persona, y el nivel
			$data_grupo_persona = array();
			$data_grupo_persona['ID_GRUPO']=$id_grupo_a_asignar;
			$data_grupo_persona['NIVEL']=$data['ID_NIVEL'];
			$this->db->where('ID_PERSONA', $id_persona);
			$this->db->update('tab_personas', $data_grupo_persona);
			//elimino las materias que tiene asignada el estudiante en el nivel de la carrera, q no hayan sido conv u homo
			$this->db->where('ID_PERSONA', $id_persona);
			//$this->db->where('NIVEL_MATERIA', $data['ID_NIVEL']);
			$this->db->where('ID_CARRERA', $data['ID_CARRERA']);
			$this->db->where('FUE_CONVALIDADA !=', 1);
			$this->db->where('FUE_HOMOLOGADA !=', 1);
			$this->db->where('ID_PERIODO_ACADEMICO', $data['ID_PERIODO_ACADEMICO'] );
			$this->db->delete('acad_estudiante_carrera_materia'); 
			//asocio las nuevas materias asignadas al estudiante
			$precio_total_por_materias=0;
			$cantidad_de_arrastres=0;
			if(isset($data['MATERIAS_ASIGNADAS'])){
				$data_est_carr_mat=array();
				$data_est_carr_mat['ID_CARRERA']=$data['ID_CARRERA']; 
				$data_est_carr_mat['ID_PERSONA']=$id_persona;
				$data_est_carr_mat['ID_PERIODO_ACADEMICO']=$data['ID_PERIODO_ACADEMICO'];
				$data_est_carr_mat['ID_GRUPO']=$id_grupo_a_asignar;
				$materias_asignadas = $data['MATERIAS_ASIGNADAS'];
				if(isset($data['ES_ARRASTRE'])){
					$arrastres = $data['ES_ARRASTRE']; //arreglo con los id de los materias q arrastra
					$cantidad_de_arrastres=count($arrastres);
				}
				$docentes_asignados =  $data['DOCENTES_ASIGNADOS'];
				unset($data['MATERIAS_ASIGNADAS']);
				unset($data['DOCENTES_ASIGNADOS']);
				unset($data['ES_ARRASTRE']);
				$grupos_asignados =  $data['GRUPO'];
				//for($i=0; $i<count($materias_asignadas); $i++)
				foreach($materias_asignadas as $i=>$materia_asignada){
					$data_est_carr_mat['ID_CARRERA_MATERIA']=$materias_asignadas[$i];
					$data_est_carr_mat['ID_PERSONA_DOCENTE']=$docentes_asignados[$i];
					//busco los creditos de la materia,el precio y el nivel
					$this->db->select('CREDITOS_MATERIA,PRECIO,NIVEL_MATERIA');
					$this->db->from('acad_carrera_materia');
					$this->db->where('ID_CARRERA_MATERIA', $materias_asignadas[$i]);
					$query = $this->db->get();
					$ds = $query->row_array();
					$data_est_carr_mat['CREDITOS_MATERIA'] = $ds['CREDITOS_MATERIA']; 
					$data_est_carr_mat['NIVEL_MATERIA']= $ds['NIVEL_MATERIA']; 
					$data_est_carr_mat['PRECIO']=$ds['PRECIO']; 
					$precio_total_por_materias += $ds['PRECIO'];
					//ingreso de grupo por materia
					//if($grupos_asignados[$i]!=$nombre_grupo){
						$this->db->select('ID_GRUPO');
						$this->db->from('acad_grupo');
						$this->db->where('NOMBRE', $grupos_asignados[$i]);
						$this->db->where('ID_CARRERA', $data_est_carr_mat['ID_CARRERA']);
						$this->db->where('ID_NIVEL', $data_est_carr_mat['NIVEL_MATERIA']);
						if(isset($data['ID_SEDE_GRUPO'])){
							//$this->db->where('ID_SEDE', $data['ID_SEDE_GRUPO']);
						}
						$query = $this->db->get();
						$ds_g= $query->row_array();
						if($ds_g!=NULL){
							$data_est_carr_mat['ID_GRUPO']=$ds_g['ID_GRUPO'];
						}else{
							$data_est_carr_mat['ID_GRUPO']=$id_grupo_a_asignar;
						}
					//}else{
						//$data_est_carr_mat['ID_GRUPO']=$id_grupo_a_asignar;
					//}
					//verifico si será asociada como arrastre
					if(isset($arrastres)){
						if (in_array($materias_asignadas[$i], $arrastres)){
							$data_est_carr_mat['ES_ARRASTRE']=1;
						}else{
							$data_est_carr_mat['ES_ARRASTRE']=0;
						}
					}
					$this->db->insert('acad_estudiante_carrera_materia', $data_est_carr_mat);
					$ids_materias_estudiante[]=$this->db->insert_id();
				}          
			}
			//verifico si asocio el rubro de arrastre
			if($cantidad_de_arrastres>0 and $data['ESTADO']!=3){
				//verifico si tiene asociado el rubro de arrastre
				$this->db->select('fac_clientes_rubros.ID_CLIENTE_RUBRO');
				$this->db->from('fac_clientes_rubros');
				$this->db->join('fac_rubros', 'fac_rubros.ID_RUBRO = fac_clientes_rubros.ID_RUBRO');
				$this->db->where('fac_rubros.ID_RUBRO', 16); 
				$this->db->where('PERIODO_VIGENTE', $data['ID_PERIODO_ACADEMICO']);
				$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
				$this->db->where('ID_CARRERA', $data['ID_CARRERA']);
				$query = $this->db->get();
				$ds = $query->row_array(); 
				$id_clte_rubro = $ds['ID_CLIENTE_RUBRO'];
				$this->db->where('ID_CLIENTE_RUBRO', $id_clte_rubro);
				$this->db->delete('fac_clientes_rubros_cuota'); 
				$this->db->where('ID_CLIENTE_RUBRO', $id_clte_rubro);
				$this->db->where('PERIODO_VIGENTE', $data['ID_PERIODO_ACADEMICO']);
				$this->db->delete('fac_clientes_rubros');  
			
				//0 0 $this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
				//$this->db->where('ID_PERIODO_ACADEMICO', $periodo);
				//$this->db->delete('fac_cuotas_generales'); 
				$this->load->model('facturacion/servicios_model');
				$this->servicios_model->asociarRubrosAClientes(array(
					'idRubro' => 16,
					'idCliente' =>  $data['ID_CLIENTE'],
					'idPeriodo' => $data['ID_PERIODO_ACADEMICO'],
					'idPlan' => 4,
					'idCarrera' => $data['ID_CARRERA'],
					'idSemestre' => $data["ID_NIVEL"],
					'nroItems' => 1,
					'aplicarRecargoGeneracion' => FALSE
				));   
				 
			}elseif($data['ESTADO']!=3){
				$this->db->select('fac_clientes_rubros.ID_CLIENTE_RUBRO');
				$this->db->from('fac_clientes_rubros');
				$this->db->join('fac_rubros', 'fac_rubros.ID_RUBRO = fac_clientes_rubros.ID_RUBRO');
				$this->db->where('fac_rubros.ID_RUBRO', 16); 
				$this->db->where('PERIODO_VIGENTE', $data['ID_PERIODO_ACADEMICO']);
				$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
				$this->db->where('ID_CARRERA', $data['ID_CARRERA']);
				$query = $this->db->get();
				$ds = $query->row_array(); 
				$id_clte_rubro = $ds['ID_CLIENTE_RUBRO'];
				$this->db->where('ID_CLIENTE_RUBRO', $id_clte_rubro);
				$this->db->delete('fac_clientes_rubros_cuota'); 
				$this->db->where('ID_CLIENTE_RUBRO', $id_clte_rubro);
				$this->db->where('PERIODO_VIGENTE', $data['ID_PERIODO_ACADEMICO']);
				$this->db->delete('fac_clientes_rubros');  
			}
			//verifico si tiene asociado el rubro de matricula y asocio los rubros de semestre
			$this->db->select('fac_clientes_rubros.ID_CLIENTE_RUBRO');
			$this->db->from('fac_clientes_rubros');
			$this->db->join('fac_rubros', 'fac_rubros.ID_RUBRO = fac_clientes_rubros.ID_RUBRO');
			$this->db->where('fac_rubros.ID_RUBRO', 17);
			$this->db->where('fac_clientes_rubros.PERIODO_VIGENTE', $data['ID_PERIODO_ACADEMICO']);
			$this->db->where('fac_clientes_rubros.ID_CLIENTE', $data['ID_CLIENTE']);
			$this->db->where('fac_clientes_rubros.ID_CARRERA', $data['ID_CARRERA']);
			$query = $this->db->get();
			$ds = $query->row_array();
			//if(count($ds)==0 and $data['ESTADO']!=3){ 
			if(count($ds)==0){
				//asocio los rubros al estudiante
				$resultado = $this->obtener_rubros_semestre_del_nivel($data['ID_NIVEL']); //RUBROS de semestre, o sea de la colegiatura. 
				$this->load->model('facturacion/servicios_model');
				foreach($resultado as $res){
					if($res['ID_RUBRO']!=16 and $res['ID_RUBRO']!=15){//Excluyo el de arrastre porque arriba ya lo agregue y homologacion
						$this->servicios_model->asociarRubrosAClientes(array(
							'idRubro' => $res['ID_RUBRO'],
							'idCliente' =>  $data['ID_CLIENTE'],
							'idPeriodo' => $data['ID_PERIODO_ACADEMICO'],
							'idPlan' => 4,
							'idCarrera' => $data['ID_CARRERA'],
							'idSemestre' => $data["ID_NIVEL"],
							'nroItems' => 1,
							'valor'=>$valor,
							'aplicarRecargoGeneracion' => FALSE
						));                          
					}		   
				}            
			//}elseif($data['ESTADO']!=3){ // si ya tenía el rubro de semestre asociado, elimino en las cuotas sencillas, las generales, elimino en cliente rubro y asocio
			}else{ // si ya tenía el rubro de semestre asociado, elimino en las cuotas sencillas, las generales, elimino en cliente rubro y asocio
				$this->db->select('fac_clientes_rubros.ID_CLIENTE_RUBRO');
				$this->db->from('fac_clientes_rubros');
				$this->db->join('fac_rubros', 'fac_rubros.ID_RUBRO = fac_clientes_rubros.ID_RUBRO');
				$this->db->where('fac_rubros.ID_RUBRO', 17); 
				$this->db->where('fac_clientes_rubros.PERIODO_VIGENTE', $data['ID_PERIODO_ACADEMICO']);
				$this->db->where('fac_clientes_rubros.ID_CLIENTE', $data['ID_CLIENTE']);
				$this->db->where('fac_clientes_rubros.ID_CARRERA', $data['ID_CARRERA']);
				$query1 = $this->db->get();
				$ds1 = $query1->row_array(); 
				$this->db->where('ID_CLIENTE_RUBRO', $ds1['ID_CLIENTE_RUBRO']);
				$this->db->delete('fac_clientes_rubros_cuota');
				$this->db->where('ID_CLIENTE_RUBRO', $ds1['ID_CLIENTE_RUBRO']);
				$this->db->where('PERIODO_VIGENTE', $data['ID_PERIODO_ACADEMICO']);
				$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
				$this->db->where('ID_CARRERA', $data['ID_CARRERA']);
				$this->db->delete('fac_clientes_rubros');  
			  
				//$this->db->where('ID_PERIODO_ACADEMICO', $periodo);
				//$this->db->delete('fac_cuotas_generales'); 
				$this->load->model('facturacion/servicios_model');
				$this->servicios_model->asociarRubrosAClientes(array(
								'idRubro' => 17,
								'idCliente' =>  $data['ID_CLIENTE'],
								'idPeriodo' => $data['ID_PERIODO_ACADEMICO'],
								'idPlan' => 4,
								'idCarrera' => $data['ID_CARRERA'],
								'idSemestre' => $data["ID_NIVEL"],
								'nroItems' => 1,
								'valor'=>$valor,
								'aplicarRecargoGeneracion' => FALSE
							));
			}
			//$this->academico_model->actualizar_matricula($id_cliente,$recargo,$rubro);
			//$this->academico_model->actualizar_matricula($id_cliente,$valor_recargo_generacion,$recargo_por_generacion_rubro,$especial,$extraordinaria);
	  
		   //aplicar valores en la pension si aplica opciones extras
		   if(isset($data['ID_RUBRO_OPCIONAL']) and $data['ID_RUBRO_OPCIONAL']>0){
			   $this->load->model('facturacion/rubros_model');
			   $rubro_opcional = $this->rubros_model->buscar_rubros(array('ID_RUBRO'=>$data['ID_RUBRO_OPCIONAL']));//datos rubro extra
			   $valor=$rubro_opcional[0]['PRECIO'];
		   }else{
			   $valor=0;
		   }
		   //if($data['ESTADO']!=3){
			   $this->load->model('automatica/automatica_model');
			   $this->automatica_model->actualizar_valor_recargo_generacion($data['ID_CLIENTE'],$valor,$data['ID_CARRERA'],$data['ID_PERIODO_ACADEMICO']);		   
		   //}
		   //verifico si se trata de una nueva matricula en el periodo actual o actualizacion de matricula
		   $this->db->select('ID_MATRICULA');
		   $this->db->from('acad_matricula');
		   $this->db->where('ID_MATRICULA', $data['ID_MATRICULA']);
		   //$this->db->where('ID_PERIODO_ACADEMICO', $data['ID_PERIODO_ACADEMICO']);
		   $query_mat = $this->db->get();
		   $ds_mat = $query_mat->row_array();
			  
		   //if (isset($data['ID_MATRICULA']) && $data['ID_MATRICULA'] != NULL) 
		   if(isset($ds_mat['ID_MATRICULA']) && $ds_mat['ID_MATRICULA'] != NULL){
				//actualizo 
				$data['ID_PERSONA']=$id_persona;
				$data['FECHA_MODIFICACION']= date("Y-m-d H:i:s");
				$data['ID_USUARIO_ACTUALIZA']= $this->session->userdata('loggeado')['ID_USUARIO'];
				//comprobar cambio de grupo
				if($id_grupo_antiguo!=$id_grupo_a_asignar){
					//crear numero de matricula
					$sql="select max(SUBSTRING(NUMERO,-4,4)) as secuencial from acad_matricula where NUMERO like '".$nombre_grupo."0%' and ID_PERIODO_ACADEMICO=".$data['ID_PERIODO_ACADEMICO'];
					$query_num =$this->db->query($sql);
					$ds_num = $query_num->row_array();
					if($ds_num['secuencial']>0){
						$numero=$nombre_grupo.sprintf("%'.04d",$ds_num['secuencial']+1);
					}else{
						$numero=$nombre_grupo.'0001';
					}
					$data['NUMERO']=$numero;
				}				
				unset($data['NOMBRES']);
				unset($data['APELLIDOS']);
				unset($data['COLEGIO']);
				unset($data['TITULO']);
				unset($data['ID_CLIENTE']);
				unset($data['PRECIO']);
				unset($data['GRUPO']);
				unset($data['GRUPO_ASIGNADO']);
				unset($data['ID_SEDE_GRUPO']);
				$data['OBSERVACIONES']=trim($data['OBSERVACIONES']);
				$this->db->where('acad_matricula.ID_MATRICULA', $data['ID_MATRICULA']);
				$this->db->update('acad_matricula', $data);
				$resultado="Matricula Actualizada";
			}else{
				//la creo
				$data['ID_PERSONA']=$id_persona;
				$data['FECHA']= date("Y-m-d H:i:s");
				$data['ID_USUARIO']= $this->session->userdata('loggeado')['ID_USUARIO'];
				//incremento el ultimo numero de matricula si es primera matricula del estudiante
				/*$numero_matricula=$this->obtener_numero_unico_matricula($data['ID_CLIENTE']);
				if ($numero_matricula=='') {
				$this->incrementarUltimoNumeroDeMatricula();
				}
				*/
				//crear numero de matricula
				$sql="select max(SUBSTRING(NUMERO,-4,4)) as secuencial from acad_matricula where NUMERO like '".$nombre_grupo."0%' and ID_PERIODO_ACADEMICO=".$data['ID_PERIODO_ACADEMICO'];
				$query_num =$this->db->query($sql);
				$ds_num = $query_num->row_array();
				if($ds_num['secuencial']>0){
					$numero=$nombre_grupo.sprintf("%'.04d",$ds_num['secuencial']+1);
				}else{
					$numero=$nombre_grupo.'0001';
				}
				//$data['NUMERO']=$nombre_grupo.'0'.sprintf("%'.03d\n",$numero);
				$data['NUMERO']=$numero;	
				unset($data['NOMBRES']);
				unset($data['APELLIDOS']);
				unset($data['COLEGIO']);
				unset($data['TITULO']);
				unset($data['ID_CLIENTE']);
				unset($data['ID_MATRICULA']);
				unset($data['PRECIO']);
				unset($data['GRUPO']);
				unset($data['GRUPO_ASIGNADO']);
				unset($data['ID_SEDE_GRUPO']);				
				$this->db->insert('acad_matricula', $data);
				$resultado="Matricula Creada";
			}
		}else{	
			//obtengo el grupo al que será asignado
			$this->db->select('ID_GRUPO');
			$this->db->from('acad_grupo');
			$this->db->where('NOMBRE', $data['GRUPO_ASIGNADO']);
			$this->db->where('ID_CARRERA', $data['ID_CARRERA']);
			$this->db->where('ID_NIVEL', $data['ID_NIVEL']);
			$query = $this->db->get();
			$ds = $query->row_array();
			$id_grupo_a_asignar=$ds['ID_GRUPO'];
			unset($data['GRUPO_ASIGNADO']);
			//le asigno el grupo a la persona, y el nivel
			$data_grupo_persona = array();
			$data_grupo_persona['ID_GRUPO']=$id_grupo_a_asignar;
			//$data_grupo_persona['NIVEL']=$data['ID_NIVEL'];
			$this->db->where('ID_PERSONA', $id_persona);
			$this->db->update('tab_personas', $data_grupo_persona);
	
			$precio_total_por_materias=0;
			$cantidad_de_arrastres=0;
			$data_est_carr_mat=array();
			$docentes_asignados =  $data['DOCENTES_ASIGNADOS'];
			$data_est_carr_mat['ID_GRUPO']=$id_grupo_a_asignar;
			$materias_asignadas = $data['MATERIAS_ASIGNADAS'];
			
			foreach($materias_asignadas as $i=>$materia_asignada){
				$data_est_carr_mat['ID_PERSONA_DOCENTE']=$docentes_asignados[$i];
				//verifico si será asociada como arrastre
				$this->db->where('ID_PERSONA', $id_persona);
				$this->db->where('id_periodo_academico', $data['ID_PERIODO_ACADEMICO']);
				$this->db->where('nivel_materia', $data['ID_NIVEL']);
				$this->db->where('id_carrera_materia',   $materias_asignadas[$i]);
				$this->db->update('acad_estudiante_carrera_materia', $data_est_carr_mat);
			}
			$resultado="Fallo de Registro: Ya tiene calificaciones";
		}
		$this->db->trans_complete();
		return array('resultado'=>$resultado,'numero'=>$data['NUMERO'],'ids_materias_estudiante'=>$ids_materias_estudiante);
	}
	

	public function incrementarUltimoNumeroDeMatricula()
	{
		$sql ="update acad_parametro set VALOR = VALOR+1 WHERE ID_PARAMETRO=9 ";
		$this->db->query($sql);
	}
	

	public function getMateriasPorCarreraNivel($id_carrera, $id_nivel)
	{
		$sql ="select m.NOMBRE,cm.ID_CARRERA_MATERIA,cm.NIVEL_MATERIA,cm.CREDITOS_MATERIA,cm.PRECIO, cm.ID_MENCION from acad_carrera c inner join acad_carrera_materia cm on c.ID_CARRERA = cm.ID_CARRERA ";
		$sql .=" inner join acad_materia m on m.ID_MATERIA = cm.ID_MATERIA ";
		$sql .=" WHERE cm.ESTADO=1 AND c.ID_CARRERA=".$id_carrera;
		if($id_nivel!='' and $id_nivel!=NULL){
			$sql .=" AND cm.NIVEL_MATERIA=".$id_nivel;
		}
		$query = $this->db->query($sql);
		$ds = $query->result_array();
		return $ds;
	}
	

	public function getMateriasPorCarrera($id_carrera,$estado=null)
	{
		$sql ="select c.NOMBRE as NOMBRE_CARRERA, cm.PRECIO,m.NOMBRE,cm.ID_CARRERA_MATERIA,cm.NIVEL_MATERIA,cm.CREDITOS_MATERIA,cm.ID_CARRERA, cm.ESTADO, cm.ID_MENCION from acad_carrera c inner join acad_carrera_materia cm on c.ID_CARRERA = cm.ID_CARRERA ";
		$sql .=" inner join acad_materia m on m.ID_MATERIA = cm.ID_MATERIA ";
		if($id_carrera!=null){
			$sql .=" WHERE c.ID_CARRERA=".$id_carrera;
		}
		if($estado!=null){
			$sql .=" and cm.ESTADO=".$estado;
		}
		$sql .=" order by cm.ID_CARRERA, cm.NIVEL_MATERIA ASC";
		$query = $this->db->query($sql);
		$ds = $query->result_array();
		return $ds;            
	}
	

	public function getDocentes($id_periodo=null)
	{
		if($id_periodo==null){
			$id_periodo=$this->get_periodo_activado();	
		}
		$sql ="SELECT p.ID_PERSONA, CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE,p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as NOMBRE, ";
		$sql .="CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as NOMBRES, CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as APELLIDOS, ";
		$sql .="cli.NRO_DOCUMENTO as CEDULA ";
		$sql .=" from tab_personas p inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION";
		$sql .=" inner join tab_clientes_naturales clin on clin.ID_PERSONA = p.ID_PERSONA ";
		$sql .=" inner join tab_clientes cli on cli.ID_CLIENTE = clin.ID_CLIENTE ";
		$sql .=" WHERE o.ID_OCUPACION=2 ";
		$sql .=" ORDER BY NOMBRE ";
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 

		for($i=0;$i<count($ds);$i++){
			 $sql1 ="select ID_CARRERA_MATERIA FROM acad_docente_carrera_materia where ID_PERIODO_ACADEMICO=".$id_periodo." and ID_PERSONA=".$ds[$i]['ID_PERSONA'];
			 $query1 = $this->db->query($sql1);
			 $ds1 = $query1->result_array(); 
			 $cadena_ids_materias="";
			 for($j=0;$j<count($ds1);$j++){
				$cadena_ids_materias.=$ds1[$j]['ID_CARRERA_MATERIA']."-";
			 }
			 $ds[$i]['CADENA_MATERIAS']=$cadena_ids_materias;
		}
		return $ds;
	}
	

	public function get_materias_asignadas($id_cliente, $id_carrera, $id_periodo, $id_nivel)
	{
		//obtengo el id como persona
		$this->db->select('ID_PERSONA');
		$this->db->from('tab_clientes_naturales');
		$this->db->where('ID_CLIENTE', $id_cliente);
		$query = $this->db->get();
		$ds = $query->row_array();
		$id_persona = $ds['ID_PERSONA'];

		$this->db->select('ecm.ID_CARRERA_MATERIA, ecm.ID_PERSONA_DOCENTE,ecm.CREDITOS_MATERIA,ecm.ES_ARRASTRE,ecm.PRECIO,g.ID_GRUPO,g.NOMBRE');
		$this->db->from('acad_estudiante_carrera_materia ecm');
		$this->db->join('acad_grupo g','g.ID_GRUPO=ecm.ID_GRUPO','left');
		$this->db->where('ecm.ID_PERSONA', $id_persona);
		$this->db->where('ecm.ID_CARRERA', $id_carrera);
		$this->db->where('ecm.ID_PERIODO_ACADEMICO', $id_periodo);
		//$this->db->where('NIVEL_MATERIA', $id_nivel);
		$this->db->where('ecm.FUE_CONVALIDADA', 0);
		$this->db->where('ecm.FUE_HOMOLOGADA', 0);
		$this->db->where('ecm.FUE_HISTORIAL', 0);
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	

	public function get_materias_conv($id_cliente)
	{
		$id_periodo=$this->get_periodo_activado();
		//obtengo el id como persona
		$this->db->select('ID_PERSONA');
		$this->db->from('tab_clientes_naturales');
		$this->db->where('ID_CLIENTE', $id_cliente);
		$query = $this->db->get();
		$ds = $query->row_array();
		$id_persona = $ds['ID_PERSONA'];

		$this->db->select('ID_CARRERA_MATERIA, NOTA_CONVALIDACION');
		$this->db->from('acad_estudiante_carrera_materia');
		$this->db->where('ID_PERSONA', $id_persona);
		//$this->db->where('ID_PERIODO_ACADEMICO', $id_periodo);
		$this->db->where('FUE_CONVALIDADA', 1);
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	

	public function get_materias_homo($id_cliente)
	{
		$id_periodo= $this->get_periodo_activado();
		//obtengo el id como persona
		$this->db->select('ID_PERSONA');
		$this->db->from('tab_clientes_naturales');
		$this->db->where('ID_CLIENTE', $id_cliente);
		$query = $this->db->get();
		$ds = $query->row_array();
		$id_persona = $ds['ID_PERSONA'];

		$this->db->select('ID_CARRERA_MATERIA, NOTA_HOMOLOGACION, REGISTRO_HOMOLOGACION');
		$this->db->from('acad_estudiante_carrera_materia');
		$this->db->where('ID_PERSONA', $id_persona);
		//$this->db->where('ID_PERIODO_ACADEMICO', $id_periodo);
		$this->db->where('FUE_HOMOLOGADA', 1);
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	

	public function get_grupo_asignado($id_cliente, $id_carrera, $id_periodo, $id_nivel)
	{
		//obtengo el id como persona
		$this->db->select('ID_PERSONA');
		$this->db->from('tab_clientes_naturales');
		$this->db->where('ID_CLIENTE', $id_cliente);
		$query = $this->db->get();
		$ds = $query->row_array();
		$id_persona = $ds['ID_PERSONA'];
		
		//$this->db->select('acad_grupo.NOMBRE');
		//$this->db->from('acad_estudiante_carrera_materia');
		//$this->db->join('acad_grupo', 'acad_grupo.ID_GRUPO = acad_estudiante_carrera_materia.ID_GRUPO');
		//$this->db->where('acad_estudiante_carrera_materia.ID_PERSONA', $id_persona);
		//$this->db->where('acad_estudiante_carrera_materia.ID_CARRERA', $id_carrera);
		//$this->db->where('acad_estudiante_carrera_materia.ID_PERIODO_ACADEMICO', $id_periodo);
		//$this->db->where('acad_estudiante_carrera_materia.NIVEL_MATERIA', $id_nivel);
		//$this->db->limit(1);
		//$query = $this->db->get();
		//$ds = $query->row_array();
		//if($ds['NOMBRE']==NULL){
			$this->db->select('acad_grupo.NOMBRE');
			$this->db->from('acad_matricula');
			$this->db->join('acad_grupo', 'acad_grupo.ID_GRUPO = acad_matricula.ID_GRUPO');
			$this->db->where('acad_matricula.ID_PERSONA', $id_persona);
			$this->db->where('acad_matricula.ID_CARRERA', $id_carrera);
			$this->db->where('acad_matricula.ID_PERIODO_ACADEMICO', $id_periodo);
			$this->db->where('acad_matricula.ID_NIVEL', $id_nivel);
			$this->db->limit(1);
			$query = $this->db->get();
			$ds = $query->row_array();
			if($ds['NOMBRE']==NULL){
				$this->db->select('acad_grupo.NOMBRE');
				$this->db->from('acad_estudiante_carrera_materia');
				$this->db->join('acad_grupo', 'acad_grupo.ID_GRUPO = acad_estudiante_carrera_materia.ID_GRUPO');
				$this->db->where('acad_estudiante_carrera_materia.ID_PERSONA', $id_persona);
				$this->db->where('acad_estudiante_carrera_materia.ID_CARRERA', $id_carrera);
				$this->db->where('acad_estudiante_carrera_materia.ID_PERIODO_ACADEMICO', $id_periodo);
				$this->db->where('acad_estudiante_carrera_materia.NIVEL_MATERIA', $id_nivel);
				$this->db->limit(1);
				$query = $this->db->get();
				$ds = $query->row_array();
			}
		//}
		return $ds['NOMBRE'];
	}


	public function obtener_rubros($id_tipo_rubro) 
	{
		$this->db->select('*');
		$this->db->from('fac_rubros');
		$this->db->where('fac_rubros.ID_TIPO_RUBRO', $id_tipo_rubro);
		$consulta = $this->db->get();
		return $consulta->result();
	}
	

	public function obtener_rubros_semestre_del_nivel($nivel) //este metodo me da los rubros teniendo en cuenta el nivel
	{
		$this->db->select('fac_rubros.*,fac_rubros_semestres.SEMESTRES_Q_SE_APLICA');
		$this->db->from('fac_rubros');
		$this->db->join('fac_rubros_semestres', 'fac_rubros.ID_RUBRO = fac_rubros_semestres.ID_RUBRO');
		$this->db->where('fac_rubros.ID_TIPO_RUBRO', 3); //rubros de semestre
		$query = $this->db->get();
		$ds = $query->result_array();

		$resultado= array();
		for($i=0; $i<count($ds);$i++){
			$semestres_q_se_aplica = $ds[$i]['SEMESTRES_Q_SE_APLICA'];
			if($semestres_q_se_aplica==NULL){
				array_push($resultado, $ds[$i]);
			}else{
				$pos = strpos($semestres_q_se_aplica, (string)$nivel);
				if($pos!==false){//si este rubro se aplica al nivel
					array_push($resultado, $ds[$i]);
				}                
			}
		}
		return $resultado;
		
	}
	
	// **************************************************************************************
	public function crearGruposEst($nombre,$sede)
	{
		$existe = $this->buscarGrupoEst($nombre);
		if($existe){
			return false;
		}else{
			//busco las carreras
			$this->db->select('ID_CARRERA');
			$this->db->from('acad_carrera');
			$query = $this->db->get();
			$ds = $query->result_array();
			if(count($ds)>0){
				for($i=0; $i<count($ds);$i++){
					$id_c = $ds[$i]['ID_CARRERA'];
					 for($j=1; $j<=6;$j++){
						$this->db->insert('acad_grupo', array('NOMBRE'=>$nombre,
															'ID_CARRERA'=>$id_c,
															'ID_NIVEL'=>$j,
															'ID_SEDE'=>$sede
										 ));
					 }
				}
				return true;
			}              
		}
	}
	

	public function buscarGrupoEst($nombre)
	{
		$this->db->select('*');
		$this->db->from('acad_grupo');
		$this->db->where('NOMBRE', $nombre);
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)>0)
			return true;
		else
			return false;
	}
	

	public function get_ultimo_numero_matricula()
	{
		$this->db->select('VALOR');
		$this->db->from('acad_parametro');
		$this->db->where('ID_PARAMETRO', 9);
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds['VALOR'];
	}
	

	public function buscarGruposEst($ids_sede=null,$id_periodo=null)
	{
		$this->db->distinct();
		$this->db->select('NOMBRE');
		$this->db->from('acad_grupo');
		if($ids_sede!=null){
			$this->db->where_in('ID_SEDE',$ids_sede);
		}
		if($id_periodo!=null){
			$this->db->where('ID_GRUPO in (select ID_GRUPO from acad_matricula where ID_PERIODO_ACADEMICO='.$id_periodo.')');
		}
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)>0){
			$nombres="";
			for($i=0;$i<count($ds);$i++){
				$nombres.=$ds[$i]['NOMBRE']." - ";
			}
			$nombres = substr($nombres, 0, strlen($nombres)-2);
			return $nombres;
		}else{
			return false;
		}
	}
	// **************************************************************************************
	// DOCENTE MATERIA
	public function buscarDocenteMateria($ap, $am, $pn, $sn, $id_carrera, $id_nivel)
	{
		$id_periodo_activado = $this->academico_model->get_periodo_activado();        
		$sql ="select dcm.ID_DOCENTE_CARRERA_MATERIA,p.ID_PERSONA,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE, p.APELLIDO_PATERNO, p.APELLIDO_MATERNO ";
		$sql.= "from tab_personas p inner join tab_clientes_naturales cn on cn.ID_PERSONA = p.ID_PERSONA ";
		$sql.= "left join acad_docente_carrera_materia dcm on dcm.ID_PERSONA = p.ID_PERSONA  inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION WHERE o.ID_OCUPACION=2 ";
		if($ap!="" && $ap!=null)
			$sql .=" and p.APELLIDO_PATERNO like '%".$ap."%' " ;
		if($am!="" && $am!=null)
			$sql .=" and p.APELLIDO_MATERNO like '%".$am."%' " ;
		if($pn!="" && $pn!=null)
			$sql .=" and p.PRIMER_NOMBRE like '%".$pn."%' " ;
		if($sn!="" && $sn!=null)
			$sql .=" and p.SEGUNDO_NOMBRE like '%".$sn."%' " ;
		if($id_carrera!="" && $id_carrera!=null)
			$sql .=" and dcm.ID_CARRERA=".$id_carrera;
		if($id_nivel!="" && $id_nivel!=null)
			$sql .=" and dcm.NIVEL_MATERIA=".$id_nivel;

		if ($this->session->userdata('loggeado')['ID_PERFIL']==4) {
			$sql .=" and dcm.ID_PERSONA=".$this->session->userdata('loggeado')['ID_PERSONA'];			
		}
		$sql.= " group by p.ID_PERSONA ";
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		if(count($ds)>0)
			return $ds;
		else
			return false;
	}
	

	public function get_datos_docente($id_persona) 
	{
		$sql = "select CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as APELLIDOS, ";
		$sql .= "CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as NOMBRES, ";
		$sql .= "DOC_TITULO_PROF as TITULO, ";
		$sql .= "DOC_INSTITUCION as INST ";
		$sql .= " from tab_personas p inner join tab_clientes_naturales cn on p.ID_PERSONA = cn.ID_PERSONA ";
		$sql .= " inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION where p.OCUPACION=2 and cn.ID_PERSONA=".$id_persona;
		$query = $this->db->query($sql);
		$ds = $query->row_array();
		return $ds;
	}
	

	public function crearActualizarDocenteMateria($data)
	{
		$this->db->trans_start();
		$p_activado = $this->get_periodo_activado();
		//obtengo el id como persona
		$id_persona = $data['ID_PERSONA'];
		$ids_docente_carrera_materia=array();
		//asocio las nuevas materias asignadas al docente
		if(isset($data['MATERIAS_ASIGNADAS'])){
			$data_doc_carr_mat=array();
			$data_doc_carr_mat['ID_PERSONA']=$id_persona;
			$data_doc_carr_mat['ID_PERIODO_ACADEMICO']=$data['ID_PERIODO_ACADEMICO'];
			$materias_asignadas = $data['MATERIAS_ASIGNADAS'];
			for($i=0; $i<count($materias_asignadas); $i++){
				$data_doc_carr_mat['ID_CARRERA_MATERIA']=$materias_asignadas[$i];
				//busco el nivel y la carrera de la materia
				$this->db->select('ID_CARRERA,NIVEL_MATERIA');
				$this->db->from('acad_carrera_materia');
				$this->db->where('ID_CARRERA_MATERIA', $materias_asignadas[$i]);
				$query = $this->db->get();
				$ds = $query->row_array();
				$data_doc_carr_mat['NIVEL_MATERIA'] = $ds['NIVEL_MATERIA'];  
				$data_doc_carr_mat['ID_CARRERA']=$ds['ID_CARRERA'];
				//revisar si es actualizacion o creacion
				$this->db->select('ID_DOCENTE_CARRERA_MATERIA');
				$this->db->from('acad_docente_carrera_materia');
				$this->db->where($data_doc_carr_mat);
				$query1 = $this->db->get();
				$ds1 = $query1->row_array();
				if($ds1==NULL){
					$this->db->insert('acad_docente_carrera_materia', $data_doc_carr_mat);
					$ids_docente_carrera_materia[]=$this->db->insert_id();
				}else{
					$ids_docente_carrera_materia[]=$ds1['ID_DOCENTE_CARRERA_MATERIA'];
				}
			}
		}
		//buscar para eliminar las materias que voy a asignar el docente
		$this->db->select('*');
		$this->db->from('acad_docente_carrera_materia');
		$this->db->where('ID_PERSONA', $id_persona);
		$this->db->where('ID_PERIODO_ACADEMICO', $p_activado);
		if(count($ids_docente_carrera_materia)>0){
			$this->db->where_not_in('ID_DOCENTE_CARRERA_MATERIA', $ids_docente_carrera_materia);
		}
		$query2 = $this->db->get();
		$ds2 = $query2->result_array();

		//elimino las materias que tiene asignada el docente
		$this->db->where('ID_PERSONA', $id_persona);
		$this->db->where('ID_PERIODO_ACADEMICO', $p_activado);
		if(count($ids_docente_carrera_materia)>0){
			$this->db->where_not_in('ID_DOCENTE_CARRERA_MATERIA', $ids_docente_carrera_materia);
		}
		$this->db->delete('acad_docente_carrera_materia'); 
		$this->db->trans_complete();
		return $ds2;
	}
	

	public function get_materias_asignadas_al_docente($id_persona)
	{
		$periodo= $this->get_periodo_activado();
		$this->db->select('ID_CARRERA_MATERIA');
		$this->db->from('acad_docente_carrera_materia');
		$this->db->where('ID_PERSONA', $id_persona);
		$this->db->where('ID_PERIODO_ACADEMICO', $periodo);
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	// **************************************************************************************
	public function get_datos_cliente_para_crear_usuario($id_cliente)
	{
		$this->db->select('tab_contactos.CORREO_ELECTRONICO, tab_personas.*,tab_clientes.*');
		$this->db->from('tab_personas');
		$this->db->join('tab_clientes_naturales', 'tab_clientes_naturales.ID_PERSONA = tab_personas.ID_PERSONA');
		$this->db->join('tab_clientes', 'tab_clientes.ID_CLIENTE = tab_clientes_naturales.ID_CLIENTE');
		$this->db->join('tab_contactos', 'tab_contactos.ID_CLIENTE = tab_clientes.ID_CLIENTE');
		$this->db->where('tab_clientes.ID_CLIENTE', $id_cliente);
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds;
	}
	
	// **************************************************************************************
	public function reporte_docentes_por_materia($id_carrera, $id_modalidad,$pn,$ap)
	{
		$id_periodo_activado = $this->academico_model->get_periodo_activado();
		/*$sql="select "; 
		$sql.="c.NOMBRE as CARRERA, ";
		$sql.="m.NOMBRE as MATERIA, ";
		$sql.="cm.NIVEL_MATERIA, ";
		$sql.="CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE,p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as DOCENTE ";
		$sql.="from ";
		$sql.="acad_carrera_materia cm left join  acad_docente_carrera_materia dcm on cm.ID_CARRERA_MATERIA = dcm.ID_CARRERA_MATERIA ";
		$sql.="inner join acad_materia m on m.ID_MATERIA = cm.ID_MATERIA ";
		$sql.="inner join acad_carrera c on c.ID_CARRERA = cm.ID_CARRERA ";
		$sql.="inner join acad_modalidad mo on mo.ID_MODALIDAD=c.ID_MODALIDAD "; 
		$sql.="left join tab_personas p on p.ID_PERSONA=dcm.ID_PERSONA ";
		$sql.= "where (dcm.ID_PERIODO_ACADEMICO IS NULL or dcm.ID_PERIODO_ACADEMICO=".$id_periodo_activado.") ";*/
		
		$sql="select "; 
		$sql.="c.NOMBRE as CARRERA, ";
		$sql.="m.NOMBRE as MATERIA, ";
		$sql.="cm.NIVEL_MATERIA, ";
		$sql.="CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE,p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as DOCENTE ";
		$sql.="from ";
		$sql.="acad_carrera_materia cm ";
		$sql.="inner join acad_materia m on m.ID_MATERIA = cm.ID_MATERIA ";
		$sql.="inner join acad_carrera c on c.ID_CARRERA = cm.ID_CARRERA ";
		$sql.="inner join acad_modalidad mo on mo.ID_MODALIDAD=c.ID_MODALIDAD "; 
		$sql.="left join  acad_docente_carrera_materia dcm on cm.ID_CARRERA_MATERIA = dcm.ID_CARRERA_MATERIA and dcm.ID_PERIODO_ACADEMICO=".$id_periodo_activado." ";
		$sql.="left join tab_personas p on p.ID_PERSONA=dcm.ID_PERSONA ";
		$sql.= "where cm.ID_CARRERA_MATERIA>0";
		if($pn!="" && $pn!=null)
			$sql .=" and p.PRIMER_NOMBRE like '%".$pn."%' " ;
		if($ap!="" && $ap!=null)
			$sql .=" and p.APELLIDO_PATERNO like '%".$ap."%' " ;
		if($id_carrera!="" && $id_carrera!=null)
			$sql .=" and cm.ID_CARRERA=".$id_carrera;
		if($id_modalidad!="" && $id_modalidad!=null)
			$sql .=" and c.ID_MODALIDAD=".$id_modalidad;
		$sql.=" ORDER BY c.ID_CARRERA asc, cm.ID_MATERIA asc ";
		$query = $this->db->query($sql);
		$ds = $query->result_array();
		return $ds;
	}
	// **************************************************************************************
  
	// **************************************************************************************
	public function seleccionado_plan_de_pago($id_cliente,$id_carrera=null,$periodo=null) //si tiene seleccionado plan de pago 
	{
		if($periodo==null){
			$periodo=$this->get_periodo_activado();
		}
		$this->db->select('fac_clientes_rubros.SELECCIONADO_PLAN_PAGO');
		$this->db->from('fac_clientes_rubros');
		$this->db->join('fac_rubros', 'fac_rubros.ID_RUBRO = fac_clientes_rubros.ID_RUBRO');
		$this->db->where('fac_rubros.ID_RUBRO', 17);
		$this->db->where('fac_clientes_rubros.periodo_vigente', $periodo);
		$this->db->where('fac_clientes_rubros.ID_CLIENTE', $id_cliente);
		if($id_carrera!=null){
			$this->db->where('fac_clientes_rubros.ID_CARRERA', $id_carrera);
		}
		$this->db->where('fac_clientes_rubros.SELECCIONADO_PLAN_PAGO', 1);
		$query = $this->db->get();
		$ds = $query->row_array();
		if($ds['SELECCIONADO_PLAN_PAGO']==1)
			return true;
		else
			return false;
	}
	// **************************************************************************************
	//SISTEMA DE CALIFICACION
	public function crearComponente($nombre, $valor)
	{   
		$this->db->insert('acad_componente', array('NOMBRE'=>$nombre,'VALOR'=>$valor));
		return $this->db->insert_id();
	}
	

	public function get_componentes()
	{
		$this->db->select('*');
		$this->db->from('acad_componente');
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	

	public function eliminarComponente($id)
	{
		$this->db->where('ID_COMPONENTE', $id);
		$this->db->delete('acad_componente'); 
	}
	

	public function updateValorComponente($id, $valor)
	{   
		$data = array();
		$data['VALOR'] = $valor;
		//actualizo
		$this->db->where('acad_componente.ID_COMPONENTE', $id);
		$this->db->update('acad_componente', $data);
	}
	

	public function crearActualizarConfiguracionCalificaciones($data)
	{
		$this->db->trans_start();
		//recorro los arreglos paralelos: carrera y modalidad
		$p_activado = $this->get_periodo_activado();
		$cant_etapas = $data['ETAPAS'];
		$base = $data['BASE'];
		$cant_componentes=count($data['COMPONENTE']);
		for($i=0;$i<count($data['CARRERA']);$i++){
			$id_carrera = $data['CARRERA'][$i];
			$id_modalidad = $data['MODALIDAD'][$i];
			$configurada=false;
			//acomodo los datos a enviar
			$data_carrera_modalidad = array();
			$data_carrera_modalidad['ID_CARRERA']=$id_carrera;
			$data_carrera_modalidad['ID_MODALIDAD']=$id_modalidad;
			$data_carrera_modalidad['CANT_ETAPAS']=$cant_etapas;
			$data_carrera_modalidad['CANT_COMPONENTES']=$cant_componentes;
			$data_carrera_modalidad['ID_PERIODO_ACADEMICO']=$p_activado;
			$data_carrera_modalidad['BASE']=$base;
			//busco si ya esta carrera-modalidad tiene alguna configuración
			$this->db->select('ID_CARRERA_MODALIDAD');
			$this->db->from('acad_carrera_modalidad');
			$this->db->where('ID_CARRERA', $id_carrera);
			$this->db->where('ID_MODALIDAD', $id_modalidad);
			$this->db->where('ID_PERIODO_ACADEMICO', $p_activado);
			$query = $this->db->get();
			$ds = $query->row_array();
			if(count($ds)>0){
				$configurada=true;
				$id_carrera_modalidad = $ds['ID_CARRERA_MODALIDAD'];
			}else{
				$configurada=false;
			}            
			if($configurada){
				//si está configurada, elimino la configuración acutal
				$this->db->where('ID_CARRERA_MODALIDAD', $id_carrera_modalidad);
				$this->db->delete('acad_carrera_modalidad_componente'); 

				$this->db->where('ID_CARRERA_MODALIDAD', $id_carrera_modalidad);
				$this->db->delete('acad_carrera_modalidad'); 
			}
			//creo la configuración
			$this->db->insert('acad_carrera_modalidad', $data_carrera_modalidad);
			$id_carrera_modalidad_generado = $this->db->insert_id();
			//inserto en carrera-modalidad-componente
			$data_carrera_modalidad_componente = array();
			$data_carrera_modalidad_componente['ID_CARRERA_MODALIDAD']=$id_carrera_modalidad_generado;
			$data_carrera_modalidad_componente['ID_PERIODO_ACADEMICO']=$p_activado;
			for($w=0;$w<count($data['COMPONENTE']);$w++){
				$data_carrera_modalidad_componente['ID_COMPONENTE']=$data['COMPONENTE'][$w];
				//busco el valor del componente actual
				$this->db->select('VALOR');
				$this->db->from('acad_componente');
				$this->db->where('ID_COMPONENTE', $data['COMPONENTE'][$w]);
				$query = $this->db->get();
				$ds1 = $query->row_array();
				$data_carrera_modalidad_componente['VALOR_COMPONENTE']=$ds1['VALOR'];
				$this->db->insert('acad_carrera_modalidad_componente', $data_carrera_modalidad_componente);
			}
		}
		$this->db->trans_complete();
	}
	
	public function get_carrera_modalidad_configuradas()
	{
		$p_activado = $this->get_periodo_activado();
		//obtengo todas las carrera-modalidad que estan creadas en el periodo actual
		$this->db->select('acad_carrera_modalidad.*,acad_carrera.NOMBRE,acad_modalidad.MODALIDAD');
		$this->db->from('acad_carrera_modalidad');
		$this->db->join('acad_carrera', 'acad_carrera.ID_CARRERA = acad_carrera_modalidad.ID_CARRERA');
		$this->db->join('acad_modalidad', 'acad_modalidad.ID_MODALIDAD = acad_carrera_modalidad.ID_MODALIDAD');
		$this->db->where('ID_PERIODO_ACADEMICO', $p_activado);
		$query = $this->db->get();
		$arreglo_carrera_modalidad = $query->result_array();
		//recorro y a cada carrera-modalidad le agrego una lista con sus componentes-valor
		for($w=0;$w<count($arreglo_carrera_modalidad);$w++){
			$id_carrera_modalidad = $arreglo_carrera_modalidad[$w]['ID_CARRERA_MODALIDAD'];
			$this->db->select('acad_carrera_modalidad_componente.VALOR_COMPONENTE, acad_componente.NOMBRE, acad_componente.ID_COMPONENTE');
			$this->db->from('acad_carrera_modalidad_componente');
			$this->db->join('acad_componente', 'acad_componente.ID_COMPONENTE = acad_carrera_modalidad_componente.ID_COMPONENTE');
			$this->db->where('acad_carrera_modalidad_componente.ID_PERIODO_ACADEMICO', $p_activado);
			$this->db->where('acad_carrera_modalidad_componente.ID_CARRERA_MODALIDAD', $id_carrera_modalidad);
			$query = $this->db->get();
			$arreglo_componentes = $query->result_array();
			$arreglo_carrera_modalidad[$w]['COMPONENTES']=$arreglo_componentes;
		 }
		 return $arreglo_carrera_modalidad;
	}

	
	// **************************************************************************************
	//CALIFICAR
	public function get_materias_del_docente_para_calificar($id_persona)
	{
		$periodo= $this->get_periodo_activado();
		$this->db->select('acad_docente_carrera_materia.*,
			acad_carrera.NOMBRE as CARRERA, 
			acad_materia.NOMBRE as MATERIA, acad_materia.ID_MATERIA,
			acad_nivel.NIVEL, acad_nivel.ID_NIVEL');
		$this->db->from('acad_docente_carrera_materia');
		$this->db->join('acad_carrera_materia', 'acad_carrera_materia.ID_CARRERA_MATERIA = acad_docente_carrera_materia.ID_CARRERA_MATERIA');
		$this->db->join('acad_carrera', 'acad_carrera.ID_CARRERA = acad_carrera_materia.ID_CARRERA');
		$this->db->join('acad_materia', 'acad_materia.ID_MATERIA = acad_carrera_materia.ID_MATERIA');
		$this->db->join('acad_nivel', 'acad_nivel.ID_NIVEL = acad_carrera_materia.NIVEL_MATERIA');
		$this->db->where('acad_docente_carrera_materia.ID_PERSONA', $id_persona);
		$this->db->where('acad_docente_carrera_materia.ID_PERIODO_ACADEMICO', $periodo);
		$this->db->order_by("acad_carrera.ID_CARRERA", "asc");
		$this->db->order_by("acad_materia.NOMBRE", "asc"); 
		$this->db->order_by("acad_nivel.ID_NIVEL", "asc");
		$query = $this->db->get();
		$ds = $query->result_array(); 
		return $ds;
	}
	

	public function buscar_grupos_calificar($id_carrera, $id_materia, $id_nivel,$id_persona,$tipo=0,$periodo=null)
	{
		if($periodo==null){
			$periodo= $this->get_periodo_activado();
		}
		/*$this->db->select(' acad_grupo.ID_GRUPO,
							acad_materia.ID_MATERIA,
							acad_estudiante_carrera_materia.ID_PERSONA_DOCENTE,
							acad_grupo.NOMBRE as GRUPO,
							acad_carrera.NOMBRE as CARRERA,
							acad_nivel.NIVEL as NIVEL,
							acad_materia.NOMBRE as MATERIA');
		$this->db->from('acad_estudiante_carrera_materia');
		$this->db->join('acad_carrera_materia', 'acad_carrera_materia.ID_CARRERA_MATERIA = acad_estudiante_carrera_materia.ID_CARRERA_MATERIA');
		$this->db->join('acad_grupo', 'acad_grupo.ID_GRUPO = acad_estudiante_carrera_materia.ID_GRUPO');
		$this->db->join('acad_carrera', 'acad_carrera.ID_CARRERA = acad_carrera_materia.ID_CARRERA');
		$this->db->join('acad_nivel', 'acad_nivel.ID_NIVEL = acad_carrera_materia.NIVEL_MATERIA');
		$this->db->join('acad_materia', 'acad_materia.ID_MATERIA = acad_carrera_materia.ID_MATERIA');
		if($id_carrera!=NULL){
			$this->db->where('acad_carrera_materia.ID_CARRERA',$id_carrera );
		}
		if($id_materia!=NULL){
			$this->db->where('acad_carrera_materia.ID_MATERIA',$id_materia );
		}
		if($id_nivel!=NULL){
			$this->db->where('acad_carrera_materia.NIVEL_MATERIA',$id_nivel );
		}
		if($id_persona!=NULL){
			$this->db->where('acad_estudiante_carrera_materia.ID_PERSONA_DOCENTE',$id_persona );
		}
		$this->db->where('acad_estudiante_carrera_materia.ID_PERIODO_ACADEMICO',$periodo );
		
		if($tipo==1){//si es para reporte calificacion
			$this->db->group_by(array("acad_grupo.ID_GRUPO","acad_estudiante_carrera_materia.ID_CARRERA_MATERIA"));
		}else{//si es para calificar
			//$this->db->group_by("acad_grupo.ID_GRUPO", "asc");
			//$this->db->group_by(array("acad_grupo.ID_GRUPO","acad_estudiante_carrera_materia.ID_CARRERA_MATERIA"));
			$this->db->group_by(array("acad_grupo.NOMBRE","acad_materia.NOMBRE"));
			//$this->db->group_by(array("acad_grupo.ID_GRUPO","acad_materia.NOMBRE"));
		}
		$this->db->order_by("GRUPO","ASC");*/
		
		
		$this->db->select(' acad_grupo.ID_GRUPO,
							acad_materia.ID_MATERIA,
							pla.ID_PERSONA as ID_PERSONA_DOCENTE,
							pla.ID_PLANTILLA,
							acad_grupo.NOMBRE as GRUPO,
							acad_carrera.NOMBRE as CARRERA,
							acad_nivel.NIVEL as NIVEL,
							acad_materia.NOMBRE as MATERIA');
		$this->db->from('acad_planificacion pla');
		$this->db->join('acad_carrera_materia', 'acad_carrera_materia.ID_CARRERA_MATERIA = pla.ID_CARRERA_MATERIA');
		$this->db->join('acad_grupo', 'acad_grupo.ID_GRUPO = pla.ID_GRUPO');
		$this->db->join('acad_carrera', 'acad_carrera.ID_CARRERA = acad_carrera_materia.ID_CARRERA');
		$this->db->join('acad_nivel', 'acad_nivel.ID_NIVEL = acad_carrera_materia.NIVEL_MATERIA');
		$this->db->join('acad_materia', 'acad_materia.ID_MATERIA = acad_carrera_materia.ID_MATERIA');
		if($id_carrera!=NULL){
			$this->db->where('acad_carrera_materia.ID_CARRERA',$id_carrera );
		}
		if($id_materia!=NULL){
			$this->db->where('acad_carrera_materia.ID_MATERIA',$id_materia );
		}
		if($id_nivel!=NULL){
			$this->db->where('acad_carrera_materia.NIVEL_MATERIA',$id_nivel );
		}
		if($id_persona!=NULL){
			$this->db->where('pla.ID_PERSONA',$id_persona );
		}
		$this->db->where('pla.ID_PERIODO_ACADEMICO',$periodo );
		
		if($tipo==1){//si es para reporte calificacion
			$this->db->group_by(array("acad_grupo.ID_GRUPO","pla.ID_CARRERA_MATERIA"));
		}else{//si es para calificar
			$this->db->group_by(array("acad_grupo.NOMBRE","acad_materia.NOMBRE","pla.ID_PLANTILLA"));
		}
		$this->db->order_by("GRUPO","ASC");
		
		$query = $this->db->get();
		$ds = $query->result_array(); 
		return $ds;
	}
	
	
	public function buscar_grupos($id_carrera, $id_materia, $id_nivel)
	{
		$periodo= $this->get_periodo_activado();
		$this->db->select(' acad_grupo.ID_GRUPO,
							acad_materia.ID_MATERIA,
							acad_estudiante_carrera_materia.ID_PERSONA_DOCENTE,
							acad_grupo.NOMBRE as GRUPO,
							acad_carrera.NOMBRE as CARRERA,
							acad_nivel.NIVEL as NIVEL,
							acad_materia.NOMBRE as MATERIA');
		$this->db->from('acad_estudiante_carrera_materia');
		$this->db->join('acad_carrera_materia', 'acad_carrera_materia.ID_CARRERA_MATERIA = acad_estudiante_carrera_materia.ID_CARRERA_MATERIA');
		$this->db->join('acad_grupo', 'acad_grupo.ID_GRUPO = acad_estudiante_carrera_materia.ID_GRUPO');
		$this->db->join('acad_carrera', 'acad_carrera.ID_CARRERA = acad_carrera_materia.ID_CARRERA');
		$this->db->join('acad_nivel', 'acad_nivel.ID_NIVEL = acad_carrera_materia.NIVEL_MATERIA');
		$this->db->join('acad_materia', 'acad_materia.ID_MATERIA = acad_carrera_materia.ID_MATERIA');
		$this->db->where('acad_carrera_materia.ID_CARRERA',$id_carrera );
		$this->db->where('acad_carrera_materia.ID_MATERIA',$id_materia );
		$this->db->where('acad_carrera_materia.NIVEL_MATERIA',$id_nivel );
		//$this->db->where('acad_estudiante_carrera_materia.ID_PERSONA_DOCENTE',$id_persona );
		$this->db->where('acad_estudiante_carrera_materia.ID_PERIODO_ACADEMICO',$periodo );
		$this->db->group_by("acad_grupo.ID_GRUPO", "asc");
		$query = $this->db->get();
		$ds = $query->result_array(); 
		return $ds;
	}
	

	public function listaAlumnos($id_carrera,$id_nivel,$id_periodo_academico,$grupo=null,$estado_matricula=null,$accesos=null,$ids_matricula=array(),$idUsuarioAcademico=null)
	{  
		$periodo= $this->get_periodo_activado();
		/*
		$this->db->select("DISTINCT CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as NOMBRE_COMPLETO, an.id_nivel, an.NIVEL as NIVEL, ag.id_grupo as ID_GRUPO, ag.NOMBRE as GRUPO, ac.id_carrera, ac.NOMBRE as CARRERA, p.ID_PERSONA, cli.nro_documento as CEDULA, cnt.CORREO_ELECTRONICO AS CORREO, cnt.TELEFONO AS TELEFONO, cnt.CELULAR AS CELULAR ",false);
		$this->db->from('acad_estudiante_carrera_materia aem');
		$this->db->join('tab_personas p', 'p.ID_PERSONA = aem.ID_PERSONA ');
		$this->db->join('tab_clientes_naturales cn', 'cn.ID_PERSONA = p.ID_PERSONA ');
		$this->db->join('tab_clientes cli', 'cli.ID_CLIENTE =cn.ID_CLIENTE ');
		$this->db->join('tab_contactos cnt', 'cnt.ID_CLIENTE=cli.ID_CLIENTE ');
		$this->db->join('acad_carrera ac', 'aem.ID_CARRERA = ac.ID_CARRERA ');
		$this->db->join('acad_nivel an', 'aem.NIVEL_MATERIA = an.ID_NIVEL ');
		$this->db->join('acad_grupo ag', 'aem.ID_GRUPO = ag.ID_GRUPO ');
		$this->db->where('cnt.ESTADO',1 ); 
		$this->db->where('cnt.ID_TIPO_CONTACTO',2 );
		//$this->db->where('aem.ID_CARRERA',$id_carrera );        
		//$this->db->where('aem.NIVEL_MATERIA',$id_nivel );
		//$this->db->where('aem.ID_PERIODO_ACADEMICO',$id_periodo_academico );        
		//$this->db->order_by("NOMBRE_COMPLETO","asc");
  
		if($id_carrera != null ){
			$this->db->where('aem.ID_CARRERA',$id_carrera );
		}
		if($id_nivel !=null){
			$this->db->where('aem.NIVEL_MATERIA',$id_nivel );
		}
		if($id_periodo_academico !=null){
			$this->db->where('aem.ID_PERIODO_ACADEMICO',$id_periodo_academico);
		}
		$this->db->order_by("NOMBRE_COMPLETO","asc");
		$query = $this->db->get();
		$ds = $query->result_array();
		*/
		$sql_adi='';
		if($accesos!=null){
			$sql_adi=',u.FECHA_ENVIO_ACCESO, u.ID_USUARIO, uo.CLAVE_OFFICE';
		}
				
		$this->db->select("DISTINCT CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as NOMBRE_COMPLETO, CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as APELLIDOS, CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as NOMBRES, p.ID_PERSONA as ID_PERSONA, m.ID_PERIODO_ACADEMICO as ID_PERIODO_ACADEMICO, m.ESTADO as ESTADO_MATRICULA,  cli.ID_CLIENTE as ID_CLIENTE, an.id_nivel, an.NIVEL as NIVEL, ac.id_carrera, ac.NOMBRE as CARRERA, cli.nro_documento as CEDULA, cnt.CORREO_ELECTRONICO, p.CORREO_INSTITUCIONAL AS CORREO, cnt.TELEFONO AS TELEFONO, cnt.CELULAR AS CELULAR, m.ID_MATRICULA, g.NOMBRE as GRUPO ".$sql_adi,false);
		$this->db->from('acad_matricula m');
		$this->db->join('tab_personas p', 'p.ID_PERSONA = m.ID_PERSONA ');
		$this->db->join('tab_clientes_naturales cn', 'cn.ID_PERSONA = p.ID_PERSONA ');
		$this->db->join('tab_clientes cli', 'cli.ID_CLIENTE =cn.ID_CLIENTE ');
		$this->db->join('tab_contactos cnt', 'cnt.ID_CLIENTE=cli.ID_CLIENTE ');
		$this->db->join('acad_carrera ac', 'm.ID_CARRERA = ac.ID_CARRERA ');
		$this->db->join('acad_nivel an', 'm.ID_NIVEL = an.ID_NIVEL ');
		$this->db->join('acad_grupo g', 'g.ID_GRUPO = m.ID_GRUPO ');
		$this->db->where('cnt.ESTADO',1 ); 
		$this->db->where('cnt.ID_TIPO_CONTACTO',2 );
		if(isset($idUsuarioAcademico) && $idUsuarioAcademico!=null){
			$this->db->join('admin_usuarios u', 'u.ID_PERSONA = m.ID_PERSONA');
			$this->db->join('acad_asesor_estudiante ae', 'ae.ID_USUARIO_ESTUDIANTE = u.ID_USUARIO and ae.ID_USUARIO_ACADEMICO='.$idUsuarioAcademico);
		}
		if($accesos!=null){
			$this->db->join('admin_usuarios u', 'u.ID_PERSONA=m.ID_PERSONA ');
			$this->db->join('acad_usuariosoffice uo', 'uo.ID_PERSONA = u.ID_PERSONA ','left');
		}  
		if($id_carrera != null){
			$this->db->where('m.ID_CARRERA',$id_carrera );
		}
		if($id_nivel !=null){
			 $this->db->where('m.ID_NIVEL',$id_nivel );
		}
		if($id_periodo_academico !=null){
			 $this->db->where('m.ID_PERIODO_ACADEMICO',$id_periodo_academico);
		}
		if($grupo !=null){
			$this->db->where('g.NOMBRE',$grupo );
		}
		if($estado_matricula !=null){
			$this->db->where('m.ESTADO',$estado_matricula );
		}
		if(count($ids_matricula)>0){
			$this->db->where_in('m.ID_MATRICULA',$ids_matricula );
		}
		$this->db->order_by("NOMBRE_COMPLETO","asc");
		$query = $this->db->get();
		$ds = $query->result_array();
		
		/*$ds_filtrado=array();
		$i=0;
		foreach($ds as $key=>$row){//asigno el dato de grupo de cada alumno
			$ds[$key]['GRUPO']=$this->get_grupo_asignado($row['ID_CLIENTE'], $row['id_carrera'], $row['ID_PERIODO_ACADEMICO'], $row['id_nivel']);
			if($grupo !=null and $grupo==$ds[$key]['GRUPO']){
			   $ds_filtrado[$i]=$ds[$key];
			   $i++;
			 }
		}
		if($grupo !=null){
			$ds=$ds_filtrado;
		}*/
		if(count($ds)>0)
			return $ds;
		else
			return false;

	}
	

	public function cambiar_grupoA($id,$grupo)
	{
		$sql = "update acad_estudiante_carrera_materia set ID_GRUPO=".$grupo;
		$sql.=" where ID_PERSONA=".$id." and NIVEL_MATERIA=2";
		$this->db->query($sql);
	}
	

	public function listaAlumnosCuotas($id_carrera,$id_nivel,$id_periodo,$grupo=null,$id_persona=null,$idUsuarioAcademico=null)
	{
		$this->load->model('facturacion/facturacion_model');
		$periodo= $this->get_periodo_activado();
		
		/*$this->db->select("DISTINCT CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as NOMBRE_COMPLETO, p.ID_PERSONA as ID_PERSONA, aem.id_periodo_academico as ID_PERIODO_ACADEMICO",false);
		$this->db->from('acad_estudiante_carrera_materia aem');
		$this->db->join('tab_personas p', 'p.ID_PERSONA = aem.ID_PERSONA ');
		$this->db->join('acad_grupo ag', 'aem.ID_GRUPO = ag.ID_GRUPO ');
		if($id_carrera != null ){
			$this->db->where('aem.ID_CARRERA',$id_carrera );
		}
		if($id_nivel !=null){
			$this->db->where('aem.NIVEL_MATERIA',$id_nivel );
		}
		if($id_periodo !=null){
			$this->db->where('aem.ID_PERIODO_ACADEMICO',$id_periodo);
		}
		*/		
		$this->db->select("DISTINCT CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as NOMBRE_COMPLETO, p.ID_PERSONA as ID_PERSONA, m.ID_PERIODO_ACADEMICO as ID_PERIODO_ACADEMICO, m.ESTADO as ESTADO_MATRICULA,m.ID_CARRERA, m.ID_BECA,  tcn.ID_CLIENTE as ID_CLIENTE, m.ID_NIVEL, m.ID_MATRICULA, g.NOMBRE as GRUPO",false);
		$this->db->from('acad_matricula m');
		$this->db->join('tab_personas p', 'p.ID_PERSONA = m.ID_PERSONA ');
		$this->db->join('tab_clientes_naturales tcn', 'm.ID_PERSONA = tcn.ID_PERSONA ');
		$this->db->join('acad_grupo g', 'g.ID_GRUPO = m.ID_GRUPO ');
		$this->db->where('m.ESTADO!=',3 );
		if(isset($idUsuarioAcademico) and $idUsuarioAcademico>0){
			$this->db->join('admin_usuarios u','u.ID_PERSONA = m.ID_PERSONA');
			$this->db->join('acad_asesor_estudiante ae','ae.ID_USUARIO_ESTUDIANTE = u.ID_USUARIO');
			$this->db->where('ae.ID_USUARIO_ACADEMICO',$idUsuarioAcademico);
		}
		if($id_carrera != null ){
			$this->db->where('m.ID_CARRERA',$id_carrera );
		}
		if($id_nivel !=null){
			$this->db->where('m.ID_NIVEL',$id_nivel );
		}
		if($id_periodo !=null){
			$this->db->where('m.ID_PERIODO_ACADEMICO',$id_periodo);
		}
		if($id_persona !=null){
			$this->db->where('m.ID_PERSONA',$id_persona);
		}
		if($grupo !=null){
			$this->db->where('g.NOMBRE',$grupo);
		}
		$this->db->order_by("NOMBRE_COMPLETO","asc");
		$query= $this->db->get();
		$ds= $query->result_array();
		
		/*$ds_filtrado=array();
		$i=0;
		foreach($ds as $key=>$row){//asigno el dato de grupo de cada alumno
			$ds[$key]['GRUPO']=$this->get_grupo_asignado($row['ID_CLIENTE'], $row['ID_CARRERA'], $row['ID_PERIODO_ACADEMICO'], $row['ID_NIVEL']);
			if($grupo !=null and $grupo==$ds[$key]['GRUPO']){
			   $ds_filtrado[$i]=$ds[$key];
			   $i++;
			 }
		}
		if($grupo !=null){
			$ds=$ds_filtrado;
		}*/
		
		$arreglo_ids=array();
        $arreglo_alumno=array();
        $arreglo_cuota=array();
        $arreglo_periodo=array();
		$arreglo_estado_matricula=array();
		$arreglo_beca_alumno=array();
		$arreglo_total_recibido=array();
		$arreglo_total_descuento=array();
		$arreglo_recibido=array();
		$arreglo_facturas=array();
		$arreglo_grupos=array();
		$arreglo_carreras=array();
		
		//establecer cuota actual
		$parametro=$this->getparametro('DIA_PAGO_CUOTA');
		$dia_mes_pago=$parametro['VALOR'];
		$dat_periodo=$this->getPeriodo($id_periodo);
		$fip=explode('-',$dat_periodo['FECHA_INICIO']);
		$f_pago_cuota_actual = date_create($fip[0].'-'.$fip[1].'-'.$dia_mes_pago);
		
		$f_actual=date_create(date('Y-m-d'));
		$cuota_actual=0;//cuota que debe estar pagada
		if($id_periodo==16){
			$f_pago_cuota_temp=date_create($fip[0].'-'.$fip[1].'-28');
			if($f_actual>$f_pago_cuota_temp){
				for($c=1;$c<6; $c++){
					$f_pago_cuota_actual->modify('+ 1 month');
					if($f_actual<=$f_pago_cuota_actual){
						break;
					}
				}
				$cuota_actual=$c;
			}
		}elseif($id_periodo==17){
			$f_pago_cuota_temp=date_create($fip[0].'-'.$fip[1].'-30');
			if($f_actual>$f_pago_cuota_temp){
				for($c=1;$c<6; $c++){
					$f_pago_cuota_actual->modify('+ 1 month');
					if($f_actual<=$f_pago_cuota_actual){
						break;
					}
				}
				$cuota_actual=$c;
			}
		}else{
			if($f_actual>$f_pago_cuota_actual){
				for($c=1;$c<6; $c++){
					$f_pago_cuota_actual->modify('+ 1 month');
					if($f_actual<=$f_pago_cuota_actual){
						break;
					}
				}
				$cuota_actual=$c;
			}
		}
		
		for($i=0; $i <count($ds) ; $i++){
			//$id_cliente=$ds[$i]['ID_PERSONA'];
			$id_cliente=$ds[$i]['ID_CLIENTE'];
			$nom_cliente=$ds[$i]['NOMBRE_COMPLETO'];
			$periodo_academico=$ds[$i]['ID_PERIODO_ACADEMICO']; 
			$estado_matricula=$ds[$i]['ESTADO_MATRICULA'];
			if($ds[$i]['ID_BECA']!=NULL and $ds[$i]['ID_BECA']>0){
				$data_beca['ID_BECA']=$ds[$i]['ID_BECA'];
				$beca=$this->buscar_beca($data_beca);
				$beca_alumno=$beca[0]['TIPO_BECA'];
			}else{
				$beca_alumno='';
			}
			$total_recibido=0;
			
			//calculo de valor recibido por factura
			/*$sql="SELECT SUM(TOTAL) as total_recibido";
			$sql.=" FROM fac_facturas";
			$sql.=" where ESTADO not in (3,4)";
			$sql.=" and ID_FACTURA in (select ID_FACTURA from fac_clientes_rubros_facturas where ID_CLIENTE_RUBRO in (select ID_CLIENTE_RUBRO from fac_clientes_rubros where ID_CLIENTE=".$ds[$i]['ID_CLIENTE']." and PERIODO_VIGENTE=".$ds[$i]['ID_PERIODO_ACADEMICO']." and ID_CARRERA=".$ds[$i]['ID_CARRERA']."))";
			$query = $this->db->query($sql);
			$ds_recibido = $query->row_array();
			$total_recibido=0;
			if($ds_recibido['total_recibido']!=NULL){
				$total_recibido=$ds_recibido['total_recibido'];
			}*/
			//buscar facturas vinculadas al pago de cuotas del alumno
			$sql="select *";
		 	$sql.=" FROM fac_facturas";
		 	$sql.=" where ESTADO not in (3,4)";
		 	$sql.=" and ID_FACTURA in (select ID_FACTURA from fac_clientes_rubros_facturas where ID_CLIENTE_RUBRO in (select ID_CLIENTE_RUBRO from fac_clientes_rubros where ID_CLIENTE=".$ds[$i]['ID_CLIENTE']." and PERIODO_VIGENTE=".$ds[$i]['ID_PERIODO_ACADEMICO']." and ID_CARRERA=".$ds[$i]['ID_CARRERA']."))";
		 	$query = $this->db->query($sql);
		 	$ds_facturas1 = $query->result_array();
			
			//buscar facturas vinculadas al pago de cuotas mediante arancel
			$sql="select *";
		 	$sql.=" FROM fac_facturas";
		 	$sql.=" where ESTADO not in (3,4)";
		 	$sql.=" and ID_FACTURA in (select ID_FACTURA from fac_pagos_estudiantes where ESTADO=1 and ID_ARANCEL_ESTUDIANTE in (select ID_ARANCEL_ESTUDIANTE from fac_aranceles_estudiantes where ID_MATRICULA=".$ds[$i]['ID_MATRICULA']." and ID_RUBRO=39))";
		 	$query = $this->db->query($sql);
		 	$ds_facturas2 = $query->result_array();
			
			
			$ds_facturas=array_merge($ds_facturas1,$ds_facturas2);
			
		 	$facturas_pagos='';
			$descuento_total=0;
			$ids_factura=array();
		 	if(count($ds_facturas)>0){
			  	foreach($ds_facturas as $df){
					$ids_factura[]=$df['ID_FACTURA'];
				  	if($df['NRO_COMPROBANTE']>0){
					  	$facturas_pagos.='<a href="Javascript:ver_factura(\''.$id_cliente.'\',\''.$df['ID_FACTURA'].'\',\'1\')" data-toggle="tooltip" data-original-title="Ver Comprobante">'.$df['NRO_COMPROBANTE'].'</a>, ';
				  	}else{
					  	$facturas_pagos.='<a href="Javascript:ver_factura(\''.$id_cliente.'\',\''.$df['ID_FACTURA'].'\',\'0\')" data-toggle="tooltip" data-original-title="Ver Factura">'.$df['NRO_FACTURA'].'</a>, ';
				  	}
					//caclcular valor de descuento
					$sql="select *";
					$sql.=" FROM fac_clientes_rubros_facturas";
					$sql.=" where ID_FACTURA=".$df['ID_FACTURA'];
					//$sql.=" and ID_CLIENTE_RUBRO in (select ID_CLIENTE_RUBRO from fac_clientes_rubros where ID_CLIENTE=".$id_cliente." and PERIODO_VIGENTE=".$periodo_academico." and ID_CARRERA=".$ds[$i]['ID_CARRERA'].")";
					$query_df = $this->db->query($sql);
					$ds_df = $query_df->result_array();
					foreach($ds_df as $detalle){
						$descuento_item=0;
						if($detalle['TIPO_DESCUENTO']==2){
							$descuento_item = round($detalle['SUBTOTAL']*$detalle['DESCUENTO']/100,2);
                        }else if($detalle['TIPO_DESCUENTO']==1){
							$descuento_item =$detalle['DESCUENTO'];
                        }
						$descuento_total +=$descuento_item;
						$total_recibido+=round($detalle['SUBTOTAL']-$descuento_item,2);
					}
			  	}
		 	}
			$valor_nota_credito=0;
			//adjunto notas de credito si existen
			if(count($ids_factura)>0){
				$sql="select *";
				$sql.=" FROM ntc_notas_creditos";
				$sql.=" where ESTADO not in (3,4)";
				$sql.=" and ID_FACTURA in ('".implode("','",$ids_factura)."')";
				$query = $this->db->query($sql);
				$ds_notasCredito = $query->result_array();
				if(count($ds_notasCredito)>0){
					foreach($ds_notasCredito as $nc){
						$facturas_pagos.='<a href="'.site_url().'/facturacion/notaCredito/generarPDF/'.$nc['ID_NOTA_CREDITO'].'/2" target="_blank" data-toggle="tooltip" data-original-title="Ver Nota de Credito"><span style="color:red">'.$nc['NRO_NOTA_CREDITO'].'</span></a>, ';
						$valor_nota_credito+=$nc['TOTAL'];
					}
				}
			}
			$total_recibido=round($total_recibido-$valor_nota_credito,2);
		 	$facturas_pagos=trim($facturas_pagos,', ');
			array_push($arreglo_ids,$id_cliente);
		   	array_push($arreglo_alumno, $nom_cliente); 
		   	array_push($arreglo_periodo, $periodo_academico);  
		   	array_push($arreglo_estado_matricula, $estado_matricula); 
		   	array_push($arreglo_beca_alumno, $beca_alumno); 
		   	array_push($arreglo_total_recibido, $total_recibido);
			array_push($arreglo_facturas,$facturas_pagos);  
			array_push($arreglo_total_descuento,$descuento_total); 
			array_push($arreglo_grupos,$ds[$i]['GRUPO']);
			array_push($arreglo_carreras,$ds[$i]['ID_CARRERA']);
		}
		for($i=0; $i <count($arreglo_ids) ; $i++){
			$this->db->select("TOTAL_PAGADO as VALOR, PRECIO_CUOTA as TOTAL");
			//$this->db->select("PRECIO_CUOTA as VALOR, PRECIO_CUOTA as TOTAL");
			$this->db->from('fac_cuotas_generales');      
			$this->db->where('ID_CLIENTE', $arreglo_ids[$i]);
			$this->db->where('ID_PERIODO_ACADEMICO', $arreglo_periodo[$i]);
			$this->db->where('ID_MATRICULA', $ds[$i]['ID_MATRICULA']);
			$this->db->order_by("CUOTA", "asc");
			$query= $this->db->get();
			$cuotas_generales= $query->result_array();
			$arreglo_cuotas= $query->result_array();
			array_push($arreglo_cuota, $arreglo_cuotas);
			$por_pagar=$this->automatica_model->get_total_por_pagar($ds[$i]['ID_MATRICULA'],$cuota_actual);
			//revisar si esta en mora
			//if(isset($arreglo_cuotas[$cuota_actual-1]) and $arreglo_cuotas[$cuota_actual-1]['VALOR']<$arreglo_cuotas[$cuota_actual-1]['TOTAL'] and $arreglo_estado_matricula[$i]==0 and $f_actual>$f_pago_cuota_actual){
			//if($cuota_actual>0 and isset($arreglo_cuotas[$cuota_actual-1]) and $arreglo_cuotas[$cuota_actual-1]['VALOR']<$arreglo_cuotas[$cuota_actual-1]['TOTAL'] and $arreglo_estado_matricula[$i]==0){
			if($cuota_actual>0 and $por_pagar>0 and $arreglo_estado_matricula[$i]==0){
				$arreglo_estado_matricula[$i]=-1;
				if($cuota_actual==6){//verificar si tabla fue cerrada por arancel de saldo pensiones
					$arancel_saldo = $this->facturacion_model->buscarArancel(array('ID_MATRICULA'=>$ds[$i]['ID_MATRICULA'],'ID_RUBRO'=>39));
					if(count($arancel_saldo)>0){
						$arreglo_estado_matricula[$i]=-2;
					}
				}
			}
			
			/*if(count($cuotas_generales)>0){
				$this->db->select("crc.CUOTA, crc.VALOR_SALDADO_POR_PAGO, crc.RECARGO_POR_GENERACION_RUBRO, crc.RECARGO_POR_ATRAZO_EN_PAGO, crc.PRECIO, cr.DESCUENTO, crc.ESTADO");
				$this->db->from('fac_clientes_rubros_cuota crc');      
				$this->db->join("fac_clientes_rubros cr","cr.ID_CLIENTE_RUBRO=crc.ID_CLIENTE_RUBRO");
				$this->db->where('cr.ID_CLIENTE', $arreglo_ids[$i]);
				$this->db->where('cr.PERIODO_VIGENTE', $arreglo_periodo[$i]);
				if($id_carrera != null ){
					$this->db->where('cr.ID_CARRERA', $id_carrera);
				}
				$this->db->order_by("crc.CUOTA", "asc");
				$query= $this->db->get();
				$arreglo_cuotas= $query->result_array();
				$j=0;
				$cuotas=array();
				$pagado=0;
				$precio=0;
				foreach($arreglo_cuotas as $cuota){
				   $k=$cuota['CUOTA']-1;
				   if($k!=$j){	 
					   $j=$j+1;
					   $pagado=0;
					   $precio=0;
				   }//$pagado=$pagado+($cuota['VALOR_SALDADO_POR_PAGO']-($cuota['VALOR_SALDADO_POR_PAGO']-$cuota['RECARGO_POR_GENERACION_RUBRO'])*$cuota['DESCUENTO']/100);
				   $pagado=$pagado+$cuota['VALOR_SALDADO_POR_PAGO'];
				   //$precio=$precio+($cuota['PRECIO']-$cuota['PRECIO']*$cuota['DESCUENTO']/100)+$cuota['RECARGO_POR_GENERACION_RUBRO'];
				   $precio=$precio+$cuota['PRECIO']+$cuota['RECARGO_POR_GENERACION_RUBRO']+$cuota['RECARGO_POR_ATRAZO_EN_PAGO'];
				   $cuotas[$j]=array('VALOR'=>sprintf("%01.2f",$pagado),'TOTAL'=>sprintf("%01.2f",$precio),'DESCUENTO'=>$cuota['DESCUENTO']);
			   }
			   array_push($arreglo_cuota, $cuotas);
		   }else{
			   array_push($arreglo_cuota, $cuotas_generales);
		   }*/
		}
		$bidimensional=array(
                            $arreglo_alumno,
                            $arreglo_cuota,
							$arreglo_estado_matricula,
							$arreglo_beca_alumno,
							$arreglo_ids,
							$arreglo_facturas,
							$arreglo_total_descuento,
							$arreglo_total_recibido,
							$arreglo_grupos,
							$arreglo_carreras
                            );     
		/*$bidimensional=array($arreglo_alumno,
							 $arreglo_cuota,
							 $arreglo_estado_matricula,
							 $arreglo_beca_alumno,
							 $arreglo_total_recibido
							);*/
		if(count($bidimensional)>0){
			return $bidimensional;
		}else{
			return false;
		}
	}
	
	
	public function listaAlumnosPagos($id_carrera,$id_nivel)
	{
		$periodo= $this->get_periodo_activado();
		$this->db->select("DISTINCT CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as NOMBRE_COMPLETO, p.ID_PERSONA as ID_PERSONA",false);
		$this->db->from('acad_estudiante_carrera_materia aem');
		$this->db->join('tab_personas p', 'p.ID_PERSONA = aem.ID_PERSONA ');
		$this->db->join('acad_grupo ag', 'aem.ID_GRUPO = ag.ID_GRUPO ');
		if($id_carrera != null){
			$this->db->where('aem.ID_CARRERA',$id_carrera );
		}
		if($id_nivel !=null){
			$this->db->where('aem.NIVEL_MATERIA',$id_nivel );
		}       
		//$this->db->where('acad_carrera_modalidad.ID_PERIODO_ACADEMICO',$periodo);
		$this->db->order_by("NOMBRE_COMPLETO","asc");
		$query= $this->db->get();
		$ds= $query->result_array(); 
		$arreglo_ids=array();
		$arreglo_alumno=array();
		$arreglo_cuota=array();
		for($i=0; $i <count($ds) ; $i++){
			$id_cliente=$ds[$i]['ID_PERSONA'];
			$nom_cliente=$ds[$i]['NOMBRE_COMPLETO'];
			array_push($arreglo_ids,$id_cliente);
			array_push($arreglo_alumno, $nom_cliente);         
		}
		for($i=0; $i <count($arreglo_ids) ; $i++) {
			$this->db->select("TOTAL_PAGADO as VALOR, PRECIO_CUOTA as TOTAL");
			$this->db->from('fac_cuotas_generales');      
			$this->db->where('ID_CLIENTE', $arreglo_ids[$i]);
			$this->db->order_by("CUOTA", "asc");
			$query= $this->db->get();
			$arreglo_cuotas= $query->result_array();
			array_push($arreglo_cuota, $arreglo_cuotas);
		}  
		$bidimensional=array($arreglo_alumno,
							 $arreglo_cuota
							);
		if(count($bidimensional)>0){
			return $bidimensional;
		}else{
			return false;
		}
	}
	

	public function CuotasAlumno($id_cliente,$curso=null,$periodo=null)
	{
		$this->db->select("*");
		$this->db->from('fac_cuotas_generales');      
		$this->db->where('ID_CLIENTE', $id_cliente);
		if($curso==1){
			$this->db->where('ID_MATRICULA_CURSO>', 0);
		}
		if($periodo>1){
			$this->db->where('ID_PERIODO_ACADEMICO', $periodo);
		}
		$this->db->order_by("CUOTA", "asc"); 
		$query= $this->db->get();
		$cuotas= $query->result_array();             
		if(count($cuotas)>0){
			return $cuotas;
		}else{
			return false;
		}
	}


	public function buscar_grupo_de_estdiantes_calificar($id_grupo, $id_materia,$id_persona_docente,$tipo=0,$periodo=0)
	{
		$this->db->trans_start();
		if($periodo<=0){
			$periodo= $this->get_periodo_activado();
		}
		
		$datos=array();
		//preparo los datos de la cabecera del registro de calificaciones
		$this->db->select(' acad_grupo.NOMBRE as GRUPO,
							acad_carrera.NOMBRE as CARRERA,
							acad_carrera.ID_MODALIDAD,
							acad_nivel.NIVEL as NIVEL,
							acad_modalidad.MODALIDAD,
							acad_sede.SEDE');
		$this->db->from('acad_grupo');
		$this->db->join('acad_sede', 'acad_sede.ID_SEDE = acad_grupo.ID_SEDE');
		$this->db->join('acad_carrera', 'acad_carrera.ID_CARRERA = acad_grupo.ID_CARRERA');
		$this->db->join('acad_nivel', 'acad_nivel.ID_NIVEL = acad_grupo.ID_NIVEL');
		$this->db->join('acad_modalidad', 'acad_modalidad.ID_MODALIDAD = acad_carrera.ID_MODALIDAD');
		$this->db->where('acad_grupo.ID_GRUPO',$id_grupo );
		$query = $this->db->get();
		$cabecera = $query->row_array(); 

		$this->db->select('acad_materia.NOMBRE,acad_nivel.NIVEL as NIVEL, uo.UNIDAD, acad_carrera_materia.*');
		$this->db->from('acad_carrera_materia');
		$this->db->join('acad_materia','acad_materia.ID_MATERIA=acad_carrera_materia.ID_MATERIA');
		$this->db->join('acad_nivel', 'acad_nivel.ID_NIVEL = acad_carrera_materia.NIVEL_MATERIA');
		$this->db->join('tab_unidad_organizacional uo', 'uo.ID_UNIDAD = acad_carrera_materia.ID_UNIDAD','LEFT');
		$this->db->where('acad_carrera_materia.ID_MATERIA',$id_materia );
		$query = $this->db->get();
		$ds = $query->row_array(); 
		$cabecera['MATERIA']=$ds['NOMBRE'];
		$cabecera['NIVEL']=$ds['NIVEL'];
		$cabecera['CREDITOS_MATERIA']=$ds['CREDITOS_MATERIA'];
		$cabecera['CODIGO_MATERIA']=$ds['CODIGO_MATERIA'];
		$cabecera['HORAS']=$ds['HORAS_DOCENCIA']+$ds['HORAS_TALLER']+$ds['HORAS_AUTONOMAS'];
		//$cabecera['HORAS']=$ds['HORAS_DOCENCIA']+$ds['HORAS_TALLER']+$ds['HORAS_AUTONOMAS'];
		$cabecera['UNIDAD']=$ds['UNIDAD'];
		$cabecera['PRE_REQUISITO'] = $this->get_prerequisitos($id_materia);

		$sql = "select CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as DOCENTE, c.NRO_DOCUMENTO ";
		$sql .= " from tab_personas p inner join tab_clientes_naturales cn on p.ID_PERSONA = cn.ID_PERSONA ";
		$sql .= " inner join tab_clientes c on c.ID_CLIENTE= cn.ID_CLIENTE ";
		$sql .= " inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION where p.OCUPACION=2 and cn.ID_PERSONA=".$id_persona_docente;
		$query = $this->db->query($sql);
		$ds = $query->row_array(); 
		$cabecera['DOCENTE']=$ds['DOCENTE'];
		$cabecera['NRO_DOCUMENTO']=$ds['NRO_DOCUMENTO'];
		$datos['cabecera']=$cabecera; 
		//codigo adicional para obtener todos los id_grupo con el mismo nombre
		$this->db->select('*');
		$this->db->from('acad_grupo');
		$this->db->where('NOMBRE',$cabecera['GRUPO']);
		$query = $this->db->get();
		$grupos = $query->result_array(); 
		foreach($grupos as $g){
			$id_grupos[]=$g['ID_GRUPO'];
		}
		//codigo adicional para obtener todos los id_materia con el mismo nombre
		$this->db->select('*');
		$this->db->from('acad_materia');
		$this->db->where('NOMBRE',$cabecera['MATERIA']);
		$query = $this->db->get();
		$materias = $query->result_array(); 
		foreach($materias as $m){
			$id_materias[]=$m['ID_MATERIA'];
		}
		//aqui se revisa para la generacion de etapas ver los periodos academicos
		//obtengo la configuracion del sistema de calificación de la carrera en cuestión (cant_etapas,cant_componentes,componentes)
		$this->db->select(' acad_carrera_modalidad.CANT_ETAPAS,
							acad_carrera_modalidad.CANT_COMPONENTES,
							acad_carrera_modalidad.ID_CARRERA_MODALIDAD,
							acad_carrera_modalidad.BASE');
		$this->db->from('acad_carrera_modalidad');
		$this->db->join('acad_grupo', 'acad_grupo.ID_CARRERA = acad_carrera_modalidad.ID_CARRERA');
		$this->db->where('acad_grupo.ID_GRUPO',$id_grupo );
		$this->db->where('acad_carrera_modalidad.ID_PERIODO_ACADEMICO',$periodo);
		$query = $this->db->get();
		$ds = $query->row_array(); 
		$datos['cant_etapas']=$ds['CANT_ETAPAS'];
		$datos['cant_componentes']=$ds['CANT_COMPONENTES'];
		$datos['base']=$ds['BASE'];

		$id_carrera_modalidad = $ds['ID_CARRERA_MODALIDAD'];
		$this->db->select(' acad_componente.ID_COMPONENTE,
							acad_componente.NOMBRE,
							acad_carrera_modalidad_componente.VALOR_COMPONENTE');
		$this->db->from('acad_componente');
		$this->db->join('acad_carrera_modalidad_componente', 'acad_carrera_modalidad_componente.ID_COMPONENTE = acad_componente.ID_COMPONENTE');
		$this->db->where('acad_carrera_modalidad_componente.ID_CARRERA_MODALIDAD',$id_carrera_modalidad );
		$this->db->where('acad_carrera_modalidad_componente.ID_PERIODO_ACADEMICO',$periodo );
		$this->db->order_by('acad_componente.ORDEN','ASC' );
		$query = $this->db->get();
		$ds = $query->result_array();

		$datos['componentes']=$ds;

		//obtengo los estudiantes que reciben la materia, en este grupo, con este profesor y en este periodo de tiempo
		$this->db->select("acad_estudiante_carrera_materia.ID_ESTUDIANTE_CARRERA_MATERIA,
							CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as NOMBRE_COMPLETO,
							c.NRO_DOCUMENTO, acad_estudiante_carrera_materia.ASISTENCIA_JUSTIFICADA",false);
		$this->db->from('acad_materia');
		$this->db->join('acad_carrera_materia', 'acad_materia.ID_MATERIA = acad_carrera_materia.ID_MATERIA');
		$this->db->join('acad_estudiante_carrera_materia', 'acad_estudiante_carrera_materia.ID_CARRERA_MATERIA = acad_carrera_materia.ID_CARRERA_MATERIA');
		$this->db->join('tab_personas p', 'p.ID_PERSONA = acad_estudiante_carrera_materia.ID_PERSONA');
		$this->db->join('tab_clientes_naturales cn', 'cn.ID_PERSONA = p.ID_PERSONA');
		$this->db->join('tab_clientes c', 'c.ID_CLIENTE = cn.ID_CLIENTE');
		$this->db->join('acad_matricula mat', 'mat.ID_PERSONA = acad_estudiante_carrera_materia.ID_PERSONA and mat.ID_PERIODO_ACADEMICO=acad_estudiante_carrera_materia.ID_PERIODO_ACADEMICO');
		if($tipo==1){//si es para reporte calificaciones
			$this->db->where('acad_materia.ID_MATERIA',$id_materia );
			$this->db->where('acad_estudiante_carrera_materia.ID_GRUPO',$id_grupo );
		}else{//si es para calificar
			//$this->db->where('acad_materia.ID_MATERIA',$id_materia );
			//$this->db->where('acad_estudiante_carrera_materia.ID_GRUPO',$id_grupo );
			$this->db->where_in('acad_materia.ID_MATERIA',$id_materias );//seleccionar todo estudiante que este en materia con el mismo nombre
			$this->db->where_in('acad_estudiante_carrera_materia.ID_GRUPO',$id_grupos );//seleccionar todo estudiante que este en grupo con el mismo nombre
		}
		//$this->db->where('acad_estudiante_carrera_materia.ID_PERSONA_DOCENTE',$id_persona_docente );
		$this->db->where('acad_estudiante_carrera_materia.ID_PERIODO_ACADEMICO',$periodo);
		$this->db->where('mat.ESTADO',0);
		$this->db->group_by('acad_estudiante_carrera_materia.ID_ESTUDIANTE_CARRERA_MATERIA');
		$this->db->order_by("NOMBRE_COMPLETO","asc");
		// $this->db->order_by("p.APELLIDO_PATERNO","asc");
		$query = $this->db->get();
		$ds = $query->result_array();
		//recorro los estudiantes-carrera-materia, y por cada estudiante mando todas las calificaciones por componente, incluyendo el tipo de calificacion
		for($i=0; $i < count($ds); $i++){ 
			$id_estudiante_carrera_materia = $ds[$i]['ID_ESTUDIANTE_CARRERA_MATERIA'];
			$calificaciones_x_etapa=array();
			//recorro las etapas
			for($j=0; $j < $datos['cant_etapas']; $j++){
				$calificaciones_de_etapa_actual = array();
				//TOMO LAS CALIFICACIONES DEL ESTUDIANTE_CARRERA_MATERIA EN CADA UNO DE LOS COMPONENTES GRABADOS EN LA CARRERA para la etapa actual
				for($k=0; $k < count($datos['componentes']); $k++){
					$this->db->select("cal.ETAPA, cal.ID_COMPONENTE, cal.CALIFICACION");
					$this->db->from('acad_estudiante_carrera_materia ecm');
					$this->db->join('acad_calificacion cal', 'ecm.ID_ESTUDIANTE_CARRERA_MATERIA = cal.ID_ESTUDIANTE_CARRERA_MATERIA', 'left');
					$this->db->where('cal.ID_PERIODO_ACADEMICO',$periodo);
					$this->db->where('cal.ETAPA',$j+1);
					$this->db->where('cal.ID_COMPONENTE',$datos['componentes'][$k]['ID_COMPONENTE']);
					$this->db->where('cal.ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
					$query = $this->db->get();
					$dataset = $query->result_array();
					array_push($calificaciones_de_etapa_actual, $dataset);
				}
				array_push($calificaciones_x_etapa, $calificaciones_de_etapa_actual);                
			}
			$ds[$i]['CALIFICACIONES_X_ETAPA']= $calificaciones_x_etapa;
		}
		//recorro los estudiantes-carrera-materia, y por cada estudiante mando todas las notas generales
		for($i=0; $i < count($ds); $i++){ 
			$id_estudiante_carrera_materia = $ds[$i]['ID_ESTUDIANTE_CARRERA_MATERIA'];
			$this->db->select("ETAPA,ID_TIPO_CALIFICACION, CALIFICACION");
			$this->db->from('acad_calificacion');
			$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			$this->db->where('ID_TIPO_CALIFICACION', 2);
			$query = $this->db->get();
			$dataset_notas_generales = $query->result_array();            
			$ds[$i]['CALIFICACIONES_GENERALES']= $dataset_notas_generales;

			$this->db->select("ID_TIPO_CALIFICACION, CALIFICACION");
			$this->db->from('acad_calificacion');
			$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			$this->db->where('ID_TIPO_CALIFICACION', 5);
			$query = $this->db->get();
			$dataset_supletorio = $query->row_array();
			if(count($dataset_supletorio)>0)
				$cal_supletorio = $dataset_supletorio['CALIFICACION'];
			else
				$cal_supletorio='';
			$ds[$i]['SUPLETORIO']= $cal_supletorio;

			$this->db->select("ID_TIPO_CALIFICACION, CALIFICACION");
			$this->db->from('acad_calificacion');
			$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			$this->db->where('ID_TIPO_CALIFICACION', 3);
			$query = $this->db->get();
			$dataset_promedio = $query->row_array();
			if(count($dataset_promedio)>0)
				$cal_promedio = $dataset_promedio['CALIFICACION'];
			else
				$cal_promedio='';
			$ds[$i]['PROMEDIO']= $cal_promedio;

			$this->db->select("ID_TIPO_CALIFICACION, CALIFICACION");
			$this->db->from('acad_calificacion');
			$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			$this->db->where('ID_TIPO_CALIFICACION', 6);
			$query = $this->db->get();
			$dataset_nota_final = $query->row_array();
			if(count($dataset_nota_final)>0)
				$cal_final = $dataset_nota_final['CALIFICACION'];
			else
				$cal_final='';
			$ds[$i]['FINAL']= $cal_final;

			$this->db->select("ID_TIPO_CALIFICACION, ESTADO_CALIFICACION");
			$this->db->from('acad_calificacion');
			$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			$this->db->where('ID_TIPO_CALIFICACION', 6);
			$this->db->where('ETAPA', 0);
			$query = $this->db->get();
			$dataset_estado_calificacion = $query->row_array();
			if(count($dataset_estado_calificacion)>0)
				$cal_estado_calificacion = $dataset_estado_calificacion['ESTADO_CALIFICACION'];
			else
				$cal_estado_calificacion='';
			$ds[$i]['ESTADO_CALIFICACION']= $cal_estado_calificacion;

			$this->db->select("ID_TIPO_CALIFICACION, CALIFICACION");
			$this->db->from('acad_calificacion');
			$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			$this->db->where('ID_TIPO_CALIFICACION', 4);
			$this->db->where('ETAPA', 0);
			$query = $this->db->get();
			$dataset_asistencia = $query->row_array();
			if(count($dataset_asistencia)>0)
				$cal_asistencia = $dataset_asistencia['CALIFICACION'];
			else
				$cal_asistencia='';
			$ds[$i]['ASISTENCIA']= $cal_asistencia;
		}
		$datos['estudiantes']=$ds;
		$this->db->trans_complete();
		return $datos;
	}
	

	public function getparametro($pm)
	{
		$this->db->select('VALOR');
		$this->db->from('acad_parametro');
		// $this->db->where('ID_PARAMETRO', $pm);
		$this->db->where('NOMBRE',$pm);
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds;
	}
	

	public function getNotaMinima($pm)
	{
		$this->db->select('VALOR');
		$this->db->from('acad_parametro');
		// $this->db->where('ID_PARAMETRO', $pm);
		$this->db->where('DESCRIPCION',$pm);
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds;
	}
  
  
	public function updateAsistenciaSupletorioNotaFinal($estudiante_carrera_meteria,$asistencia,$supletorio,$nota_final,$estado,$periodo=null)
	{
		$this->db->trans_start();
		if($periodo==null){
			$periodo= $this->get_periodo_activado();
		}
		$id_estudiante_carrera_materia= $estudiante_carrera_meteria;	
		$data_log = $this->session->userdata()['loggeado'];
		$id_usuario_en_sesion = $data_log["ID_USUARIO"];
		//creo o actualizo el promedio para esta etapa
		$this->db->select("ID_CALIFICACION,CALIFICACION");
		$this->db->from('acad_calificacion');
		$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$estudiante_carrera_meteria);
		$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
		$this->db->where('ETAPA',0);
		$this->db->where('ID_TIPO_CALIFICACION',4); //de tipo: asistencia
		$query = $this->db->get();
		$ds = $query->row_array(); 
		if(count($ds)>0 and $asistencia!='' and $ds['CALIFICACION']!=$asistencia){//si ya habia sido insertada una nota promedio, actualizo
			$id_calificacion = $ds['ID_CALIFICACION'];
			$data = array();
			$data['ID_USUARIO_ACTUALIZA'] = $id_usuario_en_sesion;
			$data['FECHA_ACTUALIZACION']=date("Y-m-d H:i:s");
			$data['CALIFICACION'] = $asistencia;
			$data['ID_USUARIO'] = $id_usuario_en_sesion;
			$data['ETAPA']=0;
			$this->db->where('acad_calificacion.ID_CALIFICACION', $id_calificacion);
			$this->db->update('acad_calificacion', $data);
		}elseif(count($ds)<=0 and $asistencia!=''){      
			$data = array();
			$data['ID_USUARIO'] = $id_usuario_en_sesion;
			$data['ID_PERIODO_ACADEMICO']=$periodo;
			$data['ID_ESTUDIANTE_CARRERA_MATERIA']=$id_estudiante_carrera_materia;
			$data['ID_TIPO_CALIFICACION']=4; //de tipo: asistencia
			$data['FECHA_HORA']=date("Y-m-d H:i:s");
			$data['CALIFICACION']=$asistencia;
			$data['ETAPA']=0;
			$this->db->insert('acad_calificacion', $data);
		}

		//if (!empty($supletorio)) {
		  //creo o actualizo la nota supletorio
		  $this->db->select("ID_CALIFICACION,CALIFICACION");
		  $this->db->from('acad_calificacion');
		  $this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$estudiante_carrera_meteria);
		  $this->db->where('ID_PERIODO_ACADEMICO',$periodo);
		  $this->db->where('ETAPA',0);
		  $this->db->where('ID_TIPO_CALIFICACION',5); //de tipo: supletorio
		  $query = $this->db->get();
		  $ds = $query->row_array(); 

		  if(count($ds)>0  and $ds['CALIFICACION']!=$supletorio){//si ya habia sido insertada una nota supletorio, actualizo
			  $id_calificacion = $ds['ID_CALIFICACION'];
			  $data = array();
			  $data['ID_USUARIO_ACTUALIZA'] = $id_usuario_en_sesion;
			  $data['FECHA_ACTUALIZACION']=date("Y-m-d H:i:s");
			  if($supletorio!=''){
				  $data['CALIFICACION'] = number_format(floatval($supletorio),2);
			  }else{
				  $data['CALIFICACION'] = '';
			  }
			  $data['ID_USUARIO'] = $id_usuario_en_sesion;
			  $data['ETAPA']=0;
			  $this->db->where('acad_calificacion.ID_CALIFICACION', $id_calificacion);
			  $this->db->update('acad_calificacion', $data);
		  }elseif(count($ds)<=0 and $supletorio!=''){      
			  $data = array();
			  $data['ID_USUARIO'] = $id_usuario_en_sesion;
			  $data['ID_PERIODO_ACADEMICO']=$periodo;
			  $data['ID_ESTUDIANTE_CARRERA_MATERIA']=$id_estudiante_carrera_materia;
			  $data['ID_TIPO_CALIFICACION']=5; //de tipo: supletorio
			  $data['FECHA_HORA']=date("Y-m-d H:i:s");
			  $data['CALIFICACION']=number_format(floatval($supletorio),2);
			  $data['ETAPA']=0;
			  $this->db->insert('acad_calificacion', $data);
		  }
		//}
		$this->db->select("ID_CALIFICACION,CALIFICACION");
		$this->db->from('acad_calificacion');
		$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$estudiante_carrera_meteria);
		$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
		$this->db->where('ETAPA',0);
		$this->db->where('ID_TIPO_CALIFICACION',6); //de tipo: final total
		$query = $this->db->get();
		$ds = $query->row_array(); 

		if(count($ds)>0  and $ds['CALIFICACION']!=$nota_final){//si ya habia sido insertada una nota promedio, actualizo
			$id_calificacion = $ds['ID_CALIFICACION'];
			$data = array();
			$data['ID_USUARIO_ACTUALIZA'] = $id_usuario_en_sesion;
			$data['FECHA_ACTUALIZACION']=date("Y-m-d H:i:s");
			if($nota_final!=''){
				$data['CALIFICACION'] = number_format(floatval($nota_final),2);
			}else{
				$data['CALIFICACION'] = '';
			}
			$data['ID_USUARIO'] = $id_usuario_en_sesion;
			$data['ETAPA'] = 0;
			$this->db->where('acad_calificacion.ID_CALIFICACION', $id_calificacion);
			$this->db->update('acad_calificacion', $data);
		}elseif(count($ds)<=0 and $nota_final!=''){      
			$data = array();
			$data['ID_USUARIO'] = $id_usuario_en_sesion;
			$data['ID_PERIODO_ACADEMICO']=$periodo;
			$data['ID_ESTUDIANTE_CARRERA_MATERIA']=$id_estudiante_carrera_materia;
			$data['ID_TIPO_CALIFICACION']=6; //de tipo: final total
			$data['FECHA_HORA']=date("Y-m-d H:i:s");
			$data['CALIFICACION']=number_format(floatval($nota_final),2);
			$data['ETAPA']=0;
			$this->db->insert('acad_calificacion', $data);
		}	
		if($estado!=''){
			$sql = "update acad_calificacion set ESTADO_CALIFICACION=".$estado;
			$sql .= " where ID_ESTUDIANTE_CARRERA_MATERIA=".$estudiante_carrera_meteria;
			$sql .= " AND ID_TIPO_CALIFICACION=6";
			$sql .= " AND ETAPA=0";
			$this->db->query($sql);
		}
		$this->db->trans_complete();
	}


	public function updatePromediototal($estudiante_carrera_meteria,$promedio_total, $nota_final,$asistencia,$estado )
	{
		$this->db->trans_start();
		$periodo= $this->get_periodo_activado();
		$id_estudiante_carrera_materia= $estudiante_carrera_meteria;
		$data_log = $this->session->userdata()['loggeado'];
		$id_usuario_en_sesion = $data_log["ID_USUARIO"]; 
		//creo o actualizo la asistencia
		$this->db->select("ID_CALIFICACION,CALIFICACION");
		$this->db->from('acad_calificacion');
		$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$estudiante_carrera_meteria);
		$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
		$this->db->where('ETAPA',0);
		$this->db->where('ID_TIPO_CALIFICACION',4); //de tipo: asistencia
		$query = $this->db->get();
		$ds = $query->row_array(); 
		if(count($ds)>0 and $ds['CALIFICACION']!=$asistencia and $asistencia!=''){//si ya habia sido insertada una nota asistencia, actualizo
			$id_calificacion = $ds['ID_CALIFICACION'];
			$data = array();
			$data['ID_USUARIO_ACTUALIZA'] = $id_usuario_en_sesion;
			$data['FECHA_ACTUALIZACION']=date("Y-m-d H:i:s");
			$data['CALIFICACION'] = $asistencia;
			$data['ID_USUARIO'] = $id_usuario_en_sesion;
			$data['ETAPA']=0;
			$this->db->where('acad_calificacion.ID_CALIFICACION', $id_calificacion);
			$this->db->update('acad_calificacion', $data);
		}elseif(count($ds)<=0 and $asistencia!=''){      
			$data = array();
			$data['ID_USUARIO'] = $id_usuario_en_sesion;
			$data['ID_PERIODO_ACADEMICO']=$periodo;
			$data['ID_ESTUDIANTE_CARRERA_MATERIA']=$id_estudiante_carrera_materia;
			$data['ID_TIPO_CALIFICACION']=4; //de tipo: asistencia
			$data['FECHA_HORA']=date("Y-m-d H:i:s");
			$data['CALIFICACION']=$asistencia;
			$data['ETAPA']=0;
			$this->db->insert('acad_calificacion', $data);
		}	
		//$promedio_total1= number_format(floatval($promedio_total),2);
		//$nota_final1= number_format(floatval($nota_final),2);	
		$this->db->select("ID_CALIFICACION,CALIFICACION");
		$this->db->from('acad_calificacion');
		$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$estudiante_carrera_meteria);
		$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
		$this->db->where('ETAPA',0);
		$this->db->where('ID_TIPO_CALIFICACION',3);
		$query = $this->db->get();
		$ds = $query->row_array(); 
		if($ds!=NULL and $ds['CALIFICACION']!=$promedio_total){
		//if($promedio_total!='' and $ds['CALIFICACION']!=$promedio_total){
			$sql = "update acad_calificacion set CALIFICACION='".($promedio_total);
			$sql .= "', ID_USUARIO_ACTUALIZA=".$id_usuario_en_sesion;
			$sql .= ", FECHA_ACTUALIZACION='".date("Y-m-d H:i:s")."'";
			$sql .= " where ID_ESTUDIANTE_CARRERA_MATERIA=".$estudiante_carrera_meteria;
			$sql .= " AND ID_TIPO_CALIFICACION=3";
			$sql .= " AND ETAPA=0";
			$this->db->query($sql); 
		}		
		$this->db->select("ID_CALIFICACION,CALIFICACION");
		$this->db->from('acad_calificacion');
		$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$estudiante_carrera_meteria);
		$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
		$this->db->where('ETAPA',0);
		$this->db->where('ID_TIPO_CALIFICACION',6);
		$query = $this->db->get();
		$ds = $query->row_array(); 
		//if($nota_final!='' and $ds['CALIFICACION']!=$nota_final){
		if($ds!=NULL and $ds['CALIFICACION']!=$nota_final){
			$sql1 = "update acad_calificacion set CALIFICACION='".($nota_final);
			$sql1 .= "', ID_USUARIO_ACTUALIZA=".$id_usuario_en_sesion;
			$sql1 .= ", FECHA_ACTUALIZACION='".date("Y-m-d H:i:s")."'";
			$sql1 .= " where ID_ESTUDIANTE_CARRERA_MATERIA=".$estudiante_carrera_meteria;
			$sql1 .= " AND ID_TIPO_CALIFICACION=6";
			$sql1 .= " AND ETAPA=0";
			$this->db->query($sql1);
		}
		if($estado!=''){
			$sql2 = "update acad_calificacion set ESTADO_CALIFICACION=".$estado;
			$sql2 .= " where ID_ESTUDIANTE_CARRERA_MATERIA=".$estudiante_carrera_meteria;
			$sql2 .= " AND ID_TIPO_CALIFICACION=6";
			$sql2 .= " AND ETAPA=0";
			$this->db->query($sql2);
			$this->db->trans_complete();
		}
	}
	
	
	public function calificar_componentes($estudiante_carrera_meteria, $etapa,$cadena_componente,$cadena_valor, $promedio_etapa,$etapas,$periodo=null)
	{
		$this->db->trans_start();
		if($periodo==null){
			$periodo= $this->get_periodo_activado();
		}
		$id_estudiante_carrera_materia = $estudiante_carrera_meteria;
		$arreglo_componentes = explode("&", $cadena_componente);
		//$arreglo_valores = array_map('floatval',explode("&", $cadena_valor));
		$arreglo_valores = explode("&", $cadena_valor);
		//TOMO EL USUARIO EN SESION
		$data_log = $this->session->userdata()['loggeado'];
		$id_usuario_en_sesion = $data_log["ID_USUARIO"]; 
		//recorro el arreglo de componentes
		for($i=0; $i < count($arreglo_componentes) ; $i++){ 
			$componente = $arreglo_componentes[$i];
			$valor = trim($arreglo_valores[$i]); 
			//verifico si el estudiante ya tiene una nota de este componente, en este periodo, en esta etapa 
			$this->db->select("ID_CALIFICACION,CALIFICACION");
			$this->db->from('acad_calificacion');
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$estudiante_carrera_meteria);
			$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
			$this->db->where('ETAPA',$etapa);
			$this->db->where('ID_COMPONENTE',$componente);
			$query = $this->db->get();
			$ds = $query->row_array(); 
			if(count($ds)>0 and $ds['CALIFICACION']!=$valor){//si ya habia sido calificado, actualizo
				$id_calificacion = $ds['ID_CALIFICACION'];
				$data = array();
				$data['ID_USUARIO_ACTUALIZA'] = $id_usuario_en_sesion;
				$data['FECHA_ACTUALIZACION']=date("Y-m-d H:i:s");
				if($valor!=''){
					$data['CALIFICACION']=number_format(floatval($valor),2);
				}else{
					$data['CALIFICACION'] = $valor;
				}
				$data['ID_USUARIO'] = $id_usuario_en_sesion;
				$this->db->where('acad_calificacion.ID_CALIFICACION', $id_calificacion);
				$this->db->update('acad_calificacion', $data);
			}elseif(count($ds)<=0 and $valor!=''){
				$data = array();
				$data['ID_USUARIO'] = $id_usuario_en_sesion;
				$data['ID_PERIODO_ACADEMICO']=$periodo;
				$data['ID_ESTUDIANTE_CARRERA_MATERIA']=$id_estudiante_carrera_materia;
				$data['ID_TIPO_CALIFICACION']=1; //de tipo compononente
				$data['FECHA_HORA']=date("Y-m-d H:i:s");
				$data['CALIFICACION']=$valor;
				$data['ETAPA']=$etapa;
				$data['ID_COMPONENTE']=$componente;
				$this->db->insert('acad_calificacion', $data);
			}
		}
		//creo o actualizo el promedio para esta etapa
		$this->db->select("ID_CALIFICACION,CALIFICACION");
		$this->db->from('acad_calificacion');
		$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$estudiante_carrera_meteria);
		$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
		$this->db->where('ETAPA',$etapa);
		$this->db->where('ID_TIPO_CALIFICACION',2); //de tipo: final de la etapa
		$query = $this->db->get();
		$ds = $query->row_array(); 
		if(count($ds)>0 and $ds['CALIFICACION']!=$promedio_etapa){//si ya habia sido insertada una nota promedio, actualizo
			$id_calificacion = $ds['ID_CALIFICACION'];
			$data = array();
			$data['ID_USUARIO_ACTUALIZA'] = $id_usuario_en_sesion;
			$data['FECHA_ACTUALIZACION']=date("Y-m-d H:i:s");
			$data['CALIFICACION'] = $promedio_etapa;
			$data['ID_USUARIO'] = $id_usuario_en_sesion;
			$this->db->where('acad_calificacion.ID_CALIFICACION', $id_calificacion);
			$this->db->update('acad_calificacion', $data);
		}elseif(count($ds)<=0 and $promedio_etapa!=''){      
			$data = array();
			$data['ID_USUARIO'] = $id_usuario_en_sesion;
			$data['ID_PERIODO_ACADEMICO']=$periodo;
			$data['ID_ESTUDIANTE_CARRERA_MATERIA']=$id_estudiante_carrera_materia;
			$data['ID_TIPO_CALIFICACION']=2; //de tipo: final etapa
			$data['FECHA_HORA']=date("Y-m-d H:i:s");
			$data['CALIFICACION']=$promedio_etapa;
			$data['ETAPA']=$etapa;
			$this->db->insert('acad_calificacion', $data);
		}
		//calculo el promedio general
		$this->db->select_sum('CALIFICACION');
		$this->db->from('acad_calificacion');
		$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$estudiante_carrera_meteria);
		$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
		$this->db->where('ID_TIPO_CALIFICACION',2); //de tipo: final etapa
		$this->db->where('CALIFICACION >=',0); 
		$this->db->where('CALIFICACION !=','');
		$query = $this->db->get();
		$ds_prom_gen = $query->row_array();
		//creo o actualizo el promedio general para este periodo
		$this->db->select("ID_CALIFICACION,CALIFICACION");
		$this->db->from('acad_calificacion');
		$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$estudiante_carrera_meteria);
		$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
		$this->db->where('ID_TIPO_CALIFICACION',3); //de tipo: final del periodo
		$query = $this->db->get();
		$ds = $query->row_array();
		$promedio_gen='';
		if($ds_prom_gen['CALIFICACION']!='' and $ds_prom_gen['CALIFICACION']!=NULL){
			$promedio_gen=number_format(floatval($ds_prom_gen['CALIFICACION']/$etapas),2);
		}
		
		if(count($ds)>0 and $ds['CALIFICACION']!=$promedio_gen){//si ya habia sido insertada una nota promedio final, actualizo
			$id_calificacion = $ds['ID_CALIFICACION'];
			$data = array();
			$data['ID_USUARIO_ACTUALIZA'] = $id_usuario_en_sesion;
			$data['FECHA_ACTUALIZACION']=date("Y-m-d H:i:s");
			$data['CALIFICACION'] = $promedio_gen;
			$data['ID_USUARIO'] = $id_usuario_en_sesion;
			$this->db->where('acad_calificacion.ID_CALIFICACION', $id_calificacion);
			$this->db->update('acad_calificacion', $data);
		}elseif(count($ds)<=0 and $promedio_etapa!=''){      
			$data = array();
			$data['ID_USUARIO'] = $id_usuario_en_sesion;
			$data['ID_PERIODO_ACADEMICO']=$periodo;
			$data['ID_ESTUDIANTE_CARRERA_MATERIA']=$id_estudiante_carrera_materia;
			$data['ID_TIPO_CALIFICACION']=3; //de tipo: final periodo
			$data['FECHA_HORA']=date("Y-m-d H:i:s");
			$data['CALIFICACION']=number_format(floatval($ds_prom_gen['CALIFICACION']/$etapas),2);
			$this->db->insert('acad_calificacion', $data);
		}
		/*$this->db->select("ID_CALIFICACION,CALIFICACION");
		$this->db->from('acad_calificacion');
		$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$estudiante_carrera_meteria);
		$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
		$this->db->where('ETAPA',0);
		$this->db->where('ID_TIPO_CALIFICACION',6); //de tipo: final de la etapa
		$query = $this->db->get();
		$ds = $query->row_array(); 

		if(count($ds)>0 and $promedio_etapa!='' and $ds['CALIFICACION']!=$promedio_gen) //si ya habia sido insertada una nota promedio, actualizo
		{
			$id_calificacion = $ds['ID_CALIFICACION'];
			$data = array();
			$data['ID_USUARIO_ACTUALIZA'] = $id_usuario_en_sesion;
			$data['FECHA_ACTUALIZACION']=date("Y-m-d H:i:s");
			$data['CALIFICACION'] = number_format(floatval($ds_prom_gen['CALIFICACION']/$etapas),2);
			//$data['ID_USUARIO'] = $id_usuario_en_sesion;
			$data['ETAPA'] = 0;

			$this->db->where('acad_calificacion.ID_CALIFICACION', $id_calificacion);
			$this->db->update('acad_calificacion', $data);
		}
		elseif(count($ds)<=0 and $promedio_etapa!='')
		{      
			$data = array();
			$data['ID_USUARIO'] = $id_usuario_en_sesion;
			$data['ID_PERIODO_ACADEMICO']=$periodo;
			$data['ID_ESTUDIANTE_CARRERA_MATERIA']=$id_estudiante_carrera_materia;
			$data['ID_TIPO_CALIFICACION']=6; //de tipo: final etapa
			$data['FECHA_HORA']=date("Y-m-d H:i:s");
			$data['CALIFICACION']=number_format(floatval($ds_prom_gen['CALIFICACION']/$etapas),2);
			$data['ETAPA']=0;

			$this->db->insert('acad_calificacion', $data);
		}*/
		$this->db->trans_complete();
	}

	// **************************************************************************************
	public function getPeriodos($id_periodo_academico=null)
	{
		$this->db->select('*');
		$this->db->from('acad_periodo_academico');
		if($id_periodo_academico!=null and $id_periodo_academico>0){
			$this->db->where('ID_PERIODO_ACADEMICO',$id_periodo_academico);
		}
		$this->db->order_by('FECHA_INICIO','ASC');
		$query=$this->db->get();
		$ds=$query->result_array();
		return $ds;
	}
	

	public function buscarEstudiantesInscritos($ap, $am, $pn, $sn, $id_carrera, $id_modalidad, $periodo)
	{
		$sql = "select DISTINCT a.id_rubro,a.id_cliente,sum(precio_unitario_rubro) AS RUBRO,
					p.ID_PERSONA,CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, 
					p.SEGUNDO_NOMBRE) as ESTUDIANTE,cont.CORREO_ELECTRONICO as CORREO,
					cli.NRO_DOCUMENTO as CEDULA,cont.telefono AS TELEFONO,cont.celular AS 
					CELULAR,nacho.NACIONALIDAD AS NACIONALIDAD ";
		$sql .= "from fac_clientes_rubros a LEFT join tab_clientes_naturales b on a.ID_CLIENTE = b.ID_CLIENTE ";
		$sql .= "left join tab_personas p on p.id_PERSONA=b.id_PERSONA
						left join tab_clientes cli on cli.ID_CLIENTE=a.ID_CLIENTE
						LEFT JOIN tab_nacionalidades nacho on nacho.ID_NACIONALIDAD =p.ID_NACIONALIDAD
						left join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION 
						left join acad_inscripcion i on i.ID_PERSONA = p.ID_PERSONA 
						LEFT JOIN acad_carrera carr on carr.ID_CARRERA=i.id_CARRERA
						LEFT JOIN acad_modalidad mo on mo.ID_MODALIDAD=i.id_MODALIDAD
						left join tab_contactos cont on cont.id_CLIENTE=cli.id_cliente and cont.ESTADO=1
						left join acad_matricula mat on mat.ID_PERSONA = p.ID_PERSONA";
		$sql .= " where o.ID_OCUPACION=1 and a.id_rubro in(18,19) and i.PAGADA=1 ";
		if($ap!="" && $ap!=null)
			$sql .=" and p.APELLIDO_PATERNO like '%".$ap."%' " ;
		if($am!="" && $am!=null)
			$sql .=" and p.APELLIDO_MATERNO like '%".$am."%' " ;
		if($pn!="" && $pn!=null)
			$sql .=" and p.PRIMER_NOMBRE like '%".$pn."%' " ;
		if($sn!="" && $sn!=null)
			$sql .=" and p.SEGUNDO_NOMBRE like '%".$sn."%' " ;
		if($id_carrera!="" && $id_carrera!=null)
			$sql .=" and carr.ID_CARRERA=".$id_carrera;
		if($id_modalidad!="" && $id_modalidad!=null)
			$sql .=" and mat.ID_MODALIDAD=".$id_modalidad;
		if($periodo!="" && $periodo!=null)
			$sql .=" and i.ID_PERIODO_ACADEMICO=".$periodo;
		$sql .=" GROUP BY(a.id_cliente) ORDER BY (a.id_cliente) ";
		$query = $this->db->query($sql);
		$ds= $query->result_array();   
		if(count($ds)>0)
			return $ds;
		else
			return false;
	}

	//**********************************************************
	//utilizo en la generacion de reportes
	public function buscarEstudiantesInscritosAll($data=array())
	{
		$datos=array();
		$this->db->select("DISTINCT a.id_rubro,a.id_cliente,sum(precio_unitario_rubro) AS RUBRO,
p.ID_PERSONA,CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as ESTUDIANTE,
i.FECHA as FECHA_INGRESO,cont.CORREO_ELECTRONICO as CORREO,cli.TIPO_DOCUMENTO as TIPO_DOC,
cli.NRO_DOCUMENTO as CEDULA,cont.telefono AS TELEFONO,cont.celular AS CELULAR,
CONCAT_WS(' ',cont.DIRECcION_CALLE_PRINCIPAL,cont.direccion_numero,cont.direccion_calle_secundaria1) As DIRECCION
,gen.GENERO,nacho.NACIONALIDAD AS NACIONALIDAD,p.FECHA_NACIMIENTO,prov.PROVINCIA,can.CANTON,p.est_titulo_bachiller AS TITULO_BACHILLER,
p.est_colegio_graduacion AS COLEGIO,p.est_ano_graduacion as GRADUACION ,pai.PAIS,carr.NOMBRE as CARRERA,mo.MODALIDAD,ase.sistema_estudio as SISTEMA,aae.AREA_ESTUDIO as AREA,
p.descripcion_discapacidad as DISCAPACIDAD,p.carnet_conadis AS CARNET,p.porcentaje_dicapacidad PORCENTAJE,tgc.GRUPO_CULTURAL AS ETNIA",false);
		$this->db->from('fac_clientes_rubros a');
		$this->db->join('tab_clientes_naturales b', 'a.id_cliente= b.id_cliente','LEFT');
		$this->db->join('tab_personas p', 'p.id_PERSONA=b.id_PERSONA ','LEFT');
		$this->db->join('tab_clientes cli', 'cli.ID_CLIENTE=a.ID_CLIENTE','LEFT');
		$this->db->join('tab_nacionalidades nacho', 'nacho.ID_NACIONALIDAD = p.ID_NACIONALIDAD','LEFT');
		$this->db->join('tab_ocupaciones o', 'o.ID_OCUPACION = p.OCUPACION','LEFT');
		$this->db->join('acad_inscripcion i', 'i.ID_PERSONA = p.ID_PERSONA ','LEFT');
		$this->db->join('acad_carrera carr', 'carr.ID_CARRERA=i.id_CARRERA','LEFT');
		$this->db->join('acad_modalidad mo', 'mo.ID_MODALIDAD=i.id_MODALIDAD','LEFT');
		$this->db->join('tab_contactos cont', 'cont.id_CLIENTE=cli.id_cliente and cont.ESTADO=1','LEFT');
		$this->db->join('acad_periodo_academico pacad', 'pacad.ID_PERIODO_ACADEMICO=i.id_periodo_academico','LEFT');
		$this->db->join('acad_matricula mat', 'mat.ID_PERSONA = p.ID_PERSONA ','LEFT');
		$this->db->join('tab_generos gen', 'gen.ABREVIATURA_GENERO = p.GENERO','LEFT');
		$this->db->join('tab_provincias prov', 'prov.ID_PROVINCIA=p.ID_PROVINCIA_NACIMIENTO ','LEFT');
		$this->db->join('tab_cantones can', 'can.ID_CANTON = p.ID_CANTON_NACIMIENTO ','LEFT');
		$this->db->join('tab_paises pai', 'pai.ID_PAIS=p.EST_PAIS_GRADUACION','LEFT');
		$this->db->join('acad_area_estudio aae', 'aae.ID_AREA_ESTUDIO=carr.ID_AREA_ESTUDIO','LEFT');
		$this->db->join('acad_sistema_estudio ase', 'ase.ID_SISTEMA_ESTUDIO=carr.ID_SISTEMA_ESTUDIO','LEFT');
		$this->db->join('tab_grupos_culturales tgc', 'tgc.ID_GRUPO_CULTURAL =p.ID_GRUPO_CULTURAL ','LEFT');   
		$this->db->where('o.ID_OCUPACION',1);
		$this->db->where('i.PAGADA',1);		
		if(isset($data['ap']) && $data['ap']!=null)
			$this->db->where('p.APELLIDO_PATERNO like','%'.$data['ap'].'%');
		if(isset($data['am']) && $data['am']!=null)
			$this->db->where('p.APELLIDO_MATERNO like','%'.$data['am'].'%');
		if(isset($data['pn']) && $data['pn']!=null)
			$this->db->where('p.PRIMER_NOMBRE like','%'.$data['pn'].'%');
		if(isset($data['sn']) && $data['sn']!=null)
			$this->db->where('p.SEGUNDO_NOMBRE like','%'.$data['sn'].'%');
		if(isset($data['id_carrera']) && $data['id_carrera']!=null)
			$this->db->where('carr.ID_CARRERA',$data['id_carrera']);
		if(isset($data['id_modalidad']) && $data['id_modalidad']!=null)
			$this->db->where('mo.ID_MODALIDAD',$data['id_modalidad']);
		if(isset($data['id_periodo']) && $data['id_periodo']!=null)
			$this->db->where('i.ID_PERIODO_ACADEMICO',$data['id_periodo']);
		$this->db->where_in('a.id_rubro',array('18','19'));
		$this->db->group_by('a.id_cliente,ESTUDIANTE,CORREO,CEDULA,TELEFONO,CELULAR,NACIONALIDAD'); 
		$this->db->order_by("a.id_cliente","asc");
		$query= $this->db->get();
	   // $query = $this->db->query($sql);
		$ds= $query->result_array();
		$datos['estudiantes']=$ds;
		return $datos;       
	}


	public function buscarAlumnoMateria($data)
	{
		/*
		$sql ="select acm.id_estudiante_carrera_materia,p.ID_PERSONA,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE, p.APELLIDO_PATERNO, p.APELLIDO_MATERNO, acm.ID_GRUPO, acm.NIVEL_MATERIA,acm.ID_PERIODO_ACADEMICO,acm.ID_CARRERA ";
		$sql.= "from tab_personas p inner join tab_clientes_naturales cn on cn.ID_PERSONA = p.ID_PERSONA ";
		$sql.= "left join acad_estudiante_carrera_materia acm on acm.ID_PERSONA = cn.ID_PERSONA  inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION WHERE o.ID_OCUPACION=1 ";
		if($ap!="" && $ap!=null)
			$sql .=" and p.APELLIDO_PATERNO like '%".$ap."%' " ;
		if($am!="" && $am!=null)
			$sql .=" and p.APELLIDO_MATERNO like '%".$am."%' " ;
		if($pn!="" && $pn!=null)
			$sql .=" and p.PRIMER_NOMBRE like '%".$pn."%' " ;
		if($sn!="" && $sn!=null)
			$sql .=" and p.SEGUNDO_NOMBRE like '%".$sn."%' " ;

		if($id_carrera!="" && $id_carrera!=null)
			$sql .=" and acm.ID_CARRERA=".$id_carrera;
		if($id_nivel!="" && $id_nivel!=null)
			$sql .=" and acm.NIVEL_MATERIA=".$id_nivel;

		 if($id_periodo_academico!="" && $id_periodo_academico!=null)
			$sql .=" and acm.id_periodo_academico=".$id_periodo_academico;

		$sql.= " group by p.ID_PERSONA ";

		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		*/

		/*
		$this->db->select("acm.id_estudiante_carrera_materia,p.ID_PERSONA,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE, p.APELLIDO_PATERNO, p.APELLIDO_MATERNO, acm.ID_GRUPO, acm.NIVEL_MATERIA,acm.ID_PERIODO_ACADEMICO,acm.ID_CARRERA ");
		$this->db->from('tab_personas p ');
		$this->db->join('tab_clientes_naturales cn', 'cn.ID_PERSONA = p.ID_PERSONA');
		$this->db->join('acad_estudiante_carrera_materia acm', 'p.ID_PERSONA = acm.ID_PERSONA ');
		$this->db->join('tab_ocupaciones o', 'o.ID_OCUPACION = p.OCUPACION');
		$this->db->where('acm.ID_CARRERA',$id_carrera );        
		$this->db->where('acm.NIVEL_MATERIA',$id_nivel );
		$this->db->where('acm.ID_PERIODO_ACADEMICO',$id_periodo_academico ); 
		$this->db->where('acm.ID_GRUPO>',0 );//adicionado no tome en cuenta los null de homologado o convalidado       
		$this->db->group_by("p.ID_PERSONA","asc");
		*/
		
		if(!isset($data['id_periodo_academico']) or $data['id_periodo_academico']=='' or $data['id_periodo_academico']==null){
			$data['id_periodo_academico']=$this->get_periodo_activado();
		}
		
		$sql_adi="";
		if(isset($data['PAGO']) and $data['PAGO']==1){
			$sql_adi=",pe.ID_PAGO_ESTUDIANTE, pe.ARCHIVO, pe.FECHA_CREACION as FECHA_CREACION_PAGO, pe.ID_FACTURA, pe.ESTADO as ESTADO_PAGO, pe.FECHA_ACTUALIZACION as FECHA_ACTUALIZACION_PAGO, pe.VALOR as VALOR_PAGO, pe.MOTIVO_RECHAZO";
			if(isset($data['PERFIL']) and $data['PERFIL']==5){
				$sql_adi.=", concat(f.PTO_EMISION,'-',LPAD(f.NRO_FACTURA,9,'0')) as FACTURA, fe.ESTADO as ESTADO_ELECTRONICA, fe.ID_FACTURA_ELECTRONICA, f.CLIENTE_DENOMINACION, f.CLIENTE_NRO_DOCUMENTO";
			}
        }
		
		$this->db->select("c.NRO_DOCUMENTO,p.ID_PERSONA,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE, p.APELLIDO_PATERNO, p.APELLIDO_MATERNO, CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as ESTUDIANTE, m.ID_GRUPO, m.ID_NIVEL,m.ID_PERIODO_ACADEMICO,m.ID_CARRERA,m.ID_MATRICULA,c.ID_CLIENTE, car.NOMBRE as CARRERA, p.CORREO_INSTITUCIONAL, g.NOMBRE as GRUPO".$sql_adi,false);
		$this->db->from('tab_personas p ');
		$this->db->join('acad_matricula m', 'm.ID_PERSONA = p.ID_PERSONA ');
		$this->db->join('acad_carrera car', 'car.ID_CARRERA = m.ID_CARRERA');
		$this->db->join('tab_ocupaciones o', 'o.ID_OCUPACION = p.OCUPACION');
		//$this->db->join('acad_estudiante_carrera_materia ecm', 'ecm.ID_CARRERA = m.ID_CARRERA and ecm.NIVEL_MATERIA=m.ID_NIVEL and ecm.ID_PERSONA=m.ID_PERSONA and ecm.ID_PERIODO_ACADEMICO=m.ID_PERIODO_ACADEMICO');
		$this->db->join('tab_clientes_naturales cn', 'cn.ID_PERSONA = p.ID_PERSONA');
		$this->db->join('tab_clientes c', 'c.ID_CLIENTE= cn.ID_CLIENTE'); 
		$this->db->join('acad_grupo g', 'g.ID_GRUPO= m.ID_GRUPO');
		$this->db->where('m.ID_PERIODO_ACADEMICO',$data['id_periodo_academico'] );	
		
		if(isset($data['PAGO']) and $data['PAGO']==1){
			$this->db->join('fac_pagos_estudiantes pe','pe.ID_MATRICULA = m.ID_MATRICULA');
			if(isset($data['PERFIL']) and $data['PERFIL']==5){
				$this->db->join('fac_facturas f','f.ID_FACTURA=pe.ID_FACTURA','left');
				$this->db->join('fac_facturas_electronicas fe','fe.ID_FACTURA=pe.ID_FACTURA','left');
			}
			$this->db->where('pe.TIPO',1);//pagos amortizacion
			if(isset($data['ESTADO_PAGO']) and $data['ESTADO_PAGO']!='' and $data['ESTADO_PAGO']!=null){
				$this->db->where('pe.ESTADO',$data['ESTADO_PAGO']);
			}
        }
		if(isset($data['id_financiero']) and $data['id_financiero']>0){
			$this->db->join('admin_usuarios u','u.ID_PERSONA = m.ID_PERSONA');
			$this->db->join('acad_asesor_estudiante ae','ae.ID_USUARIO_ESTUDIANTE = u.ID_USUARIO');
			$this->db->where('ae.ID_USUARIO_FINANCIERO',$data['id_financiero']);
		}
		if(isset($data['id_academico']) and $data['id_academico']>0){
			$this->db->join('admin_usuarios u','u.ID_PERSONA = m.ID_PERSONA');
			$this->db->join('acad_asesor_estudiante ae','ae.ID_USUARIO_ESTUDIANTE = u.ID_USUARIO');
			$this->db->where('ae.ID_USUARIO_ACADEMICO',$data['id_academico']);
		}
			
		if(isset($data['id_carrera']) and $data['id_carrera']!=NULL){
			$this->db->where('m.ID_CARRERA',$data['id_carrera'] );
		}
		if(isset($data['id_matricula']) and $data['id_matricula']!=NULL){
			$this->db->where('m.id_matricula',$data['id_matricula'] );
		}
		if(isset($data['id_nivel']) and $data['id_nivel']!=NULL){
			$this->db->where('m.ID_NIVEL',$data['id_nivel'] );
		}
		if(isset($data['id_nivel_mayor']) and $data['id_nivel_mayor']!=NULL){
			$this->db->where('m.ID_NIVEL>',$data['id_nivel_mayor'] );
		}
		if(isset($data['ap']) and $data['ap']!=NULL){
			$this->db->where('p.APELLIDO_PATERNO like','%'.$data['ap'].'%' );
		}
		if(isset($data['am']) and $data['am']!=NULL){
			$this->db->where('p.APELLIDO_MATERNO like','%'.$data['am'].'%' );
		}
		if(isset($data['pn']) and $data['pn']!=NULL){
			$this->db->where('p.PRIMER_NOMBRE like','%'.$data['pn'].'%' );
		}
		if(isset($data['sn']) and $data['sn']!=NULL){
			$this->db->where('p.SEGUNDO_NOMBRE like','%'.$data['sn'].'%' );
		}
		if(isset($data['nd']) and $data['nd']!=NULL){
			$this->db->where('c.NRO_DOCUMENTO like','%'.$data['nd'].'%' );
		}
		if(isset($data['estado_matricula']) and $data['estado_matricula']!=NULL){
			$this->db->where('m.ESTADO',$data['estado_matricula']);
		}
		if(isset($data['id_persona']) and $data['id_persona']!=NULL){
			$this->db->where('m.ID_PERSONA',$data['id_persona'] );
		}
		if(isset($data['grupo']) and $data['grupo'] !=null){
			$this->db->where('g.NOMBRE',$data['grupo'] );
		}
		//$this->db->group_by(array("p.ID_PERSONA", "m.ID_CARRERA"),"asc");
		$this->db->order_by("m.ID_MATRICULA","asc");
		$query = $this->db->get();
		$ds = $query->result_array();		
		/*$ds_filtrado=array();
		$i=0;
		foreach($ds as $key=>$row){//asigno el dato de grupo de cada alumno
			$ds[$key]['GRUPO']=$this->get_grupo_asignado($row['ID_CLIENTE'], $row['ID_CARRERA'], $row['ID_PERIODO_ACADEMICO'], $row['ID_NIVEL']);
			if(isset($data['grupo']) and $data['grupo'] !=null and $data['grupo']==$ds[$key]['GRUPO']){
				$ds_filtrado[$i]=$ds[$key];
				$i++;
			 }
		}
		if(isset($data['grupo']) and $data['grupo'] !=null){
			 $ds=$ds_filtrado;
		}*/
		if(count($ds)>0)
			return $ds;
		else
			return false;
	}

	//obtengo materias por alumno 
	public function get_materias_del_alumno_calificadas($id_persona)
	{
		$periodo= $this->get_periodo_activado();
		$this->db->select('acad_carrera.NOMBRE as CARRERA, acad_carrera.ID_CARRERA,
						   acad_materia.NOMBRE as MATERIA, acad_materia.ID_MATERIA,
						   acad_nivel.NIVEL, acad_nivel.ID_NIVEL');
		$this->db->from('acad_docente_carrera_materia');
		$this->db->join('acad_carrera_materia', 'acad_carrera_materia.ID_CARRERA_MATERIA = acad_docente_carrera_materia.ID_CARRERA_MATERIA');
		$this->db->join('acad_carrera', 'acad_carrera.ID_CARRERA = acad_carrera_materia.ID_CARRERA');
		$this->db->join('acad_materia', 'acad_materia.ID_MATERIA = acad_carrera_materia.ID_MATERIA');
		$this->db->join('acad_nivel', 'acad_nivel.ID_NIVEL = acad_carrera_materia.NIVEL_MATERIA');
		$this->db->where('acad_docente_carrera_materia.ID_PERSONA', $id_persona);
		$this->db->where('acad_docente_carrera_materia.ID_PERIODO_ACADEMICO', $periodo);
		$this->db->order_by("acad_carrera.ID_CARRERA", "asc");
		$this->db->order_by("acad_materia.NOMBRE", "asc"); 
		$this->db->order_by("acad_nivel.ID_NIVEL", "asc");
		$query = $this->db->get();
		$ds = $query->result_array(); 
		return $ds;
	}


	public function buscar_estdiante_calificado($id_persona,$id_grupo,$id_nivel,$id_carrera,$id_periodo_academico)
	{
		$this->db->trans_start();
	   // $id_periodo_academico= $this->get_periodo_activado();
		$datos=array();
		//preparo los datos de la cabecera del registro de calificaciones
		if($id_grupo>0){
			$this->db->select('acad_grupo.NOMBRE as GRUPO,
							  acad_carrera.NOMBRE as CARRERA,
							  acad_nivel.NIVEL as NIVEL');
			$this->db->from('acad_grupo');
			$this->db->join('acad_carrera', 'acad_carrera.ID_CARRERA = acad_grupo.ID_CARRERA');
			$this->db->join('acad_nivel', 'acad_nivel.ID_NIVEL = acad_grupo.ID_NIVEL');
			$this->db->where('acad_grupo.ID_GRUPO',$id_grupo );
			$query = $this->db->get();
			$cabecera = $query->row_array();
		}else{
			$cabecera['GRUPO'] = '';
		}
		$this->db->select('*');
		$this->db->from('acad_carrera');
		$this->db->where('ID_CARRERA',$id_carrera);
		$query = $this->db->get();
		$ds=$query->row_array();
		$cabecera['CARRERA'] = $ds['NOMBRE'];
		$this->db->select('*');
		$this->db->from('acad_nivel');
		$this->db->where('ID_NIVEL',$id_nivel );
		$query = $this->db->get();
		$ds=$query->row_array();
		$cabecera['NIVEL'] = $ds['NIVEL'];
		/*
		$this->db->select('acad_materia.NOMBRE');
		$this->db->from('acad_materia');
		$this->db->where('acad_materia.ID_MATERIA',$id_materia );
		$query = $this->db->get();
		$ds = $query->row_array(); 
		$cabecera['MATERIA']=$ds['NOMBRE'];
		*/
		$sql = "select CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE,p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as DOCENTE, c.NRO_DOCUMENTO, m.ESTADO ";
		$sql .= " from tab_personas p inner join tab_clientes_naturales cn on p.ID_PERSONA = cn.ID_PERSONA ";
		$sql .= " left join acad_matricula m on m.ID_PERSONA = p.ID_PERSONA and m.ID_PERIODO_ACADEMICO=".$id_periodo_academico;
		$sql .= " inner join tab_clientes c on c.ID_CLIENTE = cn.ID_CLIENTE ";
		$sql .= " inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION where p.OCUPACION=1 and m.ID_CARRERA=".$id_carrera." and cn.ID_PERSONA=".$id_persona;
		$query = $this->db->query($sql);
		$ds = $query->row_array(); 
		$cabecera['DOCENTE']=$ds['DOCENTE'];
		$cabecera['NRO_DOCUMENTO']=$ds['NRO_DOCUMENTO'];
		$cabecera['ESTADO']=$ds['ESTADO'];
		$datos['cabecera']=$cabecera;     
		//aqui se revisa para la generacion de etapas ver los periodos academicos
		//obtengo la configuracion del sistema de calificación de la carrera en cuestión (cant_etapas,cant_componentes,componentes)
		$this->db->select('acad_carrera_modalidad.CANT_ETAPAS,
							acad_carrera_modalidad.CANT_COMPONENTES,
							acad_carrera_modalidad.ID_CARRERA_MODALIDAD,
							acad_carrera_modalidad.BASE');
		$this->db->from('acad_carrera_modalidad');
		$this->db->join('acad_grupo', 'acad_grupo.ID_CARRERA = acad_carrera_modalidad.ID_CARRERA');
		$this->db->where('acad_grupo.ID_GRUPO',$id_grupo );
		$this->db->where('acad_carrera_modalidad.ID_PERIODO_ACADEMICO',$id_periodo_academico);
		$query = $this->db->get();
		$ds = $query->row_array(); 
		$datos['cant_etapas']=$ds['CANT_ETAPAS'];
		$datos['cant_componentes']=$ds['CANT_COMPONENTES'];
		$datos['base']=$ds['BASE'];

		$id_carrera_modalidad = $ds['ID_CARRERA_MODALIDAD'];
		$this->db->select('acad_componente.ID_COMPONENTE,
							acad_componente.NOMBRE,
							acad_carrera_modalidad_componente.VALOR_COMPONENTE');
		$this->db->from('acad_componente');
		$this->db->join('acad_carrera_modalidad_componente', 'acad_carrera_modalidad_componente.ID_COMPONENTE = acad_componente.ID_COMPONENTE');
		$this->db->where('acad_carrera_modalidad_componente.ID_CARRERA_MODALIDAD',$id_carrera_modalidad );
		$this->db->where('acad_carrera_modalidad_componente.ID_PERIODO_ACADEMICO',$id_periodo_academico );
		$this->db->order_by('acad_componente.ORDEN','ASC' );
		$query = $this->db->get();
		$ds = $query->result_array();
		$datos['componentes']=$ds;
		//aqui empiezo analizar el proceso realizado para la obtencion de las materias de los alumnos
		//obtengo los estudiantes que reciben la materia, en este grupo, con este profesor y en este periodo de tiempo
		$this->db->select("acad_estudiante_carrera_materia.ID_ESTUDIANTE_CARRERA_MATERIA, acad_materia.NOMBRE as NOMBRE_MATERIA, CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as NOMBRE_COMPLETO, acad_estudiante_carrera_materia.FUE_CONVALIDADA, acad_estudiante_carrera_materia.NOTA_CONVALIDACION, acad_estudiante_carrera_materia.FUE_HOMOLOGADA, acad_estudiante_carrera_materia.NOTA_HOMOLOGACION, acad_estudiante_carrera_materia.FUE_HISTORIAL, acad_estudiante_carrera_materia.NOTA_HISTORIAL, acad_estudiante_carrera_materia.ASISTENCIA_JUSTIFICADA, acad_estudiante_carrera_materia.BLOQUEO_CALIFICACION",false);
		$this->db->from('acad_materia');
		$this->db->join('acad_carrera_materia', 'acad_materia.ID_MATERIA = acad_carrera_materia.ID_MATERIA');
		$this->db->join('acad_estudiante_carrera_materia', 'acad_estudiante_carrera_materia.ID_CARRERA_MATERIA = acad_carrera_materia.ID_CARRERA_MATERIA');
		$this->db->join('tab_personas p', 'p.ID_PERSONA = acad_estudiante_carrera_materia.ID_PERSONA');
		//$this->db->where('acad_materia.ID_MATERIA',$id_materia );
		//$this->db->where('acad_estudiante_carrera_materia.ID_GRUPO',$id_grupo );
		$this->db->where('acad_estudiante_carrera_materia.ID_PERSONA',$id_persona );
		$this->db->where('acad_estudiante_carrera_materia.ID_PERIODO_ACADEMICO',$id_periodo_academico);
		$this->db->where('acad_estudiante_carrera_materia.ID_CARRERA',$id_carrera);
		$this->db->where('acad_estudiante_carrera_materia.FUE_CONVALIDADA',0);
		$this->db->where('acad_estudiante_carrera_materia.FUE_HOMOLOGADA',0);
		$this->db->where('acad_estudiante_carrera_materia.FUE_HISTORIAL',0);
		$this->db->order_by("NOMBRE_COMPLETO","asc");
		$this->db->order_by("NOMBRE_MATERIA","asc");
		$query = $this->db->get();
		$ds = $query->result_array();
		//recorro los estudiantes-carrera-materia, y por cada estudiante mando todas las calificaciones por componente, incluyendo el tipo de calificacion
		for($i=0; $i < count($ds); $i++){ 
			$id_estudiante_carrera_materia = $ds[$i]['ID_ESTUDIANTE_CARRERA_MATERIA'];
			$calificaciones_x_etapa=array();
			//recorro las etapas
			for($j=0; $j < $datos['cant_etapas']; $j++){
				$calificaciones_de_etapa_actual = array();
				//TOMO LAS CALIFICACIONES DEL ESTUDIANTE_CARRERA_MATERIA EN CADA UNO DE LOS COMPONENTES GRABADOS EN LA CARRERA para la etapa actual
				for($k=0; $k < count($datos['componentes']); $k++){
					$this->db->select("cal.ETAPA, cal.ID_COMPONENTE, cal.CALIFICACION");
					$this->db->from('acad_estudiante_carrera_materia ecm');
					$this->db->join('acad_calificacion cal', 'ecm.ID_ESTUDIANTE_CARRERA_MATERIA = cal.ID_ESTUDIANTE_CARRERA_MATERIA', 'left');
					$this->db->where('cal.ID_PERIODO_ACADEMICO',$id_periodo_academico);
					$this->db->where('cal.ETAPA',$j+1);
					$this->db->where('cal.ID_COMPONENTE',$datos['componentes'][$k]['ID_COMPONENTE']);
					$this->db->where('cal.ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
					$query = $this->db->get();
					$dataset = $query->result_array();
					array_push($calificaciones_de_etapa_actual, $dataset);
				}
				array_push($calificaciones_x_etapa, $calificaciones_de_etapa_actual);                
			}
			$ds[$i]['CALIFICACIONES_X_ETAPA']= $calificaciones_x_etapa;
		}
		//recorro los estudiantes-carrera-materia, y por cada estudiante mando todas las notas generales
		for($i=0; $i < count($ds); $i++){ 
			$id_estudiante_carrera_materia = $ds[$i]['ID_ESTUDIANTE_CARRERA_MATERIA'];
			$this->db->select("ETAPA,ID_TIPO_CALIFICACION, CALIFICACION");
			$this->db->from('acad_calificacion');
			$this->db->where('ID_PERIODO_ACADEMICO',$id_periodo_academico);
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			$this->db->where('ID_TIPO_CALIFICACION', 2);
			$query = $this->db->get();
			$dataset_notas_generales = $query->result_array();            
			$ds[$i]['CALIFICACIONES_GENERALES']= $dataset_notas_generales;

			$this->db->select("ID_TIPO_CALIFICACION, CALIFICACION");
			$this->db->from('acad_calificacion');
			$this->db->where('ID_PERIODO_ACADEMICO',$id_periodo_academico);
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			$this->db->where('ID_TIPO_CALIFICACION', 5);
			$query = $this->db->get();
			$dataset_supletorio = $query->row_array();
			if(count($dataset_supletorio)>0)
				$cal_supletorio = $dataset_supletorio['CALIFICACION'];
			else
				$cal_supletorio='';
			$ds[$i]['SUPLETORIO']= $cal_supletorio;

			$this->db->select("ID_TIPO_CALIFICACION, CALIFICACION");
			$this->db->from('acad_calificacion');
			$this->db->where('ID_PERIODO_ACADEMICO',$id_periodo_academico);
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			$this->db->where('ID_TIPO_CALIFICACION', 3);
			$query = $this->db->get();
			$dataset_promedio = $query->row_array();
			if(count($dataset_promedio)>0)
				$cal_promedio = $dataset_promedio['CALIFICACION'];
			else
				$cal_promedio='';
			$ds[$i]['PROMEDIO']= $cal_promedio;

			$this->db->select("ID_TIPO_CALIFICACION, CALIFICACION");
			$this->db->from('acad_calificacion');
			$this->db->where('ID_PERIODO_ACADEMICO',$id_periodo_academico);
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			$this->db->where('ID_TIPO_CALIFICACION', 6);
			$query = $this->db->get();
			$dataset_nota_final = $query->row_array();
			if(count($dataset_nota_final)>0)
				$cal_final = $dataset_nota_final['CALIFICACION'];
			else
				$cal_final='';
			$ds[$i]['FINAL']= $cal_final;

			$this->db->select("ID_TIPO_CALIFICACION, ESTADO_CALIFICACION");
			$this->db->from('acad_calificacion');
			$this->db->where('ID_PERIODO_ACADEMICO',$id_periodo_academico);
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			$this->db->where('ID_TIPO_CALIFICACION', 6);
			$this->db->where('ETAPA', 0);
			$query = $this->db->get();
			$dataset_estado_calificacion = $query->row_array();
			if(count($dataset_estado_calificacion)>0)
				$cal_estado_calificacion = $dataset_estado_calificacion['ESTADO_CALIFICACION'];
			else
				$cal_estado_calificacion='';
			$ds[$i]['ESTADO_CALIFICACION']= $cal_estado_calificacion;

			$this->db->select("ID_TIPO_CALIFICACION, CALIFICACION");
			$this->db->from('acad_calificacion');
			$this->db->where('ID_PERIODO_ACADEMICO',$id_periodo_academico);
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			$this->db->where('ID_TIPO_CALIFICACION', 4);
			$this->db->where('ETAPA', 0);
			$query = $this->db->get();
			$dataset_asistencia = $query->row_array();
			if(count($dataset_asistencia)>0)
				$cal_asistencia = $dataset_asistencia['CALIFICACION'];
			else
				$cal_asistencia='';
			$ds[$i]['ASISTENCIA']= $cal_asistencia;
		}
		$datos['estudiantes']=$ds;
		$this->db->trans_complete();
		return $datos;
	}
	
	
	public function buscar_certificado_estudiante($id_persona,$id_grupo,$id_nivel,$id_carrera,$id_periodo_academico)
	{
		$this->db->trans_start();
		//$periodo= $this->get_periodo_activado();
		$datos=array();
		//preparo los datos de la cabecera del registro de calificaciones
		if($id_grupo>0){
			$this->db->select('acad_grupo.NOMBRE as GRUPO,
							  acad_carrera.NOMBRE as CARRERA,
							  acad_nivel.NIVEL as NIVEL,
							  acad_modalidad.MODALIDAD as MODALIDAD');
			$this->db->from('acad_grupo');
			$this->db->join('acad_carrera', 'acad_carrera.ID_CARRERA = acad_grupo.ID_CARRERA');
			$this->db->join('acad_nivel', 'acad_nivel.ID_NIVEL = acad_grupo.ID_NIVEL');
			$this->db->join('acad_modalidad', 'acad_modalidad.ID_MODALIDAD = acad_carrera.ID_MODALIDAD');
			$this->db->where('acad_grupo.ID_GRUPO',$id_grupo );
			$query = $this->db->get();
			$cabecera = $query->row_array(); 
		}else{
			$this->db->select('*');
			$this->db->from('acad_carrera');
			$this->db->where('ID_CARRERA',$id_carrera );
			$query = $this->db->get();
			$ds=$query->row_array();
			$cabecera['CARRERA'] = $ds['NOMBRE'];
			$cabecera['GRUPO'] = '';
			$cabecera['NIVEL'] = '';
			$cabecera['MODALIDAD'] = '';
		}
		if($id_nivel>0){
			$this->db->select('*');
			$this->db->from('acad_nivel');
			$this->db->where('ID_NIVEL',$id_nivel );
			$query = $this->db->get();
			$r_nivel = $query->row_array(); 
			$cabecera['NIVEL'] = $r_nivel['NIVEL'];
		}
		/*
		$this->db->select('
							acad_materia.NOMBRE
						 ');
		$this->db->from('acad_materia');
		$this->db->where('acad_materia.ID_MATERIA',$id_materia );
		$query = $this->db->get();
		$ds = $query->row_array(); 
		$cabecera['MATERIA']=$ds['NOMBRE'];
		*/
		$sql = "select CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as DOCENTE, c.NRO_DOCUMENTO, p.GENERO, p.ID_ESTADO_CIVIL ";
		$sql .= " from tab_personas p inner join tab_clientes_naturales cn on p.ID_PERSONA = cn.ID_PERSONA ";
		$sql .= " inner join tab_clientes c on c.ID_CLIENTE = cn.ID_CLIENTE ";
		$sql .= " inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION where p.OCUPACION=1 and cn.ID_PERSONA=".$id_persona;
		$query = $this->db->query($sql);
		$ds = $query->row_array(); 
		$cabecera['DOCENTE']         = $ds['DOCENTE'];
		$cabecera['NRO_DOCUMENTO']   = $ds['NRO_DOCUMENTO'];
		$cabecera['GENERO']          = $ds['GENERO'];
		$cabecera['ID_ESTADO_CIVIL'] = $ds['ID_ESTADO_CIVIL'];
		$datos['cabecera']           = $cabecera;     
		//aqui se revisa para la generacion de etapas ver los periodos academicos
		//obtengo la configuracion del sistema de calificación de la carrera en cuestión (cant_etapas,cant_componentes,componentes)
		$this->db->select(' acad_carrera_modalidad.CANT_ETAPAS,
							acad_carrera_modalidad.CANT_COMPONENTES,
							acad_carrera_modalidad.ID_CARRERA_MODALIDAD,
							acad_carrera_modalidad.BASE');
		$this->db->from('acad_carrera_modalidad');
		$this->db->join('acad_grupo', 'acad_grupo.ID_CARRERA = acad_carrera_modalidad.ID_CARRERA');
		$this->db->where('acad_grupo.ID_GRUPO',$id_grupo );
		$this->db->where('acad_carrera_modalidad.ID_PERIODO_ACADEMICO',$id_periodo_academico);
		$query = $this->db->get();
		$ds = $query->row_array(); 
		$datos['cant_etapas']=$ds['CANT_ETAPAS'];
		$datos['cant_componentes']=$ds['CANT_COMPONENTES'];
		$datos['base']=$ds['BASE'];

		$id_carrera_modalidad = $ds['ID_CARRERA_MODALIDAD'];
		$this->db->select(' acad_componente.ID_COMPONENTE,
							acad_componente.NOMBRE,
							acad_carrera_modalidad_componente.VALOR_COMPONENTE');
		$this->db->from('acad_componente');
		$this->db->join('acad_carrera_modalidad_componente', 'acad_carrera_modalidad_componente.ID_COMPONENTE = acad_componente.ID_COMPONENTE');
		$this->db->where('acad_carrera_modalidad_componente.ID_CARRERA_MODALIDAD',$id_carrera_modalidad );
		$this->db->where('acad_carrera_modalidad_componente.ID_PERIODO_ACADEMICO',$id_carrera);
		$query = $this->db->get();
		$ds = $query->result_array();
		$datos['componentes']=$ds;
		//aqui empiezo analizar el proceso realizado para la obtencion de las materias de los alumnos
		//obtengo los estudiantes que reciben la materia, en este grupo, con este profesor y en este periodo de tiempo
		$this->db->select("acad_estudiante_carrera_materia.ID_ESTUDIANTE_CARRERA_MATERIA, acad_materia.NOMBRE as NOMBRE_MATERIA,acad_carrera_materia.CREDITOS_MATERIA,acad_estudiante_carrera_materia.ID_PERIODO_ACADEMICO AS PERIODO,acad_estudiante_carrera_materia.NIVEL_MATERIA AS NIVE,acad_estudiante_carrera_materia.CREDITOS_MATERIA AS CREDITOS, CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as NOMBRE_COMPLETO, acad_estudiante_carrera_materia.FUE_CONVALIDADA, acad_estudiante_carrera_materia.NOTA_CONVALIDACION, acad_estudiante_carrera_materia.FUE_HOMOLOGADA, acad_estudiante_carrera_materia.NOTA_HOMOLOGACION, acad_estudiante_carrera_materia.FUE_HISTORIAL, acad_estudiante_carrera_materia.NOTA_HISTORIAL",false);
		$this->db->from('acad_materia');
		$this->db->join('acad_carrera_materia', 'acad_materia.ID_MATERIA = acad_carrera_materia.ID_MATERIA');
		$this->db->join('acad_estudiante_carrera_materia', 'acad_estudiante_carrera_materia.ID_CARRERA_MATERIA = acad_carrera_materia.ID_CARRERA_MATERIA');
		$this->db->join('tab_personas p', 'p.ID_PERSONA = acad_estudiante_carrera_materia.ID_PERSONA');
		//$this->db->where('acad_materia.ID_MATERIA',$id_materia );
		//$this->db->where('acad_estudiante_carrera_materia.ID_GRUPO',$id_grupo );
		$this->db->where('acad_estudiante_carrera_materia.ID_PERSONA',$id_persona );
		$this->db->where('acad_estudiante_carrera_materia.ID_PERIODO_ACADEMICO',$id_periodo_academico);
		$this->db->where('acad_estudiante_carrera_materia.ID_CARRERA',$id_carrera);
		$this->db->order_by("NOMBRE_COMPLETO","asc");
		$this->db->order_by("NOMBRE_MATERIA","asc");
		$query = $this->db->get();
		$ds = $query->result_array();

		$total=array();
		$total1=0;
		//recorro los estudiantes-carrera-materia, y por cada estudiante mando todas las calificaciones por componente, incluyendo el tipo de calificacion
		$total_creditos=0;
		for($i=0; $i < count($ds); $i++){ 
			$id_estudiante_carrera_materia = $ds[$i]['ID_ESTUDIANTE_CARRERA_MATERIA'];
			$total_creditos+=$ds[$i]['CREDITOS_MATERIA'];
			$calificaciones_x_etapa=array();
			//recorro las etapas
			for($j=0; $j < $datos['cant_etapas']; $j++){
				$calificaciones_de_etapa_actual = array();
				//TOMO LAS CALIFICACIONES DEL ESTUDIANTE_CARRERA_MATERIA EN CADA UNO DE LOS COMPONENTES GRABADOS EN LA CARRERA para la etapa actual
				for($k=0; $k < count($datos['componentes']); $k++){
					$this->db->select("cal.ETAPA, cal.ID_COMPONENTE, cal.CALIFICACION");
					$this->db->from('acad_estudiante_carrera_materia ecm');
					$this->db->join('acad_calificacion cal', 'ecm.ID_ESTUDIANTE_CARRERA_MATERIA = cal.ID_ESTUDIANTE_CARRERA_MATERIA', 'left');
					$this->db->where('cal.ID_PERIODO_ACADEMICO',$id_periodo_academico);
					$this->db->where('cal.ETAPA',$j+1);
					$this->db->where('cal.ID_COMPONENTE',$datos['componentes'][$k]['ID_COMPONENTE']);
					$this->db->where('cal.ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
					$query = $this->db->get();
					$dataset = $query->result_array();
					array_push($calificaciones_de_etapa_actual, $dataset);
				}
				array_push($calificaciones_x_etapa, $calificaciones_de_etapa_actual);                
			}
			$ds[$i]['CALIFICACIONES_X_ETAPA']= $calificaciones_x_etapa;
		}
		$datos['cabecera']['total_creditos']=$total_creditos;
		//recorro los estudiantes-carrera-materia, y por cada estudiante mando todas las notas generales
		for($i=0; $i < count($ds); $i++){ 
			$id_estudiante_carrera_materia = $ds[$i]['ID_ESTUDIANTE_CARRERA_MATERIA'];
			$this->db->select("ETAPA,ID_TIPO_CALIFICACION, CALIFICACION");
			$this->db->from('acad_calificacion');
			$this->db->where('ID_PERIODO_ACADEMICO',$id_periodo_academico);
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			$this->db->where('ID_TIPO_CALIFICACION', 2);
			$query = $this->db->get();
			$dataset_notas_generales = $query->result_array();            
			$ds[$i]['CALIFICACIONES_GENERALES']= $dataset_notas_generales;

			$this->db->select("ID_TIPO_CALIFICACION, CALIFICACION");
			$this->db->from('acad_calificacion');
			$this->db->where('ID_PERIODO_ACADEMICO',$id_periodo_academico);
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			$this->db->where('ID_TIPO_CALIFICACION', 5);
			$query = $this->db->get();
			$dataset_supletorio = $query->row_array();
			if(count($dataset_supletorio)>0)
				$cal_supletorio = $dataset_supletorio['CALIFICACION'];
			else
				$cal_supletorio=0;
			$ds[$i]['SUPLETORIO']= $cal_supletorio;

			$this->db->select("ID_TIPO_CALIFICACION, CALIFICACION");
			$this->db->from('acad_calificacion');
			$this->db->where('ID_PERIODO_ACADEMICO',$id_periodo_academico);
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			$this->db->where('ID_TIPO_CALIFICACION', 3);
			$query = $this->db->get();
			$dataset_promedio = $query->row_array();
			if(count($dataset_promedio)>0)
				$cal_promedio = $dataset_promedio['CALIFICACION'];
			else
				$cal_promedio=0;
			$ds[$i]['PROMEDIO']= $cal_promedio;

			$this->db->select("ID_TIPO_CALIFICACION, CALIFICACION");
			$this->db->from('acad_calificacion');
			$this->db->where('ID_PERIODO_ACADEMICO',$id_periodo_academico);
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			$this->db->where('ID_TIPO_CALIFICACION', 6);
			$query = $this->db->get();
			$dataset_nota_final = $query->row_array();
			if(count($dataset_nota_final)>0)
				$cal_final = $dataset_nota_final['CALIFICACION'];
			else
				$cal_final=0;
			$ds[$i]['FINAL']= $cal_final;

			$this->db->select("ID_TIPO_CALIFICACION, ESTADO_CALIFICACION");
			$this->db->from('acad_calificacion');
			$this->db->where('ID_PERIODO_ACADEMICO',$id_periodo_academico);
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			$this->db->where('ID_TIPO_CALIFICACION', 6);
			$this->db->where('ETAPA', 0);
			$query = $this->db->get();
			$dataset_estado_calificacion = $query->row_array();
			if(count($dataset_estado_calificacion)>0)
				$cal_estado_calificacion = $dataset_estado_calificacion['ESTADO_CALIFICACION'];
			else
				$cal_estado_calificacion=0;
			$ds[$i]['ESTADO_CALIFICACION']= $cal_estado_calificacion;

			$this->db->select("ID_TIPO_CALIFICACION, CALIFICACION");
			$this->db->from('acad_calificacion');
			$this->db->where('ID_PERIODO_ACADEMICO',$id_periodo_academico);
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			$this->db->where('ID_TIPO_CALIFICACION', 4);
			$this->db->where('ETAPA', 0);
			$query = $this->db->get();
			$dataset_asistencia = $query->row_array();
			if(count($dataset_asistencia)>0)
				$cal_asistencia = $dataset_asistencia['CALIFICACION'];
			else
				$cal_asistencia=0;
			$ds[$i]['ASISTENCIA']= $cal_asistencia;

			$this->db->select('CALIFICACION');
			$this->db->from('acad_calificacion');
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			//$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
			$this->db->where('ID_TIPO_CALIFICACION',6); //de tipo: final etapa
			$query = $this->db->get();
			$promedio_de = $query->row_array();
			$total=number_format(floatval($promedio_de['CALIFICACION']),2);
			$total1=$total+$total1;
		}
		$datos['total1']=$total1;

		$this->db->select('*');
		$this->db->from('acad_periodo_academico');
		$query = $this->db->get();
		$ds1 = $query->result_array();
		$periodos=count($ds1);
		//echo $periodos;
		$datos['periodos']=$periodos;

		$this->db->select('*');
		$this->db->from('acad_periodo_academico');
		$query = $this->db->get();
		$ds2 = $query->result_array();
		$periodos1=count($ds2);

		$this->db->select('id_periodo_academico,fecha_inicio, fecha_fin');
		$this->db->from('acad_periodo_academico');
		$this->db->where('id_periodo_academico',count($ds2));
		$query2 = $this->db->get();
		$ds3 = $query2->result_array();
		//echo $periodos;
		$datos['periodos1']=$ds3;

		$this->db->select('id_periodo_academico,fecha_inicio, fecha_fin');
		$this->db->from('acad_periodo_academico');
		$this->db->where('id_periodo_academico',$id_periodo_academico);
		$query3 = $this->db->get();
		$ds4 = $query3->result_array();
		//echo $periodos;
		$datos['periodos2']=$ds4;
		$datos['estudiantes']=$ds;
		$this->db->trans_complete();
		return $datos;
	}

 
	public function buscar_certificado_estudiante_detallado($id_persona,$id_grupo,$id_nivel,$id_carrera,$periodo=null)
	{
		$this->db->trans_start();
		if($periodo==null){
			$periodo= $this->get_periodo_activado();
		}
		//periodos de lso cuales se mostrara las calificaciones
		$d_periodos=$this->getPeriodosAnteriores($periodo);
		//$v_periodos[]=-1;
		$v_periodos[]=$periodo;
		foreach($d_periodos as $d_periodo){
		   $v_periodos[]=$d_periodo['ID_PERIODO_ACADEMICO'];
		}
		$datos=array();
		//preparo los datos de la cabecera del registro de calificaciones
		if($id_grupo>0){
			$this->db->select('acad_grupo.NOMBRE as GRUPO,
							  acad_carrera.NOMBRE as CARRERA,
							  acad_nivel.NIVEL as NIVEL,
							  acad_carrera.DURACION_EN_NIVELES as DURACION');
			$this->db->from('acad_grupo');
			$this->db->join('acad_carrera', 'acad_carrera.ID_CARRERA = acad_grupo.ID_CARRERA');
			$this->db->join('acad_nivel', 'acad_nivel.ID_NIVEL = acad_grupo.ID_NIVEL');
			$this->db->where('acad_grupo.ID_GRUPO',$id_grupo );
			$query = $this->db->get();
			$cabecera = $query->row_array(); 
		}else{
			$this->db->select('*');
			$this->db->from('acad_carrera');
			$this->db->where('ID_CARRERA',$id_carrera );
			$query = $this->db->get();
			$ds=$query->row_array();
			$cabecera['CARRERA']  = $ds['NOMBRE'];
			$cabecera['DURACION'] = $ds['DURACION_EN_NIVELES'];
		}
		$sql  = "select CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE,p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as DOCENTE, p.GENERO, p.ID_ESTADO_CIVIL, c.NRO_DOCUMENTO ";
		$sql .= " from tab_personas p inner join tab_clientes_naturales cn on p.ID_PERSONA = cn.ID_PERSONA ";
		$sql .= " inner join tab_clientes c on c.ID_CLIENTE = cn.ID_CLIENTE ";
		$sql .= " inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION where p.OCUPACION=1 and cn.ID_PERSONA=".$id_persona;
		$query = $this->db->query($sql);
		$ds = $query->row_array(); 
		$cabecera['DOCENTE']=$ds['DOCENTE'];
		$cabecera['NRO_DOCUMENTO']=$ds['NRO_DOCUMENTO'];
		$cabecera['GENERO']          = $ds['GENERO'];
		$cabecera['ID_ESTADO_CIVIL'] = $ds['ID_ESTADO_CIVIL'];
		$datos['cabecera']=$cabecera;  
		//aqui se revisa para la generacion de etapas ver los periodos academicos
		//obtengo la configuracion del sistema de calificación de la carrera en cuestión (cant_etapas,cant_componentes,componentes)
		$this->db->select(' acad_carrera_modalidad.CANT_ETAPAS,
							acad_carrera_modalidad.CANT_COMPONENTES,
							acad_carrera_modalidad.ID_CARRERA_MODALIDAD,
							acad_carrera_modalidad.BASE');
		$this->db->from('acad_carrera_modalidad');
		$this->db->join('acad_grupo', 'acad_grupo.ID_CARRERA = acad_carrera_modalidad.ID_CARRERA');
		//$this->db->where('acad_grupo.ID_GRUPO',$id_grupo );
		//$this->db->where('acad_carrera_modalidad.ID_PERIODO_ACADEMICO',$periodo);
		$query = $this->db->get();
		$ds = $query->row_array(); 
		$datos['cant_etapas']=$ds['CANT_ETAPAS'];
		$datos['cant_componentes']=$ds['CANT_COMPONENTES'];
		$datos['base']=$ds['BASE'];

		$id_carrera_modalidad = $ds['ID_CARRERA_MODALIDAD'];
		$this->db->select(' acad_componente.ID_COMPONENTE,
							acad_componente.NOMBRE,
							acad_carrera_modalidad_componente.VALOR_COMPONENTE');
		$this->db->from('acad_componente');
		$this->db->join('acad_carrera_modalidad_componente', 'acad_carrera_modalidad_componente.ID_COMPONENTE = acad_componente.ID_COMPONENTE');
		$this->db->where('acad_carrera_modalidad_componente.ID_CARRERA_MODALIDAD',$id_carrera_modalidad );
		//$this->db->where('acad_carrera_modalidad_componente.ID_PERIODO_ACADEMICO',$periodo );
		$query = $this->db->get();
		$ds = $query->result_array();
		$datos['componentes']=$ds;
		//aqui empiezo analizar el proceso realizado para la obtencion de las materias de los alumnos
		//obtengo los estudiantes que reciben la materia, en este grupo, con este profesor y en este periodo de tiempo
		$this->db->select("acad_estudiante_carrera_materia.ID_ESTUDIANTE_CARRERA_MATERIA, acad_materia.NOMBRE as NOMBRE_MATERIA,acad_estudiante_carrera_materia.ID_PERIODO_ACADEMICO AS PERIODO,acad_estudiante_carrera_materia.NIVEL_MATERIA AS NIVE,acad_estudiante_carrera_materia.CREDITOS_MATERIA AS CREDITOS, CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as NOMBRE_COMPLETO, acad_estudiante_carrera_materia.FUE_CONVALIDADA, acad_estudiante_carrera_materia.NOTA_CONVALIDACION, acad_estudiante_carrera_materia.FUE_HOMOLOGADA, acad_estudiante_carrera_materia.NOTA_HOMOLOGACION,acad_estudiante_carrera_materia.FUE_HISTORIAL, acad_estudiante_carrera_materia.NOTA_HISTORIAL",false);
		$this->db->from('acad_materia');
		$this->db->join('acad_carrera_materia', 'acad_materia.ID_MATERIA = acad_carrera_materia.ID_MATERIA');
		$this->db->join('acad_estudiante_carrera_materia', 'acad_estudiante_carrera_materia.ID_CARRERA_MATERIA = acad_carrera_materia.ID_CARRERA_MATERIA');
		$this->db->join('tab_personas p', 'p.ID_PERSONA = acad_estudiante_carrera_materia.ID_PERSONA');
		//$this->db->where('acad_materia.ID_MATERIA',$id_materia );
		//$this->db->where('acad_estudiante_carrera_materia.ID_GRUPO',$id_grupo );
		$this->db->where('acad_estudiante_carrera_materia.ID_PERSONA',$id_persona );
		$this->db->where('acad_estudiante_carrera_materia.ID_CARRERA',$id_carrera );
		//$this->db->where('acad_estudiante_carrera_materia.ID_PERIODO_ACADEMICO',$id_periodo_academico);
		$this->db->where_in('acad_estudiante_carrera_materia.ID_PERIODO_ACADEMICO',$v_periodos);
		$this->db->order_by("NIVE","asc");
		$this->db->order_by("NOMBRE_MATERIA","asc");
		$query = $this->db->get();
		$ds = $query->result_array();
		$total=array();
		$total1=0;
		//recorro los estudiantes-carrera-materia, y por cada estudiante mando todas las calificaciones por componente, incluyendo el tipo de calificacion
		for($i=0; $i < count($ds); $i++){ 
			$id_estudiante_carrera_materia = $ds[$i]['ID_ESTUDIANTE_CARRERA_MATERIA'];
			$calificaciones_x_etapa=array();
			//recorro las etapas
			for($j=0; $j < $datos['cant_etapas']; $j++){
				$calificaciones_de_etapa_actual = array();
				//TOMO LAS CALIFICACIONES DEL ESTUDIANTE_CARRERA_MATERIA EN CADA UNO DE LOS COMPONENTES GRABADOS EN LA CARRERA para la etapa actual
				for($k=0; $k < count($datos['componentes']); $k++){
					$this->db->select("cal.ETAPA, cal.ID_COMPONENTE, cal.CALIFICACION");
					$this->db->from('acad_estudiante_carrera_materia ecm');
					$this->db->join('acad_calificacion cal', 'ecm.ID_ESTUDIANTE_CARRERA_MATERIA = cal.ID_ESTUDIANTE_CARRERA_MATERIA', 'left');
					//$this->db->where('cal.ID_PERIODO_ACADEMICO',$periodo);
					$this->db->where('cal.ETAPA',$j+1);
					$this->db->where('cal.ID_COMPONENTE',$datos['componentes'][$k]['ID_COMPONENTE']);
					$this->db->where('cal.ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
					$query = $this->db->get();
					$dataset = $query->result_array();
					array_push($calificaciones_de_etapa_actual, $dataset);
				}
				array_push($calificaciones_x_etapa, $calificaciones_de_etapa_actual);                
			}
			$ds[$i]['CALIFICACIONES_X_ETAPA']= $calificaciones_x_etapa;
		}
		//recorro los estudiantes-carrera-materia, y por cada estudiante mando todas las notas generales
		$prom_final=0;
		for($i=0; $i < count($ds); $i++){ 
			$id_estudiante_carrera_materia = $ds[$i]['ID_ESTUDIANTE_CARRERA_MATERIA'];
			$this->db->select("ID_TIPO_CALIFICACION, CALIFICACION");
			$this->db->from('acad_calificacion');
			//$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			$this->db->where('ID_TIPO_CALIFICACION', 6);
			$query = $this->db->get();
			$dataset_nota_final = $query->row_array();
			if(count($dataset_nota_final)>0)
				$cal_final = $dataset_nota_final['CALIFICACION'];
			 else
				$cal_final=0;
			$ds[$i]['FINAL']= $cal_final;

			$this->db->select("ID_TIPO_CALIFICACION, ESTADO_CALIFICACION");
			$this->db->from('acad_calificacion');
			//$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			$this->db->where('ID_TIPO_CALIFICACION', 6);
			$this->db->where('ETAPA', 0);
			$query = $this->db->get();
			$dataset_estado_calificacion = $query->row_array();
			if(count($dataset_estado_calificacion)>0)
				$cal_estado_calificacion = $dataset_estado_calificacion['ESTADO_CALIFICACION'];
			else
				$cal_estado_calificacion=0;
			$ds[$i]['ESTADO_CALIFICACION']= $cal_estado_calificacion;

			$this->db->select('CALIFICACION');
			$this->db->from('acad_calificacion');
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
			//$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
			$this->db->where('ID_TIPO_CALIFICACION',6); //de tipo: final etapa
			$query = $this->db->get();
			$promedio_de = $query->row_array();
			$total=number_format(floatval($promedio_de['CALIFICACION']),2);
			$total1=$total+$total1;
		}
		$datos['total1']=$total1;

		$this->db->select('*');
		$this->db->from('acad_periodo_academico');
		$query = $this->db->get();
		$ds1 = $query->result_array();
		$periodos=count($ds1);

		$this->db->select('id_periodo_academico,fecha_inicio, fecha_fin');
		$this->db->from('acad_periodo_academico');
		$this->db->where('id_periodo_academico',count($ds1));
		$query1 = $this->db->get();
		$ds2 = $query1->result_array();
		//echo $periodos;
		foreach($ds1 as $periodo){
			$datos['periodos'][$periodo['ID_PERIODO_ACADEMICO']]=array('FECHA_INICIO'=>$periodo['FECHA_INICIO'],'FECHA_FIN'=>$periodo['FECHA_FIN']);
		}
		//$datos['periodos']=$ds2;
		$datos['estudiantes']=$ds;
		$this->db->trans_complete();
		return $datos;
	}
	
	
	public function get_periodo() 
	{
		$this->db->select('VALOR');
		$this->db->from('acad_parametro');
		$this->db->where('acad_parametro.ID_PARAMETRO', 8);
		$query = $this->db->get();
		$ds = $query->row_array();
		if($this->session->userdata('id_periodo')>0){
			//$this->session->userdata('loggeado')['PERIODO']=
			return $this->session->userdata('id_periodo');
		}elseif(count($ds)>0){
			return $ds['VALOR'];
		}else{
			return false;
		}
	}
	
	
	public function get_periodo_actual() 
	{
		$this->db->select('*');
		$this->db->from('acad_periodo_academico');
		$query = $this->db->get();
		$ds = $query->row_array();
		if (count($ds)>0)
			//return count($ds);
			return $ds;
		else
			return false;
	}
	
	///*************************/////
	/// codigo realizado por GM /////
	///*************************////
	
	public function buscarEstudiantesMatriculados($data)
	{
		$id_periodo_activado = $this->academico_model->get_periodo_activado();
		//$sql ="select i.PAGADA, mat.ID_MATRICULA, mat.ESTADO, p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE, p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.ID_PERSONA,cn.ID_CLIENTE ";
		$sql ="select mat.ID_MATRICULA, mat.ESTADO, p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE, p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.ID_PERSONA,cn.ID_CLIENTE, c.TIPO_DOCUMENTO, c.NRO_DOCUMENTO, p.ES_BECADO,mat.ID_PERIODO_ACADEMICO,mat.ID_CARRERA, mat.FECHA, mat.ID_NIVEL, mat.ID_MODALIDAD, mat.OPCION_PAGO, p.ID_GRUPO, carr.NOMBRE as CARRERA, n.NIVEL";
		$sql.= " from tab_personas p ";
		$sql.= " inner join tab_clientes_naturales cn on cn.ID_PERSONA = p.ID_PERSONA ";
		//$sql.= " join acad_inscripcion i on i.ID_PERSONA = p.ID_PERSONA  inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION ";
		$sql.= " inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION ";
		$sql.= " join acad_matricula mat on mat.ID_PERSONA = p.ID_PERSONA ";
		$sql.= " join tab_clientes c on c.ID_CLIENTE = cn.ID_CLIENTE ";
		$sql.= " join acad_carrera carr on carr.ID_CARRERA = mat.ID_CARRERA ";
		$sql.= " join acad_nivel n on n.ID_NIVEL = mat.ID_NIVEL ";
		//$sql.= " WHERE o.ID_OCUPACION=1 and p.FUE_INSCRITA=1 and mat.ID_PERIODO_ACADEMICO=".$id_periodo_activado;
		$sql.= " WHERE o.ID_OCUPACION=1 and mat.ID_PERIODO_ACADEMICO=".$id_periodo_activado;				
		if(isset($data['ap']) and $data['ap']!="" && $data['ap']!=null)
			$sql .=" and p.APELLIDO_PATERNO like '%".$data['ap']."%' " ;
		if(isset($data['am']) and $data['am']!="" && $data['am']!=null)
			$sql .=" and p.APELLIDO_MATERNO like '%".$data['am']."%' " ;
		if(isset($data['pn']) and $data['pn']!="" && $data['pn']!=null)
			$sql .=" and p.PRIMER_NOMBRE like '%".$data['pn']."%' " ;
		if(isset($data['sn']) and $data['sn']!="" && $data['sn']!=null)
			$sql .=" and p.SEGUNDO_NOMBRE like '%".$data['sn']."%' " ;
		if(isset($data['nd']) and $data['nd']!="" && $data['nd']!=null)
			$sql .=" and c.NRO_DOCUMENTO = '".$data['nd']."' " ;
		if(isset($data['id_carrera']) and $data['id_carrera']!="" && $data['id_carrera']!=null)
			$sql .=" and mat.ID_CARRERA=".$data['id_carrera'];
		if(isset($data['id_nivel']) and $data['id_nivel']!="" && $data['id_nivel']!=null)
			$sql .=" and mat.ID_NIVEL=".$data['id_nivel'];
		if(isset($data['estado']) and $data['estado']!="" && $data['estado']!=null)
			$sql .=" and mat.ESTADO=".$data['estado'];
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		//return $ds;
		//return false;
		//return $sql;
		if(count($ds)>0)
			return $ds;
		else
			return false;
	}
	
	
	public function anular_matricula($id_matricula,$idusuario) 
	{
		$id_periodo_activado = $this->academico_model->get_periodo_activado();
		//revisar si no tiene calificaciones para anular
		$this->db->select('c.ID_CALIFICACION');
		$this->db->from('acad_calificacion c');
		$this->db->join('acad_estudiante_carrera_materia ecm', 'ecm.ID_ESTUDIANTE_CARRERA_MATERIA = c.ID_ESTUDIANTE_CARRERA_MATERIA', 'Inner');
		$this->db->join('acad_matricula m', 'm.ID_PERSONA = ecm.ID_PERSONA and m.ID_CARRERA=ecm.ID_CARRERA', 'Inner');
		$this->db->where('ecm.ID_PERIODO_ACADEMICO',$id_periodo_activado);
		$this->db->where('m.ID_MATRICULA',$id_matricula);
		$query = $this->db->get();
		$ds = $query->row_array();		
		//Verificar si el usuario tiene funcion para forzar anulacion de matricula
		$this->db->select('pmf.id_peril_modulo_funcionalidad');
		$this->db->from('admin_perfil_modulo_funcionalidad pmf');
		$this->db->join('admin_usuario_perfil up','up.id_perfil=pmf.id_perfil');
		$this->db->where('pmf.id_funcionalidad','50');
		$this->db->where('up.id_usuario',$idusuario);
		$query = $this->db->get();
		$ds1 = $query->row_array();		
		//Proceso Anular
		if(count($ds)<=0 or count($ds1)>0){
			//enviar datos a VLC
			$matricula=$this->obtener_matricula(array('ID_MATRICULA'=>$id_matricula));
			$materias=$this->get_materias_estudiante($matricula['ID_PERSONA'],$id_periodo_activado,null,null,$matricula['ID_CARRERA']);
			$this->load->module('academico');
			foreach($materias as $m){
				//$this->academico->sendMateriaVlc($m['ID_ESTUDIANTE_CARRERA_MATERIA'],'borrar');
			}
			
			$query_actualiza_matricula = $this->db->query("update acad_matricula set ESTADO=1, FECHA_MODIFICACION=NOW() where ID_MATRICULA=".$id_matricula);
			$query_borra_calificaciones = $this->db->query("delete from acad_calificacion where ID_ESTUDIANTE_CARRERA_MATERIA in (select ID_ESTUDIANTE_CARRERA_MATERIA from acad_estudiante_carrera_materia where ID_PERSONA=".$matricula['ID_PERSONA']." and ID_CARRERA=".$matricula['ID_CARRERA']." and ID_PERIODO_ACADEMICO=".$id_periodo_activado.")");
			$query_borra_materias = $this->db->query("delete from acad_estudiante_carrera_materia where ID_PERSONA=".$matricula['ID_PERSONA']." and ID_CARRERA=".$matricula['ID_CARRERA']." and ID_PERIODO_ACADEMICO=".$id_periodo_activado);
			$query_cierra_pago_cuotas = $this->db->query("update fac_cuotas_generales set ESTADO=1 where ID_MATRICULA=".$id_matricula);
			//$query_bloquear_usuario = $this->db->query("update admin_usuarios set ESTADO=0 where ID_PERSONA=(select ID_PERSONA from acad_matricula where ID_MATRICULA=".$id_matricula.")");
			if($query_actualiza_matricula and $query_borra_materias and $query_cierra_pago_cuotas and $query_borra_calificaciones){
				$respuesta="ANULADO";
			}else{
				$respuesta="Fallo de anulacion matricula";
			}
		}else{
			$respuesta="No se puede anular matricula. Estudiante ya tiene Calificacion";
		}
	  return $respuesta;
	}
	
	//////////////////////////////////////////////////////////////////////////////////
	public function retirar_estudiante($id_matricula,$idusuario,$nota_asistencia) 
	{
		$id_periodo_activado = $this->academico_model->get_periodo_activado();
		//Proceso de retiro
		$query_actualiza_matricula = $this->db->query("update acad_matricula set ESTADO=2, FECHA_MODIFICACION=NOW() where ID_MATRICULA=".$id_matricula);
		$query_cierra_pago_cuotas = $this->db->query("update fac_cuotas_generales set ESTADO=1 where ID_MATRICULA=".$id_matricula);
		//$query_bloquear_usuario = $this->db->query("update admin_usuarios set ESTADO=0 where ID_PERSONA=(select ID_PERSONA from acad_matricula where ID_MATRICULA=".$id_matricula.")");		
		//se califica asistencia y se pone estado perdido en todas las materias del periodo matriculado
		/*$this->db->select('ecm.ID_ESTUDIANTE_CARRERA_MATERIA');
		$this->db->from('acad_estudiante_carrera_materia ecm');
		$this->db->join('acad_matricula m', 'ecm.ID_PERSONA = m.ID_PERSONA');
		$this->db->where('m.ID_MATRICULA',$id_matricula);
		$this->db->where('ecm.ID_PERIODO_ACADEMICO',$id_periodo_activado);
		$query = $this->db->get();*/
		
		$sql="select ecm.ID_ESTUDIANTE_CARRERA_MATERIA ";
		$sql.=" from acad_estudiante_carrera_materia ecm ";
		$sql.=" join acad_matricula m on m.ID_PERSONA = ecm.ID_PERSONA and m.ID_CARRERA=ecm.ID_CARRERA";
		$sql.=" where m.ID_MATRICULA=".$id_matricula;
		$sql.=" and ecm.ID_PERIODO_ACADEMICO=".$id_periodo_activado;
		$sql.=" and ecm.FUE_CONVALIDADA=0";
		$sql.=" and ecm.FUE_HOMOLOGADA=0";
		$sql.=" and ecm.FUE_HISTORIAL=0";
		$query = $this->db->query($sql);
		$ds = $query->result_array();		
		$supletorio=0;
		$estado=2;		
		for($i=0; $i < count($ds); $i++){
			//busco nota final del periodo
			$this->db->select("CALIFICACION,ESTADO_CALIFICACION");
			$this->db->from('acad_calificacion');
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$ds[$i]['ID_ESTUDIANTE_CARRERA_MATERIA']);
			$this->db->where('ID_PERIODO_ACADEMICO',$id_periodo_activado);
			$this->db->where('ID_TIPO_CALIFICACION',6); //de tipo: nota final
			$query = $this->db->get();
			$ds1 = $query->row_array();
			if(count($ds1)>0){
				$nota_final=$ds1['CALIFICACION'];
				if($ds1['CALIFICACION']=='' or $ds1['CALIFICACION']==NULL){
					$nota_final='0';
				}
				if($ds1['ESTADO_CALIFICACION']!=1){
					$this->updateAsistenciaSupletorioNotaFinal($ds[$i]['ID_ESTUDIANTE_CARRERA_MATERIA'],$nota_asistencia,$supletorio,$nota_final,$estado);
				}
			}else{
				$nota_final='0'; 
				$this->updateAsistenciaSupletorioNotaFinal($ds[$i]['ID_ESTUDIANTE_CARRERA_MATERIA'],$nota_asistencia,$supletorio,$nota_final,$estado);
			}
		}
		if($query_actualiza_matricula and $query_cierra_pago_cuotas){
			$respuesta="RETIRADO";
		}else{
			$respuesta="Fallo de retiro estudiante";
		}
		return $respuesta;
	}
	
	////////////////////////////////////////////////////////////////////////////////////
	public function buscarEstudiantesParaMatricular_Ant_20200907($ap, $am, $pn, $sn, $nd)
	{
		$id_periodo_activado = $this->academico_model->get_periodo_activado();
		//listado de matriculados en el periodo
		//$sql ="select i.PAGADA, mat.ID_MATRICULA, mat.ESTADO, p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE, p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.ID_PERSONA,cn.ID_CLIENTE ";
		$sql ="select mat.ID_MATRICULA, mat.ESTADO, p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE, p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.ID_PERSONA,cn.ID_CLIENTE, s.SEDE, car.NOMBRE as CARRERA, c.NRO_DOCUMENTO ";
		$sql.= "from tab_personas p inner join tab_clientes_naturales cn on cn.ID_PERSONA = p.ID_PERSONA ";
		$sql.= " inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION ";
		$sql.= " join acad_matricula mat on mat.ID_PERSONA = p.ID_PERSONA ";
		$sql.= " join tab_clientes c on c.ID_CLIENTE = cn.ID_CLIENTE ";
		$sql.= " join acad_carrera car on car.ID_CARRERA = mat.ID_CARRERA ";
		$sql.= " left join acad_grupo g on g.ID_GRUPO = p.ID_GRUPO ";
		$sql.= " left join acad_sede s on s.ID_SEDE = g.ID_SEDE ";
		//$sql.= " WHERE o.ID_OCUPACION=1 and p.FUE_INSCRITA=1 and mat.ID_PERIODO_ACADEMICO=".$id_periodo_activado;
		$sql.= " WHERE o.ID_OCUPACION=1 and mat.ID_PERIODO_ACADEMICO=".$id_periodo_activado;
		if($ap!="" && $ap!=null)
			$sql .=" and p.APELLIDO_PATERNO like '%".$ap."%' " ;
		if($am!="" && $am!=null)
			$sql .=" and p.APELLIDO_MATERNO like '%".$am."%' " ;
		if($pn!="" && $pn!=null)
			$sql .=" and p.PRIMER_NOMBRE like '%".$pn."%' " ;
		if($sn!="" && $sn!=null)
			$sql .=" and p.SEGUNDO_NOMBRE like '%".$sn."%' " ;
		if($nd!="" && $nd!=null)
			$sql .=" and c.NRO_DOCUMENTO = '".$nd."' " ;      
		$query = $this->db->query($sql);
		$ds1 = $query->result_array(); 
		$matriculados='';
		$num_matriculas='';
		for($i=0;$i<count($ds1);$i++){
			$matriculados.=$ds1[$i]['ID_PERSONA'].",";
			//$num_matriculas.="'".$ds1[$i]['NUMERO']."',";
		}
		
		//listado de no matriculados en el periodo sin tomar en cuenta si esta inscrito
		$sql ="select p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE, p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.ID_PERSONA,cn.ID_CLIENTE ";
		$sql.= "from tab_personas p inner join tab_clientes_naturales cn on cn.ID_PERSONA = p.ID_PERSONA ";
		$sql.= "inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION ";
		$sql.= " left join tab_clientes c on c.ID_CLIENTE = cn.ID_CLIENTE ";
		$sql.= " WHERE o.ID_OCUPACION=1";
		//listado de no matriculados en el periodo tomando en cuenta si esta inscrito
		/*$sql ="select i.PAGADA, p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE, p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.ID_PERSONA,cn.ID_CLIENTE ";
		$sql.= "from tab_personas p inner join tab_clientes_naturales cn on cn.ID_PERSONA = p.ID_PERSONA ";
		$sql.= "inner join acad_inscripcion i on i.ID_PERSONA = p.ID_PERSONA  inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION ";
		$sql.= " left join tab_clientes c on c.ID_CLIENTE = cn.ID_CLIENTE ";
		$sql.= " WHERE o.ID_OCUPACION=1";*/

		if($matriculados!='')
			$sql .=" and p.ID_PERSONA not in (".trim($matriculados,",").")";
		if($ap!="" && $ap!=null)
			$sql .=" and p.APELLIDO_PATERNO like '%".$ap."%' " ;
		if($am!="" && $am!=null)
			$sql .=" and p.APELLIDO_MATERNO like '%".$am."%' " ;
		if($pn!="" && $pn!=null)
			$sql .=" and p.PRIMER_NOMBRE like '%".$pn."%' " ;
		if($sn!="" && $sn!=null)
			$sql .=" and p.SEGUNDO_NOMBRE like '%".$sn."%' " ;
		if($nd!="" && $nd!=null)
			$sql .=" and c.NRO_DOCUMENTO ='".$nd."' " ;			
		$query = $this->db->query($sql);
		$ds2 = $query->result_array(); 	
		foreach($ds2 as $r){
			
		}
		$ds=array_merge($ds1,$ds2);
		if(count($ds)>0)
			return $ds;
		else
			return false;
	}
	
	////////////////////////////////////////////////////////////////////////////////////
	public function buscarEstudiantesParaMatricular($ap, $am, $pn, $sn, $nd)
	{
		$id_periodo_activado = $this->academico_model->get_periodo_activado();
		$matriculas=array();
		//listado de personas de tipo estudiante
		$sql ="select p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE, p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.ID_PERSONA,cn.ID_CLIENTE, c.NRO_DOCUMENTO, s.SEDE ";
		$sql.= "from tab_personas p inner join tab_clientes_naturales cn on cn.ID_PERSONA = p.ID_PERSONA ";
		$sql.= " left join tab_clientes c on c.ID_CLIENTE = cn.ID_CLIENTE ";
		$sql.= " left join acad_grupo g on g.ID_GRUPO = p.ID_GRUPO ";
		$sql.= " left join acad_sede s on s.ID_SEDE = g.ID_SEDE ";
		$sql.= " WHERE p.OCUPACION=1 and p.ESTADO=1";
		if($ap!="" && $ap!=null)
			$sql .=" and p.APELLIDO_PATERNO like '%".$ap."%' " ;
		if($am!="" && $am!=null)
			$sql .=" and p.APELLIDO_MATERNO like '%".$am."%' " ;
		if($pn!="" && $pn!=null)
			$sql .=" and p.PRIMER_NOMBRE like '%".$pn."%' " ;
		if($sn!="" && $sn!=null)
			$sql .=" and p.SEGUNDO_NOMBRE like '%".$sn."%' " ;
		if($nd!="" && $nd!=null)
			$sql .=" and c.NRO_DOCUMENTO ='".$nd."' " ;			
		$sql.= " order by p.PRIMER_NOMBRE";
		$query = $this->db->query($sql);
		$ds1 = $query->result_array(); 	
		foreach($ds1 as $r1){
			$ids_carrera='0';
			//buscar matriculas del estudiante en periodo actual
			$sql ="select mat.ID_MATRICULA, mat.ID_CARRERA, mat.ESTADO, car.NOMBRE as CARRERA ";
			$sql.= " from acad_matricula mat ";
			$sql.= " join acad_carrera car on car.ID_CARRERA = mat.ID_CARRERA ";
			$sql.= " WHERE mat.ID_PERSONA=".$r1['ID_PERSONA']." and mat.ID_PERIODO_ACADEMICO=".$id_periodo_activado;
			$query = $this->db->query($sql);
			$ds2 = $query->result_array(); 
			foreach($ds2 as $r2){
				$matriculas[]=array_merge($r1,$r2);
				$ids_carrera.=','.$r2['ID_CARRERA'];
			}
			//buscar matriculas del estudiante en periodos diferentes al actual y que no esten en cambio de carrera
			$sql ="select mat.ID_CARRERA, car.NOMBRE as CARRERA ";
			$sql.= " from acad_matricula mat ";
			$sql.= " join acad_carrera car on car.ID_CARRERA = mat.ID_CARRERA ";
			$sql.= " WHERE mat.ID_PERSONA=".$r1['ID_PERSONA']." and mat.ID_PERIODO_ACADEMICO!=".$id_periodo_activado;
			$sql.= " and mat.ID_CARRERA not in(".trim($ids_carrera,',').") and mat.ID_CARRERA not in (select ID_CARRERA_ANTERIOR from acad_cambio_carrera where ID_PERSONA=".$r1['ID_PERSONA'].")";
			$sql.= " group by mat.ID_CARRERA ";
			$query = $this->db->query($sql);
			$ds3 = $query->result_array(); 
			foreach($ds3 as $r3){
				$matriculas[]=array_merge($r1,$r3);
			}
			//si no tiene ninguna matricula
			if(count($ds2)<=0 and count($ds3)<=0){
				$matriculas[]=$r1;
			}
			
		}
		if(count($matriculas)>0)
			return $matriculas;
		else
			return false;
	}
	
	////////////////////////////////////////////////////////////////////////////
	public function obtener_estado_matricula($id,$referencia)
	{
		$id_periodo_activado = $this->academico_model->get_periodo_activado();
		if($referencia=='id_matricula'){
			$sql = "select ESTADO ";
			$sql .= " from acad_matricula ";
			$sql .= " where ID_MATRICULA=".$id;
		}
		if($referencia=='estudiante_carrera_materia'){
			$sql = "select m.ESTADO ";
			$sql .= " from acad_matricula m ";
			$sql .= " join acad_estudiante_carrera_materia ecm on ecm.ID_PERSONA=m.ID_PERSONA ";
			$sql .= " where ecm.ID_ESTUDIANTE_CARRERA_MATERIA=".$id;
			$sql .= " and m.ID_PERIODO_ACADEMICO=".$id_periodo_activado;
		}
		$query = $this->db->query($sql);
		$ds = $query->row_array();
		return $ds['ESTADO'];
	}
	
	//////////////////////////////////////////////////////////////////////////////////////
	public function obtener_numero_unico_matricula($id_cliente,$id_carrera=null)
	{
		$sql = "select NUMERO";
		$sql .= " from acad_matricula m";
		$sql .= " join tab_clientes_naturales cn on cn.ID_PERSONA=m.ID_PERSONA ";
		$sql .= " where cn.ID_CLIENTE=".$id_cliente;
		if($id_carrera>0){
			$sql .= " and m.ID_CARRERA=".$id_carrera;
		}
		$sql .= " order by ID_MATRICULA DESC";
		$query = $this->db->query($sql);
		$ds = $query->row_array();
		return $ds['NUMERO'];
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function borrar_materia_estudiante($id_persona,$nivel_materia,$id_carrera,$id_periodo_academico,$id_carrera_materia)
	{
		//borro las calificaciones de la materia
		$sql="DELETE FROM acad_calificacion ";
		$sql.=" WHERE ID_ESTUDIANTE_CARRERA_MATERIA in ";
		$sql.=" (select ID_ESTUDIANTE_CARRERA_MATERIA FROM acad_estudiante_carrera_materia ";
		$sql.=" WHERE ID_PERSONA = '".$id_persona."' ";
		$sql.=" AND NIVEL_MATERIA = '".$nivel_materia."'";
		$sql.=" AND ID_CARRERA = '".$id_carrera."' ";
		if($id_periodo_academico!=NULL){
			$sql.=" AND ID_PERIODO_ACADEMICO = '".$id_periodo_academico."' ";
		}
		$sql.=" AND ID_CARRERA_MATERIA = '".$id_carrera_materia."')";
		$this->db->query($sql);
		//enviar a VLC
		$this->db->select('ID_ESTUDIANTE_CARRERA_MATERIA');
		$this->db->from('acad_estudiante_carrera_materia');
		$this->db->where('ID_PERSONA', $id_persona);
		$this->db->where('NIVEL_MATERIA', $nivel_materia);
		$this->db->where('ID_CARRERA', $id_carrera);
		$this->db->where('ID_PERIODO_ACADEMICO', $id_periodo_academico);
		$this->db->where('ID_CARRERA_MATERIA', $id_carrera_materia);
		$query = $this->db->get();
		$ds = $query->row_array();
		if($ds!=NULL){
			$this->load->module('academico');
			$this->academico->sendMateriaVlc($ds['ID_ESTUDIANTE_CARRERA_MATERIA'],'borrar');
		}
		//borro la materia
		$this->db->where('ID_PERSONA', $id_persona);
		$this->db->where('NIVEL_MATERIA', $nivel_materia);
		$this->db->where('ID_CARRERA', $id_carrera);
		$this->db->where('ID_PERIODO_ACADEMICO', $id_periodo_academico);
		$this->db->where('ID_CARRERA_MATERIA', $id_carrera_materia);
		$this->db->delete('acad_estudiante_carrera_materia');
		return $this->db->affected_rows();
	}//fin borrar_materia_estudiante
	
	////////////////////////////////////////////////////////////////////////////////////
	public function datos_ultima_matricula_estudiante($id_cliente,$id_carrera=null)
	{
		$sql = "select *";
		$sql .= " from acad_matricula m";
		$sql .= " join tab_clientes_naturales cn on cn.ID_PERSONA=m.ID_PERSONA ";
		$sql .= " where cn.ID_CLIENTE=".$id_cliente;
		if($id_carrera!=null){
			$sql .= " and m.ID_CARRERA=".$id_carrera;
		}
		$sql .= " order by m.ID_MATRICULA DESC LIMIT 1";
		$query = $this->db->query($sql);
		$ds = $query->row_array();
		return $ds;
	}
	
	////////////////////////////////////////////////////////////////////
	public function obtener_idgrupo_estudiante($id_persona,$id_periodo_academico=null)
	{
		if($id_periodo_academico==null){
			$id_periodo_academico = $this->get_periodo_activado();
		}
		$this->db->select('ID_GRUPO');
		$this->db->from('acad_estudiante_carrera_materia');
		$this->db->where('ID_PERSONA',$id_persona );        
		$this->db->where('ID_PERIODO_ACADEMICO',$id_periodo_academico ); 
		$this->db->where('ID_GRUPO>',0 ); 
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds['ID_GRUPO'];
	}
	
	/////////////////////////////////////////////////////////////////
	public function obtener_idcarrera_estudiante($id_persona,$id_periodo_academico=null)
	{
		if($id_periodo_academico==null){
			$id_periodo_academico = $this->get_periodo_activado();
		}
		$this->db->select('ID_CARRERA');
		$this->db->from('acad_matricula');
		$this->db->where('ID_PERSONA',$id_persona );        
		$this->db->where('ID_PERIODO_ACADEMICO',$id_periodo_academico );
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds['ID_CARRERA'];
	}
	
	///////////////////////////////////////////////////////////////////
	public function obtener_idnivel_estudiante($id_persona,$id_periodo_academico=null)
	{
		if($id_periodo_academico==null){
			$id_periodo_academico = $this->get_periodo_activado();
		}
		$this->db->select('ID_NIVEL');
		$this->db->from('acad_matricula ');
		$this->db->where('ID_PERSONA',$id_persona );        
		$this->db->where('ID_PERIODO_ACADEMICO',$id_periodo_academico );
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds['ID_NIVEL'];
	}
	
	//////////////////////////////////////////////////////////////////////////////
	public function crearUsuarioClaveTemp($id_persona,$id_cliente,$nombre)
	{
		$this->db->select('*');
		$this->db->from('tab_clientes ');
		$this->db->where('ID_CLIENTE',$id_cliente );
		$query = $this->db->get();
		$ds = $query->row_array();
		$sql="insert into admin_usuarios values ('','".$id_persona."','".$ds['NRO_DOCUMENTO']."','".md5($ds['NRO_DOCUMENTO'])."','1','".$nombre."','".$ds['NRO_DOCUMENTO']."')";
		$this->db->query($sql);
		$id = $this->db->insert_id();
		$sql="insert into admin_usuario_perfil values ('','".$id."','5')";
		$this->db->query($sql);
		
		$this->db->select('*');
		$this->db->from('admin_usuarios ');
		$this->db->where('ID_USUARIO',$id );
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds;
	}
 
	//////////////////////////////////
	public function crearBeca($datos) 
	{
		$this->db->insert('tab_tipos_becas', $datos);
		return $this->db->insert_id();
	}
 
	/////////////////////////////////////////////////////////////////////////
	public function actualizarBeca($datos,$idBeca) 
	{
		$this->db->where('ID_TIPO_BECA', $idBeca);
		$this->db->update('tab_tipos_becas', $datos);
	}
 
	////////////////////////////////////////////////
	public function buscar_beca($data = array()) 
	{
		$this->db->select('*');
		$this->db->from('tab_tipos_becas');
		if (isset($data['NOMBRE']) and $data['NOMBRE'] != '') {
			$this->db->where('TIPO_BECA like', '%'.$data['NOMBRE'].'%');
		}
		if (isset($data['ID_BECA']) and $data['ID_BECA'] != '') {
			$this->db->where('ID_TIPO_BECA',$data['ID_BECA']);
		}
		$this->db->order_by('TIPO_BECA'); 
		$consulta = $this->db->get();
		$resultado = $consulta->result_array();
		return $resultado;
	}
	
	////////////////////////////////////////////////////////////////////////////////	
	public function aplicarBeca($idCliente)
	{
		$this->db->trans_start();
		$periodo= $this->get_periodo_activado();
		//obtengo el id como persona
		$this->db->select('ID_PERSONA');
		$this->db->from('tab_clientes_naturales');
		$this->db->where('ID_CLIENTE', $idCliente);
		$query = $this->db->get();
		$ds = $query->row_array();
		$id_persona = $ds['ID_PERSONA'];
		//revisar si esta matriculado
		$this->db->select('*');
		$this->db->from('acad_matricula');
		$this->db->where('ID_PERSONA', $id_persona);
		$this->db->where('ID_PERIODO_ACADEMICO', $periodo);
		$query = $this->db->get();
		$ds_matricula = $query->result_array();
		//revisar si ya tiene beca aplicada en el periodo actual consultado
		$this->db->select('*');
		$this->db->from('fac_clientes_rubros');
		$this->db->where('ID_CLIENTE', $idCliente);
		$this->db->where('PERIODO_VIGENTE', $periodo);
		$this->db->where('DESCUENTO_BECA>', 0);
		$query = $this->db->get();
		$ds_rubro_becado = $query->result_array();		
		if(count($ds_matricula)>0 and count($ds_rubro_becado)<=0){//si esta matriculado y no tiene beca
			//buscar todos los rubros asociados en la matricula del periodo actual
			$this->db->select('*');
			$this->db->from('fac_clientes_rubros');
			$this->db->where('ID_CLIENTE', $idCliente);
			$this->db->where('PERIODO_VIGENTE', $periodo);
			$query = $this->db->get();
			$ds_rubro_matricula = $query->result_array();		
			$this->load->model('facturacion/servicios_model');
			$clte = $this->servicios_model->buscarPorcentajeDescuentoCliente($idCliente);
			$porcentajeDescuento = $clte['PORCENTAJE'];
			if($porcentajeDescuento==NULL or $porcentajeDescuento==""){
				$porcentajeDescuento=0;
			}
			$rubros_aplica='+'.$clte['RUBROS_APLICA'].'+';
			//recorrer todos los rubros de la matricula
			foreach($ds_rubro_matricula as $row){
				$pos = strpos($rubros_aplica, '+'.$row['ID_RUBRO'].'+');
				if($pos!==false){//si a este rubro se aplica el descuento beca
					$precio_descuento_rubro=0;
					//obtengo los id de las cuotas del rubro sin abonos
					$this->db->select("ID_CLIENTE_RUBRO_CUOTA,PRECIO");
					$this->db->from('fac_clientes_rubros_cuota');
					$this->db->where('ID_CLIENTE_RUBRO',$row['ID_CLIENTE_RUBRO']);
					$this->db->where('VALOR_SALDADO_POR_PAGO',0);
					$query= $this->db->get();
					$ds = $query->result_array();
					//descuento en cada una de las cuotas
					for($i=0; $i<count($ds);$i++){
						$id_cliente_rubro_cuota = $ds[$i]['ID_CLIENTE_RUBRO_CUOTA']; 
						$precio_descuento_rubro_cuota = $ds[$i]['PRECIO']*$porcentajeDescuento/100;                     
						$sql = "update fac_clientes_rubros_cuota set PRECIO=PRECIO-".$precio_descuento_rubro_cuota;
						$sql.=" where ID_CLIENTE_RUBRO_CUOTA=".$id_cliente_rubro_cuota;
						$this->db->query($sql);
						$precio_descuento_rubro+=$precio_descuento_rubro_cuota;
					}
					//actualizo cliente-rubro: precio_unitario_rubro, precio_x_nro_items,subtotal estado 
					$sql = "update fac_clientes_rubros set PRECIO_UNITARIO_RUBRO=PRECIO_UNITARIO_RUBRO-".$precio_descuento_rubro;
					$sql.= ",PRECIO_X_NRO_ITEMS=PRECIO_X_NRO_ITEMS-".$precio_descuento_rubro;
					$sql.= ",SUBTOTAL=SUBTOTAL-".$precio_descuento_rubro;
					$sql.= ",DESCUENTO_BECA=".$porcentajeDescuento;
					$sql.=",ESTADO=0 where ID_CLIENTE_RUBRO=".$row['ID_CLIENTE_RUBRO'];
					$this->db->query($sql);
				}
			}
			//consulata si tiene cuotas generales
			$this->db->select("*");
			$this->db->from('fac_cuotas_generales');
			$this->db->where('ID_CLIENTE', $idCliente);
			$this->db->where('ID_PERIODO_ACADEMICO', $periodo);
			$query= $this->db->get();
			$ds_cuotas_generales = $query->row_array();
			if(count($ds_cuotas_generales)>0){
				//recalculo las cuotas generales
				$this->load->model('automatica/automatica_model');
				$this->automatica_model->calcular_y_actualizar_cuotas_generales($idCliente);
			}
		}//fin de if(count($ds_matricula)>0 and count($ds_rubro)<=0){
		$this->db->trans_complete();
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	public function historialCalificaciones($data)
	{
		$this->db->trans_start();
		//obtengo el id como persona
		$this->db->select('ID_PERSONA');
		$this->db->from('tab_clientes_naturales');
		$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
		$query = $this->db->get();
		$ds = $query->row_array();
		$id_persona = $ds['ID_PERSONA'];
		$respuesta="";
		$id_estudiante_carrera_materia = $data['ID_ESTUDIANTE_CARRERA_MATERIA'];
		unset($data['ID_ESTUDIANTE_CARRERA_MATERIA']);
		//asocio las nuevas materias de historial al estudiante
		if(isset($data['MATERIAS_HISTORIAL'])){
			$data_est_carr_mat=array();
			$data_est_carr_mat['ID_CARRERA']=$data['ID_CARRERA']; 
			$data_est_carr_mat['ID_PERSONA']=$id_persona;
			//$data_est_carr_mat['ID_PERIODO_ACADEMICO']=$data['ID_PERIODO_ACADEMICO'];
			$data_est_carr_mat['FUE_HISTORIAL']=1;
			$materias_historial = $data['MATERIAS_HISTORIAL'];
			unset($data['MATERIAS_HISTORIAL']);
			$notas_historial = $data['NOTAS_HISTORIAL'];
			unset($data['NOTAS_HISTORIAL']);			
			$periodos_historial = $data['PERIODO_HISTORIAL'];
			unset($data['PERIODO_HISTORIAL']);
			$persona_docente = $data['PERSONA_DOCENTE'];
			unset($data['PERSONA_DOCENTE']);
			//for($i=0; $i<count($materias_historial); $i++)
			foreach($materias_historial as $i=>$v){
				$data_est_carr_mat['ID_CARRERA_MATERIA']=$materias_historial[$i];
				$data_est_carr_mat['NOTA_HISTORIAL']=$notas_historial[$i];
				$data_est_carr_mat['ID_PERIODO_ACADEMICO']=$periodos_historial[$i];
				$data_est_carr_mat['ID_PERSONA_DOCENTE']=$persona_docente[$i];
				//busco los creditos de la materia y el precio
				$this->db->select('CREDITOS_MATERIA,PRECIO,NIVEL_MATERIA');
				$this->db->from('acad_carrera_materia');
				$this->db->where('ID_CARRERA_MATERIA', $materias_historial[$i]);
				$query = $this->db->get();
				$ds = $query->row_array();
				$data_est_carr_mat['CREDITOS_MATERIA'] = $ds['CREDITOS_MATERIA'];  
				$data_est_carr_mat['NIVEL_MATERIA']=$ds['NIVEL_MATERIA'];  //TODO: este valor es temporal
				//$data_est_carr_mat['PRECIO']=$ds['PRECIO']; 
				//$precio_total_convalidadas_homologadas+=$ds['PRECIO'];
				if(isset($id_estudiante_carrera_materia[$i]) and $id_estudiante_carrera_materia[$i]!=''){
					$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA', $id_estudiante_carrera_materia[$i]);
					$this->db->update('acad_estudiante_carrera_materia', $data_est_carr_mat);
				}else{
					//borro si es q fue asociada en la matricula, para q no esté repetida
					$this->borrar_materia_estudiante($id_persona,$data_est_carr_mat['NIVEL_MATERIA'],$data_est_carr_mat['ID_CARRERA'],NULL,$data_est_carr_mat['ID_CARRERA_MATERIA']);
					$this->db->insert('acad_estudiante_carrera_materia', $data_est_carr_mat);
				}
			} 
			$respuesta.="Historial Guardada<br>";           
		}
		//borrar materia historial si desmarcaron alguno
		foreach($id_estudiante_carrera_materia as $i=>$v){
			if($v!='' and !isset($materias_historial[$i])){
				$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA', $v);
				$this->db->delete('acad_estudiante_carrera_materia'); 
			}
		}	
		$this->db->trans_complete();
		return $respuesta;
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	public function get_materias_historial($id_cliente)
	{
		//$id_periodo=$this->get_periodo_activado();
		//obtengo el id como persona
		$this->db->select('ID_PERSONA');
		$this->db->from('tab_clientes_naturales');
		$this->db->where('ID_CLIENTE', $id_cliente);
		$query = $this->db->get();
		$ds = $query->row_array();
		$id_persona = $ds['ID_PERSONA'];
		
		$this->db->select('ID_CARRERA_MATERIA, NOTA_HISTORIAL, ID_PERIODO_ACADEMICO, ID_ESTUDIANTE_CARRERA_MATERIA, ID_PERSONA_DOCENTE');
		$this->db->from('acad_estudiante_carrera_materia');
		$this->db->where('ID_PERSONA', $id_persona);
		//$this->db->where('ID_PERIODO_ACADEMICO', $id_periodo);
		$this->db->where('FUE_HISTORIAL', 1);
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	public function getMateriasParaHistorial($id_carrera, $id_persona)
	{
		$sql ="select c.NOMBRE as NOMBRE_CARRERA, cm.PRECIO,m.NOMBRE,cm.ID_CARRERA_MATERIA,cm.NIVEL_MATERIA,cm.ID_CARRERA from acad_carrera c inner join acad_carrera_materia cm on c.ID_CARRERA = cm.ID_CARRERA ";
		$sql .=" inner join acad_materia m on m.ID_MATERIA = cm.ID_MATERIA ";
		$sql .=" where cm.ID_CARRERA_MATERIA not in (select ID_CARRERA_MATERIA from acad_estudiante_carrera_materia where ID_PERSONA=".$id_persona." and FUE_HISTORIAL=0)";
		if($id_carrera!=null)
			$sql .=" and c.ID_CARRERA=".$id_carrera;
		$sql .=" order by cm.ID_CARRERA, cm.NIVEL_MATERIA ASC";
		$query = $this->db->query($sql);
		$ds = $query->result_array();
		return $ds;            
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////////
	public function buscarEstudiantesMatriculadosAll($data)
	{
		$periodo= $this->get_periodo_activado();
		$datos=array();
		$this->db->select("DISTINCT(cli.NRO_DOCUMENTO) as CEDULA, p.ID_PERSONA,p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE,
m.FECHA as FECHA_INGRESO,cont.CORREO_ELECTRONICO, p.CORREO_INSTITUCIONAL as CORREO, cli.TIPO_DOCUMENTO as TIPO_DOC,
cont.telefono AS TELEFONO,cont.celular AS CELULAR,
CONCAT_WS(' ',cont.DIRECcION_CALLE_PRINCIPAL,cont.direccion_numero,cont.direccion_calle_secundaria1) As DIRECCION
,gen.GENERO,nacho.NACIONALIDAD AS NACIONALIDAD,p.FECHA_NACIMIENTO,prov.PROVINCIA, prov.CODIGO as COD_PRO, can.CANTON, can.CODIGO as COD_CAN,p.est_titulo_bachiller AS TITULO_BACHILLER,
p.est_colegio_graduacion AS COLEGIO,p.est_ano_graduacion as GRADUACION, pai.PAIS, pai.CODIGO as COD_PAIS, carr.NOMBRE as CARRERA,mo.MODALIDAD, m.ID_MODALIDAD, ase.sistema_estudio as SISTEMA,aae.AREA_ESTUDIO as AREA,p.ES_DISCAPACITADO,p.ES_DISCAPACITADO as DISCAPACIDAD,p.carnet_conadis AS CARNET,p.PORCENTAJE_DICAPACIDAD,tgc.GRUPO_CULTURAL AS ETNIA, CONCAT('Desde:',pacad.FECHA_INICIO,' Hasta:',pacad.FECHA_FIN) as PERIODO,m.ID_NIVEL, an.NIVEL, ec.ESTADO_CIVIL,p.TIPO_SANGRE,td.DISCAPACIDAD as TIPO_DISCAPACIDAD,td.ID_TIPO_DISCAPACIDAD, pai_n.PAIS as PAIS_NAC,pai_n.CODIGO as COD_PAIS_NAC,pro_n.PROVINCIA as PRO_NAC, pro_n.CODIGO as COD_PRO_NAC, can_n.CANTON as CAN_NAC, can_n.CODIGO as COD_CAN_NAC,pacad.FECHA_INICIO, r.RUBRO, m.ID_PERIODO_ACADEMICO, m.ID_CARRERA,pf.SUELDO_PROMEDIO, pf.NRO_HIJOS,tb.TIPO_BECA, tb.PORCENTAJE, m.NUMERO, p.EST_ID_TIPO_COLEGIO, tc.TIPO_COLEGIO, s.SEDE, g.NOMBRE as GRUPO, m.ID_BECA, cli.ID_CLIENTE",false);
		$this->db->from('acad_matricula m');
		$this->db->join('tab_personas p', 'p.id_PERSONA=m.id_PERSONA ','LEFT');
		$this->db->join('tab_clientes_naturales b', 'b.id_PERSONA= m.id_PERSONA','LEFT');
		$this->db->join('tab_clientes cli', 'cli.ID_CLIENTE=b.ID_CLIENTE','LEFT');
		$this->db->join('tab_nacionalidades nacho', 'nacho.ID_NACIONALIDAD = p.ID_NACIONALIDAD','LEFT');
		$this->db->join('tab_ocupaciones o', 'o.ID_OCUPACION = p.OCUPACION','LEFT');
		$this->db->join('acad_carrera carr', 'carr.ID_CARRERA=m.ID_CARRERA','LEFT');
		$this->db->join('acad_nivel an', 'an.ID_NIVEL=m.ID_NIVEL','LEFT');
		$this->db->join('acad_modalidad mo', 'mo.ID_MODALIDAD=m.id_MODALIDAD','LEFT');
		$this->db->join('tab_contactos cont', 'cont.id_CLIENTE=cli.id_cliente and cont.ESTADO=1','LEFT');
		$this->db->join('acad_periodo_academico pacad', 'pacad.ID_PERIODO_ACADEMICO=m.ID_PERIODO_ACADEMICO','LEFT');
		$this->db->join('tab_generos gen', 'gen.ABREVIATURA_GENERO = p.GENERO','LEFT');
		//$this->db->join('tab_provincias prov', 'prov.ID_PROVINCIA=p.ID_PROVINCIA_NACIMIENTO ','LEFT');
		$this->db->join('tab_provincias prov', 'prov.ID_PROVINCIA=cont.ID_PROVINCIA ','LEFT');
		//$this->db->join('tab_cantones can', 'can.ID_CANTON = p.ID_CANTON_NACIMIENTO ','LEFT');
		$this->db->join('tab_cantones can', 'can.ID_CANTON = cont.ID_CANTON ','LEFT');
		//$this->db->join('tab_paises pai', 'pai.ID_PAIS=p.EST_PAIS_GRADUACION','LEFT');
		$this->db->join('tab_paises pai', 'pai.ID_PAIS=cont.ID_PAIS','LEFT');
		$this->db->join('acad_area_estudio aae', 'aae.ID_AREA_ESTUDIO=carr.ID_AREA_ESTUDIO','LEFT');
		$this->db->join('acad_sistema_estudio ase', 'ase.ID_SISTEMA_ESTUDIO=carr.ID_SISTEMA_ESTUDIO','LEFT');
		$this->db->join('tab_grupos_culturales tgc', 'tgc.ID_GRUPO_CULTURAL =p.ID_GRUPO_CULTURAL ','LEFT');
		$this->db->join('tab_estados_civiles ec', 'ec.ID_ESTADO_CIVIL =p.ID_ESTADO_CIVIL ','LEFT');
		$this->db->join('tab_paises pai_n', 'pai_n.ID_PAIS=p.ID_PAIS_NACIMIENTO','LEFT');
		$this->db->join('tab_provincias pro_n', 'pro_n.ID_PROVINCIA=p.ID_PROVINCIA_NACIMIENTO','LEFT');
		$this->db->join('tab_cantones can_n', 'can_n.ID_CANTON=p.ID_CANTON_NACIMIENTO','LEFT');
		$this->db->join('fac_rubros r', 'r.ID_RUBRO=m.ID_RUBRO_OPCIONAL','LEFT');
		$this->db->join('tab_personas_financiero pf', 'pf.ID_PERSONA=m.ID_PERSONA','LEFT');
		//$this->db->join('tab_tipos_becas tb', 'tb.ID_TIPO_BECA=p.ID_TIPO_BECA','LEFT');
		$this->db->join('tab_tipos_becas tb', 'tb.ID_TIPO_BECA=m.ID_BECA','LEFT');
		$this->db->join('tab_tipos_discapacidad td', 'td.ID_TIPO_DISCAPACIDAD=p.TIPO_DISCAPACIDAD','LEFT');
		$this->db->join('tab_tipos_colegio tc', 'tc.ID_TIPO_COLEGIO=p.EST_ID_TIPO_COLEGIO','LEFT');
		$this->db->join('acad_grupo g', 'g.ID_GRUPO=m.ID_GRUPO','LEFT');
		$this->db->join('acad_sede s', 's.ID_SEDE=g.ID_SEDE','LEFT');
		//$this->db->where('o.ID_OCUPACION',1);
		$this->db->where('cont.ID_TIPO_CONTACTO',2);
		$this->db->where('m.ESTADO<>',1);//filtrar matriculas anuladas		
		if(isset($data['ID_PERIODO_ACADEMICO']) and $data['ID_PERIODO_ACADEMICO']!=NULL){
		   $this->db->where('m.ID_PERIODO_ACADEMICO',$data['ID_PERIODO_ACADEMICO']);
		}else{
		   $this->db->where('m.ID_PERIODO_ACADEMICO',$periodo);
		}
		if(isset($data['ID_CARRERA']) and $data['ID_CARRERA']>0){
		   $this->db->where('m.ID_CARRERA',$data['ID_CARRERA']);
		}
		if(isset($data['ID_NIVEL']) and $data['ID_NIVEL']>0){
		   $this->db->where('m.ID_NIVEL',$data['ID_NIVEL']);
		}
		if(isset($data['ID_MATRICULA']) and $data['ID_MATRICULA']>0){
		   $this->db->where('m.ID_MATRICULA',$data['ID_MATRICULA']);
		}
		if(isset($data['GRUPO']) and $data['GRUPO']!=NULL and $data['GRUPO']>0){
			$this->db->where('g.NOMBRE',$data['GRUPO']);
		}
		$this->db->order_by("APELLIDO_PATERNO","asc");
		$query= $this->db->get();
	   // $query = $this->db->query($sql);
		$ds= $query->result_array(); 
		//verificar datos Adicionales
		foreach($ds as $k=>$v){
			$sql=" select ID_CALIFICACION";
			$sql.=" from acad_calificacion";
			$sql.=" where ID_ESTUDIANTE_CARRERA_MATERIA ";
			$sql.=" in(select ID_ESTUDIANTE_CARRERA_MATERIA from acad_estudiante_carrera_materia where ID_PERSONA=".$v['ID_PERSONA']." and ID_CARRERA=".$v['ID_CARRERA'].")";
			$sql.=" and ID_TIPO_CALIFICACION=6 and ESTADO_CALIFICACION=2";
			$query = $this->db->query($sql);
			$ds1 = $query->result_array();
			if(count($ds1)>0){
				$ds[$k]['HA_PERDIDO']='Si';
			}else{
				$ds[$k]['HA_PERDIDO']='No';
			}
			
			$sql=" select *";
			$sql.=" from vin_evaluacion_practica_vinculacion";
			$sql.=" where ID_PERSONA=".$v['ID_PERSONA']." and ID_CARRERA=".$v['ID_CARRERA'];
			$sql.=" and TIPO=1 and ESTADO=4 and ID_PERIODO_ACADEMICO=".$v['ID_PERIODO_ACADEMICO'];//practicas Aprobado realidas en el periodo
			$query = $this->db->query($sql);
			$ds2 = $query->result_array();
			if(count($ds2)>0){
				$ds[$k]['TIENE_PRACTICAS']='Si';
				$ds[$k]['HORAS_PRACTICAS']=$ds2[0]['NUM_HORAS'];
				if($ds2[0]['NUM_HORAS']<100){
					$ds[$k]['HORAS_PRACTICAS']=240;
				}
				$ds[$k]['TIPO_EMPRESA_PRACTICAS']=$ds2[0]['TIPO_EMPRESA'];
			}else{
				$ds[$k]['TIENE_PRACTICAS']='No';
				$ds[$k]['HORAS_PRACTICAS']=0;
				$ds[$k]['TIPO_EMPRESA_PRACTICAS']='';
			}
			
			$ds[$k]['VALOR_BECA']=0;
			if($v['ID_BECA']>0){
				$sql=" select *";
				$sql.=" from fac_clientes_rubros";
				$sql.=" where ID_CLIENTE=".$v['ID_CLIENTE']." and ID_CARRERA=".$v['ID_CARRERA']." and PERIODO_VIGENTE=".$v['ID_PERIODO_ACADEMICO'];
				$sql.=" and ID_RUBRO=17 ";//valor de pension
				$query = $this->db->query($sql);
				$ds3 = $query->row_array();
				if($ds3!=NULL){
					$ds[$k]['VALOR_BECA']=round(($ds3['PRECIO_X_NRO_ITEMS']*($v['PORCENTAJE']/100)));
				}
			}
			
			$sql=" select *";
			$sql.=" from vin_evaluacion_practica_vinculacion";
			$sql.=" where ID_PERSONA=".$v['ID_PERSONA']." and ID_CARRERA=".$v['ID_CARRERA'];
			$sql.=" and TIPO=2 and ESTADO=4 and ID_PERIODO_ACADEMICO=".$v['ID_PERIODO_ACADEMICO'];//servicio a la comunidad Aprobado realidas en el periodo
			$query = $this->db->query($sql);
			$ds4 = $query->result_array();
			if(count($ds4)>0){
				$ds[$k]['TIENE_VINCULACION']='Si';
			}else{
				$ds[$k]['TIENE_VINCULACION']='No';
			}
			
			
			/*$sql=" select s.SEDE, g.NOMBRE";
			$sql.=" from acad_grupo g";
			$sql.=" join acad_sede s on s.ID_SEDE=g.ID_SEDE";
			$sql.=" where g.ID_GRUPO";
			$sql.=" in(select ID_GRUPO from acad_estudiante_carrera_materia where ID_PERSONA=".$v['ID_PERSONA']." and ID_PERIODO_ACADEMICO=".$v['ID_PERIODO_ACADEMICO']." and NIVEL_MATERIA=".$v['ID_NIVEL']." and ID_GRUPO IS NOT NULL)";
			$query = $this->db->query($sql);
			$ds2 = $query->row_array();
			$ds[$k]['GRUPO']=$ds2['NOMBRE'];
			$ds[$k]['SEDE']=$ds2['SEDE'];*/
			//filtrar si selecciono un grupo especifico
			/*if(isset($data['GRUPO']) and $data['GRUPO']!=NULL and $data['GRUPO']!=$ds2['NOMBRE'] and $data['GRUPO']>0){
				unset($ds[$k]);
			}*/
		}
		$datos['estudiantes']=$ds;
		return $datos;
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//materias que ha tomado en periodos difenentes a la matricula actual
	public function get_materias_periodos($id_cliente,$id_periodo)
	{
		$this->db->trans_start();
		$datos=array();
		//obtengo el id como persona
		$this->db->select('ID_PERSONA');
		$this->db->from('tab_clientes_naturales');
		$this->db->where('ID_CLIENTE', $id_cliente);
		$query = $this->db->get();
		$ds = $query->row_array();
		$id_persona = $ds['ID_PERSONA'];

		$this->db->select('ecm.ID_CARRERA_MATERIA, ecm.NOTA_HISTORIAL');
		$this->db->from('acad_estudiante_carrera_materia ecm');
		$this->db->join('acad_calificacion c','c.ID_ESTUDIANTE_CARRERA_MATERIA=ecm.ID_ESTUDIANTE_CARRERA_MATERIA');
		$this->db->where('ecm.ID_PERSONA', $id_persona);
		//$this->db->where('ecm.ID_PERIODO_ACADEMICO<>', $id_periodo);
		$this->db->where('c.ID_TIPO_CALIFICACION', 6);
		$this->db->where('c.ETAPA', 0);
		$this->db->where('c.ESTADO_CALIFICACION', 1);//solo materias aprobadas
		$query = $this->db->get();
		$ds = $query->result_array();
		$this->db->trans_complete();
		return $ds;
	}	
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	public function num_materias_perdidas($id_persona, $id_periodo)
	{
		$this->db->select('ecm.ID_CARRERA_MATERIA, ecm.NOTA_HISTORIAL');
		$this->db->from('acad_estudiante_carrera_materia ecm');
		$this->db->join('acad_calificacion c','c.ID_ESTUDIANTE_CARRERA_MATERIA=ecm.ID_ESTUDIANTE_CARRERA_MATERIA');
		$this->db->where('ecm.ID_PERSONA', $id_persona);
		$this->db->where('ecm.ID_PERIODO_ACADEMICO', $id_periodo);
		$this->db->where('c.ID_TIPO_CALIFICACION', 6);
		$this->db->where('c.ETAPA', 0);
		$this->db->where('c.ESTADO_CALIFICACION', 2);//solo materias perdidas
		$query = $this->db->get();
		$ds = $query->result_array();
		return count($ds);
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//materias que tienen prerequisito sin aprobar
	public function get_materias_prerequisito_sin_aprobar($id_cliente,$id_carrera)
	{
		//obtengo el id como persona
		$this->db->select('ID_PERSONA');
		$this->db->from('tab_clientes_naturales');
		$this->db->where('ID_CLIENTE', $id_cliente);
		$query = $this->db->get();
		$ds = $query->row_array();
		$id_persona = $ds['ID_PERSONA'];		
		//obtener las materias de la carrera
		$materias_carrera = $this->getMateriasPorCarrera($id_carrera);
		$ds=array();
		foreach($materias_carrera as $materia_carrera){
			$prerequisitos_materia = $this->getMateriasPrerequisito($materia_carrera['ID_CARRERA_MATERIA']);
			foreach($prerequisitos_materia as $prerequisito_materia){
				if($this->materiaAprobada($prerequisito_materia['ID_CARRERA_MATERIA_PREREQUISITO'],$id_persona)==false){
					$ds[]=$materia_carrera['ID_CARRERA_MATERIA'];
				}
			}
		}
		return $ds;
	}	
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	public function getMateriasPrerequisito($id_carrera_materia)
	{
		$this->db->select('*');
		$this->db->from('acad_prerequisito');
		$this->db->where('ID_CARRERA_MATERIA', $id_carrera_materia);
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	public function materiaAprobada($id_carrera_materia,$id_persona)
	{
		$this->db->select('ecm.ID_CARRERA_MATERIA');
		$this->db->from('acad_estudiante_carrera_materia ecm');
		$this->db->join('acad_calificacion c','c.ID_ESTUDIANTE_CARRERA_MATERIA=ecm.ID_ESTUDIANTE_CARRERA_MATERIA');
		$this->db->where('ecm.ID_PERSONA', $id_persona);
		$this->db->where('ecm.ID_CARRERA_MATERIA', $id_carrera_materia);
		$this->db->where('c.ID_TIPO_CALIFICACION', 6);
		$this->db->where('c.ETAPA', 0);
		$this->db->where('c.ESTADO_CALIFICACION', 1);//solo materia aprobada
		$query = $this->db->get();
		$ds = $query->result_array();		
		if(count($ds)<=0){//comprobar si se aprobo por convalidacion, homologacion o historial
			$this->db->select('ID_CARRERA_MATERIA');
			$this->db->from('acad_estudiante_carrera_materia');
			$this->db->where('ID_PERSONA', $id_persona);
			$this->db->where('ID_CARRERA_MATERIA', $id_carrera_materia);
			$this->db->where('(FUE_CONVALIDADA=1 or FUE_HOMOLOGADA=1 or FUE_HISTORIAL=1)');
			$query = $this->db->get();
			$ds = $query->result_array();
		}
		if(count($ds)>0){
			return true;
		}else{
			return false;
		}
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////
	public function verificar_usuario_funcionalidad($idusuario, $idfuncionalidad)
	{
		//Verificar si el usuario tiene autorizacion para realizar una funcion especifica
		$this->db->select('pmf.id_peril_modulo_funcionalidad');
		$this->db->from('admin_perfil_modulo_funcionalidad pmf');
		$this->db->join('admin_usuario_perfil up','up.id_perfil=pmf.id_perfil');
		$this->db->where('pmf.id_funcionalidad',$idfuncionalidad);
		$this->db->where('up.id_usuario',$idusuario);
		$query = $this->db->get();
		$ds1 = $query->row_array();
		if(count($ds1)>0){
			return true;
		}else{
			return false;
		}
	}
	
	/////////////////////////////////////////////////////////////////////////////
	public function get_num_alumnos_materias_asignadas_al_docente($id_persona,$id_materia)
	{
		$periodo= $this->get_periodo_activado();
		$this->db->select('count(ID_ESTUDIANTE_CARRERA_MATERIA) as num_alumnos');
		$this->db->from('acad_estudiante_carrera_materia');
		$this->db->where('ID_CARRERA_MATERIA', $id_materia);
		$this->db->where('ID_PERSONA_DOCENTE', $id_persona);
		$this->db->where('ID_PERIODO_ACADEMICO', $periodo);
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds['num_alumnos'];
	}
	
	////////////////////////////////////////////////////////////////////////////////////
	public function getDocentesDeMateria($id_carrera_materia)
	{
		$id_periodo=$this->get_periodo_activado();
		$sql=" select CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE,p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as DOCENTE, dcm.ID_PERSONA,dcm.ID_DOCENTE_CARRERA_MATERIA, c.NRO_DOCUMENTO, u.ESTADO";
		$sql.=" from acad_docente_carrera_materia dcm";
		$sql.=" join tab_personas p on p.ID_PERSONA=dcm.ID_PERSONA";
		$sql.=" join tab_clientes_naturales cn on cn.ID_PERSONA=dcm.ID_PERSONA";
		$sql.=" join tab_clientes c on c.ID_CLIENTE=cn.ID_CLIENTE";
		$sql.=" left join admin_usuarios u on u.ID_PERSONA=dcm.ID_PERSONA";
		$sql.=" where dcm.ID_CARRERA_MATERIA=".$id_carrera_materia;
		$sql.=" and dcm.ID_PERIODO_ACADEMICO=".$id_periodo;
		$sql.=" group by DOCENTE";
		$query = $this->db->query($sql);
		$ds = $query->result_array();
		return $ds;
	}
	
	////////////////////////////////////////////////////////////////////////////////////
	public function reasignarDocente($id_nuevo_docente,$id_antiguo_docente,$id_carrera_materia,$id_grupo)
	{
		$id_periodo=$this->get_periodo_activado();
		$sql=" update acad_estudiante_carrera_materia";
		$sql.=" set ID_PERSONA_DOCENTE=".$id_nuevo_docente;
		$sql.=" where ID_CARRERA_MATERIA=".$id_carrera_materia;
		$sql.=" and ID_PERIODO_ACADEMICO=".$id_periodo;
		if($id_antiguo_docente>0){
			$sql.=" and ID_PERSONA_DOCENTE=".$id_antiguo_docente;
		}
		if($id_grupo>0){
			$sql.=" and ID_GRUPO=".$id_grupo;
		}
		$query = $this->db->query($sql);
		return $this->db->affected_rows();
	}
	
	/////////////////////////////////////////////////////////////////////////////////
	public function buscar_sedes($ids_sedes=null)
	{
		$this->db->select('*');
		$this->db->from('acad_sede');
		if($ids_sedes!=null){
			$this->db->where_in('ID_SEDE',$ids_sedes);
		}
		$this->db->order_by('SEDE','ASC');
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	/////////////////////////////////////////////////////////////////////////////////
	public function buscar_grupos_estudiantes($grupo=null)
	{
		$this->db->select('DISTINCT(g.NOMBRE), g.ID_SEDE, s.SEDE');
		$this->db->from('acad_grupo g');
		$this->db->join('acad_sede s','s.ID_SEDE=g.ID_SEDE');
		if($grupo!=null){
			$this->db->where('g.NOMBRE',$grupo);
		}
		$this->db->order_by('s.SEDE','ASC');
		$this->db->order_by('g.NOMBRE','ASC');
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	/////////////////////////////////////////////////////////////////////
	public function get_grupo_sede_asignado($id_cliente, $id_carrera, $id_periodo, $id_nivel)
	{
		//obtengo el id como persona
		$this->db->select('ID_PERSONA');
		$this->db->from('tab_clientes_naturales');
		$this->db->where('ID_CLIENTE', $id_cliente);
		$query = $this->db->get();
		$ds = $query->row_array();
		$id_persona = $ds['ID_PERSONA'];
		
		$this->db->select('acad_grupo.NOMBRE,acad_grupo.ID_SEDE, acad_grupo.ID_GRUPO');
		$this->db->from('acad_matricula');
		$this->db->join('acad_grupo', 'acad_grupo.ID_GRUPO = acad_matricula.ID_GRUPO');
		$this->db->where('acad_matricula.ID_PERSONA', $id_persona);
		$this->db->where('acad_matricula.ID_CARRERA', $id_carrera);
		$this->db->where('acad_matricula.ID_PERIODO_ACADEMICO', $id_periodo);
		$this->db->where('acad_matricula.ID_NIVEL', $id_nivel);
		$this->db->limit(1);
		$query = $this->db->get();
		$ds = $query->row_array();
		
		if($ds==NULL){
			$this->db->select('acad_grupo.NOMBRE,acad_grupo.ID_SEDE, acad_grupo.ID_GRUPO');
			$this->db->from('acad_estudiante_carrera_materia');
			$this->db->join('acad_grupo', 'acad_grupo.ID_GRUPO = acad_estudiante_carrera_materia.ID_GRUPO');
			$this->db->where('acad_estudiante_carrera_materia.ID_PERSONA', $id_persona);
			$this->db->where('acad_estudiante_carrera_materia.ID_CARRERA', $id_carrera);
			$this->db->where('acad_estudiante_carrera_materia.ID_PERIODO_ACADEMICO', $id_periodo);
			$this->db->where('acad_estudiante_carrera_materia.NIVEL_MATERIA', $id_nivel);
			$this->db->limit(1);
			$query = $this->db->get();
			$ds = $query->row_array();
		}
		return $ds;
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////
	public function actualizarMatriculaAcademico($data)
	{
		$periodo=$this->get_periodo_activado();
		$this->db->trans_start();
		//obtengo el id como persona
		$this->db->select('ID_PERSONA');
		$this->db->from('tab_clientes_naturales');
		$this->db->where('ID_CLIENTE', $data['ID_CLIENTE']);
		$query = $this->db->get();
		$ds = $query->row_array();
		$id_persona = $ds['ID_PERSONA'];
		//obtengo el grupo al que será asignado
		$this->db->select('ID_GRUPO');
		$this->db->from('acad_grupo');
		$this->db->where('NOMBRE', $data['GRUPO_ASIGNADO']);
		$this->db->where('ID_CARRERA', $data['ID_CARRERA']);
		$this->db->where('ID_NIVEL', $data['ID_NIVEL']);
		$this->db->where('ID_SEDE', $data['ID_SEDE_GRUPO']);
		$query = $this->db->get();
		$ds = $query->row_array();
		$id_grupo_a_asignar=$ds['ID_GRUPO'];
		$data['ID_GRUPO']=$id_grupo_a_asignar;
		$nombre_grupo=$data['GRUPO_ASIGNADO'];
		unset($data['GRUPO_ASIGNADO']);
		//ubico el grupo anterior para el caso de que va actualizar
			/*$this->db->select('ID_GRUPO');
			$this->db->from('tab_personas');
			$this->db->where('ID_PERSONA', $id_persona);
			$query = $this->db->get();
			$ds_grupo = $query->row_array();
			$id_grupo_antiguo=$ds_grupo['ID_GRUPO'];*/
		
		$ds_grupo=$this->get_grupo_sede_asignado($data['ID_CLIENTE'], $data['ID_CARRERA'], $periodo, $data['ID_NIVEL']);
		$id_grupo_antiguo=0;
		if($ds_grupo!=NULL){
			$id_grupo_antiguo=$ds_grupo['ID_GRUPO'];
		}
		//le asigno el grupo a la persona, y el nivel
		$data_grupo_persona = array();
		$data_grupo_persona['ID_GRUPO']=$id_grupo_a_asignar;
		$data_grupo_persona['NIVEL']=$data['ID_NIVEL'];
		$this->db->where('ID_PERSONA', $id_persona);
		$this->db->update('tab_personas', $data_grupo_persona);
		//asocio las nuevas materias asignadas al estudiante
		$precio_total_por_materias=0;
		$cantidad_de_arrastres=0;
		$id_materias_asignadas=array();
		$ids_materias_estudiante_actualiza=array();
		$ids_materias_estudiante_crea=array();
		$ids_materias_estudiante_borra=array();
		if(isset($data['MATERIAS_ASIGNADAS'])){
			$data_est_carr_mat=array();
			$data_est_carr_mat['ID_CARRERA']=$data['ID_CARRERA']; 
			$data_est_carr_mat['ID_PERSONA']=$id_persona;
			$data_est_carr_mat['ID_PERIODO_ACADEMICO']=$data['ID_PERIODO_ACADEMICO'];
			$data_est_carr_mat['ID_GRUPO']=$id_grupo_a_asignar;
			$materias_asignadas = $data['MATERIAS_ASIGNADAS'];
			$grupos_asignados=$data['GRUPO'];
			if(isset($data['ES_ARRASTRE'])){
				$arrastres = $data['ES_ARRASTRE']; //arreglo con los id de los materias q arrastra
				$cantidad_de_arrastres=count($arrastres);
			}
			$docentes_asignados =  $data['DOCENTES_ASIGNADOS'];
			/*unset($data['MATERIAS_ASIGNADAS']);
			unset($data['DOCENTES_ASIGNADOS']);
			unset($data['ES_ARRASTRE']);*/
			//for($i=0; $i<count($materias_asignadas); $i++)
			foreach($materias_asignadas as $i=>$materia_asignada){
				$data_est_carr_mat['ID_PERSONA_DOCENTE']=$docentes_asignados[$i];
				$data_est_carr_mat['ES_ARRASTRE']=0;
				$data_est_carr_mat['ID_CARRERA_MATERIA']=$materias_asignadas[$i];
				$data_est_carr_mat['ID_GRUPO']=$id_grupo_a_asignar;
				//verifico si será asociada como arrastre
				if(isset($arrastres)){
					if(in_array($materias_asignadas[$i], $arrastres)){
						$data_est_carr_mat['ES_ARRASTRE']=1;
					}
				}
				//verificar si es actualizacion de materia asignada
				$this->db->select('*');
				$this->db->from('acad_estudiante_carrera_materia');
				$this->db->where('ID_PERSONA', $id_persona);
				$this->db->where('ID_PERIODO_ACADEMICO', $data['ID_PERIODO_ACADEMICO']);
				$this->db->where('ID_CARRERA_MATERIA', $materias_asignadas[$i]);
				$query = $this->db->get();
				$materia = $query->row_array();
				if($materia!=NULL){//actualizacion de materia asignada
					
					//ingreso de grupo por materia
					//if($grupos_asignados[$i]!=$nombre_grupo){
						$this->db->select('ID_GRUPO');
						$this->db->from('acad_grupo');
						$this->db->where('NOMBRE', $grupos_asignados[$i]);
						$this->db->where('ID_CARRERA', $data['ID_CARRERA']);
						$this->db->where('ID_NIVEL', $materia['NIVEL_MATERIA']);
						//$this->db->where('ID_SEDE', $data['ID_SEDE_GRUPO']);
						$query = $this->db->get();
						$ds_g= $query->row_array();
						if($ds_g!=NULL){
							$data_est_carr_mat['ID_GRUPO']=$ds_g['ID_GRUPO'];
						}else{
							$data_est_carr_mat['ID_GRUPO']=$id_grupo_a_asignar;
						}
					//}else{
						//$data_est_carr_mat['ID_GRUPO']=$id_grupo_a_asignar;
					//}
					
					unset($data_est_carr_mat['CREDITOS_MATERIA']);
					unset($data_est_carr_mat['NIVEL_MATERIA']);
					unset($data_est_carr_mat['PRECIO']);
					$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA', $materia['ID_ESTUDIANTE_CARRERA_MATERIA']);
					$this->db->update('acad_estudiante_carrera_materia', $data_est_carr_mat);
					if($this->db->affected_rows()>0){
						$ids_materias_estudiante_actualiza[]=$materia['ID_ESTUDIANTE_CARRERA_MATERIA'];
					}
					$id_materia_asignada=$materia['ID_ESTUDIANTE_CARRERA_MATERIA'];
				}else{//agregar nueva materia asignada
					//busco los creditos de la materia,el precio y el nivel
					$this->db->select('CREDITOS_MATERIA,PRECIO,NIVEL_MATERIA');
					$this->db->from('acad_carrera_materia');
					$this->db->where('ID_CARRERA_MATERIA', $materias_asignadas[$i]);
					$query = $this->db->get();
					$ds = $query->row_array();
					$data_est_carr_mat['CREDITOS_MATERIA'] = $ds['CREDITOS_MATERIA']; 
					$data_est_carr_mat['NIVEL_MATERIA']= $ds['NIVEL_MATERIA']; 
					$data_est_carr_mat['PRECIO']=$ds['PRECIO'];
					
					//ingreso de grupo por materia
					//if($grupos_asignados[$i]!=$nombre_grupo){
						$this->db->select('ID_GRUPO');
						$this->db->from('acad_grupo');
						$this->db->where('NOMBRE', $grupos_asignados[$i]);
						$this->db->where('ID_CARRERA', $data['ID_CARRERA']);
						$this->db->where('ID_NIVEL', $ds['NIVEL_MATERIA']);
						//$this->db->where('ID_SEDE', $data['ID_SEDE_GRUPO']);
						$query = $this->db->get();
						$ds_g= $query->row_array();
						if($ds_g!=NULL){
							$data_est_carr_mat['ID_GRUPO']=$ds_g['ID_GRUPO'];
						}else{
							$data_est_carr_mat['ID_GRUPO']=$id_grupo_a_asignar;
						}
					//}else{
						//$data_est_carr_mat['ID_GRUPO']=$id_grupo_a_asignar;
					//}
					
					$this->db->insert('acad_estudiante_carrera_materia', $data_est_carr_mat);
					$id_materia_asignada=$this->db->insert_id();
					$ids_materias_estudiante_crea[]=$id_materia_asignada;
				}
				$id_materias_asignadas[]=$id_materia_asignada;
			}//fin de for($i=0; $i<count($materias_asignadas); $i++)          
		}//fin de if(isset($data['MATERIAS_ASIGNADAS']))
		//elimino las materias que tiene asignada el estudiante y que ya no fueron seleccionadas, q no hayan sido conv u homo
		$aprobadas = $this->get_materias_periodos($data['ID_CLIENTE'],$data['ID_PERIODO_ACADEMICO']);
		$materias_aprobadas=array();
		foreach($aprobadas as $ma){
			$materias_aprobadas[]=$ma['ID_CARRERA_MATERIA'];
		}
		$this->db->select('*');
		$this->db->from('acad_estudiante_carrera_materia');
		$this->db->where('ID_PERSONA', $id_persona);
		$this->db->where('ID_PERIODO_ACADEMICO', $data['ID_PERIODO_ACADEMICO'] );
		$this->db->where('ID_CARRERA', $data['ID_CARRERA'] );
		$this->db->where('FUE_CONVALIDADA !=', 1);
		$this->db->where('FUE_HOMOLOGADA !=', 1);
		$this->db->where('FUE_HISTORIAL !=', 1);
		if(count($id_materias_asignadas)>0){
			$this->db->where_not_in('ID_ESTUDIANTE_CARRERA_MATERIA', $id_materias_asignadas );
		}
		if(count($materias_aprobadas)>0){
			$this->db->where_not_in('ID_CARRERA_MATERIA', $materias_aprobadas );
		}
		$query = $this->db->get();
		$materias_borrar = $query->result_array();
		foreach($materias_borrar as $materia_borrar){
			//borrar calificaciones
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA', $materia_borrar['ID_ESTUDIANTE_CARRERA_MATERIA']);
			$this->db->delete('acad_calificacion'); 
			//borrar materia asignada
			$this->load->module('academico');
			$this->academico->sendMateriaVlc($materia_borrar['ID_ESTUDIANTE_CARRERA_MATERIA'],'borrar');
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA', $materia_borrar['ID_ESTUDIANTE_CARRERA_MATERIA']);
			$this->db->delete('acad_estudiante_carrera_materia');
			$ids_materias_estudiante_borra[]=$materia_borrar['ID_ESTUDIANTE_CARRERA_MATERIA'];
		}
		//verifico si se trata de una nueva matricula en el periodo actual o actualizacion de matricula
		$this->db->select('ID_MATRICULA');
		$this->db->from('acad_matricula');
		$this->db->where('ID_MATRICULA', $data['ID_MATRICULA']);
		$this->db->where('ID_PERIODO_ACADEMICO', $data['ID_PERIODO_ACADEMICO']); 
		$query_mat = $this->db->get();
		$ds_mat = $query_mat->row_array();
		//if (isset($data['ID_MATRICULA']) && $data['ID_MATRICULA'] != NULL) 
		if(isset($ds_mat['ID_MATRICULA']) && $ds_mat['ID_MATRICULA'] != NULL){
			//actualizo 
			$data['ID_PERSONA']=$id_persona;
			$data['FECHA_MODIFICACION']= date("Y-m-d H:i:s");
			$data['ID_USUARIO_ACTUALIZA']= $this->session->userdata('loggeado')['ID_USUARIO'];
			//comprobar cambio de grupo
			if($id_grupo_antiguo!=$id_grupo_a_asignar){
				//crear numero de matricula
				$sql="select max(SUBSTRING(NUMERO,-4,4)) as secuencial from acad_matricula where NUMERO like '".$nombre_grupo."0%' and ID_PERIODO_ACADEMICO=".$data['ID_PERIODO_ACADEMICO'];
				$query_num =$this->db->query($sql);
				$ds_num = $query_num->row_array();
				if($ds_num['secuencial']>0){
					$numero=$nombre_grupo.sprintf("%'.04d",$ds_num['secuencial']+1);
				}else{
					$numero=$nombre_grupo.'0001';
				}
				$data['NUMERO']=$numero;
			}
			unset($data['NOMBRES']);
			unset($data['APELLIDOS']);
			unset($data['COLEGIO']);
			unset($data['TITULO']);
			unset($data['ID_CLIENTE']);
			unset($data['PRECIO']);
			unset($data['ID_SEDE_GRUPO']);
			unset($data['GRUPO']);
			unset($data['MATERIAS_ASIGNADAS']);
			unset($data['DOCENTES_ASIGNADOS']);
			unset($data['ES_ARRASTRE']);
			$data['OBSERVACIONES']=trim($data['OBSERVACIONES']);
			$this->db->where('acad_matricula.ID_MATRICULA', $data['ID_MATRICULA']);
			$this->db->update('acad_matricula', $data);
			$resultado="Matricula Actualizada";
		}
		$this->db->trans_complete();
		//return $resultado;
		return array('resultado'=>$resultado,'ids_materias_estudiante_actualiza'=>$ids_materias_estudiante_actualiza,'ids_materias_estudiante_crea'=>$ids_materias_estudiante_crea,'ids_materias_estudiante_borra'=>$ids_materias_estudiante_borra);
	}
	
	////////////////////////////////////////
	public function get_Modalidad($id_modalidad)
	{
		$this->db->select('*');
		$this->db->from('acad_modalidad');
		$this->db->where('ID_MODALIDAD', $id_modalidad);
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds;
	}
	
	/////////////////////////////////////////////////////////////////
	public function guardar_opciones_pago($data)
	{
		$this->db->insert('tab_opciones_pago', $data);
		return $this->db->insert_id();
	}
	
	/////////////////////////////////////////////////////////////////
	public function get_opciones_pago($id_opcion_pago)
	{
		$this->db->select('*');
		$this->db->from('tab_opciones_pago');
		$this->db->where('ID_OPCION_PAGO', $id_opcion_pago);
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds;
	}
	
	/////////////////////////////////////////////////////////////////
	public function actualizar_opciones_pago($data,$id_opcion_pago)
	{
		$this->db->where('ID_OPCION_PAGO', $id_opcion_pago);
		$this->db->update('tab_opciones_pago', $data);
	}
	
	////////////////////////////////////////
	public function get_abono_matricula_actual($id_cliente,$id_periodo_actual,$id_matricula=null)
	{
		$this->db->select('SUM(TOTAL_PAGADO) as PAGADO');
		$this->db->from('fac_cuotas_generales');
		$this->db->where('ID_CLIENTE', $id_cliente);
		$this->db->where('ID_PERIODO_ACADEMICO', $id_periodo_actual);
		if($id_matricula!=null and $id_matricula>0){
			$this->db->where('ID_MATRICULA', $id_matricula);
		}
		$query = $this->db->get();
		$ds = $query->row_array();
		if($ds['PAGADO']>0){
			return $ds['PAGADO'];
		}else{
			return 0;
		}
	}
	
	////////////////////////////////////////
	public function crearCambioCarrera($data)
	{
		$this->db->insert('acad_cambio_carrera', $data);
		return $this->db->insert_id();
	}
	
	////////////////////////////////////////
	public function get_cambio_carrera($data)
	{
		$this->db->select('*');
		$this->db->from('acad_cambio_carrera');
		if(isset($data['ID_PERSONA']) and $data['ID_PERSONA']!=NULL){
			$this->db->where('ID_PERSONA', $data['ID_PERSONA']);
		}
		if(isset($data['ID_PERIODO']) and $data['ID_PERIODO']!=NULL){
			$this->db->where('ID_PERIODO_ACADEMICO', $data['ID_PERIODO']);
		}
		if(isset($data['ID_CAMBIO_CARRERA']) and $data['ID_CAMBIO_CARRERA']!=NULL){
			$this->db->where('ID_CAMBIO_CARRERA', $data['ID_CAMBIO_CARRERA']);
		}
		if(isset($data['ID_CARRERA_ANTERIOR']) and $data['ID_CARRERA_ANTERIOR']!=NULL){
			$this->db->where('ID_CARRERA_ANTERIOR', $data['ID_CARRERA_ANTERIOR']);
		}
		if(isset($data['ID_CARRERA_NUEVO']) and $data['ID_CARRERA_NUEVO']!=NULL){
			$this->db->where('ID_CARRERA_NUEVO', $data['ID_CARRERA_NUEVO']);
		}
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	////////////////////////////////////////
	public function cambioCarrera($id_cliente,$id_carrera,$id_periodo)
	{
		$this->db->select('*');
		$this->db->from('tab_clientes_naturales');
		$this->db->where('ID_CLIENTE', $id_cliente);
		$query = $this->db->get();
		$ds = $query->row_array();
		$id_persona=$ds['ID_PERSONA'];	
		$query_borra_calificaciones = $this->db->query("delete from acad_calificacion where ID_ESTUDIANTE_CARRERA_MATERIA in (select ID_ESTUDIANTE_CARRERA_MATERIA from acad_estudiante_carrera_materia where ID_PERSONA=".$id_persona." and ID_PERIODO_ACADEMICO=".$id_periodo." and ID_CARRERA=".$id_carrera.")");
		$query_borra_materias = $this->db->query("delete from acad_estudiante_carrera_materia where ID_PERSONA=".$id_persona." and ID_PERIODO_ACADEMICO=".$id_periodo." and ID_CARRERA=".$id_carrera);
		$query_borra_pago_cuotas = $this->db->query("delete from fac_cuotas_generales where ID_CLIENTE=".$id_cliente." and ID_PERIODO_ACADEMICO=".$id_periodo." and ID_MATRICULA in (select ID_MATRICULA from acad_matricula where ID_PERSONA=".$id_persona." and ID_CARRERA=".$id_carrera." and ID_PERIODO_ACADEMICO=".$id_periodo.")");		
		$query_actualiza_rubros_cliente = $this->db->query("update fac_clientes_rubros set SELECCIONADO_PLAN_PAGO=0 where ID_CLIENTE=".$id_cliente." and 	PERIODO_VIGENTE=".$id_periodo." and ID_CARRERA=".$id_carrera);		
		$query_borra_matricula = $this->db->query("delete from acad_matricula where ID_PERSONA=".$id_persona." and ID_CARRERA=".$id_carrera." and ID_PERIODO_ACADEMICO=".$id_periodo);	
		if($query_borra_matricula and $query_borra_calificaciones and $query_borra_materias and $query_borra_pago_cuotas){
			$respuesta="CAMBIADO";
		}else{
			$respuesta="Fallo cambio de carrera";
		}
		return $respuesta;
	}
	
	//////////////////////////////////////////////////////
	public function get_id_persona($id_cliente)
	{
		$this->db->select('*');
		$this->db->from('tab_clientes_naturales');
		$this->db->where('ID_CLIENTE', $id_cliente);
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds['ID_PERSONA'];
	}
	
	//////////////////////////////////////////////////////
	public function get_etapas_calificar()
	{
		$periodo=$this->get_periodo_activado();
		$this->db->select('*');
		$this->db->from('acad_activacion_calificacion');
		$this->db->where('ID_PERIODO_ACADEMICO', $periodo);
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	//////////////////////////////////////////////////////
	public function crear_etapas_calificar($data)
	{
		$this->db->insert('acad_activacion_calificacion', $data);
		return $this->db->insert_id();
	}
	
	//////////////////////////////////////////////////////
	public function actualizar_etapas_calificar($data, $id)
	{
		$this->db->where('ID_ACTIVACION_CALIFICACION', $id);
		$this->db->update('acad_activacion_calificacion', $data);
	}
	
	/////////////////////////////////////////////////////////////////////////////
	public function get_grupos_alumnos_materias_asignadas_al_docente($id_persona,$id_materia)
	{
		$periodo= $this->get_periodo_activado();
		$this->db->select('distinct(ecm.ID_GRUPO) as ID_GRUPO, g.NOMBRE');
		$this->db->from('acad_estudiante_carrera_materia ecm');
		$this->db->join('acad_grupo g','g.ID_GRUPO=ecm.ID_GRUPO');
		$this->db->where('ecm.ID_CARRERA_MATERIA', $id_materia);
		$this->db->where('ecm.ID_PERSONA_DOCENTE', $id_persona);
		$this->db->where('ecm.ID_PERIODO_ACADEMICO', $periodo);
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	//////////////////////////////////////////////////////////////////////////////
	public function buscarPeriodosGeneral() 
	{
		$this->db->select('*');
		$this->db->from('acad_periodo_academico');
		$this->db->order_by('FECHA_INICIO','ASC');
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)>0){
			$periodos='<table class="table table-condensed">';
			$p_activado = $this->get_periodo_activado();
			$p_matricula = $this->get_periodo_matricula();
			for($i=0;$i<count($ds);$i++){
				$periodos.='<tr class="tr_opcion">';
				$periodos.="<td><strong>Desde: </strong> ".$ds[$i]['FECHA_INICIO']." <strong>Hasta: </strong>".$ds[$i]['FECHA_FIN']."</td>";
				$select='';
				if(($ds[$i]['ID_PERIODO_ACADEMICO']==$p_activado) or ($p_activado==false and $i==0)){
					$select='checked';
				}
				$periodos.='<td><label class="opcion"><input type="radio" value="'.$ds[$i]['ID_PERIODO_ACADEMICO'].'" name="period" '.$select.'> Academico </label></td>';
				$select='';
				if(($ds[$i]['ID_PERIODO_ACADEMICO']==$p_matricula) or ($p_matricula==false and $i==0)){
					$select='checked';
				}
				$periodos.='<td><label class="opcion"><input type="radio" value="'.$ds[$i]['ID_PERIODO_ACADEMICO'].'" name="matricula" '.$select.'> Matricula </label></td>';
				$periodos.='</tr>';
				//$periodos.='<label class="opcion"><input type="radio" value="'.$ds[$i]['ID_PERIODO_ACADEMICO'].'" name="period" '.$select.'> ';
				//$periodos.= "<strong>Desde: </strong> ".$ds[$i]['FECHA_INICIO']." <strong>Hasta: </strong>".$ds[$i]['FECHA_FIN']."</label><br>";
			}	
			$periodos.="</table>";
			return $periodos;  
		}else{
			return false;
		}
		
		/*$this->db->select('*');
		$this->db->from('acad_periodo_academico');
		$this->db->order_by('FECHA_INICIO','ASC');
		$query = $this->db->get();
		$ds = $query->result_array();
		if(count($ds)>0){
			$periodos="";
			$this->db->select('VALOR');
			$this->db->from('acad_parametro');
			$this->db->where('acad_parametro.ID_PARAMETRO', 8);
			$query = $this->db->get();
			$ds_periodo = $query->row_array();
			$p_activado = $ds_periodo['VALOR'];
			if($p_activado==NULL){
				for($i=0;$i<count($ds);$i++){
					if($i==0){
						$periodos.="<label><input type='radio' value='".$ds[$i]['ID_PERIODO_ACADEMICO']."' name='period' checked> ";
						$periodos.= "<strong>Desde: </strong> ".$ds[$i]['FECHA_INICIO']." <strong>Hasta: </strong>".$ds[$i]['FECHA_FIN']."</label><br>";
					}else{
						$periodos.="<label><input type='radio' value='".$ds[$i]['ID_PERIODO_ACADEMICO']."' name='period'> ";
						$periodos.= "<strong>Desde: </strong> ".$ds[$i]['FECHA_INICIO']." <strong>Hasta: </strong>".$ds[$i]['FECHA_FIN']."</label><br>";
					}
				}
				return $periodos;                
			}else{
				for($i=0;$i<count($ds);$i++){
					if($ds[$i]['ID_PERIODO_ACADEMICO']==$p_activado){
						$periodos.="<label><input type='radio' value='".$ds[$i]['ID_PERIODO_ACADEMICO']."' name='period' checked> ";
						$periodos.= "<strong>Desde: </strong> ".$ds[$i]['FECHA_INICIO']." <strong>Hasta: </strong>".$ds[$i]['FECHA_FIN']."</label><br>";
					}else{
						$periodos.="<label><input type='radio' value='".$ds[$i]['ID_PERIODO_ACADEMICO']."' name='period'> ";
						$periodos.= "<strong>Desde: </strong> ".$ds[$i]['FECHA_INICIO']." <strong>Hasta: </strong>".$ds[$i]['FECHA_FIN']."</label><br>";
					}
				}
				return $periodos; 
			}
		}else{
			return false;
		}*/
	}
	
	//////////////////////////////////////////////////////
	public function actualizaMateria($id_carrera_materia,$data)
	{
		$this->db->where('ID_CARRERA_MATERIA', $id_carrera_materia);
		$this->db->update('acad_carrera_materia', $data);
	}
	
	//////////////////////////////////////////////
	public function listado_silabos_tareas($data) 
	{
		$sql="SELECT dcm.*, concat(SUBSTRING(pa.FECHA_INICIO,1,7),' / ',SUBSTRING(pa.FECHA_FIN,1,7)) as PERIODO, CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE,p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as DOCENTE, c.NOMBRE as CARRERA, m.NOMBRE as MATERIA,g.ID_GRUPO, g.NOMBRE as GRUPO, st.SILABO, st.TAREA, st.FECHA";
		$sql.=" FROM acad_docente_carrera_materia dcm";
		$sql.=" join acad_grupo g on g.ID_CARRERA=dcm.ID_CARRERA and g.ID_NIVEL=dcm.NIVEL_MATERIA";
		$sql.=" join acad_periodo_academico pa on pa.ID_PERIODO_ACADEMICO=dcm.ID_PERIODO_ACADEMICO";
		$sql.=" join acad_carrera c on c.ID_CARRERA=dcm.ID_CARRERA";
		$sql.=" join acad_materia m on m.ID_MATERIA=dcm.ID_CARRERA_MATERIA";
		$sql.=" join tab_personas p on p.ID_PERSONA=dcm.ID_PERSONA";
		$sql.=" LEFT join acad_silabo_tarea st on st.ID_DOCENTE_CARRERA_MATERIA=dcm.ID_DOCENTE_CARRERA_MATERIA and st.ID_GRUPO=g.ID_GRUPO";
		$sql.=" where dcm.ID_DOCENTE_CARRERA_MATERIA>0";		
		if(isset($data['APELLIDO_PATERNO']) and $data['APELLIDO_PATERNO']!=NULL){
			$sql.=" and p.APELLIDO_PATERNO like '%".$data['APELLIDO_PATERNO']."%'";
		}
		if(isset($data['APELLIDO_MATERNO']) and $data['APELLIDO_MATERNO']!=NULL){
			$sql.=" and p.APELLIDO_MATERNO like '%".$data['APELLIDO_MATERNO']."%'";
		}
		if(isset($data['PRIMER_NOMBRE']) and $data['PRIMER_NOMBRE']!=NULL){
			$sql.=" and p.PRIMER_NOMBRE like '%".$data['PRIMER_NOMBRE']."%'";
		}
		if(isset($data['SEGUNDO_NOMBRE']) and $data['SEGUNDO_NOMBRE']!=NULL){
			$sql.=" and p.SEGUNDO_NOMBRE like '%".$data['SEGUNDO_NOMBRE']."%'";
		}
		if(isset($data['ID_PERIODO_ACADEMICO']) and $data['ID_PERIODO_ACADEMICO']!=NULL){
			$sql.=" and dcm.ID_PERIODO_ACADEMICO =".$data['ID_PERIODO_ACADEMICO'];
		}
		if(isset($data['ID_CARRERA']) and $data['ID_CARRERA']!=NULL){
			$sql.=" and dcm.ID_CARRERA =".$data['ID_CARRERA'];
		}
		if(isset($data['ID_NIVEL']) and $data['ID_NIVEL']!=NULL){
			$sql.=" and dcm.NIVEL_MATERIA =".$data['ID_NIVEL'];
		}
		if(isset($data['ID_CARRERA_MATERIA']) and $data['ID_CARRERA_MATERIA']!=NULL){
			$sql.=" and dcm.ID_CARRERA_MATERIA =".$data['ID_CARRERA_MATERIA'];
		}
		if(isset($data['ID_PERSONA']) and $data['ID_PERSONA']!=NULL){
			$sql.=" and dcm.ID_PERSONA =".$data['ID_PERSONA'];
		}
		if(isset($data['ID_GRUPO']) and $data['ID_GRUPO']!=NULL){
			$sql.=" and g.ID_GRUPO =".$data['ID_GRUPO'];
		}
		if(isset($data['ID_DOCENTE_CARRERA_MATERIA']) and $data['ID_DOCENTE_CARRERA_MATERIA']!=NULL){
			$sql.=" and dcm.ID_DOCENTE_CARRERA_MATERIA =".$data['ID_DOCENTE_CARRERA_MATERIA'];
		}
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		return $ds;
	}
	
	/////////////////////////////////////////////////////////////////////////////
	public function get_silabo_tarea($id_docente_carrera_materia,$id_grupo)
	{
		$this->db->select('*');
		$this->db->from('acad_silabo_tarea');
		$this->db->where('ID_DOCENTE_CARRERA_MATERIA', $id_docente_carrera_materia);
		$this->db->where('ID_GRUPO', $id_grupo);
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds;
	}
	
	//////////////////////////////////////////////////////
	public function crearSilaboTarea($data)
	{
		$this->db->insert('acad_silabo_tarea', $data);
		return $this->db->insert_id();
	}
	
	//////////////////////////////////////////////////////
	public function actualizarSilaboTarea($data,$id_silabo_tarea)
	{
		$this->db->where('ID_SILABO_TAREA', $id_silabo_tarea);
		$this->db->update('acad_silabo_tarea', $data);
	}
	
	/////////////////////////////////////////////////////////////////////////////
	public function get_materias_estudiante($id_persona,$id_periodo,$todo=null,$hasta_periodo=null,$id_carrera=null,$id_nivel=null,$grupo=null)
	{
		$this->db->select('ecm.*,lg.ID_LOG_GUIA,lg.FECHA');
		$this->db->from('acad_estudiante_carrera_materia ecm');
		$this->db->join('acad_log_guia lg','lg.ID_ESTUDIANTE_CARRERA_MATERIA=ecm.ID_ESTUDIANTE_CARRERA_MATERIA','left');
		$this->db->where('ecm.ID_PERSONA', $id_persona);
		if($hasta_periodo!=null){
			//$this->db->where('ID_PERIODO_ACADEMICO<=', $hasta_periodo);
			$this->db->where('ecm.ID_PERIODO_ACADEMICO in ( select ID_PERIODO_ACADEMICO from acad_periodo_academico where FECHA_INICIO<=(select FECHA_INICIO from acad_periodo_academico where ID_PERIODO_ACADEMICO='.$hasta_periodo.'))');
		}elseif($id_periodo!=null){
			$this->db->where('ecm.ID_PERIODO_ACADEMICO', $id_periodo);
		}
		if($id_carrera!=null and $id_carrera!=''){
			$this->db->where('ecm.ID_CARRERA', $id_carrera);
		}
		if($id_nivel!=null and $id_nivel!=''){
			$this->db->where('ecm.NIVEL_MATERIA', $id_nivel);
		}
		if($grupo!=null and $grupo!=''){
			$this->db->join('acad_grupo', 'acad_grupo.ID_GRUPO=ecm.ID_GRUPO');
			$this->db->where('acad_grupo.NOMBRE', $grupo);
		}
		if($todo==null){
			$this->db->where('ecm.FUE_CONVALIDADA', 0);
			$this->db->where('ecm.FUE_HOMOLOGADA', 0);
			$this->db->where('ecm.FUE_HISTORIAL', 0);
		}
		$this->db->order_by('ecm.ID_CARRERA_MATERIA');
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	/////////////////////////////////////////////////////////////////////////////
	public function get_correos_estudiantes_grupo($id_docente_carrera_materia,$id_grupo)
	{
		/*$this->db->select('tc.CORREO_ELECTRONICO');
		$this->db->from('tab_contactos tc');
		$this->db->join('tab_clientes_naturales cn','cn.ID_CLIENTE=tc.ID_CLIENTE');
		$this->db->join('acad_estudiante_carrera_materia ecm','ecm.ID_PERSONA=cn.ID_PERSONA');
		$this->db->join('acad_docente_carrera_materia dcm','dcm.ID_PERSONA=ecm.ID_PERSONA_DOCENTE and dcm.ID_CARRERA_MATERIA=ecm.ID_CARRERA_MATERIA and dcm.ID_PERIODO_ACADEMICO=ecm.ID_PERIODO_ACADEMICO and dcm.NIVEL_MATERIA=ecm.NIVEL_MATERIA and dcm.ID_CARRERA=ecm.ID_CARRERA');
		$this->db->where('dcm.ID_DOCENTE_CARRERA_MATERIA', $id_docente_carrera_materia);
		$this->db->where('ecm.ID_GRUPO', $id_grupo);
		$this->db->where('tc.ID_TIPO_CONTACTO', 2);
		$this->db->where('tc.ESTADO', 1);*/
		$this->db->select('p.CORREO_INSTITUCIONAL');
		$this->db->from('tab_personas p');
		$this->db->join('acad_estudiante_carrera_materia ecm','ecm.ID_PERSONA=p.ID_PERSONA');
		$this->db->join('acad_docente_carrera_materia dcm','dcm.ID_PERSONA=ecm.ID_PERSONA_DOCENTE and dcm.ID_CARRERA_MATERIA=ecm.ID_CARRERA_MATERIA and dcm.ID_PERIODO_ACADEMICO=ecm.ID_PERIODO_ACADEMICO and dcm.NIVEL_MATERIA=ecm.NIVEL_MATERIA and dcm.ID_CARRERA=ecm.ID_CARRERA');
		$this->db->where('dcm.ID_DOCENTE_CARRERA_MATERIA', $id_docente_carrera_materia);
		$this->db->where('ecm.ID_GRUPO', $id_grupo);
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	//////////////////////////////////////////////
	public function verificar_si_tiene_estudiantes($data) 
	{
		$sql="SELECT ID_ESTUDIANTE_CARRERA_MATERIA";
		$sql.=" FROM acad_estudiante_carrera_materia";
		$sql.=" where ID_ESTUDIANTE_CARRERA_MATERIA>0";	
		if(isset($data['ID_PERIODO_ACADEMICO']) and $data['ID_PERIODO_ACADEMICO']!=NULL){
			$sql.=" and ID_PERIODO_ACADEMICO =".$data['ID_PERIODO_ACADEMICO'];
		}
		if(isset($data['ID_PERSONA']) and $data['ID_PERSONA']!=NULL){
			$sql.=" and ID_PERSONA_DOCENTE =".$data['ID_PERSONA'];
		}
		if(isset($data['ID_CARRERA']) and $data['ID_CARRERA']!=NULL){
			$sql.=" and ID_CARRERA =".$data['ID_CARRERA'];
		}
		if(isset($data['NIVEL_MATERIA']) and $data['NIVEL_MATERIA']!=NULL){
			$sql.=" and NIVEL_MATERIA =".$data['NIVEL_MATERIA'];
		}
		if(isset($data['ID_CARRERA_MATERIA']) and $data['ID_CARRERA_MATERIA']!=NULL){
			$sql.=" and ID_CARRERA_MATERIA =".$data['ID_CARRERA_MATERIA'];
		}
		if(isset($data['ID_GRUPO']) and $data['ID_GRUPO']!=NULL){
			$sql.=" and ID_GRUPO =".$data['ID_GRUPO'];
		}
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 		
		if(count($ds)>0){
			return 1;
		}else{
			return 0;
		}
	}
	
	//////////////////////////////////////////////
	public function num_tareas_estudiantes($id_docente_carrera_materia,$id_grupo) 
	{
		$sql="select count(ID_TAREA) as num_tareas";
		$sql.=" FROM acad_tareas";
		$sql.=" where ID_DOCENTE_CARRERA_MATERIA=".$id_docente_carrera_materia;
		$sql.=" and ID_GRUPO=".$id_grupo;
		$query = $this->db->query($sql);
		$ds = $query->row_array(); 		
		if($ds!=NULL){
			return $ds['num_tareas'];
		}else{
			return 0;
		}
	}
	
	/////////////////////////////////////////////////////////////////////////////
	public function get_docente_carrera_materia_grupo($id_docente_carrera_materia,$id_grupo)
	{
		$sql="SELECT dcm.*, concat(SUBSTRING(pa.FECHA_INICIO,1,7),' / ',SUBSTRING(pa.FECHA_FIN,1,7)) as PERIODO, CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE,p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as DOCENTE, c.NOMBRE as CARRERA, m.NOMBRE as MATERIA,g.ID_GRUPO, g.NOMBRE as GRUPO";
		$sql.=" FROM acad_docente_carrera_materia dcm";
		$sql.=" join acad_grupo g on g.ID_CARRERA=dcm.ID_CARRERA and g.ID_NIVEL=dcm.NIVEL_MATERIA";
		$sql.=" join acad_periodo_academico pa on pa.ID_PERIODO_ACADEMICO=dcm.ID_PERIODO_ACADEMICO";
		$sql.=" join acad_carrera c on c.ID_CARRERA=dcm.ID_CARRERA";
		$sql.=" join acad_materia m on m.ID_MATERIA=dcm.ID_CARRERA_MATERIA";
		$sql.=" join tab_personas p on p.ID_PERSONA=dcm.ID_PERSONA";
		$sql.=" where dcm.ID_DOCENTE_CARRERA_MATERIA=".$id_docente_carrera_materia;
		$sql.=" and g.ID_GRUPO=".$id_grupo;
		$query = $this->db->query($sql);
		$ds = $query->row_array();
		return $ds;
	}
	
	///////////////////////////////////////////////////////////
	public function buscar_tareas($data)
	{
		$this->db->select('*');
		$this->db->from('acad_tareas');
		if(isset($data['ID_DOCENTE_CARRERA_MATERIA']) and $data['ID_DOCENTE_CARRERA_MATERIA']!=NULL){
			$this->db->where('ID_DOCENTE_CARRERA_MATERIA',$data['ID_DOCENTE_CARRERA_MATERIA']);
		}
		if(isset($data['ID_GRUPO']) and $data['ID_GRUPO']!=NULL){
			$this->db->where('ID_GRUPO',$data['ID_GRUPO']);
		}
		if(isset($data['ID_TAREA']) and $data['ID_TAREA']!=NULL){
			$this->db->where('ID_TAREA',$data['ID_TAREA']);
		}
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	//////////////////////////////////////////////////////
	public function crearTarea($data)
	{
		$this->db->insert('acad_tareas', $data);
		return $this->db->insert_id();
	}
	
	//////////////////////////////////////////////////////
	public function actualizarTarea($data,$id_tarea)
	{
		$this->db->where('ID_TAREA', $id_tarea);
		$this->db->update('acad_tareas', $data);
	}
	
	//////////////////////////////////////////////
	public function num_respuestas_estudiantes($id_tarea) 
	{
		$sql="select count(ID_RESPUESTA_TAREA) as num_respuestas";
		$sql.=" FROM acad_respuestas_tareas";
		$sql.=" where ID_TAREA=".$id_tarea;
		$query = $this->db->query($sql);
		$ds = $query->row_array(); 
		if($ds!=NULL){
			return $ds['num_respuestas'];
		}else{
			return 0;
		}
	}
	
	//////////////////////////////////////////////////////
	public function crearRespuestaTarea($data)
	{
		$this->db->insert('acad_respuestas_tareas', $data);
		return $this->db->insert_id();
	}
	
	///////////////////////////////////////////////////////////
	public function buscar_respuestas_tarea($data)
	{
		$sql="select rt.*,CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE,p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as ESTUDIANTE";
		$sql.=" from acad_respuestas_tareas rt";
		$sql.=" join tab_personas p on p.ID_PERSONA=rt.ID_PERSONA";
		$sql.=" where rt.ID_RESPUESTA_TAREA>0";
		if(isset($data['ID_TAREA']) and $data['ID_TAREA']!=NULL){
			$sql.=" and rt.ID_TAREA=".$data['ID_TAREA'];
		}
		if(isset($data['ID_PERSONA']) and $data['ID_PERSONA']!=NULL){
			$sql.=" and rt.ID_PERSONA=".$data['ID_PERSONA'];
		}
		if(isset($data['ID_RESPUESTA_TAREA']) and $data['ID_RESPUESTA_TAREA']!=NULL){
			$sql.=" and rt.ID_RESPUESTA_TAREA=".$data['ID_RESPUESTA_TAREA'];
		}
		$sql.=" order by ESTUDIANTE";
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		return $ds;
	}
	
	//////////////////////////////////////////////
	public function listado_carrera_materia($data) 
	{
		$sql="SELECT cm.*, c.NOMBRE as CARRERA, m.NOMBRE as MATERIA";
		$sql.=" FROM acad_carrera_materia cm";
		$sql.=" join acad_carrera c on c.ID_CARRERA=cm.ID_CARRERA";
		$sql.=" join acad_materia m on m.ID_MATERIA=cm.ID_MATERIA";
		$sql.=" where cm.ESTADO=1";
		if(isset($data['ID_CARRERA']) and $data['ID_CARRERA']!=NULL){
			$sql.=" and cm.ID_CARRERA =".$data['ID_CARRERA'];
		}
		if(isset($data['ID_NIVEL']) and $data['ID_NIVEL']!=NULL){
			$sql.=" and cm.NIVEL_MATERIA =".$data['ID_NIVEL'];
		}
		if(isset($data['IDS_CARRERA_MATERIA']) and $data['IDS_CARRERA_MATERIA']!=''){
			$sql.=" and cm.ID_CARRERA_MATERIA in (".$data['IDS_CARRERA_MATERIA'].")";
		}
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		return $ds;
	}
	
	///////////////////////////////////////////////////////////
	public function buscar_guia_academica($id_periodo_academico,$id_carrera_materia)
	{
		$this->db->select('*');
		$this->db->from('acad_guias_academicas');
		$this->db->where('ID_PERIODO_ACADEMICO',$id_periodo_academico);
		$this->db->where('ID_CARRERA_MATERIA',$id_carrera_materia);
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds;
	}
	
	//////////////////////////////////////////////////////
	public function crearGuiaAcademica($data)
	{
		$this->db->insert('acad_guias_academicas', $data);
		return $this->db->insert_id();
	}
	
	//////////////////////////////////////////////////////
	public function actualizarGuiaAcademica($data,$id_guia_academica)
	{
		$this->db->where('ID_GUIA_ACADEMICA', $id_guia_academica);
		$this->db->update('acad_guias_academicas', $data);
	}
	
	//////////////////////////////////////////////////////
	public function actualizarRespuestaTarea($data,$id_respuesta_tarea)
	{
		$this->db->where('ID_RESPUESTA_TAREA', $id_respuesta_tarea);
		$this->db->update('acad_respuestas_tareas', $data);
	}
	
	/////////////////////////////////////////////////////////////////////////////
	public function get_estudiantes_grupo($id_docente_carrera_materia,$id_grupo)
	{
		$sql="select CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE,p.APELLIDO_PATERNO, p.APELLIDO_MATERNO ) as ESTUDIANTE, p.ID_PERSONA";
		$sql.=" from tab_personas p";
		$sql.=" join acad_estudiante_carrera_materia ecm on ecm.ID_PERSONA=p.ID_PERSONA";
		$sql.=" join acad_docente_carrera_materia dcm on dcm.ID_PERSONA=ecm.ID_PERSONA_DOCENTE and dcm.ID_CARRERA_MATERIA=ecm.ID_CARRERA_MATERIA and dcm.ID_PERIODO_ACADEMICO=ecm.ID_PERIODO_ACADEMICO and dcm.NIVEL_MATERIA=ecm.NIVEL_MATERIA and dcm.ID_CARRERA=ecm.ID_CARRERA";
		$sql.=" where dcm.ID_DOCENTE_CARRERA_MATERIA=".$id_docente_carrera_materia;
		$sql.=" and ecm.ID_GRUPO=".$id_grupo;
		$sql.=" order by ESTUDIANTE";
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		return $ds;
	}
	
	/////////////////////////////////////////////////////////////////////////////
	public function tareas_realizadas_estudiante($id_persona,$id_docente_carrera_materia,$id_grupo)
	{
		$sql="select *";
		$sql.=" from acad_respuestas_tareas";
		$sql.=" where ID_TAREA in (select ID_TAREA from acad_tareas where ID_DOCENTE_CARRERA_MATERIA=".$id_docente_carrera_materia." and ID_GRUPO=".$id_grupo.")";
		$sql.=" and ID_PERSONA=".$id_persona;
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		return $ds;
	}
	
	//////////////////////////////////////////////////////
	public function borrar_activacion_etapas_calificar_periodo()
	{
		$periodo=$this->get_periodo_activado();
		$this->db->where('ID_PERIODO_ACADEMICO', $periodo);
		$this->db->delete('acad_activacion_calificacion');
	}
	
	//////////////////////////////////////////////////////
	public function get_datos_persona($id_persona,$nroDocumento=null)
	{
		$this->db->select('p.*, cli.NRO_DOCUMENTO as CEDULA, c.CORREO_ELECTRONICO, clin.ID_CLIENTE, c.CELULAR ');
		$this->db->from('tab_personas p');
		$this->db->join('tab_clientes_naturales clin','clin.ID_PERSONA=p.ID_PERSONA');
		$this->db->join('tab_clientes cli','cli.ID_CLIENTE=clin.ID_CLIENTE');
		$this->db->join('tab_contactos c','c.ID_CLIENTE = cli.ID_CLIENTE AND c.ID_TIPO_CONTACTO = 2 AND c.ESTADO = 1','left');
		if($id_persona>0){
			$this->db->where('p.ID_PERSONA',$id_persona);
		}
		if($nroDocumento!=null){
			$this->db->where('cli.NRO_DOCUMENTO',$nroDocumento);
		}
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds;
	}
	
	//////////////////////////////////////////////////////
	public function get_calificaciones($data)
	{
		$this->db->select('*');
		$this->db->from('acad_calificacion');
		if(isset($data['ID_ESTUDIANTE_CARRERA_MATERIA']) and $data['ID_ESTUDIANTE_CARRERA_MATERIA']!=NULL){
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$data['ID_ESTUDIANTE_CARRERA_MATERIA']);
		}
		if(isset($data['ID_TIPO_CALIFICACION']) and $data['ID_TIPO_CALIFICACION']!=NULL){
			$this->db->where('ID_TIPO_CALIFICACION',$data['ID_TIPO_CALIFICACION']);
		}
		if(isset($data['ID_COMPONENTE']) and $data['ID_COMPONENTE']!=NULL){
			$this->db->where('ID_COMPONENTE',$data['ID_COMPONENTE']);
		}
		if(isset($data['ESTADO_CALIFICACION']) and $data['ESTADO_CALIFICACION']!=NULL){
			$this->db->where('ESTADO_CALIFICACION',$data['ESTADO_CALIFICACION']);
		}
		if(isset($data['ETAPA']) and $data['ETAPA']>=0){
			$this->db->where('ETAPA',$data['ETAPA']);
		}
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	//////////////////////////////////////////////////////////////////
	public function get_grupo($idGrupo)
	{
		$this->db->select('g.*,s.SEDE');
		$this->db->from('acad_grupo g');
		$this->db->join('acad_sede s','s.ID_SEDE=g.ID_SEDE');
		$this->db->where('g.ID_GRUPO', $idGrupo);
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds;
	}
	
	//////////////////////////////////////////////////////
	public function actualizar_mensaje_estudiante($data)
	{
		if(isset($data['mensaje_aprueba'])){
			$this->db->where('NOMBRE', 'mensaje_aprueba');
			$this->db->update('acad_parametro', array('DESCRIPCION'=>$data['mensaje_aprueba']));
		}
		if(isset($data['mensaje_pierde'])){
			$this->db->where('NOMBRE', 'mensaje_pierde');
			$this->db->update('acad_parametro', array('DESCRIPCION'=>$data['mensaje_pierde']));
		}
		if(isset($data['mensaje_supletorio'])){
			$this->db->where('NOMBRE', 'mensaje_supletorio');
			$this->db->update('acad_parametro', array('DESCRIPCION'=>$data['mensaje_supletorio']));
		}
	}
	
	//////////////////////////////////////////////////////////////////
	public function get_mensaje_aprueba()
	{
		$this->db->select('DESCRIPCION');
		$this->db->from('acad_parametro');
		$this->db->where('NOMBRE', 'mensaje_aprueba');
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds['DESCRIPCION'];
	}
	
	//////////////////////////////////////////////////////////////////
	public function get_mensaje_pierde()
	{
		$this->db->select('DESCRIPCION');
		$this->db->from('acad_parametro');
		$this->db->where('NOMBRE', 'mensaje_pierde');
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds['DESCRIPCION'];
	}
	
	//////////////////////////////////////////////////////////////////
	public function get_mensaje_supletorio()
	{
		$this->db->select('DESCRIPCION');
		$this->db->from('acad_parametro');
		$this->db->where('NOMBRE', 'mensaje_supletorio');
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds['DESCRIPCION'];
	}
	
	//////////////////////////////////////////////////////////////////
	public function get_materias_conversion($id_materia_externo)
	{
		$this->db->select('*');
		$this->db->from('acad_conversion_materias');
		$this->db->where('ID_MATERIA_EXTERNO', $id_materia_externo);
		$query = $this->db->get();
		$ds = $query->row_array();
		if(isset($ds['ID_MATERIA_BINARY'])){
			return $ds['ID_MATERIA_BINARY'];
		}else{
			return '';
		}
	}
	
	///////////////////////////////////////////////////////
	public function actualizar_acad_estudiante_carrera_materia($datos,$id_estudiante_carrera_materia) 
	{
		$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA', $id_estudiante_carrera_materia);
		$this->db->update('acad_estudiante_carrera_materia', $datos);
	}
	
	////////////////////////////////////////////////
	public function get_sede($id_sede) 
	{
		$this->db->select('*');
		$this->db->from('acad_sede');
		$this->db->where('ID_SEDE',$id_sede);
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds;
	}
	
	////////////////////////////////////////////////
	public function get_asistencia_materia($estudiante_carrera_materia) 
	{
		$periodo=$this->get_periodo_activado();
		$this->db->select("ID_CALIFICACION,CALIFICACION");
		$this->db->from('acad_calificacion');
		$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$estudiante_carrera_materia);
		//$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
		$this->db->where('ETAPA',0);
		$this->db->where('ID_TIPO_CALIFICACION',4); //de tipo: asistencia
		$query = $this->db->get();
		$ds = $query->row_array(); 
		if($ds!=NULL){
			return $ds['CALIFICACION'];
		}else{
			return -1;
		}
	}
	
	//////////////////////////////////////////////////////
	public function crear_fecha_cierre($data)
	{
		$this->db->insert('acad_cierre_calificacion', $data);
		return $this->db->insert_id();
	}
	
	///////////////////////////////////////////////////////
	public function actualizar_fecha_cierre($datos,$id_cierre_calificacion) 
	{
		$this->db->where('ID_CIERRE_CALIFICACION', $id_cierre_calificacion);
		$this->db->update('acad_cierre_calificacion', $datos);
	}
	
	////////////////////////////////////////////////
	public function get_fecha_cierre($data) 
	{
		$this->db->select("*");
		$this->db->from('acad_cierre_calificacion');
		if(isset($data['ID_PERIODO_ACADEMICO']) and $data['ID_PERIODO_ACADEMICO']!=''){
			$this->db->where('ID_PERIODO_ACADEMICO',$data['ID_PERIODO_ACADEMICO']);
		}
		if(isset($data['GRUPO']) and $data['GRUPO']!=''){
			$this->db->where('GRUPO',$data['GRUPO']);
		}
		if(isset($data['ID_MATERIA']) and $data['ID_MATERIA']!=''){
			$this->db->where('ID_MATERIA',$data['ID_MATERIA']);
		}
		if(isset($data['MATERIA']) and $data['MATERIA']!=''){
			$this->db->where('MATERIA',$data['MATERIA']);
		}
		if(isset($data['ID_GRUPO']) and $data['ID_GRUPO']!=''){
			$this->db->where('ID_GRUPO',$data['ID_GRUPO']);
		}
		if(isset($data['FECHA_CIERRE']) and $data['FECHA_CIERRE']!=''){
			$this->db->where('FECHA_CIERRE',$data['FECHA_CIERRE']);
		}
		if(isset($data['ID_PLANTILLA']) and $data['ID_PLANTILLA']!=''){
			$this->db->where('ID_PLANTILLA',$data['ID_PLANTILLA']);
		}
		$query = $this->db->get();
		$ds = $query->result_array(); 
		if(count($ds)==1){
			return $ds[0];
		}else{
			return $ds;
		}
	}
	
	///////////////////////////////////////////////////////
	public function getPeriodosAnteriores($id_periodo_academico)
	{
		$sql="select ID_PERIODO_ACADEMICO";
		$sql.=" from acad_periodo_academico";
		$sql.=" where FECHA_INICIO<(select FECHA_INICIO from acad_periodo_academico where ID_PERIODO_ACADEMICO=".$id_periodo_academico.")";
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		return $ds;
	}
	
	////////////////////////////////////////////////
	public function get_supletorio_materia($estudiante_carrera_materia) 
	{
		$periodo=$this->get_periodo_activado();
		$this->db->select("ID_CALIFICACION,CALIFICACION");
		$this->db->from('acad_calificacion');
		$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$estudiante_carrera_materia);
		//$this->db->where('ID_PERIODO_ACADEMICO',$periodo);
		$this->db->where('ETAPA',0);
		$this->db->where('ID_TIPO_CALIFICACION',5); //de tipo: supletorio
		$query = $this->db->get();
		$ds = $query->row_array(); 
		if($ds!=NULL){
			return $ds['CALIFICACION'];
		}else{
			return -1;
		}
	}

	/////////////////////////////////////////////////
	public function buscarEstudianteCarreraMateria($idEstudianteCarreraMateria)
	{
		$this->db->select('*');
		$this->db->from('acad_estudiante_carrera_materia');
		$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$idEstudianteCarreraMateria);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	//////////////////////////////////////////////////////
	public function crearLogVlc($data)
	{
		$this->db->insert('tab_log_vlc', $data);
		return $this->db->insert_id();
	}
	
	//////////////////////////////////////////////////////////
	public function borrar_matricula($id_matricula,$idCliente) 
    {
        $id_periodo_activado = $this->academico_model->get_periodo_activado();	
		//Proceso Borrar
		$this->db->query('SET FOREIGN_KEY_CHECKS=0'); 
		$query_borra_materias = $this->db->query("delete from acad_estudiante_carrera_materia where ID_PERSONA in (select ID_PERSONA from acad_matricula where ID_MATRICULA=".$id_matricula.") and ID_CARRERA in (select ID_CARRERA from acad_matricula where ID_MATRICULA=".$id_matricula.") and ID_PERIODO_ACADEMICO=".$id_periodo_activado);
		$query_borra_rubros_cliente_cuota=$this->db->query("delete from fac_clientes_rubros_cuota where ID_CLIENTE_RUBRO in (select ID_CLIENTE_RUBRO from fac_clientes_rubros where ID_CLIENTE=".$idCliente." and PERIODO_VIGENTE=".$id_periodo_activado." and ID_CARRERA in (select ID_CARRERA from acad_matricula where ID_MATRICULA=".$id_matricula."))");
		$query_borra_rubros_cliente=$this->db->query("delete from fac_clientes_rubros where ID_CLIENTE=".$idCliente." and PERIODO_VIGENTE=".$id_periodo_activado." and ID_CARRERA in (select ID_CARRERA from acad_matricula where ID_MATRICULA=".$id_matricula.")");
		$query_borra_cuota_general = $this->db->query("delete from fac_cuotas_generales where ID_CLIENTE=".$idCliente." and ID_PERIODO_ACADEMICO=".$id_periodo_activado." and ID_MATRICULA=".$id_matricula);
		$query_borra_matricula = $this->db->query("delete from acad_matricula where ID_MATRICULA=".$id_matricula);
    }

	////////////////////////////////////////////
		public function buscarTipoDocumento($data){
			$this->db->select('*');
			$this->db->from('acad_tipo_documento');
			if (isset($data['ID_TIPO_DOCUMENTO'])) {
				$this->db->where('ID_TIPO_DOCUMENTO', $data['ID_TIPO_DOCUMENTO']);
			}
			$query = $this->db->get();
			return $query->row_array();

		}
	////////////////////////////////////////////
		public function consultarCodigo($codigo){
			$this->db->select('*');
			$this->db->from('acad_documentos_academicos');
			if (isset($codigo)) {
				$this->db->where('CODIGO_DOCUMENTO', $codigo);
			}
			$query = $this->db->get();
			$ds=$query->result_array();
			if (count($ds)>0) {
				return true;
			}else{
				return false;
			}

		}

	////////////////////////////////////////////
		public function buscarDocumentoAcademico($data){
			$this->db->select('*');
			$this->db->from('acad_documentos_academicos');
			if (isset($data['ID_MATRICULA'])) {
				$this->db->where('ID_MATRICULA', $data['ID_MATRICULA']);
			}
			if (isset($data['ID_TIPO_DOCUMENTO'])) {
				$this->db->where('ID_TIPO_DOCUMENTO', $data['ID_TIPO_DOCUMENTO']);
			}
			$query = $this->db->get();
			return $query->row_array();

		}
	//////////////////////////////////////////////////////
		public function crearDocumentoAcademico($data){
			$this->db->insert('acad_documentos_academicos', $data);
			return $this->db->insert_id();
		}

	///////////////////////////////////////////////////////
		public function actualizarDocumentoAcademico($datos,$idDocumentoAcademico){
			$this->db->where('ID_DOCUMENTO_ACADEMICO', $idDocumentoAcademico);
			$this->db->update('acad_documentos_academicos', $datos);
		}
	///////////////////////////////////////////////////////
		public function getDocentesMateria($data){
			$id_periodo=$this->get_periodo_activado();		
			
			/*$sql ="SELECT p.ID_PERSONA, CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE,p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as NOMBRE, ";
			$sql .="CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as NOMBRES, CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as APELLIDOS, ";
			$sql .="cli.NRO_DOCUMENTO as CEDULA ";
			$sql .=" from tab_personas p inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION";
			$sql .=" inner join tab_clientes_naturales clin on clin.ID_PERSONA = p.ID_PERSONA ";
			$sql .=" inner join tab_clientes cli on cli.ID_CLIENTE = clin.ID_CLIENTE ";
			$sql .=" WHERE o.ID_OCUPACION=2 ";
			$sql .=" ORDER BY NOMBRE ";
			$query = $this->db->query($sql);
			// $query = $this->db->get();
			$ds    = $query->result_array(); 

			for($i=0;$i<count($ds);$i++){
				 $sql1 ="select ID_CARRERA_MATERIA FROM acad_docente_carrera_materia where ID_PERIODO_ACADEMICO=".$id_periodo." and ID_PERSONA=".$ds[$i]['ID_PERSONA'];
				 $query1 = $this->db->query($sql1);
				 $ds1 = $query1->result_array(); 
				 $cadena_ids_materias="";
				 for($j=0;$j<count($ds1);$j++){
					$cadena_ids_materias.=$ds1[$j]['ID_CARRERA_MATERIA']."-";
				 }
				 $ds[$i]['CADENA_MATERIAS']=$cadena_ids_materias;
			}*/
			
			$sql ="SELECT p.ID_PERSONA, CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE,p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as NOMBRE, ";
			$sql .="CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as NOMBRES, CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as APELLIDOS, dcm.ID_DOCENTE_CARRERA_MATERIA, ";
			$sql .="cli.NRO_DOCUMENTO as CEDULA ";
			$sql .=" from tab_personas p inner join tab_ocupaciones o on o.ID_OCUPACION = p.OCUPACION";
			$sql .=" inner join tab_clientes_naturales clin on clin.ID_PERSONA = p.ID_PERSONA ";
			$sql .=" inner join tab_clientes cli on cli.ID_CLIENTE = clin.ID_CLIENTE ";
			$sql .=" inner join acad_docente_carrera_materia dcm on dcm.ID_PERSONA = p.ID_PERSONA ";
			$sql .=" WHERE o.ID_OCUPACION=2 ";
			$sql .=" and dcm.ID_PERIODO_ACADEMICO=".$id_periodo." ";
			$sql .=" and dcm.ID_CARRERA_MATERIA =".$data['ID_CARRERA_MATERIA']." ";
			$sql .=" ORDER BY NOMBRE ";
			$query = $this->db->query($sql);
			// $query = $this->db->get();
			$ds    = $query->result_array(); 

			return $ds;
		}
	
	///////////////////////////////////////////////////////////
	public function buscar_vlog($data) 
	{
		$this->db->select("*");
		$this->db->from('tab_log_vlc');
		if(isset($data['CEDULA_ESTUDIANTE']) and $data['CEDULA_ESTUDIANTE']!=''){
			$this->db->where('CEDULA_ESTUDIANTE',$data['CEDULA_ESTUDIANTE']);
		}
		if(isset($data['FECHAI']) and $data['FECHAI']!=''){
			$this->db->where('date(FECHA)>=',$data['FECHAI']);
		}
		if(isset($data['FECHAF']) and $data['FECHAF']!=''){
			$this->db->where('date(FECHA)<=',$data['FECHAF']);
		}
		$query = $this->db->get();
		$ds = $query->result_array(); 
		return $ds;
	}
	
	////////////////////////////////////////////////////////////////////////////
	public function get_materias_estudianteAll($id_estudiante_carrera_materia,$id_planificacion=0)
	{
		$sql ="SELECT m.NOMBRE as MATERIA, n.NIVEL, c.NOMBRE as CARRERA, n1.NIVEL as NIVEL_ESTUDIANTE, cli.NRO_DOCUMENTO as CEDULA_ESTUDIANTE, g.NOMBRE as GRUPO, CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO, p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as ESTUDIANTE, CONCAT_WS(' ',p1.APELLIDO_PATERNO, p1.APELLIDO_MATERNO, p1.PRIMER_NOMBRE, p1.SEGUNDO_NOMBRE) as DOCENTE, cli1.NRO_DOCUMENTO as CEDULA_DOCENTE, pla.FECHA_TUTORIA1, pla.FECHA_TUTORIA2, pla.FECHA_TUTORIA3, pla.FECHA_TUTORIA4, pla.FECHA_EXAMEN, pla.FECHA_SUPLETORIO, pla.FECHAS_TUTORIA, pla.FECHA_CIERRE, ecm.ID_CARRERA_MATERIA, ecm.ID_VLC";
		$sql .=" FROM acad_estudiante_carrera_materia ecm";
		$sql .=" join acad_materia m on m.ID_MATERIA=ecm.ID_CARRERA_MATERIA";
		$sql .=" join acad_nivel n on n.ID_NIVEL=ecm.NIVEL_MATERIA";
		$sql .=" join acad_carrera c on c.ID_CARRERA=ecm.ID_CARRERA";
		$sql .=" join tab_clientes_naturales cn on cn.ID_PERSONA=ecm.ID_PERSONA";
		$sql .=" join tab_clientes cli on cli.ID_CLIENTE=cn.ID_CLIENTE";
		$sql .=" left join acad_grupo g on g.ID_GRUPO=ecm.ID_GRUPO";
		$sql .=" join tab_personas p on p.ID_PERSONA=ecm.ID_PERSONA";
		$sql .=" left join acad_matricula mat on mat.ID_PERSONA=ecm.ID_PERSONA and mat.ID_PERIODO_ACADEMICO=ecm.ID_PERIODO_ACADEMICO";
		$sql .=" left join acad_nivel n1 on n1.ID_NIVEL=mat.ID_NIVEL";
		$sql .=" left join acad_planificacion pla on pla.ID_GRUPO=ecm.ID_GRUPO and pla.ID_CARRERA_MATERIA=ecm.ID_CARRERA_MATERIA and pla.ID_PERIODO_ACADEMICO=ecm.ID_PERIODO_ACADEMICO";
		$sql .=" left join tab_personas p1 on p1.ID_PERSONA=ecm.ID_PERSONA_DOCENTE";
		$sql .=" left join tab_clientes_naturales cn1 on cn1.ID_PERSONA=ecm.ID_PERSONA_DOCENTE";
		$sql .=" left join tab_clientes cli1 on cli1.ID_CLIENTE=cn1.ID_CLIENTE";
		$sql .=" WHERE ecm.ID_ESTUDIANTE_CARRERA_MATERIA=".$id_estudiante_carrera_materia;
		if($id_planificacion>0){
			$sql .=" and pla.ID_PLANIFICACION=".$id_planificacion;
		}
		$query = $this->db->query($sql);
		$ds    = $query->row_array(); 
		return $ds;
	}
	
	//////////////////////////////////////////////////////////////////
	public function get_url_copia()
	{
		$this->db->select('DESCRIPCION');
		$this->db->from('acad_parametro');
		$this->db->where('NOMBRE', 'url_copia');
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds['DESCRIPCION'];
	}
	
	//////////////////////////////////////////////////////////////////
	public function get_url_vlc()
	{
		$this->db->select('DESCRIPCION');
		$this->db->from('acad_parametro');
		$this->db->where('NOMBRE', 'url_vlc');
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds['DESCRIPCION'];
	}
	
	//////////////////////////////////////////////////////////////////
	public function get_id_grupo($nombre,$id_carrera,$id_nivel)
	{
		$this->db->select('ID_GRUPO');
		$this->db->from('acad_grupo');
		$this->db->where('NOMBRE', $nombre);
		$this->db->where('ID_CARRERA', $id_carrera);
		$this->db->where('ID_NIVEL', $id_nivel);
		$query = $this->db->get();
		$ds = $query->row_array();
		$id_grupo=0;
		if($ds!=NULL){
			$id_grupo=$ds['ID_GRUPO'];
		}
		return $id_grupo;
	}
	
	////////////////////////////////////////////////////////////
	public function crearPlanificacion($datos)
	{   
		$this->db->insert('acad_planificacion',$datos);
		return $this->db->insert_id();
	}
	
	/////////////////////////////////////////////////////////////
	public function actualizarPlanificacion($datos,$idPlanificacion)
	{
		$this->db->where('ID_PLANIFICACION', $idPlanificacion);
		$this->db->update('acad_planificacion', $datos);
		return $this->db->affected_rows();
	}
	
	//////////////////////////////////////////////////////
	public function borraPlanificacion($id_grupo,$id_carrera_materia)
	{
		$sql="Delete from acad_planificacion";
		$sql.=" Where ID_GRUPO=".$id_grupo;
		$sql.=" and ID_DOCENTE_CARRERA_MATERIA in (select ID_DOCENTE_CARRERA_MATERIA from acad_docente_carrera_materia where ID_CARRERA_MATERIA=".$id_carrera_materia.")";
		$this->db->query($sql);
	}
	
	//////////////////////////////////////////////////////////////
	public function getPlanificacion($id_grupo,$id_carrera_materia,$id_periodo=null,$id_plantilla=null)
	{
		if($id_periodo==null){
			$id_periodo=$this->get_periodo_activado();
		}
		$this->db->select('p.*,g.NOMBRE as GRUPO,c.NRO_DOCUMENTO');
		$this->db->from('acad_planificacion p');
		$this->db->join('tab_clientes_naturales cn','cn.ID_PERSONA=p.ID_PERSONA','left');
		$this->db->join('tab_clientes c','c.ID_CLIENTE=cn.ID_CLIENTE','left');
		$this->db->join('acad_grupo g','g.ID_GRUPO=p.ID_GRUPO','left');
		$this->db->where('p.ID_GRUPO', $id_grupo);
		$this->db->where('p.ID_CARRERA_MATERIA', $id_carrera_materia);
		$this->db->where('p.ID_PERIODO_ACADEMICO', $id_periodo);
		if($id_plantilla!=null){
			$this->db->where('p.ID_PLANTILLA', $id_plantilla);
		}
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds;
	}
	
	//////////////////////////////////////////////////////////////
	public function buscarPlanificacion($grupo,$id_carrera,$id_periodo)
	{
		$this->db->select('p.*');
		$this->db->from('acad_planificacion p');
		$this->db->join('acad_grupo g','g.ID_GRUPO=p.ID_GRUPO');
		$this->db->where('g.NOMBRE', $grupo);
		$this->db->where('g.ID_CARRERA', $id_carrera);
		$this->db->where('p.ID_PERIODO_ACADEMICO', $id_periodo);
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	//////////////////////////////////////////////////////////////////
	public function get_id_materia_conversion($id_materia_interno)
	{
		$this->db->select('*');
		$this->db->from('acad_conversion_materias');
		$this->db->like('ID_MATERIA_BINARY', $id_materia_interno);
		$query = $this->db->get();
		$ds = $query->result_array();
		$id_materia_externo=0;
		if(count($ds)>0){
			foreach($ds as $row){
				$ids=explode('+',$row['ID_MATERIA_BINARY']);
				if(in_array($id_materia_interno,$ids)){
					$id_materia_externo=$row['ID_MATERIA_EXTERNO'];
					break;
				}
			}
		}
		return $id_materia_externo;
	}
	
	////////////////////////////////////////////////////////////
	public function crear_log_send_vlc($datos)
	{   
		$this->db->insert('tab_log_send_vlc',$datos);
		return $this->db->insert_id();
	}
	
	////////////////////////////////////////////////////////////////////////////////////
	public function obtener_idCliente_matricula($id_matricula)
	{
		$sql = "select cn.*";
		$sql .= " from tab_clientes_naturales cn";
		$sql .= " join acad_matricula m on m.ID_PERSONA=cn.ID_PERSONA ";
		$sql .= " where m.ID_MATRICULA=".$id_matricula;
		$query = $this->db->query($sql);
		$ds = $query->row_array();
		$id_cliente=0;
		if($ds!=NULL){
			$id_cliente=$ds['ID_CLIENTE'];
		}
		return $id_cliente;
	}
	
	/////////////////////////////////////////////////////////////////////////////
	public function get_alumnos_materias_asignadas_al_docente($id_persona,$id_materia,$id_grupo)
	{
		$periodo= $this->get_periodo_activado();
		$this->db->select('cn.ID_CLIENTE,ecm.ID_ESTUDIANTE_CARRERA_MATERIA');
		$this->db->from('acad_estudiante_carrera_materia ecm');
		$this->db->join('tab_clientes_naturales cn','cn.ID_PERSONA=ecm.ID_PERSONA');
		$this->db->where('ecm.ID_CARRERA_MATERIA', $id_materia);
		$this->db->where('ecm.ID_PERSONA_DOCENTE', $id_persona);
		$this->db->where('ecm.ID_PERIODO_ACADEMICO', $periodo);
		if($id_grupo>0){
			$this->db->where('ecm.ID_GRUPO', $id_grupo);
		}
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	//////////////////////////////////////////////////////////////
	public function buscarPlanificaciones($data)
	{
		$this->db->select('m.NOMBRE,m.NOMBRE as MATERIA,cm.ID_CARRERA_MATERIA,cm.CREDITOS_MATERIA,cm.NIVEL_MATERIA,cm.PRECIO, CONCAT_WS(" ",per.PRIMER_NOMBRE,per.SEGUNDO_NOMBRE,per.APELLIDO_PATERNO,per.APELLIDO_MATERNO) as DOCENTE, p.ID_PERSONA, p.FECHA_TUTORIA1, p.FECHA_TUTORIA2, p.FECHA_TUTORIA3, p.FECHA_TUTORIA4, p.FECHA_EXAMEN, p.FECHA_SUPLETORIO, p.FECHAS_TUTORIA, p.FECHA_CIERRE, p.ID_GRUPO, p.ID_PLANTILLA',false);
		$this->db->from('acad_carrera_materia cm');
		$this->db->join('acad_carrera c','c.ID_CARRERA = cm.ID_CARRERA');
		$this->db->join('acad_materia m','m.ID_MATERIA = cm.ID_MATERIA');
		$this->db->join('acad_planificacion p','p.ID_CARRERA_MATERIA=cm.ID_CARRERA_MATERIA','left');
		$this->db->join('acad_grupo g','g.ID_GRUPO=p.ID_GRUPO','left');
		$this->db->join('tab_personas per','per.ID_PERSONA=p.ID_PERSONA','left');
		$this->db->where('cm.ESTADO', 1);
		if(isset($data['ID_CARRERA']) and $data['ID_CARRERA']!=''){
			$this->db->where('cm.ID_CARRERA',$data['ID_CARRERA']);
		}
		if(isset($data['ID_NIVEL']) and $data['ID_NIVEL']!=''){
			$this->db->where('cm.NIVEL_MATERIA',$data['ID_NIVEL']);
		}
		if(isset($data['ID_GRUPO']) and $data['ID_GRUPO']!=''){
			$this->db->where('p.ID_GRUPO',$data['ID_GRUPO']);
		}
		if(isset($data['ID_PERIODO_ACADEMICO']) and $data['ID_PERIODO_ACADEMICO']!=''){
			$this->db->where('p.ID_PERIODO_ACADEMICO',$data['ID_PERIODO_ACADEMICO']);
		}
		$this->db->order_by('p.FECHA_TUTORIA1');
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	//////////////////////////////////////////////////////////////
	public function verificaDocenteOcupado($id_persona,$fecha_tutoria,$id_grupo,$materia,$grupo)
	{
		$sql = "select p.*";
		$sql .= " from acad_planificacion p";
		$sql .= " join acad_materia m on m.ID_MATERIA=p.ID_CARRERA_MATERIA";
		$sql .= " join acad_grupo g on g.ID_GRUPO=p.ID_GRUPO";
		$sql .= " where p.ID_PERSONA=".$id_persona;
		$sql .= " and (p.FECHA_TUTORIA1='".$fecha_tutoria."' or p.FECHA_TUTORIA2='".$fecha_tutoria."' or p.FECHA_TUTORIA3='".$fecha_tutoria."' or p.FECHA_TUTORIA4='".$fecha_tutoria."' or p.FECHAS_TUTORIA like '%".$fecha_tutoria."%')";
		$sql .= " and p.ID_GRUPO<>".$id_grupo;
		$sql .= " and g.NOMBRE<>'".$grupo."'";
		//$sql .= " and m.NOMBRE<>'".$materia."'";
		$query = $this->db->query($sql);
		$ds = $query->result_array();
		$ocupado=0;
		if(count($ds)>0){
			$ocupado=1;
		}
		if($ocupado==0){
			$sql1 = "select p.*";
			$sql1 .= " from acad_planificacion p";
			$sql1 .= " join acad_materia m on m.ID_MATERIA=p.ID_CARRERA_MATERIA";
			$sql1 .= " join acad_grupo g on g.ID_GRUPO=p.ID_GRUPO";
			$sql1 .= " where p.ID_PERSONA=".$id_persona;
			$sql1 .= " and (p.FECHA_TUTORIA1='".$fecha_tutoria."' or p.FECHA_TUTORIA2='".$fecha_tutoria."' or p.FECHA_TUTORIA3='".$fecha_tutoria."' or p.FECHA_TUTORIA4='".$fecha_tutoria."' or p.FECHAS_TUTORIA like '%".$fecha_tutoria."%')";
			$sql1 .= " and p.ID_GRUPO<>".$id_grupo;
			$sql1 .= " and m.NOMBRE='".$materia."'";
			$sql1 .= " and g.NOMBRE='".$grupo."'";
			$query = $this->db->query($sql1);
			$ds1 = $query->result_array();
			if(count($ds1)>0){
				$ocupado=2;
			}
		}
		return $ocupado;
	}
	
	//////////////////////////////////////////////////////
	public function get_id_cliente($id_persona)
	{
		$this->db->select('*');
		$this->db->from('tab_clientes_naturales');
		$this->db->where('ID_PERSONA', $id_persona);
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds['ID_CLIENTE'];
	}
	
	//////////////////////////////////////////////////////////////
	public function buscar_materias_matriculados($data)
	{
		$this->db->select('*');
		$this->db->from('acad_estudiante_carrera_materia');
		if(isset($data['ID_CARRERA_MATERIA']) and $data['ID_CARRERA_MATERIA']!=''){
			$this->db->where('ID_CARRERA_MATERIA',$data['ID_CARRERA_MATERIA']);
		}
		if(isset($data['ID_PERIODO_ACADEMICO']) and $data['ID_PERIODO_ACADEMICO']!=''){
			$this->db->where('ID_PERIODO_ACADEMICO',$data['ID_PERIODO_ACADEMICO']);
		}
		if(isset($data['ID_GRUPO']) and $data['ID_GRUPO']!=''){
			$this->db->where('ID_GRUPO',$data['ID_GRUPO']);
		}
		if(isset($data['ID_PERSONA']) and $data['ID_PERSONA']!=''){
			$this->db->where('ID_PERSONA',$data['ID_PERSONA']);
		}
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	//////////////////////////////////////////////////////////////
	public function buscarPlanificacionTotal($data)
	{
		$this->db->distinct();
		/*$this->db->select('p.ID_PLANIFICACION, p.PLATAFORMA,p.FECHA_TUTORIA1, p.FECHA_TUTORIA2, p.FECHA_TUTORIA3, p.FECHA_TUTORIA4, p.FECHAS_TUTORIA, p.FECHA_EXAMEN, p.FECHA_CIERRE, p.FECHA_SUPLETORIO, p.TOTAL_HORAS, p.TOTAL_VALOR, g.NOMBRE as GRUPO, s.SEDE, n.NIVEL, m.NOMBRE as MATERIA, CONCAT_WS(" ", per.PRIMER_NOMBRE, per.SEGUNDO_NOMBRE, per.APELLIDO_PATERNO, per.APELLIDO_MATERNO) as DOCENTE, car.NOMBRE as CARRERA, p.HORA_EXAMEN, p.HORA_SUPLETORIO, p.ID_GRUPO, p.ID_CARRERA_MATERIA, p.ID_PERIODO_ACADEMICO, c.NRO_DOCUMENTO, p.ID_PERSONA',false);
		$this->db->from('acad_planificacion p');*/
		
		$this->db->select('p.PLATAFORMA,p.FECHA_TUTORIA1, p.FECHA_TUTORIA2, p.FECHA_TUTORIA3, p.FECHA_TUTORIA4, p.FECHAS_TUTORIA, p.FECHA_EXAMEN, p.FECHA_CIERRE, p.FECHA_SUPLETORIO, g.NOMBRE as GRUPO, s.SEDE, n.NIVEL, m.NOMBRE as MATERIA, CONCAT_WS(" ", per.PRIMER_NOMBRE, per.SEGUNDO_NOMBRE, per.APELLIDO_PATERNO, per.APELLIDO_MATERNO) as DOCENTE, p.HORA_EXAMEN, p.HORA_SUPLETORIO, p.ID_PERIODO_ACADEMICO, c.NRO_DOCUMENTO, p.ID_PERSONA',false);
		$this->db->from('acad_planificacion p');
		
		$this->db->join('acad_grupo g','g.ID_GRUPO=p.ID_GRUPO');
		$this->db->join('acad_carrera_materia cm','cm.ID_CARRERA_MATERIA=p.ID_CARRERA_MATERIA');
		$this->db->join('acad_carrera car','car.ID_CARRERA=cm.ID_CARRERA');
		$this->db->join('acad_sede s','s.ID_SEDE=g.ID_SEDE');
		$this->db->join('acad_nivel n','n.ID_NIVEL=cm.NIVEL_MATERIA');
		$this->db->join('acad_materia m','m.ID_MATERIA=cm.ID_MATERIA');
		$this->db->join('tab_personas per','per.ID_PERSONA=p.ID_PERSONA','left');
		$this->db->join('tab_clientes_naturales cn','cn.ID_PERSONA=p.ID_PERSONA','left');
		$this->db->join('tab_clientes c','c.ID_CLIENTE=cn.ID_CLIENTE','left');
		if(isset($data['GRUPO']) and $data['GRUPO']!=''){
			$this->db->where('g.NOMBRE', $data['GRUPO']);
		}
		if(isset($data['GRUPOS']) and count($data['GRUPOS'])>0){
			$this->db->where_in('g.NOMBRE', $data['GRUPOS']);
		}
		if(isset($data['ID_CARRERA']) and $data['ID_CARRERA']!=''){
			$this->db->where('cm.ID_CARRERA', $data['ID_CARRERA']);
		}
		if(isset($data['ID_PERIODO_ACADEMICO']) and $data['ID_PERIODO_ACADEMICO']!=''){
			$this->db->where('p.ID_PERIODO_ACADEMICO', $data['ID_PERIODO_ACADEMICO']);
		}
		if(isset($data['ID_SEDE']) and $data['ID_SEDE']!=''){
			$this->db->where('g.ID_SEDE', $data['ID_SEDE']);
		}
		if(isset($data['ID_NIVEL']) and $data['ID_NIVEL']!=''){
			$this->db->where('cm.NIVEL_MATERIA', $data['ID_NIVEL']);
		}
		if(isset($data['NRO_DOCUMENTO']) and $data['NRO_DOCUMENTO']!=''){
			$this->db->where('c.NRO_DOCUMENTO', $data['NRO_DOCUMENTO']);
		}
		if(isset($data['FECHA_DESDE']) and $data['FECHA_DESDE']!=''){
			$this->db->where('p.FECHA_TUTORIA1>=', $data['FECHA_DESDE']);
		}
		if(isset($data['FECHA_HASTA']) and $data['FECHA_HASTA']!=''){
			$this->db->where('p.FECHA_TUTORIA1<=', $data['FECHA_HASTA']);
		}
		if(isset($data['ID_PERSONA']) and $data['ID_PERSONA']!=''){
			$this->db->where('p.ID_PERSONA', $data['ID_PERSONA']);
		}
		if(isset($data['ID_PLANIFICACION']) and $data['ID_PLANIFICACION']!=''){
			$this->db->where('p.ID_PLANIFICACION', $data['ID_PLANIFICACION']);
		}
		$this->db->order_by('p.FECHA_TUTORIA1');
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}

	//////////////////////////////////////////////////////////////////////////////////////////
	public function id_seleccionado_plan_de_pago($id_cliente,$id_carrera=null,$periodo=null) //si tiene seleccionado plan de pago 
	{
		if($periodo==null){
			$periodo=$this->get_periodo_activado();
		}
        $this->db->select('fac_clientes_rubros.ID_PLAN_PAGO');
        $this->db->from('fac_clientes_rubros');
        $this->db->join('fac_rubros', 'fac_rubros.ID_RUBRO = fac_clientes_rubros.ID_RUBRO');
        $this->db->where('fac_rubros.ID_RUBRO', 17);
		$this->db->where('fac_clientes_rubros.periodo_vigente', $periodo);
        $this->db->where('fac_clientes_rubros.ID_CLIENTE', $id_cliente);
		if($id_carrera!=null){
			$this->db->where('fac_clientes_rubros.ID_CARRERA', $id_carrera);
		}
        $query = $this->db->get();
        $ds = $query->row_array();
        if($ds['ID_PLAN_PAGO']>0)
            return $ds['ID_PLAN_PAGO'];
        else
            return 0;
 	}
	
	////////////////////////////////////////////
	public function actualizarMatricula($datos,$idMatricula) 
	{
        $this->db->where('ID_MATRICULA', $idMatricula);
        $this->db->update('acad_matricula', $datos);
    }
	
	//////////////////////////////////////////////////////////////
	public function verificaDocenteOcupadoExterno($nro_documento,$fecha_tutoria)
	{
		$sql = "select p.*";
		$sql .= " from acad_planificacion p";
		$sql .= " join tab_clientes_naturales cn on cn.ID_PERSONA=p.ID_PERSONA";
		$sql .= " join tab_clientes c on c.ID_CLIENTE=cn.ID_CLIENTE";
		$sql .= " where c.NRO_DOCUMENTO='".$nro_documento."'";
		$sql .= " and (p.FECHA_TUTORIA1='".$fecha_tutoria."' or p.FECHA_TUTORIA2='".$fecha_tutoria."' or p.FECHA_TUTORIA3='".$fecha_tutoria."' or p.FECHA_TUTORIA4='".$fecha_tutoria."' or p.FECHAS_TUTORIA like '%".$fecha_tutoria."%')";
		$query = $this->db->query($sql);
		$ds = $query->result_array();
		$ocupado=0;
		if(count($ds)>0){
			$ocupado=1;
		}
		return $ocupado;
	}
	
	//////////////////////////////////////////////////////////////
	public function get_informe($data)
	{
		//codigo adicional para obtener todos los id_grupo con el mismo nombre
		$id_grupos=array();
		if(isset($data['ID_GRUPO']) and $data['ID_GRUPO']!=''){
			$this->db->select('*');
			$this->db->from('acad_grupo');
			$this->db->where('ID_GRUPO',$data['ID_GRUPO']);
			$query = $this->db->get();
			$g = $query->row_array();
			
			$this->db->select('*');
			$this->db->from('acad_grupo');
			$this->db->where('NOMBRE',$g['NOMBRE']);
			$query = $this->db->get();
			$grupos = $query->result_array(); 
			foreach($grupos as $g){
				$id_grupos[]=$g['ID_GRUPO'];
			}
		}
		//codigo adicional para obtener todos los id_materia con el mismo nombre
		$id_materias=array();
		if(isset($data['ID_MATERIA']) and $data['ID_MATERIA']!=''){
			$this->db->select('*');
			$this->db->from('acad_materia');
			$this->db->where('ID_MATERIA',$data['ID_MATERIA']);
			$query = $this->db->get();
			$m = $query->row_array(); 
			
			$this->db->select('*');
			$this->db->from('acad_materia');
			$this->db->where('NOMBRE',$m['NOMBRE']);
			$query = $this->db->get();
			$materias = $query->result_array(); 
			foreach($materias as $m){
				$id_materias[]=$m['ID_MATERIA'];
			}
		}
		$this->db->select('*');
		$this->db->from('acad_informe');
		if(isset($data['ID_INFORME']) and $data['ID_INFORME']!=''){
			$this->db->where('ID_INFORME',$data['ID_INFORME']);
		}
		if(isset($data['ID_PERIODO_ACADEMICO']) and $data['ID_PERIODO_ACADEMICO']!=''){
			$this->db->where('ID_PERIODO_ACADEMICO',$data['ID_PERIODO_ACADEMICO']);
		}
		if(isset($data['ID_MATERIA']) and $data['ID_MATERIA']!=''){
			if(isset($data['TIPO']) and $data['TIPO']==1){//para reporte informe
				$this->db->where_in('ID_MATERIA',$id_materias);
			}else{//pare registro informe
				$this->db->where('ID_MATERIA',$data['ID_MATERIA']);
			}
		}
		if(isset($data['ID_GRUPO']) and $data['ID_GRUPO']!=''){
			if(isset($data['TIPO']) and $data['TIPO']==1){//para reporte informe
				$this->db->where_in('ID_GRUPO',$id_grupos);
			}else{//pare registro informe
				$this->db->where('ID_GRUPO',$data['ID_GRUPO']);
			}
		}
		if(isset($data['ID_PLANTILLA']) and $data['ID_PLANTILLA']!=''){
			$this->db->where('ID_PLANTILLA',$data['ID_PLANTILLA']);
		}
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	////////////////////////////////////////////////////////////
	public function crearInforme($datos)
	{   
		$this->db->insert('acad_informe',$datos);
		return $this->db->insert_id();
	}
	
	/////////////////////////////////////////////////////////////
	public function actualizarInforme($datos,$idInforme)
	{
		$this->db->where('ID_INFORME', $idInforme);
		$this->db->update('acad_informe', $datos);
		return $this->db->affected_rows();
	}
	
	////////////////////////////////////////////////////////////
	public function crearTema($datos)
	{   
		$this->db->insert('acad_informe_tema',$datos);
		return $this->db->insert_id();
	}
	
	/////////////////////////////////////////////////////////////
	public function actualizarTema($datos,$idInformeTema)
	{
		$this->db->where('ID_INFORME_TEMA', $idInformeTema);
		$this->db->update('acad_informe_tema', $datos);
		return $this->db->affected_rows();
	}
	
	////////////////////////////////////////////////////////////
	public function crearSubtema($datos)
	{   
		$this->db->insert('acad_informe_subtema',$datos);
		return $this->db->insert_id();
	}
	
	/////////////////////////////////////////////////////////////
	public function actualizarSubtema($datos,$idInformeSubtema)
	{
		$this->db->where('ID_INFORME_SUBTEMA', $idInformeSubtema);
		$this->db->update('acad_informe_subtema', $datos);
		return $this->db->affected_rows();
	}
	
	//////////////////////////////////////////////////////////////
	public function get_tema($idInforme)
	{
		$this->db->select('*');
		$this->db->from('acad_informe_tema');
		$this->db->where('ID_INFORME',$idInforme);
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	//////////////////////////////////////////////////////////////
	public function get_subtema($idInformeTema)
	{
		$this->db->select('*');
		$this->db->from('acad_informe_subtema');
		$this->db->where('ID_INFORME_TEMA',$idInformeTema);
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	/////////////////////////////////////////////////////////////////
	public function borrarInformeTema($idInformeTema)
	{
		$this->db->where('ID_INFORME_TEMA', $idInformeTema);
		$this->db->delete('acad_informe_tema'); 
	}
	
	/////////////////////////////////////////////////////////////////
	public function borrarInformeSubtema($idInformeSubtema)
	{
		$this->db->where('ID_INFORME_SUBTEMA', $idInformeSubtema);
		$this->db->delete('acad_informe_subtema'); 
	}
	
	////////////////////////////////////////////////
	public function get_fechas_cierre($data) 
	{
		$this->db->select("*");
		$this->db->from('acad_cierre_calificacion');
		if(isset($data['ID_PERIODO_ACADEMICO']) and $data['ID_PERIODO_ACADEMICO']!=''){
			$this->db->where('ID_PERIODO_ACADEMICO',$data['ID_PERIODO_ACADEMICO']);
		}
		if(isset($data['GRUPO']) and $data['GRUPO']!=''){
			$this->db->where('GRUPO',$data['GRUPO']);
		}
		if(isset($data['ID_MATERIA']) and $data['ID_MATERIA']!=''){
			$this->db->where('ID_MATERIA',$data['ID_MATERIA']);
		}
		if(isset($data['MATERIA']) and $data['MATERIA']!=''){
			$this->db->where('MATERIA',$data['MATERIA']);
		}
		if(isset($data['ID_GRUPO']) and $data['ID_GRUPO']!=''){
			$this->db->where('ID_GRUPO',$data['ID_GRUPO']);
		}
		if(isset($data['FECHA_CIERRE']) and $data['FECHA_CIERRE']!=''){
			$this->db->where('FECHA_CIERRE',$data['FECHA_CIERRE']);
		}
		$query = $this->db->get();
		$ds = $query->result_array(); 
		return $ds;
	}
	
	//////////////////////////////////////////////////////
	public function crearLogInscripcionVlc($data)
	{
		//$this->db->insert('tab_log_inscripcion_vlc', $data);
		$this->db->insert('tab_log_send_vlc', $data);
		return $this->db->insert_id();
	}
	
	public function buscar_alumno_materia($data)
	{
		$this->db->select("c.NRO_DOCUMENTO, p.ID_PERSONA, CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as ESTUDIANTE, ecm.ID_GRUPO, ecm.NIVEL_MATERIA, ecm.ID_PERIODO_ACADEMICO, ecm.ID_CARRERA, c.ID_CLIENTE, car.NOMBRE as CARRERA, ecm.ID_PERIODO_ACADEMICO, mat.NOMBRE as MATERIA, aj.ID_ASISTENCIA_JUSTIFICACION, aj.ESTADO, ecm.ASISTENCIA_JUSTIFICADA, ecm.ID_ESTUDIANTE_CARRERA_MATERIA",false);
		$this->db->from('acad_estudiante_carrera_materia ecm');
		$this->db->join('tab_personas p', 'p.ID_PERSONA = ecm.ID_PERSONA');
		$this->db->join('acad_carrera car', 'car.ID_CARRERA = ecm.ID_CARRERA');
		$this->db->join('tab_clientes_naturales cn', 'cn.ID_PERSONA = p.ID_PERSONA');
		$this->db->join('tab_clientes c', 'c.ID_CLIENTE= cn.ID_CLIENTE');
		$this->db->join('acad_materia mat', 'mat.ID_MATERIA= ecm.ID_CARRERA_MATERIA');
		$this->db->join('acad_asistencia_justificacion aj', 'aj.ID_ESTUDIANTE_CARRERA_MATERIA= ecm.ID_ESTUDIANTE_CARRERA_MATERIA','left');
		$this->db->where('ecm.ID_PERIODO_ACADEMICO',$data['id_periodo_academico']);
		if(isset($data['id_carrera']) and $data['id_carrera']!=NULL and $data['id_carrera']!=''){
			$this->db->where('ecm.ID_CARRERA',$data['id_carrera']);
		}
		if(isset($data['id_nivel']) and $data['id_nivel']!=NULL and $data['id_nivel']!=''){
			$this->db->where('ecm.NIVEL_MATERIA',$data['id_nivel']);
		}
		if(isset($data['id_nivel_mayor']) and $data['id_nivel_mayor']!=NULL and $data['id_nivel_mayor']!=''){
			$this->db->where('ecm.NIVEL_MATERIA>',$data['id_nivel_mayor']);
		}
		if(isset($data['ap']) and $data['ap']!=NULL and $data['ap']!=''){
			$this->db->where('p.APELLIDO_PATERNO like','%'.$data['ap'].'%');
		}
		if(isset($data['am']) and $data['am']!=NULL and $data['am']!=''){
			$this->db->where('p.APELLIDO_MATERNO like','%'.$data['am'].'%');
		}
		if(isset($data['pn']) and $data['pn']!=NULL and $data['pn']!=''){
			$this->db->where('p.PRIMER_NOMBRE like','%'.$data['pn'].'%');
		}
		if(isset($data['sn']) and $data['sn']!=NULL and $data['sn']!=''){
			$this->db->where('p.SEGUNDO_NOMBRE like','%'.$data['sn'].'%');
		}
		if(isset($data['nd']) and $data['nd']!=NULL and $data['nd']!=''){
			$this->db->where('c.NRO_DOCUMENTO like','%'.$data['nd'].'%');
		}
		if(isset($data['ID_PERSONA']) and $data['ID_PERSONA']!=NULL and $data['ID_PERSONA']!=''){
			$this->db->where('ecm.ID_PERSONA',$data['ID_PERSONA']);
		}
		if(isset($data['estado']) and $data['estado']!=NULL and $data['estado']!=''){
			if($data['estado']==1){
				$this->db->where('(ecm.ASISTENCIA_JUSTIFICADA=1 or aj.ESTADO=1)');
			}else{
				$this->db->where('aj.ESTADO',$data['estado']);
			}
		}
		if(isset($data['justificando']) and $data['justificando']==1){
			$this->db->where('(ecm.ASISTENCIA_JUSTIFICADA=1 or ecm.ID_ESTUDIANTE_CARRERA_MATERIA in (select ID_ESTUDIANTE_CARRERA_MATERIA from acad_asistencia_justificacion))');
		}
		//$this->db->group_by("p.ID_PERSONA","asc");
		$query = $this->db->get();
		$ds = $query->result_array();
		$ds_filtrado=array();
		$i=0;
		foreach($ds as $key=>$row){//asigno el dato de grupo de cada alumno
			$ds[$key]['GRUPO']=$this->get_grupo_asignado($row['ID_CLIENTE'], $row['ID_CARRERA'], $row['ID_PERIODO_ACADEMICO'], $row['NIVEL_MATERIA']);
			if($data['grupo'] !=null and $data['grupo']==$ds[$key]['GRUPO']){
				$ds_filtrado[$i]=$ds[$key];
				$i++;
			}
		}
		if($data['grupo'] !=null){
			$ds=$ds_filtrado;
		}
		if(count($ds)>0)
			return $ds;
		else
			return false;
	}
	
	/////////////////////////////////////////////////////////////////////////////
	public function get_justificacion($id_estudiante_carrera_materia)
	{
		$sql="select aj.*, CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as ESTUDIANTE, c.NOMBRE as CARRERA, m.NOMBRE as MATERIA";
		$sql.=" from acad_asistencia_justificacion aj";
		$sql.=" join acad_estudiante_carrera_materia ecm on ecm.ID_ESTUDIANTE_CARRERA_MATERIA=aj.ID_ESTUDIANTE_CARRERA_MATERIA";
		$sql.=" join tab_personas p on p.ID_PERSONA=ecm.ID_PERSONA";
		$sql.=" join acad_carrera c on c.ID_CARRERA=ecm.ID_CARRERA";
		$sql.=" join acad_materia m on m.ID_MATERIA=ecm.ID_CARRERA_MATERIA";
		$sql.=" where aj.ID_ESTUDIANTE_CARRERA_MATERIA=".$id_estudiante_carrera_materia;
		$query = $this->db->query($sql);
		$ds = $query->row_array(); 
		return $ds;
	}
	
	//////////////////////////////////
	public function crearJustificacionAsistencia($datos) 
	{
		$this->db->insert('acad_asistencia_justificacion', $datos);
		return $this->db->insert_id();
	}
	
	///////////////////////////////////////////////////////////////////////
	public function actualizarJustificacionAsistencia($datos,$id_asistencia_justificacion) 
	{
		$this->db->where('ID_ASISTENCIA_JUSTIFICACION', $id_asistencia_justificacion);
		$this->db->update('acad_asistencia_justificacion', $datos);
	}
	
	/////////////////////////////////////////////////////////////////////
	/*public function get_matricula_nroDocumento($nroDocumento) 
	{
		$id_periodo=$this->get_periodo_activado();
		$sql = "select m.*, car.NOMBRE as CARRERA, CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as ESTUDIANTE";
		$sql .= " from acad_matricula m";
		$sql .= " inner join tab_personas p on p.ID_PERSONA = m.ID_PERSONA ";
		$sql .= " inner join tab_clientes_naturales cn on cn.ID_PERSONA = m.ID_PERSONA ";
		$sql .= " inner join tab_clientes c on c.ID_CLIENTE = cn.ID_CLIENTE ";
		$sql .= " inner join acad_carrera car on car.ID_CARRERA = m.ID_CARRERA";
		$sql .= " where m.ID_PERIODO_ACADEMICO=".$id_periodo." and c.NRO_DOCUMENTO='".$nroDocumento."'";
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		return $ds;
	}*/
	
	/////////////////////////////////////////////////////////////////////
	public function get_matricula_nroDocumento($nroDocumento, $id_periodo = 0)
	{
	    if($id_periodo == 0){
            $id_periodo=$this->get_periodo_activado();
        }

		$sql = "select m.*, car.NOMBRE as CARRERA, CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as ESTUDIANTE";
		$sql .= " from acad_matricula  m";
		$sql .= " inner join tab_personas p on p.ID_PERSONA = m.ID_PERSONA ";
		$sql .= " inner join tab_clientes_naturales cn on cn.ID_PERSONA = m.ID_PERSONA ";
		$sql .= " inner join tab_clientes c on c.ID_CLIENTE = cn.ID_CLIENTE ";
		$sql .= " inner join acad_carrera car on car.ID_CARRERA = m.ID_CARRERA";
        $sql .= " where c.NRO_DOCUMENTO='".$nroDocumento."'";

		if($id_periodo != null and $id_periodo > 0){
            $sql .= " and m.ID_PERIODO_ACADEMICO=".$id_periodo;
        }elseif ($id_periodo < 0){
		    $sql .= " order by m.ID_MATRICULA desc";
        }

		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		return $ds;
	}
	
	/////////////////////////////////////////////////////////////////////////////////
	public function buscar_matricula($datos)
	{
		$this->db->select('m.*,c.NOMBRE as CARRERA,cn.ID_CLIENTE,cli.NRO_DOCUMENTO');
		$this->db->from('acad_matricula m');
		$this->db->join('tab_clientes_naturales cn','cn.ID_PERSONA=m.ID_PERSONA');
		$this->db->join('tab_clientes cli','cli.ID_CLIENTE=cn.ID_CLIENTE');
		$this->db->join('acad_carrera c','c.ID_CARRERA=m.ID_CARRERA');
		if(isset($datos['ID_PERIODO_ACADEMICO']) and $datos['ID_PERIODO_ACADEMICO']!=''){
			$this->db->where('m.ID_PERIODO_ACADEMICO',$datos['ID_PERIODO_ACADEMICO']);
		}
		if(isset($datos['ID_CLIENTE']) and $datos['ID_CLIENTE']!=''){
			$this->db->where('cn.ID_CLIENTE',$datos['ID_CLIENTE']);
		}
		if(isset($datos['ID_CARRERA']) and $datos['ID_CARRERA']!=''){
			$this->db->where('m.ID_CARRERA',$datos['ID_CARRERA']);
		}
		if(isset($datos['ID_PERSONA']) and $datos['ID_PERSONA']!=''){
			$this->db->where('m.ID_PERSONA',$datos['ID_PERSONA']);
		}
		if(isset($datos['ESTADO']) and $datos['ESTADO']!=''){
			$this->db->where('m.ESTADO',$datos['ESTADO']);
		}
		if(isset($datos['ID_MATRICULA']) and $datos['ID_MATRICULA']!=''){
			$this->db->where('m.ID_MATRICULA',$datos['ID_MATRICULA']);
		}
		if(isset($datos['NRO_DOCUMENTO']) and $datos['NRO_DOCUMENTO']!=''){
			$this->db->where('cli.NRO_DOCUMENTO',$datos['NRO_DOCUMENTO']);
		}
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	//////////////////////////////////////////////////////////////////
	public function url_vlc_supletorio_crear()
	{
		$this->db->select('DESCRIPCION');
		$this->db->from('acad_parametro');
		$this->db->where('NOMBRE', 'url_vlc_supletorio_crear');
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds['DESCRIPCION'];
	}
	
	//////////////////////////////////////////////////////////////////
	public function url_vlc_supletorio_eliminar()
	{
		$this->db->select('DESCRIPCION');
		$this->db->from('acad_parametro');
		$this->db->where('NOMBRE', 'url_vlc_supletorio_eliminar');
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds['DESCRIPCION'];
	}
	
	///////////////////////////////////////////////////////////////////////
	public function actualizar_estudiante_supletorio($datos,$idEstudianteCarreraMateria) 
	{
		$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA', $idEstudianteCarreraMateria);
		$this->db->update('acad_estudiante_supletorio', $datos);
	}
	
	//////////////////////////////////////////////////////////////////
	public function get_estudiante_supletorio($idEstudianteCarreraMateria)
	{
		$this->db->select('*');
		$this->db->from('acad_estudiante_supletorio');
		$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA', $idEstudianteCarreraMateria);
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds;
	}
	
	//////////////////////////////////
	public function crear_estudiante_supletorio($datos) 
	{
		$this->db->insert('acad_estudiante_supletorio', $datos);
	}
	
	/////////////////////////////////////////////////////////////////
	public function borrar_estudiante_supletorio($idEstudianteCarreraMateria)
	{
		$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA', $idEstudianteCarreraMateria);
		$this->db->delete('acad_estudiante_supletorio'); 
	}
	
	////////////////////////////////////////////////////////////////////////////
	public function buscar_alumno_supletorio($data)
	{
		$this->db->select("c.NRO_DOCUMENTO, p.ID_PERSONA, CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as ESTUDIANTE, ecm.ID_GRUPO, ecm.NIVEL_MATERIA, ecm.ID_PERIODO_ACADEMICO, ecm.ID_CARRERA, c.ID_CLIENTE, car.NOMBRE as CARRERA, ecm.ID_PERIODO_ACADEMICO, mat.NOMBRE as MATERIA, es.ID_SUPLETORIO_VLC, es.ID_REMEDIAL_VLC, es.FECHA_REMEDIAL, ecm.ID_ESTUDIANTE_CARRERA_MATERIA, cal.ESTADO_CALIFICACION",false);
		$this->db->from('acad_estudiante_carrera_materia ecm');
		$this->db->join('tab_personas p', 'p.ID_PERSONA = ecm.ID_PERSONA');
		$this->db->join('acad_carrera car', 'car.ID_CARRERA = ecm.ID_CARRERA');
		$this->db->join('tab_clientes_naturales cn', 'cn.ID_PERSONA = p.ID_PERSONA');
		$this->db->join('tab_clientes c', 'c.ID_CLIENTE= cn.ID_CLIENTE');
		$this->db->join('acad_materia mat', 'mat.ID_MATERIA= ecm.ID_CARRERA_MATERIA');
		$this->db->join('acad_estudiante_supletorio es', 'es.ID_ESTUDIANTE_CARRERA_MATERIA= ecm.ID_ESTUDIANTE_CARRERA_MATERIA');
		$this->db->join('acad_calificacion cal', 'cal.ID_ESTUDIANTE_CARRERA_MATERIA= ecm.ID_ESTUDIANTE_CARRERA_MATERIA');
		$this->db->where('ecm.ID_PERIODO_ACADEMICO',$data['id_periodo_academico']);
		$this->db->where('cal.ID_TIPO_CALIFICACION',6);//calificacion final total
		if(isset($data['id_carrera']) and $data['id_carrera']!=NULL and $data['id_carrera']!=''){
			$this->db->where('ecm.ID_CARRERA',$data['id_carrera']);
		}
		if(isset($data['id_nivel']) and $data['id_nivel']!=NULL and $data['id_nivel']!=''){
			$this->db->where('ecm.NIVEL_MATERIA',$data['id_nivel']);
		}
		if(isset($data['id_nivel_mayor']) and $data['id_nivel_mayor']!=NULL and $data['id_nivel_mayor']!=''){
			$this->db->where('ecm.NIVEL_MATERIA>',$data['id_nivel_mayor']);
		}
		if(isset($data['ap']) and $data['ap']!=NULL and $data['ap']!=''){
			$this->db->where('p.APELLIDO_PATERNO like','%'.$data['ap'].'%');
		}
		if(isset($data['am']) and $data['am']!=NULL and $data['am']!=''){
			$this->db->where('p.APELLIDO_MATERNO like','%'.$data['am'].'%');
		}
		if(isset($data['pn']) and $data['pn']!=NULL and $data['pn']!=''){
			$this->db->where('p.PRIMER_NOMBRE like','%'.$data['pn'].'%');
		}
		if(isset($data['sn']) and $data['sn']!=NULL and $data['sn']!=''){
			$this->db->where('p.SEGUNDO_NOMBRE like','%'.$data['sn'].'%');
		}
		if(isset($data['nd']) and $data['nd']!=NULL and $data['nd']!=''){
			$this->db->where('c.NRO_DOCUMENTO like','%'.$data['nd'].'%');
		}
		if(isset($data['ID_PERSONA']) and $data['ID_PERSONA']!=NULL and $data['ID_PERSONA']!=''){
			$this->db->where('ecm.ID_PERSONA',$data['ID_PERSONA']);
		}
		//$this->db->group_by("p.ID_PERSONA","asc");
		$query = $this->db->get();
		$ds = $query->result_array();
		$ds_filtrado=array();
		$i=0;
		foreach($ds as $key=>$row){//asigno el dato de grupo de cada alumno
			$ds[$key]['GRUPO']=$this->get_grupo_asignado($row['ID_CLIENTE'], $row['ID_CARRERA'], $row['ID_PERIODO_ACADEMICO'], $row['NIVEL_MATERIA']);
			if($data['grupo'] !=null and $data['grupo']==$ds[$key]['GRUPO']){
				$ds_filtrado[$i]=$ds[$key];
				$i++;
			}
		}
		if($data['grupo'] !=null){
			$ds=$ds_filtrado;
		}
		if(count($ds)>0)
			return $ds;
		else
			return false;
	}
	
	//////////////////////////////////////////////////////////////////
	public function url_vlc_remedial_crear()
	{
		$this->db->select('DESCRIPCION');
		$this->db->from('acad_parametro');
		$this->db->where('NOMBRE', 'url_vlc_remedial_crear');
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds['DESCRIPCION'];
	}
	
	//////////////////////////////////////////////////////////////////
	public function url_vlc_remedial_eliminar()
	{
		$this->db->select('DESCRIPCION');
		$this->db->from('acad_parametro');
		$this->db->where('NOMBRE', 'url_vlc_remedial_eliminar');
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds['DESCRIPCION'];
	}
	
	////////////////////////////////////////////////
	public function buscar_plantillas($data = array()) 
	{
		$this->db->select('*');
		$this->db->from('acad_plantillas');
		if(isset($data['PLANTILLA']) and $data['PLANTILLA'] != ''){
			$this->db->where('PLANTILLA like', '%'.$data['PLANTILLA'].'%');
		}
		if(isset($data['ID_PLANTILLA']) and $data['ID_PLANTILLA'] != ''){
			$this->db->where('ID_PLANTILLA', $data['ID_PLANTILLA']);
		}
		if(isset($data['ID_USUARIO']) and $data['ID_USUARIO'] != ''){
			$this->db->where('ID_USUARIO', $data['ID_USUARIO']);
		}
		$this->db->order_by('PLANTILLA'); 
		$consulta = $this->db->get();
		$resultado = $consulta->result_array();
		return $resultado;
	}
	
	////////////////////////////////////////////////
	public function numPlantillaPreguntas($idPlantilla) 
	{
		$this->db->where('ID_PLANTILLA', $idPlantilla);
		$this->db->from('acad_preguntas');
		return $this->db->count_all_results();
	}
	
	//////////////////////////////////
	public function crearPlantilla($datos) 
	{
		$this->db->insert('acad_plantillas', $datos);
		return $this->db->insert_id();
	}
	
	/////////////////////////////////////////////////////////////////////////
	public function actualizarPlantilla($datos,$idPlantilla) 
	{
		$this->db->where('ID_PLANTILLA', $idPlantilla);
		$this->db->update('acad_plantillas', $datos);
	}
	
	///////////////////////////////////////////////////////////////////
	public function getPreguntas($data=array())
	{
		$this->db->select('*');
		$this->db->from('acad_preguntas');
		if(isset($data['ID_PLANTILLA']) and $data['ID_PLANTILLA']!=''){
			$this->db->where('ID_PLANTILLA',$data['ID_PLANTILLA']);
		}
		$query = $this->db->get();
		$ds    = $query->result_array();
		return $ds;
	}
	
	///////////////////////////////////////////////////////////////////
	public function getOpcionesRespuesta($data=array()) 
	{
		$this->db->select('*');
		$this->db->from('acad_opciones_respuesta');
		if(isset($data['ID_PREGUNTA']) and $data['ID_PREGUNTA']!=''){
			$this->db->where('ID_PREGUNTA',$data['ID_PREGUNTA']);
		}
		if(isset($data['ID_PLANTILLA']) and $data['ID_PLANTILLA']!=''){
			$this->db->where('ID_PREGUNTA in (select ID_PREGUNTA from acad_preguntas where ID_PLANTILLA='.$data['ID_PLANTILLA'].')');
		}
		$query = $this->db->get();
		$ds    = $query->result_array();
		return $ds;
	}
	
	/////////////////////////////////////////////////////////////////////////
	public function actualizarPregunta($datos,$idPregunta) 
	{
		$this->db->where('ID_PREGUNTA', $idPregunta);
		$this->db->update('acad_preguntas', $datos);
	}
	
	//////////////////////////////////
	public function crearPregunta($datos) 
	{
		$this->db->insert('acad_preguntas', $datos);
		return $this->db->insert_id();
	}
	
	/////////////////////////////////////////////////////////////////////////
	public function actualizarOpcionesRespuesta($datos,$idOpcionRespuesta) 
	{
		$this->db->where('ID_OPCION_RESPUESTA', $idOpcionRespuesta);
		$this->db->update('acad_opciones_respuesta', $datos);
	}
	
	//////////////////////////////////
	public function crearOpcionesRespuesta($datos) 
	{
		$this->db->insert('acad_opciones_respuesta', $datos);
		return $this->db->insert_id();
	}
	
	/////////////////////////////////////////////////////////////////
	public function borrarPregunta($idPregunta)
	{
		$this->db->where('ID_PREGUNTA', $idPregunta);
		$this->db->delete('acad_preguntas'); 
	}
	
	/////////////////////////////////////////////////////////////////
	public function borrarOpcionRespuesta($idOpcionRespuesta)
	{
		$this->db->where('ID_OPCION_RESPUESTA', $idOpcionRespuesta);
		$this->db->delete('acad_opciones_respuesta'); 
	}
	
	///////////////////////////////////////////////////////////////////
	public function getRetosProyectos($data) 
	{
		$this->db->select('rp.*');
		$this->db->from('acad_retos_proyectos rp');
		if (isset($data['ID_PLANTILLA']) && $data['ID_PLANTILLA']!="") {
			$this->db->where('rp.ID_PLANTILLA',$data['ID_PLANTILLA']);
		}
		if (isset($data['TIPO']) && $data['TIPO']!="") {
			$this->db->where('rp.TIPO',$data['TIPO']);
		}
		$query = $this->db->get();
		$ds    = $query->result_array();
		return $ds;
	}
	
	///////////////////////////////////////////////////////////////////
	public function getPreguntasRetos($data=array())
	{
		$this->db->select('*');
		$this->db->from('acad_preguntas_retos');
		if(isset($data['ID_RETO']) and $data['ID_RETO']!=''){
			$this->db->where('ID_RETO',$data['ID_RETO']);
		}
		$query = $this->db->get();
		$ds    = $query->result_array();
		return $ds;
	}
	
	///////////////////////////////////////////////////////////////////
	public function getOpcionesRespuestaRetos($data=array())
	{
		$this->db->select('*');
		$this->db->from('acad_opciones_respuesta_retos');
		if(isset($data['ID_PREGUNTA_RETO']) and $data['ID_PREGUNTA_RETO']!=''){
			$this->db->where('ID_PREGUNTA_RETO',$data['ID_PREGUNTA_RETO']);
		}
		$query = $this->db->get();
		$ds    = $query->result_array();
		return $ds;
	}
	
	//////////////////////////////////
	public function crearRetoProyecto($datos) 
	{
		$this->db->insert('acad_retos_proyectos', $datos);
		return $this->db->insert_id();
	}
	
	///////////////////////////////////////////////////////////////////////
	public function actualizarRetoProyecto($datos,$idRetoProyecto) 
	{
		$this->db->where('ID_RETO_PROYECTO', $idRetoProyecto);
		$this->db->update('acad_retos_proyectos', $datos);
	}
	
	/////////////////////////////////////////////////////////////////////////
	public function actualizarPreguntaReto($datos,$idPregunta) 
	{
		$this->db->where('ID_PREGUNTA_RETO', $idPregunta);
		$this->db->update('acad_preguntas_retos', $datos);
	}
	
	//////////////////////////////////
	public function crearPreguntaReto($datos) 
	{
		$this->db->insert('acad_preguntas_retos', $datos);
		return $this->db->insert_id();
	}
	
	/////////////////////////////////////////////////////////////////////////
	public function actualizarOpcionesRespuestaReto($datos,$idOpcionRespuesta) 
	{
		$this->db->where('ID_OPCION_RESPUESTA_RETO', $idOpcionRespuesta);
		$this->db->update('acad_opciones_respuesta_retos', $datos);
	}
	
	//////////////////////////////////
	public function crearOpcionesRespuestaReto($datos) 
	{
		$this->db->insert('acad_opciones_respuesta_retos', $datos);
		return $this->db->insert_id();
	}
	
	///////////////////////////////////////////////////////////////////
	public function getOpcionRespuestaReto($idOpcionRespuesta)
	{
		$this->db->select('*');
		$this->db->from('acad_opciones_respuesta_retos');
		$this->db->where('ID_OPCION_RESPUESTA_RETO', $idOpcionRespuesta);
		$query = $this->db->get();
		$ds    = $query->row_array();
		return $ds;
	}
	
	///////////////////////////////////////////////////////////////////
	public function getPreguntaReto($idPreguntaReto)
	{
		$this->db->select('*');
		$this->db->from('acad_preguntas_retos');
		$this->db->where('ID_PREGUNTA_RETO', $idPreguntaReto);
		$query = $this->db->get();
		$ds    = $query->row_array();
		return $ds;
	}
	
	/////////////////////////////////////////////////////////////////
	public function borrarPreguntaReto($idPregunta)
	{
		$this->db->where('ID_PREGUNTA_RETO', $idPregunta);
		$this->db->delete('acad_preguntas_retos'); 
	}
	
	/////////////////////////////////////////////////////////////////
	public function borrarOpcionRespuestaReto($idOpcionRespuesta)
	{
		$this->db->where('ID_OPCION_RESPUESTA_RETO', $idOpcionRespuesta);
		$this->db->delete('acad_opciones_respuesta_retos'); 
	}
	
	////////////////////////////////////////////////
	public function numRetosPreguntas($idReto) 
	{
		$this->db->where('ID_RETO', $idReto);
		$this->db->from('acad_preguntas_retos');
		return $this->db->count_all_results();
	}
	
	///////////////////////////////////////////////////////////////////
	public function getRetoProyecto($idRetoProyecto)
	{
		$this->db->select('rp.*');
		$this->db->from('acad_retos_proyectos rp');
		$this->db->where('rp.ID_RETO_PROYECTO',$idRetoProyecto);
		$query = $this->db->get();
		$ds    = $query->row_array();
		return $ds;
	}
	
	//////////////////////////////////////////////////////
	public function eliminarRetoProyecto($id_retoProyecto)
	{
		$this->db->where('ID_RETO_PROYECTO', $id_retoProyecto);
		$this->db->delete('acad_retos_proyectos');
	}
	
	////////////////////////////////////////////////
	public function numPlantillaRetos($idPlantilla) 
	{
		$this->db->where('ID_PLANTILLA', $idPlantilla);
		$this->db->where('TIPO', 0);
		$this->db->from('acad_retos_proyectos');
		return $this->db->count_all_results();
	}
	
	////////////////////////////////////////////////
	public function numPlantillaProyectos($idPlantilla) 
	{
		$this->db->where('ID_PLANTILLA', $idPlantilla);
		$this->db->where('TIPO', 1);
		$this->db->from('acad_retos_proyectos');
		return $this->db->count_all_results();
	}
	
	///////////////////////////////////////////////////////////////////
	public function get_unidad_organizacional() 
	{
		$this->db->select('*');
		$this->db->from('tab_unidad_organizacional');
		$query = $this->db->get();
		$ds    = $query->result_array();
		return $ds;
	}
	
	////////////////////////////////////////////////
	public function buscar_contenidos($data = array()) 
	{
		$this->db->select('*');
		$this->db->from('acad_contenidos');
		if(isset($data['CONTENIDO']) and $data['CONTENIDO'] != ''){
			$this->db->where('CONTENIDO like', '%'.$data['CONTENIDO'].'%');
		}
		if(isset($data['ID_CONTENIDO']) and $data['ID_CONTENIDO'] != ''){
			$this->db->where('ID_CONTENIDO', $data['ID_CONTENIDO']);
		}
		if(isset($data['ID_PLANTILLA']) and $data['ID_PLANTILLA'] != ''){
			$this->db->where('ID_PLANTILLA', $data['ID_PLANTILLA']);
		}
		if(isset($data['ID_PERIODO_ACADEMICO']) and $data['ID_PERIODO_ACADEMICO'] != ''){
			$this->db->where('ID_PERIODO_ACADEMICO', $data['ID_PERIODO_ACADEMICO']);
		}
		$this->db->order_by('CONTENIDO'); 
		$consulta = $this->db->get();
		$resultado = $consulta->result_array();
		return $resultado;
	}
	
	//////////////////////////////////
	public function crear_contenido($datos) 
	{
		$this->db->insert('acad_contenidos', $datos);
		return $this->db->insert_id();
	}
	
	public function actualizarContenido($datos,$idContenido) 
	{
		$this->db->where('ID_CONTENIDO', $idContenido);
		$this->db->update('acad_contenidos', $datos);
	}
	
	//////////////////////////////////
	public function crearPreguntaContenido($datos) 
	{
		$this->db->insert('acad_preguntas_contenido', $datos);
		return $this->db->insert_id();
	}
	
	//////////////////////////////////
	public function crearOpcionesRespuestaContenido($datos) 
	{
		$this->db->insert('acad_opciones_respuesta_contenido', $datos);
		return $this->db->insert_id();
	}
	
	/////////////////////////////////////////////////////////////////////////
	public function actualizarPreguntaContenido($datos,$idPreguntaContenido) 
	{
		$this->db->where('ID_PREGUNTA_CONTENIDO', $idPreguntaContenido);
		$this->db->update('acad_preguntas_contenido', $datos);
	}
	
	//////////////////////////////////
	public function crearRetoProyectoContenido($datos) 
	{
		$this->db->insert('acad_retos_proyectos_contenido', $datos);
		return $this->db->insert_id();
	}
	
	//////////////////////////////////
	public function crearPreguntaRetoContenido($datos) 
	{
		$this->db->insert('acad_preguntas_retos_contenido', $datos);
		return $this->db->insert_id();
	}
	
	//////////////////////////////////
	public function crearOpcionesRespuestaRetoContenido($datos) 
	{
		$this->db->insert('acad_opciones_respuesta_retos_contenido', $datos);
		return $this->db->insert_id();
	}
	
	/////////////////////////////////////////////////////////////////////////
	public function actualizarPreguntaRetoContenido($datos,$idPreguntaRetoContenido) 
	{
		$this->db->where('ID_PREGUNTA_RETO_CONTENIDO', $idPreguntaRetoContenido);
		$this->db->update('acad_preguntas_retos_contenido', $datos);
	}
	
	//////////////////////////////////
	public function crearMateriaContenido($datos) 
	{
		$this->db->insert('acad_materia_contenido', $datos);
	}
	
	//////////////////////////////////
	public function getMateriaContenido($idContenido,$idMateria) 
	{
		$this->db->select('*');
		$this->db->from('acad_materia_contenido');
		$this->db->where('ID_CONTENIDO', $idContenido);
		$this->db->where('ID_MATERIA', $idMateria);
		$query = $this->db->get();
		$ds    = $query->row_array();
		return $ds;
	}
	
	//////////////////////////////////////////////
	public function listado_contenido($data) 
	{
		$sql="SELECT pla.*, CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE,p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as DOCENTE, c.NOMBRE as CARRERA, m.NOMBRE as MATERIA, cm.NIVEL_MATERIA, g.NOMBRE as GRUPO";
		$sql.=" FROM acad_planificacion pla";
		$sql.=" join acad_grupo g on g.ID_GRUPO=pla.ID_GRUPO";
		$sql.=" join acad_carrera_materia cm on cm.ID_CARRERA_MATERIA=pla.ID_CARRERA_MATERIA";
		$sql.=" join acad_carrera c on c.ID_CARRERA=cm.ID_CARRERA";
		$sql.=" join acad_materia m on m.ID_MATERIA=cm.ID_CARRERA_MATERIA";
		$sql.=" join tab_personas p on p.ID_PERSONA=pla.ID_PERSONA";
		//$sql.=" LEFT join acad_materia_contenido mcon on mcon.ID_MATERIA=pla.ID_CARRERA_MATERIA";
		//$sql.=" LEFT join acad_contenidos con on con.ID_CONTENIDO=mcon.ID_CONTENIDO and con.ID_PERIODO_ACADEMICO=pla.ID_PERIODO_ACADEMICO";
		$sql.=" where pla.ID_PLANIFICACION>0";		
		if(isset($data['APELLIDO_PATERNO']) and $data['APELLIDO_PATERNO']!=NULL){
			$sql.=" and p.APELLIDO_PATERNO like '%".$data['APELLIDO_PATERNO']."%'";
		}
		if(isset($data['APELLIDO_MATERNO']) and $data['APELLIDO_MATERNO']!=NULL){
			$sql.=" and p.APELLIDO_MATERNO like '%".$data['APELLIDO_MATERNO']."%'";
		}
		if(isset($data['PRIMER_NOMBRE']) and $data['PRIMER_NOMBRE']!=NULL){
			$sql.=" and p.PRIMER_NOMBRE like '%".$data['PRIMER_NOMBRE']."%'";
		}
		if(isset($data['SEGUNDO_NOMBRE']) and $data['SEGUNDO_NOMBRE']!=NULL){
			$sql.=" and p.SEGUNDO_NOMBRE like '%".$data['SEGUNDO_NOMBRE']."%'";
		}
		if(isset($data['ID_PERIODO_ACADEMICO']) and $data['ID_PERIODO_ACADEMICO']!=NULL){
			$sql.=" and pla.ID_PERIODO_ACADEMICO =".$data['ID_PERIODO_ACADEMICO'];
		}
		if(isset($data['ID_CARRERA']) and $data['ID_CARRERA']!=NULL){
			$sql.=" and cm.ID_CARRERA =".$data['ID_CARRERA'];
		}
		if(isset($data['ID_NIVEL']) and $data['ID_NIVEL']!=NULL){
			$sql.=" and cm.NIVEL_MATERIA =".$data['ID_NIVEL'];
		}
		if(isset($data['ID_CARRERA_MATERIA']) and $data['ID_CARRERA_MATERIA']!=NULL){
			$sql.=" and cm.ID_CARRERA_MATERIA =".$data['ID_CARRERA_MATERIA'];
		}
		if(isset($data['ID_PERSONA']) and $data['ID_PERSONA']!=NULL){
			$sql.=" and pla.ID_PERSONA =".$data['ID_PERSONA'];
		}
		if(isset($data['ID_GRUPO']) and $data['ID_GRUPO']!=NULL){
			$sql.=" and g.ID_GRUPO =".$data['ID_GRUPO'];
		}
		if(isset($data['GRUPO']) and $data['GRUPO']!=NULL){
			$sql.=" and g.NOMBRE like '".$data['GRUPO']."'";
		}
		if(isset($data['GRUPOS']) and $data['GRUPOS']!=NULL){
			$sql.=" and g.NOMBRE in (".$data['GRUPOS'].")";
		}
		if(isset($data['ID_PLANIFICACION']) and $data['ID_PLANIFICACION']!=NULL){
			$sql.=" and pla.ID_PLANIFICACION =".$data['ID_PLANIFICACION'];
		}
		if(isset($data['FECHA_CIERRE']) and $data['FECHA_CIERRE']!=NULL){
			$sql.=" and pla.FECHA_CIERRE = '".$data['FECHA_CIERRE']."'";
		}
		if(isset($data['MATERIA']) and $data['MATERIA']!=NULL){
			$sql.=" and m.NOMBRE like '".$data['MATERIA']."'";
		}
		if(isset($data['sin_agrupar']) and $data['sin_agrupar']==1){
		}else{
			$sql.=" group by MATERIA,ID_PLANTILLA,GRUPO ";
		}
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		return $ds;
	}
	
	///////////////////////////////////////////////////////////////////
	public function getContenidoMateria($idMateria,$idPeriodo,$idPlantilla=0)
	{
		$this->db->select('c.*');
		$this->db->from('acad_contenidos c');
		$this->db->join('acad_materia_contenido mc','mc.ID_CONTENIDO=c.ID_CONTENIDO');
		$this->db->where('c.ID_PERIODO_ACADEMICO', $idPeriodo);
		$this->db->where('mc.ID_MATERIA', $idMateria);
		if($idPlantilla>0){
			$this->db->where('c.ID_PLANTILLA', $idPlantilla);
		}
		$query = $this->db->get();
		$ds    = $query->row_array();
		return $ds;
	}
	
	//////////////////////////////////
	public function creaLogGuia($datos) 
	{
		$this->db->insert('acad_log_guia', $datos);
	}
	
	//////////////////////////////////
	public function getLogGuia($idEstudianteCarreraMateria) 
	{
		$this->db->select('*');
		$this->db->from('acad_log_guia');
		$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$idEstudianteCarreraMateria);
		$query = $this->db->get();
		$ds    = $query->row_array();
		return $ds;
	}
	
	///////////////////////////////////////////////////////////////////
	public function getRetosProyectosContenido($data) 
	{
		$this->db->select('rpc.*');
		$this->db->from('acad_retos_proyectos_contenido rpc');
		if(isset($data['ID_CONTENIDO']) && $data['ID_CONTENIDO']!="") {
			$this->db->where('rpc.ID_CONTENIDO',$data['ID_CONTENIDO']);
		}
		if(isset($data['TIPO']) && $data['TIPO']!="") {
			$this->db->where('rpc.TIPO',$data['TIPO']);
		}
		if(isset($data['ID_RETO_PROYECTO_CONTENIDO']) && $data['ID_RETO_PROYECTO_CONTENIDO']!="") {
			$this->db->where('rpc.ID_RETO_PROYECTO_CONTENIDO',$data['ID_RETO_PROYECTO_CONTENIDO']);
		}
		$query = $this->db->get();
		$ds    = $query->result_array();
		return $ds;
	}
	
	////////////////////////////////////////////////
	public function numRetosPreguntasContenido($idRetoContenido) 
	{
		$this->db->where('ID_RETO_CONTENIDO', $idRetoContenido);
		$this->db->from('acad_preguntas_retos_contenido');
		return $this->db->count_all_results();
	}
	
	///////////////////////////////////////////////////////////
	public function buscar_talleres($data){
		// $this->db->select('*');
		// $this->db->from('acad_talleres');
		// if(isset($data['ID_PLANIFICACION']) and $data['ID_PLANIFICACION']!=NULL){
		// 	$this->db->where('ID_PLANIFICACION',$data['ID_PLANIFICACION']);
		// }

		// if(isset($data['ID_TALLER']) and $data['ID_TALLER']!=NULL){
		// 	$this->db->where('ID_TALLER',$data['ID_TALLER']);
		// }
		// $query = $this->db->get();
		// $ds = $query->result_array();
		// return $ds;

		$sql =  "SELECT t.*,p.ID_PLANTILLA ";
		$sql .= " FROM acad_talleres t";
		$sql .= " JOIN acad_planificacion p ON p.ID_PLANIFICACION = t.ID_PLANIFICACION";
		$sql .= " where t.ID_TALLER>0 ";
		if(isset($data['ID_TALLER']) and $data['ID_TALLER']!=NULL){
			$sql .= " AND t.ID_TALLER= ".$data['ID_TALLER'];
		}
		if (isset($data['ID_CARRERA_MATERIA']) && $data['ID_CARRERA_MATERIA'] != "") {
			$sql.=' and p.ID_CARRERA_MATERIA in (select ID_MATERIA from acad_materia where NOMBRE=(select NOMBRE from acad_materia where ID_MATERIA='.$data['ID_CARRERA_MATERIA'].'))';
		}
		if (isset($data['ID_PERIODO_ACADEMICO']) && $data['ID_PERIODO_ACADEMICO'] != "") {
			$sql.=' and p.ID_PERIODO_ACADEMICO='. $data['ID_PERIODO_ACADEMICO'];
		}
		if (isset($data['ID_GRUPO']) && $data['ID_GRUPO'] != "") {
			$sql.=' and p.ID_GRUPO in (select ID_GRUPO from acad_grupo where NOMBRE=(select NOMBRE from acad_grupo where ID_GRUPO='.$data['ID_GRUPO'].'))';
		}
		if (isset($data['ID_PLANTILLA']) && $data['ID_PLANTILLA'] != "") {
			$sql.=' and p.ID_PLANTILLA='. $data['ID_PLANTILLA'];
		}

		$query = $this->db->query($sql);
		// $query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}

	/////////////////////////////////////////////////////////////////////////////
	public function get_docente_carrera_materia_grupo_planificacion($data){
		/*$sql="SELECT dcm.*, concat(SUBSTRING(pa.FECHA_INICIO,1,7),' / ',SUBSTRING(pa.FECHA_FIN,1,7)) as PERIODO, CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE,p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as DOCENTE, c.NOMBRE as CARRERA, m.NOMBRE as MATERIA,g.ID_GRUPO, g.NOMBRE as GRUPO";
		$sql.=" FROM acad_docente_carrera_materia dcm";
		$sql.=" join acad_grupo g on g.ID_CARRERA=dcm.ID_CARRERA and g.ID_NIVEL=dcm.NIVEL_MATERIA";
		$sql.=" join acad_periodo_academico pa on pa.ID_PERIODO_ACADEMICO=dcm.ID_PERIODO_ACADEMICO";
		$sql.=" join acad_carrera c on c.ID_CARRERA=dcm.ID_CARRERA";
		$sql.=" join acad_materia m on m.ID_MATERIA=dcm.ID_CARRERA_MATERIA";
		$sql.=" join tab_personas p on p.ID_PERSONA=dcm.ID_PERSONA";
		$sql.=" where dcm.ID_DOCENTE_CARRERA_MATERIA=".$id_docente_carrera_materia;
		$sql.=" and g.ID_GRUPO=".$id_grupo;
		$query = $this->db->query($sql);
		$ds = $query->row_array();
		return $ds;*/

		

		$sql="SELECT pln.*, concat(SUBSTRING(pa.FECHA_INICIO,1,7),' / ',SUBSTRING(pa.FECHA_FIN,1,7)) as PERIODO, CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE,p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as DOCENTE, c.NOMBRE as CARRERA, m.NOMBRE as MATERIA,g.ID_GRUPO, g.NOMBRE as GRUPO";
		$sql.=" FROM acad_planificacion pln";
		$sql.=" join acad_grupo g on g.ID_GRUPO=pln.ID_GRUPO";
		$sql.=" join acad_periodo_academico pa on pa.ID_PERIODO_ACADEMICO=pln.ID_PERIODO_ACADEMICO";
		$sql.=" join acad_carrera_materia cm on cm.ID_CARRERA_MATERIA = pln.ID_CARRERA_MATERIA";
		$sql.=" join acad_carrera c on c.ID_CARRERA=cm.ID_CARRERA";
		$sql.=" join acad_materia m on m.ID_MATERIA=pln.ID_CARRERA_MATERIA";
		$sql.=" join tab_personas p on p.ID_PERSONA=pln.ID_PERSONA";
		if (isset($data['ID_PLANIFICACION']) && $data['ID_PLANIFICACION'] != "") {
			$sql.=" where pln.ID_PLANIFICACION=".$data['ID_PLANIFICACION'];
		}

		$query = $this->db->query($sql);
		$ds = $query->row_array();
		return $ds;
	}

	/////////////////////////////////////////////////////////////////////////////
	public function get_estudiantes($data)
	{
		$sql ="SELECT CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO, p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as ESTUDIANTE, p.ID_PERSONA, ecm.ID_ESTUDIANTE_CARRERA_MATERIA, ecm.ASISTENCIA_JUSTIFICADA";
		$sql.=' from acad_estudiante_carrera_materia ecm ';
		$sql.=' join tab_personas p ON p.ID_PERSONA = ecm.ID_PERSONA ';
		$sql.=' join acad_matricula m ON m.ID_PERSONA = ecm.ID_PERSONA and m.ID_PERIODO_ACADEMICO=ecm.ID_PERIODO_ACADEMICO and m.ID_CARRERA=ecm.ID_CARRERA';
		if (isset($data['ID_USUARIO_ACADEMICO']) && $data['ID_USUARIO_ACADEMICO'] != "") {
			$sql.=' join admin_usuarios u ON u.ID_PERSONA = ecm.ID_PERSONA';
			$sql.=' join acad_asesor_estudiante ae ON ae.ID_USUARIO_ESTUDIANTE = u.ID_USUARIO and ae.ID_USUARIO_ACADEMICO='.$data['ID_USUARIO_ACADEMICO'];
		}
		$sql.=' where ecm.ID_ESTUDIANTE_CARRERA_MATERIA>0 and m.ESTADO=0 ';
		if (isset($data['ID_CARRERA_MATERIA']) && $data['ID_CARRERA_MATERIA'] != "") {
			//$sql.=' and ecm.ID_CARRERA_MATERIA='. $data['ID_CARRERA_MATERIA'];
			$sql.=' and ecm.ID_CARRERA_MATERIA in (select ID_MATERIA from acad_materia where NOMBRE=(select NOMBRE from acad_materia where ID_MATERIA='.$data['ID_CARRERA_MATERIA'].'))';
		}
		if (isset($data['ID_PERIODO_ACADEMICO']) && $data['ID_PERIODO_ACADEMICO'] != "") {
			$sql.=' and ecm.ID_PERIODO_ACADEMICO='. $data['ID_PERIODO_ACADEMICO'];
		}
		if (isset($data['ID_GRUPO']) && $data['ID_GRUPO'] != "") {
			//$sql.=' and ecm.ID_GRUPO='. $data['ID_GRUPO'];
			$sql.=' and ecm.ID_GRUPO in (select ID_GRUPO from acad_grupo where NOMBRE=(select NOMBRE from acad_grupo where ID_GRUPO='.$data['ID_GRUPO'].'))';
		}
		$sql.=' order by ESTUDIANTE';
		$query = $this->db->query($sql);
		// $query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}

	//////////////////////////////////////////////////////
	public function crearTaller($data){
		$this->db->insert('acad_talleres', $data);
		return $this->db->insert_id();
	}

	//////////////////////////////////////////////////////
	public function actualizarTaller($data,$id_taller){
		$this->db->where('ID_TALLER', $id_taller);
		$this->db->update('acad_talleres', $data);
	}
	//////////////////////////////////////////////////////
	public function crearTallerEstudiante($data){
		$this->db->insert('acad_aplazar_contenido', $data);
		return $this->db->insert_id();
	}

	//////////////////////////////////////////////////////
	public function eliminarTallerEstudiante($id){
		$this->db->where('ID', $id);
		$this->db->delete('acad_aplazar_contenido');
	}

	/////////////////////////////////////////////////////////////////////////////
	public function get_estudiantes_taller($id){
		$this->db->select('*');
		$this->db->from('acad_aplazar_contenido cte');
		$this->db->where('cte.ID', $id);
		$this->db->where('cte.TIPO', 2);
		$query = $this->db->get();
		return $query->result_array();
	}

	//////////////////////////////////////////////
	public function num_respuestasTalleres_estudiantes($id_taller,$id_usuario_academico=null){
		$sql="select count(rt.ID_RESPUESTA_TALLER) as num_respuestas";
		$sql.=" FROM acad_respuestas_talleres rt";
		if ($id_usuario_academico != null && $id_usuario_academico != "") {
			$sql.=' join admin_usuarios u ON u.ID_PERSONA = rt.ID_PERSONA';
			$sql.=' join acad_asesor_estudiante ae ON ae.ID_USUARIO_ESTUDIANTE = u.ID_USUARIO and ae.ID_USUARIO_ACADEMICO='.$id_usuario_academico;
		}
		$sql.=" where rt.ID_TALLER=".$id_taller;
		$sql.=" and rt.RESPUESTA is not null";
		// $sql.=" and RESPUESTA is not null";
		$query = $this->db->query($sql);
		$ds = $query->row_array();
		if($ds!=NULL){
			return $ds['num_respuestas'];
		}else{
			return 0;
		}
	}

	///////////////////////////////////////////////////////////
	public function buscar_fechaAplazada_taller_por_estudiante($data){
		$this->db->distinct('ESTUDIANTE');
		$this->db->select('cte.ID_PERSONA, cte.FECHA_APLAZADA');
		$this->db->from('acad_aplazar_contenido cte');
		if(isset($data['ID']) and $data['ID']!=NULL){
			$this->db->where('cte.ID',$data['ID']);
		}
		if(isset($data['ID_PERSONA']) and $data['ID_PERSONA']!=NULL){
			$this->db->where('cte.ID_PERSONA',$data['ID_PERSONA']);
		}
		if(isset($data['TIPO']) and $data['TIPO']!=NULL){
			$this->db->where('cte.TIPO',$data['TIPO']);
		}
		
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds;
	}

	///////////////////////////////////////////////////////////
	public function buscar_respuestas_taller($data){
		$sql="select rt.*,CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE,p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as ESTUDIANTE";
		$sql.=" from acad_respuestas_talleres rt";
		$sql.=" join tab_personas p on p.ID_PERSONA=rt.ID_PERSONA";
		$sql.=" where rt.ID_RESPUESTA_TALLER>0";
		if(isset($data['ID_TALLER']) and $data['ID_TALLER']!=NULL){
			$sql.=" and rt.ID_TALLER=".$data['ID_TALLER'];
		}
		if(isset($data['ID_PERSONA']) and $data['ID_PERSONA']!=NULL){
			$sql.=" and rt.ID_PERSONA=".$data['ID_PERSONA'];
		}
		if(isset($data['ID_RESPUESTA_TALLER']) and $data['ID_RESPUESTA_TALLER']!=NULL){
			$sql.=" and rt.ID_RESPUESTA_TALLER=".$data['ID_RESPUESTA_TALLER'];
		}
		$sql.=" order by ESTUDIANTE";
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		return $ds;
	}

	///////////////////////////////////////////////////////////
	public function buscar_taller_estudiante($data){
		$this->db->select('cte.*');
		$this->db->from('acad_aplazar_contenido cte');
		
		if(isset($data['ID']) and $data['ID']!=NULL){
			$this->db->where('cte.ID',$data['ID']);
		}
		if(isset($data['ID_PERSONA']) and $data['ID_PERSONA']!=NULL){
			$this->db->where('cte.ID_PERSONA',$data['ID_PERSONA']);
		}
		if(isset($data['TIPO']) and $data['TIPO']!=NULL){
			$this->db->where('cte.TIPO',$data['TIPO']);
		}
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds;
	}

	//////////////////////////////////////////////////////
	public function actualizarRespuestaTaller($data,$id_respuesta_taller){
		$this->db->where('ID_RESPUESTA_TALLER', $id_respuesta_taller);
		$this->db->update('acad_respuestas_talleres', $data);
	}

	//////////////////////////////////////////////////////
	public function crearRespuestaTaller($data){
		$this->db->insert('acad_respuestas_talleres', $data);
		return $this->db->insert_id();
	}

	//////////////////////////////////
	public function existeCalificacionTaller($datos){
		$this->db->select('*');
		$this->db->from('acad_respuestas_talleres');
		if (isset($datos['ID_TALLER']) && $datos['ID_TALLER']!="") {
			$this->db->where('ID_TALLER', $datos['ID_TALLER']);
		}
		if (isset($datos['ID_PERSONA']) && $datos['ID_PERSONA']!="") {
			$this->db->where('ID_PERSONA', $datos['ID_PERSONA']);
		}
		$query = $this->db->get();
		$ds    = $query->result_array();
		if (count($ds)>0) {
			return $ds[0];
		}else{
			return "";
		}
		
	}

	//////////////////////////////////////////////
	public function num_talleres_estudiantes($data,$id_persona=null){
		// $this->db->select("count(ct.ID_TALLER) as num_talleres");
		// $this->db->from('acad_talleres ct');
		
		// if (isset($id_planificacion) && $id_planificacion!=0) {
		// 	$this->db->where('ct.ID_PLANIFICACION',$id_planificacion);
		// }

		
		
		// $query = $this->db->get();
		// $ds = $query->row_array(); 
		
		// if($ds!=NULL){
		// 	return $ds['num_talleres'];
		// }else{
		// 	return 0;
		// }

		$sql =  "SELECT count(ct.ID_TALLER) as num_talleres ";
		$sql .= " FROM acad_talleres ct";
		$sql .= " JOIN acad_planificacion p ON p.ID_PLANIFICACION = ct.ID_PLANIFICACION";
		$sql .= " where ct.ID_TALLER>0 ";
		if(isset($data['ID_TALLER']) and $data['ID_TALLER']!=NULL){
			$sql .= " AND ct.ID_TALLER= ".$data['ID_TALLER'];
		}
		if (isset($data['ID_CARRERA_MATERIA']) && $data['ID_CARRERA_MATERIA'] != "") {
			$sql.=' and p.ID_CARRERA_MATERIA in (select ID_MATERIA from acad_materia where NOMBRE=(select NOMBRE from acad_materia where ID_MATERIA='.$data['ID_CARRERA_MATERIA'].'))';
		}
		if (isset($data['ID_PERIODO_ACADEMICO']) && $data['ID_PERIODO_ACADEMICO'] != "") {
			$sql.=' and p.ID_PERIODO_ACADEMICO='. $data['ID_PERIODO_ACADEMICO'];
		}
		if (isset($data['ID_GRUPO']) && $data['ID_GRUPO'] != "") {
			$sql.=' and p.ID_GRUPO in (select ID_GRUPO from acad_grupo where NOMBRE=(select NOMBRE from acad_grupo where ID_GRUPO='.$data['ID_GRUPO'].'))';
		}
		if (isset($data['ID_PLANTILLA']) && $data['ID_PLANTILLA'] != "") {
			$sql.=' and p.ID_PLANTILLA='. $data['ID_PLANTILLA'];
		}

		$query = $this->db->query($sql);
		$ds = $query->row_array(); 
		if($ds!=NULL){
			return $ds['num_talleres'];
		}else{
			return 0;
		}
	}

	/////////////////////////////////////////////////////////////////////////////
	public function talleres_realizadas_estudiante($id_persona,$data){
		
		$sql_adi='';
		if(isset($data['ID_PLANTILLA']) && $data['ID_PLANTILLA'] != "") {
			$sql_adi=' and p.ID_PLANTILLA='. $data['ID_PLANTILLA'];
		}
		$sql="select *";
		$sql.=" from acad_respuestas_talleres";
		$sql.=" where ID_TALLER in (select t.ID_TALLER from acad_talleres t JOIN acad_planificacion p ON p.ID_PLANIFICACION = t.ID_PLANIFICACION where ID_TALLER>0  and p.ID_PERIODO_ACADEMICO=". $data['ID_PERIODO_ACADEMICO']." and p.ID_CARRERA_MATERIA in (select ID_MATERIA from acad_materia where NOMBRE=(select NOMBRE from acad_materia where ID_MATERIA=".$data['ID_CARRERA_MATERIA']."))".$sql_adi." and p.ID_GRUPO in (select ID_GRUPO from acad_grupo where NOMBRE=(select NOMBRE from acad_grupo where ID_GRUPO=".$data['ID_GRUPO'].")))";
		$sql.=" and ID_PERSONA=".$id_persona;
		$sql.=" and RESPUESTA is not null";
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		return $ds;
	}

	/////////////////////////////////////////////////////////////////////////////
	public function talleres_calificadas_estudiante($id_persona,$data){
		$sql_adi='';
		if(isset($data['ID_PLANTILLA']) && $data['ID_PLANTILLA'] != "") {
			$sql_adi=' and p.ID_PLANTILLA='. $data['ID_PLANTILLA'];
		}
		$sql="select *";
		$sql.=" from acad_respuestas_talleres";
		$sql.=" where ID_TALLER in (select t.ID_TALLER from acad_talleres t JOIN acad_planificacion p ON p.ID_PLANIFICACION = t.ID_PLANIFICACION where ID_TALLER>0 and p.ID_PERIODO_ACADEMICO=". $data['ID_PERIODO_ACADEMICO']." and p.ID_CARRERA_MATERIA in (select ID_MATERIA from acad_materia where NOMBRE=(select NOMBRE from acad_materia where ID_MATERIA=".$data['ID_CARRERA_MATERIA']."))".$sql_adi." and p.ID_GRUPO in (select ID_GRUPO from acad_grupo where NOMBRE=(select NOMBRE from acad_grupo where ID_GRUPO=".$data['ID_GRUPO'].")))";
		$sql.=" and ID_PERSONA=".$id_persona;
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		return $ds;
	}
	
	///////////////////////////////////////////////
	public function borrarTaller($idTaller){
		$this->db->where('ID_TALLER', $idTaller);
		$this->db->delete('acad_talleres'); 
	}
	
	////////////////////////////////////////////////
	public function borrarRespuestasTaller($idTaller){
		$this->db->where('ID_TALLER', $idTaller);
		$this->db->delete('acad_respuestas_talleres'); 
	}

	////////////////////////////////
	public function buscar_aulaVirtual($data){
		// $this->db->select('*');
		// $this->db->from('acad_planificacion_aulas_virtuales');
		// if(isset($data['ID_PLANIFICACION']) and $data['ID_PLANIFICACION']!=''){
		//            $this->db->where('ID_PLANIFICACION',$data['ID_PLANIFICACION']);
		// }
		// if(isset($data['ID_AULA_VIRTUAL']) and $data['ID_AULA_VIRTUAL']!=''){
		//            $this->db->where('ID_AULA_VIRTUAL',$data['ID_AULA_VIRTUAL']);
		// }
		// $query = $this->db->get();
		// return $query->row_array();
		
		$sql =  "SELECT pav.* ";
		$sql .= " FROM acad_planificacion_aulas_virtuales pav";
		$sql .= " JOIN acad_planificacion p ON p.ID_PLANIFICACION = pav.ID_PLANIFICACION";
		$sql .= " where pav.ID_AULA_VIRTUAL>0 ";
		if (isset($data['ID_CARRERA_MATERIA']) && $data['ID_CARRERA_MATERIA'] != "") {
			$sql.=' and p.ID_CARRERA_MATERIA in (select ID_MATERIA from acad_materia where NOMBRE=(select NOMBRE from acad_materia where ID_MATERIA='.$data['ID_CARRERA_MATERIA'].'))';
		}
		if (isset($data['ID_GRUPO']) && $data['ID_GRUPO'] != "") {
			$sql.=' and p.ID_GRUPO in (select ID_GRUPO from acad_grupo where NOMBRE=(select NOMBRE from acad_grupo where ID_GRUPO='.$data['ID_GRUPO'].'))';
		}
		if (isset($data['ID_PERIODO_ACADEMICO']) && $data['ID_PERIODO_ACADEMICO'] != "") {
			$sql.=' and p.ID_PERIODO_ACADEMICO='. $data['ID_PERIODO_ACADEMICO'];
		}
		if (isset($data['ID_AULA_VIRTUAL']) && $data['ID_AULA_VIRTUAL'] != "") {
			$sql.=' and pav.ID_AULA_VIRTUAL='. $data['ID_AULA_VIRTUAL'];
		}
		if (isset($data['ID_PLANTILLA']) && $data['ID_PLANTILLA'] != "") {
			$sql.=' and p.ID_PLANTILLA='. $data['ID_PLANTILLA'];
		}
		$query = $this->db->query($sql);
		return $query->row_array();
	}


	////////////////////////////////
	public function existeCodAulaVirtual($codUnico){
		$this->db->select('*');
		$this->db->from('acad_planificacion_aulas_virtuales');
	
		$this->db->where('CODIGO_UNICO',$codUnico);
		
		$query = $this->db->get();
		$ds    = $query->result_array();

		if (count($ds)>0) {
			return true;
		}else{
			return false;
		}
	}

	//////////////////////////////////
	public function crearAulaVirtual($datos){
		$this->db->insert('acad_planificacion_aulas_virtuales', $datos);
		return $this->db->insert_id();
	}

	/////////////////////////////////////////////////////////////////////////
	public function actualizarAulaVirtual($datos,$idAulaVirtual) 
	{
		$this->db->where('ID_AULA_VIRTUAL', $idAulaVirtual);
		$this->db->update('acad_planificacion_aulas_virtuales', $datos);
	}
	
	//////////////////////////////////
	public function borrarAulaVirtual($idAulaVirtual=0)
	{
		$this->db->where('ID_AULA_VIRTUAL', $idAulaVirtual);
		$this->db->delete('acad_planificacion_aulas_virtuales');
	}
	
	/////////////////////////////////////////////////////////////////////////////
	public function retos_realizados_estudiante($idPersona=null,$idContenido=null,$idRetoContenido=null)
	{
		$sql="select *";
		$sql.=" from acad_retos_estudiantes";
		$sql.=" where ID_RETO_CONTENIDO>0";
		if($idContenido!=null){
			$sql.=" and ID_RETO_CONTENIDO in (select ID_RETO_PROYECTO_CONTENIDO from acad_retos_proyectos_contenido where ID_CONTENIDO=".$idContenido.")";
		}
		if($idPersona!=null){
			$sql.=" and ID_PERSONA=".$idPersona;
		}
		if($idRetoContenido!=null){
			$sql.=" and ID_RETO_CONTENIDO=".$idRetoContenido;
		}
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		return $ds;
	}
	
	///////////////////////////////////////////////////////////
	public function buscar_retos_estudiantes($data)
	{
		$sql="select re.*,CONCAT_WS(' ',p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE,p.APELLIDO_PATERNO, p.APELLIDO_MATERNO) as ESTUDIANTE";
		$sql.=" from acad_retos_estudiantes re";
		$sql.=" join tab_personas p on p.ID_PERSONA=re.ID_PERSONA";
		$sql.=" where re.ID_RETO_ESTUDIANTE>0";
		if(isset($data['ID_RETO_CONTENIDO']) and $data['ID_RETO_CONTENIDO']!=NULL){
			$sql.=" and re.ID_RETO_CONTENIDO=".$data['ID_RETO_CONTENIDO'];
		}
		if(isset($data['ID_PERSONA']) and $data['ID_PERSONA']!=NULL){
			$sql.=" and re.ID_PERSONA=".$data['ID_PERSONA'];
		}
		if(isset($data['ID_RETO_ESTUDIANTE']) and $data['ID_RETO_ESTUDIANTE']!=NULL){
			$sql.=" and re.ID_RETO_ESTUDIANTE=".$data['ID_RETO_ESTUDIANTE'];
		}
		$sql.=" order by ESTUDIANTE";
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		return $ds;
	}
	
	///////////////////////////////////////////////////////////////////
	public function getPreguntasRetosContenido($data=array())
	{
		$this->db->select('*');
		$this->db->from('acad_preguntas_retos_contenido');
		if(isset($data['ID_RETO_CONTENIDO']) and $data['ID_RETO_CONTENIDO']!=''){
			$this->db->where('ID_RETO_CONTENIDO',$data['ID_RETO_CONTENIDO']);
		}
		$query = $this->db->get();
		$ds    = $query->result_array();
		return $ds;
	}
	
	///////////////////////////////////////////////////
	public function crearRetoEstudiante($datos)
	{
		$this->db->insert('acad_retos_estudiantes', $datos);
		return $this->db->insert_id();
	}

	/////////////////////////////////////////////////////////////////
	public function actualizarRetoEstudiante($datos,$idRetoEstudiante) 
	{
		$this->db->where('ID_RETO_ESTUDIANTE', $idRetoEstudiante);
		$this->db->update('acad_retos_estudiantes', $datos);
	}
	
	///////////////////////////////////////////////////////////////////
	public function getOpcionesRespuestaRetosContenido($data=array())
	{
		$this->db->select('*');
		$this->db->from('acad_opciones_respuesta_retos_contenido');
		if(isset($data['ID_PREGUNTA_RETO_CONTENIDO']) and $data['ID_PREGUNTA_RETO_CONTENIDO']!=''){
			$this->db->where('ID_PREGUNTA_RETO_CONTENIDO',$data['ID_PREGUNTA_RETO_CONTENIDO']);
		}
		$query = $this->db->get();
		$ds    = $query->result_array();
		return $ds;
	}
	
	/////////////////////////////////////////////////////////////////////////////
	public function proyectos_realizados_estudiante($idPersona=null,$idContenido=null,$idProyectoContenido=null)
	{
		$sql="select *";
		$sql.=" from acad_respuestas_proyectos";
		$sql.=" where ID_PROYECTO_CONTENIDO>0";
		if($idContenido!=null){
			$sql.=" and ID_PROYECTO_CONTENIDO in (select ID_RETO_PROYECTO_CONTENIDO from acad_retos_proyectos_contenido where ID_CONTENIDO=".$idContenido.")";
		}
		if($idPersona!=null){
			$sql.=" and ID_PERSONA=".$idPersona;
		}
		if($idProyectoContenido!=null){
			$sql.=" and ID_PROYECTO_CONTENIDO=".$idProyectoContenido;
		}
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		return $ds;
	}
	
	/////////////////////////////////////////////////////
	public function num_respuestasProyectos_estudiantes($idProyectoContenido,$ids_persona)
	{
		$sql="select count(ID_RESPUESTA_PROYECTO) as num_respuestas";
		$sql.=" FROM acad_respuestas_proyectos";
		$sql.=" where ID_PROYECTO_CONTENIDO=".$idProyectoContenido;
		$sql.=" and ID_PERSONA in (".$ids_persona.")";
		$sql.=" and RESPUESTA is not null";
		$query = $this->db->query($sql);
		$ds = $query->row_array();
		if($ds!=NULL){
			return $ds['num_respuestas'];
		}else{
			return 0;
		}
	}
	
	///////////////////////////////////////////////////
	public function crearRespuestaProyecto($datos)
	{
		$this->db->insert('acad_respuestas_proyectos', $datos);
		return $this->db->insert_id();
	}

	/////////////////////////////////////////////////////////////////
	public function actualizarRespuestaProyecto($datos,$idRespuestaProyecto) 
	{
		$this->db->where('ID_RESPUESTA_PROYECTO', $idRespuestaProyecto);
		$this->db->update('acad_respuestas_proyectos', $datos);
	}
	
	/////////////////////////////////////////////////////////////////////////////
	public function getAplazoContenido($idPersona=null,$tipo=null,$id=null)
	{
		$sql="select *";
		$sql.=" from acad_aplazar_contenido";
		$sql.=" where ID>0";
		if($tipo!=null){
			$sql.=" and TIPO=".$tipo;
		}
		if($idPersona!=null){
			$sql.=" and ID_PERSONA=".$idPersona;
		}
		if($id!=null){
			$sql.=" and ID=".$id;
		}
		$query = $this->db->query($sql);
		$ds = $query->result_array(); 
		return $ds;
	}
	
	/////////////////////////////////////////////////////////////////////////////
	public function borrarAplazoContenido($idPersona=null,$tipo=null,$id=null)
	{
		if($tipo!=null){
			$this->db->where('TIPO', $tipo);
		}
		if($idPersona!=null){
			$this->db->where('ID_PERSONA', $idPersona);
		}
		if($id!=null){
			$this->db->where('ID', $id);
		}
		$this->db->delete('acad_aplazar_contenido');
	}
	
	//////////////////////////////////////////////////////
	public function crearAplazoContenido($data)
	{
		$this->db->insert('acad_aplazar_contenido', $data);
	}
	
	//////////////////////////////////////////////////////////////
	public function get_estudianteCarreraMateria($data){
		// $this->db->select('*');
		// $this->db->from('acad_estudiante_carrera_materia');
		// if(isset($data['ID_CARRERA_MATERIA']) and $data['ID_CARRERA_MATERIA']!=''){
		// 	$this->db->where('ID_CARRERA_MATERIA',$data['ID_CARRERA_MATERIA']);
		// }
		// if(isset($data['ID_PERIODO_ACADEMICO']) and $data['ID_PERIODO_ACADEMICO']!=''){
		// 	$this->db->where('ID_PERIODO_ACADEMICO',$data['ID_PERIODO_ACADEMICO']);
		// }
		// if(isset($data['ID_GRUPO']) and $data['ID_GRUPO']!=''){
		// 	$this->db->where('ID_GRUPO',$data['ID_GRUPO']);
		// }
		// if(isset($data['ID_ESTUDIANTE_CARRERA_MATERIA']) and $data['ID_ESTUDIANTE_CARRERA_MATERIA']!=''){
		// 	$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$data['ID_ESTUDIANTE_CARRERA_MATERIA']);
		// }
		// if(isset($data['ID_PERSONA']) and $data['ID_PERSONA']!=''){
		// 	$this->db->where('ID_PERSONA',$data['ID_PERSONA']);
		// }
		// $query = $this->db->get();
		// $ds = $query->row_array();
		// return $ds;

		$sql =  "SELECT * ";
		$sql .= " FROM acad_estudiante_carrera_materia ";
		$sql .= " where ID_ESTUDIANTE_CARRERA_MATERIA>0 ";
		if(isset($data['ID_CARRERA_MATERIA']) and $data['ID_CARRERA_MATERIA']!=''){
			$sql.=' and ID_CARRERA_MATERIA in (select ID_MATERIA from acad_materia where NOMBRE=(select NOMBRE from acad_materia where ID_MATERIA='.$data['ID_CARRERA_MATERIA'].'))';
		}

		if(isset($data['ID_PERIODO_ACADEMICO']) and $data['ID_PERIODO_ACADEMICO']!=''){
			$sql.=' and ID_PERIODO_ACADEMICO='. $data['ID_PERIODO_ACADEMICO'];
		}
		if(isset($data['ID_GRUPO']) and $data['ID_GRUPO']!=''){
			$sql.=' and ID_GRUPO in (select ID_GRUPO from acad_grupo where NOMBRE=(select NOMBRE from acad_grupo where ID_GRUPO='.$data['ID_GRUPO'].'))';
		}
		if(isset($data['ID_ESTUDIANTE_CARRERA_MATERIA']) and $data['ID_ESTUDIANTE_CARRERA_MATERIA']!=''){
			$sql.=' and ID_ESTUDIANTE_CARRERA_MATERIA='. $data['ID_ESTUDIANTE_CARRERA_MATERIA'];
		}
		if(isset($data['ID_PERSONA']) and $data['ID_PERSONA']!=''){
			$sql.=' and ID_PERSONA='. $data['ID_PERSONA'];
		}
		if(isset($data['ID_CARRERA']) and $data['ID_CARRERA']!=''){
			$sql.=' and ID_CARRERA='. $data['ID_CARRERA'];
		}
		if(isset($data['FUE_CONVALIDADA']) and $data['FUE_CONVALIDADA']!=''){
			$sql.=' and FUE_CONVALIDADA='. $data['FUE_CONVALIDADA'];
		}
		if(isset($data['FUE_HOMOLOGADA']) and $data['FUE_HOMOLOGADA']!=''){
			$sql.=' and FUE_HOMOLOGADA='. $data['FUE_HOMOLOGADA'];
		}
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	//////////////////////////////////////////////////////
	public function crearCalificacion($data){
		$this->db->insert('acad_calificacion', $data);
		return $this->db->insert_id();
	}
	
	////////////////////////////////////////////////////////////
	public function actualizarCalificacion($datos,$id_calificacion){
		$this->db->where('ID_CALIFICACION', $id_calificacion);
		$this->db->update('acad_calificacion', $datos);
	}
	
	////////////////////////////////////////////////////////////////////////////
	public function buscar_calificacion($data = array()){
		$this->db->select('*');
		$this->db->from('acad_calificacion');
		if(isset($data['ID_PERIODO_ACADEMICO']) and $data['ID_PERIODO_ACADEMICO'] != ''){
			$this->db->where('ID_PERIODO_ACADEMICO', $data['ID_PERIODO_ACADEMICO']);
		} 
		if(isset($data['ID_ESTUDIANTE_CARRERA_MATERIA']) and $data['ID_ESTUDIANTE_CARRERA_MATERIA'] != ''){
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA', $data['ID_ESTUDIANTE_CARRERA_MATERIA']);
		} 
		if(isset($data['ETAPA']) and $data['ETAPA'] != ''){
			$this->db->where('ETAPA', $data['ETAPA']);
		}
		if(isset($data['ID_COMPONENTE']) and $data['ID_COMPONENTE'] != ''){
			$this->db->where('ID_COMPONENTE', $data['ID_COMPONENTE']);
		}
		if(isset($data['ID_TIPO_CALIFICACION']) and $data['ID_TIPO_CALIFICACION'] != ''){
			$this->db->where('ID_TIPO_CALIFICACION', $data['ID_TIPO_CALIFICACION']);
		}
		if(isset($data['CALIFICACION']) and $data['CALIFICACION'] != ''){
			$this->db->where('CALIFICACION', $data['CALIFICACION']);
		}
		$consulta = $this->db->get();
		$resultado = $consulta->result_array();
		return $resultado;
	}
	
	///////////////////////////////////////////////////////////////////
	public function get_estudiante_carrera_materia($id_estudiante_carrera_materia){
		$this->db->select('*');
		$this->db->from('acad_estudiante_carrera_materia');
		$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$id_estudiante_carrera_materia);
		$query = $this->db->get();
		$ds    = $query->row_array();
		return $ds;
	}
	
	////////////////////////////////////////////////
	public function buscarGruposExamenesEstudiantes($data = array()) 
	{
		$periodo= $this->get_periodo_activado();
		$sql_adi='';
		$sql_where_adi='';
		if(isset($data['EXAMEN']) && $data['EXAMEN'] == 1){
			//$sql_adi.=', ee.TIPO_EXAMEN,ee.ESTADO as ESTADO_EXAMEN, ee.CALIFICACION, fa.FECHA_APLAZADO, fa.HORA_APLAZADO, fa.DURACION_EXAMEN';
			//$sql_adi.=', ee.TIPO_EXAMEN,ee.ESTADO as ESTADO_EXAMEN, ee.CALIFICACION';
		}
		$sql_plantilla='';
		$sql='select CONCAT_WS(" ",p.APELLIDO_PATERNO,p.APELLIDO_MATERNO, p.PRIMER_NOMBRE,p.SEGUNDO_NOMBRE) as NOMBRE_ESTUDIANTE, c.NRO_DOCUMENTO, ca.NOMBRE as CARRERA, pla.FECHA_EXAMEN, pla.HORA_EXAMEN, m.NOMBRE as MATERIA, ecm.ID_ESTUDIANTE_CARRERA_MATERIA, mat.ESTADO, g.NOMBRE as GRUPO, ecm.ID_CARRERA_MATERIA, ecm.ID_GRUPO, ecm.ID_PERIODO_ACADEMICO, pla.FECHA_SUPLETORIO, pla.HORA_SUPLETORIO, ecm.ID_PERSONA_DOCENTE, mat.ID_MATRICULA, p.CORREO_INSTITUCIONAL, p.ID_PERSONA, ca.ID_CARRERA, pla.ID_PLANTILLA'.$sql_adi.'  ';
		$sql.='from acad_estudiante_carrera_materia ecm ';
		$sql.='join tab_personas p on p.ID_PERSONA=ecm.ID_PERSONA ';
		$sql.='join acad_matricula mat on mat.ID_PERSONA=ecm.ID_PERSONA and mat.ID_PERIODO_ACADEMICO=ecm.ID_PERIODO_ACADEMICO and mat.ID_CARRERA=ecm.ID_CARRERA ';
		$sql.='join tab_clientes_naturales cn on cn.ID_PERSONA = ecm.ID_PERSONA ';
		$sql.='join tab_clientes c on c.ID_CLIENTE = cn.ID_CLIENTE ';
		$sql.='join acad_carrera ca on ca.ID_CARRERA = ecm.ID_CARRERA ';
		$sql.='join acad_materia m on m.ID_MATERIA = ecm.ID_CARRERA_MATERIA ';
		$sql.='join acad_grupo g on g.ID_GRUPO = ecm.ID_GRUPO ';
		$sql.='join acad_planificacion pla on pla.ID_CARRERA_MATERIA = ecm.ID_CARRERA_MATERIA and pla.ID_GRUPO = ecm.ID_GRUPO and pla.ID_PERIODO_ACADEMICO=ecm.ID_PERIODO_ACADEMICO ';
		if(isset($data['ID_USUARIO_ACADEMICO']) && $data['ID_USUARIO_ACADEMICO'] != ""){
			$sql.=' join admin_usuarios u ON u.ID_PERSONA = ecm.ID_PERSONA';
			$sql.=' join acad_asesor_estudiante ae ON ae.ID_USUARIO_ESTUDIANTE = u.ID_USUARIO and ae.ID_USUARIO_ACADEMICO='.$data['ID_USUARIO_ACADEMICO'];
		}
		
		$sql.=' where ecm.FUE_CONVALIDADA=0 and ecm.FUE_HOMOLOGADA=0 and ecm.FUE_HISTORIAL=0 and ecm.ID_PERIODO_ACADEMICO='.$periodo.$sql_where_adi;
		
	   	if(isset($data['ID_PERSONA']) and $data['ID_PERSONA'] != ''){
			$sql.=' and ecm.ID_PERSONA='.$data['ID_PERSONA'];
		}
		if(isset($data['ID_MATRICULA']) and $data['ID_MATRICULA'] != ''){
			$sql.=' and mat.ID_MATRICULA='.$data['ID_MATRICULA'];
		} 
		if(isset($data['NRO_DOCUMENTO']) and $data['NRO_DOCUMENTO']!=''){
			$sql.=" and c.NRO_DOCUMENTO='".$data['NRO_DOCUMENTO']."'";
		} 
		if(isset($data['ID_CARRERA']) and $data['ID_CARRERA']!=''){
			$sql.=' and ca.ID_CARRERA='.$data['ID_CARRERA'];
		}
		if(isset($data['ESTADO_ESTUDIANTE']) and $data['ESTADO_ESTUDIANTE']!=''){
			$sql.=' and mat.ESTADO=0';
		}
		if(isset($data['ID_DOCENTE']) and $data['ID_DOCENTE']!=''){
			$sql.=' and ecm.ID_PERSONA_DOCENTE='.$data['ID_DOCENTE'];
		}
		if(isset($data['ID_ESTUDIANTE_CARRERA_MATERIA']) and $data['ID_ESTUDIANTE_CARRERA_MATERIA']!=''){
			$sql.=' and ecm.ID_ESTUDIANTE_CARRERA_MATERIA='.$data['ID_ESTUDIANTE_CARRERA_MATERIA'];
		}
		if(isset($data['FECHA']) and $data['FECHA']!=''){
			$sql.=" and pla.FECHA_EXAMEN='".$data['FECHA']."'";
		}
		if(isset($data['ID_CONTENIDO']) and $data['ID_CONTENIDO']!=''){
			$sql.=' and ecm.ID_CARRERA_MATERIA in (select ID_MATERIA from acad_materia_contenido where ID_CONTENIDO='.$data['ID_CONTENIDO'].')';
		}
		if(isset($data['GRUPO']) and $data['GRUPO']!=''){
			$sql.=" and ecm.ID_GRUPO in (select ID_GRUPO from acad_grupo where NOMBRE='".$data['GRUPO']."')";
		}
		if(isset($data['GRUPOS']) and $data['GRUPOS']!=''){
			$sql.=" and ecm.ID_GRUPO in (select ID_GRUPO from acad_grupo where NOMBRE in (".$data['GRUPOS']."))";
		}
		if(isset($data['FECHA_INICIO']) and $data['FECHA_INICIO']!=''){
			$sql.=" and pla.FECHA_EXAMEN>='".$data['FECHA_INICIO']."'";
		}
		if(isset($data['FECHA_FIN']) and $data['FECHA_FIN']!=''){
			$sql.=" and pla.FECHA_EXAMEN<='".$data['FECHA_FIN']."'";
		}
		if(isset($data['FECHA_INICIO_SUPLETORIO']) and $data['FECHA_INICIO_SUPLETORIO']!=''){
			$sql.=" and pla.FECHA_SUPLETORIO>='".$data['FECHA_INICIO_SUPLETORIO']."'";
		}
		if(isset($data['FECHA_FIN_SUPLETORIO']) and $data['FECHA_FIN_SUPLETORIO']!=''){
			$sql.=" and pla.FECHA_SUPLETORIO<='".$data['FECHA_FIN_SUPLETORIO']."'";
		}
		if(isset($data['ID_PLANTILLA']) and $data['ID_PLANTILLA']!=''){
			$sql.=" and pla.ID_PLANTILLA=".$data['ID_PLANTILLA'];
			$sql_plantilla=' and ID_PLANTILLA='.$data['ID_PLANTILLA'];
		}
		if(isset($data['ESTADO_EXAMEN']) && $data['ESTADO_EXAMEN']>=0 && $data['ESTADO_EXAMEN']!='' && $data['ESTADO_EXAMEN']!=null){
			$sql.=" and ecm.ID_ESTUDIANTE_CARRERA_MATERIA in (select ID_ESTUDIANTE_CARRERA_MATERIA from acad_examenes_estudiantes where ETAPA=1".$sql_plantilla." and ESTADO=".$data['ESTADO_EXAMEN'].")";
		}elseif(isset($data['ESTADO_EXAMEN']) && $data['ESTADO_EXAMEN']==-1){
			$sql.=" and ecm.ID_ESTUDIANTE_CARRERA_MATERIA not in (select ID_ESTUDIANTE_CARRERA_MATERIA from acad_examenes_estudiantes where ETAPA=1".$sql_plantilla.")";
		}
		$sql.=' order by NOMBRE_ESTUDIANTE';
		//$this->db->query('SET SQL_BIG_SELECTS=1');
		$query=$this->db->query($sql);
		$resultado = $query->result_array();
		return $resultado;
	}
	
	///////////////////////////////////////////////////////////////////
	public function buscarExamenesEstudiantesAplazados($data=array()) 
	{
		$this->db->select('*');
		$this->db->from('acad_examenes_estudiantes_aplazados');
		if(isset($data['ID_ESTUDIANTE_CARRERA_MATERIA']) and $data['ID_ESTUDIANTE_CARRERA_MATERIA']!=''){
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$data['ID_ESTUDIANTE_CARRERA_MATERIA']);
		}
		if(isset($data['ETAPA']) and $data['ETAPA']!=''){
			$this->db->where('ETAPA',$data['ETAPA']);
		}
		if(isset($data['FECHA_APLAZADO']) and $data['FECHA_APLAZADO']!=''){
			$this->db->where('FECHA_APLAZADO',$data['FECHA_APLAZADO']);
		}
		if(isset($data['ID_PLANTILLA']) and $data['ID_PLANTILLA']!=''){
			$this->db->where('ID_PLANTILLA',$data['ID_PLANTILLA']);
		}
		$query = $this->db->get();
		$ds    = $query->result_array();
		return $ds;
	}
	
	///////////////////////////////////////////////////////////////////
	public function buscarExamenesEstudiantes($data=array()) 
	{
		$this->db->select('*');
		$this->db->from('acad_examenes_estudiantes');
		if(isset($data['ID_ESTUDIANTE_CARRERA_MATERIA']) and $data['ID_ESTUDIANTE_CARRERA_MATERIA']!=''){
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$data['ID_ESTUDIANTE_CARRERA_MATERIA']);
		}
		if(isset($data['ETAPA']) and $data['ETAPA']!=''){
			$this->db->where('ETAPA',$data['ETAPA']);
		}
		if(isset($data['TIPO_EXAMEN']) and $data['TIPO_EXAMEN']!=''){
			$this->db->where('TIPO_EXAMEN',$data['TIPO_EXAMEN']);
		}
		if(isset($data['ESTADO']) and $data['ESTADO']!=''){
			$this->db->where('ESTADO',$data['ESTADO']);
		}
		if(isset($data['ID_PLANTILLA']) and $data['ID_PLANTILLA']!=''){
			$this->db->where('ID_PLANTILLA',$data['ID_PLANTILLA']);
		}
		$query = $this->db->get();
		$ds    = $query->result_array();
		return $ds;
	}
	
	///////////////////////////////////////////////////////////////////
	public function getPreguntasContenido($data=array())
	{
		$this->db->select('*');
		$this->db->from('acad_preguntas_contenido');
		if(isset($data['ID_CONTENIDO']) and $data['ID_CONTENIDO']!=''){
			$this->db->where('ID_CONTENIDO',$data['ID_CONTENIDO']);
		}
		if(isset($data['TIPO']) and $data['TIPO']!=''){
			$this->db->where('TIPO',$data['TIPO']);
		}
		if(isset($data['EXCLUIR']) and count($data['EXCLUIR'])>0){
			$this->db->where_not_in('ID_PREGUNTA_CONTENIDO',$data['EXCLUIR']);
		}
		if(isset($data['ALEATORIO']) and $data['ALEATORIO']!=''){
			$this->db->order_by('ID_PREGUNTA_CONTENIDO','RANDOM');
		}
		if(isset($data['NUM_REGISTROS']) and $data['NUM_REGISTROS']!=''){
			$this->db->limit($data['NUM_REGISTROS']);
		}
		if(isset($data['ID_PREGUNTA_CONTENIDO']) and $data['ID_PREGUNTA_CONTENIDO']!=''){
			$this->db->where('ID_PREGUNTA_CONTENIDO',$data['ID_PREGUNTA_CONTENIDO']);
		}
		$query = $this->db->get();
		$ds    = $query->result_array();
		return $ds;
	}
	
	///////////////////////////////////////////////////////////////////
	public function getOpcionesRespuestaContenido($data=array()) 
	{
		$this->db->select('*');
		$this->db->from('acad_opciones_respuesta_contenido');
		if(isset($data['ID_PREGUNTA_CONTENIDO']) and $data['ID_PREGUNTA_CONTENIDO']!=''){
			$this->db->where('ID_PREGUNTA_CONTENIDO',$data['ID_PREGUNTA_CONTENIDO']);
		}
		if(isset($data['ID_OPCION_RESPUESTA_CONTENIDO']) and $data['ID_OPCION_RESPUESTA_CONTENIDO']!=''){
			$this->db->where('ID_OPCION_RESPUESTA_CONTENIDO',$data['ID_OPCION_RESPUESTA_CONTENIDO']);
		}
		$query = $this->db->get();
		$ds    = $query->result_array();
		return $ds;
	}
	
	//////////////////////////////////
	public function actualizarExamenEstudiante($datos,$idExamenEstudiante) 
	{
		$this->db->where('ID_EXAMEN_ESTUDIANTE', $idExamenEstudiante);
		$this->db->update('acad_examenes_estudiantes', $datos);
	}
	
	//////////////////////////////////
	public function crearExamenEstudiante($datos) 
	{
		$this->db->insert('acad_examenes_estudiantes', $datos);
		return $this->db->insert_id();
	}
	
	//////////////////////////////////
	public function actualizarExamenEstudianteAplazado($datos,$idExamenEstudianteAplazado) 
	{
		$this->db->where('ID_EXAMEN_ESTUDIANTE_APLAZADO', $idExamenEstudianteAplazado);
		$this->db->update('acad_examenes_estudiantes_aplazados', $datos);
	}
	
	//////////////////////////////////
	public function crearExamenEstudianteAplazado($datos) 
	{
		$this->db->insert('acad_examenes_estudiantes_aplazados', $datos);
		return $this->db->insert_id();
	}
	
	///////////////////////////////////////////////////////////////////
	public function buscarExamenesPersonas($data=array()) 
	{
		$this->db->select('*');
		$this->db->from('acad_examenes_personas');
		if(isset($data['ID_CONTENIDO']) and $data['ID_CONTENIDO']!=''){
			$this->db->where('ID_CONTENIDO',$data['ID_CONTENIDO']);
		}
		if(isset($data['ID_PERSONA']) and $data['ID_PERSONA']!=''){
			$this->db->where('ID_PERSONA',$data['ID_PERSONA']);
		}
		if(isset($data['TIPO_EXAMEN']) and $data['TIPO_EXAMEN']!=''){
			$this->db->where('TIPO_EXAMEN',$data['TIPO_EXAMEN']);
		}
		if(isset($data['ESTADO']) and $data['ESTADO']!=''){
			$this->db->where('ESTADO',$data['ESTADO']);
		}
		$query = $this->db->get();
		$ds    = $query->result_array();
		return $ds;
	}
	
	//////////////////////////////////
	public function actualizarExamenPersona($datos,$idExamenPersona) 
	{
		$this->db->where('ID_EXAMEN_PERSONA', $idExamenPersona);
		$this->db->update('acad_examenes_personas', $datos);
	}
	
	//////////////////////////////////
	public function crearExamenPersona($datos) 
	{
		$this->db->insert('acad_examenes_personas', $datos);
		return $this->db->insert_id();
	}
	
	////////////////////////////////////////////////
	public function buscarExamenesPersonasTotal($data = array()) 
	{
		$sql='select ep.*,CONCAT_WS(" ",p.APELLIDO_PATERNO,p.APELLIDO_MATERNO, p.PRIMER_NOMBRE,p.SEGUNDO_NOMBRE) as NOMBRE_COMPLETO, c.NRO_DOCUMENTO, co.CONTENIDO as EXAMEN, co.DURACION_EXAMEN, co.ID_PLANTILLA ';
		$sql.='from acad_examenes_personas ep ';
		$sql.='join tab_personas p on p.ID_PERSONA=ep.ID_PERSONA ';
		$sql.='join tab_clientes_naturales cn on cn.ID_PERSONA = ep.ID_PERSONA ';
		$sql.='join tab_clientes c on c.ID_CLIENTE = cn.ID_CLIENTE ';
		$sql.='join acad_contenidos co on co.ID_CONTENIDO = ep.ID_CONTENIDO ';
		$sql.='where ep.ID_EXAMEN_PERSONA>0';
		if(isset($data['ID_EXAMEN_PERSONA']) and $data['ID_EXAMEN_PERSONA'] != ''){
			$sql.=' and ep.ID_EXAMEN_PERSONA='.$data['ID_EXAMEN_PERSONA'];
		} 
	   	if(isset($data['ID_PERSONA']) and $data['ID_PERSONA'] != ''){
			$sql.=' and ep.ID_PERSONA='.$data['ID_PERSONA'];
		} 
		if(isset($data['NRO_DOCUMENTO']) and $data['NRO_DOCUMENTO']!=''){
			$sql.=" and c.NRO_DOCUMENTO='".$data['NRO_DOCUMENTO']."'";
		} 
		if(isset($data['ID_CONTENIDO']) and $data['ID_CONTENIDO']!=''){
			$sql.=' and ep.ID_CONTENIDO='.$data['ID_CONTENIDO'];
		}
		if(isset($data['FECHA']) and $data['FECHA']!=''){
			$sql.=" and ep.FECHA='".$data['FECHA']."'";
		}
		$sql.=' order by NOMBRE_COMPLETO';
		$query=$this->db->query($sql);
		$resultado = $query->result_array();
		return $resultado;
	}
	
	///////////////////////////////////////////////////////////////////
	public function getGrupoTeam($data=array()) 
	{
		$this->db->select('*');
		$this->db->from('acad_teamsoffice');
		if(isset($data['GRUPO']) and $data['GRUPO']!=''){
			$this->db->where('GRUPO',$data['GRUPO']);
		}
		if(isset($data['PROPIETARIOS']) and $data['PROPIETARIOS']!=''){
			$this->db->like('PROPIETARIOS', $data['PROPIETARIOS']);
		}
		if(isset($data['MIEMBROS']) and $data['MIEMBROS']!=''){
			$this->db->like('MIEMBROS', $data['MIEMBROS']);
		}
		if(isset($data['ID_TEAM']) and $data['ID_TEAM']!=''){
			$this->db->where('ID_TEAM', $data['ID_TEAM']);
		}
		if(isset($data['EQUIPO']) and $data['EQUIPO']!=''){
			$this->db->where('EQUIPO', $data['EQUIPO']);
		}
		$query = $this->db->get();
		$ds    = $query->row_array();
		return $ds;
	}
	
	//////////////////////////////////
	public function crearGrupoTeam($datos) 
	{
		$this->db->insert('acad_teamsoffice', $datos);
		return $this->db->insert_id();
	}
	
	///////////////////////////////////////////////////////////////////
	public function getUsuarioTeam($data=array()) 
	{
		$this->db->select('*');
		$this->db->from('acad_usuariosoffice');
		if(isset($data['ID_PERSONA']) and $data['ID_PERSONA']!=''){
			$this->db->where('ID_PERSONA',$data['ID_PERSONA']);
		}
		$query = $this->db->get();
		$ds    = $query->row_array();
		return $ds;
	}
	
	////////////////////////////////////////
	public function crearUsuarioTeam($datos) 
	{
		$this->db->insert('acad_usuariosoffice', $datos);
		return $this->db->insert_id();
	}
	
	////////////////////////////////////////
	public function actualizarUsuarioTeam($datos,$idPersona) 
	{
		$this->db->where('ID_PERSONA', $idPersona);
		$this->db->update('acad_usuariosoffice', $datos);
	}
	
	////////////////////////////////////////////////////////////
	public function actualizarGrupoTeam($datos,$idTeamOffice) 
	{
		$this->db->where('ID_TEAM_OFFICE', $idTeamOffice);
		$this->db->update('acad_teamsoffice', $datos);
	}
	
	//////////////////////////////////////////////////////////////
	public function get_horasDictadas($data)
	{
		//codigo adicional para obtener todos los id_grupo con el mismo nombre
		$id_grupos=array();
		if(isset($data['ID_GRUPO']) and $data['ID_GRUPO']!=''){
			$this->db->select('*');
			$this->db->from('acad_grupo');
			$this->db->where('ID_GRUPO',$data['ID_GRUPO']);
			$query = $this->db->get();
			$g = $query->row_array();
			
			$this->db->select('*');
			$this->db->from('acad_grupo');
			$this->db->where('NOMBRE',$g['NOMBRE']);
			$query = $this->db->get();
			$grupos = $query->result_array(); 
			foreach($grupos as $g){
				$id_grupos[]=$g['ID_GRUPO'];
			}
		}
		//codigo adicional para obtener todos los id_materia con el mismo nombre
		$id_materias=array();
		if(isset($data['ID_MATERIA']) and $data['ID_MATERIA']!=''){
			$this->db->select('*');
			$this->db->from('acad_materia');
			$this->db->where('ID_MATERIA',$data['ID_MATERIA']);
			$query = $this->db->get();
			$m = $query->row_array(); 
			
			$this->db->select('*');
			$this->db->from('acad_materia');
			$this->db->where('NOMBRE',$m['NOMBRE']);
			$query = $this->db->get();
			$materias = $query->result_array(); 
			foreach($materias as $m){
				$id_materias[]=$m['ID_MATERIA'];
			}
		}
		$this->db->select('*');
		$this->db->from('acad_horas_dictadas');
		if(isset($data['ID_HORA_DICTADA']) and $data['ID_HORA_DICTADA']!=''){
			$this->db->where('ID_HORA_DICTADA',$data['ID_HORA_DICTADA']);
		}
		if(isset($data['ID_PERIODO_ACADEMICO']) and $data['ID_PERIODO_ACADEMICO']!=''){
			$this->db->where('ID_PERIODO_ACADEMICO',$data['ID_PERIODO_ACADEMICO']);
		}
		if(isset($data['ID_MATERIA']) and $data['ID_MATERIA']!=''){
			if(isset($data['TIPO']) and $data['TIPO']==1){//para reporte
				$this->db->where_in('ID_MATERIA',$id_materias);
			}else{//pare registro
				$this->db->where('ID_MATERIA',$data['ID_MATERIA']);
			}
		}
		if(isset($data['ID_GRUPO']) and $data['ID_GRUPO']!=''){
			if(isset($data['TIPO']) and $data['TIPO']==1){//para reporte
				$this->db->where_in('ID_GRUPO',$id_grupos);
			}else{//pare registro
				$this->db->where('ID_GRUPO',$data['ID_GRUPO']);
			}
		}
		if(isset($data['ID_PLANTILLA']) and $data['ID_PLANTILLA']!=''){
			$this->db->where('ID_PLANTILLA',$data['ID_PLANTILLA']);
		}
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	////////////////////////////////////////
	public function crear_horasDictadas($datos) 
	{
		$this->db->insert('acad_horas_dictadas', $datos);
		return $this->db->insert_id();
	}
	
	////////////////////////////////////////////////////////////
	public function actualizar_horasDictadas($datos,$idHoraDictada) 
	{
		$this->db->where('ID_HORA_DICTADA', $idHoraDictada);
		$this->db->update('acad_horas_dictadas', $datos);
	}
	
	////////////////////////////////////////////////////////////////////////////
	public function buscar_alumno_remedial($data)
	{
		$periodo= $this->get_periodo_activado();
		$sql='select CONCAT_WS(" ",p.APELLIDO_PATERNO,p.APELLIDO_MATERNO, p.PRIMER_NOMBRE,p.SEGUNDO_NOMBRE) as NOMBRE_ESTUDIANTE, c.NRO_DOCUMENTO, ca.NOMBRE as CARRERA, m.NOMBRE as MATERIA, ecm.ID_ESTUDIANTE_CARRERA_MATERIA, mat.ESTADO, g.NOMBRE as GRUPO, ecm.ID_CARRERA_MATERIA, ecm.ID_GRUPO, ecm.ID_PERIODO_ACADEMICO, ecm.ID_PERSONA_DOCENTE, cal.ESTADO_CALIFICACION, mat.ID_MATRICULA, p.ID_PERSONA, ecm.ID_CARRERA ';
		$sql.='from acad_estudiante_carrera_materia ecm ';
		$sql.='join tab_personas p on p.ID_PERSONA=ecm.ID_PERSONA ';
		$sql.='join acad_matricula mat on mat.ID_PERSONA=ecm.ID_PERSONA and mat.ID_PERIODO_ACADEMICO=ecm.ID_PERIODO_ACADEMICO and mat.ID_CARRERA=ecm.ID_CARRERA ';
		$sql.='join tab_clientes_naturales cn on cn.ID_PERSONA = ecm.ID_PERSONA ';
		$sql.='join tab_clientes c on c.ID_CLIENTE = cn.ID_CLIENTE ';
		$sql.='join acad_carrera ca on ca.ID_CARRERA = ecm.ID_CARRERA ';
		$sql.='join acad_materia m on m.ID_MATERIA = ecm.ID_CARRERA_MATERIA ';
		$sql.='join acad_grupo g on g.ID_GRUPO = ecm.ID_GRUPO ';
		$sql.='join acad_calificacion cal on cal.ID_ESTUDIANTE_CARRERA_MATERIA= ecm.ID_ESTUDIANTE_CARRERA_MATERIA ';
		$sql.='join acad_examenes_estudiantes ee on ee.ID_ESTUDIANTE_CARRERA_MATERIA= ecm.ID_ESTUDIANTE_CARRERA_MATERIA ';
		if(isset($data['ID_USUARIO_ACADEMICO']) && $data['ID_USUARIO_ACADEMICO'] != ""){
			$sql.=' join admin_usuarios u ON u.ID_PERSONA = ecm.ID_PERSONA';
			$sql.=' join acad_asesor_estudiante ae ON ae.ID_USUARIO_ESTUDIANTE = u.ID_USUARIO and ae.ID_USUARIO_ACADEMICO='.$data['ID_USUARIO_ACADEMICO'];
		}
		
		$sql.=' where cal.ID_TIPO_CALIFICACION=6 and ee.ETAPA=0 and ee.ESTADO=1 and ecm.ID_PERIODO_ACADEMICO='.$periodo;
		
	   	if(isset($data['ID_PERSONA']) and $data['ID_PERSONA'] != ''){
			$sql.=' and ecm.ID_PERSONA='.$data['ID_PERSONA'];
		} 
		if(isset($data['ID_MATRICULA']) and $data['ID_MATRICULA'] != ''){
			$sql.=' and mat.ID_MATRICULA='.$data['ID_MATRICULA'];
		} 
		if(isset($data['NRO_DOCUMENTO']) and $data['NRO_DOCUMENTO']!=''){
			$sql.=" and c.NRO_DOCUMENTO='".$data['NRO_DOCUMENTO']."'";
		} 
		if(isset($data['ID_CARRERA']) and $data['ID_CARRERA']!=''){
			$sql.=' and ca.ID_CARRERA='.$data['ID_CARRERA'];
		}
		if(isset($data['ESTADO_ESTUDIANTE']) and $data['ESTADO_ESTUDIANTE']!=''){
			$sql.=' and mat.ESTADO=0';
		}
		if(isset($data['ID_DOCENTE']) and $data['ID_DOCENTE']!=''){
			$sql.=' and ecm.ID_PERSONA_DOCENTE='.$data['ID_DOCENTE'];
		}
		if(isset($data['ID_ESTUDIANTE_CARRERA_MATERIA']) and $data['ID_ESTUDIANTE_CARRERA_MATERIA']!=''){
			$sql.=' and ecm.ID_ESTUDIANTE_CARRERA_MATERIA='.$data['ID_ESTUDIANTE_CARRERA_MATERIA'];
		}
		if(isset($data['GRUPO']) and $data['GRUPO']!=''){
			$sql.=" and ecm.ID_GRUPO in (select ID_GRUPO from acad_grupo where NOMBRE='".$data['GRUPO']."')";
		}
		if(isset($data['GRUPOS']) and $data['GRUPOS']!=''){
			$sql.=" and ecm.ID_GRUPO in (select ID_GRUPO from acad_grupo where NOMBRE in (".$data['GRUPOS']."))";
		}
		$sql.=' order by NOMBRE_ESTUDIANTE';
		$query=$this->db->query($sql);
		$resultado = $query->result_array();
		return $resultado;
	}
	
	/////////////////////////////////////////////////
	public function borrarExamenEstudiante($id_estudiante_carrera_materia,$etapa)
    {
		if($id_estudiante_carrera_materia>0 and $etapa!=''){
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA', $id_estudiante_carrera_materia);
			$this->db->where('ETAPA', $etapa);
        	$this->db->delete('acad_examenes_estudiantes'); 
		}
    }
	
	///////////////////////////////////////////////////////////////////
	public function buscarExamenesRemediales($data=array()) 
	{
		$this->db->select('*');
		$this->db->from('acad_examenes_remediales');
		if(isset($data['ID_ESTUDIANTE_CARRERA_MATERIA']) and $data['ID_ESTUDIANTE_CARRERA_MATERIA']!=''){
			$this->db->where('ID_ESTUDIANTE_CARRERA_MATERIA',$data['ID_ESTUDIANTE_CARRERA_MATERIA']);
		}
		if(isset($data['ID_EXAMEN_REMEDIAL']) and $data['ID_EXAMEN_REMEDIAL']!=''){
			$this->db->where('ID_EXAMEN_REMEDIAL',$data['ID_EXAMEN_REMEDIAL']);
		}
		if(isset($data['TIPO_EXAMEN']) and $data['TIPO_EXAMEN']!=''){
			$this->db->where('TIPO_EXAMEN',$data['TIPO_EXAMEN']);
		}
		if(isset($data['ESTADO']) and $data['ESTADO']!=''){
			$this->db->where('ESTADO',$data['ESTADO']);
		}
		if(isset($data['FECHA']) and $data['FECHA']!=''){
			$this->db->where('FECHA',$data['FECHA']);
		}
		if(isset($data['HORA']) and $data['HORA']!=''){
			$this->db->where('HORA',$data['HORA']);
		}
		$query = $this->db->get();
		$ds    = $query->result_array();
		return $ds;
	}
	
	////////////////////////////////////////
	public function crearExamenRemedial($datos) 
	{
		$this->db->insert('acad_examenes_remediales', $datos);
		return $this->db->insert_id();
	}
	
	////////////////////////////////////////////////////////////
	public function actualizarExamenRemedial($datos,$idExamenRemedial) 
	{
		$this->db->where('ID_EXAMEN_REMEDIAL', $idExamenRemedial);
		$this->db->update('acad_examenes_remediales', $datos);
	}
	
	////////////////////////////////////////////////////////////
	public function get_periodo_matricula() 
	{
		$this->db->select('VALOR');
		$this->db->from('acad_parametro');
		$this->db->where('NOMBRE','id_periodo_matricula');
		$query = $this->db->get();
		$ds = $query->row_array();
		if (count($ds)>0){
			return $ds['VALOR'];
		}else{
			return false;
		}
	}
	
	///////////////////////////////////////////////////////////////////
	public function buscar_ies($data=array()) 
	{
		$this->db->select('*');
		$this->db->from('tab_ies');
		if(isset($data['ID_IES']) and $data['ID_IES']!=''){
			$this->db->where('ID_IES',$data['ID_IES']);
		}
		if(isset($data['COD_IES']) and $data['COD_IES']!=''){
			$this->db->like('CODIGO', $data['COD_IES'], 'both');
			$this->db->or_like('IES', $data['COD_IES'], 'both');
		}
		$query = $this->db->get();
		$ds    = $query->result_array();
		return $ds;
	}
	
	////////////////////////////////////////////////////////////
	public function get_homologacion($id_carrera=0,$id_persona=0) 
	{
		$this->db->select('h.*,i.CODIGO,i.IES');
		$this->db->from('acad_homolgacion h');
		$this->db->join('tab_ies i','i.ID_IES=h.ID_IES','left');
		$this->db->join('acad_matricula m','m.ID_MATRICULA=h.ID_MATRICULA');
		$this->db->where('m.ID_PERSONA',$id_persona);
		$this->db->where('m.ID_CARRERA',$id_carrera);
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds;
	}
	
	////////////////////////////////////////
	public function crearHomologacion($datos) 
	{
		$this->db->insert('acad_homolgacion', $datos);
		return $this->db->insert_id();
	}
	
	////////////////////////////////////////////////////////////
	public function actualizarHomologacion($datos,$idHomologacion) 
	{
		$this->db->where('ID_HOMOLOGACION', $idHomologacion);
		$this->db->update('acad_homolgacion', $datos);
	}
	
	///////////////////////////////////////
	public function getPeriodo($idp=0) 
	{
		$this->db->select('*');
		$this->db->from('acad_periodo_academico');
		$this->db->where('ID_PERIODO_ACADEMICO',$idp);
		$query = $this->db->get();
		$ds = $query->row_array();
		return $ds;
	}
	
	
	public function getNombresGrupoDeming($id_pediodo_academico, $id_carrera){
	    $sql = 'SELECT DISTINCT NOMBRE FROM acad_grupo WHERE ID_GRUPO IN ';
        $sql .='(SELECT `ID_GRUPO` FROM acad_planificacion WHERE ID_PERIODO_ACADEMICO ='.$id_pediodo_academico.') ';
        $sql .= 'AND ID_CARRERA ='.$id_carrera;

        $sql.=' order by NOMBRE';
        $query=$this->db->query($sql);
        $resultado = $query->result_array();
        return $resultado;
    }
	
	public function get_ids_carreras($idsCarrera){
        $this->db->select('*');
        $this->db->from('acad_carrera');
        if(count($idsCarrera)>0){
            $this->db->where_in('ID_CARRERA',$idsCarrera);
        }
        $query = $this->db->get();
        $ds = $query->result_array();
        return $ds;
    }
	
	//////////////////////////////////////////////////
	public function getDocentesPeriodo($id_periodo=null)
	{
		if($id_periodo==null){
			$id_periodo=$this->get_periodo_activado();	
		}
		$this->db->select('*');
        $this->db->from('acad_docente_carrera_materia');
        $this->db->where('ID_PERIODO_ACADEMICO',$id_periodo);
        $query = $this->db->get();
        $ds = $query->result_array();
        return $ds;
	}
	
	//////////////////////////////////////////////////
	public function copiarDocentesPeriodo($id_periodo_anterior=null,$id_periodo_nuevo=null)
	{
		$sql ="insert into acad_docente_carrera_materia (ID_PERSONA, ID_CARRERA_MATERIA,NIVEL_MATERIA, ID_CARRERA) select ID_PERSONA, ID_CARRERA_MATERIA, NIVEL_MATERIA, ID_CARRERA from acad_docente_carrera_materia where ID_PERIODO_ACADEMICO=".$id_periodo_anterior;
		$this->db->query($sql);
		$sql ="update acad_docente_carrera_materia set ID_PERIODO_ACADEMICO=".$id_periodo_nuevo." where ID_PERIODO_ACADEMICO=0";
		$this->db->query($sql);
	}
	
	////////////////////////////////////////////////
	public function ultimaActualizacionRetos($idPlantilla) 
	{
		$dat_reto=NULL;
		$this->db->select('*');
        $this->db->from('acad_retos_proyectos');
        $this->db->where('ID_PLANTILLA',$idPlantilla);
		$this->db->where('TIPO','0');
		$this->db->order_by('FECHA_CREACION','DESC');
        $query = $this->db->get();
        $fc = $query->row_array();
		if($fc!=NULL){
			$dat_reto=array('FECHA'=>$fc['FECHA_CREACION'],'ID_USUARIO'=>$fc['ID_USUARIO']);
			$this->db->select('*');
			$this->db->from('acad_retos_proyectos');
			$this->db->where('ID_PLANTILLA',$idPlantilla);
			$this->db->where('TIPO','0');
			$this->db->order_by('FECHA_MODIFICACION','DESC');
			$query = $this->db->get();
			$fa = $query->row_array();
			if($fa['FECHA_MODIFICACION']!=NULL and date_create($fa['FECHA_MODIFICACION'])>date_create($fc['FECHA_CREACION'])){
				$dat_reto=array('FECHA'=>$fa['FECHA_MODIFICACION'],'ID_USUARIO'=>$fa['ID_USUARIO_MODIFICACION']);;
			}
		}
		return $dat_reto;
	}
	
	////////////////////////////////////////////////
	public function ultimaActualizacionProyectos($idPlantilla) 
	{
		$dat_proyecto=NULL;
		$this->db->select('*');
        $this->db->from('acad_retos_proyectos');
        $this->db->where('ID_PLANTILLA',$idPlantilla);
		$this->db->where('TIPO',1);
		$this->db->order_by('FECHA_CREACION','DESC');
        $query = $this->db->get();
        $fc = $query->row_array();
		if($fc!=NULL){
			$dat_proyecto=array('FECHA'=>$fc['FECHA_CREACION'],'ID_USUARIO'=>$fc['ID_USUARIO']);
			$this->db->select('*');
			$this->db->from('acad_retos_proyectos');
			$this->db->where('ID_PLANTILLA',$idPlantilla);
			$this->db->where('TIPO',1);
			$this->db->order_by('FECHA_MODIFICACION','DESC');
			$query = $this->db->get();
			$fa = $query->row_array();
			if($fa['FECHA_MODIFICACION']!=NULL and date_create($fa['FECHA_MODIFICACION'])>date_create($fc['FECHA_CREACION'])){
				$dat_proyecto=array('FECHA'=>$fa['FECHA_MODIFICACION'],'ID_USUARIO'=>$fa['ID_USUARIO_MODIFICACION']);;
			}
		}
		return $dat_proyecto;
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////
	public function asesoresEstudiantes($data=array())
	{
		if(!isset($data['ID_PERIODO_ACADEMICO']) or $data['ID_PERIODO_ACADEMICO']<=0){
			$data['ID_PERIODO_ACADEMICO']=$this->get_periodo_activado();
		}
		$this->db->select("CONCAT_WS(' ',p.APELLIDO_PATERNO, p.APELLIDO_MATERNO,p.PRIMER_NOMBRE, p.SEGUNDO_NOMBRE) as ESTUDIANTE, p.ID_PERSONA, m.ID_PERIODO_ACADEMICO, m.ESTADO as ESTADO_MATRICULA, cli.ID_CLIENTE, m.ID_NIVEL, an.NIVEL, m.ID_CARRERA, ac.NOMBRE as CARRERA, cli.NRO_DOCUMENTO, m.ID_MATRICULA, g.NOMBRE as GRUPO, p.REFERIDO, u.ID_USUARIO, ae.ID_USUARIO_COMISIONISTA, ae.ID_USUARIO_ACADEMICO, ae.ID_USUARIO_FINANCIERO, ua.NOMBRE_COMPLETO as ACADEMICO, uf.NOMBRE_COMPLETO as FINANCIERO ",false);
		$this->db->from('acad_matricula m');
		$this->db->join('tab_personas p', 'p.ID_PERSONA = m.ID_PERSONA ');
		$this->db->join('tab_clientes_naturales cn', 'cn.ID_PERSONA = p.ID_PERSONA ');
		$this->db->join('tab_clientes cli', 'cli.ID_CLIENTE =cn.ID_CLIENTE ');
		$this->db->join('acad_carrera ac', 'm.ID_CARRERA = ac.ID_CARRERA ');
		$this->db->join('acad_nivel an', 'm.ID_NIVEL = an.ID_NIVEL ');
		$this->db->join('acad_grupo g', 'g.ID_GRUPO = m.ID_GRUPO ');
		$this->db->join('admin_usuarios u', 'u.ID_PERSONA = m.ID_PERSONA ');
		$this->db->join('acad_asesor_estudiante ae', 'ae.ID_USUARIO_ESTUDIANTE = u.ID_USUARIO ','left');
		//$this->db->join('admin_usuarios uc', 'uc.ID_USUARIO = ae.ID_USUARIO_COMISIONISTA ','left');
		$this->db->join('admin_usuarios ua', 'ua.ID_USUARIO = ae.ID_USUARIO_ACADEMICO ','left');
		$this->db->join('admin_usuarios uf', 'uf.ID_USUARIO = ae.ID_USUARIO_FINANCIERO ','left');
		$this->db->where('m.ID_PERIODO_ACADEMICO',$data['ID_PERIODO_ACADEMICO']);
		if(isset($data['ID_CARRERA']) and $data['ID_CARRERA']>0){
			$this->db->where('m.ID_CARRERA',$data['ID_CARRERA']);
		}
		if(isset($data['ESTADOS_MATRICULA']) and count($data['ESTADOS_MATRICULA'])>0){
			$this->db->where_in('m.ESTADO',$data['ESTADOS_MATRICULA']);
		}
		if(isset($data['ID_NIVEL']) and $data['ID_NIVEL']>0){
			 $this->db->where('m.ID_NIVEL',$data['ID_NIVEL'] );
		}
		if(isset($data['GRUPO']) and $data['GRUPO']!='' and $data['GRUPO']!=NULL){
			$this->db->where("m.ID_GRUPO in (select ID_GRUPO from acad_grupo where NOMBRE like '".$data['GRUPO']."')");
		}
		if(isset($data['ID_USUARIO_COMISIONISTA']) and $data['ID_USUARIO_COMISIONISTA']!='' and $data['ID_USUARIO_COMISIONISTA']!=NULL){
			//$this->db->where('uc.ID_USUARIO',$data['ID_USUARIO_COMISIONISTA'] );
			$this->db->where('u.ID_USUARIO in (select ID_USUARIO_ESTUDIANTE from fac_comisionista_estudiantes where ID_USUARIO_COMISIONISTA='.$data['ID_USUARIO_COMISIONISTA'].')');
		}
		if(isset($data['ID_USUARIO_ACADEMICO']) and $data['ID_USUARIO_ACADEMICO']!='' and $data['ID_USUARIO_ACADEMICO']!=NULL){
			$this->db->where('ua.ID_USUARIO',$data['ID_USUARIO_ACADEMICO'] );
		}
		if(isset($data['ID_USUARIO_FINANCIERO']) and $data['ID_USUARIO_FINANCIERO']!='' and $data['ID_USUARIO_FINANCIERO']!=NULL){
			$this->db->where('uf.ID_USUARIO',$data['ID_USUARIO_FINANCIERO'] );
		}
		$this->db->order_by("ESTUDIANTE","asc");
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	//////////////////////////////////////////////////
	public function getAsesorEstudiante($id_usuario)
	{
		$this->db->select('*');
        $this->db->from('acad_asesor_estudiante');
        $this->db->where('ID_USUARIO_ESTUDIANTE',$id_usuario);
        $query = $this->db->get();
        $ds = $query->row_array();
        return $ds;
	}
	
	////////////////////////////////////////
	public function crearAsesorEstudiante($datos) 
	{
		$this->db->insert('acad_asesor_estudiante', $datos);
	}
	
	////////////////////////////////////////////////////////////
	public function actualizarAsesorEstudiante($datos,$idUsuario) 
	{
		$this->db->where('ID_USUARIO_ESTUDIANTE', $idUsuario);
		$this->db->update('acad_asesor_estudiante', $datos);
	}
	
	////////////////////////////////////////////////////////////////////////////////////
	public function datos_primera_matricula_estudiante($id_cliente,$id_carrera=null,$id_nivel=null)
	{
		$sql = "select *";
		$sql .= " from acad_matricula m";
		$sql .= " join tab_clientes_naturales cn on cn.ID_PERSONA=m.ID_PERSONA ";
		$sql .= " where cn.ID_CLIENTE=".$id_cliente;
		if($id_carrera!=null){
			$sql .= " and m.ID_CARRERA=".$id_carrera;
		}
		if($id_nivel!=null){
			$sql .= " and m.ID_NIVEL=".$id_nivel;
		}
		$sql .= " order by m.ID_MATRICULA ASC LIMIT 1";
		$query = $this->db->query($sql);
		$ds = $query->row_array();
		return $ds;
	}
	
	//////////////////////////////////////////////////////////////
	public function get_log_vlc($dat=array())
	{
		if(count($dat)>0){
			$this->db->select('*');
			$this->db->from('tab_log_send_vlc');
			if(isset($dat['CEDULA']) and $dat['CEDULA']!=''){
				$this->db->where('CEDULA',$dat['CEDULA']);
			}
			$query = $this->db->get();
			$ds = $query->row_array();
			return $ds;
		}
	}
	
	////////////////////////////////////////////////
	public function get_beca($idBeca) 
	{
		$this->db->select('*');
		$this->db->from('tab_tipos_becas');
		$this->db->where('ID_TIPO_BECA',$idBeca);
		$consulta = $this->db->get();
		$resultado = $consulta->row_array();
		return $resultado;
	}
	
	////////////////////////////////////////////////
	public function get_carrera_mencion($idCarrera=0) 
	{
		$this->db->select('cm.*,m.MENCION');
		$this->db->from('acad_carrera_mencion cm');
		$this->db->join('tab_menciones m','m.ID_MENCION=cm.ID_MENCION');
		$this->db->where('cm.ID_CARRERA',$idCarrera);
		$consulta = $this->db->get();
		$resultado = $consulta->result_array();
		return $resultado;
	}
	
	////////////////////////////////////////////////
	public function get_menciones() 
	{
		$this->db->select('*');
		$this->db->from('tab_menciones');
		$consulta = $this->db->get();
		$resultado = $consulta->result_array();
		return $resultado;
	}
	
	///////////////////////////////////////////
	public function borrar_mencion_carrera($idCarrera)
	{
		if($idCarrera>0){
			$this->db->where('ID_CARRERA', $idCarrera);
			$this->db->delete('acad_carrera_mencion');
		}
	}
	
	////////////////////////////////////////
	public function crear_mencion_carrera($datos) 
	{
		$this->db->insert('acad_carrera_mencion', $datos);
	}
	
	////////////////////////////////////////////////
	public function get_plantilla($idPlantilla) 
	{
		$this->db->select('*');
		$this->db->from('acad_plantillas');
		$this->db->where('ID_PLANTILLA', $idPlantilla);
		$consulta = $this->db->get();
		$resultado = $consulta->row_array();
		return $resultado;
	}
	
	//////////////////////////////////////////////////////////////
	public function getPlanificaciones($id_grupo,$id_carrera_materia,$id_periodo=null)
	{
		if($id_periodo==null){
			$id_periodo=$this->get_periodo_activado();
		}
		$this->db->select('p.*');
		$this->db->from('acad_planificacion p');
		$this->db->where('p.ID_GRUPO', $id_grupo);
		$this->db->where('p.ID_CARRERA_MATERIA', $id_carrera_materia);
		$this->db->where('p.ID_PERIODO_ACADEMICO', $id_periodo);
		$this->db->order_by('p.FECHA_CIERRE', 'ASC');
		$query = $this->db->get();
		$ds = $query->result_array();
		return $ds;
	}
	
	///////////////////////////////////////////////////////
	public function crear_estudiante_carrera_materia($datos) 
	{
		$this->db->insert('acad_estudiante_carrera_materia', $datos);
		return $this->db->insert_id();
	}
	
}