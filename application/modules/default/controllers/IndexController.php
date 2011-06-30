<?php
class Default_IndexController extends Zend_Controller_Action
{
    public function init()
    {
        $this->_issueService = Zend_Registry::get('Default_DiContainer')->getIssueService();
        $this->_labelService = Zend_Registry::get('Default_DiContainer')->getLabelService();
        $this->_userService = Zend_Registry::get('Default_DiContainer')->getUserService();
    }

    public function indexAction()
    {
        $this->view->openIssues = $this->_issueService->filterIssues('open');

        $this->view->labels = $this->_labelService->getAllLabels();
        $fm = $this->getHelper('FlashMessenger')->getMessages(); 
        $this->view->createLabelForm = (count($fm) > 0) ? $fm[0] : $this->getCreateLabelForm();

        $this->view->labelsSelect = $this->_labelService->getLabelsForSelect($this->view->labels);

        $this->view->usersSelect = $this->_userService->getUsersForSelect();
    }

    public function getCreateLabelForm()
    {
        return $this->_labelService->getCreateForm()->setAction($this->_helper->url->direct('post','labels'));
    }
}
