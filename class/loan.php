<?php
class Loan extends Data
{
    public function save_loan()
    {
        $aFields = array(
                'ID' => $this->r_ID,
                'type' => $this->r_type,
                'user_ID' => $this->r_user_ID,
                'return_date' => null,
                'returned' => null,

            );
        if ((isset($this->r_pickup_date)) and (""!= $this->r_pickup_date)) {
            $aFields['pickup_date'] = $this->r_pickup_date;
            $aFields['last_reminder'] = $this->r_pickup_date;
        } else {
            $aFields['pickup_date'] = date("Y-m-d");
            $aFields['last_reminder'] = date("Y-m-d");
        }
        if ((isset($this->r_return_date)) and (""!= $this->r_return_date)) {
            $aFields['return_date'] = $this->r_return_date;
        } else {
            $aFields['return_date'] = "0000-00-00";
        }
        $this->ID=$this->store_data(TABLE_LOAN, $aFields, 'loan_ID', $this->r_loan_ID);
        
        $aFields = array(
            'lent' => 1
        );
        if ($this->r_type=="book") {
            $this->store_data(TABLE_BOOKS, $aFields, 'book_ID', $this->r_ID);
        }
        if ($this->r_type=="material") {
            $this->store_data(TABLE_MATERIAL, $aFields, 'material_ID', $this->r_ID);
        }
    }
    
    public function return_loan()
    {
        $aLoans= $this->get_loan(null, null, null);
        $aLoan = $aLoans[$this->r_loan_ID];
        $aFields = array(
            'return_date' => date("Y-m-d H:i:s"),
            'returned' => 1
        );
        $this->ID=$this->store_data(TABLE_LOAN, $aFields, 'loan_ID', $this->r_loan_ID);
        
        $aFields = array(
        'lent' => 0
    );
        if ($aLoan['type']=='book') {
            $this->store_data(TABLE_BOOKS, $aFields, 'book_ID', $this->r_ID);
        }
        if ($aLoan['type']=='material') {
            $this->store_data(TABLE_MATERIAL, $aFields, 'material_ID', $this->r_ID);
        }
    }
    
    public function get_loan(int $loan_ID = null, int $user_ID = null, int $book_ID = null)
    {
        /*
        params:
            int $loan_ID:
                Filters loans by ID of loan (unique therfor will return only one)
            int $user_ID:
                Filters loans by ID of user
            int $book_ID:
                Filters loans by ID of book
        returns: Associative array with complete loan Information (loan_ID as keys)
        */
        $aFields= array();
        $oUser = new User;
        $oBook = new Book;
        $oMaterial = new Material;
        $oBook->r_book_ID = null;
        $oMaterial->r_material_ID = null;
        $this->all_user = $oUser->get_user();
        $this->all_book = $oBook->get_book_itemized();
        $this->all_material = $oMaterial->get_material_itemized();
        if ((isset($user_ID)) and ($user_ID!= "")) {
            $aFields["user_ID"] = $this->r_user_ID;
        }
        if ((isset($loan_ID)) and ($loan_ID!= "")) {
            $aFields["loan_ID"] = $this->r_loan_ID;
        }
        if ((isset($book_ID)) and ($book_ID!= "")) {
            $aFields["book_ID"] = $this->r_book_ID;
        }
        $aOrder = array("-user_ID");
        $this->p_result = $this->select_rows(TABLE_LOAN, $aFields);
        while ($aRow=mysqli_fetch_assoc($this->p_result)) {
            $aLoan[$aRow['loan_ID']] = $aRow;
        }
        return $aLoan;
    }
}
