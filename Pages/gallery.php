

<h2>Gallery</h2>

<div class="swiper-container">
    <div class="swiper-wrapper">
        <?php
        $sliderOptions = scandir('./uploads');
        foreach ($sliderOptions as $option) {
            if ($option !== '.' && $option !== '..' && is_dir("./uploads/$option")) {
                $images = scandir("./uploads/$option");
                foreach ($images as $image) {
                    if ($image !== '.' && $image !== '..') {
                        echo "<div class='swiper-slide'>";
                        echo "<a class='gallery-link' href='./uploads/$option/$image'>";
                        echo "<img src='./uploads/$option/$image' alt='$image'>";
                        echo "</a>";
                        echo "</div>";
                    }
                }
            }
        }
        ?>
    </div>
    <div class="swiper-pagination"></div>
</div>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
    
    const galleryLinks = document.querySelectorAll('.gallery-link');
    galleryLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            $.fancybox.open({ src: this.href, type: 'image' });
        });
    });
</script>