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

     /**Billet date.
     *
     * @var date
     */
    private $billet_date;

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

    public function getBilletDate() {
        return $this->billet_date;
    }

    public function setBilletDate($billet_date) {
        $this->billet_date = $billet_date;
        return $this;
    }
}
