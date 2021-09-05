<?php
class Token
{
    public function __construct($oData)
    {
        $this->oData = $oData;
    }

    public function create_token_array($allowed_keys)
    {
        $aToken = array();
        foreach ($allowed_keys as $key) {
            if (isset($this->oData->payload[$key])) {
                $aToken[$key] = $this->oData->payload[$key];
            }
        }
        if (DEBUG) {
            echo "Created token:<br>";
            var_dump($aToken);
            echo "<br>";
        }
        return $aToken;
    }

    /**
     * Generate a random string, using a cryptographically secure
     * pseudorandom number generator (random_int)
     *
     * Function by Scott Arciszewski CC BY-SA 3.0
     * https://stackoverflow.com/a/34149536
     * @param int $length      How many characters do we want?
     * @param string $keyspace A string of all possible characters
     *                         to select from
     * @return string
     */
    public static function random_str(
        $length,
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ) {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        if ($max < 1) {
            throw new Exception('$keyspace must be at least two characters long');
        }
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }

    public function register()
    {
        //returns token_ID or -1 on failure
        $aToken = array();
        $aToken['user_ID'] = $_SESSION['user_ID'];
        if (isset($this->oData->payload['name'])) {
            $aToken['name'] = $this->oData->payload['name'];
        }
        $aToken['token'] = Token::random_str(32);
        $aToken['active'] = 1;
        $aToken['creation_date'] = date('Y-m-d H:i:s');
        if (DEBUG) {
            echo "Registering Token with:<br>";
            var_dump($aToken);
        }
        return $this->save_token($aToken);
    }
    public function save_token($aToken)
    {
        /*
        args:
            Array $aToken
                Array of token information which will be saved.
                e.g.	array(
                        'forename' => String $forname,
                        'surname' => String $surname,
                        'email' => String $email,
                        'language' => String $language,
                        'role' => Int $role, as decribed in config/permissions.php
                        'password_hash' => password_hash(String $password, PASSWORD_DEFAULT)
                    );

        returns:
            None or -1 if saving fails
        Function will save token Information given in $aToken. If token exists it will
        overwrite existing data but not delete not-specified data
        */
        if (DEBUG) {
            echo "Token that will be saved<br>";
            var_dump($aToken);
        }
        if ((isset($aToken['token_ID']) and ($aToken['token_ID'] != ""))) {
            $this->oData->databaselink->query("DELETE password FROM ".TABLE_API_TOKEN."WHERE token_ID=".$aToken['token_ID'].";");
            return $this->oData->store_data(TABLE_API_TOKEN, $aToken, 'token_ID', $token_ID);
        } else {
            return $this->ID=$this->oData->store_data(TABLE_API_TOKEN, $aToken, null, null);
        }
    }

    public function delete_token($token_ID)
    {
        $aFields = array(
            'token_ID' => $token_ID
        );
        $this->removed=$this->oData->delete_rows(TABLE_API_TOKEN, $aFields);
    }

    public function get_token($token_ID = null, $user_ID = null)
    {
        $aToken= array();
        $aFields= array();
        if ((isset($token_ID)) and ($token_ID!= "")) {
            $aFields["token_ID"] = $token_ID;
        }
        if ((isset($user_ID)) and ($user_ID!= "")) {
            $aFields["user_ID"] = $user_ID;
        }
        $aOrder = array("-token_ID");
        $this->p_result = $this->oData->select_rows(TABLE_API_TOKEN, $aFields, $aOrder);
        while ($aRow=mysqli_fetch_assoc($this->p_result)) {
            $aToken[$aRow['token_ID']] = $aRow;
        }
        return $aToken;
    }
}

?>

