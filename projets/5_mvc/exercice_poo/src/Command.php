<?php

class Command 
{
    public function __construct(
        private readonly ContactManager $contactManager
    ){}
    public function list(){
        foreach($this->contactManager->findAll() as $contact) {
            $this->ln($contact->toString());
        }
    }

    public function detail(int $id){
        $contact = $this->contactManager->find($id);
        if($contact !== null) {
            $this->ln($contact->toString());
        } else {
            $this->ln("Pas de contact trouvé pour cette ID");
        }
    }

    public function create(string $name, string $email, string $phoneNumber) 
    {
        $newContact = new Contact(
            id: null,
            name: $name,
            email: $email,
            phoneNumber: $phoneNumber
        );
        $this->contactManager->insert($newContact);
        $this->ln(
            "Contact inséré !",
            $newContact->toString()
        );
    }

    public function delete(int $id): void
    {
        $contact = $this->contactManager->find($id);
        if($contact === null) {
            $this->ln("Pas de contact à supprimer.");
            return;
        }

        $this->contactManager->delete($id);
        $this->ln("Contact {$id} supprimé !");
    }

    public function quit(): never
    {
        $this->ln("OK, Bye !");
        die();
    }

    private function ln(string ...$msgs,){
        echo implode("\n\r", $msgs) . "\n\r";
    }
}