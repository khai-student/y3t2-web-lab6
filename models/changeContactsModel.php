<?php

class ChangeContactsModel extends Object
{
    function selectContacts()
    {
        global $db;
        $contacts = $db->Select('SELECT * FROM public.contacts;');
        if (count($contacts) > 0)
        {
            foreach ($contacts as $contact)
            {
                if (strtolower($contact['contact']) == 'e-mail')
                {
                    $this->email = $contact['value'];
                }
                elseif (strtolower($contact['contact']) == 'phone')
                {
                    $this->phone = $contact['value'];
                }
                elseif (strtolower($contact['contact']) == 'skype')
                {
                    $this->skype = $contact['value'];
                }
            }
        }

        if (!isset($this->email)) $this->email = '';
        if (!isset($this->phone)) $this->phone = '';
        if (!isset($this->skype)) $this->skype = '';

        return $this->data;
    }

    function alterContacts()
    {
        global $db;
        
        if (!isset($this->email) || !isset($this->phone) || !isset($this->skype))
        {
            $this->msg = 'Not all data entered.';
            return $this->data;
        }
        $sql = sprintf("DELETE FROM public.contacts WHERE LOWER(contact) = 'E-Mail' OR LOWER(contact) = 'Phone' OR LOWER(contact) = 'Skype';
                        INSERT INTO public.contacts (contact, value) VALUES
                        ('E-Mail', '%s'),
                        ('Phone', '%s'),
                        ('Skype', '%s');",
                        $db->RealEscapeString($this->email),
                        $db->RealEscapeString($this->phone),
                        $db->RealEscapeString($this->skype)
                        );
        if ($db->MultiQuery($sql) != TRUE)
        {
            $this->msg = 'Contacts update failed.';
        } 
        else
        {
            $this->msg = 'Contacts update success.';
        }

        return $this->data;
    }
}