<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Document_model extends Base_model{
	public function __construct(){
		parent::__construct();
	}
	
	public function get_list($where = '', $sort = array(), $limit = ''){
		$sql = "SELECT * FROM documents"
			.(empty($where) ? "" : " WHERE $where ")
			.(empty($sort) ? "" : " ORDER BY ".implode(",", $sort))
			.(empty($limit) ? "" : " LIMIT $limit");
		return $this->db->query($sql);
	}
	
	public function get_list_total($where = ''){
		$sql = "SELECT COUNT(*) AS count FROM documents "
			.(empty($where) ? "" : " WHERE $where ");
		$result = $this->db->query($sql);
		return $result[0]['count'];
	}
	
	public function insert($files){
		if(count($files) <= 0){
			return;
		}
		$fields = array();
		foreach($files[0] as $n => $f){
			array_push($fields, "`$n`");
		}
		$values = array();
		foreach($files as $n => $f){
			array_push($values, "('".implode("','", $f)."')");
		}
		$sql = "INSERT INTO documents (".implode(",", $fields).") VALUES ".implode(",", $values);
		return $this->db->query($sql) && $this->db->insert_id() > 0;
	}
	
	public function update($prop, $where){
		$set = array();
		foreach($prop as $k => $v){
			array_push($set, "$k='$v'");
		}
		$sql = "UPDATE documents SET ".implode(",", $set).(!empty($where) ? " WHERE $where" : "");
		return $this->db->query($sql);
	}
	
	public function delete($where = ''){
		$sql = "DELETE FROM documents ".(empty($where) ? "" : " WHERE $where");
		return $this->db->query($sql);
	}
	
	public function get_all_content_types(){
		$sql = "SHOW columns FROM documents";
		$result = $this->db->query($sql); 
		foreach($result as $r){
			if($r['Field'] == 'content_type'){
				preg_match("/^enum\(\'(.*)\'\)$/", $r['Type'], $matches);
				$ret = explode("','", $matches[1]);
				return $ret;
			}
		}
		return array();
	}
	
	public function get_all_mime_content_types(){
		$sql = "SELECT distinct(mime_content_type) as mime_type FROM documents";
		$result = $this->db->query($sql);
		$ret = array();
		foreach($result as $r){
			array_push($ret, $r['mime_type']);
		}
		return $ret;
	}
	
	public function get_item($uniqid){
		$sql = "SELECT * FROM documents d LEFT JOIN document_pub_code dpc ON d.uniqid=dpc.document_id
			WHERE d.uniqid='$uniqid' ORDER BY dpc.expire DESC";
		return $this->db->query($sql);
	}
	
	public function get_item_with_code($uniqid, $code){
		$sql = "SELECT * FROM documents d LEFT JOIN document_pub_code dpc ON d.uniqid=dpc.document_id
			WHERE d.uniqid='$uniqid' AND dpc.code='$code' ORDER BY dpc.expire DESC";
		return $this->db->query($sql);
	}
	
	public function get_pub_code(){
		$sql = "SELECT code FROM document_pub_code";
		return $this->db->query($sql);
	}
	
	public function new_pub_code($code, $expire, $uniqid){
		$sql = "INSERT INTO document_pub_code (code, expire, document_id) VALUES ('$code','$expire','$uniqid')";
		if(!$this->db->query($sql)){
			return false;
		}
		return $this->db->insert_id();
	}
	
	public function delete_pub_code($where){
		$sql = "DELETE FROM document_pub_code WHERE 1=1 AND $where";
		$this->db->query($sql);
	}
}