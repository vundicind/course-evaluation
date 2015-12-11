<?php

namespace common\components;

use JsonRPC\Client;
use yii\base\Component;

/**
 * This exception will be thrown in case of LimeSurvey errors.
 *
 * @author vundicind
 */
class LimeSurveyException extends \Exception {

}

/**
 * This class will serve as proxy to the LimeSurvey instalation.
 *
 * @author vundicind
 */
class LimeSurvey extends Component
{

    public $username;
    public $password;
    public $url;
    public $surveyId = null;
    private $client;
    private $sessionKey = null;
    
    private function assertNoError($response) 
    {
        if (isset($response['status']) && strpos($response['status'], 'Error: ') === 0)
        {
            throw new LimeSurveyException($response['status']);
        }
    }

    public function init()
    {
        parent::init();

        $this->client = new Client("{$this->url}/index.php/admin/remotecontrol");
        $this->client->debug = true;
    }

    public function closeSession()
    {
        $this->client->execute('release_session_key', array($this->sessionKey));
        $this->sessionKey = null;
    }

    public function importSurvey($fileName, $newSurveyName = null)
    {
        if (empty($this->sessionKey))
            $this->sessionKey = $this->client->execute('get_session_key', array($this->username, $this->password));

        $importData = base64_encode(file_get_contents($fileName));
        $result = $this->client->execute('import_survey', array($this->sessionKey, $importData, 'txt', $newSurveyName));
        print_r($result);
    }

    public function listSurveys()
    {
        if (empty($this->sessionKey))
            $this->sessionKey = $this->client->execute('get_session_key', array($this->username, $this->password));

        return $this->client->execute('list_surveys', array($this->sessionKey, null));
    }

    public function deleteSurvey($id)
    {
        if (empty($this->sessionKey))
            $this->sessionKey = $this->client->execute('get_session_key', array($this->username, $this->password));

        return $this->client->execute('delete_survey', array($this->sessionKey, $id));
    }

    public function activateSurvey($id)
    {
        if (empty($this->sessionKey))
            $this->sessionKey = $this->client->execute('get_session_key', array($this->username, $this->password));

        return $this->client->execute('activate_survey', array($this->sessionKey, $id));
    }

    public function listGroups($id)
    {
        if (empty($this->sessionKey))
            $this->sessionKey = $this->client->execute('get_session_key', array($this->username, $this->password));

        return $this->client->execute('list_groups', array($this->sessionKey, $id));
    }

    public function listQuestions($id, $groupId)
    {
        if (empty($this->sessionKey))
            $this->sessionKey = $this->client->execute('get_session_key', array($this->username, $this->password));

        $response = $this->client->execute('list_questions', array($this->sessionKey, $id, $groupId, 'ro'));
        $this->assertNoError($response);
        return $response;
    }

    public function getQuestionProperties($questionId, $questionSettings)
    {
        if (empty($this->sessionKey))
            $this->sessionKey = $this->client->execute('get_session_key', array($this->username, $this->password));

        return $this->client->execute('get_question_properties', array($this->sessionKey, $questionId, $questionSettings, 'ro'));
    }

    public function setQuestionProperties($questionId, $questionSettings, $language = null)
    {
        if (empty($this->sessionKey))
            $this->sessionKey = $this->client->execute('get_session_key', array($this->username, $this->password));

        return $this->client->execute('set_question_properties', array($this->sessionKey, $questionId, $questionSettings, 'ro'));
    }

    public function exportResponses($id, $x1, $x2, $x3, $x4, $x5)
    {
        if (empty($this->sessionKey))
            $this->sessionKey = $this->client->execute('get_session_key', array($this->username, $this->password));

        return $this->client->execute('export_responses', array($this->sessionKey, $id, $x1, $x2, $x3, $x4, $x5));
    }

    public function getSurveyProperties($id, $surveySettings)
    {
        if (empty($this->sessionKey))
            $this->sessionKey = $this->client->execute('get_session_key', array($this->username, $this->password));

        return $this->client->execute('get_survey_properties', array($this->sessionKey, $id, $surveySettings));
    }

    public function setSurveyProperties($id, $surveySettings)
    {
        if (empty($this->sessionKey))
            $this->sessionKey = $this->client->execute('get_session_key', array($this->username, $this->password));

        return $this->client->execute('set_survey_properties', array($this->sessionKey, $id, $surveySettings));
    }

    public function getSummary($id, $statname = 'all')
    {
        if (empty($this->sessionKey))
            $this->sessionKey = $this->client->execute('get_session_key', array($this->username, $this->password));

        return $this->client->execute('get_summary', array($this->sessionKey, $id, $statname));
    }
}
