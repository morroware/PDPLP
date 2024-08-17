<?php
// 1. Introduction to PHP
// This entire file demonstrates basic PHP syntax and structure

// 2. Variables and Data Types
$pageTitle = "My PHP Blog";  // String
$postCount = 0;  // Integer
$isLoggedIn = false;  // Boolean
$pi = 3.14;  // Float
$emptyVar = null;  // Null

// Variable scope demonstration
function demonstrateScope() {
    global $pageTitle;
    $localVar = "I'm local";
    echo "Global \$pageTitle inside function: $pageTitle<br>";
    echo "Local \$localVar inside function: $localVar<br>";
}

// 3. Constants
define("SITE_NAME", "PHP Learning Blog");
const ADMIN_EMAIL = "admin@example.com";

// 4. Arrays
$posts = [];  // Indexed array
$categories = [  // Associative array
    "php" => "PHP",
    "web" => "Web Development",
    "db" => "Databases"
];
$users = [  // Multidimensional array
    ["name" => "John", "email" => "john@example.com"],
    ["name" => "Jane", "email" => "jane@example.com"]
];

// Array functions demonstration
$numbers = [3, 1, 4, 1, 5, 9, 2, 6, 5, 3];
sort($numbers);
$numberCount = count($numbers);

// 5. Control Structures
function categorizePost($category) {
    if ($category === 'php') {
        return "PHP Post";
    } elseif ($category === 'web') {
        return "Web Development Post";
    } else {
        return "Other Post";
    }
}

// Ternary operator
$displayName = isset($_SESSION['user']) ? $_SESSION['user'] : 'Guest';

// 6. Loops
function displayPosts($posts) {
    if (empty($posts)) {
        echo "No posts found.";
    } else {
        foreach ($posts as $index => $post) {
            echo "<h2>" . ($index + 1) . ". {$post['title']}</h2>";
            echo "<p>{$post['content']}</p>";
            
            // Switch statement example
            switch ($post['category']) {
                case 'php':
                    echo "<span class='category php'>PHP</span>";
                    break;
                case 'web':
                    echo "<span class='category web'>Web Development</span>";
                    break;
                default:
                    echo "<span class='category other'>Other</span>";
            }
            
            echo "<hr>";
        }
    }
}

// While loop example
function countDown($start) {
    while ($start > 0) {
        echo $start . "... ";
        $start--;
    }
    echo "Blast off!";
}

// Do-while loop example
function guessNumber($target) {
    $guess = 0;
    $attempts = 0;
    do {
        $guess = rand(1, 10);
        $attempts++;
    } while ($guess != $target);
    return $attempts;
}

// 7. Functions
function addPost($title, $content, $category) {
    global $posts;
    $posts[] = [
        'title' => $title,
        'content' => $content,
        'category' => $category
    ];
}

// Function with default parameter
function greet($name = "Guest") {
    return "Hello, $name!";
}

// Anonymous function example
$wordCount = function($str) {
    return str_word_count($str);
};

// Variadic function example
function sum(...$numbers) {
    return array_sum($numbers);
}

// 8. Superglobals
session_start();
$_SESSION['user'] = 'John Doe';

// 9. Working with Forms
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $category = $_POST['category'] ?? '';
    
    // Form validation
    if (empty($title) || empty($content) || empty($category)) {
        $error = "All fields are required.";
    } else {
        // Sanitize input
        $title = htmlspecialchars($title);
        $content = htmlspecialchars($content);
        $category = htmlspecialchars($category);
        
        addPost($title, $content, $category);
        $success = "Post added successfully.";
    }
}

// 10. Include and Require
// For demonstration purposes, we'll just define functions here
// In a real project, these would be in separate files
function getHeader() {
    return "<header><h1>" . SITE_NAME . "</h1></header>";
}

function getFooter() {
    return "<footer>&copy; " . date('Y') . " " . SITE_NAME . "</footer>";
}

// 11. Error Handling
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    echo "<b>Error:</b> [$errno] $errstr<br>";
    echo "Error on line $errline in $errfile";
}
set_error_handler("customErrorHandler");

// Main content
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; padding: 20px; }
        .category { padding: 5px 10px; border-radius: 5px; color: white; }
        .category.php { background-color: #8892BF; }
        .category.web { background-color: #61DAFB; }
        .category.other { background-color: #999; }
    </style>
</head>
<body>
    <?php echo getHeader(); ?>
    
    <h2>PHP Basics Demonstration</h2>
    
    <h3>Variables and Scope</h3>
    <?php
    demonstrateScope();
    echo "Global \$pageTitle outside function: $pageTitle<br>";
    // This will cause an undefined variable error, demonstrating local scope
    // Uncomment to see the error: echo $localVar;
    ?>

    <h3>Constants</h3>
    <p>Site Name: <?php echo SITE_NAME; ?></p>
    <p>Admin Email: <?php echo ADMIN_EMAIL; ?></p>

    <h3>Arrays</h3>
    <p>Categories:</p>
    <ul>
    <?php foreach ($categories as $key => $value): ?>
        <li><?php echo "$key: $value"; ?></li>
    <?php endforeach; ?>
    </ul>
    <p>Sorted numbers: <?php echo implode(', ', $numbers); ?></p>
    <p>Count of numbers: <?php echo $numberCount; ?></p>

    <h3>Control Structures and Loops</h3>
    <p>Categorize 'php': <?php echo categorizePost('php'); ?></p>
    <p>Display Name: <?php echo $displayName; ?></p>
    <p>Countdown: <?php countDown(5); ?></p>
    <p>Guesses to find number: <?php echo guessNumber(7); ?></p>

    <h3>Functions</h3>
    <p><?php echo greet(); ?></p>
    <p><?php echo greet("Alice"); ?></p>
    <p>Sum of 1, 2, 3, 4, 5: <?php echo sum(1, 2, 3, 4, 5); ?></p>

    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    if (isset($success)) {
        echo "<p style='color: green;'>$success</p>";
    }
    ?>

    <h2>Add a New Post</h2>
    <form method="post">
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="content">Content:</label>
            <textarea id="content" name="content" required></textarea>
        </div>
        <div>
            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <?php foreach ($categories as $key => $value): ?>
                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit">Add Post</button>
    </form>

    <h2>Posts</h2>
    <?php
    displayPosts($posts);
    
    // Demonstrating the anonymous function
    echo "<p>Total words in all posts: " . array_sum(array_map($wordCount, array_column($posts, 'content'))) . "</p>";
    
    // Demonstrating error handling
    try {
        $result = 10 / 0;
    } catch (DivisionByZeroError $e) {
        echo "<p>Error caught: " . $e->getMessage() . "</p>";
    }

    // Demonstrating $_SERVER superglobal
    echo "<p>You are visiting from: " . $_SERVER['REMOTE_ADDR'] . "</p>";
    ?>

    <?php echo getFooter(); ?>
</body>
</html>
