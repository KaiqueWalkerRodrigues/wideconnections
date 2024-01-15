<?php

class Categoria {

    # ATRIBUTOS	
	public $pdo;
    
    public function __construct()
    {
        $this->pdo = Conexao::conexao();               
    }

    /**
     * listar todas as categorias
     * @return array
     * @example $variavel = $Obj->metodo()
     */
    public function listar(){
    	// montar o SELECT ou o SQL        
        $sql = $this->pdo->prepare('SELECT * FROM categorias WHERE status = 1 ORDER BY categoria ASC');        
    	// executar a consulta
    	$sql->execute();
    	// Pegar os dados retornados, como Objectos estanciados
        // Como serão retornados vários tabela usamos fetchAll
    	$dados = $sql->fetchAll(PDO::FETCH_OBJ);
        // retornar os dados para um array
    	return $dados;
    }

    public function listarmenos(int $id_categoria){
    	// montar o SELECT ou o SQL        
        $sql = $this->pdo->prepare('SELECT * FROM categorias WHERE id_categoria != :id_categoria AND status = 1 ORDER BY categoria ASC');        
    	// executar a consulta
        $sql->bindParam(':id_categoria',$id_categoria);
    	$sql->execute();
    	// Pegar os dados retornados, como Objectos estanciados
        // Como serão retornados vários tabela usamos fetchAll
    	$dados = $sql->fetchAll(PDO::FETCH_OBJ);
        // retornar os dados para um array
    	return $dados;
    }

    public function listaradm(){
    	// montar o SELECT ou o SQL        
        $sql = $this->pdo->prepare('SELECT * FROM categorias ORDER BY categoria ASC');        
    	// executar a consulta
    	$sql->execute();
    	// Pegar os dados retornados, como Objectos estanciados
        // Como serão retornados vários tabela usamos fetchAll
    	$dados = $sql->fetchAll(PDO::FETCH_OBJ);
        // retornar os dados para um array
    	return $dados;
    }

    /**
     * cadastra um nova categoria
     * @param Array $dados    
     * @return int
     * @example $Obj->cadastrar($_POST);
     * 
     */
    public function cadastrar(Array $dados)
    {
        $sql = $this->pdo->prepare('INSERT INTO categorias 
                                    (categoria, status, created_at, updated_at)
                                    values
                                    (:categoria, :status, :created_at, :updated_at)
                                 ');

        // Tratar os dados recebidos do formulário
        // TRIM - remove os espaços antes de depois do texto
        // STRTOLOWER - transforma a STRING (str), para (to), minúsculo (lower)
        // UCFIRST - transforma o primeiro caracter (FIRST) para maiúscuo (UC Upper Case)        
        $categoria  = trim($dados['categoria']);
        $status  = ($dados['status']);
        $created_at = date('Y-m-d H:i');
        $updated_at = date('Y-m-d H:i');
         
        // Mesclar os dados, ou seja, 
        // atribuir os valores armazenados nas variáveis ($alguma_coisa)
        // aos parametros (:alguma_coisa)
        $sql->bindParam(':categoria',$categoria);          
        $sql->bindParam(':status',$status);       
        $sql->bindParam(':created_at',$created_at);
        $sql->bindParam(':updated_at',$updated_at);

        // Executar o SQL
        $sql->execute();
        // Retorna o ID do ITEM, ou seja, a PK (chave primária) do item
        return $this->pdo->lastInsertId();
    }


    /**
     * Retorna os dados de uma categoria
     * @param int $id_do_item
     * @return object
     * @example $variavel = $Obj->mostrar($id_do_item);
     */
    public function mostrar(int $id_categoria)
    {
    	// Montar o SELECT ou o SQL
    	$sql = $this->pdo->prepare('SELECT * FROM categorias WHERE id_categoria = :id_categoria LIMIT 1');
        $sql->bindParam(':id_categoria', $id_categoria);
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
        $sql = $this->pdo->prepare("UPDATE categorias SET
                                    categoria = :categoria,
                                    status = :status,
                                    updated_at = :updated_at           
                                    WHERE id_categoria = :id_categoria
                                  ");
        // tratar os dados
        $categoria = trim($dados['categoria']);  
        $status = $dados['status'];    
        $id_categoria = $dados['id_categoria'];  
        $updated_at = date('Y-m-d H:i');
        // Mesclar os dados, ou seja, 
        // atribuir os valores armazenados nas variáveis ($alguma_coisa)
        // aos parametros (:alguma_coisa)
        $sql->bindParam(':categoria',$categoria);    
        $sql->bindParam(':status',$status);       
        $sql->bindParam(':id_categoria',$id_categoria);    
        $sql->bindParam(':updated_at',$updated_at);
        // Executar o SQL
        $sql->execute();

        return $id_categoria;
    }


    /**
     * Excluir ITEM
     *
     * @param integer $id_categoria
     * @return void (esse metodo não retorna nada)
     */
    public function excluir(array $categoria)
    {
        $id_categoria = $categoria['id'];
        $sql = $this->pdo->prepare('DELETE FROM categorias WHERE id_categoria = :id_categoria');
        $sql->bindParam(':id_categoria',$id_categoria);
        $sql->execute();
    }

    public function verificarcategoria(int $id_categoria)
    {
        $sql = $this->pdo->prepare('SELECT count(id_categoria) FROM categorias WHERE id_categoria = :id_categoria');
        $sql->bindParam(':id_categoria',$id_categoria);
        $sql->execute();

        $existente = $sql->fetch(PDO::FETCH_NUM);

        return $existente[0];
    }

    public function countcategorias()
    {
        $sql = $this->pdo->prepare('SELECT count(id_categoria) FROM categorias WHERE status = 1');
        $sql->execute();

        $categorias = $sql->fetch(PDO::FETCH_NUM);

        return $categorias[0];
    }

 }

?>