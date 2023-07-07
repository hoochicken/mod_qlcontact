<?php
/**
 * @package        mod_qlcontact
 * @copyright    Copyright (C) 2023 ql.de All rights reserved.
 * @author        Mareike Riegel mareike.riegel@ql.de
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class modQlcontactHelper
{

    static function checkIfUserLoggedIn()
    {
        $user = JFactory::getUser();
        if ($id = $user->get('id') > 0) return $id;
        else return false;
    }

    static function checkIfDataOfQlcontact($id)
    {
        $db = JFactory::getDbo();
        $db->setQuery("SELECT * FROM `#__qlcontact` WHERE `id`= '" . $id . "'");
        $db->query();
        $dataQlcontact = $db->loadObject();
        if (0 < (is_countable($dataQlcontact) ? count($dataQlcontact) : 0)) return true;
        else return false;
        //$db=$this->geDbo();
    }

    static function getData($id, $component, $table, $field = 'id', $selector = '*')
    {
        if (!JComponentHelper::isEnabled($component)) {
            return new stdClass();
        }

        $db = JFactory::getDbo();
        $db->setQuery('SELECT ' . $selector . ' FROM `' . $table . '` WHERE `' . $field . '`= \'' . $id . '\'');

        return $db->loadObject();
    }

    static function mergeObjects($obj1, $obj2, $prefix = "")
    {
        if (is_object($obj1) && is_object($obj2)) {
            foreach ($obj2 as $k => $v) $obj1->{$prefix . $k} = $v;
            return $obj1;
        } elseif (is_object($obj1)) {
            return $obj1;
        } elseif (is_object($obj2)) {
            return $obj2;
        } else return false;

    }

    static function getUrl($data)
    {
        $db = null;
        require_once JPATH_BASE . '/components/com_contact/helpers/route.php';
        if (!isset($data->id) || !isset($data->alias) || !isset($data->catid)) return false;
        $url = JRoute::_(ContactHelperRoute::getContactRoute($data->id . ':' . $data->alias, $data->catid));
        if (preg_match('/Itemid/', (string) $url)) {
            $arr = preg_split('/=/', (string) $url);
            if (is_array($arr) && isset($arr[1])) {
                $db = JFactory::getDbo();
                $db->setQuery('SELECT * FROM `#__menu` WHERE `id`= \'' . $arr[1] . '\' && `published`=\'1\'');
                $db->query();
            }
            if (!is_array($arr) || !isset($arr[1]) || !preg_match('/option=com_contact/', (string) $db->loadObject()->link)) $url = JURI::base() . '/index.php?option=com_contact&view=contact&id=' . $data->id;
        }
        return $url;
    }

    static function getType()
    {
        $user = JFactory::getUser();
        return (!$user->get('guest')) ? 'logout' : 'qlcontact';
    }

    static function getArticleData($id, $select = "*")
    {
        $db = JFactory::getDbo();
        $db->setQuery('SELECT ' . $select . ' FROM `#__content` WHERE `id`= \'' . $id . '\'');
        $db->query();
        if ('*' == $select && is_object($db->loadObject())) return $db->loadObject();
        elseif (is_object($db->loadObject())) return $db->loadObject()->$select;
        else return false;
    }

    static function getCurrentContact()
    {
        $input = JFactory::getApplication()->input;
        if ('com_contact' == $input->getData('option') && 'contact' == $input->getData('view'))
            return $input->getData('id');
        return false;
    }

    static function mail($mail, $subject, $post)
    {
        unset($post['hamburger']);
        unset($post['state']);
        $body = '';
        foreach ($post as $k => $v) {
            if (is_string($v)) $body .= ucwords((string) $k) . "\n" . $v . "\n\n";
            elseif (is_array($v)) $body .= ucwords((string) $k) . "\n" . json_encode($v, JSON_THROW_ON_ERROR) . "\n\n";
        }
        $subject = $subject . ': ' . $post['name'] . ' <' . $post['email'] . '>';
        //echo preg_replace("/\n/",'<br />',$body);die;
        mail((string) $mail, $subject, $body);
        return true;
    }

    static function deJsonify($data, $field)
    {
        if (!isset($data->$field)) return $data;
        $arr = json_decode((string) $data->$field, null, 512, JSON_THROW_ON_ERROR);
        foreach ($arr as $k => $v) {
            $data->{$field . '_' . $k} = $v;
        }
        return $data;
    }
}