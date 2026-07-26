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
}