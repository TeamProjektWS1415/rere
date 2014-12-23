<?php
namespace Rere\Rere\Domain\Model;

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
 * Fach
 */
class Fach extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * fachnr
	 * 
	 * @var string
	 * @validate NotEmpty
	 */
	protected $fachnr = '';

	/**
	 * fachname
	 * 
	 * @var string
	 * @validate NotEmpty
	 */
	protected $fachname = '';

	/**
	 * pruefer
	 * 
	 * @var string
	 * @validate NotEmpty
	 */
	protected $pruefer = '';

	/**
	 * notenschema
	 * 
	 * @var string
	 * @validate NotEmpty
	 */
	protected $notenschema = '';

	/**
	 * modulnr
	 * 
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Rere\Rere\Domain\Model\Modul>
	 */
	protected $modulnr = NULL;

	/**
	 * matrikelnr
	 * 
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Rere\Rere\Domain\Model\Pruefling>
	 */
	protected $matrikelnr = NULL;

	/**
	 * Returns the fachnr
	 * 
	 * @return string $fachnr
	 */
	public function getFachnr() {
		return $this->fachnr;
	}

	/**
	 * Sets the fachnr
	 * 
	 * @param string $fachnr
	 * @return void
	 */
	public function setFachnr($fachnr) {
		$this->fachnr = $fachnr;
	}

	/**
	 * Returns the fachname
	 * 
	 * @return string $fachname
	 */
	public function getFachname() {
		return $this->fachname;
	}

	/**
	 * Sets the fachname
	 * 
	 * @param string $fachname
	 * @return void
	 */
	public function setFachname($fachname) {
		$this->fachname = $fachname;
	}

	/**
	 * Returns the pruefer
	 * 
	 * @return string $pruefer
	 */
	public function getPruefer() {
		return $this->pruefer;
	}

	/**
	 * Sets the pruefer
	 * 
	 * @param string $pruefer
	 * @return void
	 */
	public function setPruefer($pruefer) {
		$this->pruefer = $pruefer;
	}

	/**
	 * Returns the notenschema
	 * 
	 * @return string $notenschema
	 */
	public function getNotenschema() {
		return $this->notenschema;
	}

	/**
	 * Sets the notenschema
	 * 
	 * @param string $notenschema
	 * @return void
	 */
	public function setNotenschema($notenschema) {
		$this->notenschema = $notenschema;
	}

	/**
	 * Returns the modulnr
	 * 
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Rere\Rere\Domain\Model\Modul> modulnr
	 */
	public function getModulnr() {
		return $this->modulnr;
	}

	/**
	 * Sets the modulnr
	 * 
	 * @param \ReRe\Rere\Domain\Model\Modul $modulnr
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Rere\Rere\Domain\Model\Modul> modulnr
	 */
	public function setModulnr(\ReRe\Rere\Domain\Model\Modul $modulnr) {
		$this->modulnr = $modulnr;
	}

	/**
	 * __construct
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties
	 * Do not modify this method!
	 * It will be rewritten on each save in the extension builder
	 * You may modify the constructor of this class instead
	 * 
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->modulnr = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->matrikelnr = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

}