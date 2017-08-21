<?php
include($_SERVER['DOCUMENT_ROOT'] . '/conf.php');

if (!@mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS)) {
    die('Could not connect to the server. Try again later.');
    exit;
} else {
    $database_name = MYSQL_BASE;
    mysql_select_db($database_name);
    mysql_query('SET NAMES utf8');
}

function auth($login, $password, $md5 = false, $sha256 = false, $print = false)
{
    
    $gets = mysql_query("SELECT * FROM user WHERE login='" . $login . "'");
    if (mysql_num_rows($gets) > 0) {
        $get = mysql_fetch_array($gets);
        if ($get['pass'] == ($md5 ? md5($password) : ($sha256 ? hash('sha256', $password) : $password))) {
            
            if ($print != false) {
                $is_int = json_decode(is_in_str($print, ","), true);
                if ($is_int['response'] == 0) {
                    $array['' . $print . ''] = $get[$print];
                    $print_json              = $array;
                } else {
                    $count = substr_count($print, ',');
                    for ($i = 0; $i < $count + 1; $i++) {
                        $exp                       = explode(',', $print);
                        $array['' . $exp[$i] . ''] = $get[$exp[$i]];
                    }
                    $print_json = $array;
                }
            }
            
            $jsonSet = array(
                'response' => array(
                    'error' => 0,
                    'login' => $login,
                    'status' => 'Authorization was successful'
                )
            );
            
            ($md5 ? $jsonSet['response']['md5'] = 'true' : '');
            ($sha256 ? $jsonSet['response']['sha256'] = 'true' : '');
            ($print_json ? $jsonSet['response']['print'] = $print_json : '');
        } else {
            $jsonSet = array(
                'response' => array(
                    'error' => array(
                        'error_code' => error_code_npass,
                        'error_msg' => 'Incorrect password'
                    )
                )
            );
        }
    } else {
        $jsonSet = array(
            'response' => array(
                'error' => array(
                    'error_code' => error_code_nuser,
                    'error_msg' => 'Account does not exist'
                )
            )
        );
    }
    
    return json_encode($jsonSet);
}

function is_in_str($str, $substr)
{
    $result = strpos($str, $substr);
    if ($result === FALSE) {
        $jsonSet = array(
            'response' => 0
        );
    } else {
        $jsonSet = array(
            'response' => 1
        );
    }
    
    return json_encode($jsonSet);
}
?>