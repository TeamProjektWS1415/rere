<?php
namespace ReRe\Rere\Tests\Unit\Controller;
/***************************************************************
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
 ***************************************************************/

/**
 * Test case for class ReRe\Rere\Controller\NoteController.
 *
 */
class NoteControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \ReRe\Rere\Controller\NoteController
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = $this->getMock('ReRe\\Rere\\Controller\\NoteController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllNotesFromRepositoryAndAssignsThemToView() {

		$allNotes = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$noteRepository = $this->getMock('ReRe\\Rere\\Domain\\Repository\\NoteRepository', array('findAll'), array(), '', FALSE);
		$noteRepository->expects($this->once())->method('findAll')->will($this->returnValue($allNotes));
		$this->inject($this->subject, 'noteRepository', $noteRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('notes', $allNotes);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenNoteToView() {
		$note = new \ReRe\Rere\Domain\Model\Note();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('note', $note);

		$this->subject->showAction($note);
	}

	/**
	 * @test
	 */
	public function newActionAssignsTheGivenNoteToView() {
		$note = new \ReRe\Rere\Domain\Model\Note();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('newNote', $note);
		$this->inject($this->subject, 'view', $view);

		$this->subject->newAction($note);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenNoteToNoteRepository() {
		$note = new \ReRe\Rere\Domain\Model\Note();

		$noteRepository = $this->getMock('ReRe\\Rere\\Domain\\Repository\\NoteRepository', array('add'), array(), '', FALSE);
		$noteRepository->expects($this->once())->method('add')->with($note);
		$this->inject($this->subject, 'noteRepository', $noteRepository);

		$this->subject->createAction($note);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenNoteToView() {
		$note = new \ReRe\Rere\Domain\Model\Note();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('note', $note);

		$this->subject->editAction($note);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenNoteInNoteRepository() {
		$note = new \ReRe\Rere\Domain\Model\Note();

		$noteRepository = $this->getMock('ReRe\\Rere\\Domain\\Repository\\NoteRepository', array('update'), array(), '', FALSE);
		$noteRepository->expects($this->once())->method('update')->with($note);
		$this->inject($this->subject, 'noteRepository', $noteRepository);

		$this->subject->updateAction($note);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenNoteFromNoteRepository() {
		$note = new \ReRe\Rere\Domain\Model\Note();

		$noteRepository = $this->getMock('ReRe\\Rere\\Domain\\Repository\\NoteRepository', array('remove'), array(), '', FALSE);
		$noteRepository->expects($this->once())->method('remove')->with($note);
		$this->inject($this->subject, 'noteRepository', $noteRepository);

		$this->subject->deleteAction($note);
	}
}
