<?php
namespace ReRe\Rere\Domain\Model;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Felix Hohlwegler <info@felix-hohlwegler.de>, TeamProjektWS14/15
 *           Sarah Kieninger <sarah.kieninger@gmail.com>, TeamProjektWS14/15
 *           Tim Wacker, TeamProjektWS14/15
 *           Nejat Balta, TeamProjektWS14/15
 *           Tobias Brockner, TeamProjektWS14/15
 *           Nicolas Tedjadharma, TeamProjektWS14/15
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
 ***************************************************************/

/**
 * Modul
 */
class Modul extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * modulnr
	 * 
	 * @var string
	 * @validate NotEmpty
	 */
	protected $modulnr = '';

	/**
	 * modulname
	 * 
	 * @var string
	 * @validate NotEmpty
	 */
	protected $modulname = '';

	/**
	 * gueltigkeitszeitraum
	 * 
	 * @var \DateTime
	 * @validate NotEmpty
	 */
	protected $gueltigkeitszeitraum = NULL;

	/**
	 * Returns the modulnr
	 * 
	 * @return string $modulnr
	 */
	public function getModulnr() {
		return $this->modulnr;
	}

	/**
	 * Sets the modulnr
	 * 
	 * @param string $modulnr
	 * @return void
	 */
	public function setModulnr($modulnr) {
		$this->modulnr = $modulnr;
	}

	/**
	 * Returns the modulname
	 * 
	 * @return string $modulname
	 */
	public function getModulname() {
		return $this->modulname;
	}

	/**
	 * Sets the modulname
	 * 
	 * @param string $modulname
	 * @return void
	 */
	public function setModulname($modulname) {
		$this->modulname = $modulname;
	}

	/**
	 * Returns the gueltigkeitszeitraum
	 * 
	 * @return \DateTime $gueltigkeitszeitraum
	 */
	public function getGueltigkeitszeitraum() {
		return $this->gueltigkeitszeitraum;
	}

	/**
	 * Sets the gueltigkeitszeitraum
	 * 
	 * @param \DateTime $gueltigkeitszeitraum
	 * @return void
	 */
	public function setGueltigkeitszeitraum(\DateTime $gueltigkeitszeitraum) {
		$this->gueltigkeitszeitraum = $gueltigkeitszeitraum;
	}

}