<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <script src="assets/scripts/main.js" defer></script>
    <title><?php __($post['title']) ?></title>
</head>
<body>
<header>
    <div>
        <h1><a href="/">XiReader</a></h1>
        <span>Open, Know, Repeat </span>
    </div>
    <nav>
        <?php if(isLoggedIn()): ?>
            <a href="logout.php">logout</a>
            <a href="createpost.php">Create Post</a>
        <?php else: ?>
            <a href="login.php">login</a>
            <a href="join.php">Join</a>
        <?php endif; ?>
    </nav>
</header>