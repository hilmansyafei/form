<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{	
		$this->kpl1();
	}

	function generateID($table,$ID){
		$data = $this->db->select($ID)->like($ID, date('Y'), 'after')->order_by($ID,'DESC')->limit(1)->get($table)->result();

		if (empty($data)) {
			return date('Y')."000001";
		}
		
		return $data[0]->$ID + 1;
	}

	function getDate(){
		$months =  array(
            "01"=>"JAN",
            "02"=>"FEB",
            "03"=>"MAR",
            "04"=>"APR",
            "05"=>"MEI",
            "06"=>"JUN",
            "07"=>"JUL",
            "08"=>"AGUS",
            "09"=>"SEP",
            "10"=>"OKT",
            "11"=>"NOV",
            "12"=>"DES"
        );
		$getMonth = date('m');

		$newDate = date('d')."-".$months[date('m')]."-".date('Y');
		return $newDate;
	}

	public function kpl1($state = "get",$id="",$data = array()){
		$data['dataKunci'] = $this->db->get('TB_KPI_INDI_KIN_KUNCI')->result();
		$data['dataKinerja'] = $this->db->get('TB_KPI_KINERJA')->result();

		$data['upload_path'] = './data_uploads/formula/kpl1/';
		$data['view_path'] = base_url().'/data_uploads/formula/kpl1/';
		switch ($state) {
			case 'get':
				$getData = $this->db
								->from('KPI_L1')
								->join('TB_KPI_INDI_KIN_KUNCI','KPI_L1.ID_INDI_KIN_KUNCI = TB_KPI_INDI_KIN_KUNCI.ID_INDI_KIN_KUNCI','left')
								->join('TB_KPI_KINERJA','KPI_L1.ID_KINERJA_L1 = TB_KPI_KINERJA.ID_KINERJA','left')
								->order_by('CREATED_DATE')
								->get()
								->result();
				$data['data'] = $getData;
				return $this->hlmhelper->genView('form/kpl_1',$data);
				break;
			case 'viewNew':
				$data['statEdit'] = false;
				return $this->hlmhelper->genView('form/viewEdit',$data);
				break;
			case 'viewEdit':
				$data['statEdit'] = true;
				$data['dataEdit'] = $this->db->where('ID_KPI_L1',$id)->get('KPI_L1')->result();
				$data['idParam'] = $id;
				return $this->hlmhelper->genView('form/viewEdit',$data);
				break;
			case 'save.new':
				$getData = $this->input->post(NULL);
				$dataInsert = $getData;
				$dataInsert['ID_KPI_L1'] = $this->generateID('KPI_L1','ID_KPI_L1');
				$dataInsert['CREATED_DATE'] = $this->getDate();
				$dataInsert['CREATED_BY'] = 111111;
				$dataInsert['LAST_UPDATE_DATE'] = $this->getDate();
				$dataInsert['LAST_UPDATE_BY'] = 111111;

				$config['upload_path']          = $data['upload_path'];
        		$config['allowed_types']        = '*';
        		$config['max_size']             = 10000;

				if (is_uploaded_file($_FILES['FORMULA']['tmp_name'])) {
		            $fileName = $_FILES['FORMULA']['name'];
		            $ext = explode('.', $fileName);
		            $ext = end($ext);
		            $newFileName = $config['file_name'] = date('Ymdhis').".".$ext;
		            $this->load->library('upload', $config);
		            if ( ! $this->upload->do_upload('FORMULA'))
		            {
		                $this->session->set_flashdata('error','Uploading problem, please check your file extention !!!');
		                return redirect('welcome/kpl1');
		            }
		            else
		            {
		                $dataInsert['FORMULA'] = trim($newFileName);
		            }
		        }

				$this->db->insert('KPI_L1',$dataInsert);
				$this->session->set_flashdata('success','Data berhasil ditambah');
				return redirect('welcome/kpl1');
				break;
			case 'save.edit':
				$getData = $this->input->post(NULL);
				$idParam = $getData['idParam'];
				unset($getData['idParam']);
				$dataUpdate = $getData;

				$config['upload_path']          = $data['upload_path'];
        		$config['allowed_types']        = '*';
        		$config['max_size']             = 10000;

        		$oldData = $this->db->where('ID_KPI_L1',$idParam)->get('KPI_L1')->result();
				if (is_uploaded_file($_FILES['FORMULA']['tmp_name'])) {
		            $fileName = $_FILES['FORMULA']['name'];
		            $ext = explode('.', $fileName);
		            $ext = end($ext);
		            $newFileName = $config['file_name'] = date('Ymdhis').".".$ext;
		            $this->load->library('upload', $config);
		            if ( ! $this->upload->do_upload('FORMULA'))
		            {
		                $this->session->set_flashdata('error','Uploading problem, please check your file extention !!!');
		                return redirect('welcome/kpl1');
		            }
		            else
		            {
		            	if (file_exists($config['upload_path'].$oldData[0]->FORMULA)) {
		                    unlink($config['upload_path'].$oldData[0]->FORMULA);
		                }
		                $dataUpdate['FORMULA'] = trim($newFileName);
		            }
		        }
				$dataUpdate['LAST_UPDATE_DATE'] = $this->getDate();
				$dataUpdate['LAST_UPDATE_BY'] = 111111;
				
				$this->db->where('ID_KPI_L1',$idParam)->update('KPI_L1',$dataUpdate);
				$this->session->set_flashdata('success','Data berhasil diubah');
				return redirect('welcome/kpl1');
				break;
			case 'delete':
				$upload_path = $data['upload_path'];
				$oldData = $this->db->where('ID_KPI_L1',$id)->get('KPI_L1')->result();
				if (file_exists($upload_path.$oldData[0]->FORMULA)) {
                    unlink($upload_path.$oldData[0]->FORMULA);
                }
				$this->db->where('ID_KPI_L1',$id)->delete('KPI_L1');
				$this->session->set_flashdata('success','Data berhasil dihapus');
				return redirect($this->agent->referrer());
				break;
			default:
				# code...
				break;
		}
	}

	public function kpl2($state = "get",$id="",$data = array()){
		$data['kpl1'] = $this->db->get('KPI_L1')->result();
		$data['pat'] = $this->db->get('TB_PAT')->result();
		$data['gas'] = $this->db->get('TB_GAS')->result();
		$data['jbt'] = $this->db->get('TB_JBT')->result();
		
		$data['upload_path'] = './data_uploads/formula/kpl2/';
		$data['view_path'] = base_url().'/data_uploads/formula/kpl2/';
		switch ($state) {
			case 'get':
				$getData = $this->db
								->select('KPI_L2.*,TB_PAT.KET as PAT,TB_GAS.KET as GAS,TB_JBT.KET as JBT')
								->from('KPI_L2')
								->join('KPI_L1',
									   'KPI_L1.ID_KPI_L1 = KPI_L2.ID_KPI_L1')
								->join('TB_PAT',
									   'TB_PAT.KD_PAT = KPI_L2.KD_PAT','left')
								->join('TB_GAS',
									   'TB_GAS.KD_GAS = KPI_L2.KD_GAS','left')
								->join('TB_JBT',
									   'TB_JBT.KD_JBT = KPI_L2.KD_JBT','left')
								->order_by('KPI_L2.CREATED_DATE')
								->get()
								->result();
				$data['data'] = $getData;
				return $this->hlmhelper->genView('form/kpl_2',$data);
				break;
			case 'viewNew':
				$data['statEdit'] = false;
				return $this->hlmhelper->genView('viewEditKpl2',$data);
				break;
			case 'viewEdit':
				$data['statEdit'] = true;
				$data['idParam'] = $id;
				$data['dataEdit'] = $this->db->where('ID_KPI_L2',$id)->get('KPI_L2')->result();
				return $this->hlmhelper->genView('viewEditKpl2',$data);
				break;
			case 'save.new':
				$getData = $this->input->post(NULL);
				$dataInsert = $getData;
				$dataInsert['ID_KPI_L2'] = $this->generateID('KPI_L2','ID_KPI_L2');
				$dataInsert['CREATED_DATE'] = $this->getDate();
				$dataInsert['CREATED_BY'] = 111111;
				$dataInsert['LAST_UPDATE_DATE'] = $this->getDate();
				$dataInsert['LAST_UPDATE_BY'] = 111111;

				$config['upload_path']          = $data['upload_path'];
        		$config['allowed_types']        = '*';
        		$config['max_size']             = 10000;

				if (is_uploaded_file($_FILES['FORMULA']['tmp_name'])) {
		            $fileName = $_FILES['FORMULA']['name'];
		            $ext = explode('.', $fileName);
		            $ext = end($ext);
		            $newFileName = $config['file_name'] = date('Ymdhis').".".$ext;
		            $this->load->library('upload', $config);
		            if ( ! $this->upload->do_upload('FORMULA'))
		            {
		                $this->session->set_flashdata('error','Uploading problem, please check your file extention !!!');
		                return redirect('welcome/kpl2');
		            }
		            else
		            {
		                $dataInsert['FORMULA'] = trim($newFileName);
		            }
		        }

				$this->db->insert('KPI_L2',$dataInsert);
				$this->session->set_flashdata('success','Data berhasil ditambah');
				return redirect('welcome/kpl2');
				break;
			case 'save.edit':
				$getData = $this->input->post(NULL);
				$idParam = $getData['idParam'];
				unset($getData['idParam']);
				$dataUpdate = $getData;

				$config['upload_path']          = $data['upload_path'];
        		$config['allowed_types']        = '*';
        		$config['max_size']             = 10000;

        		$oldData = $this->db->where('ID_KPI_L2',$idParam)->get('KPI_L2')->result();
				if (is_uploaded_file($_FILES['FORMULA']['tmp_name'])) {
		            $fileName = $_FILES['FORMULA']['name'];
		            $ext = explode('.', $fileName);
		            $ext = end($ext);
		            $newFileName = $config['file_name'] = date('Ymdhis').".".$ext;
		            $this->load->library('upload', $config);
		            if ( ! $this->upload->do_upload('FORMULA'))
		            {
		                $this->session->set_flashdata('error','Uploading problem, please check your file extention !!!');
		                return redirect('welcome/kpl2');
		            }
		            else
		            {
		            	if (file_exists($config['upload_path'].$oldData[0]->FORMULA)) {
		                    unlink($config['upload_path'].$oldData[0]->FORMULA);
		                }
		                $dataUpdate['FORMULA'] = trim($newFileName);
		            }
		        }
				$dataUpdate['LAST_UPDATE_DATE'] = $this->getDate();
				$dataUpdate['LAST_UPDATE_BY'] = 111111;
				
				$this->db->where('ID_KPI_L2',$idParam)->update('KPI_L2',$dataUpdate);
				$this->session->set_flashdata('success','Data berhasil diubah');
				return redirect('welcome/kpl2');
				break;
			case 'delete':
				$upload_path = $data['upload_path'];
				$oldData = $this->db->where('ID_KPI_L2',$id)->get('KPI_L2')->result();
				if (file_exists($upload_path.$oldData[0]->FORMULA)) {
                    unlink($upload_path.$oldData[0]->FORMULA);
                }
				$this->db->where('ID_KPI_L2',$id)->delete('KPI_L2');
				$this->session->set_flashdata('success','Data berhasil dihapus');
				return redirect($this->agent->referrer());
				break;
			default:
				# code...
				break;
		}
	}

	public function kpl3($state = "get",$id="",$data = array()){
		$data['kpl2'] = $this->db->get('KPI_L2')->result();
		$data['pat'] = $this->db->get('TB_PAT')->result();
		$data['gas'] = $this->db->get('TB_GAS')->result();
		$data['jbt'] = $this->db->get('TB_JBT')->result();

		$data['upload_path'] = './data_uploads/formula/kpl3/';
		$data['view_path'] = base_url().'/data_uploads/formula/kpl3/';
		switch ($state) {
			case 'get':
				$getData = $this->db
								->select('KPI_L3.*,
										  TB_PAT.KET as PAT,
										  TB_GAS.KET as GAS,
										  TB_JBT.KET as JBT')
								->from('KPI_L3')
								->join('KPI_L2',
									   'KPI_L2.ID_KPI_L2 = KPI_L3.ID_KPI_L2')
								->join('TB_PAT',
									   'TB_PAT.KD_PAT = KPI_L3.KD_PAT','left')
								->join('TB_GAS',
									   'TB_GAS.KD_GAS = KPI_L3.KD_GAS','left')
								->join('TB_JBT',
									   'TB_JBT.KD_JBT = KPI_L3.KD_JBT','left')
								->order_by('KPI_L3.CREATED_DATE')
								->get()
								->result();
				$data['data'] = $getData;
				return $this->hlmhelper->genView('form/kpl_3',$data);
				break;
			case 'viewNew':
				$data['statEdit'] = false;
				return $this->hlmhelper->genView('viewEditKpl3',$data);
				break;
				break;
			case 'save.new':
				$getData = $this->input->post(NULL);
				$dataInsert = $getData;
				$dataInsert['ID_KPI_L3'] = $this->generateID('KPI_L3','ID_KPI_L3');
				$dataInsert['CREATED_DATE'] = $this->getDate();
				$dataInsert['CREATED_BY'] = 111111;
				$dataInsert['LAST_UPDATE_DATE'] = $this->getDate();
				$dataInsert['LAST_UPDATE_BY'] = 111111;

				$config['upload_path']          = $data['upload_path'];
        		$config['allowed_types']        = '*';
        		$config['max_size']             = 10000;

				if (is_uploaded_file($_FILES['FORMULA']['tmp_name'])) {
		            $fileName = $_FILES['FORMULA']['name'];
		            $ext = explode('.', $fileName);
		            $ext = end($ext);
		            $newFileName = $config['file_name'] = date('Ymdhis').".".$ext;
		            $this->load->library('upload', $config);
		            if ( ! $this->upload->do_upload('FORMULA'))
		            {
		                $this->session->set_flashdata('error','Uploading problem, please check your file extention !!!');
		                return redirect('welcome/kpl2');
		            }
		            else
		            {
		                $dataInsert['FORMULA'] = trim($newFileName);
		            }
		        }

				$this->db->insert('KPI_L3',$dataInsert);
				$this->session->set_flashdata('success','Data berhasil ditambah');
				return redirect('welcome/kpl3');
				break;
			case 'viewEdit':
				$data['statEdit'] = true;
				$data['idParam'] = $id;
				$data['dataEdit'] = $this->db->where('ID_KPI_L3',$id)->get('KPI_L3')->result();
				return $this->hlmhelper->genView('viewEditKpl3',$data);
				break;
			case 'save.edit':
				$getData = $this->input->post(NULL);
				$idParam = $getData['idParam'];
				unset($getData['idParam']);
				$dataUpdate = $getData;

				$config['upload_path']          = $data['upload_path'];
        		$config['allowed_types']        = '*';
        		$config['max_size']             = 10000;

        		$oldData = $this->db->where('ID_KPI_L3',$idParam)->get('KPI_L3')->result();
				if (is_uploaded_file($_FILES['FORMULA']['tmp_name'])) {
		            $fileName = $_FILES['FORMULA']['name'];
		            $ext = explode('.', $fileName);
		            $ext = end($ext);
		            $newFileName = $config['file_name'] = date('Ymdhis').".".$ext;
		            $this->load->library('upload', $config);
		            if ( ! $this->upload->do_upload('FORMULA'))
		            {
		                $this->session->set_flashdata('error','Uploading problem, please check your file extention !!!');
		                return redirect('welcome/kpl3');
		            }
		            else
		            {
		            	if (file_exists($config['upload_path'].$oldData[0]->FORMULA)) {
		                    unlink($config['upload_path'].$oldData[0]->FORMULA);
		                }
		                $dataUpdate['FORMULA'] = trim($newFileName);
		            }
		        }
				$dataUpdate['LAST_UPDATE_DATE'] = $this->getDate();
				$dataUpdate['LAST_UPDATE_BY'] = 111111;
				
				$this->db->where('ID_KPI_L3',$idParam)->update('KPI_L3',$dataUpdate);
				$this->session->set_flashdata('success','Data berhasil diubah');
				return redirect('welcome/kpl3');
				break;
			case 'delete':
				$upload_path = $data['upload_path'];
				$oldData = $this->db->where('ID_KPI_L3',$id)->get('KPI_L3')->result();
				if (file_exists($upload_path.$oldData[0]->FORMULA)) {
                    unlink($upload_path.$oldData[0]->FORMULA);
                }
				$this->db->where('ID_KPI_L3',$id)->delete('KPI_L3');
				$this->session->set_flashdata('success','Data berhasil dihapus');
				return redirect($this->agent->referrer());
				break;
			default:
				# code...
				break;
		}
	}

	public function kpl4($state = "get",$id="",$data = array()){
		$data['kpl3'] = $this->db->get('KPI_L3')->result();
		$data['pat'] = $this->db->get('TB_PAT')->result();
		$data['gas'] = $this->db->get('TB_GAS')->result();
		$data['jbt'] = $this->db->get('TB_JBT')->result();

		$data['upload_path'] = './data_uploads/formula/kpl4/';
		$data['view_path'] = base_url().'/data_uploads/formula/kpl4/';
		switch ($state) {
			case 'get':
				$getData = $this->db
								->select('KPI_L4.*,
										  TB_PAT.KET as PAT,
										  TB_GAS.KET as GAS,
										  TB_JBT.KET as JBT')
								->from('KPI_L4')
								->join('KPI_L3',
									   'KPI_L4.ID_KPI_L3 = KPI_L3.ID_KPI_L3')
								->join('TB_PAT',
									   'TB_PAT.KD_PAT = KPI_L4.KD_PAT','left')
								->join('TB_GAS',
									   'TB_GAS.KD_GAS = KPI_L4.KD_GAS','left')
								->join('TB_JBT',
									   'TB_JBT.KD_JBT = KPI_L4.KD_JBT','left')
								->order_by('KPI_L3.CREATED_DATE')
								->get()
								->result();
				$data['data'] = $getData;
				return $this->hlmhelper->genView('form/kpl_4',$data);
				break;
			case 'viewNew':
				$data['statEdit'] = false;
				return $this->hlmhelper->genView('viewEditKpl4',$data);
				break;
				break;
			case 'save.new':
				$getData = $this->input->post(NULL);
				$dataInsert = $getData;
				$dataInsert['ID_KPI_L4'] = $this->generateID('KPI_L4','ID_KPI_L4');
				$dataInsert['CREATED_DATE'] = $this->getDate();
				$dataInsert['CREATED_BY'] = 111111;
				$dataInsert['LAST_UPDATE_DATE'] = $this->getDate();
				$dataInsert['LAST_UPDATE_BY'] = 111111;

				$config['upload_path']          = $data['upload_path'];
        		$config['allowed_types']        = '*';
        		$config['max_size']             = 10000;

				if (is_uploaded_file($_FILES['FORMULA']['tmp_name'])) {
		            $fileName = $_FILES['FORMULA']['name'];
		            $ext = explode('.', $fileName);
		            $ext = end($ext);
		            $newFileName = $config['file_name'] = date('Ymdhis').".".$ext;
		            $this->load->library('upload', $config);
		            if ( ! $this->upload->do_upload('FORMULA'))
		            {
		                $this->session->set_flashdata('error','Uploading problem, please check your file extention !!!');
		                return redirect('welcome/kpl2');
		            }
		            else
		            {
		                $dataInsert['FORMULA'] = trim($newFileName);
		            }
		        }

				$this->db->insert('KPI_L4',$dataInsert);
				$this->session->set_flashdata('success','Data berhasil ditambah');
				return redirect('welcome/kpl4');
				break;
			case 'viewEdit':
				$data['statEdit'] = true;
				$data['idParam'] = $id;
				$data['dataEdit'] = $this->db->where('ID_KPI_L4',$id)->get('KPI_L4')->result();
				return $this->hlmhelper->genView('viewEditKpl4',$data);
				break;
			case 'save.edit':
				$getData = $this->input->post(NULL);
				$idParam = $getData['idParam'];
				unset($getData['idParam']);
				$dataUpdate = $getData;

				$config['upload_path']          = $data['upload_path'];
        		$config['allowed_types']        = '*';
        		$config['max_size']             = 10000;

        		$oldData = $this->db->where('ID_KPI_L4',$idParam)->get('KPI_L4')->result();
				if (is_uploaded_file($_FILES['FORMULA']['tmp_name'])) {
		            $fileName = $_FILES['FORMULA']['name'];
		            $ext = explode('.', $fileName);
		            $ext = end($ext);
		            $newFileName = $config['file_name'] = date('Ymdhis').".".$ext;
		            $this->load->library('upload', $config);
		            if ( ! $this->upload->do_upload('FORMULA'))
		            {
		                $this->session->set_flashdata('error','Uploading problem, please check your file extention !!!');
		                return redirect('welcome/kpl3');
		            }
		            else
		            {
		            	if (file_exists($config['upload_path'].$oldData[0]->FORMULA)) {
		                    unlink($config['upload_path'].$oldData[0]->FORMULA);
		                }
		                $dataUpdate['FORMULA'] = trim($newFileName);
		            }
		        }
				$dataUpdate['LAST_UPDATE_DATE'] = $this->getDate();
				$dataUpdate['LAST_UPDATE_BY'] = 111111;
				
				$this->db->where('ID_KPI_L4',$idParam)->update('KPI_L4',$dataUpdate);
				$this->session->set_flashdata('success','Data berhasil diubah');
				return redirect('welcome/kpl4');
				break;
			case 'delete':
				$upload_path = $data['upload_path'];
				$oldData = $this->db->where('ID_KPI_L4',$id)->get('KPI_L4')->result();
				if (file_exists($upload_path.$oldData[0]->FORMULA)) {
                    unlink($upload_path.$oldData[0]->FORMULA);
                }
				$this->db->where('ID_KPI_L4',$id)->delete('KPI_L4');
				$this->session->set_flashdata('success','Data berhasil dihapus');
				return redirect($this->agent->referrer());
				break;
			default:
				# code...
				break;
		}
	}
}
