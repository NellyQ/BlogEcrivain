<!doctype html>
<html>

    <head>
    <meta charset="utf-8" />
    <link href="blogecrivain.css" rel="stylesheet" />
    <title>Un billet pour l'Alaska</title>
</head>

<body>
    
    <header>
        <h1>Un billet pour l'Alaska</h1>
    </header>
    
    <?php foreach ($billets as $billet): ?>
    <article>
        <h2><?php echo $billet['billet_title'] ?></h2>
        <p><?php echo $billet['billet_content'] ?></p>
        <p class = "date"><?php echo $billet['billet_date'] ?></p>
    </article>
    <?php endforeach ?>
    
    <footer class="footer">
        Un billet pour l'Alaska - blog de Jean Forteroche
    </footer>
    
</body>
</html>