<?php
// src/Entity/User.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="app_files")
 * @ORM\Entity(repositoryClass="App\Repository\FileRepository")
 */
class File
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    public $name;

    /**  
     * @ORM\Column(type="datetime", name="posted_at") 
     **/
    public $postedAt;

    // ...
    /**
     * @var PersistentCollection
     * @ORM\OneToMany(targetEntity="Hand", mappedBy="file")
     **/
    public $hands;

    public function postedAtStr(){
        return $this->postedAt->format('Y-m-d H:i:s');
    }
}