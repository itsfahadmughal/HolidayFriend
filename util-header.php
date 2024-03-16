<?php
$main_url=basename($_SERVER['REQUEST_URI']);
if($main_url=="HolidayFriend"){
    $main_url="index";
}

if(!session_id()){
    session_start();
}

$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$acceptLang = ['de', 'it', 'en']; 
$lang = in_array($lang, $acceptLang) ? $lang : '';

?>

<script>

    var lang='<?php echo $lang ?>';
    var session_lang=sessionStorage.getItem("langchange");
    if(session_lang == "1"){
        //sessionStorage.setItem("langchange", "0");
    }else{
        if(lang=="de" || lang == "it"){
            location.href = lang;
        }
    }

</script>

<!-- Topnav -->
<nav class="navbar navbar-top navbar-expand navbar-dark border-bottom sticky-mobile">
    <div class="container-fluid" style="position:relative !important;float:right;width:auto !important;margin-right:inherit !important;">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Search form -->
            <!-- Navbar links -->
            <ul class="navbar-nav align-items-center  ml-md-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-globe text-primary1" aria-hidden="true"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0 overflow-hidden">
                        <!-- Dropdown header -->
                        <div class="px-3 py-3">
                            <h6 class="text-sm text-muted m-0" style="font-weight:bold;margin:0px;font-size: 1.0625rem;font-family: inherit;">Choose Language</h6>
                        </div>
                        <!-- List group -->
                        <div class="list-group list-group-flush">
                            <a href="javascript:void(0)" class="list-group-item list-group-item-action active_lang lang_hover" onclick="lang_change('<?php echo $main_url; ?>')" >
                                <div class="row align-items-center">
                                    <div class="col pl-4 pr-3">
                                        <h3 class="mb-0" style="font-weight:bold;margin:0px;font-size: 1.0625rem;font-family: inherit;">EN</h3>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="list-group-item list-group-item-action lang_hover" onclick="lang_change('it/<?php echo $main_url; ?>')" >
                                <div class="row align-items-center">
                                    <div class="col pl-4 pr-3">
                                        <h3 class="mb-0" style="font-weight:bold;margin:0px;font-size: 1.0625rem;font-family: inherit;">IT</h3>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="list-group-item list-group-item-action lang_hover" onclick="lang_change('de/<?php echo $main_url; ?>')" >
                                <div class="row align-items-center">
                                    <div class="col pl-4 pr-3">
                                        <h3 class="mb-0" style="font-weight:bold;margin:0px;font-size: 1.0625rem;font-family: inherit;">DE</h3>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                </li>
                <li class="nav-item d-xl-none">
                    <!-- Sidenav toggler -->
                    <div class="pl-3 pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-title"></i>
                            <i class="sidenav-toggler-line bg-title"></i>
                            <i class="sidenav-toggler-line bg-title"></i>
                        </div>
                    </div>
                </li>
            </ul>

        </div>
    </div>
</nav>
<script>
    function lang_change(url){
        sessionStorage.setItem("langchange", "1");
        window.location.href = url;
    }
</script>
<!-- Header -->