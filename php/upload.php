<?php

$target_path = dirname(__FILE__) . "/upload/";

$tmp_name = $_FILES['upload']['tmp_name'];
$filename = $_FILES['upload']['name'];
$target_file = $target_path.$filename;
$num = $_POST['num'];
$num_chunks = $_POST['num_chunks'];

move_uploaded_file($tmp_name, $target_file.$num);
sleep(1);

// count ammount of uploaded chunks
$chunksUploaded = 0;
for ( $i = 1; $i <= $num; $i++ ) {
    if ( file_exists( $target_file.$i ) ) {
         ++$chunksUploaded;
    }
}

// and THAT's what you were asking for
// when this triggers - that means your chunks are uploaded
if ($chunksUploaded === (int)$num_chunks) {
    /* here you can reassemble chunks together */
    for ($i = 1; $i <= $num_chunks; $i++) {

      $file = fopen($target_file.$i, 'rb');
      $buff = fread($file, 2097152);
      fclose($file);

      $final = fopen($target_file, 'ab');
      $write = fwrite($final, $buff);
      fclose($final);

      unlink($target_file.$i);
    }
}

// echo json_encode($msg);
?>
