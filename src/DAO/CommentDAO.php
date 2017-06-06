<?php

namespace BlogEcrivain\DAO;

use BlogEcrivain\Domain\Comment;

class CommentDAO extends DAO 
{
    /*** @var \BlogEcrivain\DAO\BilletDAO
     */
    private $billetDAO;
    
    /**
     * @var \BlogEcrivain\DAO\UserDAO
     */
    private $userDAO;

    public function setBilletDAO(BilletDAO $billetDAO) {
        $this->billetDAO = $billetDAO;
    }

    public function setUserDAO(UserDAO $userDAO) {
        $this->userDAO = $userDAO;
    }
    
    /** Return a list of all comments for a billet, sorted by date (most recent last).
     *
     * @param integer $billetId The billet id.
     *
     * @return array A list of all comments for the billet.
     */
    public function findAllByArticle($billetId) {
        // The associated article is retrieved only once
        $billet = $this->billetDAO->find($billetId);

        // billet_id is not selected by the SQL query
        // The billet won't be retrieved during domain objet construction
        $sql = "select com_id, com_content, user_id from comments where billet_id=? order by com_id";
        $result = $this->getDb()->fetchAll($sql, array($billetId));

        // Convert query result to an array of domain objects
        $comments = array();
        foreach ($result as $row) {
            $comId = $row['com_id'];
            $comment = $this->buildDomainObject($row);
            // The associated article is defined for the constructed comment
            $comment->setBillet($billet);
            $comments[$comId] = $comment;
        }
        return $comments;
    }
    
    /**
     * Saves a comment into the database.
     *
     * @param \BlogEcrivain\Domain\Comment $comment The comment to save
     */
    public function save(Comment $comment) {
        $commentData = array(
            'billet_id' => $comment->getBillet()->getBilletId(),
            'user_id' => $comment->getComAuthor()->getId(),
            'com_content' => $comment->getComContent()
            );

        if ($comment->getComId()) {
            // The comment has already been saved : update it
            $this->getDb()->update('comments', $commentData, array('com_id' => $comment->getComId()));
        } else {
            // The comment has never been saved : insert it
            $this->getDb()->insert('comments', $commentData);
            // Get the id of the newly created comment and set it on the entity.
            $com_id = $this->getDb()->lastInsertId();
            $comment->setComId($com_id);
        }
    }
    
     public function findAll() {
        $sql = "select * from comments order by com_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['com_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }
    
     /**
     * Removes all comments for a billet
     *
     * @param $billetId The id of the billet
     */
    public function deleteAllByArticle($billetId) {
        $this->getDb()->delete('comments', array('billet_id' => $billetId));
    }
    
    /**
     * Returns a comment matching the supplied id.
     *
     * @param integer $id The comment id
     *
     * @return \BlogEcrivain\Domain\Comment|throws an exception if no matching comment is found
     */
    public function find($com_id) {
        $sql = "select * from comments where com_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($com_id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No comment matching id " . $com_id);
    }

    // ...

    /**
     * Removes a comment from the database.
     *
     * @param @param integer $id The comment id
     */
    public function delete($com_id) {
        // Delete the comment
        $this->getDb()->delete('comments', array('com_id' => $com_id));
    }

    /**
     * Removes all comments for a user
     *
     * @param integer $userId The id of the user
     */
    public function deleteAllByUser($userId) {
        $this->getDb()->delete('comments', array('user_id' => $userId));
    }
    

    /** Creates an Comment object based on a DB row.
     *
     * @param array $row The DB row containing Comment data.
     * @return \MicroCMS\Domain\Comment
     */
    protected function buildDomainObject(array $row) {
        $comment = new Comment();
        $comment->setComId($row['com_id']);
        $comment->setComContent($row['com_content']);
        
        if (array_key_exists('billet_id', $row)) {
            // Find and set the associated article
            $billetId = $row['billet_id'];
            $billet = $this->billetDAO->find($billetId);
            $comment->setBillet($billet);
        }
        
        if (array_key_exists('user_id', $row)) {
            // Find and set the associated author
            $userId = $row['user_id'];
            $user = $this->userDAO->find($userId);
            $comment->setComAuthor($user);
        }
        
        return $comment;
    }
}