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

    public function modify(int $id, string $name, string $email, string $phoneNumber)
    {
        $contact = $this->contactManager->find($id);
        if($contact === null) {
            $this->ln("Contact introuvable.");
            return;
        }

        $contact->setName($name);
        $contact->setEmail($email);
        $contact->setPhoneNumber($phoneNumber);

        $this->contactManager->update($contact);
        $this->ln("Contact modifié !", $contact->toString());
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

    public function help() {
        $this->ln(
            "help : affiche cette aide",
            "list : liste les contacts",
            "detail [id] : affiche les détails d'un contact",
            "create [name], [email], [phone number] : crée un contact",
            "delete [id] : supprime un contact",
            "quit : quitte le programme"
        );
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