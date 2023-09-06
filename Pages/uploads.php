<h1>Uploads</h1>
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consequuntur ducimus, laboriosam quam voluptatum dolorum, hic quo amet vel qui nostrum rem possimus ab delectus ipsam inventore eum iusto aspernatur numquam!
<?php Message::get() ?>

<form action="index.php" method="POST" enctype="multipart/form-data">
<input type="file" name="file"> <br>
<button class="button.btn.btn-primary" name="action" value="sendFile">Send</button>
</form>


<?php

//1

$files = scandir('./uploads');
$files = array_diff($files, ['.', '..']);

dump($files);

foreach($files as $file){
    if(!is_dir("uploads/$file"))
    echo "<img src='uploads/$file'>";
}


// 2 

// $files = glob('uploads/*.{jpg,jpeg,png,gif,webp,avif}', GLOB_BRACE);
// // dump($files);
// foreach($files as $file){
//   echo "<img src='$file'>";
// }
