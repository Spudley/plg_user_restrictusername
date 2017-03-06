<?php
/**
 * @package   Restrictusername
 * @type      Plugin (User)
 * @version   1.0.0
 * @author    Simon Champion
 * @copyright (C) 2016 Simon Champion
 * @license   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

defined('_JEXEC') or die('Restricted access');

class plgUserRestrictusername extends JPlugin
{
    const MIN_MIN = 2;  //lowest allowed value for minLength.

    protected $autoloadLanguage = true;

    /**
     * @throws RuntimeException if the username is not valid according to the regex.
     */
    public function onUserBeforeSave($user, $isnew, $data)
    {
        if (!$data['username']) {
            return true;
        }

        if ($this->params->get('allowEmail')) {
            if (JFactory::getMailer()->ValidateAddress($data['username'])) {
                return true;
            }
        }

        $regex = $this->buildAllowedCharsRegex();
        if($regex && !preg_match($regex, $data['username'])) {
            throw new RuntimeException($this->allowedCharsErrorMessage());
        }

        return true;
    }

    protected function buildAllowedCharsRegex()
    {
        if($this->params->get('useOwnRegex')) {
            return $this->params->get('userDefinedRegex');
        }

        $characterExpression = implode('', $this->regexesFromParamData());
        if (!$characterExpression) { return ''; }

        $max = (int)$this->params->get('maxLength', 0);
        $min = (int)$this->params->get('minLength', 0);
        if ($min < self::MIN_MIN) { $min = self::MIN_MIN;}
        if ($max < $min) { $max = 0; }

        $lengthRange = "{".$min.",".($max?:'')."}";

        return "/^[{$characterExpression}]{$lengthRange}$/";
    }

    protected function allowedCharsErrorMessage()
    {
        if($this->params->get('userDefinedErrorMessage')) {
            return $this->params->get('userDefinedErrorMessage');
        }

        if($this->params->get('useRegex')) {
            return JText::_('PLG_USER_RESTRICTUSERNAME_NOT_MATCH_REGEX');   //"Invalid Username"
        }

        $errorMessage = JText::_('PLG_USER_RESTRICTUSERNAME_NOT_MEET_CRITERIA');   //"Username does not meet the following criteria:"
        $errorBullets = $this->messagesFromParamData();
        return $errorMessage."<ul><li>".implode('</li><li>', $errorBullets)."</li></ul>";
    }

    protected function messagesFromParamData()
    {
        $output = [];
        foreach($this->paramData() as $paramName=>$paramData) {
            list($rex, $message) = $paramData;
            if($this->params->get($paramName)) {
                $output[] = $message;
            }
        }
        return $output;
    }

    protected function regexesFromParamData()
    {
        $output = [];
        foreach($this->paramData() as $paramName=>$paramData) {
            list($rex, $message) = $paramData;
            if($this->params->get($paramName)) {
                $output[] = $rex;
            }
        }
        return $output;
    }

    protected function paramData() {
        $sym = $this->params->get('userDefinedSymbols');
        return [
            'allowSpaces'   => ['\s',  JText::_('PLG_USER_RESTRICTUSERNAME_MAY_CONTAIN_SPACES')],
            'allowUpper'    => ['A-Z', JText::_('PLG_USER_RESTRICTUSERNAME_MAY_CONTAIN_UPPER')],
            'allowLower'    => ['a-z', JText::_('PLG_USER_RESTRICTUSERNAME_MAY_CONTAIN_LOWER')],
            'allowNumbers'  => ['\d',  JText::_('PLG_USER_RESTRICTUSERNAME_MAY_CONTAIN_NUMBERS')],
            'allowDots'     => [preg_quote('.'), JText::_('PLG_USER_RESTRICTUSERNAME_MAY_CONTAIN_DOTS')],
            'allowDashes'   => [preg_quote('-'), JText::_('PLG_USER_RESTRICTUSERNAME_MAY_CONTAIN_DASHES')],
            'allowSymbols'  => [preg_quote($sym), JText::sprintf('PLG_USER_RESTRICTUSERNAME_MAY_CONTAIN_SYMBOLS', htmlentities($sym))],
            'allowCyrillic' => ['\p{Cyrillic}', JText::_('PLG_USER_RESTRICTUSERNAME_MAY_CONTAIN_CYRILLIC')],
            'allowArabic'   => ['\p{Arabic}', JText::_('PLG_USER_RESTRICTUSERNAME_MAY_CONTAIN_ARABIC')],
            'allowHebrew'   => ['\p{Hebrew}', JText::_('PLG_USER_RESTRICTUSERNAME_MAY_CONTAIN_HEBREW')],
            'allowLatin'    => ['\p{Latin}', JText::_('PLG_USER_RESTRICTUSERNAME_MAY_CONTAIN_LATIN')],

            //no regex for these as they're validated separately, but still here so we can include them in the message.
            'allowEmail'    => ['', JText::_('PLG_USER_RESTRICTUSERNAME_MAY_BE_EMAIL')],
            'minLength'     => ['', JText::sprintf('PLG_USER_RESTRICTUSERNAME_MIN_LENGTH', (int)$this->params->get('minLength', 0))],
            'maxLength'     => ['', JText::sprintf('PLG_USER_RESTRICTUSERNAME_MAX_LENGTH', (int)$this->params->get('maxLength', 0))],
        ];
    }
}

