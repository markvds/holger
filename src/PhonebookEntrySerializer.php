<?php


namespace Holger;


use Holger\Entities\PhonebookEntry;

class PhonebookEntrySerializer
{

    public static function serialize(PhonebookEntry $phonebookEntry)
    {
        $serialize = "<contact>
            <category>" . $phonebookEntry->category . "</category>
            <person>
                <realName>" . $phonebookEntry->realName . "</realName>
            </person>
            <uniqueid>" . $phonebookEntry->uniqueid . "</uniqueid>
            <telephony nid=\"" . count($phonebookEntry->numbers) . "\">";

        foreach ($phonebookEntry->numbers as $number) {
            $serialize .= "<number type=\"" . $number->type . "\" prio=\"" . $number->prio . "\" id=\"" . $number->id . "\">" . $number->number . "</number>";
        }

        $serialize .= "
	        </telephony>
	        <services nid=\"1\">
		        <email classifier=\"private\" id=\"0\">" . $phonebookEntry->email . "</email>
	        </services>
	        <setup />
	        <features doorphone=\"0\" />
	        <mod_time>" . $phonebookEntry->modTime . "</mod_time>
        </contact>";

        return $serialize;
    }
}