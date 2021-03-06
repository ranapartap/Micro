<?php
//namespace Micro\Libs;
//use Micro\Core\SessionManager;

/**
 * Get directory path
 * @param string $directory
 * @return absolute path to the directory specified
 */
function getPath($directory) {

    switch (strtolower($directory)) {
        case 'view':
        case 'views':
            return PATH_VIEW;
            break;

        case 'lib':
        case 'libs':
        case 'library':
            return PATH_LIB;
            break;
    }

    return '';
}

/**
 * Get url for given path
 * @param string $path
 * @param string $add_post_slash (optional) default true, Weather slash at the end of url
 * @return string Full url to the path
 */
function get_url($path, $add_post_slash = true) {

    return URL . URL_SEPARATOR . $path . ($add_post_slash || URL_ADD_POST_SLASH ? URL_SEPARATOR : '' );
}

/**
 * Get Admin Base url
 * @param type $path Add path to admin url
 * @param string $add_post_slash (optional) default true, Weather slash at the end of url
 * @return string Full url to the ADMIN path
 */
function admin_url($path = null, $add_post_slash = true) {

    return URL . URL_SEPARATOR . ADMIN_BASE . ($path && $path != '' ? URL_SEPARATOR . $path : '') . ($add_post_slash && URL_ADD_POST_SLASH ? URL_SEPARATOR : '' );
}

/**
 * Chack current admin url and supplied path is same
 * @param type $path to compare
 * @return boolean Success on compare success
 */
function curent_url_verify($path = null) {
    return ltrim(URI, '/') == ADMIN_BASE . ($path && $path != '' ? URL_SEPARATOR . $path : '');
}

function get_username($user_id = null) {

    if (!$user_id) {
        $session = new \Micro\Core\SessionManager();
        $user = $session->getSession()->user;
    } else {
        if (!$user = Micro\Core\Application::$app->db->connection->users("id = ?", $user_id)->fetch())
            return false;

        $user = fetch_row($user);
    }

    if ($user)
        return empty($user->fullname) ? $user->username : $user->fullname;

    return '';
}

/**
 * Get Base url for the application
 * @return string Full url to the application
 */
function getBaseUrl() {

    return URL;
}

/**
 * Debug Print n Die Function
 */
function dd($var, $can_die = false) {
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    if ($can_die)
        die();
}

function arrayToObject($array) {
    return json_decode(json_encode($array));
//    if (is_array($d)) {
//        return (object) array_map(__FUNCTION__, $d);
//    } else {
//        return $d;
//    }
}

function error_exit($error, $description = null) {
    ?>
    <style>
        .content {
            -webkit-font-smoothing: antialiased;
            font-family: Georgia, serif;
            width: 90%;
            margin: 40px auto;
            padding: 20px;
            border: 1px solid #e5e5e5;
            border-radius: 4px;
            background-color: rgba(249, 249, 249, 0.96);
        }

    </style>

    <div class="content">
        <h2><?= $error ?></h2>
        <?= $description ? "<p>" . $description . "</p>" : '' ?>
    </div>
    <?php
    exit;
}

/**
 * Get base url as per parameters provided
 *
 * echo base_url();
 *          - http://stackoverflow.com/questions/2820723/
 * echo base_url(TRUE);
 *          - http://stackoverflow.com/
 * echo base_url(TRUE, TRUE); || echo base_url(NULL, TRUE);
 *          - http://stackoverflow.com/questions/
 *
 */
function base_url($root_only = false, $atCore = false) {
    if (isset($_SERVER['HTTP_HOST'])) {
        $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
        $hostname = $_SERVER['HTTP_HOST'];
        $dir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

        $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
        $core = $core[0];

        $tmplt = $root_only ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
        $end = $root_only ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
        $base_url = sprintf($tmplt, $http, $hostname, $end);
        // $base_url = $root_only && strpos($_SERVER['SCRIPT_NAME'], '/dev') >= 0 ? $base_url.'dev/' : $base_url;
    } else
        $base_url = 'http://localhost/';

     $base_url = URL_PUBLIC_FOLDER ? str_replace('/'.URL_PUBLIC_FOLDER, '', $base_url) : $base_url;

    return $base_url;
}

/**
 * Get site url
 */
function site_url($location = false) {
    $url = rtrim(base_url(), '/');

    if (!$location)
        return $url;

    return $url . $location . '/';
}

/**
 * NotORM - Fetch a single from NotORM single result object
 * @param type $notORM_object
 * @return object $row
 */
function fetch_row($notORM_object) {

    if (!is_object($notORM_object))
        return false;

    foreach ($notORM_object as $key => $user_channel) {
        $array[$key] = $user_channel;
    }

    return arrayToObject($array);
}

/**
 *
 */
function errors_to_string($errors) {
    $error = '';
    foreach ($errors as $key => $field) {
//        $error .= "<h6>" . ucwords($key) . "</h6><ul>";
        $error .= "<ul>";
        foreach ($field as $k => $err) {
            $error .= "<li>" . $err . "</li>";
        }
        $error .= "</ul>";
    }

    return $error;
}

/**
 * Create the slug from string
 * @param type $str String to slugify
 * @return type
 */
function slug_create($str) {
    $search = array('Ș', 'Ț', 'ş', 'ţ', 'Ş', 'Ţ', 'ș', 'ț', 'î', 'â', 'ă', 'Î', 'Â', 'Ă', 'ë', 'Ë');
    $replace = array('s', 't', 's', 't', 's', 't', 's', 't', 'i', 'a', 'a', 'i', 'a', 'a', 'e', 'E');
    $str = str_ireplace($search, $replace, strtolower(trim($str)));
    $str = preg_replace('/[^\w\d\-\ ]/', '', $str);
    $str = str_replace(' ', '-', $str);
    return preg_replace('/\-{2,}/', '-', $str);
}

function date_format_view($mysql_date, $format) {
    return date($format, strtotime($mysql_date));
}

function get_content() {
    $page = Micro\Core\Application::$service->page;
//    dd(stripslashes($page->content),1);
    return htmlspecialchars_decode($page->content);
}

//
//function save_content($) {
//    $page = Micro\Core\Application::$service->page;
////    dd(stripslashes($page->content),1);
//    return htmlspecialchars()($page->content);
//}

/**
 * Returns the db safe html string
 * @param type $html Html to sanatize
 * @param type $char_set
 * @return string escaped string
 */
function esc_html($html, $char_set = 'UTF-8') {
    if (empty($html)) {
        return '';
    }

    $html = (string) $html;
    $html = htmlspecialchars($html, ENT_QUOTES, $char_set);

    return $html;
}

/**
 * Returns the db safe html string
 * @param type $html Html to sanatize
 * @param type $char_set
 * @return string escaped string
 */
function esc_html_decode($string) {
    if (empty($string)) {
        return '';
    }

    $html = htmlspecialchars_decode ($string);

    return $html;
}

/**
 * Register Javascript
 *
 * @param string $id Script Identification
 * @param string $script Script url/code block
 * @param bool $include_in_footer (default true)
 *                              True = Include script in footer,
 *                              False = Include script in head,
 * @param int $priority (default 10) script priority 0-99
 */
function JSRegister($id, $script, $include_in_footer = true, $priority = 10) {

    Micro\Core\Application::$enqueue_scripts[$id] = [
            'priority' => $priority,
            'include_in_footer' => $include_in_footer,
            'script' => $script
        ];
}

/**
 * Un-register Javascript
 */
function JSUnregister($id) {
    unset(Micro\Core\Application::$enqueue_scripts[$id]);
}

/**
 * Load Javascript
 *
 * @param boolean $location_footer Load footer scripts (default: true)
 */
function JSLoad($location_footer = true) {
    $scripts = '';

    $scripts_array = Micro\Core\Application::$enqueue_scripts;
    usort($scripts_array, function($a, $b) {return $a['priority'] - $b['priority'];} );

    foreach ($scripts_array as $id => $arScript)
    {
        //Header Scripts
        if(!$location_footer && !$arScript['include_in_footer'])
            $scripts .= _createscript($arScript);

        //Footer Scripts
        if($location_footer && $arScript['include_in_footer'])
            $scripts .= _createscript($arScript);


    }

    return $scripts;
}

 function _createscript($arScript) {
        if (filter_var($arScript['script'], FILTER_VALIDATE_URL) == TRUE)
            return  "<script type=\"text/javascript\" src=\"{$arScript['script']}\" ></script>";
        else
            return  "{$arScript['script']}";

    }