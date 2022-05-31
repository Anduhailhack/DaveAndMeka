<?php
	define ("DB_HOST", "localhost");
	define ("DB_NAME", "MAIN");
	define ("DB_USER", "root");
	define ("DB_PASS", "");

	class Database {
		private $db;
		private $memories_table = "memories";
		
		function __construct()
		{
			$this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			
		}
		
		function insertMemories($caption, $photo, $posted_by)
		{
			//$caption = $this->db->real_escape_string($caption);
			//$photo = $this->db->real_escape_string($photo);
			//$posted_by = $this->db->real_escape_string($posted_by);
			
			$prepared_query = $this->db->prepare("INSERT INTO " . $this->memories_table . " (caption, photo, posted_by) VALUES (?, ?, ?);");
			$prepared_query->bind_param("sss", $caption, $photo, $posted_by);
			$prepared_query->execute();
			$prepared_query->close();
			
			if(mysqli_errno($this->db))
			{
				return mysqli_error($this->db);
			}
			
			return "Added successfully !";
		}
		
		function fetchMemories()
		{
			$query = "SELECT * FROM " . $this->memories_table;
			$results = $this->db->query($query);
			
			if(mysqli_errno($this->db))
			{
				return mysqli_error($this->db);
			}
			
			return $results;
		}

		function fetchPreviousMemories($username)
		{
			$username = $this->db->real_escape_string($username);
			$query = "SELECT * FROM " . $this->memories_table . " WHERE posted_by='" . $username . "'";
			$results = $this->db->query($query);
			
			if(mysqli_errno($this->db))
			{
				return mysqli_error($this->db);
			}
			
			return $results;
		}

		function updateMemories($id, $posted_by, $caption)
		{
			$caption = $this->db->real_escape_string($caption);
			$id = $this->db->real_escape_string($id);
			$posted_by = $this->db->real_escape_string($posted_by);
			
			$query = "UPDATE " . $this->memories_table . " SET caption = ? WHERE id = ? AND posted_by = ?";
			$prepared_query = $this->db->prepare($query);
			$prepared_query->bind_param("sss", $caption, $id, $posted_by);
			$prepared_query->execute();
			$prepared_query->close();

			if (mysqli_errno($this->db) != 0)
			{
				return mysqli_error($this->db);
			}

			return "Changed successfully!";
		}

		function deleteMemories($id, $posted_by)
		{
			$id = $this->db->real_escape_string($id);
			$posted_by = $this->db->real_escape_string($posted_by);
			
			$query = "DELETE FROM " . $this->memories_table . " WHERE id = ? AND posted_by = ?";
			$prepared_query = $this->db->prepare($query);
			$prepared_query->bind_param("ss", $id, $posted_by);
			$prepared_query->execute();
			$prepared_query->close();

			if (mysqli_errno($this->db) != 0)
			{
				return mysqli_error($this->db);
			}

			return "Removed successfully!";
		}
		
		function __distruct()
		{
			$this->db->close();
		}
	}
?>