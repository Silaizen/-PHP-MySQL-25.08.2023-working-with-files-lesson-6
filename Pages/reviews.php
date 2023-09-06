<h1>Reviews</h1>

<?php Message::get() ?>

<form action="index.php" method="post">

    <div class="form-group">
        <label>Name:</label>
        <input type="text" class="form-control" name="name">
    </div>

   <div class="form-group">
    <label for="">Review:</label>
    <textarea name="review" class="form-control" id="" cols="30" rows="10"></textarea>
   </div>

   <button class="btn btn-primary" name="action" value="sendReview">Send</button>
</form>

<?php


if(file_exists('reviews.txt')){
 //$reviews = file('reviews.txt');
 //dump($reviews);
 $reviews = json_decode(file_get_contents('reviews.txt')); //полностью считывает весь файл.
$reviews = array_reverse($reviews);

$limit = 3;
$pages = ceil(count($reviews) / $limit);
$p = $_GET['p'] ?? 1;

$p = $p > $pages ? $pages : ($p < 1 ? 1 : $p);

$reviews = array_chunk($reviews, $limit);
 foreach($reviews[$p - 1] as $review):
  ?> 
<div class="border p-3 mb-3">
    <div class="d-flex justify-content-between">
        <strong><?= $review->name ?></strong>
        <?= date('d.m.Y H:i', $review->time) ?>
    </div>
    <?= $review->review ?>
</div>

<?php
endforeach;
?>


<nav class="mt-3">
    <ul class="pagination justify-content-center">
        <?php for($i = 1; $i <= $pages; $i++) : ?>
            <li class="page-item <? $p == $i ? 'active' : '' ?>">
        <a href="index.php?p=<?= $li ?>&page=reviews" class="page-link"><?= $i ?></a>
        </li>
        <?php endfor ?>
    </ul>
</nav>



<?php
}else{
    echo 'No reviews';
}
?>