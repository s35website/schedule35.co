<?php
/**
 * Created by PhpStorm.
 * User: Co
 * Date: 22/03/2016
 * Time: 23:30
 */

namespace search;


class Searcher
{
    /** @var \Database */
    public $db;

    /** @var SearchSettings */
    public $settings;

    //results
    private $primaryResults = [], $primaryRankings = [];
    /** @var  Query */
    private $primaryQuery;

    private $secondaryResults = [], $secondaryRankings = [];
    /** @var  Query */
    private $secondaryQuery;
    private $minimumScore;


    public function __construct(\Database $db){
        $this->db = $db;

        $this->checkInstall();

        //Get settings
        $this->loadSettings();

    }

    /** Check if the searcher is installed and does so if it's not.
     *
     * If the DB Tables don't exist yet, this function will
     * create the database, set the default settings, and run the first Full Index.
     * @return bool True if install successful or not needed, false on error.
     */
    public function checkInstall(){
        $searchtermsExists = $this->db->tableExists('searchterms');
        $customSettingsExist = $this->db->tableExists('custom_settings');

        if ($searchtermsExists && $customSettingsExist) return true;

        $errorMessage = "Error installing new Search functionality: <br>";

        //Create settings
        if (!$customSettingsExist){
            //Create table
            $sql = file_get_contents(__DIR__ . '/sqlScripts/createCustomSettings.sql');
            $this->db->query($sql);

            if ($this->db->error) {
                echo $errorMessage;
                echo "Couldn't create Settings Table: " . $this->db->error;
                return false;
            }

            //Set default options.
            $this->settings = new SearchSettings();
            $this->saveSettings();
        }

        //create Search terms
        if (!$searchtermsExists){
            //Create table
            $sql = file_get_contents(__DIR__ . '/sqlScripts/createSearchterms.sql');
            $this->db->query($sql);

            if ($this->db->error) {
                echo $errorMessage;
                echo "Couldn't create Terms Table: " . $this->db->error;
                return false;
            }

            $errors = array();
            $this->indexAll($errors);

            if (count($errors) > 0 ) {
                echo $errorMessage;
                echo "Indexing products failed for these producIds: " . join(', ', $errors);
                return false;
            }
        }

        return true;
    }

    public function saveSettings(){
        //check values
        if (!$this->settings->isValid()) return false;

        $json = json_encode($this->settings);
        $name = SearchSettings::SETTINGS_KEY;

        return $this->db->saveCustomSettings($name, $json);
    }

    public function loadSettings(){
        $name = SearchSettings::SETTINGS_KEY;

        $json = $this->db->loadCustomSettings($name);
        $this->settings = SearchSettings::fromJson($json);

        return true;
    }

    /** Returns the weight of the category.
     * @param $name string The category id
     * @return false|int The weight of the category or false on failure.
     */
    public function getCategoryWeight($name){
        if (isset($this->settings->weights[$name])) {
            return $this->settings->weights[$name];
        }

        return false;
    }

    public function getRankings(){
        return array(
            'primary' => $this->primaryRankings,
            'secondary' => $this->secondaryRankings
        );
    }

    public function getQueries(){
        return array(
            'primary' => $this->primaryQuery,
            'secondary' => $this->secondaryQuery
        );
    }

    private function resetResults(){
        $this->primaryRankings = [];
        $this->primaryResults = [];
        $this->primaryQuery = null;

        $this->secondaryRankings = [];
        $this->secondaryResults = [];
        $this->secondaryQuery = null;
    }

    /** Search the database for Products
     * @var $searchString string The search query of the user
     * @return array The resulting Products from the Products table
     */
    public function search($searchString){

        $this->resetResults();

        $this->getPrimaryMatches($searchString);

        if ($this->settings->getMethod() != 'term'){
            $this->getSecondaryMatches($searchString);
            
            //Add popular results to fill up the secondary results 
            if (count($this->secondaryResults) < $this->settings->minSecondarySheets){
                $this->padSecondaryResults();
            }
        }

        return array(
            'primary' => $this->primaryResults,
            'secondary' => $this->secondaryResults
        );
    }
    
    private function padSecondaryResults(){
        $needed = $this->settings->minSecondarySheets - count($this->secondaryResults);
        if ($needed < 1) return true;

        global $item;
        /** @var $item \Products */

        $popular = $item->getProductsPage('popular', 1, $needed);

        foreach ($popular as $p) {
            $this->secondaryResults[] = $p;
            $this->secondaryRankings[] = [
                'productId' => $p->id,
                'score' => 1,
                'popular' => true,
                'matchedOn' => []
            ];
        }

        return true;
    }

    /** Search the database for Primary Matches.
     * The results are stored in Searcher::PrimaryResults
     * @var $searchString string The search query of the user
     * @return true
     */
    private function getPrimaryMatches($searchString){
        $q = Query::newInstance($searchString, $this->settings);
        $this->primaryQuery = $q;
        //Note on SQL injection, Query::newInstance() strips everything non-alphanumerical.

        $normalSearchTerms = $q->getNormalizedTermsArray();

        //Create the SQL
        if (empty($normalSearchTerms)) return true;

        //Search for direct matches (and partials)
        $like = "term LIKE '" . implode("%' OR term LIKE '", $normalSearchTerms) . "%' ";
        $sql = "SELECT * FROM searchterms WHERE $like";

        $matches = $this->db->fetch_all($sql);

        //Rank it
        $rankings = $this->primaryRankings;
        foreach ($matches as $result) {
            if (!isset($rankings[$result->product_id])){
                //Create a new result
                $rankings[$result->product_id] = array(
                    'productId' => $result->product_id,
                    'score' => $this->getCategoryWeight($result->category), //0,
                    'matchedOn' => [$result->term]
                );
            } else {
                //update the extisting result
                $rankings[$result->product_id]['score'] += $this->getCategoryWeight($result->category);
                $rankings[$result->product_id]['matchedOn'][] = $result->term;
            }

            //Extra points proportionate to the match.
            /*foreach ($normalSearchTerms as $term) {
                $length = strlen($term);
                if (substr($result->term, 0, $length) == $term){
                    $fullWeight = $this->getCategoryWeight($result->category);
                    $fullLenth = strlen($result->term);
                    $add = $fullWeight * ($length / $fullLenth);
                    $rankings[$result->product_id]['score'] += $add;
                }
            }*/

            //Extra points for exact matches.
            if (in_array($result->term, $normalSearchTerms)){
                $rankings[$result->product_id]['score'] += $this->getCategoryWeight($result->category);
            }
        }

        //Results?
        if (empty($rankings)) return true;

        //Sort by score
        usort($rankings, function($a, $b){
            return ($a['score'] < $b['score']) ? 1 : -1;
        });

        //Remove (relatievely) low scores
        $factor = $this->settings->ignoreLowerScorePercentage / 100;
        $minimumScore = $rankings[0]['score'] * $factor;
        $this->minimumScore = $minimumScore;

        $demoteFactor = $this->settings->demoteLowerScorePercentage / 100;
        $demoteScore =  $rankings[0]['score'] * $demoteFactor;

        if ($this->settings->minScore > $minimumScore) $minimumScore = $this->settings->minScore;

        $productIds = array();
        foreach ($rankings as &$product) {
            if ($product['score'] > $demoteScore) {
                //This is a primary result
                $productIds[] = $product['productId'];
            } else if ($product['score'] > $minimumScore) {
                //This is a secondary result
                $product['demoted'] = true;
                $this->secondaryRankings[$product['productId']] = $product;
            } else {
                //This is so low we don't want it.
                $product['scoreTooLow'] = true;
            }
        }

        //Update ranking info
        $this->primaryRankings = $rankings;

        if (empty($productIds)) return true;

        //Get product info
        $idString = implode(',', $productIds);
        $sql = "SELECT * FROM products WHERE active = 1 AND id IN (" . $idString . ") ";
        $sql .= "ORDER BY FIELD(id,$idString)";
        $this->primaryResults = $this->db->fetch_all($sql);

        return true;
    }

    /** Search the database for Secondary (sounds-like) Matches.
     * The results are stored in Searcher::PrimaryResults
     * @var $searchString string The search query of the user
     * @return true
     */
    private function getSecondaryMatches($searchString){
        $q = Query::newInstance($searchString, $this->settings);
        $this->secondaryQuery = $q;
        //Note on SQL injection, Query::newInstance() strips everything non-alphanumerical.

        $normalSearchTerms = $q->getNormalizedTermsArray();

        //Create the SQL
        $array = $q->getMethodTermsArray();
        $method = $this->settings->getMethod();

        if (empty($array)) return true;

        //What to search for
        $searchTerms = "'" . implode("', '", $array) . "'";
        //Ignore the products that are already in Primary Results
        //$primaryIds = implode(', ', array_keys($this->primaryRankings));
        $primaryIds = array_map(function($r){ return $r['productId']; }, $this->primaryRankings);
        $idString = ($primaryIds) ? " AND product_id NOT IN (" . implode(', ', $primaryIds) .")" : "";

        $sql = "SELECT * FROM searchterms WHERE $method IN (" . $searchTerms . ") $idString";

        $matches = $this->db->fetch_all($sql);

        //Rank it
        $rankings = $this->secondaryRankings;
        foreach ($matches as $result) {
            if (!isset($rankings[$result->product_id])){
                //Create a new result
                $rankings[$result->product_id] = array(
                    'productId' => $result->product_id,
                    'score' => $this->getCategoryWeight($result->category),
                    'matchedOn' => [$result->term]
                );
            } else {
                //update the extisting result
                $rankings[$result->product_id]['score'] += $this->getCategoryWeight($result->category);
                $rankings[$result->product_id]['matchedOn'][] = $result->term;
            }

            //Extra points for exact matches
            if (in_array($result->term, $normalSearchTerms)){
                $rankings[$result->product_id]['score'] += $this->getCategoryWeight($result->category);
                //This can theoretically not happen, because exact matches are in the primary results. If we get here
                // we made a mistake.
                $rankings[$result->product_id]['exactMatchError'] = true;
            }
        }

        //Results?
        if (empty($rankings)) return true;

        //Sort by score
        usort($rankings, function($a, $b){
            return ($a['score'] < $b['score']) ? 1 : -1;
        });

        //Remove (relatievely) low scores
        $minimumScore = $this->minimumScore;

        if ($this->settings->minScore > $minimumScore) $minimumScore = $this->settings->minScore;

        $productIds = array();
        foreach ($rankings as &$product) {
            if ($product['score'] > $minimumScore) {
                //This is a primary result
                $productIds[] = $product['productId'];
            } else {
                //This is so low we don't want it.
                $product['scoreTooLow'] = true;
            }
        }

        //Update ranking info
        $this->secondaryRankings = $rankings;

        if (empty($productIds)) return true;

        //Get product info
        $idString = implode(',', $productIds);
        $sql = "SELECT * FROM products WHERE active = 1 AND id IN (" . $idString . ") ";
        $sql .= " ORDER BY FIELD(id,$idString)";
        $sql .= " LIMIT " . $this->settings->maxSecondarySheets;
        $this->secondaryResults = $this->db->fetch_all($sql);

        return true;
    }

    /** Removes the indexed terms for a Product
     * @param $id int The ProductId
     * @return bool true un success, false otherwise
     */
    public function removeIndex($id){
        return $this->db->removeIndexTerms($id);
    }

    /** Index one product.
     * Should be calles when a product is added, or edited.
     * @param $id int The ID of the Product to be updated.
     * @return bool True on successful, false otherwise.
     * @throws \Exception
     */
    public function indexOne($id){
        //todo: Make prepared statements!
        // Now instead I will escape things.
        if (!is_numeric($id)) {
            //
            return false;
        }

        //Get the record
        $sql = "SELECT p.id, p.title, p.artist, p.body, u.username, u.fname, u.lname, u.alias " .
            "FROM products p LEFT OUTER JOIN users u on p.aid = u.id " .
            "WHERE p.id = $id";
        $result = $this->db->first($sql);

        if (!$result) {
            //Product not found.
            return false;
        }

        //Turn it into terms with categories
        $terms = array();
        //Title terms
        if (isset($result->title)) {
            $title = html_entity_decode($result->title, ENT_QUOTES);
            $titleTerms = Query::getIndexTerms($title, 'title', $this->settings);
            $terms = array_merge($terms, $titleTerms);
        }
        //Artist terms
        if (isset($result->artist)) {
            $artist = html_entity_decode($result->artist, ENT_QUOTES);
            $artistTerms = Query::getIndexTerms($artist, 'artist', $this->settings);
            $terms = array_merge($terms, $artistTerms);
        }
        //transcripter terms
        $transcriber = "";
        if (isset($result->username)) $transcriber .= $result->username . " ";
        if (isset($result->fname)) $transcriber .= $result->fname . " ";
        if (isset($result->lname)) $transcriber .= $result->lname;
        if (isset($result->alias)) $transcriber .= $result->alias;
        if ($transcriber != "") {
            $terms = array_merge($terms, Query::getIndexTerms($transcriber, 'transcriber', $this->settings));
        }
        //Transform body (description) to something readable
        if (isset($result->body)){
            //Decode HTML
            $description = html_entity_decode($result->body, ENT_QUOTES);
            //Add spaces before tags to avoid `<h1>whats</h1>updog` from becoming one word.
            $description = str_replace('<', ' <', $description);
            //Remove HTML tags
            $description =  strip_tags($description);
            //Remove extra newlines and whitespaces
            $description = preg_replace('/\s+/', ' ', $description);

            $terms = array_merge($terms, Query::getIndexTerms($description, 'description', $this->settings));
        }

        return $this->db->insertIndexTerms($id, $terms);

    }

    /** (Re-)index all products.
     * This will go through all products in the database and create their search terms.
     * @param $failedProductIds array An array of the product IDs where the creation of search terms failed.
     * @return bool True if there were no errors, false otherwise.
     * @throws \Exception
     */
    public function indexAll(&$failedProductIds){
        //Get the ids
        $sql = "SELECT id FROM products";
        $result = $this->db->fetch_all($sql);

        if (!$result) {
            //Something went wrong
            throw new \Exception('Couldn\'t get product Id\'s');
        }

        //Remove all indexes first
        if (!$this->db->removeAllIndexTerms()){
            throw new \Exception('Couldn\'t remove old index Terms');
        }

        $failedProductIds = array();
        foreach ($result as $item) {
            if (!$this->indexOne($item->id)) {
                $failedProductIds[] = $item->id;
            }
        }

        if (count($failedProductIds) > 0) return false;

        return true;

    }



}