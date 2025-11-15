<?php

namespace App\Repository;

use App\Models\Ad;
use App\Models\AdAttributesOption;
use App\Models\Attribute;

class AttributesRepository{

    public function getAdAttributesSelectedOptions($adAttributeid)
    {
        return AdAttributesOption::with('option')->where('ad_attribute_id',$adAttributeid)->get();
    }

    public function getAdAttributesSelectedOptionsMap($adAttributeids)
    {
        return AdAttributesOption::with('option')->whereIn('ad_attribute_id',$adAttributeids)->get();
    }

    function getAttribute($id)
    {
        return Attribute::with('typeList')->find($id);
    }

    function getAttributesByIds($ids)
    {
        return Attribute::whereIn('id',$ids)->get();
    }

    public function getOptionsForAttribute($attributeId)
    {
        return AdAttributesOption::where('attribute_id', $attributeId)->get();
    }
}
