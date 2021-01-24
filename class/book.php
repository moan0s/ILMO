<?php

class Book extends Data {
	function get_book_itemized (){
		$aBook= array();
		$aFields= array();
		if((isset($this->r_book_ID)) and ($this->r_book_ID!= "")){$aFields["book_ID"] = $this->r_book_ID;}
		if((isset($this->r_title)) and ($this->r_title= "")){$aFields["title" ]= $this->r_title;}
		
		$this->p_result = $this->select_rows(TABLE_BOOKS, $aFields);
		while($aRow=mysqli_fetch_assoc($this->p_result)){
			$aBook[$aRow['book_ID']] = $aRow;
		}
		return $aBook;
	}
	function get_book(){
	$sQuery="SELECT 
	B1.title as title,
	B1.author as author,
	B1.location as location,
	count(*) as number,
	(
	   select  count(*) as available from ".TABLE_BOOKS." B2 where lent=0 and title=B1.title 
	      ) as available 
	     FROM `".TABLE_BOOKS."` B1
	     group by title";
	$this->p_result = $this->sql_statement($sQuery);
	while($aRow=mysqli_fetch_assoc($this->p_result)){
		$aBook[$aRow['title']] = $aRow;
	}
	return $aBook;
	}	
	function save_book(){
		$aFields = array(
			'title' => $this->r_title,
			'author' => $this->r_author,
			'location' => $this->r_location,
			'lent' => null		
		);
		if ((isset($this->r_number)) and ($this->r_number>0)){
			for ($i=0; $i<$this->r_number; $i++){
				if ($i<26){
					$aFields['book_ID'] = $this->r_book_ID." ".chr(97+$i);
				}
				else{
					$aFields['book_ID'] = $this->r_book_ID." ".chr(97+(int)($i/26)).chr(96+$i%26);
				}
				$this->ID=$this->store_data(TABLE_BOOKS, $aFields, FALSE, FALSE);
			}
				
		}
		else{
			$aFields['book_ID'] = $this->r_book_ID;
			$this->ID=$this->store_data(TABLE_BOOKS, $aFields, 'book_ID',$this->r_book_ID);
		}
				
	}
	function delete_book(){
		$aFields = array (
			'book_ID' => $this->r_book_ID
		);
		$this->removed=$this->delete_rows(TABLE_BOOKS, $aFields);
	}
	function return_book($book_ID){
		$aFields = array(
			'lent' => 0		
		);

		$this->id = $this->store_data(TABLE_BOOKS, $aFields, 'book_ID',$book_ID);
	return $ID;
	}
}
