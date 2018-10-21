<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 10/6/2018
 * Time: 11:42 AM
 */

namespace App\Event\Event;


use App\Event\UserEventInterface;

/**
 * @package App\Event\Event
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 */
interface HasUserAndEventInterface extends HasEventInterface, UserEventInterface { }
