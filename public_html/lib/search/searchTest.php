<?php
use \search\Searcher;
use search\NumberConverter as nc;

//INIT stuff
define("_VALID_PHP", true);

require_once (__DIR__ . "/../../admin/init.php");
if (!$user->is_Admin()) redirect_to("login.php");

Registry::set('Database',new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE));
$db = Registry::get("Database");
$db->connect();
$searcher = new Searcher($db);


//Search stuff
$q = false;
if (isset($_GET['q'])){
    $q = sanitize($_GET['q']);
}

$queries = array();
$primaryResults = array();
$secondaryResults = array();

if ($q){
    $results = $searcher->search($q);
    $primary = $results['primary'];
    $secondary = $results['secondary'];
    $rankings = $searcher->getRankings();
    $queries = $searcher->getQueries();

    $primaryResults = organizeResults($results['primary'], $rankings['primary']);
    $secondaryResults = organizeResults($results['secondary'], $rankings['secondary']);
}

// helper functions
function getProperty($object, $value, $default = ""){
    if (!is_object($object)) return $default;
    if (!property_exists($object, $value)) return $default;

    return $object->$value;
}

function organizeResults($results, $rankings){
    $searchResults = [];

    //Organize Products
    foreach ($results as $product) {
        $assocProducts[$product->id] = $product;
    }

    //Organize search results
    foreach ($rankings as $ranking) {
        $id = $ranking['productId'];

        $product = (isset($assocProducts[$id])) ? $assocProducts[$id] : new stdClass();

        $scoreTooLow = (isset($ranking['scoreTooLow']) && $ranking['scoreTooLow']) ? true : false;
        $demoted = (isset($ranking['demoted']) && $ranking['demoted']) ? true : false;
        $popular = (isset($ranking['popular']) && $ranking['popular']) ? true : false;
        $searchResults[] = array(
            'id' => $id,
            'title' => getProperty($product, 'title'),
            'artist' => getProperty($product, 'artist'),
            'description' => getProperty($product, 'body'),
            'score' => $ranking['score'],
            'matchedOn' => $ranking['matchedOn'],
            'scoreTooLow' => $scoreTooLow,
            'demoted' => $demoted,
            'popular' => $popular
        );

    }

    return $searchResults;
}

//The View
?>
<html>
<head>
    <title>Search Tester</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">


</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1>Search Tester</h1>
            <form method="get" action="searchTest.php" class="form-inline">
                <div class="form-group">
                    <label for="q">Search for</label>
                    <input type="text" class="form-control" id="q" name="q" placeholder="Justin" value="<?php echo $q ?>">
                </div>
                <button type="submit" class="btn btn-default">Search</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h3>Primary results</h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Artist</th>
                    <th>Score</th>
                    <th>Matched on</th>
                    <th>Remark</th>
                    <th>Description</th>
                </tr>

                </thead>
                <tbody>
                <?php
                foreach ($primaryResults as $result) {
                    ?>
                    <tr>
                        <td><?php echo $result['id'];  ?></td>
                        <td><?php echo $result['title'];  ?></td>
                        <td><?php echo $result['artist'];  ?></td>
                        <td><?php echo $result['score'];  ?></td>
                        <td><?php echo join(', ', $result['matchedOn']);  ?></td>
                        <td><?php
                            echo ($result['scoreTooLow']) ? "Score too low" : "";
                            echo ($result['demoted']) ? "Demoted" : "";
                            echo ($result['popular']) ? "Popular" : "";
                            ?></td>
                        <td><?php echo $result['description'];  ?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
            <h3>Secondary results</h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Artist</th>
                    <th>Score</th>
                    <th>Matched on</th>
                    <th>Remark</th>
                    <th>Description</th>
                </tr>

                </thead>
                <tbody>
                <?php
                foreach ($secondaryResults as $result) {
                ?>
                <tr>
                    <td><?php echo $result['id'];  ?></td>
                    <td><?php echo $result['title'];  ?></td>
                    <td><?php echo $result['artist'];  ?></td>
                    <td><?php echo $result['score'];  ?></td>
                    <td><?php echo join(', ', $result['matchedOn']);  ?></td>
                    <td><?php
                        echo ($result['scoreTooLow']) ? "Score too low" : "";
                        echo ($result['demoted']) ? "Demoted" : "";
                        echo ($result['popular']) ? "Popular" : "";
                        ?></td>
                    <td><?php echo $result['description'];  ?></td>
                </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>

        <div class="col-md-12">
            <h3>Debug info</h3>
            <pre><?php echo json_encode($queries, JSON_PRETTY_PRINT) ?></pre>
        </div>
    </div>
</div>


<!-- Latest compiled and minified JavaScript -->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>-->
</body>
</html>

