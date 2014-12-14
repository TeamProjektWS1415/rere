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
 * Note
 */
class Note extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * notenr
	 * 
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $notenr = 0;

	/**
	 * wert
	 * 
	 * @var string
	 * @validate NotEmpty
	 */
	protected $wert = '';

	/**
	 * kommentar
	 * 
	 * @var string
	 * @validate NotEmpty
	 */
	protected $kommentar = '';

	/**
	 * fachnr
	 * 
	 * @var \ReRe\Rere\Domain\Model\Fach
	 */
	protected $fachnr = NULL;

	/**
	 * matrikelnr
	 * 
	 * @var \ReRe\Rere\Domain\Model\Pruefling
	 */
	protected $matrikelnr = NULL;

	/**
	 * Returns the notenr
	 * 
	 * @return integer $notenr
	 */
	public function getNotenr() {
		return $this->notenr;
	}

	/**
	 * Sets the notenr
	 * 
	 * @param integer $notenr
	 * @return void
	 */
	public function setNotenr($notenr) {
		$this->notenr = $notenr;
	}

	/**
	 * Returns the wert
	 * 
	 * @return string $wert
	 */
	public function getWert() {
		return $this->wert;
	}

	/**
	 * Sets the wert
	 * 
	 * @param string $wert
	 * @return void
	 */
	public function setWert($wert) {
		$this->wert = $wert;
	}

	/**
	 * Returns the kommentar
	 * 
	 * @return string $kommentar
	 */
	public function getKommentar() {
		return $this->kommentar;
	}

	/**
	 * Sets the kommentar
	 * 
	 * @param string $kommentar
	 * @return void
	 */
	public function setKommentar($kommentar) {
		$this->kommentar = $kommentar;
	}

	/**
	 * Returns the fachnr
	 * 
	 * @return \ReRe\Rere\Domain\Model\Fach $fachnr
	 */
	public function getFachnr() {
		return $this->fachnr;
	}

	/**
	 * Sets the fachnr
	 * 
	 * @param \ReRe\Rere\Domain\Model\Fach $fachnr
	 * @return void
	 */
	public function setFachnr(\ReRe\Rere\Domain\Model\Fach $fachnr) {
		$this->fachnr = $fachnr;
	}

	/**
	 * Returns the matrikelnr
	 * 
	 * @return \ReRe\Rere\Domain\Model\Pruefling $matrikelnr
	 */
	public function getMatrikelnr() {
		return $this->matrikelnr;
	}

	/**
	 * Sets the matrikelnr
	 * 
	 * @param \ReRe\Rere\Domain\Model\Pruefling $matrikelnr
	 * @return void
	 */
	public function setMatrikelnr(\ReRe\Rere\Domain\Model\Pruefling $matrikelnr) {
		$this->matrikelnr = $matrikelnr;
	}

}