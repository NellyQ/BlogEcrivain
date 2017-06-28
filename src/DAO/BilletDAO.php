<?php

namespace BlogEcrivain\DAO;

use BlogEcrivain\Domain\Billet;

 

class BilletDAO extends DAO
{
    /*** @var \BlogEcrivain\DAO\CommentDAO
     */
    private $commentDAO;
    
    public function setCommentDAO(CommentDAO $commentDAO) {
        $this->commentDAO = $commentDAO;
    }
    
    
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
            $nbComment = $this->commentDAO->countAllByBillet($billetId);
            $billets[$billetId] = $this->buildDomainObject($row);
            $billets[$billetId]->setNbComment($nbComment);
        }
        return $billets;
    }
    
    
    /**
     * Returns a billet matching the supplied id.
     *
     * @param integer $billet_id
     *
     * @return \BlogEcrivain\Domain\Billet|throws an exception if no matching article is found
     */
    public function find($billet_id) {
        $sql = "select * from billets where billet_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($billet_id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No article matching id " . $billet_id);
    }
    
    
    /**
     * Saves a billet into the database.
     *
     * @param \BlogEcrivain\Domain\Billet The billet to save
     */
    public function save(Billet $billet) {
        $billetData = array(
            'billet_title' => $billet->getBilletTitle(),
            'billet_content' => $billet->getBilletContent(),
            );

        if ($billet->getBilletId()) {
            
            // The billet has already been saved : update it
            $this->getDb()->update('billets', $billetData, array('billet_id' => $billet->getBilletId()));
        } else {
            
            // The billet has never been saved : insert it
            $this->getDb()->insert('billets', $billetData);
            
            // Get the id of the newly created billet and set it on the entity.
            $billet_id = $this->getDb()->lastInsertId();
            $billet->setBilletId($billet_id);
        }
    }

    
    /**
     * Removes a billet from the database.
     *
     * @param integer $billet_id The billet id.
     */
    public function delete($billet_id) {
        // Delete the article
        $this->getDb()->delete('billets', array('billet_id' => $billet_id));
    }

    
    /**Creates a billet object based on a DB row.
     *
     * @param array $row The DB row containing billet data.
     * @return \BlogEcrivain\Domain\Billet
     */
    protected function buildDomainObject(array $row) {
        $billet = new Billet();
        $billet->setBilletId($row['billet_id']);
        $billet->setBilletTitle($row['billet_title']);
        $billet->setBilletContent($row['billet_content']);
        return $billet;
    }
}
