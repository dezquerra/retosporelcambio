<?php
class Bibliographies extends CI_Model {

	    public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
		
		public function add($name, $pages, $author, $description, $src)
		{
			$data["name"] = $name;
			$data["pages"] = $pages;
			$data["author"] = $author;
			$data["description"] = $description;
			$data["location"] = $src;
			
			$this->db->insert('bibliography', $data);
			return $this->db->insert_id();
		}
		
		public function update($description, $pages, $author, $src, $topics, $id)
		{
			$data["name"] = $description;
			$data["pages"] = $pages;
			$data["author"] = $author;
			$data["topics"] = $topics;
			$data["location"] = $src;
			
			$this->db->where("bibliographyID", $id);
			$this->db->update("bibliography", $data);
		}
		
		public function getAll()
		{
			$query = "SELECT * FROM bibliography ORDER BY RAND()";
			$answer = $this->db->query($query);
			
			return $answer;
		}
		
		public function getFiltered($filter)
		{
			$query = "SELECT DISTINCT bibliography.* FROM bibliography, bibliographytopics ";
			$where = "WHERE (bibliography.bibliographyID=bibliographytopics.bibliographyID and bibliographytopics.topicID='".$filter."') ORDER BY RAND()";
			$answer = $this->db->query($query.$where);
			
			return array($answer->num_rows(),$answer);
		}
		
		public function getNumberOfBibliographyByTag($tagID)
		{
			$query = "SELECT COUNT(*) as number FROM bibliographytags WHERE tagID = '".$tagID."'";
			$answer = $this->db->query($query);
			
			$row = $answer->row();
			
			return $row->number;
		}
		
		public function addDownload($id)
		{
			$query = "UPDATE bibliography SET downloads=downloads+1 WHERE bibliographyID='".$id."'";
			$this->db->query($query);
		}
}
?>