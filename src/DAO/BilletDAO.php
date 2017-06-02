<?php

namespace BlogEcrivain\DAO;

use BlogEcrivain\Domain\Billet;

class BilletDAO extends DAO
{
    /** Return a list of all billets, sorted by date (most recent first).
     *
     * @return array A list of all billets.
     */
    public function findAll() {
        $sql = "select * from billets order by billet_id desc";
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $billets = array();
        foreach ($result as $row) {
            $billetId = $row['billet_id'];
            $billets[$billetId] = $this->buildDomainObject($row);
        }
        return $billets;
    }
    
    /**
     * Returns an article matching the supplied id.
     *
     * @param integer $id
     *
     * @return \MicroCMS\Domain\Article|throws an exception if no matching article is found
     */
    public function find($billet_id) {
        $sql = "select * from billets where billet_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($billet_id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No article matching id " . $billet_id);
    }

    /**Creates an Billet object based on a DB row.
     *
     * @param array $row The DB row containing Billet data.
     * @return \BlogEcrivain\Domain\Billet
     */
    protected function buildDomainObject(array $row) {
        $billet = new Billet();
        $billet->setBilletId($row['billet_id']);
        $billet->setBilletTitle($row['billet_title']);
        $billet->setBilletContent($row['billet_content']);
        $billet->setBilletDate($row['billet_date']);
        return $billet;
    }
}