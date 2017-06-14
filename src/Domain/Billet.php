<?php

namespace BlogEcrivain\Domain;

class Billet
{
    /** Billet id.
     *
     * @var integer
     */
    private $billet_id;

    /** Billet title.
     *
     * @var string
     */
    private $billet_title;

    /**Billet content.
     *
     * @var string
     */
    private $billet_content;

    /**Number of comment.
     *
     * @var integer
     */
    private $nb_comment;

    public function getBilletId() {
        return $this->billet_id;
    }

    public function setBilletId($billet_id) {
        $this->billet_id = $billet_id;
        return $this;
    }

    public function getBilletTitle() {
        return $this->billet_title;
    }

    public function setBilletTitle($billet_title) {
        $this->billet_title = $billet_title;
        return $this;
    }

    public function getBilletContent() {
        return $this->billet_content;
    }

    public function setBilletContent($billet_content) {
        $this->billet_content = $billet_content;
        return $this;
    }
    
     public function getNbComment() {
        return $this->nb_comment;
    }

    public function setNbComment($nb_comment) {
        $this->nb_comment = $nb_comment;
        return $this;
    }

}
