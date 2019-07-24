<?php


namespace App\Events;


final class Events
{

    /**
     * For the event naming conventions, see:
     * https://symfony.com/doc/current/components/event_dispatcher.html#naming-conventions.
     *
     * @Event("Symfony\Component\EventDispatcher\GenericEvent")
     *
     * @var string
     */
    const ARTISTBAND_REGISTERED_PICTURE = 'member.registered';

    /**
     * @Event("Symfony\Component\EventDispatcher\GenericEvent")
     *
     * @var string
     */
    const ARTISTNEWPROJECT_REGISTERED_PICTURE = 'member.registred';


    /**
     * @Event("Symfony\Component\EventDispatcher\GenericEvent")
     *
     * @var string
     */
    const ARTISTNEWPROJECT_REGISTRED_MUSICFILE = 'member.registred';
}