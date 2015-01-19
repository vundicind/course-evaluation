<?php

use JsonRPC\Client;

/**
 * This class will serve as proxy to the LimeSurvey instalation.
 *
 * @author vundicind
 */
class LimeSurvey extends CApplicationComponent {

    public $username;
    public $password;
    public $url;
    private $client;
    private $sessionKey = null;

    public function init() {
        $this->client = new Client("{$this->url}/index.php/admin/remotecontrol", $debug=true);
    }
    
    public function closeSession() {
        $this->client->execute('release_session_key', array($this->sessionKey));
        $this->sessionKey = null;
    }

    public function importSurvey($fileName, $newSurveyName = null) {
        if (empty($this->sessionKey))
            $this->sessionKey = $this->client->execute('get_session_key', array($this->username, $this->password));

        $importData = base64_encode(file_get_contents($fileName));
        $result = $this->client->execute('import_survey', array($this->sessionKey, $importData, 'txt', $newSurveyName));
        print_r($result);
    }
    
    public function listSurveys() {
        if (empty($this->sessionKey))
            $this->sessionKey = $this->client->execute('get_session_key', array($this->username, $this->password));
        
        return $this->client->execute('list_surveys', array($this->sessionKey, null));
    }

    public function deleteSurvey($id) {
        if (empty($this->sessionKey))
            $this->sessionKey = $this->client->execute('get_session_key', array($this->username, $this->password));
        
        return $this->client->execute('delete_survey', array($this->sessionKey, $id));
    }    
 
    public function activateSurvey($id) {
        if (empty($this->sessionKey))
            $this->sessionKey = $this->client->execute('get_session_key', array($this->username, $this->password));
        
        return $this->client->execute('activate_survey', array($this->sessionKey, $id));
    }    
    
    public function listGroups($id) {
        if (empty($this->sessionKey))
            $this->sessionKey = $this->client->execute('get_session_key', array($this->username, $this->password));
        
        return $this->client->execute('list_groups', array($this->sessionKey, $id));
    }    
    
    public function listQuestions($id, $groupId) {
        if (empty($this->sessionKey))
            $this->sessionKey = $this->client->execute('get_session_key', array($this->username, $this->password));
        
        return $this->client->execute('list_questions', array($this->sessionKey, $id, $groupId, 'ro'));
    }    

    public function getQuestionProperties($questionId, $questionSettings) {
        if (empty($this->sessionKey))
            $this->sessionKey = $this->client->execute('get_session_key', array($this->username, $this->password));
        
        return $this->client->execute('get_question_properties', array($this->sessionKey, $questionId, $questionSettings, 'ro'));
    }    

    public function exportResponses($id, $x1, $x2, $x3, $x4, $x5) {
        if (empty($this->sessionKey))
            $this->sessionKey = $this->client->execute('get_session_key', array($this->username, $this->password));
        
        return $this->client->execute('export_responses', array($this->sessionKey, $id, $x1, $x2, $x3, $x4, $x5));
    }    

}
