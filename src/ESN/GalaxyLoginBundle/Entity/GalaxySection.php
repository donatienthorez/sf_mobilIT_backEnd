<?php

namespace ESN\GalaxyLoginBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\MappedSuperclass */
abstract class GalaxySection
{
  /**
   * @ORM\Id
   * @ORM\Column(name="codeSection", type="string", length=11)
   */
  private $codeSection;

  /**
   * @return string
   */
  public function getCodeSection()
  {
    return $this->codeSection;
  }

  /**
   * @param string $codeSection
   *
   * @return $this
   */
  public function setCodeSection($codeSection)
  {
    $this->codeSection = $codeSection;

    return $this;
  }

}