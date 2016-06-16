<?php
/**
 * @package     mod_droideforms.Plugin
 * @subpackage  capcha
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author 		André Luiz Pereira <[<and4563@gmail.com>]>
 */

defined('_JEXEC') or die ();

class plgDroideformsCaptcha extends JPlugin{

  public function __construct(&$subject, $config)
  {

    parent::__construct($subject, $config);

  }

  ///// trigger initialice your system
  public function onDroideformsInit()
  {
    $app = JFactory::getApplication();
    $input = $app->input;
    $getimageurl = $input->get('imgjpg',0,'INT');

    if($getimageurl && $app->getName() == 'site'){
      header("Content-Type: image/jpeg");
      $img = $this->generateImage();
      imagejpeg($img);
      exit;
    }else{
        return ;
    }


  }

   /// trigger add valdiate
  public function onDroideformsAddvalidate($post, $validFiltros, &$errors, &$log)
  {
    $session = JFactory::getSession();
    $get_text = $session->get('imgcpt');

    if($get_text != $post['capcha']){
      $errors[] = 'O campo de Captha está incorreto tente novamente.';
    }

  }

 // generate new image
  private function generateImage()
  {

    $session = JFactory::getSession();

                          //largura / altura
     $img = imagecreate(120,40);

     $word = substr(str_shuffle("AaBbCcDdEeFfGgHhJjKkMmNnPpQqRrSsTUuVvYyXxWwZz23456789"),0,4);
     $session->set('imgcpt', $word);
//rgb(168, 181, 255)
     $bgc = imagecolorallocate($img, 168, 181, 255);
     $textcolor  = imagecolorallocate($img, 0, 0, 0);
     imagefilledrectangle($img, 0, 0, 200, 50, $bgc);
     //imagestring($img, 36, 75, 15, $word, $tc);
     imagettftext($img, 19, 0, 30, 27, $textcolor, 'templates/system/images/opensans.ttf',$word);

     return $img;

  }

}
