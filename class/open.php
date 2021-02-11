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
        foreach ($this->oData->settings['opening_days'] as $day) {
            $fieldS=$this->oData->payload[$day."_s"];
            $fieldE=$this->oData->payload[$day."_e"];
            $fieldN=$this->oData->payload[$day."_n"];
            $aFields = array(
                'day' => $day,
                'start' => $fieldS,
                'end' => $fieldE,
                'notice' => $fieldN
            );
            $xy = $this->oData->store_data(TABLE_OPEN, $aFields, "day", $day);
            unset($aFields);
        }
    }
}
