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
                'user_ID' => $user_ID
        );
        if (isset($loan_ID)) {
            $aFields['loan_ID'] = $loan_ID;
        }
        if ((isset($return_date)) and (""!= $return_date)) {
            $aFields['return_date'] = $return_date;
        }
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
            $this->oData->store_data(TABLE_BOOKS, $aFields, 'book_ID', $ID);
        }
        if ($type=="material") {
            $this->oData->store_data(TABLE_MATERIAL, $aFields, 'material_ID', $ID);
        }
    }

    public function return_loan($loan_ID)
    {
        /*
        Params:
        $loan_ID = NULL
                ID of the loan.
     */
        $aLoans= $this->get_loan($loan_ID);
        $aLoan = $aLoans[$loan_ID];
        $aFields = array(
            'return_date' => date("Y-m-d H:i:s"),
            'returned' => 1
        );
        $this->ID=$this->oData->store_data(TABLE_LOAN, $aFields, 'loan_ID', $loan_ID);

        $aFields = array(
        'lent' => 0
    );

        if ($aLoan['type']=='book') {
            $this->oData->store_data(TABLE_BOOKS, $aFields, 'book_ID', $ID);
        }
        if ($aLoan['type']=='material') {
            $this->oData->store_data(TABLE_MATERIAL, $aFields, 'material_ID', $ID);
        }
    }

    public function get_loan(int $loan_ID = null, int $user_ID = null, $book_ID = null, $material_ID = null, bool $returned = null)
    {
        /*
        params:
            int $loan_ID:
                Filters loans by ID of loan (unique therfor will return only one)
            int $user_ID:
                Filters loans by ID of user
            int $book_ID:
                Filters loans by ID of book
            int $material_ID:
                Filters loans by ID of a material
        returns: Associative array with complete loan Information (loan_ID as keys)
        */
        $aFields= array();
        $query = "
	SELECT user.user_ID, CONCAT(user.forename,' ',user.surname) AS user_name, loan.loan_ID, loan.ID, loan.type, loan.pickup_date, loan.return_date, books.title AS book_name, material.name AS material_name
	From loan
	LEFT JOIN user
		ON user.user_ID=loan.user_ID
	LEFT JOIN books
		ON books.book_ID=loan.ID
	LEFT JOIN material
		ON material.material_ID=loan.ID";
        $restrictions = array();
        if (isset($loan_ID)) {
            $restrictions["loan.loan_ID"] = $loan_ID;
        }
        if ((isset($user_ID)) and ($user_ID!= "")) {
            $restrictions["user.user_ID"] = $user_ID;
        }
        if ((isset($book_ID)) and ($book_ID!= "")) {
            $restrictions["loan.ID"] = $book_ID;
        }
        if ((isset($material_ID)) and ($material_ID!= "")) {
            $restrictions["loan.ID"] = $material_ID;
        }
        $i = 0;
        $sCondition = "";
        foreach ($restrictions as $key=>$value) {
            if ($i >0) {
                $sCondition .= " AND ";
            } else {
                $sCondition .= " WHERE ";
            }
            $sCondition .= $key."='".$value."'";
            $i++;
        }
        $query .= $sCondition;
        $sort = " ORDER BY loan_ID DESC;";
        $query .= $sort;
        $this->p_result = $this->oData->databaselink->query($query);
        while ($aRow=mysqli_fetch_assoc($this->p_result)) {
            $aLoan[$aRow['loan_ID']] = $aRow;
        }
        return $aLoan;
    }
}
