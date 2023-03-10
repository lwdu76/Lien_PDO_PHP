<?php

// Paramètres de connexion à la base de données (à adapter en fonction de votre environnement);

define('HOST', 'localhost');
define('USER', 'root');
define('DBNAME', 'links_manager_dev');
define('PASSWORD', ''); // windows (Mamp le mot de passe c'est 'root')

/**
 * Fonction de connexion à la base de données
 *
 * @return \PDO
 */
function db_connect(): PDO {

    try {
        /**
         * Data Source Name : chaine de connexion à la base de données
         * Elle permet de renseigner le domaine du serveur de la base de données, le nom de la base de données cible et l'encodage de données pendant leur transport
         * @var string
         */
        $dsn =  'mysql:host=' . HOST . ';dbname=' . DBNAME . ';charset=utf8';

        return new PDO($dsn, USER, PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    
    } catch (\PDOException $ex) {
    
        echo sprintf('La demande de connexion à la base de donnée a échouée avec le message %s', $ex->getMessage());
    
        exit(0);
    }
}

/**
 * Fonction qui permet de récupérer le tableau des enregistrements de la table des liens
 * @return array
 */
function get_all_link() {

    // TODO implement function
    $db = db_connect();

    $sql = <<<EOD
    SELECT
        `link_id`,
        `title`,
        `url`
    FROM
        `links`
    EOD;

    $linkStmt = $db->query($sql);

    $link = $linkStmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $link;
}

/**
 * Fonction qui permet de récupérer un enregistrement à partir de son identifiant dans la table des liens
 * @param integer $link_id
 * @return array
 */
function get_link_by_id($link_id) {

    // TODO implement function
    $db = db_connect();

    $sql = <<<EOD
    SELECT
        `link_id`,
        `title`,
        `url`
    FROM
        `links`
    WHERE
        `link_id` = :link_id
    EOD;

    $linkDetailsStmt = $db->prepare($sql);

    $linkDetailsStmt->bindParam(':link_id', $link_id);

    $linkDetailsStmt->execute();
    
    $linkdetails = $linkDetailsStmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $linkdetails;
}

/**
 * Fonction qui permet de d'enregistrer un nouveau lien dans la table des liens
 * @param array $data: ['title' => 'MDN', 'url' => 'https://developer.mozilla.org/fr/']
 * @return bool
 */
function create_link($data) {

    // TODO implement function
    $db = db_connect();

    $sql = <<<EOD
    INSERT INTO 
        `links` (`title`,
                 `url`)
    VALUES 
        (:title, 
         :url_link)
    EOD;

    $linkDetailsStmt = $db->prepare($sql);

    $linkDetailsStmt->bindParam(':title', $data['title']);
    $linkDetailsStmt->bindParam(':url_link', $data['url']);

    $linkDetailsStmt->execute();
    
    return $linkDetailsStmt;
}

/**
 * Fonction qui permet de modifier un enregistrement dans la table des liens
 * @param array $data: ['link_id' => 1, 'title' => 'MDN', 'url' => 'https://developer.mozilla.org/fr/']
 * @return bool
 */
function update_link($data) {

    // TODO implement function
    $db = db_connect();

    $sql = <<<EOD
    UPDATE 
        links
    SET 
        `title` = :title, 
        `url` = :url_link
    WHERE 
        `link_id` = :link_id
    EOD;

    $linkDetailsStmt = $db->prepare($sql);

    $linkDetailsStmt->bindParam(':link_id', $data['link_id']);
    $linkDetailsStmt->bindParam(':title', $data['title']);
    $linkDetailsStmt->bindParam(':url_link', $data['url']);

    $linkDetailsStmt->execute();
    
    return $linkDetailsStmt;
}

/**
 * Fonction qui permet de supprimer l'enregistrement dont l'identifiant est $link_id dans la table des liens
 *@param integer $link_id
 * @return bool
 */
function delete_link($link_id) {

    // TODO implement function
    $db = db_connect();

    $sql = <<<EOD
    DELETE
    FROM
        `links`
    WHERE
        `link_id` = :link_id
    EOD;

    $linkDetailsStmt = $db->prepare($sql);

    $linkDetailsStmt->bindParam(':link_id', $link_id);

    $linkDetailsStmt->execute();
    
    return $linkDetailsStmt;
}
