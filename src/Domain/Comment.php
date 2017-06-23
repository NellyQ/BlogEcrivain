<?php

namespace BlogEcrivain\Domain;

class Comment 
{
    /** Comment id.
     *
     * @var integer
     */
    private $com_id;

    /**Comment author.
     *
     * @var string
     */
    private $com_author;

    /**Comment content.
     *
     * @var integer
     */
    private $com_content;

    /** Associated article.
     *
     * @var \BlogEcrivain\Domain\Article
     */
    private $billet;
    
    /** Parent ID.
     *
     * @var integer
     */
    private $parent_id;
    
    /** Comment level.
     *
     * @var integer
     */
    private $com_level;
    
    /** Comment signalement.
     *
     * @var integer
     */
    private $com_signal;
    
    

    public function getComId() {
        return $this->com_id;
    }

    public function setComId($com_id) {
        $this->com_id = $com_id;
        return $this;
    }

    public function getComAuthor() {
        return $this->com_author;
    }

    public function setComAuthor($com_author) {
        $this->com_author = $com_author;
        return $this;
    }

    public function getComContent() {
        return $this->com_content;
    }

    public function setComContent($com_content) {
        $this->com_content = $com_content;
        return $this;
    }

    public function getBillet() {
        return $this->billet;
    }

    public function setBillet($billet) {
        $this->billet = $billet;
        return $this;
    }
    
    public function getParentId() {
        return $this->parent_id;
    }

    public function setParentId($parent_id) {
        $this->parent_id = $parent_id;
        return $this;
    }
    
    public function getComLevel() {
        return $this->com_level;
    }

    public function setComLevel($com_level) {
        $this->com_level = $com_level;
        return $this;
    }
    
    public function getComSignal() {
        return $this->com_signal;
    }

    public function setComSignal($com_signal) {
        $this->com_signal = $com_signal;
        return $this;
    }
   
}