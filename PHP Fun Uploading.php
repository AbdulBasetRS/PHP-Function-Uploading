<?php 
    function UploadFile($FILE,$PATH,$FOLDERNAME,$FILENAME = null,$SIZE = null,$EXTENSIONS = array()){
        $Error = array();
        if (empty($FILE) OR $FILE === '') {
            $Error[] = 'PHP function UploadFile() Cant Get FILE.';
        }
        if (empty($PATH) OR $PATH === '') {
            $Error[] = 'PHP function UploadFile() Cant Get PATH.';
        }
        if (empty($FOLDERNAME) OR $FOLDERNAME === '') {
            $Error[] = 'PHP function UploadFile() Cant Get FOLDERNAME.';
        }
        if ($FILENAME === '') {
            $Error[] = 'PHP function UploadFile() Must Be Not Empty FILENAME.';
        }
        if (empty($Error)) {
            $Uploaded_File = $FILE;
            $File_Name  = $Uploaded_File['name'];
            $File_Type  = $Uploaded_File['type'];
            $File_Temp  = $Uploaded_File['tmp_name'];
            $File_Error = $Uploaded_File['error'];
            $File_Size  = $Uploaded_File['size'];
            $Extension = explode('.',$File_Name);
            $File_Extensions = strtolower(end($Extension)) ;
            if ($File_Error == 4) {
                $Error[] = 'PHP function UploadFile() Must Be Not Empty.';
            }
            if (!empty($EXTENSIONS) AND !in_array($File_Extensions,$EXTENSIONS)) {
                $Error[] = 'PHP function UploadFile() Wrong File Extension.';
            }else {
                $file_extensions = '.'.$File_Extensions;
            }
            if (!empty($SIZE) AND $SIZE !== null) {
                if (!is_numeric($SIZE)) {
                    $Error[] = 'PHP function UploadFile() Wrong File SIZE Must Be Number.';
                }else if ((int)$File_Size > $SIZE) {
                    $Error[] = 'PHP function UploadFile() File SIZE Can\'t Be More Than [ ' . (number_format($SIZE /1024 /1024)) . ' MB ].';
                }
            }
            if ($FILENAME !== null OR !empty($FILENAME)) {
                $file_name = $FILENAME;
            }else {
                $file_extensions = '';
                $file_name = $File_Name ;
            }
        }
        if (empty($Error)) {
            if (!is_dir( $PATH.$FOLDERNAME)) {
                mkdir($PATH.$FOLDERNAME, 0700); // Make Folder 
                move_uploaded_file($File_Temp, $PATH.$FOLDERNAME . '/' . $file_name . $file_extensions);
            }else {
                move_uploaded_file($File_Temp, $PATH.$FOLDERNAME . '/' . $file_name . $file_extensions);
            }
            return true;
        }else {
            return false; // Here Write Your Foreach Loob To Get The Message In Error Array
        }
    }
    UploadFile($_FILES['FILE'],'PATH/','FOLDERNAME','FILENAME','1024000',['txt']); // Return [ TRUE or FALSE ]
?>