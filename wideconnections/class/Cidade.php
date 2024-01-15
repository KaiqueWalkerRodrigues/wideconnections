<?php

class Cidade {

    # ATRIBUTOS	
	public $pdo;
    
    public function __construct()
    {
        $this->pdo = Conexao::conexao();               
    }

    /**
     * listar todas cidades
     * @return array
     * @example $variavel = $Obj->metodo()
     */
    public function listar(){
    	// montar o SELECT ou o SQL        
        $sql = $this->pdo->prepare('SELECT * FROM cidades ORDER BY cidade DESC');        
    	// executar a consulta
    	$sql->execute();
    	// Pegar os dados retornados, como Objectos estanciados
        // Como serão retornados vários tabela usamos fetchAll
    	$dados = $sql->fetchAll(PDO::FETCH_OBJ);
        // retornar os dados para um array
    	return $dados;
    }

    public function listarpdiretor(int $id_usuario){
    	// montar o SELECT ou o SQL        

        $sql = $this->pdo->prepare('SELECT id_escola FROM usuarios WHERE id_usuario = :id_usuario LIMIT 1');
        $sql->bindParam(':id_usuario',$id_usuario);
        $sql->execute();

        $usuario = $sql->fetch(PDO::FETCH_OBJ);

        $sql = $this->pdo->prepare('SELECT id_cidade FROM escolas WHERE id_escola = :id_escola LIMIT 1');
        $sql->bindParam(':id_escola',$usuario->id_escola);
        $sql->execute();

        $escola = $sql->fetch(PDO::FETCH_OBJ);

        $sql = $this->pdo->prepare('SELECT * FROM cidades WHERE id_cidade = :id_cidade ORDER BY cidade DESC'); 
        $sql->bindParam(':id_cidade',$escola->id_cidade);       
    	// executar a consulta
    	$sql->execute();
    	// Pegar os dados retornados, como Objectos estanciados
        // Como serão retornados vários tabela usamos fetchAll
    	$dados = $sql->fetchAll(PDO::FETCH_OBJ);
        // retornar os dados para um array
    	return $dados;
    }

    /**
     * cadastra um nova cidade
     * @param Array $dados    
     * @return int
     * @example $Obj->cadastrar($_POST);
     * 
     */
    public function cadastrar(Array $dados)
    {
        $sql = $this->pdo->prepare('INSERT INTO cidades
                                    (cidade, status, id_estado, created_at, updated_at)
                                    values
                                    (:cidade, :status, :id_estado, :created_at, :updated_at)
                                 ');

        // Tratar os dados recebidos do formulário
        // TRIM - remove os espaços antes de depois do texto
        // STRTOLOWER - transforma a STRING (str), para (to), minúsculo (lower)
        // UCFIRST - transforma o primeiro caracter (FIRST) para maiúscuo (UC Upper Case)        
        $cidade  = (trim($dados['cidade']));
        $id_estado  = ($dados['id_estado']);
        $status  = ($dados['status']);
        $created_at = date('Y-m-d H:i');
        $updated_at = date('Y-m-d H:i');
         
        // Mesclar os dados, ou seja, 
        // atribuir os valores armazenados nas variáveis ($alguma_coisa)
        // aos parametros (:alguma_coisa)
        $sql->bindParam(':cidade',$cidade);          
        $sql->bindParam(':id_estado',$id_estado);          
        $sql->bindParam(':status',$status);   
        $sql->bindParam(':created_at',$created_at);
        $sql->bindParam(':updated_at',$updated_at);       

        // Executar o SQL
        $sql->execute();
        // Retorna o ID do ITEM, ou seja, a PK (chave primária) do item
        return $this->pdo->lastInsertId();
    }


    /**
     * Retorna os dados de uma cidade
     * @param int $id_do_item
     * @return object
     * @example $variavel = $Obj->mostrar($id_do_item);
     */
    public function mostrar(int $id_cidade)
    {
    	// Montar o SELECT ou o SQL
    	$sql = $this->pdo->prepare('SELECT * FROM cidades WHERE id_cidade = :id_cidade LIMIT 1');
        $sql->bindParam(':id_cidade', $id_cidade);
    	// Executar a consulta
    	$sql->execute();
    	// Pega os dados retornados
        // Como será retornado apenas UM tabela usamos fetch. para
    	$dados = $sql->fetch(PDO::FETCH_OBJ);
    	return $dados;
    }

    /**
     * Atualiza um determinada cidade
     *
     * @param array $dados   
     * @return int id - do ITEM
     * @example $Obj->editar($_POST);
     */
    public function editar(array $dados)
    {
        $sql = $this->pdo->prepare("UPDATE cidades SET
                                    cidade = :cidade,
                                    status = :status,
                                    id_estado = :id_estado,
                                    updated_at = :updated_at                         
                                    WHERE id_cidade = :id_cidade
                                  ");
        // tratar os dados
        $cidade = trim($dados['cidade']);  
        $status = $dados['status'];  
        $id_estado = $dados['id_estado'];  
        $id_cidade = $dados['id_cidade'];  
        $updated_at = date('Y-m-d H:i');
        // Mesclar os dados, ou seja, 
        // atribuir os valores armazenados nas variáveis ($alguma_coisa)
        // aos parametros (:alguma_coisa)
        $sql->bindParam(':cidade',$cidade);    
        $sql->bindParam(':status',$status);    
        $sql->bindParam(':id_estado',$id_estado);    
        $sql->bindParam(':id_cidade',$id_cidade);   
        $sql->bindParam(':updated_at',$updated_at); 
        // Executar o SQL
        $sql->execute();

        return $id_cidade;
    }


    /**
     * Excluir ITEM
     *
     * @param integer $id_cidade
     * @return void (esse metodo não retorna nada)
     */
    public function excluir(array $cidade)
    {
        $id_cidade = $cidade['id'];
        $sql = $this->pdo->prepare('DELETE FROM cidades WHERE id_cidade = :id_cidade');
        $sql->bindParam(':id_cidade',$id_cidade);
        $sql->execute();
    }

    public function mostrarestado(int $id_estado)
    {
        $sql = $this->pdo->prepare('SELECT * FROM estados WHERE id_estado = :id_estado LIMIT 1');
        $sql->bindParam(':id_estado',$id_estado);
        $sql->execute();

        $dados = $sql->fetch(PDO::FETCH_OBJ);

        return $dados;
    }

 }

?>