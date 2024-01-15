<?php

class Noticia {

    # ATRIBUTOS	
	public $pdo;
    
    public function __construct()
    {
        $this->pdo = Conexao::conexao();               
    }

    /**
     * listar todos as noticias
     * @return array
     * @example $variavel = $Obj->metodo()
     */
    public function listar(){
    	// montar o SELECT ou o SQL        
        $sql = $this->pdo->prepare('SELECT * FROM noticias ORDER BY titulo ASC');        
    	// executar a consulta
    	$sql->execute();
    	// Pegar os dados retornados, como Objectos estanciados
        // Como serão retornados vários tabela usamos fetchAll
    	$dados = $sql->fetchAll(PDO::FETCH_OBJ);
        // retornar os dados para um array
    	return $dados;
    }

    public function listarpdiretor(int $id_usuario){
        $sql = $this->pdo->prepare('SELECT * FROM usuarios WHERE id_usuario = :id_usuario LIMIT 1');  
        $sql->bindParam(':id_usuario',$id_usuario);
        $sql->execute();

        $diretor = $sql->fetch(PDO::FETCH_OBJ);
        $id_escola = $diretor->id_escola;
    	// montar o SELECT ou o SQL        
        $sql = $this->pdo->prepare('SELECT * FROM noticias WHERE id_escola = :id_escola ORDER BY titulo ASC');  
        $sql->bindParam(':id_escola',$id_escola);      
    	// executar a consulta
    	$sql->execute();
    	// Pegar os dados retornados, como Objectos estanciados
        // Como serão retornados vários tabela usamos fetchAll
    	$dados = $sql->fetchAll(PDO::FETCH_OBJ);
        // retornar os dados para um array
    	return $dados;
    }

    public function listarnoticias()
    {
        // montar o SELECT ou o SQL        
        $sql = $this->pdo->prepare('SELECT * FROM noticias WHERE status = 1 ORDER BY created_at DESC LIMIT 8');        
    	// executar a consulta
    	$sql->execute();
    	// Pegar os dados retornados, como Objectos estanciados
        // Como serão retornados vários tabela usamos fetchAll
    	$dados = $sql->fetchAll(PDO::FETCH_OBJ);
        // retornar os dados para um array
    	return $dados;
    }

    /**
     * cadastra um nova noticia
     * @param Array $dados    
     * @return int
     * @example $Obj->cadastrar($_POST);
     * 
     */
    public function cadastrar(Array $dados, $capa_enviada = null)
    {
        if (!is_null($capa_enviada)) {
            $capa = Helper::sobeArquivo($capa_enviada,'imagens/');
        }else{
            $capa = '';
        }

        $sql = $this->pdo->prepare('INSERT INTO noticias 
                                    (id_usuario, id_subcategoria, id_categoria, id_escola, serie, id_cidade, id_estado, titulo, conteudo, descricao, tempodevida, link, capa, status, created_at, updated_at)
                                    values
                                    (:id_usuario, :id_subcategoria, :id_categoria, :id_escola, :serie, :id_cidade, :id_estado, :titulo, :conteudo, :descricao, :tempodevida, :link, :capa, :status, :created_at, :updated_at)
                                 ');
        // Tratar os dados recebidos do formulário
        // TRIM - remove os espaços antes de depois do texto
        // STRTOLOWER - transforma a STRING (str), para (to), minúsculo (lower)
        // UCFIRST - transforma o primeiro caracter (FIRST) para maiúscuo (UC Upper Case)        
        $titulo  = (trim($dados['titulo']));
        $id_usuario  = ($dados['id_usuario']);
        $id_subcategoria  = ($dados['id_subcategoria']);
        $id_categoria  = ($dados['id_categoria']);
        $id_escola  = ($dados['id_escola']);
        $id_cidade  = ($dados['id_cidade']);
        $id_estado  = ($dados['id_estado']);
        $serie  = ($dados['serie']);
        $conteudo  = ($dados['conteudo']);
        $descricao  = ($dados['descricao']);
        $tempodevida  = ($dados['tempodevida']);
        $link  = ($dados['link']);
        $status  = ($dados['status']);
        $created_at = date('Y-m-d H:i:s');   
        $updated_at = date('Y-m-d H:i:s');   
         
        // Mesclar os dados, ou seja, 
        // atribuir os valores armazenados nas variáveis ($alguma_coisa)
        // aos parametros (:alguma_coisa)
        $sql->bindParam(':titulo',$titulo);          
        $sql->bindParam(':id_usuario',$id_usuario);          
        $sql->bindParam(':id_subcategoria',$id_subcategoria);          
        $sql->bindParam(':id_categoria',$id_categoria);          
        $sql->bindParam(':id_escola',$id_escola);          
        $sql->bindParam(':serie',$serie);          
        $sql->bindParam(':id_cidade',$id_cidade);          
        $sql->bindParam(':id_estado',$id_estado);          
        $sql->bindParam(':conteudo',$conteudo);          
        $sql->bindParam(':descricao',$descricao);           
        $sql->bindParam(':tempodevida',$tempodevida);                  
        $sql->bindParam(':link',$link);          
        $sql->bindParam(':capa',$capa);          
        $sql->bindParam(':status',$status);    
        $sql->bindParam(':created_at',$created_at);
        $sql->bindParam(':updated_at',$updated_at);

        // Executar o SQL
        $sql->execute();
        // Retorna o ID do ITEM, ou seja, a PK (chave primária) do item
        return $this->pdo->lastInsertId();
    }


    /**
     * Retorna os dados de uma noticia
     * @param int $id_do_item
     * @return object
     * @example $variavel = $Obj->mostrar($id_do_item);
     */
    public function mostrar(int $id_noticia)
    {
    	// Montar o SELECT ou o SQL
    	$sql = $this->pdo->prepare('SELECT * FROM noticias WHERE id_noticia = :id_noticia LIMIT 1');
        $sql->bindParam(':id_noticia', $id_noticia);
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
    public function editar(array $dados, $capa_enviada = null)
    {
        $sql = $this->pdo->prepare("UPDATE noticias SET
                                    titulo = :titulo,
                                    id_usuario = :id_usuario,
                                    id_categoria = :id_categoria,                                                    
                                    id_subcategoria = :id_subcategoria,                                                    
                                    serie = :serie,                                                   
                                    conteudo = :conteudo,  
                                    descricao = :descricao,                        
                                    tempodevida = :tempodevida,                          
                                    link = :link,  
                                    capa = :capa,                       
                                    status = :status,                      
                                    updated_at = :updated_at                        
                                    WHERE id_noticia = :id_noticia
                                  ");
        // tratar os dados
        $titulo  = (trim($dados['titulo']));
        $id_usuario  = ($dados['id_usuario']);
        $id_categoria  = ($dados['id_categoria']);
        $id_subcategoria  = ($dados['id_subcategoria']);
        $serie  = ($dados['serie']);
        $conteudo  = ($dados['conteudo']);
        $descricao = ($dados['descricao']);
        $tempodevida  = ($dados['tempodevida']);
        $link  = ($dados['link']);
        $capa_atual  = ($dados['capa_atual']); 
        $status  = ($dados['status']); 
        $updated_at = date('Y-m-d H:i:s');
        $id_noticia = $dados['id_noticia'];  

        if (!is_null($capa_enviada) && trim($capa_enviada['name']) != ''){
            $capa = Helper::sobeArquivo($capa_enviada,'imagens/');
        }else{
            $capa = $capa_atual;
        }

        // Mesclar os dados, ou seja, 
        // atribuir os valores armazenados nas variáveis ($alguma_coisa)
        // aos parametros (:alguma_coisa)
        $sql->bindParam(':titulo',$titulo);          
        $sql->bindParam(':id_usuario',$id_usuario);          
        $sql->bindParam(':id_subcategoria',$id_subcategoria);                   
        $sql->bindParam(':id_categoria',$id_categoria);                   
        $sql->bindParam(':serie',$serie);          
        $sql->bindParam(':conteudo',$conteudo);          
        $sql->bindParam(':descricao',$descricao);          
        $sql->bindParam(':tempodevida',$tempodevida);                  
        $sql->bindParam(':link',$link);          
        $sql->bindParam(':capa',$capa);   
        $sql->bindParam(':status',$status);           
        $sql->bindParam(':updated_at',$updated_at);
        $sql->bindParam(':id_noticia',$id_noticia);    
        // Executar o SQL
        $sql->execute();

        return $id_noticia;
    }

    /**
     * Excluir ITEM
     *
     * @param integer $id_estado
     * @return void (esse metodo não retorna nada)
     */
    public function excluir(array $noticia)
    {
        $id_noticia = $noticia['id'];
        $sql = $this->pdo->prepare('DELETE FROM noticias WHERE id_noticia = :id_noticia');
        $sql->bindParam(':id_noticia',$id_noticia);
        $sql->execute();
    }

    public function mostrarescritor(int $id_usuario)
    {
        $sql = $this->pdo->prepare('SELECT nome FROM usuarios WHERE id_usuario = :id_usuario LIMIT 1');
        $sql->bindParam(':id_usuario',$id_usuario);
        $sql->execute();
        $usuario = $sql->fetch(PDO::FETCH_OBJ);
    	return $usuario;
    }

    public function mostrarcategoria(int $id_categoria)
    {
        $sql = $this->pdo->prepare('SELECT categoria FROM categorias WHERE id_categoria = :id_categoria LIMIT 1');
        $sql->bindParam(':id_categoria',$id_categoria);
        $sql->execute();
        $categoria = $sql->fetch(PDO::FETCH_OBJ);
    	return $categoria;
    }

    public function mostrarsubcategoria(int $id_subcategoria)
    {
        $sql = $this->pdo->prepare('SELECT subcategoria FROM subcategorias WHERE id_subcategoria = :id_subcategoria LIMIT 1');
        $sql->bindParam(':id_subcategoria',$id_subcategoria);
        $sql->execute();
        $categoria = $sql->fetch(PDO::FETCH_OBJ);
    	return $categoria;
    }

    public function mostrarescola(int $id_escola)
    {
        $sql = $this->pdo->prepare('SELECT escola FROM escolas WHERE id_escola = :id_escola LIMIT 1');
        $sql->bindParam(':id_escola',$id_escola);
        $sql->execute();
        $escola = $sql->fetch(PDO::FETCH_OBJ);
    	return $escola;
    }

    public function encontrarcidade(int $id_escola)
    {
        $sql = $this->pdo->prepare('SELECT id_cidade FROM escolas WHERE id_escola = :id_escola LIMIT 1');
        $sql->bindParam(':id_escola',$id_escola);
        $sql->execute();
        $cidade = $sql->fetch(PDO::FETCH_NUM);
    	return $cidade[0];  
    }

    public function buscarcidade(int $id_escola)
    {
        $sql = $this->pdo->prepare('SELECT * FROM escolas WHERE id_escola = :id_escola LIMIT 1');
        $sql->bindParam(':id_escola',$id_escola);
        $sql->execute();
        $escola = $sql->fetch(PDO::FETCH_OBJ);

        $sql = $this->pdo->prepare('SELECT * FROM cidade WHERE id_cidade = :id_cidade LIMIT 1');
        $sql->bindParam(':id_cidade',$escola->id_cidade);
        $sql->execute();
        $cidade = $sql->fetch(PDO::FETCH_OBJ);

        return $cidade;
    }

    public function mostrarcidade(int $id_cidade)
    {
        $sql = $this->pdo->prepare('SELECT cidade FROM cidades WHERE id_cidade = :id_cidade LIMIT 1');
        $sql->bindParam(':id_cidade',$id_cidade);
        $sql->execute();
        $cidade = $sql->fetch(PDO::FETCH_OBJ);
    	return $cidade;
    }

    public function encontrarestado(int $id_cidade)
    {
        $sql = $this->pdo->prepare('SELECT id_estado FROM cidades WHERE id_cidade = :id_cidade LIMIT 1');
        $sql->bindParam(':id_cidade',$id_cidade);
        $sql->execute();
        $estado = $sql->fetch(PDO::FETCH_NUM);
    	return $estado[0];
    }

    public function mostrarestado(int $id_estado)
    {
        $sql = $this->pdo->prepare('SELECT estado FROM estados WHERE id_estado = :id_estado LIMIT 1');
        $sql->bindParam(':id_estado',$id_estado);
        $sql->execute();
        $estado = $sql->fetch(PDO::FETCH_OBJ);
    	return $estado;
    }

    public function countnoticias()
    {
        $sql = $this->pdo->prepare('SELECT count(id_noticia) FROM noticias WHERE status = 1');
        $sql->execute();

        $count = $sql->fetch(PDO::FETCH_NUM);

        return $count[0];
    }

    public function visualizar(int $id_usuario, int $id_noticia)
    {
        $sql = $this->pdo->prepare('SELECT count(id_view_usuario) FROM views_usuarios WHERE id_usuario = :id_usuario AND id_noticia = :id_noticia');
        $sql->bindParam(':id_usuario',$id_usuario);
        $sql->bindParam(':id_noticia',$id_noticia);
        $sql->execute();
        
        $view = $sql->fetch(PDO::FETCH_NUM);
        
        if($view[0] == 0){
            $sql = $this->pdo->prepare('INSERT INTO views_usuarios (id_usuario, id_noticia) VALUES (:id_usuario, :id_noticia)');
            $sql->bindParam(':id_usuario',$id_usuario);
            $sql->bindParam(':id_noticia',$id_noticia);
            $sql->execute();
        }
    }
    
    public function contarviews(int $id_noticia)
    {
        $sql = $this->pdo->prepare('SELECT count(id_view_usuario) FROM views_usuarios WHERE id_noticia = :id_noticia');
        $sql->bindParam(':id_noticia',$id_noticia);
        $sql->execute();
        
        $view = $sql->fetch(PDO::FETCH_NUM);

        return $view[0];
    }

    public function curtir(int $id_usuario, int $id_noticia)
    {
        $sql = $this->pdo->prepare('SELECT * FROM likes_usuarios WHERE id_usuario = :id_usuario AND id_noticia = :id_noticia');
        $sql->bindParam(':id_usuario',$id_usuario);
        $sql->bindParam(':id_noticia',$id_noticia);
        $sql->execute();
        
        $curtida = $sql->fetch(PDO::FETCH_OBJ);

        if(!isset($curtida->id_like_usuario)){
            $sql = $this->pdo->prepare('INSERT INTO likes_usuarios (id_usuario, id_noticia, curtida) VALUES (:id_usuario, :id_noticia, 1)');
            $sql->bindParam(':id_usuario',$id_usuario);
            $sql->bindParam(':id_noticia',$id_noticia);
            $sql->execute();
        }else{
            if($curtida->curtida == 0){
                $like = 1;
            }else{ $like = 0; }
            $sql = $this->pdo->prepare('UPDATE likes_usuarios SET curtida = :like WHERE id_like_usuario = :id_like_usuario');
            $sql->bindParam(':id_like_usuario',$curtida->id_like_usuario);
            $sql->bindParam(':like',$like);
            $sql->execute();
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;

        // return header('location:noticia.php?id='.$id_noticia);
    }

    public function contarlikes(int $id_noticia)
    {
        $sql = $this->pdo->prepare('SELECT count(id_like_usuario) FROM likes_usuarios WHERE id_noticia = :id_noticia');
        $sql->bindParam(':id_noticia',$id_noticia);
        $sql->execute();
        
        $like = $sql->fetch(PDO::FETCH_NUM);

        return $like[0];
    }

    public function verificarlike(int $id_noticia,int $id_usuario)
    {
        $sql = $this->pdo->prepare('SELECT curtida FROM likes_usuarios WHERE id_usuario = :id_usuario AND id_noticia = :id_noticia');
        $sql->bindParam(':id_usuario',$id_usuario);
        $sql->bindParam(':id_noticia',$id_noticia);
        $sql->execute();

        $curtida = $sql->fetch(PDO::FETCH_NUM);
        if(!isset($curtida[0])){
            return 0;
        }else if($curtida[0] == 1){
            return 1;
        }else{
            return 0;
        };
    }

    public function listardacategoria(int $id_categoria)
    {
        $sql = $this->pdo->prepare('SELECT * FROM noticias WHERE id_categoria = :id_categoria AND id_estado = 0 AND id_cidade = 0 AND id_escola = 0 AND status = 1 ORDER BY created_at limit 20');
        $sql->bindParam(':id_categoria',$id_categoria);
        $sql->execute();

        $noticias = $sql->fetchAll(PDO::FETCH_OBJ);

        return $noticias;
    }

    // Lista

    public function listarnoticiaspublicas()
    {
        // montar o SELECT ou o SQL        
        $sql = $this->pdo->prepare('SELECT * FROM noticias WHERE status = 1 AND id_escola = 0 AND id_cidade = 0 AND id_estado = 0 AND status = 1 ORDER BY created_at DESC LIMIT 20;');        
    	// executar a consulta
    	$sql->execute();
    	// Pegar os dados retornados, como Objectos estanciados
        // Como serão retornados vários tabela usamos fetchAll
    	$dados = $sql->fetchAll(PDO::FETCH_OBJ);
        // retornar os dados para um array
    	return $dados;
    }

    public function listarnoticiasescola(int $id_usuario)
    {
        $sql = $this->pdo->prepare('SELECT * FROM usuarios WHERE id_usuario = :id_usuario LIMIT 1');
        $sql->bindParam('id_usuario',$id_usuario);
        $sql->execute();
        $usuario = $sql->fetch(PDO::FETCH_OBJ);

        // Se for administrador
        if($usuario->nv_acesso == 5 OR $usuario->nv_acesso == 3){

        $sql = $this->pdo->prepare('SELECT * FROM noticias WHERE id_escola != 0 AND status = 1 ORDER BY created_at LIMIT 12');
        $sql->execute();
        $noticias = $sql->fetchAll(PDO::FETCH_OBJ);
        return $noticias;

        }elseif($usuario->nv_acesso == 2 OR $usuario->nv_acesso == 4){
            //Visão Professor e Diretor
            $sql = $this->pdo->prepare('SELECT * FROM noticias WHERE id_escola = :id_escola AND status = 1 ORDER BY created_at LIMIT 12');
            $sql->bindParam(':id_escola',$usuario->id_escola);
            $sql->execute();
            $noticias = $sql->fetchAll(PDO::FETCH_OBJ);
            return $noticias;
        }
        {

        $sql = $this->pdo->prepare('SELECT * FROM noticias WHERE id_escola = :id_escola AND status = 1 AND serie = :serie OR id_escola = :id_escola AND status = 1 AND serie = 0 ORDER BY created_at LIMIT 12');
        $sql->bindParam(':serie',$usuario->serie);
        $sql->bindParam(':id_escola',$usuario->id_escola);
        $sql->execute();
        $noticias = $sql->fetchAll(PDO::FETCH_OBJ);
        return $noticias;

        }
    }

    public function listarnoticiasescolaescolar(int $id_usuario, int $id_subcategoria)
    {
        $sql = $this->pdo->prepare('SELECT id_escola,nv_acesso,serie FROM usuarios WHERE id_usuario = :id_usuario');
        $sql->bindParam('id_usuario',$id_usuario);
        $sql->execute();
        $id_escola = $sql->fetch(PDO::FETCH_NUM);

        if($id_escola[1] == 5 OR $id_escola[1] == 3){

        $sql = $this->pdo->prepare('SELECT * FROM noticias WHERE id_subcategoria = :id_subcategoria AND id_escola != 0 AND status = 1 ORDER BY created_at LIMIT 12');
        $sql->bindParam(':id_subcategoria',$id_subcategoria);
        $sql->execute();
        $noticias = $sql->fetchAll(PDO::FETCH_OBJ);
        return $noticias;

        }elseif($id_escola[1] == 2 OR $id_escola[1] == 4){
            $sql = $this->pdo->prepare('SELECT * FROM noticias WHERE id_subcategoria = :id_subcategoria AND id_escola = :id_escola AND status = 1 ORDER BY created_at LIMIT 12');
            $sql->bindParam(':id_escola',$id_escola[0]);
            $sql->bindParam(':id_subcategoria',$id_subcategoria);
            $sql->execute();
            $noticias = $sql->fetchAll(PDO::FETCH_OBJ);
            return $noticias;
        }
        {

        $sql = $this->pdo->prepare('SELECT * FROM noticias WHERE id_subcategoria = :id_subcategoria AND id_escola = :id_escola AND status = 1 AND serie = :serie OR  id_subcategoria = :id_subcategoria AND id_escola = :id_escola AND status = 1 AND serie = 0 ORDER BY created_at LIMIT 12');
        $sql->bindParam(':serie',$id_escola[2]);
        $sql->bindParam(':id_escola',$id_escola[0]);
        $sql->bindParam(':id_subcategoria',$id_subcategoria);
        $sql->execute();
        $noticias = $sql->fetchAll(PDO::FETCH_OBJ);
        return $noticias;

        }
    }

    public function listarnoticiascidade(int $id_usuario)
    {
        $sql = $this->pdo->prepare('SELECT id_escola,nv_acesso FROM usuarios WHERE id_usuario = :id_usuario');
        $sql->bindParam('id_usuario',$id_usuario);
        $sql->execute();
        $id_escola = $sql->fetch(PDO::FETCH_NUM);
        $Noticia = new Noticia();

        
        //Se o cargo do usuario for igual a admin mostra todas as noticias de escolas
        if($id_escola[1] == 5  OR $id_escola[1] == 3){
            
            $sql = $this->pdo->prepare('SELECT * FROM noticias WHERE id_escola = 0 AND id_cidade != 0 AND status = 1 ORDER BY created_at LIMIT 12');
            $sql->execute();
            $noticias = $sql->fetchAll(PDO::FETCH_OBJ);
            return $noticias;
            
        }else{
        //Encontra o id da cidade do Usuario
        $id_cidade = $Noticia->encontrarcidade($id_escola[0]);

        $sql = $this->pdo->prepare('SELECT * FROM noticias WHERE id_escola = 0 AND id_cidade = :id_cidade AND status = 1 ORDER BY created_at LIMIT 12');
        $sql->bindParam(':id_cidade',$id_cidade);
        $sql->execute();
        $noticias = $sql->fetchAll(PDO::FETCH_OBJ);
        return $noticias;
        }
    }

    public function listarnoticiascidadeescolar(int $id_usuario, int $id_subcategoria)
    {
        $sql = $this->pdo->prepare('SELECT id_escola,nv_acesso FROM usuarios WHERE id_usuario = :id_usuario');
        $sql->bindParam('id_usuario',$id_usuario);
        $sql->execute();
        $id_escola = $sql->fetch(PDO::FETCH_NUM);
        $Noticia = new Noticia();

        
        //Se o cargo do usuario for igual a admin mostra todas as noticias de escolas
        if($id_escola[1] == 5 OR $id_escola[1] == 3){
            
            $sql = $this->pdo->prepare('SELECT * FROM noticias WHERE id_subcategoria = :id_subcategoria AND id_escola = 0 AND id_cidade != 0 AND status = 1 ORDER BY created_at LIMIT 12');
            $sql->bindParam(':id_subcategoria',$id_subcategoria);
            $sql->execute();
            $noticias = $sql->fetchAll(PDO::FETCH_OBJ);
            return $noticias;
            
        }else{
        //Encontra o id da cidade do Usuario
        $id_cidade = $Noticia->encontrarcidade($id_escola[0]);

        $sql = $this->pdo->prepare('SELECT * FROM noticias WHERE id_subcategoria = :id_subcategoria AND id_escola = 0 AND id_cidade = :id_cidade AND status = 1 ORDER BY created_at LIMIT 12');
        $sql->bindParam(':id_cidade',$id_cidade);
        $sql->bindParam(':id_subcategoria',$id_subcategoria);
        $sql->execute();
        $noticias = $sql->fetchAll(PDO::FETCH_OBJ);
        return $noticias;
        }
    }

    public function listarnoticiasestado(int $id_usuario)
    {
        $sql = $this->pdo->prepare('SELECT id_escola,nv_acesso FROM usuarios WHERE id_usuario = :id_usuario');
        $sql->bindParam('id_usuario',$id_usuario);
        $sql->execute();
        $id_escola = $sql->fetch(PDO::FETCH_NUM);

        $Noticia = new Noticia();

        
        //Se o cargo do usuario for igual a admin mostra todas as noticias de escolas
        if($id_escola[1] == 5  OR $id_escola[1] == 3){
            
            $sql = $this->pdo->prepare('SELECT * FROM noticias WHERE id_escola = 0 AND id_cidade = 0 AND id_estado != 0 AND status = 1 ORDER BY created_at LIMIT 12');
            $sql->execute();
            $noticias = $sql->fetchAll(PDO::FETCH_OBJ);
            return $noticias;
            
        }else{
        //encontrar o id da cidade do usuario
        $id_cidade = $Noticia->encontrarcidade($id_escola[0]);
        //encontrar o id do estado do usuario
        $id_estado = $Noticia->encontrarestado($id_cidade);

        $sql = $this->pdo->prepare('SELECT * FROM noticias WHERE id_escola = 0 AND id_cidade = 0 AND id_estado = :id_estado AND status = 1 ORDER BY created_at LIMIT 12');
        $sql->bindParam(':id_estado',$id_estado);
        $sql->execute();
        $noticias = $sql->fetchAll(PDO::FETCH_OBJ);
        return $noticias;

        }
    }

    public function listarnoticiasestadoescolar(int $id_usuario, int $id_subcategoria)
    {
        $sql = $this->pdo->prepare('SELECT id_escola,nv_acesso FROM usuarios WHERE id_usuario = :id_usuario');
        $sql->bindParam('id_usuario',$id_usuario);
        $sql->execute();
        $id_escola = $sql->fetch(PDO::FETCH_NUM);

        $Noticia = new Noticia();

        
        //Se o cargo do usuario for igual a admin mostra todas as noticias de escolas
        if($id_escola[1] == 5  OR $id_escola[1] == 3){
            
            $sql = $this->pdo->prepare('SELECT * FROM noticias WHERE id_subcategoria = :id_subcategoria AND id_escola = 0 AND id_cidade = 0 AND id_estado != 0 AND status = 1 ORDER BY created_at LIMIT 12');
            $sql->bindParam(':id_subcategoria',$id_subcategoria);
            $sql->execute();
            $noticias = $sql->fetchAll(PDO::FETCH_OBJ);
            return $noticias;
            
        }else{
        //encontrar o id da cidade do usuario
        $id_cidade = $Noticia->encontrarcidade($id_escola[0]);
        //encontrar o id do estado do usuario
        $id_estado = $Noticia->encontrarestado($id_cidade);

        $sql = $this->pdo->prepare('SELECT * FROM noticias WHERE id_subcategoria = :id_subcategoria AND id_escola = 0 AND id_cidade = 0 AND id_estado = :id_estado AND status = 1 ORDER BY created_at LIMIT 12');
        $sql->bindParam(':id_estado',$id_estado);
        $sql->bindParam(':id_subcategoria',$id_subcategoria);
        $sql->execute();
        $noticias = $sql->fetchAll(PDO::FETCH_OBJ);
        return $noticias;

        }
    }

    // End Lista

    public function maislidas()
    {
        $sql = $this->pdo->prepare('SELECT *,count(titulo) as contador FROM noticias INNER JOIN views_usuarios ON noticias.id_noticia = views_usuarios.id_noticia WHERE id_escola = 0 AND id_cidade = 0 AND id_estado = 0 AND status = 1 GROUP BY titulo ORDER BY contador DESC LIMIT 2;');
        $sql->execute();
        $maislidas = $sql-> fetchAll(PDO::FETCH_OBJ);
        return $maislidas;
    }

    public function excExpiradas()
    {
        $hoje = new DateTime(date('d-m-Y'));
        $sql = $this->pdo->prepare('SELECT * FROM noticias WHERE tempodevida != "0000-00-00"');
        $sql->execute();
        $noticias = $sql->fetchAll(PDO::FETCH_OBJ);

        foreach($noticias as $noticia){
            $tempodevida = new DateTime($noticia->tempodevida);
            if($hoje > $tempodevida){
                $sql = $this->pdo->prepare('DELETE FROM noticias WHERE id_noticia = :id_noticia');
                $sql->bindParam(':id_noticia',$noticia->id_noticia);
                $sql->execute();
            }
        }
    }

 }
//By Kaique R. Souza
?>

