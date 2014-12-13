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
 * Pruefling
 */
class Pruefling extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * matrikelnr
	 * 
	 * @var
	 */
	protected $matrikelnr = NULL;

	/**
	 * prueflingvorname
	 * 
	 * @var
	 */
	protected $prueflingvorname = NULL;

	/**
	 * prueflingname
	 * 
	 * @var
	 */
	protected $prueflingname = NULL;

	/**
	 * Returns the matrikelnr
	 * 
	 * @return  $matrikelnr
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
	 * Returns the prueflingvorname
	 * 
	 * @return  $prueflingvorname
	 */
	public function getPrueflingvorname() {
		return $this->prueflingvorname;
	}

	/**
	 * Sets the prueflingvorname
	 * 
	 * @param string $prueflingvorname
	 * @return void
	 */
	public function setPrueflingvorname($prueflingvorname) {
		$this->prueflingvorname = $prueflingvorname;
	}

	/**
	 * Returns the prueflingname
	 * 
	 * @return  $prueflingname
	 */
	public function getPrueflingname() {
		return $this->prueflingname;
	}

	/**
	 * Sets the prueflingname
	 * 
	 * @param string $prueflingname
	 * @return void
	 */
	public function setPrueflingname($prueflingname) {
		$this->prueflingname = $prueflingname;
	}

}