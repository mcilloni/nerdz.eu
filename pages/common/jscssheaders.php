<?php
/*css and jss required for blacklist -> declared here so we can reuse the code in standard and ssl headers version */
$logged = $core->isLogged();
if($logged && ($blist = $core->getBlacklist()))
{
    $jsonObj = [];
    $blistcss = '<style type="text/css">';
    foreach($blist as $b_id) {
        $blistcss.= ".bluser{$b_id},";
        $jsonObj[] = $core->getUsername($b_id);
    }
    $blistcss = substr($blistcss,0,-1); //rimuovo ultima ,
    $blistcss.= '{border:1px solid #FF0000}</style>';

    $blistjs = '<script type="application/javascript">window.idiots = '.json_encode((array)$jsonObj).';</script>';
}

require_once $_SERVER['DOCUMENT_ROOT'].'/class/browser.class.php';
$uagdata = (new Browser(isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ''))->getArray();
// da includere in ogni pagine, nell'header, dopo aver creato $core  e creato la variabile $headers
$tno = $core->getTemplate();
if($core->isMobile()) { ?>
    <meta name="viewport" id="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="mobile-web-app-capable" content="yes">
<?php }    
if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') //se ssl è attivo uso l'url senza static, dato che non ho il certificato per quel sottodominio
{
?>
<?php
    if($uagdata['platform'] == 'Windows' && (float)$uagdata['version'] >= 10)
    {
?>
        <meta name="application-name" content="NERDZ" /> 
        <meta name="msapplication-TileColor" content="#1D1B1B" /> 
        <meta name="msapplication-TileImage" content="/static/images/winicon.png" />
<?php
    }
  if($core->isMobile()) { ?>
        <link rel="shortcut icon" sizes="196x196" href="/static/images/droidico.png"/>
<?php } else { ?>
        <link rel="icon" type="image/x-icon" href="/static/images/favicon.ico" />
<?php
      }
    foreach($headers['css'] as $var)
        if(filter_var($var,FILTER_VALIDATE_URL,FILTER_FLAG_PATH_REQUIRED))
            echo '<link rel="stylesheet" type="text/css" href="',$var,'" />';
        else
            echo '<link rel="stylesheet" type="text/css" href="/tpl/',$tno,'/',$var,'" />';
    echo isset($blistcss) ? $blistcss : '';
?>
    <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<?php
    echo isset($blistjs) ? $blistjs : '';
    foreach($headers['js'] as $var)
    {
        if (is_array ($var)) continue;
        if(filter_var($var,FILTER_VALIDATE_URL,FILTER_FLAG_PATH_REQUIRED))
            echo '<script type="application/javascript" src="',$var,'"></script>';
        else
            echo '<script type="application/javascript" src="/tpl/',$tno,'/',$var,'"></script>';
    }
?>
    <script type="application/javascript" src="/static/js/api.php"></script>
    <script type="text/x-mathjax-config">
    MathJax.Hub.Config({
        extensions: ["tex2jax.js"],
        jax: ["input/TeX", "output/HTML-CSS"],
        tex2jax: {
          inlineMath: [ ['[m]','[/m]'] ],
          displayMath: [ ['[math]','[/math]'] ],
          processEscapes: true
        },
        "HTML-CSS": { availableFonts: ["TeX"], linebreaks: { automatic: true, width: "container" } }
      });
    </script>
    <script type="application/javascript" src="https://c328740.ssl.cf1.rackcdn.com/mathjax/latest/MathJax.js"></script>
<?php
}
else //ssl non attivo
{
?>
<?php
    if($uagdata['platform'] == 'Windows' && (float)$uagdata['version'] >= 10)
    {
?>
        <meta name="application-name" content="NERDZ" /> 
        <meta name="msapplication-TileColor" content="#1D1B1B" /> 
        <meta name="msapplication-TileImage" content="/static/images/winicon.png" />
<?php
    }

if($core->isMobile()) { ?>
    <link rel="shortcut icon" sizes="196x196" href="<?php echo STATIC_DOMAIN;?>/static/images/droidico.png">
<?php } else { ?>
    <link rel="icon" type="image/x-icon" href="<?php echo STATIC_DOMAIN;?>/static/images/favicon.ico" />
<?php }
    foreach($headers['css'] as $var)
        if(filter_var($var,FILTER_VALIDATE_URL,FILTER_FLAG_PATH_REQUIRED))
            echo '<link rel="stylesheet" type="text/css" href="',$var,'" />';
        else
            echo '<link rel="stylesheet" type="text/css" href="',STATIC_DOMAIN,'/tpl/',$tno,'/',$var,'" />';
    echo isset($blistcss) ? $blistcss : '';
?>
    <script type="application/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<?php
    echo isset($blistjs) ? $blistjs : '';
    foreach($headers['js'] as $var)
    {
        if (is_array ($var)) continue;
        if(filter_var($var,FILTER_VALIDATE_URL,FILTER_FLAG_PATH_REQUIRED))
            echo '<script type="application/javascript" src="',$var,'"></script>';
        else
            echo '<script type="application/javascript" src="',STATIC_DOMAIN,'/tpl/',$tno,'/',$var,'"></script>';
    }
?>
    <script type="application/javascript" src="<?php echo STATIC_DOMAIN;?>/static/js/api.php"></script>
    <script type="text/x-mathjax-config">
    MathJax.Hub.Config({
        extensions: ["tex2jax.js"],
        jax: ["input/TeX", "output/HTML-CSS"],
        tex2jax: {
          inlineMath: [ ['[m]','[/m]'] ],
          displayMath: [ ['[math]','[/math]'] ],
          processEscapes: true
        },
        "HTML-CSS": { availableFonts: ["TeX"], linebreaks: { automatic: true, width: "container" } }
      });
    </script>
    <script type="application/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js"></script>
<?php
}
?>
    <script type="application/javascript">
        var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-16114171-2']);
            _gaq.push(['_setDomainName', 'nerdz.eu']);
            _gaq.push(['_setAllowHash', 'false']);
            _gaq.push(['_trackPageview']);
            (function() {
                 var ga = document.createElement('script'); ga.type = 'application/javascript'; ga.async = true;
                 ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
             })();
<?php if (isset ($headers['js']['staticData']['outputVersion']) && $headers['js']['staticData']['outputVersion'] === true)
{
    unset($headers['js']['staticData']['outputVersion']);
?>
        var Nversion = '<?=$core->getVersion()?>';
<?php } ?>
        var Nstatic = <?=json_encode(isset($headers['js']['staticData'])?$headers['js']['staticData']:array(),JSON_HEX_TAG)?>;
    </script>
<?php
    if($core->isLogged() && (($o = $core->query(array('SELECT "userscript" FROM "profiles" WHERE "counter" = ?',array($_SESSION['nerdz_id'])),db::FETCH_OBJ))) && !empty($o->userscript))
        echo '<script type="application/javascript" src="',html_entity_decode($o->userscript,ENT_QUOTES,'UTF-8'),'"></script>';
?>
