<?php
namespace Rere\Rere\Domain\Model;

/* * *************************************************************
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
 * ************************************************************* */

/**
 * Pruefling
 */
class Pruefling extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * matrikelnr
	 * 
	 * @var string
	 * @validate NotEmpty
	 */
	protected $matrikelnr = '';

	/**
	 * vorname
	 * 
	 * @var string
	 * @validate NotEmpty
	 */
	protected $vorname = '';

	/**
	 * nachname
	 * 
	 * @var string
	 * @validate NotEmpty
	 */
	protected $nachname = '';

	/**
	 * typo3FEUser
	 * 
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
	 */
	protected $typo3FEUser = NULL;

	/**
	 * Returns the matrikelnr
	 * 
	 * @return string $matrikelnr
	 */
	public function getMatrikelnr() {
		return $this->matrikelnr;
	}

	/**
	 * Sets the matrikelnr
	 * 
	 * @param string $matrikelnr
	 * @return void
	 */
	public function setMatrikelnr($matrikelnr) {
		$this->matrikelnr = $matrikelnr;
	}

	/**
	 * Returns the vorname
	 * 
	 * @return string $vorname
	 */
	public function getVorname() {
		return $this->vorname;
	}

	/**
	 * Sets the vorname
	 * 
	 * @param string $vorname
	 * @return void
	 */
	public function setVorname($vorname) {
		$this->vorname = $vorname;
	}

	/**
	 * Returns the nachname
	 * 
	 * @return string $nachname
	 */
	public function getNachname() {
		return $this->nachname;
	}

	/**
	 * Sets the nachname
	 * 
	 * @param string $nachname
	 * @return void
	 */
	public function setNachname($nachname) {
		$this->nachname = $nachname;
	}

	/**
	 * Returns the typo3FEUser
	 * 
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser typo3FEUser
	 */
	public function getTypo3FEUser() {
		return $this->typo3FEUser;
	}

	/**
	 * Sets the typo3FEUser
	 * 
	 * @param string $typo3FEUser
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser typo3FEUser
	 */
	public function setTypo3FEUser($typo3FEUser) {
		$this->typo3FEUser = $typo3FEUser;
	}

}