<?php

class Escola {

    # ATRIBUTOS	
	public $pdo;
    
    public function __construct()
    {
        $this->pdo = Conexao::conexao();               
    }

    /**
     * listar todos as escolas
     * @return array
     * @example $variavel = $Obj->metodo()
     */
    public function listar(){
    	// montar o SELECT ou o SQL        
        $sql = $this->pdo->prepare('SELECT * FROM escolas ORDER BY escola DESC');        
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
        $sql = $this->pdo->prepare('SELECT * FROM usuarios WHERE id_usuario = :id_usuario LIMIT 1');  
        $sql->bindParam(':id_usuario',$id_usuario);
        $sql->execute();

        $diretor = $sql->fetch(PDO::FETCH_OBJ);
        $id_escola = $diretor->id_escola;

        $sql = $this->pdo->prepare('SELECT * FROM escolas WHERE id_escola = :id_escola ORDER BY escola DESC');    
        $sql->bindParam(':id_escola',$id_escola);    
    	// executar a consulta
    	$sql->execute();
    	// Pegar os dados retornados, como Objectos estanciados
        // Como serão retornados vários tabela usamos fetchAll
    	$dados = $sql->fetchAll(PDO::FETCH_OBJ);
        // retornar os dados para um array
    	return $dados;
    }

    /**
     * cadastra uma nova escola
     * @param Array $dados    
     * @return int
     * @example $Obj->cadastrar($_POST);
     * 
     */
    public function cadastrar(Array $dados)
    {
        $sql = $this->pdo->prepare('INSERT INTO escolas 
                                    (escola, codigo, id_cidade, status, created_at, updated_at)
                                    values
                                    (:escola, :codigo, :id_cidade, :status, :created_at, :updated_at)
                                 ');

        // Tratar os dados recebidos do formulário
        // TRIM - remove os espaços antes de depois do texto
        // STRTOLOWER - transforma a STRING (str), para (to), minúsculo (lower)
        // UCFIRST - transforma o primeiro caracter (FIRST) para maiúscuo (UC Upper Case)        
        $escola  = (trim($dados['escola']));
        $codigo  = (trim($dados['codigo']));
        $id_cidade  = $dados['id_cidade'];          
        $status  = $dados['status'];          
        $created_at = date('Y-m-d H:i');
        $updated_at = date('Y-m-d H:i');

        // Mesclar os dados, ou seja, 
        // atribuir os valores armazenados nas variáveis ($alguma_coisa)
        // aos parametros (:alguma_coisa)
        $sql->bindParam(':escola',$escola);
        $sql->bindParam(':codigo',$codigo);                          
        $sql->bindParam(':id_cidade',$id_cidade);                         
        $sql->bindParam(':status',$status);
        $sql->bindParam(':created_at',$created_at);
        $sql->bindParam(':updated_at',$updated_at);                       
               
        // Executar o SQL
        $sql->execute();
        // Retorna o ID do ITEM, ou seja, a PK (chave primária) do item
        return $this->pdo->lastInsertId();
    }


    /**
     * Retorna os dados de um ITEM
     * @param int $id_do_item
     * @return object
     * @example $variavel = $Obj->mostrar($id_do_item);
     */
    public function mostrar(int $id_escola)
    {
    	// Montar o SELECT ou o SQL
    	$sql = $this->pdo->prepare('SELECT * FROM escolas WHERE id_escola = :id_escola LIMIT 1');
        $sql->bindParam(':id_escola', $id_escola);
    	// Executar a consulta
    	$sql->execute();
    	// Pega os dados retornados
        // Como será retornado apenas UM tabela usamos fetch. para
    	$dados = $sql->fetch(PDO::FETCH_OBJ);
    	return $dados;
    }

    /**
     * Atualiza um determinada escola
     *
     * @param array $dados   
     * @return int id - do ITEM
     * @example $Obj->editar($_POST);
     */
    public function editar(array $dados)
    {
        $sql = $this->pdo->prepare("UPDATE escolas SET
                                    escola = :escola,
                                    codigo = :codigo,                                   
                                    id_cidade = :id_cidade,
                                    status = :status,
                                    updated_at = :updated_at                           
                                    WHERE id_escola = :id_escola
                                  ");
        // tratar os dados
        $escola = trim($dados['escola']);
        $codigo = $dados['codigo'];        
        $id_cidade = $dados['id_cidade'];
        $status = $dados['status'];
        $id_escola = $dados['id_escola'];
        $updated_at = date('Y-m-d H:i');
        // Mesclar os dados, ou seja, 
        // atribuir os valores armazenados nas variáveis ($alguma_coisa)
        // aos parametros (:alguma_coisa)
        $sql->bindParam(':escola',$escola);
        $sql->bindParam(':codigo',$codigo);              
        $sql->bindParam(':id_cidade', $id_cidade);   
        $sql->bindParam(':status', $status);   
        $sql->bindParam(':updated_at',$updated_at);
        $sql->bindParam('id_escola',$id_escola);
        // Executar o SQL
        $sql->execute();

        return $id_escola;
    }


    /**
     * Excluir escola
     *
     * @param integer $id_escola
     * @return void (esse metodo não retorna nada)
     */
    public function excluir(array $escola)
    {
        $id_escola = $escola['id'];
        $sql = $this->pdo->prepare('DELETE FROM escolas WHERE id_escola = :id_escola');
        $sql->bindParam(':id_escola',$id_escola);
        $sql->execute();
    }

    public function encontrarcidade(int $id_escola)
    {
        $sql = $this->pdo->prepare('SELECT id_cidade FROM escolas WHERE id_escola = :id_escola LIMIT 1');
        $sql->bindparam(':id_escola',$id_escola);
        $sql->execute();
        $cidade = $sql->fetch(PDO::FETCH_NUM);
        return $cidade[0];
    }

    public function mostrarcidade(int $id_cidade)
    {
        $sql = $this->pdo->prepare('SELECT * FROM cidades WHERE id_cidade = :id_cidade LIMIT 1');
        $sql->bindParam(':id_cidade',$id_cidade);
        $sql->execute();

        $dados = $sql->fetch(PDO::FETCH_OBJ);

        return $dados;
    }

    public function encontrarestado(int $id_cidade)
    {
        $sql = $this->pdo->prepare('SELECT id_estado FROM cidades WHERE id_cidade = :id_cidade LIMIT 1');
        $sql->bindparam(':id_cidade',$id_cidade);
        $sql->execute();
        $estado = $sql->fetch(PDO::FETCH_NUM);
        return $estado[0];
    }

    public function mostrarestado(int $id_estado)
    {
        $sql = $this->pdo->prepare('SELECT * FROM estados WHERE id_estado = :id_estado LIMIT 1');
        $sql->bindParam(':id_estado',$id_estado);
        $sql->execute();

        $dados = $sql->fetch(PDO::FETCH_OBJ);

        return $dados;
    }

    public function countescolasativas()
    {
        $sql = $this->pdo->prepare('SELECT count(id_escola) FROM escolas WHERE status = 1');
        $sql->execute();
        
        $count = $sql->fetch(PDO::FETCH_NUM);

        return $count[0];
    }

 }

?>