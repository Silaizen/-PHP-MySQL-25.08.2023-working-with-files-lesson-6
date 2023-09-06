

<h2>Manage Sliders</h2>

<!-- Form 1: Create Slider -->
<form method="post" action="index.php">
    <label for="sliderName">Slider Name:</label>
    <input type="text" id="sliderName" name="sliderName" required>
    <button type="submit" name="createSlider">Create Slider</button>
</form>

<!-- Form 2: Upload Images to Slider -->
<form method="post" action="index.php" enctype="multipart/form-data">
    <label for="sliderSelect">Select Slider:</label>
    <select id="sliderSelect" name="sliderSelect">
       
        <?php
        $sliderOptions = scandir('./uploads');
        foreach ($sliderOptions as $option) {
            if ($option !== '.' && $option !== '..' && is_dir("./uploads/$option")) {
                echo "<option value='$option'>$option</option>";
            }
        }
        ?>
    </select>
    <input type="file" name="sliderImages[]" multiple accept="image/*">
    <button type="submit" name="uploadImages">Upload Images</button>
</form>

<!-- Form 3: Delete Slider and Contents -->
<form method="post" action="index.php">
    <label for="deleteSlider">Select Slider to Delete:</label>
    <select id="deleteSlider" name="deleteSlider">
       
        <?php
        foreach ($sliderOptions as $option) {
            if ($option !== '.' && $option !== '..' && is_dir("./uploads/$option")) {
                echo "<option value='$option'>$option</option>";
            }
        }
        ?>
    </select>
    <button type="submit" name="deleteSliderBtn">Delete Slider and Contents</button>
</form>