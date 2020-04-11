<?php
set_time_limit(0);
include 'Instagram.class.php';
clear();
echo "
 *  INSTAGRAM FEED COMMENTER
 *  ReCode CJDW Team
 *  RECOMMENDED SLEEP 600s
  
    •••••••••••••••••••••••••••••••••••••••••
    
 * Use tools at your own risk.
 * Use this Tool for personal use, not for sale.
 * I am not responsible for your account using this tool.
 * Make sure your account has been verified (Email & Telp).
 
";

## username and password geting
$username    = getUsername();
$password    = getPassword();

$login = login($username, $password);
if ($login['status'] == 'success') {
    echo '[*] Login as ' . $login['username'] . ' Success!' . PHP_EOL;
    $data_login = array(
        'username' => $login['username'],
        'csrftoken' => $login['csrftoken'],
        'sessionid' => $login['sessionid']

    );
    $comment = getComment();
    $sleep = rand(0,10) + getComment('[?]  Sleep in Seconds ( RECOMMENDED 600 )  : ');

       while (true) {
        $profile    = getHome($data_login);
        $data_array = json_decode($profile);
        $result     = $data_array->user->edge_web_feed_timeline;
        foreach ($result->edges as $items) {
            $id       = $items->node->id;
            $username = $items->node->owner->username;


            $like = comment($id, $data_login,$comment);
            if ($like['status'] == 'error') {
                echo '[+] Username: ' . $username . ' | Media_id: ' . $id . ' | Error Comment' . PHP_EOL;
                logout($data_login);
                $login = login($username, $password);
                if ($login['status'] == 'success') {
                    echo '[*] Login as ' . $login['username'] . ' Success!' . PHP_EOL;
                    $data_login = array(
                        'username' => $login['username'],
                        'csrftoken' => $login['csrftoken'],
                        'sessionid' => $login['sessionid']
                    );
                }else{

                    die("Something went wrong");

                }
            } else {
                echo '[+] Username: ' . $username . ' | Media_id: ' . $id . ' | Comment Success' . PHP_EOL;
            }
            break;
        }
        echo '[+] [' . date("H:i:s") . '] Sleep for ' . $sleep . ' seconds [+]' . PHP_EOL;
        sleep( $sleep);
        echo '•••••••••••••••••••••••••••••••••••••••••' . PHP_EOL . PHP_EOL;
    }



}else

    echo json_encode($login);
