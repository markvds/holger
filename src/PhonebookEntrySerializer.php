<?php

namespace Holger;

use Holger\Entities\PhonebookEntry;

class PhonebookEntrySerializer
{
    public static function serialize(PhonebookEntry $phonebookEntry)
    {
        $serialize = '
<?xml version="1.0" encoding="UTF-8" ?>
<contact>
            <category>' . $phonebookEntry->category . '</category>
            <person>
                <realName>' . $phonebookEntry->realName . '</realName>
            </person>
            <telephony nid="' . count($phonebookEntry->numbers) . '">';

        foreach ($phonebookEntry->numbers as $number) {
            $serialize .= '<number type="' . $number->type . '" prio="' . $number->prio . '" id="' . $number->id . '">' . $number->number . '</number>';
        }

        $serialize .= '
	        </telephony>
	        ';
        if ($phonebookEntry->uniqueid !== null) {
            $serialize .= '<uniqueid>' . $phonebookEntry->uniqueid . '</uniqueid>';
        }
        $serialize .= '
	        <services nid="1">
		        <email classifier="private" id="0">' . $phonebookEntry->email . '</email>
	        </services>
	        <setup />
	        <features doorphone="0" />
	        <mod_time>' . $phonebookEntry->modTime . '</mod_time>
        </contact>';

        return $serialize;
    }
}
