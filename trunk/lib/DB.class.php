<?php
class DB {

    private $debug          = false;
    private $conexao        = false;
    private $tabelas        = array ();
    private $colunas        = array ();
    private $informacoes    = array ();

    function setConexao($conexao) {
        if (gettype($conexao) != 'resource') {
            return false;
        }
        $this->conexao = $conexao;

        $sql = "SHOW TABLES";
        $res = mysql_query($sql, $this->conexao);
        mysql_query("SET NAMES 'utf8';");
        if (!$res) {
            $this->showErro();
            return false;
        }
        while ($row = mysql_fetch_row($res)) {
            $this->tabelas[] = $row[0];
        }
        mysql_free_result($res);

        foreach ($this->tabelas as $tabela) {
            $sql = "SHOW COLUMNS FROM {$tabela}";
            $res = mysql_query($sql, $this->conexao);
            if (!$res) {
                $this->showErro();
                return false;
            }
            while ($row = mysql_fetch_row($res)) {
                $this->colunas[$tabela][] = $row[0];
                $this->informacoes[$tabela][$row[0]] = array (
                    'type'      => $row[1],
                    'null'      => $row[2] == 'YES',
                    'primary'   => $row[3] == 'PRI',
                    'default'   => $row[4]
                );
            }
            mysql_free_result($res);
        }

        return true;
    }

    function getConexao() {
        return $this->conexao;
    }

    function setDebug($value) {
        $this->debug = $value;
    }

    function getTabelas() {
        return $this->tabelas;
    }

    function getColunas($tabela = null) {
        if ($tabela) {
            return $this->colunas[$tabela];
        }
        return $this->colunas;
    }

    function getInformacoes($tabela = null, $coluna = null, $dado = null) {
        if ($dado) {
            return $this->informacoes[$tabela][$coluna][$dado];
        }
        if ($coluna) {
            return $this->informacoes[$tabela][$coluna];
        }
        if ($tabela) {
            return $this->informacoes[$tabela];
        }
        return $this->informacoes;
    }

    function conectar() {

        //$config     = oGetConfig('db');
        $server     = 'localhost';
        $user       = 'root';
        $pass       = '';
        $banco      = 'monitoramento';

        $conexao = mysql_connect($server, $user, $pass);

        if (!$conexao) {
            return false;
        }

        if (!mysql_select_db($banco, $conexao)) {
            return false;
        }

        $this->setConexao($conexao);

        return true;
    }

    function desconectar() {
        if (!$this->conexao) {
            return false;
        }
        return mysql_close($this->conexao);
    }

    function executar($sql) {
        if (!$this->conexao) {
            return false;
        }

        $timestamp = microtime();
        $result = mysql_query($sql, $this->conexao);
        $time = microtime() - $timestamp;

        $error = mysql_error($this->conexao);
        $errno = mysql_errno($this->conexao);

        if ($this->debug) {
            echo "<hr />";
            echo "<pre>{$sql}</pre>";
            echo "<b>Tempo:</b> {$time} microsegundos<br />";
            if (!$result) {
                echo "<b>Erro:</b> #{$errno} - {$error}<br />";
            }
            if ($result && @mysql_num_rows($result)) {
                echo "<b>Resultado:</b><br />";
                echo "<table border=\"1\" cellpadding=\"2\" style=\"border-collapse: collapse;\">";
                while ($row = mysql_fetch_assoc($result)) {
                    if (!$count++) {
                        echo "<tr>";
                        foreach ($row as $key => $val) {
                            echo "<th>{$key}</th>";
                        }
                        echo "</tr>";
                    }
                    echo "<tr>";
                    foreach ($row as $key => $val) {
                        echo "<td>{$val}</td>";
                    }
                    echo "</tr>";
                }
                mysql_data_seek($result, 0);
                echo "</table>";
            }

            echo "<hr />";
        }
        
        if (!$result) {
            $this->showErro();
        }
        
        return $result;
    }

    function getErro() {
        return mysql_error($this->conexao);
    }

    function getErroNumero() {
        return mysql_errno($this->conexao);
    }

    function showErro() {

            $errno = $this->getErroNumero();
            $error = $this->getErro();

            if ($this->debug) {
                $erro = "<br /><b>Erro:</b> #{$errno} - {$error}";
            }
            echo $erro;
            echo $errno;
            echo $error;
            exit;
    }

    /**
     * O mesmo que selectMultiLinhas().
     */
    function select($sql, $colIndex = null) {
        return $this->selectMultiLinhas($sql, $colIndex);
    }

    /**
     * Executa o comando SQL e retorna uma lista
     * com as linhas do resultado.
     */
    function selectMultiLinhas($sql, $colIndex = null) {
        $res = $this->executar($sql);
        return $this->processarResultadoMultiLinhas($res, $colIndex);
    }

    /**
     * Executa o comando SQL e retorna
     * uma unica linha do resultado.
     */
    function selectUmaLinha($sql) {
        $res = $this->executar($sql);
        return $this->processarResultadoUmaLinha($res);
    }

    /**
     * Executa o comando SQL e retorna
     * um unico valor do resultado.
     */
    function selectUmValor($sql) {
        $res = $this->executar($sql);
        return $this->processarResultadoUmValor($res);
    }

    /**
     * Executa o comando SQL e retorna
     * o n�mero de linhas do resultado.
     */
    function selectCount($sql) {
        $sql = "SELECT COUNT(*) AS count_value FROM ({$sql}) AS count_table";
        $res = $this->executar($sql);
        return $this->processarResultadoUmValor($res);
    }

    /**
     * Retorna o n�mero de linhas da tabela
     */
    function getCount($tabela) {
        $sql = "SELECT COUNT(*) FROM {$tabela}";
        return $this->selectUmValor($sql);
    }

    function getColunaId($tabela) {
        return $this->colunas[$tabela][0];
    }

    /**
     * Retorna todas as linhas de uma tabela
     */
    function getLinhas($tabela, $ordem = null) {
        $col_id = $this->getColunaId($tabela);
        $sql = "SELECT * FROM {$tabela}";
        if (strlen($ordem) > 0) {
            $sql .= " ORDER BY {$ordem}";
        }
        return $this->selectMultiLinhas($sql, $col_id);
    }

    /**
     * Retorna uma linha da tabela atraves do ID
     */
    function getLinha($tabela, $id) {
        $col_id = $this->getColunaId($tabela);
        $sql = "SELECT * FROM {$tabela} WHERE {$col_id} = '{$id}' LIMIT 1";
        return $this->selectUmaLinha($sql);
    }

    /**
     * Retorna a ultima linha da tabela
     */
    function getUltimaLinha($tabela) {
        $sql = "SELECT * FROM {$tabela} ORDER BY 1 DESC LIMIT 1";
        return $this->selectUmaLinha($sql);
    }

    /**
     * Insere os dados na tabela e retorna a linha inserida
     * ou false caso n�o houver sucesso.
     * <br>
     * @param string $tabela O nome da tabela.
     * @param mixed $dados Um array ou object com os dados.<br>Chave = coluna, Valor = valor.
     * @return mixed A linha inserida ou false caso n�o houver sucesso.
     */
    function insert($tabela, $dados) {

        $resevados = array ('NOW()', 'NULL', 'DEFAULT');

        if (is_object($dados)) {
            $dados = (array)$dados;
        }
        if (!is_array($dados) || count($dados) == 0) {
            return false;
        }

        $sql = "";
        
        $tmp = array ();
        foreach ($dados as $key => $val) {
            $tmp[] = $key;
        }
        $tmp = implode(', ', $tmp);

        $sql .= "INSERT INTO {$tabela} ({$tmp})";

        $tmp = array ();
        foreach ($dados as $key => $val) {
            if (in_array(strtoupper($val), $resevados)) {
                $tmp[] = "{$val}";
            } else {
                $tmp[] = "'{$val}'";
            }
        }
        $tmp = implode(', ', $tmp);
        $sql .= " VALUES ({$tmp})";

        if (!$this->executar($sql)) {
            return false;
        }

        //$linha = $this->getUltimaLinha($tabela);

        return true;
    }

    /**
     * Atualiza os dados na tabela e retorna a linha atualizada
     * ou false caso n�o houver sucesso.
     * <br>
     * @param string $tabela O nome da tabela.
     * @param mixed $dados Um array ou object com os dados.<br>Chave = coluna, Valor = valor.
     * @param string $id A chave primaria da tabela.
     * @return mixed A linha atualizada ou false caso n�o houver sucesso.
     */
    function update($tabela, $dados, $id) {

        $resevados = array ('NOW()', 'NULL', 'DEFAULT');

        if (is_object($dados)) {
            $dados = (array)$dados;
        }
        if (!is_array($dados) || count($dados) == 0) {
            return false;
        }

        $col_id = $this->getColunaId($tabela);

        $tmp = array ();
        foreach ($dados as $key => $val) {
            if (in_array(strtoupper($val), $resevados)) {
                $tmp[] = "{$key} = {$val}";
            } else {
                $tmp[] = "{$key} = '{$val}'";
            }
        }
        $tmp = implode(', ', $tmp);
        $sql = "UPDATE {$tabela} SET {$tmp} WHERE {$col_id} = '{$id}'";
        
        if (!$this->executar($sql)) {
            return false;
        }
                        
        return true;
    }

    /**
     * Deleta dados da tabela.
     * <br>
     * @param string $tabela O nome da tabela.
     * @param string $id A chave primaria da tabela.
     * @return boolean false caso n�o houver sucesso.
     */
    function delete($tabela, $id) {

        $col_id = $this->getColunaId($tabela);

        $sql = "DELETE FROM {$tabela} WHERE {$col_id} = '{$id}'";
var_dump($sql);
        if (!$this->executar($sql)) {
            return false;
        }
        
        return true;
    }

    function processarResultado($result, $colIndex = null) {
        return $this->processarResultadoMultiLinhas($result, $colIndex);
    }

    function processarResultadoMultiLinhas($result, $colIndex = null) {
        if (!$result) {
            return false;
        }
        $rt = array ();
        
        while ($row = mysql_fetch_object($result)) {                                                
            $rt[]=$row;                   
        }
        
        mysql_free_result($result);
        return $rt;
    }

    function processarResultadoUmaLinha($result) {
        if (!$result) {
            return false;
        }
        $rt = mysql_fetch_object($result);
        mysql_free_result($result);
        return $rt;
    }

    function processarResultadoUmValor($result) {
        if (!$result) {
            return false;
        }
        list ($rt) = mysql_fetch_row($result);
        mysql_free_result($result);
        return $rt;
    }

    function iniciarTransacao(){
        return $this->executar("BEGIN");
    }

    function cancelarTransacao(){
        return $this->executar("ROLLBACK");
    }
    
    function concluirTransacao(){
        return $this->executar("COMMIT");
    }

}
?>
