<?php
require_once("utilities.php");

if (isset($_FILES['pkg']))
    $contents = Utilities::parse($_FILES['pkg']['tmp_name']);
else
    die("upload a file boi");

if ($contents['magic'] == "UNK")
    die("o shit waddup u got a bad pkg boi");
?>
<head>
    <title>PakMan | Parse</title>
</head>
<body>
    <h3><?php echo $contents['data']->name; ?></h3>
    <b>Magic</b>: <?php echo $contents['magic'] ?><br>
    <b>Content ID</b>: <?php echo $contents['contentID'] ?><br>
    <b>Size</b>: <?php echo $contents['size'] ?> (<?php echo hexdec($contents['size']) ?> bytes)<br>
    <b>Data Size</b>: <?php echo $contents['dataSize'] ?> (<?php echo hexdec($contents['dataSize']) ?> bytes)<br>
    <b>Data Offset</b>: <?php echo $contents['dataOffset'] ?><br>
    <b>Files</b>:
    <?php if (count($contents['contents']) > 0): ?>
    <ul>
        <?php foreach ($contents['contents'] as $file): ?>
            <li><?php echo $file ?></li>
        <?php endforeach ?>
    </ul>
    <?php else: ?>
        No files boi
    <?php endif ?>
    <br>
    <img src="<?php echo $contents['data']->images[0]->url?>" />
</body>