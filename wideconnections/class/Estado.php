<?php

class Estado {

    # ATRIBUTOS	
	public $pdo;
    
    public function __construct()
    {
        $this->pdo = Conexao::conexao();               
    }

    /**
     * listar todos os estados
     * @return array
     * @example $variavel = $Obj->metodo()
     */
    public function listar(){
    	// montar o SELECT ou o SQL        
        $sql = $this->pdo->prepare('SELECT * FROM estados ORDER BY estado DESC');        
    	// executar a consulta
    	$sql->execute();
    	// Pegar os dados retornados, como Objectos estanciados
        // Como serão retornados vários tabela usamos fetchAll
    	$dados = $sql->fetchAll(PDO::FETCH_OBJ);
        // retornar os dados para um array
    	return $dados;
    }

    /**
     * cadastra um novo estado
     * @param Array $dados    
     * @return int
     * @example $Obj->cadastrar($_POST);
     * 
     */
    public function cadastrar(Array $dados)
    {
        $sql = $this->pdo->prepare('INSERT INTO estados 
                                    (estado, status, uf, created_at, updated_at)
                                    values
                                    (:estado, :status, :uf, :created_at, :updated_at)
                                 ');

        // Tratar os dados recebidos do formulário
        // TRIM - remove os espaços antes de depois do texto
        // STRTOLOWER - transforma a STRING (str), para (to), minúsculo (lower)
        // UCFIRST - transforma o primeiro caracter (FIRST) para maiúscuo (UC Upper Case)        
        $estado  = (trim($dados['estado']));
        $status  = ($dados['status']);
        $uf  = ($dados['uf']);
        $created_at = date('Y-m-d H:i');
        $updated_at = date('Y-m-d H:i');
         
        // Mesclar os dados, ou seja, 
        // atribuir os valores armazenados nas variáveis ($alguma_coisa)
        // aos parametros (:alguma_coisa)
        $sql->bindParam(':estado',$estado);          
        $sql->bindParam(':status',$status);          
        $sql->bindParam(':uf',$uf);     
        $sql->bindParam(':created_at',$created_at);
        $sql->bindParam(':updated_at',$updated_at);     

        // Executar o SQL
        $sql->execute();
        // Retorna o ID do ITEM, ou seja, a PK (chave primária) do item
        return $this->pdo->lastInsertId();
    }


    /**
     * Retorna os dados de um estado
     * @param int $id_do_item
     * @return object
     * @example $variavel = $Obj->mostrar($id_do_item);
     */
    public function mostrar(int $id_estado)
    {
    	// Montar o SELECT ou o SQL
    	$sql = $this->pdo->prepare('SELECT * FROM estados WHERE id_estado = :id_estado LIMIT 1');
        $sql->bindParam(':id_estado', $id_estado);
    	// Executar a consulta
    	$sql->execute();
    	// Pega os dados retornados
        // Como será retornado apenas UM tabela usamos fetch. para
    	$dados = $sql->fetch(PDO::FETCH_OBJ);
    	return $dados;
    }

    /**
     * Atualiza um determinado estado
     *
     * @param array $dados   
     * @return int id - do ITEM
     * @example $Obj->editar($_POST);
     */
    public function editar(array $dados)
    {
        $sql = $this->pdo->prepare("UPDATE estados SET
                                    estado = :estado,
                                    status = :status,
                                    uf = :uf,
                                    updated_at = :updated_at                          
                                    WHERE id_estado = :id_estado
                                  ");
        // tratar os dados
        $estado = trim($dados['estado']);  
        $status = $dados['status'];  
        $uf = $dados['uf'];  
        $updated_at = date('Y-m-d H:i');
        $id_estado = $dados['id_estado'];  
        // Mesclar os dados, ou seja, 
        // atribuir os valores armazenados nas variáveis ($alguma_coisa)
        // aos parametros (:alguma_coisa)
        $sql->bindParam(':estado',$estado);    
        $sql->bindParam(':status',$status);    
        $sql->bindParam(':uf',$uf);    
        $sql->bindParam(':updated_at',$updated_at);
        $sql->bindParam(':id_estado',$id_estado);    
        // Executar o SQL
        $sql->execute();

        return $id_estado;
    }


    /**
     * Excluir ITEM
     *
     * @param integer $id_estado
     * @return void (esse metodo não retorna nada)
     */
    public function excluir(array $estado)
    {
        $id_estado = $estado['id'];
        $sql = $this->pdo->prepare('DELETE FROM estados WHERE id_estado = :id_estado');
        $sql->bindParam(':id_estado',$id_estado);
        $sql->execute();
    }

 }

?>