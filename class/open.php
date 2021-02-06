<?php
class Open
{
    public function __construct($oData)
    {
        $this->oData = $oData;
        return;
    }

    public function get_open()
    {
        $aOpen = array();
        $aFields = array();

        $this->p_result = $this->oData->select_rows(TABLE_OPEN, $aFields);
        while ($aRow=mysqli_fetch_assoc($this->p_result)) {
            $aOpen[$aRow['day']] = $aRow;
        }
        return $aOpen;
    }

    public function save_open()
    {
        foreach ($this->settings['opening_days'] as $day) {
            $fieldS="r_".$day."_s";
            $fieldE="r_".$day."_e";
            $fieldN="r_".$day."_n";
            $aFields = array(
                'day' => $day,
                'start' => $this->$fieldS,
                'end' => $this->$fieldE,
                'notice' => $this->$fieldN
            );
            $xy = $this->oData->store_data(TABLE_OPEN, $aFields, "day", $day);
            unset($aFields);
        }
    }
}
