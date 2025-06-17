<?php

/**
 * classe reponsavel pelas stastisticas sessoes e atualizaçoes de trafico do sistema
 *
 * @author pj
 */
class Session {

    private $Date;
    private $Cache;
    private $Traffic;
    private $Browser;

    function __construct($Cache = NULL) {
        session_start();
        $this->CheckSession($Cache);
    }

    private function CheckSession($Cache = NULL) {
        $this->Date = date('Y-m-d');
        $this->Cache = ((int) $Cache ? $Cache : 20);

        if (empty($_SESSION['useronline'])):

            $this->setTrafic();
            $this->setSession();
            $this->checkBrowser();
            
            $this->browserUpdate();
        else:
            $this->trafficUpdate();
            $this->sessionUpdate();
            $this->checkBrowser();
        endif;

        $this->Date = NULL;
    }

    //inicia sessao de usuario
    private function setSession() {
        $_SESSION['useronline'] = [
            "online_session" => session_id(),
            "online_startviews" => date('Y-m-d H:i:s'),
            "online_endviews" => date('Y-m-d H:i:s', strtotime("+{$this->Cache}minutes")),
            "online_ip" => filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP),
            "online_url" => filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT),
            "online_agent" => filter_input(INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_DEFAULT)
        ];
    }

    private function sessionUpdate() {

        $_SESSION['useronline']['online_endviews'] = date('Y-m-d H:i:s', strtotime("+{$this->Cache}minutes"));
        $_SESSION['useronline']['online_url'] = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT);
    }

    //verifica e insere trafico na tabela
    private function setTrafic() {

        $this->getTraffic();
        if (!$this->Traffic):
            $arrSiteViews = [
                'siteviews_date' => $this->Date,
                'siteviews_users' => 1,
                'siteviews_views' => 1,
                'siteviews_pages' => 1
            ];
            $CreateSiteViews = new Create();
            $CreateSiteViews->exeCreate('ws_siteviews', $arrSiteViews);
        else:

            if (!$this->getCookie()):
                $arrSiteViews = [
                    'siteviews_users' => $this->Traffic['siteviews_users'] + 1,
                    'siteviews_views' => $this->Traffic['siteviews_views'] + 1,
                    'siteviews_pages' => $this->Traffic['siteviews_pages'] + 1
                ];
            else:
                $arrSiteViews = [
                    'siteviews_views' => $this->Traffic['siteviews_views'] + 1,
                    'siteviews_pages' => $this->Traffic['siteviews_pages'] + 1
                ];
            endif;
        endif;

        $updateSiteViews = new Update();
        $updateSiteViews->exeUpdate('ws_siteviews', $arrSiteViews, 'WHERE siteviews_date = :date', "date= {$this->Date}");
    }

    //verifica e atualiza os pageviews

    private function trafficUpdate() {

        $this->getTraffic();
        $arrSiteViews = ['siteviews_pages' => $this->Traffic['siteviews_pages'] + 1];

        $updatePageViews = new Update();
        $updatePageViews->exeUpdate('ws_siteviews', $arrSiteViews, 'WHERE siteviews_date = :date', "date= {$this->Date}");

        $this->Traffic = NULL;
    }

    // obtem dados tabela trafico
    private function getTraffic() {
        $readSiteViews = new Read;
        $readSiteViews->ExeRead('ws_siteviews', "WHERE siteviews_date = :date", "date={$this->Date}");

        if ($readSiteViews->getRowCount()):
            $this->Traffic = $readSiteViews->getResult()[0];
        endif;
    }

    //verifica, cria e atualiza cookie do usuario
    private function getCookie() {
        //pega o cookie via post
        $cookie = filter_input(INPUT_COOKIE, 'useronline', FILTER_DEFAULT);

        // nao existir se cria um cookie que expira em 24 hrs
        setcookie("useronline", base64_decode("ceugreen"), time() + 86400);

        //verificaçao booleane se existe o cookie
        if (!$cookie):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    private function checkBrowser() {
        $this->Browser = $_SESSION['useronline']['online_agent'];

        if (strpos($this->Browser, 'Firefox/')):
            $this->Browser = 'Firefox';

        elseif (strpos($this->Browser, 'Chrome')):
            $this->Browser = 'Chrome';


        elseif (strpos($this->Browser, 'MSIE') || strpos($this->Browser, 'Trident/')):
            $this->Browser = 'IE';


        else:
            $this->Browser = 'Outros';
        endif;
    }

    private function browserUpdate() {
        $readAgent = new Read();
        $readAgent->exeRead('ws_siteviews_agent', "WHERE agent_name = :agent", "agent={$this->Browser}");

        if (!$readAgent->getResult()):
            $ArrAgent = [
                'agent_name' => $this->Browser,
                'agent_views' => 1
            ];

        $CreateAgent = new Create();
        $CreateAgent->exeCreate('ws_siteviews_agent', $ArrAgent);
        else:
            $ArrAgent = [
                'agent_views' => $readAgent->getResult() [0] ['agent_views'] + 1
            ];

        $updateAgente = new Update();
        $updateAgente->ExeUpdate('ws_siteviews_agent', $ArrAgent, "WHERE agent_name :name", "name={$this->Browser}"); 
        endif;
    }

}
