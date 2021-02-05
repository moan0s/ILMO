<?php
class Loan
{
    public function __construct($oData)
    {
        $this->oData = $oData;
    }
    public function save_loan($loan_ID = null, $ID=null, $type=null, $user_ID=null, $pickup_date=null, $return_date= null, $returned = null)
    {
        /*
        Params:
        $loan_ID = NULL
                ID of the loan.
        $ID = NULL
                ID of the item.
        $type = NULL
            Book or material
        $user_ID:int
        	Id of the user that has the loan
        $pickup_date = NULL
                Date on that the loan was picked up
        $return_date = NULL
                Date on that the loan was returned
        $returned = NULL
                Whether the loan was returned (True if returned)

        Returns:
            True if succensful, else False
        */
        $aFields = array(
                'ID' => $ID,
                'type' => $type,
                'user_ID' => $user_ID,
                'return_date' => null,
                'returned' => null
        );
        if ((isset($pickup_date)) and (""!= $pickup_date)) {
            $aFields['pickup_date'] = $pickup_date;
            $aFields['last_reminder'] = $pickup_date;
        } else {
            $aFields['pickup_date'] = date("Y-m-d");
            $aFields['last_reminder'] = date("Y-m-d");
        }
        if ((isset($return_date)) and (""!= $return_date)) {
            $aFields['return_date'] = $return_date;
        } else {
            $aFields['return_date'] = "0000-00-00";
        }
        $this->ID=$this->oData->store_data(TABLE_LOAN, $aFields, 'loan_ID', $loan_ID);

        $aFields = array(
            'lent' => 1
        );
        if ($type=="book") {
            $this->store_data(TABLE_BOOKS, $aFields, 'book_ID', $ID);
        }
        if ($type=="material") {
            $this->store_data(TABLE_MATERIAL, $aFields, 'material_ID', $ID);
        }
    }

    public function return_loan($loan_ID, $ID, $type)
    {
        /*
        Params:
        $loan_ID = NULL
                ID of the loan.
        $ID = NULL
                ID of the item.
        $type = NULL
            Book or material
     */
        $aLoans= $this->get_loan(null, null, null);
        $aLoan = $aLoans[$loan_ID];
        $aFields = array(
            'return_date' => date("Y-m-d H:i:s"),
            'returned' => 1
        );
        $this->ID=$this->store_data(TABLE_LOAN, $aFields, 'loan_ID', $loan_ID);

        $aFields = array(
        'lent' => 0
    );
        if ($aLoan['type']=='book') {
            $this->store_data(TABLE_BOOKS, $aFields, 'book_ID', $ID);
        }
        if ($aLoan['type']=='material') {
            $this->store_data(TABLE_MATERIAL, $aFields, 'material_ID', $ID);
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
        $oUser = new User($this->oData);
        $oBook = new Book($this->oData);
        $oMaterial = new Material($this->oData);
        $this->all_user = $oUser->get_user();
        $this->all_book = $oBook->get_book_itemized();
        $this->all_material = $oMaterial->get_material_itemized();
        if ((isset($user_ID)) and ($user_ID!= "")) {
            $aFields["user_ID"] = $this->oData->payload['user_ID'];
        }
        if ((isset($loan_ID)) and ($loan_ID!= "")) {
            $aFields["loan_ID"] = $this->oData->payload['loan_ID'];
        }
        if ((isset($book_ID)) and ($book_ID!= "")) {
            $aFields["book_ID"] = $this->oData->payload['book_ID'];
        }
        $aOrder = array("-user_ID");
        $this->p_result = $this->oData->select_rows(TABLE_LOAN, $aFields);
        while ($aRow=mysqli_fetch_assoc($this->p_result)) {
            $aLoan[$aRow['loan_ID']] = $aRow;
        }
        return $aLoan;
    }
}
