<?php
class Default_IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $this->_issueService = Zend_Registry::get('Default_DiContainer')->getIssueService();
        $this->view->openIssues = $this->_issueService->filterIssues('open');

        $this->_labelService = Zend_Registry::get('Default_DiContainer')->getLabelService();
        $this->view->labels = $this->_labelService->getAllLabels();
    }
}
