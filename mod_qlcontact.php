<?php
/**
 * @package		mod_qlcontact
 * @copyright	Copyright (C) 2013 ql.de All rights reserved.
 * @author 		Mareike Riegel mareike.riegel@ql.de
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

require_once dirname(__FILE__).'/helper.php';

$type=modQlcontactHelper::getType();
$user=JFactory::getUser();
$input=JFactory::getApplication()->input;

$data=new stdClass();
if (1==$params->get('displaytype'))
{
    if (''!=$params->get('contact') AND 0<$params->get('contact'))$contact=$params->get('contact');
    else $contact=modQlcontactHelper::getCurrentContact();
    if (is_numeric($contact) AND 0<$contact)
    {


        $dataContact=modQlcontactHelper::getData($contact,'com_contact','#__contact_details', 'id');
        if (is_object($dataContact))while(list($k,$v)=each($dataContact))$data->{'contact_'.$k}=$v;
        $email=$dataContact->email_to;
    }
    else unset($data);
}
elseif (2==$params->get('displaytype'))
{
    if (''!=$params->get('user') AND 0<$params->get('user'))$user=$params->get('user');
    else $user=modQlcontactHelper::getArticleData($input->get('id'),'created_by');
    if (is_numeric($user) AND 0<$user)
    {
        $dataUser=modQlcontactHelper::getData($user,'com_users','#__users');
        $dataContact=modQlcontactHelper::getData($user,'com_contact','#__contact_details', 'user_id');
        if(isset($dataContact->email_to) AND ''!=$dataContact->email_to) $email=$dataContact->email_to;
        else $email=$dataUser->email;
        $data=modQlcontactHelper::mergeObjects($data,$dataContact,'contact_');
        if (is_object($dataUser))while (list($k,$v)=each($dataUser)) $data->{'user_'.$k}=$v;
    }
    else unset($data);
}

/*SENDING MAIL START*/
if (0<count($_POST) AND isset($_POST['hamburger']) AND ''==$_POST['hamburger']) $sent=modQlcontactHelper::mail($email,$params->get('email_subject'),$_POST);
if (isset($sent) AND true==$sent)
{
    header('Location:'.$params->get('redirect'));
    exit;
}
/*SENDING MAIL STOP*/
if (isset($data) AND is_object($data))
{
    $data=modQlcontactHelper::deJsonify($data,'contact_params');
    $ordering=array_flip(preg_split("?\n?",$params->get('ordering')));
    foreach ($ordering as $k=>$v){$ordering[trim($k)]=$v;if ($k!=trim($k))unset($ordering[$k]);}
    asort($ordering);
    $dataDisplay=new stdClass();
    foreach ($ordering as $k=>$v) {if (isset($data->$k))$dataDisplay->$k=$data->$k;}
    foreach ($data as $k=>$v)
    {
        $dataDisplay->$k=$v;
    }
    $arrPositions=array_flip($params->get('data'));
    $dataDisplay=array_intersect_key((array)$dataDisplay,$arrPositions);
    $link=modQlcontactHelper::getUrl($dataContact);
}
require JModuleHelper::getLayoutPath('mod_qlcontact', $params->get('layout', 'default'));