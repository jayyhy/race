<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TeacherController extends CController {

    protected function renderJSON($data) {
        header('Content-type: application/json');
        echo CJSON::encode($data);

        foreach (Yii::app()->log->routes as $route) {
            if ($route instanceof CWebLogRoute) {
                $route->enabled = false; // disable any weblogroutes
            }
        }
        Yii::app()->end();
    }

    public $layout = '//layouts/teacherBar';

    public function actionSet() {       //set
        $result = 'no';
        $mail = '';
        $userid_now = Yii::app()->session['userid_now'];
        $user = Teacher::model()->find('userID=?', array($userid_now));
        if (!empty($user->mail_address)) {
            $mail = $user->mail_address;
        }
        if (isset($_POST['old'])) {
            $new1 = $_POST['new1'];
            $defnew = $_POST['defnew'];
            $usertype = Yii::app()->session['role_now'];
            $user = Teacher::model()->find('userID=?', array($userid_now));
            if ($user->password != md5($_POST['old'])) {
                $result = 'old error';
                $this->render('set', ['result' => $result, 'mail' => $mail]);
                return;
            }
            $user->password = md5($new1);
            $result = $user->update();
        }
        $this->render('set', ['result' => $result]);
    }

    public function actionIndex() {
        $this->render('index');
    }
    public function actionRaceLst() {
        $aList = RaceIndex::model()->getAllRaceIndex();
        $result = $aList['list'];
        $pages = $aList['pages'];
        $this->render('raceLst', array(
            'raceLst' => $result,
            'pages' => $pages,
            'result' => ''
        ));
    }
        public function actionEditRace() {
        $aList = RaceIndex::model()->getAllRaceIndex();
        $raceList = $aList['list'];
        $step = $_GET["step"];
        $indexID = $_GET["indexID"];
        $result = "";
        $render = '';
        $result2 = "";
        $result3 = "";
        $result4 = "";
        $result5 = "";
        switch ($step) {
            case 1:
                if (isset($_POST['time'])) {
                    $time = $_POST['time']*60;
//                    $score = $_POST['score'];
                    Race::model()->addRace($indexID, $step, "", 0, $time, "", "");
                    $result = 1;
                }
                $render = 'One';
                break;
            case 2:
                if (isset($_POST['time'])) {
                    $flag = Race::model()->find("indexID=? AND step =?", array($indexID, $step));
                    $time = $_POST['time']*60;
                    $txtNoSpace="";
                    if(!empty($_FILES["myfile"]['name'])){
                     $tmp_file = $_FILES ['myfile'] ['tmp_name'];
                     $file_types = explode(".", $_FILES ['myfile'] ['type']);
                     $file_type = $file_types [count($file_types) - 1];
                     // 判别是不是excel文件
                     if (strtolower($file_type) != "text/plain") {
                        $result = '不是txt文件';
                     } else {
                     // 解析文件并存入数据库逻辑
                     /* 设置上传路径 */
                      $savePath = dirname(Yii::app()->BasePath) . "./resources/race/";
                      $file_name = "-" . $_FILES ['myfile'] ['name'] . "-";
                      $file_name = iconv("UTF-8","GB2312//IGNORE",$file_name);
                      if (!copy($tmp_file, $savePath . $file_name)) {
                        $result = '上传失败';
                      } else {
                        $file_dir = $savePath . $file_name;
                        $file_dir = str_replace("\\", "\\\\", $file_dir);
                        $fp = fopen($file_dir, "r");
                        move_uploaded_file($file_name, $savePath);
                        $file_name=iconv("gb2312","UTF-8", $file_name);
                        if (filesize($file_dir) < 1) {
                            $result = '空文件，上传失败';
                        } else {
                            $content = fread($fp, filesize($file_dir)); //读文件 
                            $encode = mb_detect_encoding($content, array("ASCII","UTF-8","GB2312","GBK",'BIG5'));
                            if($encode == ""){
                                $content = iconv('UCS-2', 'utf-8', $content);
                            }else if($encode =="EUC-CN"){
                                $content = iconv('GBK', 'utf-8', $content);
                            }    
                            $txtContent = Tool::SBC_DBC($content, 0);
                            Race::model()->addRace($indexID, $step, $txtContent, 0, $time, "", "");
                            $result = "1";
                       }
                    }
                }
            }else {
                $txtContent = $flag["content"];
                Race::model()->addRace($indexID, $step, $txtContent, 0, $time, "", "");
                $result = "1";
            }
                    
        }
                $render = 'Two';
                break;
            case 3:
                if (isset($_POST['content'])) {
//                    $time = $_POST['time'];
//                    $score = $_POST['score'];
                    $txtNoSpace = "";
//                    $score2 = $_POST['score2'];
//                    $content2 = $_POST['content2'];
                    $dir = "./resources/race/";                    
                    if (!is_dir($dir)) {
                        mkdir($dir, 0777);
                    }
                    $radioDir = "./resources/race/radio/";
                    if (!is_dir($radioDir)) {
                        mkdir($radioDir, 0777);
                    }
                    $flag = Race::model()->find("indexID=? AND step =?", array($indexID, $step));
                    $flag2 = Race::model()->find("indexID=? AND step =?", array($indexID, 32));
                    if ($flag==null){
                        if($_FILES["files"]["name"]!=""){
                         if ($_FILES ['files'] ['type'] != "audio/mpeg" &&
                            $_FILES ['files'] ['type'] != "audio/wav" &&
                            $_FILES ['files'] ['type'] != "audio/x-wav") {
                                $result5 = '试音音频文件格式不正确，应为MP3或WAV格式';
                            } else if ($_FILES['files']['error'] > 0) {
                                 $result5 = '试音音频文件上传失败';
                              }else {
                        $oldName = $_FILES["files"]["name"];
                        $newName = Tool::createID() . "." . pathinfo($oldName, PATHINFO_EXTENSION);
                        move_uploaded_file($_FILES["files"]["tmp_name"], $radioDir . iconv("UTF-8", "gb2312", $newName));
                        Resourse::model()->insertAudition($newName, $oldName,$indexID);
                        
//                        $result = "1";
                            } 
                        }
                            if ($_FILES ['file'] ['type'] != "audio/mpeg" &&
                            $_FILES ['file'] ['type'] != "audio/wav" &&
                            $_FILES ['file'] ['type'] != "audio/x-wav") {
                            $result4 = '第一个音频格式不正确，应为MP3或WAV格式';
                        } else if ($_FILES['file']['error'] > 0) {
                                 $result4 = '第一个音频文件上传失败';
                         } else {
                        $oldName = $_FILES["file"]["name"];
                        $newName = Tool::createID() . "." . pathinfo($oldName, PATHINFO_EXTENSION);
                        move_uploaded_file($_FILES["file"]["tmp_name"], $dir . iconv("UTF-8", "gb2312", $newName));
                        Resourse::model()->insertRelaVoice($newName, $oldName);
                        $file=realpath($dir . iconv("UTF-8", "gb2312", $newName));
                        $player=new COM("WMPlayer.OCX");
                        $media=$player->newMedia($file);
                        $time=round($media->duration);
                        if(!empty($_FILES["myfile"]['name'])){
                         $tmp_file = $_FILES ['myfile'] ['tmp_name'];
                         $file_types = explode(".", $_FILES ['myfile'] ['type']);
                         $file_type = $file_types [count($file_types) - 1];
                        // 判别是不是excel文件
                         if (strtolower($file_type) != "text/plain") {
                            $result3 = '上传答案不是txt文件';
                        } else {
                        // 解析文件并存入数据库逻辑
                        /* 设置上传路径 */
                        $savePath = dirname(Yii::app()->BasePath) . "./resources/race/";
                        $file_name = "-" . $_FILES ['myfile'] ['name'] . "-";
                        $file_name = iconv("UTF-8","GB2312//IGNORE",$file_name);
                        if (!copy($tmp_file, $savePath . $file_name)) {
                            $result3 = '上传答案失败';
                        } else {
                            $file_dir = $savePath . $file_name;
                            $file_dir = str_replace("\\", "\\\\", $file_dir);
                            $fp = fopen($file_dir, "r");
                            move_uploaded_file($file_name, $savePath);
                            $file_name=iconv("gb2312","UTF-8", $file_name);
                        if (filesize($file_dir) < 1) {
                            $result3 = '上传答案为空文件，上传失败';
                        } else {
                            $content = fread($fp, filesize($file_dir)); //读文件 
                            $encode = mb_detect_encoding($content, array("ASCII","UTF-8","GB2312","GBK",'BIG5'));
                            if($encode == ""){
                                $content = iconv('UCS-2', 'utf-8', $content);
                            }else if($encode =="EUC-CN"){
                                $content = iconv('GBK', 'utf-8', $content);
                            }    
                            $txtContent = Tool::SBC_DBC($content, 0);
                            $txtNoSpace = Tool::filterAllSpaceAndTab($txtContent);
                          
                           if ($_FILES ['file2'] ['type'] != "audio/mpeg" &&
                          $_FILES ['file2'] ['type'] != "audio/wav" &&
                          $_FILES ['file2'] ['type'] != "audio/x-wav") {
                          $result2 = '第二个音频文件格式不正确，应为MP3或WAV格式';
                          } else if ($_FILES['file2']['error'] > 0) {
                              $result2 = '第二个音频文件上传失败';
                         } else {
                              Race::model()->addRace($indexID, $step, $txtNoSpace, 0, $time, $newName, $oldName);
                           $oldName = $_FILES["file2"]["name"];
                           $newName = Tool::createID() . "." . pathinfo($oldName, PATHINFO_EXTENSION);
                           move_uploaded_file($_FILES["file2"]["tmp_name"], $dir . iconv("UTF-8", "gb2312", $newName));
                           Resourse::model()->insertRelaVoice($newName, $oldName);
                           $file=realpath($dir . iconv("UTF-8", "gb2312", $newName));
                           $player=new COM("WMPlayer.OCX");
                           $media=$player->newMedia($file);
                           $time=round($media->duration);
                           Race::model()->addRace($indexID, 32, "", 0, $time, $newName, $oldName);
                           $step4 = Race::model()->find("indexID=? AND step=?", array($indexID, 4));
                           Race::model()->addRace($indexID, 4, "", 0, $step4['time'], "", "");
                           $result = "1";
                        } 
                       }
                    }
                }
            }
         }  
          
     }
                else {
                   $newName = $flag['resourseID'];
                   $oldName = $flag['fileName'];
                   $time = $flag['time'];
                   $txtNoSpace = $flag['content']; 
                   if($_FILES["files"]["name"]!=""){
                         if ($_FILES ['files'] ['type'] != "audio/mpeg" &&
                            $_FILES ['files'] ['type'] != "audio/wav" &&
                            $_FILES ['files'] ['type'] != "audio/x-wav") {
                                $result5 = '试音音频文件格式不正确，应为MP3或WAV格式';
                            } else if ($_FILES['files']['error'] > 0) {
                                 $result5 = '试音音频文件上传失败';
                              }else {
                        $oldNames = $_FILES["files"]["name"];
                        $newNames = Tool::createID() . "." . pathinfo($oldNames, PATHINFO_EXTENSION);
                        move_uploaded_file($_FILES["files"]["tmp_name"], $radioDir . iconv("UTF-8", "gb2312", $newNames));
                        Resourse::model()->insertAudition($newNames, $oldNames,$indexID);
//                        $result = "1";
                            } 
                        }
                   if($_FILES["file"]["name"]!=""){
                        if ($_FILES ['file'] ['type'] != "audio/mpeg" &&
                            $_FILES ['file'] ['type'] != "audio/wav" &&
                            $_FILES ['file'] ['type'] != "audio/x-wav") {
                                $result4 = '第一个音频文件格式不正确，应为MP3或WAV格式';
                            } else if ($_FILES['file']['error'] > 0) {
                                 $result4 = '第一个音频文件上传失败';
                              }else {
                        $oldName = $_FILES["file"]["name"];
                        $newName = Tool::createID() . "." . pathinfo($oldName, PATHINFO_EXTENSION);
                        move_uploaded_file($_FILES["file"]["tmp_name"], $dir . iconv("UTF-8", "gb2312", $newName));
                        Resourse::model()->insertRelaVoice($newName, $oldName);
                        $file=realpath($dir . iconv("UTF-8", "gb2312", $newName));
                        $player=new COM("WMPlayer.OCX");
                        $media=$player->newMedia($file);
                        $time=round($media->duration);
                        
//                        $step4 = Race::model()->find("indexID=? AND step=?", array($indexID, 4));
//                        Race::model()->addRace($indexID, 4, $content, $step4['score'], $step4['time'], "", "");
                        $result = "1";
                            } 
                        }
                        if(!empty($_FILES["myfile"]['name'])){
                            $tmp_file = $_FILES ['myfile'] ['tmp_name'];
                            $file_types = explode(".", $_FILES ['myfile'] ['type']);
                            $file_type = $file_types [count($file_types) - 1];
                            // 判别是不是excel文件
                            if (strtolower($file_type) != "text/plain") {
                                $result3 = '上传答案不是txt文件';
                             } else {
                            // 解析文件并存入数据库逻辑
                            /* 设置上传路径 */
                                $savePath = dirname(Yii::app()->BasePath) . "./resources/race/";
                                $file_name = "-" . $_FILES ['myfile'] ['name'] . "-";
                                $file_name = iconv("UTF-8","GB2312//IGNORE",$file_name);
                                if (!copy($tmp_file, $savePath . $file_name)) {
                                   $result3 = '上传答案失败';
                                } else {
                                    $file_dir = $savePath . $file_name;
                                    $file_dir = str_replace("\\", "\\\\", $file_dir);
                                    $fp = fopen($file_dir, "r");
                                    move_uploaded_file($file_name, $savePath);
                                    $file_name=iconv("gb2312","UTF-8", $file_name);
                                    if (filesize($file_dir) < 1) {
                                        $result3 = '上传答案为空文件，上传失败';
                                    } else {
                                        $content = fread($fp, filesize($file_dir)); //读文件 
                                        $encode = mb_detect_encoding($content, array("ASCII","UTF-8","GB2312","GBK",'BIG5'));
                                        if($encode == ""){
                                           $content = iconv('UCS-2', 'utf-8', $content);
                                        }else if($encode =="EUC-CN"){
                                            $content = iconv('GBK', 'utf-8', $content);
                                        }    
                                        $txtContent = Tool::SBC_DBC($content, 0);
                                        $txtNoSpace = Tool::filterAllSpaceAndTab($txtContent);
                                        $result = "1";
                                    }
                                }
                            }
                     }
                     Race::model()->addRace($indexID, $step, $txtNoSpace, 0, $time, $newName, $oldName);
                     
                 if($_FILES["file2"]["name"]!=""){
                        if ($_FILES ['file2'] ['type'] != "audio/mpeg" &&
                            $_FILES ['file2'] ['type'] != "audio/wav" &&
                            $_FILES ['file2'] ['type'] != "audio/x-wav") {
                                $result2 = '第二个音频文件格式不正确，应为MP3或WAV格式';
                            } else if ($_FILES['file2']['error'] > 0) {
                                 $result2 = '第二个音频文件上传失败';
                              }else {
                        $oldName = $_FILES["file2"]["name"];
                        $newName = Tool::createID() . "." . pathinfo($oldName, PATHINFO_EXTENSION);
                        move_uploaded_file($_FILES["file2"]["tmp_name"], $dir . iconv("UTF-8", "gb2312", $newName));
                        Resourse::model()->insertRelaVoice($newName, $oldName);
                        $file=realpath($dir . iconv("UTF-8", "gb2312", $newName));
                        $player=new COM("WMPlayer.OCX");
                        $media=$player->newMedia($file);
                        $time=round($media->duration);
                        Race::model()->addRace($indexID, 32, "", 0, $time, $newName, $oldName);
                        $step4 = Race::model()->find("indexID=? AND step=?", array($indexID, 4));
                        Race::model()->addRace($indexID, 4, "", 0, $step4['time'], "", "");
                        $result = "1";
                            } 
                        }else {
                           $newName = $flag2['resourseID'];
                           $oldName = $flag2['fileName'];
                           $time = $flag2['time'];
                           Race::model()->addRace($indexID, 32, "", 0, $time, $newName, $oldName);
                        }    
         }          
             }
                $render = 'Three';
                break;
            case 4:
                if (isset($_POST['time'])) {
                    $flag = Race::model()->find("indexID=? AND step =?", array($indexID, $step));
                    $time = $_POST['time']*60;
                    $txtNoSpace="";
                    if(!empty($_FILES["myfile"]['name'])){
                     $tmp_file = $_FILES ['myfile'] ['tmp_name'];
                     $file_types = explode(".", $_FILES ['myfile'] ['type']);
                     $file_type = $file_types [count($file_types) - 1];
                     // 判别是不是excel文件
                     if (strtolower($file_type) != "text/plain") {
                        $result = '不是txt文件';
                     } else {
                     // 解析文件并存入数据库逻辑
                     /* 设置上传路径 */
                      $savePath = dirname(Yii::app()->BasePath) . "./resources/race/";
                      $file_name = "-" . $_FILES ['myfile'] ['name'] . "-";
                      $file_name = iconv("UTF-8","GB2312//IGNORE",$file_name);
                      if (!copy($tmp_file, $savePath . $file_name)) {
                        $result = '上传失败';
                      } else {
                        $file_dir = $savePath . $file_name;
                        $file_dir = str_replace("\\", "\\\\", $file_dir);
                        $fp = fopen($file_dir, "r");
                        move_uploaded_file($file_name, $savePath);
                        $file_name=iconv("gb2312","UTF-8", $file_name);
                        if (filesize($file_dir) < 1) {
                            $result = '空文件，上传失败';
                        } else {
                            $content = fread($fp, filesize($file_dir)); //读文件 
                            $encode = mb_detect_encoding($content, array("ASCII","UTF-8","GB2312","GBK",'BIG5'));
                            if($encode == ""){
                                $content = iconv('UCS-2', 'utf-8', $content);
                            }else if($encode =="EUC-CN"){
                                $content = iconv('GBK', 'utf-8', $content);
                            }                          
                            $txtContent = Tool::SBC_DBC($content, 0);
                            $txtNoSpace = Tool::filterAllSpaceAndTab($txtContent);
                            Race::model()->addRace($indexID, $step, $txtNoSpace, 0, $time, "", "");
                            $result = "1";
                       }
                    }
                }
            }else {
                $txtContent = $flag["content"];
                Race::model()->addRace($indexID, $step, $txtContent, 0, $time, "", "");
                $result = "1";
            }
                }
                $render = 'Four';
                break;
            case 5:
                if (isset($_POST['content'])) {
                    $flag5 = Race::model()->find("indexID=? AND step=?", array($indexID, $step));
                    $dir = "./resources/race/";
                    if (!is_dir($dir)) {
                        mkdir($dir, 0777);
                    }
                if($flag5== NULL){
                    if($_FILES["file"]["name"]!=""){
                    if ($_FILES ['file'] ['type'] != "audio/mpeg" &&
                            $_FILES ['file'] ['type'] != "audio/wav" &&
                            $_FILES ['file'] ['type'] != "audio/x-wav") {
                        $result = '文件格式不正确，应为MP3或WAV格式';
                    } else if ($_FILES['file']['error'] > 0) {
                        $result = '文件上传失败';
                    } else {
                        $oldName = $_FILES["file"]["name"];
                        $newName = Tool::createID() . "." . pathinfo($oldName, PATHINFO_EXTENSION);
                        move_uploaded_file($_FILES["file"]["tmp_name"], $dir . iconv("UTF-8", "gb2312", $newName));
                        Resourse::model()->insertRelaVoice($newName, $oldName);
                        $file=realpath($dir . iconv("UTF-8", "gb2312", $newName));
                        $player=new COM("WMPlayer.OCX");
                        $media=$player->newMedia($file);
                        $time=round($media->duration);
                 if(!empty($_FILES["myfile"]['name'])){
                     $tmp_file = $_FILES ['myfile'] ['tmp_name'];
                     $file_types = explode(".", $_FILES ['myfile'] ['type']);
                     $file_type = $file_types [count($file_types) - 1];
                     // 判别是不是excel文件
                     if (strtolower($file_type) != "text/plain") {
                        $result = '不是txt文件';
                     } else {
                     // 解析文件并存入数据库逻辑
                     /* 设置上传路径 */
                      $savePath = dirname(Yii::app()->BasePath) . "./resources/race/";
                      $file_name = "-" . $_FILES ['myfile'] ['name'] . "-";
                      $file_name = iconv("UTF-8","GB2312//IGNORE",$file_name);
                      if (!copy($tmp_file, $savePath . $file_name)) {
                        $result = '上传失败';
                      } else {
                        $file_dir = $savePath . $file_name;
                        $file_dir = str_replace("\\", "\\\\", $file_dir);
                        $fp = fopen($file_dir, "r");
                        move_uploaded_file($file_name, $savePath);
                        $file_name=iconv("gb2312","UTF-8", $file_name);
                        if (filesize($file_dir) < 1) {
                            $result = '空文件，上传失败';
                        } else {
                            $content = fread($fp, filesize($file_dir)); //读文件 
                            $encode = mb_detect_encoding($content, array("ASCII","UTF-8","GB2312","GBK",'BIG5'));
                            if($encode == ""){
                                $content = iconv('UCS-2', 'utf-8', $content);
                            }else if($encode =="EUC-CN"){
                                $content = iconv('GBK', 'utf-8', $content);
                            }    
                            $txtContent = Tool::SBC_DBC($content, 0);
                            $txtNoSpace = Tool::filterAllSpaceAndTab($txtContent);
                           Race::model()->addRace($indexID, $step, $txtNoSpace, 0, $time, $newName, $oldName);
                            $result = "1";
                       }
                    }
                }
            }
                        
     }
                }
                }else {
                    $txtNoSpace = $flag5['content'];
                    $time = $flag5['time'];
                    $newName = $flag5['resourseID'];
                    $oldName = $flag5['fileName'];
                   if($_FILES["file"]["name"]!=""){
                      if ($_FILES ['file'] ['type'] != "audio/mpeg" &&
                            $_FILES ['file'] ['type'] != "audio/wav" &&
                            $_FILES ['file'] ['type'] != "audio/x-wav") {
                        $result2 = '文件格式不正确，应为MP3或WAV格式';
                    } else if ($_FILES['file']['error'] > 0) {
                        $result2 = '文件上传失败';
                    } else {
                        $oldName = $_FILES["file"]["name"];
                        $newName = Tool::createID() . "." . pathinfo($oldName, PATHINFO_EXTENSION);
                        move_uploaded_file($_FILES["file"]["tmp_name"], $dir . iconv("UTF-8", "gb2312", $newName));
                        Resourse::model()->insertRelaVoice($newName, $oldName);
                        $file=realpath($dir . iconv("UTF-8", "gb2312", $newName));
                        $player=new COM("WMPlayer.OCX");
                        $media=$player->newMedia($file);
                        $time=round($media->duration);
                        $result = "1";
                    } 
                   } 
                   if(!empty($_FILES["myfile"]['name'])){
                     $tmp_file = $_FILES ['myfile'] ['tmp_name'];
                     $file_types = explode(".", $_FILES ['myfile'] ['type']);
                     $file_type = $file_types [count($file_types) - 1];
                     // 判别是不是excel文件
                     if (strtolower($file_type) != "text/plain") {
                        $result3 = '不是txt文件';
                     } else {
                     // 解析文件并存入数据库逻辑
                     /* 设置上传路径 */
                      $savePath = dirname(Yii::app()->BasePath) . "./resources/race/";
                      $file_name = "-" . $_FILES ['myfile'] ['name'] . "-";
                      $file_name = iconv("UTF-8","GB2312//IGNORE",$file_name);
                      if (!copy($tmp_file, $savePath . $file_name)) {
                        $result3 = '上传失败';
                      } else {
                        $file_dir = $savePath . $file_name;
                        $file_dir = str_replace("\\", "\\\\", $file_dir);
                        $fp = fopen($file_dir, "r");
                        move_uploaded_file($file_name, $savePath);
                        $file_name=iconv("gb2312","UTF-8", $file_name);
                        if (filesize($file_dir) < 1) {
                            $result3 = '空文件，上传失败';
                        } else {
                            $content = fread($fp, filesize($file_dir)); //读文件 
                            $encode = mb_detect_encoding($content, array("ASCII","UTF-8","GB2312","GBK",'BIG5'));
                            if($encode == ""){
                                $content = iconv('UCS-2', 'utf-8', $content);
                            }else if($encode =="EUC-CN"){
                                $content = iconv('GBK', 'utf-8', $content);
                            }    
                            $txtContent = Tool::SBC_DBC($content, 0);
                            $txtNoSpace = Tool::filterAllSpaceAndTab($txtContent);
                            $result = "1";
                       }
                    }
                }
            }
                 Race::model()->addRace($indexID, $step, $txtNoSpace, 0, $time, $newName, $oldName);
//                 $result = "1";   
                }
              }
                $render = 'Five';
                break;
            case 6:
                if (isset($_POST['time'])) {
                    $flag6 = Race::model()->find("indexID=? AND step=?", array($indexID, $step));
                    $time = $_POST['time']*60;
                    $dir = "./resources/race/";
                    if (!is_dir($dir)) {
                        mkdir($dir, 0777);
                    }
                 if($flag6 == NULL){
                if($_FILES["file"]["name"]!=""){
                    if ($_FILES["file"]["type"] == "video/mp4" || $_FILES["file"]["type"] == "application/octet-stream" && substr($_FILES["file"]["name"], strrpos($_FILES["file"]["name"], '.') + 1) != "rm" && substr($_FILES["file"]["name"], strrpos($_FILES["file"]["name"], '.') + 1) != "RM") {
                        if ($_FILES["file"]["error"] > 0) {
                            $result = "Return Code: " . $_FILES["file"]["error"];
                        } else {
                            $oldName = $_FILES["file"]["name"];
                            $newName = Tool::createID() . "." . pathinfo($oldName, PATHINFO_EXTENSION);
                            move_uploaded_file($_FILES["file"]["tmp_name"], $dir . iconv("UTF-8", "gb2312", $newName));
                            Resourse::model()->insertRelaVideo($newName, $oldName);
                            Race::model()->addRace($indexID, $step, "", 0, $time, $newName, $oldName);  
                            $result ="1";
                        }
                    } else {
                        $result = "请上传正确类型的文件！";
                    }
                 }
                }else {
                    $newName = $flag6['resourseID'];
                    $oldName = $flag6['fileName'];
                  if($_FILES["file"]["name"]!=""){
                    if ($_FILES["file"]["type"] == "video/mp4" || $_FILES["file"]["type"] == "application/octet-stream" && substr($_FILES["file"]["name"], strrpos($_FILES["file"]["name"], '.') + 1) != "rm" && substr($_FILES["file"]["name"], strrpos($_FILES["file"]["name"], '.') + 1) != "RM") {
                        if ($_FILES["file"]["error"] > 0) {
                            $result2 = "Return Code: " . $_FILES["file"]["error"];
                        } else {
                            $oldName = $_FILES["file"]["name"];
                            $newName = Tool::createID() . "." . pathinfo($oldName, PATHINFO_EXTENSION);
                            move_uploaded_file($_FILES["file"]["tmp_name"], $dir . iconv("UTF-8", "gb2312", $newName));
                            Resourse::model()->insertRelaVideo($newName, $oldName);
                            Race::model()->addRace($indexID, $step, "", 0, $time, $newName, $oldName);
                            $result ="1";
                        } 
                    }else {
                        $result2 = "请上传正确类型的文件！";
                    }
                  }else {
                      Race::model()->addRace($indexID, $step, "", 0, $time, $newName, $oldName);
                      $result ="1";
                  }
                   
                }
              }
                $render = 'Six';
                break;
        }
        $race = Race::model()->find("indexID=? AND step=?", array($indexID, $step));
        if($render == "Three"){
            $race2 = Race::model()->find("indexID=? AND step=?", array($indexID, 32));
            $this->render('editRace' . $render, array(
                'raceLst' => $raceList,
            'race' => $race,
            'race2'=>$race2,
            'result' => $result,
            'result2' => $result2,
            'result3' => $result3,
            'result4' => $result4,
            'result5' => $result5,
            'step' => $step
           )); 
        }  else {
           $this->render('editRace' . $render, array(
               'raceLst' => $raceList,
            'race' => $race,
            'result' => $result,
            'result2' => $result2,
            'result3' => $result3,
            'step' => $step
           )); 
        }
        
    }
     public function ActionGetProgress() {
        session_start();
        $i = ini_get('session.upload_progress.name');
        $key = ini_get("session.upload_progress.prefix") . $_GET[$i];
        if (!empty($_SESSION[$key])) {
            $current = $_SESSION[$key]["bytes_processed"];
            $total = $_SESSION[$key]["content_length"];
            echo $current < $total ? ceil($current / $total * 100) : 100;
        } else {
            echo 100;
        }
    }
        public function actionDeleteRaceIndex() {
        if (isset($_GET['indexID'])) {
            $indexID = $_GET['indexID'];
            RaceIndex::model()->deleteRaceIndex($indexID);
            $result = 1;
        }

        if (isset($_POST['checkbox'])) {
            $result = 1;
            $userIDlist = $_POST['checkbox'];
            foreach ($userIDlist as $v) {
                RaceIndex::model()->deleteRaceIndex($v);
            }
            $aList = RaceIndex::model()->getAllRaceIndex();
            $raceLst = $aList ['list'];
            $pages = $aList ['pages'];
            $this->render('raceLst', array(
                'raceLst' => $raceLst,
                'pages' => $pages,
                'result' => $result,
            ));
        } else {
            $aList = RaceIndex::model()->getAllRaceIndex();
            $raceLst = $aList ['list'];
            $pages = $aList ['pages'];
            $this->render('raceLst', array(
                'raceLst' => $raceLst,
                'pages' => $pages,
                'result' => $result
            ));
        }
    }
    public function actionIsRepeated() {
        $courseName = $_POST["courseName"];
        $results =  RaceIndex::model()->find("name = '$courseName'");
        $data = "0";
        if($results !=NULL){
            $data ="1";
        }
        echo $data;
    }
    
    public function actionAddRaceIndex() {
        $raceName = $_GET['raceName'];
        $teacherID = Yii::app()->session['userid_now'];
        $classID = Teacher::model()->find("userID=?", array($teacherID))['classID'];
        RaceIndex::model()->addRaceIndex($raceName,$classID);
        $aList = RaceIndex::model()->getAllRaceIndex();
        $result = $aList['list'];
        $pages = $aList['pages'];
        $this->render('raceLst', array(
            'raceLst' => $result,
            'pages' => $pages,
            'result' => ''
        ));
    }
    
    public function actionteaInformation() {
        $ID = Yii::app()->session['userid_now'];
        $teacher = Teacher::model()->find("userID = '$ID'");
        return $this->render('teaInformation', array(
                    'id' => $teacher ['userID'],
                    'name' => $teacher ['userName'],
                    'password' => $teacher['password'],
        ));
    }

    public function ActionUpdateTime() {      //更新时间
        $type = $_GET['type'];
        $examID = $_GET['examID'];
        /*
          $startTime=$_POST['startTime'];
          $endTime=$_POST['endTime'];
          $examTime=$_POST['examTime'];


          $date=floor((strtotime($endTime)-strtotime($startTime))/86400);
          $hour=floor((strtotime($endTime)-strtotime($startTime))%86400/3600);
          $minute=floor((strtotime($endTime)-strtotime($startTime))%86400/60);
          $second=floor((strtotime($endTime)-strtotime($startTime))%86400%60);
          if($second>=60){
          $minute+=($second/60);
          $second=$second%60;
          }

          if($minute>=60){
          $hour=$hour+(int)($hour/60);
          $minute=$minute%60;
          }
          if($hour>=24){
          $date+=($date/24);
          $hour=$hour%24;
          }
          $duration=(strtotime($endTime)-strtotime($startTime))/60;
          $duration=$examTime;
          Race::model()->updateByPk($examID,array('begintime'=>$startTime,'endtime'=>$endTime,'duration'=>$duration));
         * 
         */
        $this->renderModifyExam($type, $examID);
    }

    //公告信息
    public function actionteacherNotice() {
        $result = Notice::model()->findNotice();
        $noticeRecord = $result ['noticeLst'];
        $pages = $result ['pages'];
        $teacherID = Yii::app()->session['userid_now'];
        $noticeS = Teacher::model()->findByPK($teacherID);
        $noticeS->noticestate = '0';
        $noticeS->update();
        $this->render('teacherNotice', array('noticeRecord' => $noticeRecord, 'pages' => $pages));
    }

    public function actionNoticeContent() {
        $result = 0;
        if (isset($_GET['action']) && $_GET['action'] == 'edit') {
            $result = 1;
        }
        $id = $_GET['id'];
        $noticeRecord = Notice::model()->find("id= '$id'");
        $this->render('noticeContent', array('noticeRecord' => $noticeRecord));
    }

    public function actionRaceControl() {
        $teacherID = Yii::app()->session['userid_now'];
        $teacher = Teacher::model()->find("userID=?", array($teacherID));
        $course = Course::model()->find("courseID=?", array($teacher['classID']));
        $pager = RaceIndex::model()->getAllRaceIndex();
        $raceIndex = $pager['list'];
        $pages = $pager['pages'];
        $isoncourse = $course['onRaceID'];
        $this->render('raceControl', array("course" => $course, "raceIndex" => $raceIndex, "pages" => $pages,"isoncourse"=>$isoncourse));
    }

    public function actionControl() {
        $step = $_GET['step'];
        $indexID = $_GET['indexID'];
        $flag = 0;
        $race = Race::model()->find("indexID=? AND step=?", array($indexID, $step));
        $teacherID = Yii::app()->session['userid_now'];
        $pager = RaceIndex::model()->getAllRaceIndex();
        $raceIndex = $pager['list'];
        
        if(isset($_GET['over'])){
            if($step != 6){
              $race = Race::model()->find("indexID=? AND step=?", array($indexID, $step+1));
            }
         }
        switch ($step) {
            case 1:
                if (isset($_GET['raceID'])) {
                    $CDTime = $_GET['CDTime'];
                    Course::model()->startRace($_GET['raceID'], $teacherID,$CDTime);
                }
                if (isset($_GET['over'])) {
                    Course::model()->overRace($teacherID);
                    $step = $step + 1;
                    Race::model()->isover($indexID,$step);
                    $render = "Two";
                    break;
                }
                $render = "One";
                break;
            case 2:
                if (isset($_GET['raceID'])) {
                    $CDTime = $_GET['CDTime'];
                    Course::model()->startRace($_GET['raceID'], $teacherID,$CDTime);
                }
                if (isset($_GET['over'])) {
                    Course::model()->overRace($teacherID);
                    $step = $step + 1;
                    Race::model()->isover($indexID,$step);
                    $render = "Three";
                    $tip = 0;
                    break;
                }
                $render = "Two";
                break;
            case 3:
                if (isset($_GET['raceID'])) {
                   $CDTime = $_GET['CDTime'];
                   Course::model()->startRace($_GET['raceID'], $teacherID,$CDTime);
                }
                if (isset($_GET['over'])) {
                    Course::model()->overRace($teacherID);
                    $step = $step + 1;
                    Race::model()->isover($indexID,$step);
                    $step = 32;
                    $race = Race::model()->find("indexID=? AND step=?", array($indexID, $step));
                    $render = "Three1";
                    $tip = 1;
                    break;
                }
                $tip = 1;
                $render = "Three";
                break;
            case 4:
                if (isset($_GET['raceID']) && $_GET['raceID']!= "") {
                    $CDTime = $_GET['CDTime'];
                    Course::model()->startRace($_GET['raceID'], $teacherID,$CDTime);
                }
                if (isset($_GET['over'])) {
                    Course::model()->overRace($teacherID);
                    $step = $step + 1;
                    Race::model()->isover($indexID,$step);
                    $render = "Five";
                    break;
                }
                $render = "Four";
                break;
            case 5:
                if (isset($_GET['raceID'])) {
                    $CDTime = $_GET['CDTime'];
                    Course::model()->startRace($_GET['raceID'], $teacherID,$CDTime);
                }
                if (isset($_GET['over'])) {
                    Course::model()->overRace($teacherID);
                    $step = $step + 1;
                    Race::model()->isover($indexID,$step);
                    $render = "Six";
                    break;
                }
                $render = "Five";
                break;
            case 6:
                if (isset($_GET['raceID'])) {
                    $CDTime = $_GET['CDTime'];
                    Course::model()->startRace($_GET['raceID'], $teacherID,$CDTime);
                }
                if (isset($_GET['over'])) {
                    Course::model()->overRace($teacherID);
                    $step = $step + 1;
                    Race::model()->isover($indexID,$step);
                    $render = "Six";
                    $step = $step - 1;
                    break;
                }
                $render = "Six";
                break;
            case 32:
                if (isset($_GET['raceID'])) {
                    $CDTime = $_GET['CDTime'];
                    Course::model()->startRace($_GET['raceID'], $teacherID,$CDTime);
                }
                if (isset($_GET['over'])) {
                    Course::model()->overRace($teacherID);
                    $step = 32;
                    Race::model()->isover($indexID,$step);
                    $step = 4;
                    $tip = 1;
                    $render = "Four";
                    break;
                }
                $step = 32;
                $render = "Three1";
                $tip = 0;
                break;
        }
            
        $endTime = Course::model()->isOpen($teacherID);
        if ($endTime != 0) {
            $flag = 1;
        }
        $nowOnStep = Course::model()->getNowOnStep($teacherID);
        if($render == "Three"){
           $race2 = Race::model()->find("indexID=? AND step=?", array($indexID, 32));
          $this->render('control' . $render, array("step" => $step,"raceIndex" => $raceIndex, "race" => $race,'race2'=>$race2, "flag" => $flag, "endTime" => $endTime, "nowOnStep" => $nowOnStep,"tip" =>$tip));  
        }
        else if ($render == "Three1") {
            $race2 = Race::model()->find("indexID=? AND step=?", array($indexID, 3));
            $race = Race::model()->find("indexID=? AND step=?", array($indexID, 32));
          $this->render('control' . $render, array("step" => $step,"raceIndex" => $raceIndex, "race" => $race,'race2'=>$race2, "flag" => $flag, "endTime" => $endTime, "nowOnStep" => $nowOnStep,"tip" =>$tip));  
         }
         else if ($render == "Four") {
            $race = Race::model()->find("indexID=? AND step=?", array($indexID, 4));
          $this->render('control' . $render, array("step" => $step,"raceIndex" => $raceIndex, "race" => $race, "flag" => $flag, "endTime" => $endTime, "nowOnStep" => $nowOnStep));  
         }
        else {
          $this->render('control' . $render, array("step" => $step, "raceIndex" => $raceIndex,"race" => $race, "flag" => $flag, "endTime" => $endTime, "nowOnStep" => $nowOnStep));
        }
    }

    public function actionMarkRace() {
        $teacherID = Yii::app()->session['userid_now'];
        $teacher = Teacher::model()->find("userID=?", array($teacherID));
        $course = Course::model()->find("courseID=?", array($teacher['classID']));
        $pager = RaceIndex::model()->getAllRaceIndex();
        $raceIndex = $pager['list'];
        $pages = $pager['pages'];
        $this->render('markRace', array("course" => $course, "raceIndex" => $raceIndex, "pages" => $pages));
    }

    public function actionStuLst() {
        $teacherID = Yii::app()->session['userid_now'];
        $classID = Teacher::model()->find("userID=?", array($teacherID))['classID'];
        $lstWithPages = Student::model()->getStuLstByClassID($classID);
        $students = $lstWithPages['list'];
        $pages = $lstWithPages['pages'];
        $indexID = $_GET['indexID'];
        $raceIndex = RaceIndex::model()->find("indexID=?", array($indexID));
        $this->render('stuLst', array("students" => $students, "pages" => $pages, "raceIndex" => $raceIndex));
    }

    public function actionDetail() {
        $step = $_GET['step'];
        $indexID = $_GET['indexID'];
        $race = Race::model()->find("indexID=? AND step=?", array($indexID, $step));
        $stuID = $_GET['stuID'];
        $raceID = $race['raceID'];
        $answer = AnswerRecord::model()->find("studentID=? AND raceID=?", array($stuID, $raceID));
        $result = "";
        $render = "";
        $totalScore = AnswerRecord::model()->getAllScoreByStudentIDAndIndexID($stuID,$indexID);
        switch ($step) {
            case 1:
                if (isset($_POST['mark'])) {
                    $mark = $_POST['mark'];
                    $result = AnswerRecord::model()->markScore($stuID, $raceID, $mark, '');
                }
                $render = "One";
                break;
            case 2:
                if (isset($_POST['mark'])) {
                    $mark = $_POST['mark'];
                    $rate = $_POST['rate'];
                    $result = AnswerRecord::model()->markScore($stuID, $raceID, $mark,$rate);
                }
                $render = "Two";
                break;
            case 3:
                if (isset($_POST['mark'])) {
                    $mark = $_POST['mark'];
                    $result = AnswerRecord::model()->markScore($stuID, $raceID, $mark, '');
                }
                $render = "Three";
                break;
            case 4:
                if (isset($_POST['mark'])) {
                    $mark = $_POST['mark'];
                    $result = AnswerRecord::model()->markScore($stuID, $raceID, $mark, '');
                }
                $render = "Four";
                break;
            case 5:
                if (isset($_POST['mark'])) {
                    $mark = $_POST['mark'];
                    $result = AnswerRecord::model()->markScore($stuID, $raceID, $mark, '');
                }
                $render = "Five";
                break;
            case 6:
                if (isset($_POST['mark'])) {
                    $mark = $_POST['mark'];
                    $result = AnswerRecord::model()->markScore($stuID, $raceID, $mark, '');
                }
                $render = "Six";
                break;
        }
        $this->render("detail" . $render, array("step" => $step, "race" => $race,'totalScore'=>$totalScore, 'answer' => $answer, 'result' => $result));
    }
    public function actionresults(){
            $aList = RaceIndex::model()->getAllRaceIndex();
            $result = $aList['list'];
            $pages = $aList['pages'];
            $arrayData = Array();
            $data = Array();
        if(isset($_GET['indexID'])){
            $indexID = $_GET['indexID'];
            $stuList = Student::model()->findAll();
            foreach ($stuList as $key => $studentID){
                $studentID = $studentID['userID'];
                $step1 = Race::model()->find("step=? AND indexID=?",array(1,$indexID));
                $step1 = $step1['raceID'];
                $resultstep1 = AnswerRecord::model()->find("studentID=? AND raceid=?", array($studentID, $step1));
                $step2 = Race::model()->find("step=? AND indexID=?",array(2,$indexID));
                $step2 = $step2['raceID'];
                $resultstep2 = AnswerRecord::model()->find("studentID=? AND raceid=?", array($studentID, $step2));
                $step3 = Race::model()->find("step=? AND indexID=?",array(3,$indexID));
                $step3 = $step3['raceID'];
                $resultstep3 = AnswerRecord::model()->find("studentID=? AND raceid=?", array($studentID, $step3));
                $step4 = Race::model()->find("step=? AND indexID=?",array(4,$indexID));
                $step4 = $step4['raceID'];
                $resultstep4 = AnswerRecord::model()->find("studentID=? AND raceid=?", array($studentID, $step4));
                $step5 = Race::model()->find("step=? AND indexID=?",array(5,$indexID));
                $step5 = $step5['raceID'];
                $resultstep5 = AnswerRecord::model()->find("studentID=? AND raceid=?", array($studentID, $step5));
                $step6 = Race::model()->find("step=? AND indexID=?",array(6,$indexID));
                $step6 = $step6['raceID'];
                $resultstep6 = AnswerRecord::model()->find("studentID=? AND raceid=?", array($studentID, $step6));
                $arrayData = ["studentID"=>$studentID,
                "resultstep1"=>$resultstep1,"resultstep2"=>$resultstep2,
                "resultstep3"=>$resultstep3,"resultstep4"=>$resultstep4,
                "resultstep5"=>$resultstep5,"resultstep6"=>$resultstep6,
                ];
                array_push($data, $arrayData);
            }
            $this->render('results', array(
            'raceLst' => $result,
            'pages' => $pages,
            'stuList' => $stuList,
            'data' => $data,
        ));
        }else{
        $this->render('results', array(
            'raceLst' => $result,
            'pages' => $pages,
            'result' => ''
        ));}
    }
    public function actionExportresults(){ 
            $arrayData = Array();
            $data = Array();
            $indexID = $_GET['indexID'];
            $stuList = Student::model()->findAll();
            foreach ($stuList as $key => $studentID){
                $studentID = $studentID['userID'];
                $step1 = Race::model()->find("step=? AND indexID=?",array(1,$indexID));
                $step1 = $step1['raceID'];
                $resultstep1 = AnswerRecord::model()->find("studentID=? AND raceid=?", array($studentID, $step1));
                $step2 = Race::model()->find("step=? AND indexID=?",array(2,$indexID));
                $step2 = $step2['raceID'];
                $resultstep2 = AnswerRecord::model()->find("studentID=? AND raceid=?", array($studentID, $step2));
                $step3 = Race::model()->find("step=? AND indexID=?",array(3,$indexID));
                $step3 = $step3['raceID'];
                $resultstep3 = AnswerRecord::model()->find("studentID=? AND raceid=?", array($studentID, $step3));
                $step4 = Race::model()->find("step=? AND indexID=?",array(4,$indexID));
                $step4 = $step4['raceID'];
                $resultstep4 = AnswerRecord::model()->find("studentID=? AND raceid=?", array($studentID, $step4));
                $step5 = Race::model()->find("step=? AND indexID=?",array(5,$indexID));
                $step5 = $step5['raceID'];
                $resultstep5 = AnswerRecord::model()->find("studentID=? AND raceid=?", array($studentID, $step5));
                $step6 = Race::model()->find("step=? AND indexID=?",array(6,$indexID));
                $step6 = $step6['raceID'];
                $resultstep6 = AnswerRecord::model()->find("studentID=? AND raceid=?", array($studentID, $step6));
                $arrayData = ["studentID"=>$studentID,
                "resultstep1"=>$resultstep1,"resultstep2"=>$resultstep2,
                "resultstep3"=>$resultstep3,"resultstep4"=>$resultstep4,
                "resultstep5"=>$resultstep5,"resultstep6"=>$resultstep6,
                ];
                array_push($data, $arrayData);
            }   
        $title=array('学号','看打','听打','听打校对','盲打','视频纠错');
        $filename="考场".$indexID."导出结果";
        /* 把引入PHPExcel.php文件 */
        Yii::$enableIncludePath = false;
        Yii::import('application.extensions.PHPExcel.PHPExcel', 1);
        $styleArray1 = array(
            'font' => array(
            'bold' => true,
            'size'=>14,
            'color'=>array(
            'argb' => '00000000',),
        ));
        $objectPHPExcel = new PHPExcel();
        $objectPHPExcel->setActiveSheetIndex(0);
        $objActSheet = $objectPHPExcel->getActiveSheet();
        $objectPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleArray1);
        $objectPHPExcel->getActiveSheet()->setCellValue('A1','学号');
        $objectPHPExcel->getActiveSheet()->setCellValue('B1','看打');
        $objectPHPExcel->getActiveSheet()->setCellValue('C1','听打');
        $objectPHPExcel->getActiveSheet()->setCellValue('D1','听打校对');
        $objectPHPExcel->getActiveSheet()->setCellValue('E1','盲打');
        $objectPHPExcel->getActiveSheet()->setCellValue('F1','视频纠错');
        //设置字体居中
        $objectPHPExcel->getActiveSheet()->getStyle('A1:F101')
        ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objectPHPExcel->getActiveSheet()->getStyle('A1:F101')
        ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objectPHPExcel->getActiveSheet()->getStyle('A1:F1')
        ->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ccffff');
        //设置视频纠错自动换行和宽度
        $objActSheet->getColumnDimension('D')->setWidth(16);
        $objActSheet->getColumnDimension('F')->setWidth(350);
        $objectPHPExcel->getActiveSheet()->getStyle('F1:F101')->getAlignment()->setWrapText(true);
        $one = 2;$two = 2;$tree = 2;$four =2;$five = 2;$six = 2;
        //导出考生成绩信息
        if (!empty($data)){
              foreach ($data as $k => $model):
              $objectPHPExcel->getActiveSheet()->setCellValue('A'.($one++) ,$model['studentID']);
              if($model['resultstep2']['rate']==null){
              $objectPHPExcel->getActiveSheet()->setCellValue('B'.($two++) ,"未作答");}
              else{
              $objectPHPExcel->getActiveSheet()->setCellValue('B'.($two++) ,$model['resultstep2']['rate']."%");}
              if($model['resultstep3']['rate']==null){
              $objectPHPExcel->getActiveSheet()->setCellValue('C'.($tree++) ,"未作答");}
              else{
              $objectPHPExcel->getActiveSheet()->setCellValue('C'.($tree++) ,$model['resultstep3']['rate']."%");}
              if($model['resultstep4']['rate']==null){
              $objectPHPExcel->getActiveSheet()->setCellValue('D'.($four++) ,"未作答");}
              else{
              $objectPHPExcel->getActiveSheet()->setCellValue('D'.($four++) ,$model['resultstep4']['rate']."%");}
              if($model['resultstep5']['rate']==null){
              $objectPHPExcel->getActiveSheet()->setCellValue('E'.($five++) ,"未作答");}
              else{
              $objectPHPExcel->getActiveSheet()->setCellValue('E'.($five++) ,$model['resultstep5']['rate']."%");}
              if($model['resultstep6']['rate']==null){
              $objectPHPExcel->getActiveSheet()->setCellValue('F'.($six++) ,"未作答");}
              else{
              $objectPHPExcel->getActiveSheet()->setCellValue('F'.($six++) ,$model['resultstep6']['content']);} 
              endforeach;
      }
        ob_end_clean();
        ob_start();
        header('Content-Type : application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="'."$filename".'.xls"');
        $objWriter= PHPExcel_IOFactory::createWriter($objectPHPExcel,'Excel5');
        $objWriter->save('php://output');
        exit;
//    return $this->renderPartial('simple',['data'=>$data,'indexID'=>$indexID]);
        }
    public function actionIsOvered() {
        $indexID = $_POST['indexID'];
        $tags = "1";
         $raceList = Race::model()->findAll("indexID = '$indexID'");
         foreach ($raceList as $r) {
             if($r["is_over"] == 0){
                 $tags = "0";
                 break;
             }
         }
         echo $tags;
    
    }
}