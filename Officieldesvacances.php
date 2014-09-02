<?php

/**
 * Description of Officieldesvacances
 *
 * @author ouidir
 */
class Officieldesvacances {
    
    const  URL_WS = 'http://abo.officiel-des-vacances.com/partenaire.php';
    private $client;
    private $request;
    
    private $civilite;
    private $nom;
    private $prenom;
    private $adresse;
    private $cp;
    private $ville;
    private $pays;
    private $dob;
    private $mdp ;
    private $email;
    private $id_partenaire;
    private $url_return;
    private $optin_nl; 
    
    
    function __construct(GuzzleHttp\Client $client) {
        $this->client = $client; 
        $this->request = $this->client->createRequest('POST', self::URL_WS );
    }

    /**
     * @param mixte $civilite
     * @return int  
     */
    public function getCivilite() {
        return $this->civilite;
    }
    /**
     * 
     * @param string $civilite (M, Mme, Mlle)     
     */
    public function setCivilite($civilite) {        
        switch($civilite) {
            case 'M'    :    return '1';
            case 'Mme'  :    return '2';
            case 'Mlle' :    return '3';
            default     :    return '0';
        }
        $this->civilite = $civilite;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        if( strlen($nom)> 45  ) 
            throw new Exception('Erreur: nom ');
        $this->nom = $nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        if( strlen($prenom)> 45  ) 
            throw new Exception('Erreur: prenom ');
        $this->prenom = $prenom;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function setAdresse($adresse) {
        if( strlen($adresse)> 255  ) 
            throw new Exception('Erreur: adresse ');
        $this->adresse = $adresse;
    }

    public function getCp() {
        return $this->cp;
    }

    public function setCp($cp) {
        if( strlen($cp)> 20  ) 
            throw new Exception('Erreur: cp ');
        $this->cp = $cp;
    }

    public function getVille() {
        return $this->ville;
    }

    public function setVille($ville) {
        if( strlen($ville)> 64  ) 
            throw new Exception('Erreur: ville ');
        $this->ville = $ville;
    }

    public function getPays() {
        return $this->pays;
    }

    public function setPays($pays) {
        if( strlen($pays)> 2  ) 
            throw new Exception('Erreur: pays ');
        $this->pays = $pays;
    }

    public function getDob() {
        return $this->dob;
    }

    public function setDob($dob) {
        if( $dob && !preg_match('#^([0-9]{2})-([0-9]{2})-([0-9]{4})$#')  ) 
            throw new Exception('Erreur: date de naissance jj/mm/aaaa ! ');
        $this->dob = $dob;
    }

    public function getMdp() {
        return $this->mdp;
    }

    public function setMdp($mdp) {
        if( strlen($mdp)>50 && strlen($mdp)<5 ) 
            throw new Exception('Erreur: mdp ');
        $this->mdp = $mdp;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        if( strlen($email)>128 || !self::VerifierEmail($email)  )
            throw new Exception('Erreur: email ');
        $this->email = $email;
    }

    public function getIdPartenaire() {
        return $this->id_partenaire;
    }

    public function setIdPartenaire($id_partenaire) {
        $this->id_partenaire = $id_partenaire;
    }

    public function getUrlReturn() {
        return $this->url_return;
    }

    public function setUrlReturn($url_return) {
        if( strlen($url_return)> 255  ) 
            throw new Exception('Erreur: url_return ');
        $this->url_return = $url_return;
    }

    public function getOptinNl() {
        return $this->optin_nl;
    }

    public function setOptinNl($optin_nl) {
        if( !in_array($optin_nl, array("0","1") )   ) 
            throw new Exception('Erreur: optin_nl ');
        $this->optin_nl = $optin_nl;
    }

    public function getOptinPartenaire() {
        return $this->optin_partenaire;
    }

    public function setOptinPartenaire($optin_partenaire) {
        if( !in_array($optin_partenaire, array("0","1") ) ) 
            throw new Exception('Erreur: optin_partenaire ');
        $this->optin_partenaire = $optin_partenaire;
    }

    public function getUpdate() {
        return $this->update;
    }

    public function setUpdate($update) {
        if( !in_array($update, array("0","1") ) ) 
            throw new Exception('Erreur: update ');
        $this->update = $update;
    }

    public function sendprofil() {
        try {            
            if($this->civilite  )      $this->request->setHeader('civilite'     , $this->civilite       );
            if($this->nom       )      $this->request->setHeader('nom'          , $this->nom            );
            if($this->prenom    )      $this->request->setHeader('prenom'       , $this->prenom         );
            if($this->adresse   )      $this->request->setHeader('adresse'      , $this->adresse        );
            if($this->cp        )      $this->request->setHeader('cp'           , $this->cp             );
            if($this->ville     )      $this->request->setHeader('ville'        , $this->ville          );
            if($this->pays      )      $this->request->setHeader('pays'         , $this->pays           );
            if($this->mdp       )      $this->request->setHeader('dob'          , $this->mdp            );
                                       $this->request->setHeader('email'        , $this->email          );
                                       $this->request->setHeader('id_partenaire', $this->id_partenaire  );
            if($this->url_return)      $this->request->setHeader('url_return'   , $this->url_return     );
            if($this->optin_nl  )      $this->request->setHeader('optin_nl'     , $this->optin_nl       );
            
            return $this->client->send($this->request);
            
        } catch(Exception $e){
            return $e->getMessage();
        }        
    }
    
    public static function VerifierEmail($email) {
        if(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email))
          return true;         
        return false;
    }    
}

?>
