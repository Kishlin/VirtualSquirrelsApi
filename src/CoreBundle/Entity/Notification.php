<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 01/10/2018
 * Time: 11:38
 */

namespace CoreBundle\Entity;


use JMS\Serializer\Annotation as JMS;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\InheritanceType("JOINED")
 * @ORM\Table(name="vs_notification")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 *
 * @JMS\ExclusionPolicy("all")
 *
 * @package CoreBundle\Entity
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class Notification
{

}
