<?php

namespace ReRe\Rere\Domain\Model;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 * Interval
 */
class Intervall extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * type
     *
     * @var string
     * @validate NotEmpty
     */
    protected $type = '';

    /**
     * aktuell
     *
     * @var string
     * @validate NotEmpty
     */
    protected $aktuell = '';

    /**
     * Returns the type
     *
     * @return string $type
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Sets the type
     *
     * @param string $type
     * @return void
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * Returns the aktuell
     *
     * @return string $aktuell
     */
    public function getAktuell() {
        return $this->aktuell;
    }

    /**
     * Sets the aktuell
     *
     * @param string $aktuell
     * @return void
     */
    public function setAktuell($aktuell) {
        $this->aktuell = $aktuell;
    }

}
