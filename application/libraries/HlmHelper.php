<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HlmHelper{
	public function genView($view='',$data=array())
	{	
		$CI =& get_instance();
		
		$data['foto'] = "";
		$data['name'] = "";
		$data['userGroup'] = "";
		if ($view=="") {
			$view = "dashboard/dashboard";
		}
		
        $data['title'] = "WIKA";
		$data['year'] = "2019";
		$data['version'] = "1.0";
		
		$CI->load->view('template/header',$data);
		$CI->load->view('template/sidebar',$data);
		$CI->load->view($view,$data);
		$CI->load->view('template/footer',$data);
	}

	public function throwError(){
		return $this->genView('template/error');
	}

	public function throwForbidden(){
		return $this->genView('template/error');
	}

	static function validateDate($date)
	{
	  if (stripos($date,":")) {
	    $d = DateTime::createFromFormat('Y-m-d H:i:s', $date);
	    $format = "Y-m-d H:i:s";
	  }else{
	    $d = DateTime::createFromFormat('Y-m-d', $date);
	    $format = "Y-m-d";
	  }

	  return $d && ($d->format($format) === $date) ;
	  
	}

	public static function ajaxHilman($table_name="",$tbl_id="",$hide_column="",$columns=array(),$custom_where="",$custom_order="",$custom_if=array(),$method_link=array(),$icon_img=array(),$custom_group="",$custom_link=array(),$custom_field=array(),$custom_thick=false,$requestMenu="",$custom="")
	{
		$requestData= $_REQUEST;
		$CI =& get_instance();
		$custom_where2= "";
		if ($custom_where!="") {
			$custom_where2 = " where ".$custom_where;
		}
		$sql_raw = "SELECT count($tbl_id) as total FROM ".$table_name." ".$custom_where2;
		//$sql_raw = "SELECT ID_KPI_L1 FROM KPI_L1 k WHERE 1=1 ORDER BY ID_KPI_L1 offset 10";
		//echo $sql_raw;die();
		$get_total = $CI->db->query($sql_raw)->result();
		$totalData = $get_total[0]->TOTAL;

		$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
		if ($custom_where!="") {
			$custom_where = " and ".$custom_where;
		}

		if (stripos($tbl_id, ".")){
			$tbl_id = explode('.', $tbl_id);
			$tbl_id = $tbl_id[1];
		}

		$sql = "SELECT ";
		for ($i=0; $i < count($columns) ; $i++) { 
			if ($i==(count($columns)-1)){
				$sql.=$columns[$i];
			}else{
				$sql.=$columns[$i].",";
			}
		}
		$sql.=" FROM ".$table_name." WHERE 1=1";
		if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
			if (stripos($columns[0], " as ")) {
				$columns[0] = explode("as", $columns[0]);
				$columns[0] = trim($columns[$i][1]);
			}
			$sql.=" AND ( ".$columns[0]." LIKE '%".$requestData['search']['value']."%' ";    
			for ($i=1; $i < count($columns)-1 ; $i++) { 
				if (stripos($columns[$i], " as ")) {
					$columns[$i] = explode(" as ", $columns[$i]);
					$findData = trim($columns[$i][0]);
					$columns[$i] = trim($columns[$i][1]);
					
					$sql.=" OR ".$findData." LIKE '%".$requestData['search']['value']."%' ";
				}else{
					$sql.=" OR ".$columns[$i]." LIKE '%".$requestData['search']['value']."%' ";
				}
			}
			if (stripos($columns[count($columns)-1], " as ")) {
				$columns[count($columns)-1] = explode(" as ", $columns[count($columns)-1]);
				$columns[count($columns)-1] = trim($columns[count($columns)-1][0]);
				if ($columns[$i] == "amount_debet") {
					$findData = "amount";
				}elseif($columns[$i] == "amount_kredit"){
					$findData = "amount";
				}else{
					$findData = $columns[$i];
				}
				$sql.=" OR ".$findData." LIKE '%".$requestData['search']['value']."%' ";
				$sql .= ")";
			}else{
				$sql.=" OR ".$columns[count($columns)-1]." LIKE '%".$requestData['search']['value']."%' ) ";
			}
		}
		$sql.= $custom_where;


		if ($custom_group!="") {
			$sql .= " group by ".$custom_group;
		}
		//echo $sql;die();
		$query = $query_run = $CI->db->query($sql)->result();
		
		$totalFiltered = count($query);
		
		if ($custom_order!="") {
			$sql.= " ORDER BY ".$custom_order." LIMIT ".$requestData['start']." ,".$requestData['length']." ";
		}else{
			if (strpos($columns[$requestData['order'][0]['column']], " as "))  {
				$getColumn = $columns[$requestData['order'][0]['column']];
				$getColumn = explode(" as ", $columns[$requestData['order'][0]['column']]);
				$columns[$requestData['order'][0]['column']] = $getColumn[1];
			}
			$sql.=" ORDER BY ".$columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']." OFFSET ".$requestData['start']." ROWS FETCH NEXT ".$requestData['length']." ROWS ONLY";
		}
		//echo $sql;die();
		$query = $query_run = $CI->db->query($sql)->result();
		
		$data = array();
		$no = $requestData['start']+1;
		foreach ($query as $key => $value) {
			$nestedData=array();
		 	$nestedData[] = $no;
		 	$no++;
		 	
			for ($i=0; $i < count($columns); $i++) {
				$cek =array();
				if ($columns[$i]!==$hide_column) {
					if (strpos($columns[$i], " as ")) {
						$cek =  $columns[$i];
						$columns[$i] = explode(" as ", $columns[$i]);
						$columns[$i] = trim($columns[$i][1]);
					}

					if (stripos($columns[$i],".")) {
						$get = explode(".", $columns[$i]);
						$columns[$i] = trim($get[1]);
					}

					
					if (HlmHelper::validateDate($value->$columns[$i])) {
						$getDate = date_create($value->$columns[$i]);
						$value->$columns[$i] = date_format($getDate,'d/m/Y');
					}elseif ($value->$columns[$i]=="0000-00-00") {
						$value->$columns[$i] = "00/00/0000";
					}elseif ($value->$columns[$i]=="0000-00-00 00:00:00") {
						$value->$columns[$i] = "00/00/0000 00:00:00";
					}

					if (!empty($custom_field)) {
						foreach ($custom_field as $fieldName => $valChange) {
							if ($fieldName==$columns[$i]) {
								foreach ($valChange as $keyName => $newVal) {
									if ($value->$columns[$i]==$keyName) {
										$value->$columns[$i] = $newVal;
									}								
								}
							}
						}
					}

					if (count($custom_link)>0) {
						foreach ($custom_link as $field => $valField) {
							if ($field==$columns[$i]) {
								$value->$columns[$i] = "<a style='color:blue' href='".base_url().$valField.".".$value->$tbl_id."/".$requestMenu."'>".$value->$columns[$i]."</a>";
							}
						}
					}
					$nestedData[] = $value->$columns[$i];
				}
			}

			if ($custom_thick!="") {
				$nestedData[] ='<input type="checkbox" name="'.$custom_thick.'['.$value->$tbl_id.']" data_id="'.$custom_thick.'['.$value->$tbl_id.']">';
			}

			//custom filesize
			if ($custom=="majagemen") {
				$totalMegabytes = 0;
				$fileUploads = $CI->db->where('id_document',$value->id)->get('file_uploads')->result();
				$getOldata = $CI->db->where('id',$value->id)->get('documents')->result();
				$jumlahFile = 0;
				// foreach ($fileUploads as $keyFile => $valueFile) {
				// 	$fileLoc = "./data_uploads/documents/".$getOldata[0]->id_level_1."/".$valueFile->file_name;
				// 	$bytes = filesize($fileLoc);
		  //           $kilobytes = $bytes/1024;
		  //           $megabytes = $kilobytes/1024;
		  //           $totalMegabytes = $totalMegabytes + $megabytes;
		  //           $jumlahFile++;
				// }
				
	   //          $nestedData[] = round($totalMegabytes,2)." MB ($jumlahFile File)";
				$nestedData[] = round(10,2)." MB ($jumlahFile File)";
			}

			if ($custom=="unit") {
				$totalMegabytes = 0;
				$getKodeUnitKerja = $CI->db->where('id',$value->id)->get('unit_kerja')->result();

				$fileUploads = $CI->db->query('select d.id_level_1,d.kode_unit_kerja,fu.* from documents as d join file_uploads as fu on d.id = fu.id_document where d.kode_unit_kerja = "'.$getKodeUnitKerja[0]->kode_unit_kerja.'"')->result();
				$jumlahFile = 0;
				foreach ($fileUploads as $keyFile => $valueFile) {
					$fileLoc = "./data_uploads/documents/".$valueFile->id_level_1."/".$valueFile->file_name;
					$bytes = filesize($fileLoc);
		            $kilobytes = $bytes/1024;
		            $megabytes = $kilobytes/1024;
		            $totalMegabytes = $totalMegabytes + $megabytes;
		            $jumlahFile++;
				}
				
	            $nestedData[] = round($totalMegabytes,2)." MB ($jumlahFile File)";
			}
			//end custom filesize

			if (count($custom_if)>0) {
				$val = (key($custom_if));
				if ($value->$val==$custom_if[key($custom_if)]) {
					$link = "";
					foreach ($method_link as $key2 => $value2) {
						$tipe = "info";
						$del = "";
						if (stripos($icon_img[$key2],"_")) {
							$getTipe = explode("_", $icon_img[$key2]);
							$tipe = $getTipe[1];
							$icon = $getTipe[0];
							$describ = "";
							if (isset($getTipe[2])) {
								$describ = $getTipe[2];
							}

							if (stripos($tipe, 'anger') || stripos($tipe, 'arning')) {
								$del = "onclick='return confirm(\"Apakah anda yakin ?\")'";
							}
						}else{
							$icon = $icon_img[$key2];
						}
						if (stripos(" ".$value2, "Click")) {
							$value2 = str_replace("id",$value->$tbl_id, $value2);
							$link .= "<a ".$value2."  style='margin-right:0px' class='btn btn-".$tipe."' title='".$key2."' ><span class='".$icon."'></span> $describ</a>";
						}else{
							$link .= "<a style='margin-right:0px' class='btn btn-".$tipe."' href='".base_url().$value2."/".$value->$tbl_id."/' title='".$key2."' data-id='".$value->$tbl_id."/".$requestMenu."' ".$del." ><span class='".$icon."'></span> $describ</a>";
						}
						
					}
					if ($link!="") {
						$nestedData[] = $link;
					}else{
						$nestedData[] = "N/A";
					}
				}else{
					$nestedData[] = "N/A";
				}
			}elseif(empty($custom_if)){
				$link = "";
				foreach ($method_link as $key2 => $value2) {
					$tipe= "info";
					$del = "";
					$describ = "";
					if (stripos($icon_img[$key2],"_")) {
						$getTipe = explode("_", $icon_img[$key2]);
						$tipe = $getTipe[1];
						$icon = $getTipe[0];
						$describ = "";
						if (isset($getTipe[2])) {
							$describ = $getTipe[2];
						}

						if (stripos($tipe, 'anger') || stripos($tipe, 'arning')) {
							$del = "onclick='return confirm(\"Apakah anda yakin ?\")'";
						}
					}else{
						$icon = $icon_img[$key2];
					}
					if (stripos(" ".$value2, "onClick")) {
						$value2 = str_replace("id",$value->$tbl_id, $value2);
						$link .= "<a ".$value2."  style='margin-right:0px' class='btn btn-".$tipe."' title='".$key2."'><span class='".$icon."'></span> $describ</a>";
					}else{
						$link .= "<a style='margin:1px' class='btn btn-".$tipe."' href='".base_url().$value2.".".$value->$tbl_id."/".$requestMenu."' title='".$key2."' data-id='".$value->$tbl_id."' ".$del." ><span class='".$icon."'></span> $describ</a>";	
					}			
				}
				if ($link!="") {
					$nestedData[] = $link;
				}else{
					$nestedData[] = "N/A";
				}
			}else{
				$nestedData[] = "N/A";
			}
			$data[] = $nestedData;
		}

		$json_data = array(
					"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalFiltered ),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   // total data array
					);

		echo json_encode($json_data);  // send data as json format
	}

	public function genDocumentId($idDocument="")
	{
		$CI =& get_instance();
		$CI->db->insert('seq_no_dicument',array('id_document'=>$idDocument));
		$getSeqNumber = $CI->db->where('id_document',$idDocument)->get('seq_no_dicument')->result();
		$resID = $getSeqNumber[0]->id;
		$lenId = strlen($resID);
		for ($i=0; $i < (7-$lenId) ; $i++) { 
			$resID = "0".$resID;
		}

		$CI->db->where('id_document',$idDocument)->delete('seq_no_dicument');

		return $resID;
	}

	public function getAbjad(){
		return array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	}

	public function genCode($first){
		$CI =& get_instance();
        $chars = "123456789ABCDEFGHIJLMNPQRSTUVWXYZ";
        $res = "";
        $check = true;
        while ($check) {
            for ($i = 0; $i < 9; $i++) {
             $res .= $chars[mt_rand(0, strlen($chars)-1)];
            }
            $res = $first.$res;
            $checkAvailable = $CI->db->where('qr_code',$res)->get('kardus')->result();
            if (count($checkAvailable) == 0) {
                $check=false;
            }
        }
            
        return $res;
    }

    public function genQr($prefix){
    	$CI =& get_instance();
        $PNG_TEMP_DIR = $_SERVER['DOCUMENT_ROOT']."/efile_v2/data_uploads/qr/";
        $check = true;
        while ($check) {
        	$res = HlmHelper::genCode($prefix);
        	$checkAvailable = $CI->db->where('qr_code',$res)->get('kardus')->result();
        	if (count($checkAvailable) == 0) {
        		$check=false;
        	}
        }
        $CI->load->library('phpqrcode/qrlib');
        $filename = $PNG_TEMP_DIR.$res.'.png';
        QRcode::png($res, $filename, "M", "20", 2);  
        
        return $res;
    }

    public function auth()
    {
    	$CI =& get_instance();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        //JWT Auth middleware
        $headers = $CI->input->get_request_header('Authorization');
        $apiKey = $CI->input->get_request_header('x-api-key');

        $kunci = SALT; //secret key for encode and decode
        $token= "token";
       	if (!empty($headers) && !empty($apiKey)) {
        	if (preg_match('/Bearer\s(\S+)/', $headers , $matches)) {
            	$token = $matches[1];
        	}

        	if ($apiKey != '3dncu32823hrnfosjd7dshy728uebjsuwg2jefhfuhe') {
        		$CI->response(['error' => 'Invalid API KEY'], 401);//401
        	}
        	
    	}
        try {
           $decoded = JWT::decode($token, $kunci, array('HS256'));
           $CI->user_data = $decoded;
        } catch (Exception $e) {
            $invalid = ['error' => $e->getMessage()]; //Respon if credential invalid
            $CI->response($invalid, 401);//401
        }
    }

    public function debug($data){
    	echo "<pre>";
    	print_r($data);
    	die();
    }

    public static function sendEmail($to="",$message="Test Message from WIKA e-File System")
    {	  
    	$CI =& get_instance();
        $config = Array(
          'protocol' => 'smtp',
          'smtp_host' => 'ssl://wbmail.wika-beton.co.id',
          'smtp_port' => 465,
          'smtp_user' => 'hc@wika-beton.co.id', // change it to yours
          'smtp_pass' => 'w1k4b3t0n', // change it to yours
          'mailtype' => 'html',
          'smtp_timeout'=>'30',
          'charset' => 'iso-8859-1',
          'wordwrap' => TRUE
        );

        $CI->load->library('email', $config);
        $CI->email->initialize($config);
        $CI->email->set_newline("\r\n");
        $CI->email->from('hc@wika-beton.co.id'); // change it to yours
        $CI->email->to($to);// change it to yours
        $CI->email->subject('Email Notifikasi e-File System');
        $CI->email->message($message);
        if($CI->email->send())
        {
            echo 'Email sent.';
        }
        else
        {
            show_error($CI->email->print_debugger());
        }
    }

    public function sendInfo($nipPeminjam = "WB030025",$nipPengupload = "",$idDocument = "14"){
    	$CI =& get_instance();
      	$query = 'select d.`digital_number`,
                       d.document_name as nama_dokumen,
                       l1.`name` as level1,
                       l2.name as level2,l3.name as level3,
                       l4.name as level4,l5.name as level5,
                       d.`tgl_notifikasi`,
                       d.`tgl_kadaluarsa`,
                       d.date as tgl_dokumen,
                       d.`change_date` as tgl_upload from documents as d 
                  left join level_1 as l1
                    on d.id_level_1 = l1.id
                  left join level_2 as l2
                    on d.id_level_2 = l2.id
                  left join level_3 as l3
                    on d.id_level_3 = l3.id
                  left join level_4 as l4
                    on d.id_level_4 = l4.id
                  left join level_5 as l5
                    on d.id_level_5 = l5.id
                  where d.id = '.$idDocument;

        $queryPeminjam = "SELECT 
        					email,
        					concat_ws(' ',first_title,name,last_name,last_title) as nama,
        					j.nama_jabatan
        				  FROM users as u 
                          left join jabatan as j 
                          	on u.kode_jabatan = j.kode_jabatan
                          where email = '".$nipPeminjam."'";
        $data['dataPeminjam'] = $CI->db->query($queryPeminjam)->result();
      	
      	$queryPengupload = "SELECT 
        					email,
        					concat_ws(' ',first_title,name,last_name,last_title) as nama,
        					j.nama_jabatan
        				  FROM users as u 
                          left join jabatan as j 
                          	on u.kode_jabatan = j.kode_jabatan
                          where email = '".$nipPeminjam."'";
        $data['dataPengupload'] = $CI->db->query($queryPengupload)->result();
      	$data['dataFile'] = $getData = $CI->db->query($query)->result();
      	$msg = $CI->load->view('infoPeminjaman',$data,TRUE);  
      	HlmHelper::sendEmail('syafeihilman@gmail.com',$msg);  
    }
}