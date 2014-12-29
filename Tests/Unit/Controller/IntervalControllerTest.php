<?php

namespace ReRe\Rere\Tests\Unit\Controller;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2014
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class ReRe\Rere\Controller\IntervalController.
 *
 */
class IntervalControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

    /**
     * @var \ReRe\Rere\Controller\IntervalController
     */
    protected $subject = NULL;

    protected function setUp() {
        $this->subject = $this->getMock('ReRe\\Rere\\Controller\\IntervalController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
    }

    protected function tearDown() {
        unset($this->subject);
    }

    /**
     * @test
     */
    public function newActionAssignsTheGivenIntervalToView() {
        $interval = new \ReRe\Rere\Domain\Model\Interval();

        $view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
        $view->expects($this->once())->method('assign')->with('newInterval', $interval);
        $this->inject($this->subject, 'view', $view);

        $this->subject->newAction($interval);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenIntervalToIntervalRepository() {
        $interval = new \ReRe\Rere\Domain\Model\Interval();

        $intervalRepository = $this->getMock('ReRe\\Rere\\Domain\\Repository\\IntervalRepository', array('add'), array(), '', FALSE);
        $intervalRepository->expects($this->once())->method('add')->with($interval);
        $this->inject($this->subject, 'intervalRepository', $intervalRepository);

        $this->subject->createAction($interval);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenIntervalToView() {
        $interval = new \ReRe\Rere\Domain\Model\Interval();

        $view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
        $this->inject($this->subject, 'view', $view);
        $view->expects($this->once())->method('assign')->with('interval', $interval);

        $this->subject->editAction($interval);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenIntervalInIntervalRepository() {
        $interval = new \ReRe\Rere\Domain\Model\Interval();

        $intervalRepository = $this->getMock('ReRe\\Rere\\Domain\\Repository\\IntervalRepository', array('update'), array(), '', FALSE);
        $intervalRepository->expects($this->once())->method('update')->with($interval);
        $this->inject($this->subject, 'intervalRepository', $intervalRepository);

        $this->subject->updateAction($interval);
    }

}
