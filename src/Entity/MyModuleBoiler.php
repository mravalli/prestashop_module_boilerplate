<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to mario@raval.li so I can send you a copy immediately.
 *
 * @author    Mario Ravalli <mario@raval.li>
 * @copyright Since 2023 Mario Ravalli
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

namespace MyModule\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 *
 * @ORM\Entity()
 */
class MyModuleBoiler
{
    /**
     * @var int
     *
     * @ORM\Id
     *
     * @ORM\Column(name="id_mymodule_boiler", type="integer")
     *
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="boiler", type="string")
     */
    private $boiler;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getBoiler(): string
    {
        return $this->boiler;
    }

    /**
     * @param string $boiler
     */
    public function setBoiler(string $boiler): void
    {
        $this->boiler = $boiler;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id_mymodule_boiler' => $this->getId(),
            'boiler' => $this->getBoiler(),
        ];
    }
}
