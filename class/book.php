<?php

class Book
{
    public function __construct($oData)
    {
        $this->oData = $oData;
        return;
    }
    public function get_book_itemized()
    {
        $aBook= array();
        $aFields= array();
        if ((isset($this->r_book_ID)) and ($this->r_book_ID!= "")) {
            $aFields["book_ID"] = $this->r_book_ID;
        }
        if ((isset($this->r_title)) and ($this->r_title= "")) {
            $aFields["title" ]= $this->r_title;
        }
        $this->p_result = $this->oData->select_rows(TABLE_BOOKS, $aFields);
        while ($aRow=mysqli_fetch_assoc($this->p_result)) {
            $aBook[$aRow['book_ID']] = $aRow;
        }
        return $aBook;
    }
    public function get_book()
    {
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
        $this->p_result = $this->oData->sql_statement($sQuery);
        while ($aRow=mysqli_fetch_assoc($this->p_result)) {
            $aBook[$aRow['title']] = $aRow;
        }
        return $aBook;
    }
    public function save_book($book_ID = null, $title = null, $author = null, $number = null, $location = null, $lent = null)
    {
        /*
        Params:
            $book_ID = NULL
                ID of the material. If number > 1 this will be extended with a char number
            $title = NULL
                Title of the book
            $author = NULL
                Author of the book
            $number = NULL
                Number of books of same title/author (only relevant when adding)
            $location = NULL
                Location of the book
            $lent = NULL
                Lent status of the book

        Returns:
            True if succensful, else False
        */
        $aFields = array(
            'title' => $title,
            'author' => $author,
            'location' => $location,
            'lent' => null
        );
        if ((isset($number)) and ($number>0)) {
            for ($i=0; $i<$number; $i++) {
                if ($i<26) {
                    $aFields['book_ID'] = $book_ID." ".chr(97+$i);
                } else {
                    $aFields['book_ID'] = $book_ID." ".chr(97+(int)($i/26)).chr(96+$i%26);
                }
                $this->ID=$this->oData->store_data(TABLE_BOOKS, $aFields, false, false);
            }
        } else {
            $aFields['book_ID'] = $book_ID;
            $this->ID=$this->oData->store_data(TABLE_BOOKS, $aFields, 'book_ID', $book_ID);
        }
    }

    public function delete_book($book_ID)
    {
        $aFields = array(
            'book_ID' => $book_ID
        );
        $this->removed=$this->oData->delete_rows(TABLE_BOOKS, $aFields);
    }
    public function return_book($book_ID)
    {
        $aFields = array(
            'lent' => 0
        );

        $this->id = $this->store_data(TABLE_BOOKS, $aFields, 'book_ID', $book_ID);
        return $ID;
    }
}
