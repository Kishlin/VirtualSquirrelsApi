<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 9/22/2018
 * Time: 3:42 PM
 */

namespace UserBundle\Entity;


use Mgilet\NotificationBundle\NotifiableInterface;
use Mgilet\NotificationBundle\Annotation as MG;
use FOS\UserBundle\Model\User as BaseUser;
use JMS\Serializer\Annotation as JMS;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\UserRoles;

/**
 * @ORM\Entity
 * @ORM\Table(name="vs_user")
 * @MG\Notifiable(name="user")
 *
 * @JMS\ExclusionPolicy("all")
 */
class User extends BaseUser implements NotifiableInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Expose
     * @JMS\Groups({"default"})
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @return array
     */
    public static function getPossibleRoles(): array
    {
        return array(
            UserRoles::ROLE_TRIAL,
            UserRoles::ROLE_MEMBER,
            UserRoles::ROLE_OFFICER,
            UserRoles::ROLE_ADMIN
        );
    }

}