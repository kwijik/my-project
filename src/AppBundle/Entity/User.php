<?php
// src/AppBundle/Entity/User.php
namespace AppBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser{

	const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';
    

/**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var
     *
     * @ORM\ManyToMany(targetEntity="Group", inversedBy="users")
     * @ORM\JoinTable(name="users_groups",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;
    
 	public function __construct(){
 		parent::__construct();
        $this->groups = new ArrayCollection();
    }
 // your own logic
 	

 	/**
     * @param $group
     * @return $this
     */
    public function addGoup($group)
    {
        $this->groups[] = $group;
        $group->setUser($this);

        return $this;
    }

    /**
     * @param $groups
     */
    public function setGroups($groups)
    {
        $this->groups->clear();
        foreach ($groups as $group) {
            $this->addGroup($group);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getGroups()
    {
        return $this->groups;
    }
} 