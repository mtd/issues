<?php
class Default_Model_Mapper_Issue extends Issues_Model_Mapper_DbAbstract
{
    protected $_name = 'issue';

    public function getIssueById($issueId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getTableName())
                  ->where('issue_id = ?', $issueId);
        $row = $db->fetchRow($sql);
        return ($row) ? new Default_Model_Issue($row) : false;
    }

    public function filterIssues($status = false)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getTableName());
        if ($status) {
            $sql->where('status = ?', $status);
        }
        $rows = $db->fetchAll($sql);
        return $this->_rowsToModels($rows);
    }

    public function getAllIssues()
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getTableName());
        $rows = $db->fetchAll($sql);
        return $this->_rowsToModels($rows);
    }

    public function insert(Default_Model_Issue $issue)
    {
        $data = array(
            'title'             => $issue->getTitle(),
            'description'       => $issue->getDescription(),
            'status'            => $issue->getStatus(),
            'project'           => $issue->getProject()->getProjectId(),
            'created_by'        => $issue->getCreatedBy()->getUserId(),
            'created_time'      => new Zend_Db_Expr('NOW()'),
        );
        $db = $this->getWriteAdapter();
        $db->insert($this->getTableName(), $data);
        return $db->lastInsertId();
    }

    public function updateLastUpdate($issue)
    {
        $data = array(
            'last_update_time' => new Zend_Db_Expr('NOW()')
        );
        $db = $this->getWriteAdapter();
        return $db->update($this->getTableName(), $data, $db->quoteInto('issue_id = ?', $issue->getIssueId()));
    }

    protected function _rowsToModels($rows)
    {
        if (!$rows) return array();
        foreach ($rows as $i => $row) {
            $rows[$i] = new Default_Model_Issue($row);
        }
        return $rows;
    }
}