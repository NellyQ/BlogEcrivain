<?php

namespace BlogEcrivain\DAO;

use BlogEcrivain\Domain\Comment;

class CommentDAO extends DAO 
{
    /*** @var \BlogEcrivain\DAO\BilletDAO
     */
    private $billetDAO;

    public function setBilletDAO(BilletDAO $billetDAO) {
        $this->billetDAO = $billetDAO;
    }

    /** Return a list of all comments for an article, sorted by date (most recent last).
     *
     * @param integer $billetId The article id.
     *
     * @return array A list of all comments for the article.
     */
    public function findAllByArticle($billetId) {
        // The associated article is retrieved only once
        $billet = $this->billetDAO->find($billetId);

        // billet_id is not selected by the SQL query
        // The article won't be retrieved during domain objet construction
        $sql = "select com_id, com_content, com_author from comments where billet_id=? order by com_id";
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

    /** Creates an Comment object based on a DB row.
     *
     * @param array $row The DB row containing Comment data.
     * @return \MicroCMS\Domain\Comment
     */
    protected function buildDomainObject(array $row) {
        $comment = new Comment();
        $comment->setComId($row['com_id']);
        $comment->setComContent($row['com_content']);
        $comment->setComAuthor($row['com_author']);

        if (array_key_exists('billet_id', $row)) {
            // Find and set the associated article
            $billetId = $row['billet_id'];
            $billet = $this->billetDAO->find($billetId);
            $comment->setBillet($billet);
        }
        
        return $comment;
    }
}