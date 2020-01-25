<?php

/**
 * M
 */
class Mobil_model extends CI_Model
{
	
	public function getMobil($id = null)
	{
		if (isset($id)) {
			return $this->db->get_where('mobil', ['id' => $id])->result_array();
		}
		else{
			return $this->db->get('mobil')->result_array();
		}
	}

	public function cariMobil($kriteria = null, $keyword = null)
	{
		if (isset($kriteria,$keyword)) {
			$this->db->like($kriteria, $keyword);
			return $this->db->get('mobil')->result_array();
		}
		else{
			return $this->db->get('mobil')->result_array();
		}

	}

	public function createMobil($data)
	{
		$this->db->insert('mobil', $data);
		return $this->db->affected_rows();
	}

	public function updateMobil($data, $id)
	{
		$this->db->update('mobil', $data, ['id' => $id]);
		return $this->db->affected_rows();
	}

	public function deleteMobil($id)
	{
		$this->db->delete('mobil', ['id' => $id]);
		return $this->db->affected_rows();
	}






}