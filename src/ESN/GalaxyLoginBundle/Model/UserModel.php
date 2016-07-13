<?php

namespace ESN\GalaxyLoginBundle\Model;

use ESN\GalaxyLoginBundle\Entity\GalaxyUser;

class UserModel extends GalaxyUser
{
  private $codeSection;

  /**
   * @return string
   */
  public function getCodeSection()
  {
    return $this->codeSection;
  }

  /**
   * @param $codeSection
   *
   * @return $this
   */
  public function setCodeSection($codeSection)
  {
    $this->codeSection = $codeSection;

    return $this;
  }
}
