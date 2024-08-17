<?php
// 1. Introduction to PHP
// PHP is a server-side scripting language designed for web development.
// PHP code is executed on the server, generating HTML which is then sent to the client.
// PHP files have a .php extension and can contain HTML, CSS, JavaScript, and PHP code.

// 2. Variables and Data Types
// In PHP, variables start with a $ sign and are case-sensitive.
// PHP is a loosely typed language, meaning you don't need to declare variable types explicitly.

$pageTitle = "My PHP Blog";  // String: Sequence of characters
$postCount = 0;  // Integer: Whole number
$isLoggedIn = false;  // Boolean: true or false
$pi = 3.14;  // Float: Number with decimal point
$emptyVar = null;  // Null: Variable with no value

// 3. Constants
// Constants are identifiers for simple values that cannot be changed during script execution.
// There are two ways to define constants in PHP:

define("SITE_NAME", "PHP Learning Blog");  // Using define() function
const ADMIN_EMAIL = "admin@example.com";   // Using const keyword (PHP 5.3+)

// 4. Arrays
// Arrays in PHP can hold multiple values under a single variable name.
// PHP supports three types of arrays: indexed, associative, and multidimensional.

$posts = [];  // Indexed array: Empty array to store posts
$categories = [  // Associative array: Key-value pairs
    "php" => "PHP",
    "web" => "Web Development",
    "db" => "Databases"
];
$users = [  // Multidimensional array: Array containing other arrays
    ["name" => "John", "email" => "john@example.com"],
    ["name" => "Jane", "email" => "jane@example.com"]
];

// 5. Control Structures & 6. Loops
// Control structures allow you to control the flow of your program's execution.
// Loops are used to execute a block of code repeatedly.

function displayPosts($posts) {
    // The if-else statement is used for conditional execution
    if (empty($posts)) {
        echo "No posts found.";
    } else {
        // The foreach loop is used to iterate over arrays
        foreach ($posts as $post) {
            echo "<h2>{$post['title']}</h2>";
            echo "<p>{$post['content']}</p>";
            
            // The switch statement is used to perform different actions based on different conditions
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

// 7. Functions
// Functions are blocks of reusable code that perform specific tasks.
// They help organize code and promote reusability.

// Regular function with parameters
function addPost($title, $content, $category) {
    global $posts;  // 'global' keyword is used to access global variables inside functions
    $posts[] = [
        'title' => $title,
        'content' => $content,
        'category' => $category
    ];
}

// Anonymous function (also called closures)
// These are functions without a name, often used as callback functions
$wordCount = function($str) {
    return str_word_count($str);
};

// Variadic function (PHP 5.6+)
// These functions can accept a variable number of arguments
function sum(...$numbers) {
    return array_sum($numbers);
}

// 8. Superglobals
// Superglobals are built-in variables that are always available in all scopes
session_start();  // Start a new or resume existing session
$_SESSION['user'] = 'John Doe';  // $_SESSION is used to store data for a specific session

// 9. Working with Forms
// PHP can collect form data after submitting an HTML form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Check if the form was submitted
    // Retrieve form data using the $_POST superglobal
    // The ?? operator is the null coalescing operator (PHP 7+)
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $category = $_POST['category'] ?? '';
    
    // Form validation
    if (empty($title) || empty($content) || empty($category)) {
        $error = "All fields are required.";
    } else {
        addPost($title, $content, $category);
        $success = "Post added successfully.";
    }
}

// 10. Include and Require
// These statements are used to include and evaluate other PHP files
// For demonstration purposes, we'll just define a function here
// In a real project, this would be in a separate file
function getFooter() {
    return "<footer>&copy; " . date('Y') . " " . SITE_NAME . "</footer>";
}

// 11. Error Handling
// Custom error handler to handle errors gracefully
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    echo "<b>Error:</b> [$errno] $errstr<br>";
    echo "Error on line $errline in $errfile";
}
set_error_handler("customErrorHandler");  // Set the custom error handler

// Main content
// PHP can be embedded in HTML. When PHP encounters HTML, it simply passes it through to the browser.
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
    <h1><?php echo SITE_NAME; ?></h1>
    
    <?php
    // Display error or success messages
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
                <?php 
                // Use foreach to iterate over the categories array
                foreach ($categories as $key => $value): 
                ?>
                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit">Add Post</button>
    </form>

    <h2>Posts</h2>
    <?php
    // Display all posts
    displayPosts($posts);
    
    // Demonstrating the anonymous function
    // array_map applies the $wordCount function to each element of the array
    // array_column extracts the 'content' column from the $posts array
    echo "<p>Total words in all posts: " . array_sum(array_map($wordCount, array_column($posts, 'content'))) . "</p>";
    
    // Demonstrating the variadic function
    echo "<p>Sum of 1, 2, 3, 4, 5: " . sum(1, 2, 3, 4, 5) . "</p>";
    
    // Demonstrating error handling with try-catch
    try {
        $result = 10 / 0;  // This will throw a DivisionByZeroError
    } catch (DivisionByZeroError $e) {
        echo "<p>Error caught: " . $e->getMessage() . "</p>";
    }
    ?>

    <?php echo getFooter(); ?>
</body>
</html>
