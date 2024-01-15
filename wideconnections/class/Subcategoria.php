<?php

class Subcategoria {

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
        $sql = $this->pdo->prepare('SELECT * FROM subcategorias ORDER BY subcategoria ASC');        
    	// executar a consulta
    	$sql->execute();
    	// Pegar os dados retornados, como Objectos estanciados
        // Como serão retornados vários tabela usamos fetchAll
    	$dados = $sql->fetchAll(PDO::FETCH_OBJ);
        // retornar os dados para um array
    	return $dados;
    }

    public function listarsubcategoria(int $id_usuario)
    {
        $sql = $this->pdo->prepare('SELECT * FROM usuarios WHERE id_usuario = :id_usuario LIMIT 1');
        $sql->bindParam(':id_usuario',$id_usuario);
        $sql->execute();
        $usuario = $sql->fetch(PDO::FETCH_OBJ);

        $sql = $this->pdo->prepare('SELECT * FROM subcategorias WHERE id_escola = :id_escola ORDER BY subcategoria ASC');
        $sql->bindParam(':id_escola',$usuario->id_escola);
        $sql->execute();
        $subcategorias = $sql->fetchAll(PDO::FETCH_OBJ);

        return $subcategorias;
    }

    public function listaradm(){
    	// montar o SELECT ou o SQL        
        $sql = $this->pdo->prepare('SELECT * FROM subcategorias ORDER BY subcategoria ASC');        
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
        $sql = $this->pdo->prepare('SELECT count(*) FROM subcategorias WHERE id_escola = :id_escola');
        $sql->bindParam(':id_escola',$dados['id_escola']);
        $sql->execute();
        $subcategorias = $sql->fetch(PDO::FETCH_OBJ);

        if($subcategorias < 5 OR $dados['nv_acesso']){

            $sql = $this->pdo->prepare('INSERT INTO subcategorias 
                                        (subcategoria, id_escola, id_usuario, created_at, updated_at)
                                        values
                                        (:subcategoria, :id_escola, :id_usuario, :created_at, :updated_at)
                                    ');

            // Tratar os dados recebidos do formulário
            // TRIM - remove os espaços antes de depois do texto
            // STRTOLOWER - transforma a STRING (str), para (to), minúsculo (lower)
            // UCFIRST - transforma o primeiro caracter (FIRST) para maiúscuo (UC Upper Case)        
            $subcategoria  = trim($dados['subcategoria']);
            $id_usuario  = ($dados['id_usuario']);
            $id_escola = $dados['id_escola'];
            $created_at = date('Y-m-d H:i');
            $updated_at = date('Y-m-d H:i');
            
            // Mesclar os dados, ou seja, 
            // atribuir os valores armazenados nas variáveis ($alguma_coisa)
            // aos parametros (:alguma_coisa)          
            $sql->bindParam(':id_usuario',$id_usuario);       
            $sql->bindParam(':id_escola',$id_escola);       
            $sql->bindParam(':subcategoria',$subcategoria);       
            $sql->bindParam(':created_at',$created_at);
            $sql->bindParam(':updated_at',$updated_at);

            // Executar o SQL
            $sql->execute();
            // Retorna o ID do ITEM, ou seja, a PK (chave primária) do item
            return $this->pdo->lastInsertId();

        }else{
            return header('location:subcategorias.php?le');
        }
    }


    /**
     * Retorna os dados de uma categoria
     * @param int $id_do_item
     * @return object
     * @example $variavel = $Obj->mostrar($id_do_item);
     */
    public function mostrar(int $id_subcategoria)
    {
    	// Montar o SELECT ou o SQL
    	$sql = $this->pdo->prepare('SELECT * FROM subcategorias WHERE id_subcategoria = :id_subcategoria LIMIT 1');
        $sql->bindParam(':id_subcategoria', $id_subcategoria);
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
        $sql = $this->pdo->prepare("UPDATE subcategorias SET
                                    subcategoria = :subcategoria,
                                    updated_at = :updated_at           
                                    WHERE id_subcategoria = :id_subcategoria
                                  ");
        // tratar os dados
        $subcategoria = trim($dados['subcategoria']);  
        $id_subcategoria = $dados['id_subcategoria'];  
        $updated_at = date('Y-m-d H:i');
        // Mesclar os dados, ou seja, 
        // atribuir os valores armazenados nas variáveis ($alguma_coisa)
        // aos parametros (:alguma_coisa)
        $sql->bindParam(':subcategoria',$subcategoria);          
        $sql->bindParam(':id_subcategoria',$id_subcategoria);    
        $sql->bindParam(':updated_at',$updated_at);
        // Executar o SQL
        $sql->execute();

        return $id_subcategoria;
    }


    /**
     * Excluir ITEM
     *
     * @param integer $id_subcategoria
     * @return void (esse metodo não retorna nada)
     */
    public function excluir(array $subcategoria)
    {
        $id_subcategoria = $subcategoria['id'];
        $sql = $this->pdo->prepare('DELETE FROM subcategorias WHERE id_subcategoria = :id_subcategoria');
        $sql->bindParam(':id_subcategoria',$id_subcategoria);
        $sql->execute();
    }

    public function verificarcategoria(int $id_subcategoria)
    {
        $sql = $this->pdo->prepare('SELECT count(id_subcategoria) FROM subcategorias WHERE id_subcategoria = :id_subcategoria');
        $sql->bindParam(':id_subcategoria',$id_subcategoria);
        $sql->execute();

        $existente = $sql->fetch(PDO::FETCH_NUM);

        return $existente[0];
    }

    public function countcategorias()
    {
        $sql = $this->pdo->prepare('SELECT count(id_subcategoria) FROM subcategorias WHERE status = 1');
        $sql->execute();

        $subcategorias = $sql->fetch(PDO::FETCH_NUM);

        return $subcategorias[0];
    }

    public function mostrarescola(int $id_escola)
    {
        $sql = $this->pdo->prepare('SELECT * FROM escolas WHERE id_escola = :id_escola LIMIT 1');
        $sql->bindParam(':id_escola',$id_escola);
        $sql->execute();

        $escola = $sql->fetch(PDO::FETCH_OBJ);

        return $escola;
    }

    public function mostrarcriador(int $id_usuario)
    {
        $sql = $this->pdo->prepare('SELECT * FROM usuarios WHERE id_usuario = :id_usuario LIMIT 1');
        $sql->bindParam(':id_usuario',$id_usuario);
        $sql->execute();

        $criador = $sql->fetch(PDO::FETCH_OBJ);

        return $criador;
    }

    public function listarmenos(int $id_subcategoria){
    	// montar o SELECT ou o SQL        
        $sql = $this->pdo->prepare('SELECT * FROM subcategorias WHERE id_subcategoria != :id_subcategoria ORDER BY subcategoria ASC');        
    	// executar a consulta
        $sql->bindParam(':id_subcategoria',$id_subcategoria);
    	$sql->execute();
    	// Pegar os dados retornados, como Objectos estanciados
        // Como serão retornados vários tabela usamos fetchAll
    	$dados = $sql->fetchAll(PDO::FETCH_OBJ);
        // retornar os dados para um array
    	return $dados;
    }

 }

?>