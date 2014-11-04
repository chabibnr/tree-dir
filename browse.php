<?php

if (!function_exists('directory_map')) {
    function directory_map($source_dir, $directory_depth = 0, $hidden = FALSE) {
        if ($fp = @opendir($source_dir)) {
            $filedata = '<ul class="root-folder">';
            $new_depth = $directory_depth - 1;
            $source_dir = rtrim($source_dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

            while (FALSE !== ($file = readdir($fp))) {
                // Remove '.', '..', and hidden files [optional]
                if (!trim($file, '.') OR ( $hidden == FALSE && $file[0] == '.')) {
                    continue;
                }

                if (($directory_depth < 1 OR $new_depth > 0) && @is_dir($source_dir . $file)) {
                    $filedata .= '<li><a href="#">'.$file.'</a>';
                    $filedata .= directory_map($source_dir . $file . DIRECTORY_SEPARATOR, $new_depth, $hidden);
                    $file .= '</li>';
                } else {
                    $filedata .= '<li>'.$file.'</li>';
                }
            }

            closedir($fp);
            $filedata .= '</ul>';
            return $filedata;
        }

        return FALSE;
    }

}

?>
<html>
    <head>
        <title>Fetching Folder v 0.2</title>
        <script src="jquery.js" type="text/javascript"></script>
        <script>
        $(function(){
            $(".root-folder").hide(); //hide All
            $(".root-folder:eq(0)").show(); //hide All
            $('li > a').click(function(){
                $(this).parent().find('ul.root-folder:eq(0)').toggle()
            })
        })
        </script>
    </head>
    <body>
        <?php echo directory_map('./');?>
    </body>
</html>