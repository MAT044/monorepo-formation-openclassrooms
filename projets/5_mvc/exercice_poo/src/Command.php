<?php

class Command 
{
    public function __construct(
        private readonly ContactManager $contactManager
    ){}
    public function list(){
        foreach($this->contactManager->findAll() as $contact) {
            echo $contact->toString();
            echo "\n";
        }
    }

    public function detail(int $id){
        $contact = $this->contactManager->find($id);
        if($contact !== null) {
            echo $contact->toString();
            echo "\n";
        } else {
            echo "Pas de contact trouvé pour cette ID \n";
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
        echo "Contact inséré !\n";
        echo $newContact->toString();
        echo "\n";
    }

    public function delete(int $id): void
    {
        $contact = $this->contactManager->find($id);
        if($contact === null) {
            echo "Pas de contact à supprimer.\n";
            return;
        }

        $this->contactManager->delete($id);
        echo "Contact {$id} supprimé !\n";
    }

    public function quit(): never
    {
        echo "OK, Bye !\n";
        die();
    }
}