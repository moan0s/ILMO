<?php

class Material
{
    public function __construct($oData)
    {
        $this->oData = $oData;
    }
    public function get_material_itemized()
    {
        $aMaterial= array();
        $aFields= array();
        if ((isset($this->r_material_ID)) and ($this->r_material_ID!= "")) {
            $aFields["material_ID"] = $this->r_material_ID;
        }
        if ((isset($this->r_name)) and ($this->r_name= "")) {
            $aFields["name" ]= $this->r_name;
        }
        $this->p_result = $this->oData->select_rows(TABLE_MATERIAL, $aFields);
        while ($aRow=mysqli_fetch_assoc($this->p_result)) {
            $aMaterial[$aRow['material_ID']] = $aRow;
        }

        return $aMaterial;
    }

    public function get_material()
    {
        $sQuery="SELECT 
	B1.name as name,
	B1.location as location,
	count(*) as number,
	(
	   select  count(*) as available from ".TABLE_MATERIAL." B2 where lent=0 and name=B1.name 
	      ) as available 
	     FROM `".TABLE_MATERIAL."` B1
	     group by name";
        $this->p_result = $this->oData->sql_statement($sQuery);
        while ($aRow=mysqli_fetch_assoc($this->p_result)) {
            $aMaterial[$aRow['name']] = $aRow;
        }
        return $aMaterial;
    }

    public function save_material($material_ID=null, $name=null, $number=null, $location=null, $lent=null)
    {
        /*
        Params:
            $material_ID = NULL
                ID of the material. If number > 1 this will be extended with a number
            $name = NULL
                Name of the material
            $number = NULL
                Number of materials (only relevant when adding)
            $location = NULL
                Location of the material
            $lent = NULL
                Lent status of the material

        Returns:
            True if succensful, else False
        */
        $aFields = array(
            'name' => $name,
            'location' => $location,
            'lent' => null
        );
        if ((isset($number)) and ($number>1)) {
            for ($i=1; $i<=$this->r_number; $i++) {
                $aFields['material_ID'] = $material_ID." ".$i;
                $this->ID=$this->oData->store_data(TABLE_MATERIAL, $aFields, false, false);
            }
        } else {
            $aFields['material_ID'] = $material_ID;
            $this->ID=$this->oData->store_data(TABLE_MATERIAL, $aFields, 'material_ID', $material_ID);
        }
        return true;
    }

    public function delete_material()
    {
        $aFields = array(
            'material_ID' => $this->r_material_ID
        );
        $this->removed=$this->delete_rows(TABLE_MATERIAL, $aFields);
    }
    public function return_material($material_ID)
    {
        $aFields = array(
            'loan' => 0
        );

        $this->id = $this->store_data(TABLE_MATERIAL, $aFields, 'material_ID', $material_ID);
        return $ID;
    }
}
