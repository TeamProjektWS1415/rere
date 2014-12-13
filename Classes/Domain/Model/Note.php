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
	 */
	protected $notenr = 0;

	/**
	 * wert
	 * 
	 * @var string
	 */
	protected $wert = '';

	/**
	 * kommentar
	 * 
	 * @var string
	 */
	protected $kommentar = '';

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

}