<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Contact;

interface ContactRepositoryInterface
{
    /**
     * Salva um novo contato no repositório.
     */
    public function save(Contact $contact): Contact;

    /**
     * Atualiza um contato existente.
     */
    public function update(Contact $contact): Contact;

    /**
     * Busca um contato pelo ID.
     */
    public function findById(int $id): ?Contact;

    /**
     * Lista contatos com paginação.
     */
    public function paginate(int $perPage = 15);

    /**
     * Exclui (soft delete) um contato.
     */
    public function delete(Contact $contact): void;
}
