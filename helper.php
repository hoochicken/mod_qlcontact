<?php
/**
 * @package		mod_qlcontact
 * @copyright	Copyright (C) 2013 ql.de All rights reserved.
 * @author 		Mareike Riegel mareike.riegel@ql.de
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class modQlcontactHelper
{

    static function checkIfUserLoggedIn()
    {
        $user=JFactory::getUser();
        if ($id=$user->get('id')>0) return $id;
        else return false;
    }
    static function checkIfDataOfQlcontact($id)
    {
        $db=JFactory::getDbo();
        $db->setQuery("SELECT * FROM `#__qlcontact` WHERE `id`= '".$id."'");
        $db->query();
        $dataQlcontact=$db->loadObject();
        if (0<count($dataQlcontact)) return true;
        else return false;
        //$db=$this->geDbo();
    }
    static function getData($id,$component,$table,$field='id',$selector='*')
    {
        if (1==JComponentHelper::isEnabled($component))
        {
            $db=JFactory::getDbo();
            $db->setQuery('SELECT '.$selector.' FROM `'.$table.'` WHERE `'.$field.'`= \''.$id.'\'');
            $db->query();
            return $db->loadObject();
        }
    }
    static function mergeObjects($obj1,$obj2,$prefix="")
    {
        if (is_object($obj1) AND is_object($obj2)) { foreach ($obj2 as $k=>$v) $obj1->{$prefix.$k}=$v; return $obj1;}
        elseif (is_object($obj1)) { return $obj1;}
        elseif (is_object($obj2)) { return $obj2;}
        else return false;

    }
    static function getUrl($data)
    {
        require_once JPATH_BASE.'/components/com_contact/helpers/route.php';
        if (!isset($data->id) OR !isset($data->alias) OR !isset($data->catid)) return false;
        $url=JRoute::_(ContactHelperRoute::getContactRoute($data->id.':'.$data->alias, $data->catid));
        if (preg_match('/Itemid/',$url))
        {
            $arr=preg_split('/=/',$url);
            if (is_array($arr) AND isset($arr[1]))
            {
                $db=JFactory::getDbo();
                $db->setQuery('SELECT * FROM `#__menu` WHERE `id`= \''.$arr[1].'\' AND `published`=\'1\'');
                $db->query();
            }
            if(!is_array($arr) OR !isset($arr[1]) OR !preg_match('/option=com_contact/',$db->loadObject()->link))$url=JURI::base().'/index.php?option=com_contact&view=contact&id='.$data->id;
        }
        return $url;
   }

    static function getType()
    {
        $user = JFactory::getUser();
        return (!$user->get('guest')) ? 'logout' : 'qlcontact';
    }
    static function getArticleData($id,$select="*")
    {
        $db=JFactory::getDbo();
        $db->setQuery('SELECT '.$select.' FROM `#__content` WHERE `id`= \''.$id.'\'');
        $db->query();
        if ('*'==$select AND is_object($db->loadObject())) return $db->loadObject();
        elseif (is_object($db->loadObject())) return $db->loadObject()->$select;
        else return false;
    }
    static function getCurrentContact()
    {
        $input=JFactory::getApplication()->input;
        if ('com_contact'==$input->getData('option') AND 'contact'==$input->getData('view'))
        return $input->getData('id');
        return false;
    }
    static function mail($mail,$subject,$post)
    {
        unset($post['hamburger']);
        unset($post['state']);
        $body='';
        while (list($k,$v)=each($post))
        {
            if (is_string($v)) $body.=ucwords($k)."\n".$v."\n\n";
            elseif (is_array($v))$body.=ucwords($k)."\n".json_encode($v)."\n\n";
        }
        $subject=$subject.': '.$post['name'].' <'.$post['email'].'>';
        //echo preg_replace("/\n/",'<br />',$body);die;
        mail($mail,$subject,$body);
        return true;
    }
    static function deJsonify($data,$field)
    {
        if(!isset($data->$field))return $data;
        $arr=json_decode($data->$field);
        while(list($k,$v)=each($arr))
        {
            $data->{$field.'_'.$k}=$v;
        }
        return $data;
    }
}