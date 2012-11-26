<?php
/**
 * Classe d'entité d'évènement Google Agenda
 * @author Shivato Web
 * @version 1.0
 *
 */
class GoogleAgendaEvent {
 
    protected $_sTitle;
    protected $_dStartDate;
    protected $_dEndDate;
    protected $_sAddress;
    protected $_sDescription;
    protected $_sAuthorName;
    protected $_sAuthorEmail;
    protected $_dPublishedDate;
    protected $_dUpdatedDate;
    protected $_sUrlDetail;
    protected $_aPersons = array();
    protected $_aReminders = array();
    protected $_dOriginalDate;
    protected $_bRecurs = false;
 
    /**
     * Constructeur
     * @return void
     */
    public function __construct() { }
 
    /**
     * setteur titre
     * @param string $sTitle
     * @return void
     */
    public function setTitle($sTitle) {
        $this->_sTitle = $sTitle;
    }
 
    /**
     * getteur titre
     * @return string
     */
    public function getTitle() {
        return $this->_sTitle;
    }
 
    /**
     * setteur date de début
     * @param date $dStartDate
     * @return void
     */
    public function setStartDate($dStartDate) {
        $this->_dStartDate = $dStartDate;
    }
 
    /**
     * getteur date de début
     * @return date
     */
    public function getStartDate() {
        return $this->_dStartDate;
    }
 
    /**
     * setteur date de fin
     * @param date $dEndDate
     * @return void
     */
    public function setEndDate($dEndDate) {
        $this->_dEndDate = $dEndDate;
    }
 
    /**
     * getteur date de fin
     * @return date
     */
    public function getEndDate() {
        return $this->_dEndDate;
    }
 
    /**
     * setteur adresse
     * @param string $sAddress
     * @return void
     */
    public function setAddress($sAddress) {
        $this->_sAddress = $sAddress;
    }
 
    /**
     * getteur adresse
     * @return string
     */
    public function getAddress() {
        return $this->_sAddress;
    }
 
    /**
     * setteur description
     * @param string $sDescription
     * @return void
     */
    public function setDescription($sDescription) {
        $this->_sDescription = $sDescription;
    }
 
    /**
     * getteur description
     * @return string
     */
    public function getDescription() {
        return $this->_sDescription;
    }
 
    /**
     * setteur date de publication
     * @param date $dPublishedDate
     * @return void
     */
    public function setPublishedDate($dPublishedDate) {
        $this->_dPublishedDate = $dPublishedDate;
    }
 
    /**
     * getteur date de publication
     * @return date
     */
    public function getPublishedDate() {
        return $this->_dPublishedDate;
    }
 
    /**
     * setteur date de modification
     * @param date $dModifiedDate
     * @return void
     */
    public function setUpdatedDate($dUpdatedDate) {
        $this->_dUpdatedDate = $dUpdatedDate;
    }
 
    /**
     * getteur date de modification
     * @return date
     */
    public function getUpdatedDate() {
        return $this->_dUpdatedDate;
    }
 
    /**
     * setteur url détail
     * @param string $sUrlDetail
     * @return void
     */
    public function setUrlDetail($sUrlDetail) {
        $this->_sUrlDetail = $sUrlDetail;
    }
 
    /**
     * getteur url détail
     * @return string
     */
    public function getUrlDetail() {
        return $this->_sUrlDetail;
    }
 
    /**
     * setteur du nom de l'auteur de l'évènement
     * @param string $sAuthorName
     * @return void
     */
    public function setAuthorName($sAuthorName) {
        $this->_sAuthorName = $sAuthorName;
    }
 
    /**
     * getteur du nom de l'auteur de l'évènement
     * @return string
     */
    public function getAuthorName() {
        return $this->_sAuthorName;
    }
 
    /**
     * setteur du mail de l'auteur de l'évènement
     * @param string $sAuthorEmail
     * @return void
     */
    public function setAuthorEmail($sAuthorEmail) {
        $this->_sAuthorEmail = $sAuthorEmail;
    }
 
    /**
     * getteur du mail de l'auteur de l'évènement
     * @return string
     */
    public function getAuthorEmail() {
        return $this->_sAuthorEmail;
    }
 
    /**
     * setteur des personnes attaché à l'évènement
     * @param array $aPersons
     * @return void
     */
    public function setPersons(array $aPersons) {
        $this->_aPersons = $aPersons;
    }
 
    /**
     * getteur des personnes attaché à l'évènement
     * retourne un tableau d'objet de type stdClass() : $aPersons[0]->name, $aPersons[0]->email, $aPersons[0]->role, $aPersons[0]->status
     * @return array
     */
    public function getPersons() {
        return $this->_aPersons;
    }
 
    /**
     * setteur des rappels attaché à l'évènement
     * @param array $aReminders
     * @return void
     */
    public function setReminders(array $aReminders) {
        $this->_aReminders = $aReminders;
    }
 
    /**
     * getteur des rappels attaché à l'évènement
     * retourne un tableau d'objet de type stdClass() : $aReminders[0]->type, $aReminders[0]->minutes
     * @return array
     */
    public function getReminders() {
        return $this->_aReminders;
    }
 
    /**
     * setteur date d'origine
     * @param date $dDate
     * @return void
     */
    public function setOriginalDate($dOriginalDate) {
        $this->_dOriginalDate = $dOriginalDate;
    }
 
    /**
     * getteur date d'origine
     * @return date
     */
    public function getOriginalDate() {
        return $this->_dOriginalDate;
    }
 
    /**
     * setteur évènement récurrent
     * @param bool $bRecurs
     * @return void
     */
    public function setRecurs($bRecurs) {
        $this->_bRecurs = $bRecurs;
    }
 
    /**
     * getteur évènement récurrent
     * @return bool
     */
    public function getRecurs() {
        return $this->_bRecurs;
    }
}
