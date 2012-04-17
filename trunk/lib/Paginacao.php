<?php

class Paginacao {

    private $pagina_atual;
    private $total_paginas;
    private $limite_paginas;
    private $is_post = false;
    private $div;
    private $store;
    private $linkPagina;


    function  __construct($pagina_atual = 0, $total_paginas = 0, $limite_paginas = 0, $div = null, $store = null, $linkPagina = null) {
        $this->setPaginaAtual($pagina_atual);
        $this->setTotalPaginas($total_paginas);
        $this->setLimitePaginas($limite_paginas);
        $this->setDiv($div);
        $this->setStore($store);
        $this->setLinkPagina($linkPagina);
    }

    function setPaginaAtual($valor) {
        $this->pagina_atual = $valor;
    }

    function setLinkPagina($valor) {
        $this->linkPagina = $valor;
    }
    function setDiv($valor) {
        $this->div = $valor;
    }
    function setStore($valor) {
        $this->store = $valor;
    }

    function setTotalPaginas($valor) {
        $this->total_paginas = $valor;
    }

    function setLimitePaginas($valor) {
        $this->limite_paginas = $valor;
    }

    function isPost() {
        $this->is_post = true;
    }

    function getConteudo() {
        if ($this->total_paginas < 2) {
            return false;
        }

        $retorno = "";
        $retorno .= "<div class=\"paginacao\">";
        $retorno .= "<span>Página {$this->pagina_atual} de {$this->total_paginas}</span>";
        $retorno .= "   <table border=\"0\" cellspacing=\"2\" cellpadding=\"0\">";
        $retorno .= "       <tr>";

        $link = "";
        $link = "?".$_SERVER['QUERY_STRING'];
        //$link = str_replace("&pag=$this->pagina_atual", "", $link);
        //$link = str_replace("pag=$this->pagina_atual", "", $link);
        $link = ereg_replace('(&pag|pag)=[0-9]*', '', $link);        
//        $link = explode('&cache', $link);
//
//        var_dump($link);
//        $link = $link[0];
        //echo $link;

        $retorno .= "<td></td>";
        //$retorno .= "<td><span>Ir à página </span></td>";
        $inputs = "";
        foreach ($_POST as $key => $valor) {
            $inputs.= "<input type=\"hidden\" name=\"$key\" value=\"$valor\">";
        }

        if ($this->pagina_atual > 1) {
            $pagina = 1;
            if ($this->is_post) {
                $retorno .= "<td><form method=\"post\" action=\"$link&pag=$pagina\">$inputs<input type=\"submit\" value=\"<<\" title=\"Primeira\"></form></td>";
            } else {
                $retorno .= "<td><a onclick = \" requestPage('{$this->linkPagina}.php{$link}&pag={$pagina}','{$this->div}','GET','', '{$this->store}{$pagina}'); return false; \" href=\"index.php?op={$this->linkPagina}{$link}&pag={$pagina}\" title=\"Primeira Página\"> << </a></td>";
            }

            $pagina = $this->pagina_atual - 1;
            if ($this->is_post) {
                $retorno .= "<td><form method=\"post\" action=\"$link&pag=$pagina\">$inputs<input type=\"submit\" value=\"<\" title=\"Voltar\"></form></td>";
            } else {
                $retorno .= "<td><a onclick = \" requestPage('{$this->linkPagina}.php{$link}&pag={$pagina}','{$this->div}','GET','', '{$this->store}{$pagina}'); return false; \" href=\"index.php?op={$this->linkPagina}{$link}&pag={$pagina}\" title=\"Voltar Página\"> < </a></td>";
            }
        }

        if ($this->limite_paginas > 0 && $this->total_paginas > $this->limite_paginas) {
            if ($this->pagina_atual - 1 < ($this->limite_paginas / 2)) {
                $mais = 0;
            } else {
                $mais = $this->pagina_atual - 1 - (int)($this->limite_paginas / 2);
                if($mais + $this->limite_paginas > $this->total_paginas) {
                    $mais = $this->total_paginas - $this->limite_paginas;
                }
            }
            $inicio = 1 + $mais;
            $fim = $this->limite_paginas + $mais;
        } else {
            $inicio = 1;
            $fim = $this->total_paginas;
        }

        for ($i = $inicio; $this->total_paginas > 1 && $i <= $fim; $i++) {
            $pagina = $i;
            if ($pagina == $this->pagina_atual) {
                $retorno .= "<td><span>$i</span></td>";
            } else {
                if ($this->is_post) {
                    $retorno .= "<td><form method=\"post\" action=\"$link&pag=$pagina\">$inputs<input type=\"submit\" value=\"$i\" title=\"Página $i\"></form></td>";
                } else {
                    $retorno .= "<td><a onclick = \" requestPage('{$this->linkPagina}.php{$link}&pag={$pagina}','{$this->div}','GET','', '{$this->store}{$pagina}'); return false; \" href=\"index.phpop={$this->linkPagina}{$link}&pag={$pagina}\" title=\"Página $i\">$i</a></td>";
                }
            }
        }
        if ($this->pagina_atual < $this->total_paginas) {
            $pagina = $this->pagina_atual + 1;
            if ($this->is_post) {
                $retorno .= "<td><form method=\"post\" action=\"$link&pag=$pagina\">$inputs<input type=\"submit\" value=\">\" title=\"Avançar\"></form></td>";
            } else {
                $retorno .= "<td><a onclick = \" requestPage('{$this->linkPagina}.php{$link}&pag={$pagina}','{$this->div}','GET','', '{$this->store}{$pagina}'); return false; \" href=\"index.phpop={$this->linkPagina}{$link}&pag={$pagina}\" title=\"Avançar Página\"> > </a></td>";
            }

            $pagina = $this->total_paginas;
            if ($this->is_post) {
                $retorno .= "<td><form method=\"post\" action=\"$link&pag=$pagina\">$inputs<input type=\"submit\" value=\">>\" title=\"Última\"></form></td>";
            } else {
                $retorno .= "<td><a onclick = \" requestPage('{$this->linkPagina}.php{$link}&pag={$pagina}','{$this->div}','GET','', '{$this->store}{$pagina}'); return false; \" href=\"index.phpop={$this->linkPagina}{$link}&pag={$pagina}\" title=\"Última Página\"> >> </a></td>";
            }
        }
        $retorno .= "       </tr>";
        $retorno .= "   </table>";
        $retorno .= "</div>";

        return $retorno;
    }

}
?>