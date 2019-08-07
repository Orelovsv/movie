<?php
    require_once 'header.php';

$genres = [];
$name = '';
$genre = '';
$genreId = isset($_POST['genreId']) ? (int) $_POST['genre'] : 0;
$summary = '';
$year = '';
$country = '';
$duration = '';
$image = '';
$quality = '';
$rating = '';
$errors = [];

$sql = "SELECT
            `id`,
            `name`
        FROM `".TABLE_GENRES."`

";

if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $genres[] = $row;
    }
}

$count = count($genres);

if (isset($_POST['submit'])) {
    
    if (!mb_strlen($_POST['name'])) {
        $errors[] = 'Please enter movie name';
    } else {
        $name = trim($_POST['name']);
    }

    if (!mb_strlen($_POST['summary'])) {
        $errors[] = 'Please enter summary';
    } else {
        $summary = trim($_POST['summary']);
    }

    if (!mb_strlen($_POST['year'])) {
        $errors[] = 'Please enter year';
    } else {
        $year = trim($_POST['year']);
    }

    if (!mb_strlen($_POST['country'])) {
        $errors[] = 'Please enter country';
    } else {
        $country = trim($_POST['country']);
    }
    if (isset($_POST['image'])) {
        $dir = 'images/';
        $image = $dir . basename($_FILES['images']['image']);

        $errors = [];
        if ($_FILES['images']['size'] > 25000) {
            $errors[] = "File is too large";
        }
        $fileType = mime_content_type($_FILES['images']['tmp_name']);
        
        if ($fileType !== 'image/jpeg'
            && $fileType !== 'image/png'
            && $fileType !== 'image/svg+xml')
        {
            $errors[] = "File is not valid";
        }
        if (!count($errors)) {
            if (move_uploaded_file($_FILES['images']['tmp_name'], $name)) {
                echo "File uploaded";
            } else {
                echo "File is not uploaded";
            }
            showArray($errors);
        }
    }

    if (!mb_strlen($_POST['duration'])) {
        $errors[] = 'Please enter duration';
    } else {
        $duration = trim($_POST['duration']);
    }

    if (!mb_strlen($_POST['quality'])) {
        $errors[] = 'Please enter quality';
    } else {
        $quality = trim($_POST['quality']);
    }

    if (!mb_strlen($_POST['rating'])) {
        $errors[] = 'Please enter rating';
    } else {
        $rating = trim($_POST['rating']);
    }

    if (!count($errors)) {
        $sql = "INSERT INTO `".TABLE_MOVIES."`
        (
            `genre_id`,
            `name`,
            `summary`,
            `year`,
            `country`,
            `duration`,
            `image`,
            `quality`,
            `rating`,
            `added`,
            `modified`
        ) VALUES (
            '".mysqli_real_escape_string($conn, $genreId)."',
            '".mysqli_real_escape_string($conn, $name)."',
            '".mysqli_real_escape_string($conn, $summary)."',
            '".mysqli_real_escape_string($conn, $year)."',
            '".mysqli_real_escape_string($conn, $country)."',
            '".mysqli_real_escape_string($conn, $duration)."',
            '".mysqli_real_escape_string($conn, $image)."',
            '".mysqli_real_escape_string($conn, $quality)."',
            '".mysqli_real_escape_string($conn, $rating)."',
            NOW(),
            NOW()
        )
        ";
//showArray($sql);

        if (mysqli_query($conn, $sql)) {
            echo "success";
        } else {
            echo "error";
        }
    }
}
?>

<div class="container-fluid">
    <form action="" method="post" enctype="multipart/form-data">
        <p>Genre</p>
        <select name='genre' >
                <option value="genre" select="select">Choose genre</option>
                <option value="<?=$genres[$i]['id']?>">Action</option>
                <option value="<?=$genres[$i]['id']?>">Comedy</option>
                <option value="<?=$genres[$i]['id']?>">Thriller</option>
                <option value="<?=$genres[$i]['id']?>">Horror</option>
                <option value="<?=$genres[$i]['id']?>">Sci-Fi</option>
        </select>   
        <p></p>
        <p>Name:</p>
        <input type="text" name="name" value="<?=$name?>" placeholder="movie" />
        <P>Summary:</p>
        <input type="text" name="summary" value="<?=$summary?>" placeholder="Summary" />
        <P>Year:</p>
        <input type="text" name="year" value="<?=$year?>" placeholder="Year" />
        <P>Country:</p>
        <input type="text" name="country" value="<?=$country?>" placeholder="Country" />
        <P>Duration:</p>
        <input type="text" name="duration" value="<?=$duration?>" placeholder="Duration" />
        <P>Image:</p>
        <input type="file" name="images" value="<?=$image?>" placeholder="Image" />
        <P>Quality:</p>
        <input type="text" name="quality" value="<?=$quality?>" placeholder="Quality" />
        <P>Rating:</p>
        <input type="text" name="rating" value="<?=$rating?>" placeholder="rating" />

        <button type="submit" name="submit" class="btn btn-primary btn-block">Add movie</button>


            <?php if (isset($errors) && count($errors)) : ?>
                <?php for ($i=0; $i < count($errors); $i++) : ?> 
                    <li><?=$errors[$i];?></li>
                    <?php endfor?>
                <?php endif?>
    </form>  

<?php 
    require_once 'footer.php';
    ?>