<?php

namespace App\Domain\Events;

use App\Domain\Entities\Contact;

class ContactScoreProcessed
{
    /**
     * Entidade de contato processada
     */
    public Contact $contact;

    /**
     * Construtor recebe o contato atualizado
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }
}
