<?php
$bg_btn_color="";
$textcolor="";
$textcolormobiler="";
$sql1="SELECT btn_color_code, `textcolor`,`textcolormobile` from tbl_hotel_more_detail where hotel_id=$hotel_id";
$result1 = $conn->query($sql1);
if ($result1 && $result1->num_rows > 0) {
    while($row = mysqli_fetch_array($result1)) {
        $bg_btn_color=$row['btn_color_code'];
        $textcolor=$row['textcolor'];
        $textcolormobiler=$row['textcolormobile'];
    }
}
?>

<!DOCTYPE html>
<html>
    <head>


    </head>
    <body>
        <script type="text/javascript">



            var bg_color = "<?php echo $bg_btn_color; ?>";
            var textcolor = "<?php echo $textcolor; ?>";
            var textcolormobiler = "<?php echo $textcolormobiler; ?>";

            var textstyle = document.getElementsByClassName("textstyle");
            var text_primary1 = document.getElementsByClassName("text-primary1");
            var bg_title = document.getElementsByClassName("bg-title");
            var div_title_background_1 = document.getElementsByClassName("div-title-background-1");
            var button_background_color = document.getElementsByClassName("button-background-color");
            var bg_gradient_default_1 = document.getElementsByClassName("bg-gradient-default-1");
            var icon_color = document.getElementsByClassName("icon-color");



            if(textcolor == "")
            { 
                for (i = 0; i < textstyle.length; i++) {
                    textstyle[i].style.color = "#6F6F6E";
                }
            }else {
                function getwidth(x) {
                    if (x.matches) { // If media query matches
                        for (i = 0; i < textstyle.length; i++) {
                            textstyle[i].style.setProperty('color', textcolormobiler, 'important');
                        }
                    } else { 
                        for (i = 0; i < textstyle.length; i++) {
                            textstyle[i].style.color = textcolor;
                        }
                    }
                }
                var x = window.matchMedia("(max-width: 960px)")
                getwidth(x) // Call listener function at run time
                x.addListener(getwidth)

            }


            if(bg_color == "")
            {    
                //Nav Color Change
                for (i = 0; i < text_primary1.length; i++) {
                    text_primary1[i].style.color = "#6F6F6E";
                }
                //Hotel Information
                for (i = 0; i < bg_title.length; i++) {
                    bg_title[i].style.backgroundColor = "#6F6F6E";

                }
                //Mobile View Title Background
                function getwidth(x) {
                    if (x.matches) { // If media query matches
                        for (i = 0; i < div_title_background_1.length; i++) {
                            div_title_background_1[i].style.backgroundColor = "#6F6F6E";
                        }
                    } else { 
                        for (i = 0; i < div_title_background_1.length; i++) {
                            div_title_background_1[i].style.backgroundColor = "transparent";
                        }
                    }
                }
                var x = window.matchMedia("(max-width: 960px)")
                getwidth(x) // Call listener function at run time
                x.addListener(getwidth)
                //Button Color
                for (i = 0; i < button_background_color.length; i++) {
                    button_background_color[i].style.backgroundColor = "#6F6F6E";
                    button_background_color[i].style.borderColor  = "#6F6F6E";
                }
                //Div Background
                for (i = 0; i < bg_gradient_default_1.length; i++) {
                    bg_gradient_default_1[i].style.backgroundColor = "#6F6F6E";
                    bg_gradient_default_1[i].style.borderColor  = "#6F6F6E";
                }
                //Icon Color
                for (i = 0; i < icon_color.length; i++) {
                    icon_color[i].style.color = "#6F6F6E"; //172b4d blue
                }


            }

            //Color Found in data base
            else{   
                //Nav Color Change
                for (i = 0; i < text_primary1.length; i++) {
                    text_primary1[i].style.color = bg_color;
                }
                //Hotel Information
                for (i = 0; i < bg_title.length; i++) {
                    bg_title[i].style.backgroundColor = bg_color;
                }
                //Mobile View Title Background
                function getwidth(x) {
                    if (x.matches) { // If media query matches
                        for (i = 0; i < div_title_background_1.length; i++) {
                            div_title_background_1[i].style.backgroundColor = bg_color;
                        }
                    } else { 
                        for (i = 0; i < div_title_background_1.length; i++) {
                            div_title_background_1[i].style.backgroundColor = "transparent";
                        }
                    }
                }
                var x = window.matchMedia("(max-width: 960px)")
                getwidth(x) // Call listener function at run time
                x.addListener(getwidth)
                //Button Color
                for (i = 0; i < button_background_color.length; i++) {
                    button_background_color[i].style.backgroundColor = bg_color;
                    button_background_color[i].style.borderColor  = bg_color;
                }
                //Div Background
                for (i = 0; i < bg_gradient_default_1.length; i++) {
                    bg_gradient_default_1[i].style.backgroundColor = bg_color;
                    bg_gradient_default_1[i].style.borderColor  = bg_color;
                }
                //Icon Color
                for (i = 0; i < icon_color.length; i++) {
                    icon_color[i].style.color = bg_color;
                }
            }


        </script>

    </body>

</html>
