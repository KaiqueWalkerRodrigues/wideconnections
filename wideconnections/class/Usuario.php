<?php

class Usuario {

    # ATRIBUTOS	
	public $pdo;
    
    public function __construct()
    {
        $this->pdo = Conexao::conexao();               
    }

    /**
     * listar todos os usuarios
     * @return array
     * @example $variavel = $Obj->metodo()
     */
    public function listar(){
    	// montar o SELECT ou o SQL        
        $sql = $this->pdo->prepare('SELECT * FROM usuarios ORDER BY nome DESC');        
    	// executar a consulta
    	$sql->execute();
    	// Pegar os dados retornados, como Objectos estanciados
        // Como serão retornados vários tabela usamos fetchAll
    	$dados = $sql->fetchAll(PDO::FETCH_OBJ);
        // retornar os dados para um array
    	return $dados;
    }

    /**
     * listar todos os usuarios
     * @return array
     * @example $variavel = $Obj->metodo()
     */
    public function listarpdiretor($id_usuario){
    	// montar o SELECT ou o SQL      
        $sql = $this->pdo->prepare('SELECT * FROM usuarios WHERE id_usuario = :id_usuario LIMIT 1');  
        $sql->bindParam(':id_usuario',$id_usuario);
        $sql->execute();

        $diretor = $sql->fetch(PDO::FETCH_OBJ);

        $sql = $this->pdo->prepare('SELECT * FROM usuarios WHERE id_escola = :id_escola ORDER BY nome DESC');   
        $sql->bindParam(':id_escola',$diretor->id_escola);     
    	// executar a consulta
    	$sql->execute();
    	// Pegar os dados retornados, como Objectos estanciados
        // Como serão retornados vários tabela usamos fetchAll
    	$dados = $sql->fetchAll(PDO::FETCH_OBJ);
        // retornar os dados para um array
    	return $dados;
    }

    /**
     * cadastra um novo usuario
     * @param Array $dados    
     * @return int
     * @example $Obj->cadastrar($_POST);
     * 
     */
    public function cadastrar(Array $dados)
    {
        $Usuario = new Usuario();

        $sql = $this->pdo->prepare('INSERT INTO usuarios 
                                    (nome, email, nv_acesso, senha, serie, codigo, id_escola, status, auth,created_at, updated_at)
                                    values
                                    (:nome, :email, :nv_acesso, :senha, :serie, :codigo, :id_escola, :status, :auth,:created_at, :updated_at)
                                 ');

        // Tratar os dados recebidos do formulário
        // TRIM - remove os espaços antes de depois do texto
        // STRTOLOWER - transforma a STRING (str), para (to), minúsculo (lower)
        // UCFIRST - transforma o primeiro caracter (FIRST) para maiúscuo (UC Upper Case)        
        $nome  = (trim($dados['nome']));
        $email  = (trim($dados['email']));
        $nv_acesso  = 1;  
        $serie = ($dados['serie']);
        $codigo = ($dados['codigo']);
        $created_at = date('Y-m-d H:i');
        $updated_at = date('Y-m-d H:i');
        $id_escola = $Usuario->buscarcodigo($dados['codigo']);
        $auth = Helper::generateauth();
        $status = 0;

        if($id_escola > 0)
        {

        //Um valor qualquer para ser usado como
        //chave na criptografia
        $salt = 'Jot@'; 

        //Retorna o valor recebido comp parâmetro,
        //usando a função CRYPT e o SALT
        $senha = crypt($dados['senha'], $salt);
         

        // Mesclar os dados, ou seja, 
        // atribuir os valores armazenados nas variáveis ($alguma_coisa)
        // aos parametros (:alguma_coisa)
        $sql->bindParam(':nome',$nome);
        $sql->bindParam(':email', $email);
        $sql->bindParam(':nv_acesso',$nv_acesso);              
        $sql->bindParam(':senha',$senha);              
        $sql->bindParam(':serie',$serie);              
        $sql->bindParam(':codigo',$codigo);              
        $sql->bindParam(':id_escola',$id_escola);              
        $sql->bindParam(':auth',$auth);              
        $sql->bindParam(':status',$status);              
        $sql->bindParam(':created_at',$created_at);
        $sql->bindParam(':updated_at',$updated_at);

        // Retorna o ID do ITEM, ou seja, a PK (chave primária) do item

        // Autentificação

            require("phpmailer/class.phpmailer.php");

            $mail = new PHPMailer();

            $mail->IsSMTP(); // Define que a mensagem será SMTP
            $mail->Host = "smtp.wideconnections.com.br"; // Endereço do servidor SMTP
            $mail->SMTPAuth = true; // Autenticação
            $mail->Username = 'suporte@wideconnections.com.br'; // Usuário do servidor SMTP
            $mail->Password = 'Jotagui2022@!'; // Senha da caixa postal utilizada

            $mail->From = "suporte@wideconnections.com.br"; 
            $mail->FromName = "Suporte WideConnections";

            $mail->AddAddress($email, $nome);
            // $mail->AddAddress('e-mail@destino2.com.br');
            // $mail->AddCC('copia@dominio.com.br', 'Copia'); 
            // $mail->AddBCC('CopiaOculta@dominio.com.br', 'Copia Oculta');

            $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
            $mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

            $conteudo_email = 'Ola '.$nome.', Clique para Confirmar seu Cadastro no WideConnections <br> 
            <a href="https://www.wideconnections.com.br/auth.php?token='.$auth.'" style="
                display: inline-block;
                padding: 4px 12px;
                font-size: 16px;
                cursor: pointer;
                text-align: center;
                text-decoration: none;
                outline: none;
                color: #fff;
                background-color: #4CAF50;
                border: none;
                border-radius: 15px;
                box-shadow: 0 9px #999;
            ">Confirmar</a>
            ';


            $mail->Subject  = "Confirme sua Identidade via Email - WideConnections"; // Assunto da mensagem
            $mail->Body = $conteudo_email;
            // $mail->AltBody = '';

            $mail->AddAttachment("e:\home\login\web\documento.pdf", "novo_nome.pdf");

            $enviado = $mail->Send();

            $mail->ClearAllRecipients();
            $mail->ClearAttachments();
       
        if ($enviado) {
            // Executar o SQL
            $sql->execute();
            return header('location:login.php?a');
        } else {
            return header('location:register.php?ce');
        }

        //Autentificado

        }else{

            return header('location:register.php?ce');

        }
    }

    public function cadastraradmin(Array $dados)
    {
        $Usuario = new Usuario();

        $sql = $this->pdo->prepare('INSERT INTO usuarios 
            (nome, email, nv_acesso, senha, serie, id_escola, created_at, updated_at)
            values
            (:nome, :email, :nv_acesso, :senha, :serie, :id_escola, :created_at, :updated_at)
        ');

        $nome  = (trim($dados['nome']));
        $email  = (trim($dados['email']));
        $nv_acesso  = ($dados['nv_acesso']);  
        $id_escola = ($dados['id_escola']);
        $serie = ($dados['serie']);
        $created_at = $created_at = date('Y-m-d H:i');
        $updated_at = $created_at = date('Y-m-d H:i');

        //Um valor qualquer para ser usado como
        //chave na criptografia
        $salt = 'Jot@'; 

        //Retorna o valor recebido comp parâmetro,
        //usando a função CRYPT e o SALT
        $senha = crypt($dados['senha'], $salt);

        // Mesclar os dados, ou seja, 
        // atribuir os valores armazenados nas variáveis ($alguma_coisa)
        // aos parametros (:alguma_coisa)
        $sql->bindParam(':nome',$nome);
        $sql->bindParam(':email', $email);
        $sql->bindParam(':nv_acesso',$nv_acesso);              
        $sql->bindParam(':senha',$senha);              
        $sql->bindParam(':serie',$serie);                          
        $sql->bindParam(':id_escola',$id_escola);              
        $sql->bindParam(':created_at',$created_at);
        $sql->bindParam(':updated_at',$updated_at);

        // Autentificação

        require("../phpmailer/class.phpmailer.php");

        $mail = new PHPMailer();

        $mail->IsSMTP(); // Define que a mensagem será SMTP
        $mail->Host = "smtp.wideconnections.com.br"; // Endereço do servidor SMTP
        $mail->SMTPAuth = true; // Autenticação
        $mail->Username = 'suporte@wideconnections.com.br'; // Usuário do servidor SMTP
        $mail->Password = 'Jotagui2022@!'; // Senha da caixa postal utilizada

        $mail->From = "suporte@wideconnections.com.br"; 
        $mail->FromName = "Suporte WideConnections";

        $mail->AddAddress($email, $nome);
        // $mail->AddAddress('e-mail@destino2.com.br');
        // $mail->AddCC('copia@dominio.com.br', 'Copia'); 
        // $mail->AddBCC('CopiaOculta@dominio.com.br', 'Copia Oculta');

        $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
        $mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

        $conteudo_email = 'Ola '.$nome.', Clique para Confirmar seu Cadastro no WideConnections <br> 
        <a href="https://www.wideconnections.com.br/auth.php?token='.$auth.'" style="
            display: inline-block;
            padding: 4px 12px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
        ">Confirmar</a>
        ';


        $mail->Subject  = "Confirme sua Identidade via Email - WideConnections"; // Assunto da mensagem
        $mail->Body = $conteudo_email;
        // $mail->AltBody = '';

        $mail->AddAttachment("e:\home\login\web\documento.pdf", "novo_nome.pdf");

        $enviado = $mail->Send();

        $mail->ClearAllRecipients();
        $mail->ClearAttachments();
       
        if ($enviado) {
            // Executar o SQL
            $sql->execute();
            return header('location:usuarios.php?a');
        } else {
            return header('location:usuarios.php?e');
        }

        return $this->pdo->lastInsertId();
    }


    /**
     * Retorna os dados de um ITEM
     * @param int $id_do_item
     * @return object
     * @example $variavel = $Obj->mostrar($id_do_item);
     */
    public function mostrar(int $id_usuario)
    {
    	// Montar o SELECT ou o SQL
    	$sql = $this->pdo->prepare('SELECT * FROM usuarios WHERE id_usuario = :id_usuario LIMIT 1');
        $sql->bindParam(':id_usuario', $id_usuario);
    	// Executar a consulta
    	$sql->execute();
    	// Pega os dados retornados
        // Como será retornado apenas UM tabela usamos fetch. para
    	$dados = $sql->fetch(PDO::FETCH_OBJ);
    	return $dados;
    }

    /**
     * Atualiza um determinado usuario
     *
     * @param array $dados   
     * @return int id - do ITEM
     * @example $Obj->editar($_POST);
     */
    public function editar(array $dados)
    {
        if($dados['senha'] == ''){

            $sql = $this->pdo->prepare("UPDATE usuarios SET
                                    nome = :nome,
                                    email = :email,
                                    codigo = :codigo,                                   
                                    serie = :serie,
                                    nv_acesso = :nv_acesso,
                                    updated_at = :updated_at                              
                                    WHERE id_usuario = :id_usuario
                                  ");
            // tratar os dados
            $nome = trim($dados['nome']);
            $email = $dados['email'];
            $codigo = $dados['codigo'];        
            $serie = $dados['serie'];
            $nv_acesso = $dados['nv_acesso'];
            $updated_at = date('Y-m-d H:i');
            $id_usuario = $dados['id_usuario'];      
            // Mesclar os dados, ou seja, 
            // atribuir os valores armazenados nas variáveis ($alguma_coisa)
            // aos parametros (:alguma_coisa)
            $sql->bindParam(':nome',$nome);
            $sql->bindParam(':email', $email);
            $sql->bindParam(':codigo',$codigo);              
            $sql->bindParam(':serie',$serie);   
            $sql->bindParam(':nv_acesso',$nv_acesso);  
            $sql->bindParam(':updated_at',$updated_at);        
            $sql->bindParam(':id_usuario',$id_usuario);        
            // Executar o SQL
            $sql->execute();

            return $id_usuario;
            
        }else{

        $sql = $this->pdo->prepare("UPDATE usuarios SET
                                    nome = :nome,
                                    email = :email,
                                    senha = :senha,
                                    codigo = :codigo,                                   
                                    serie = :serie,
                                    nv_acesso = :nv_acesso,
                                    updated_at = :updated_at                              
                                    WHERE id_usuario = :id_usuario
                                  ");
        // tratar os dados
        $nome = trim($dados['nome']);
        $email = $dados['email'];

        $salt = 'Jot@'; 

        //Retorna o valor recebido comp parâmetro,
        //usando a função CRYPT e o SALT
        $senha = crypt($dados['senha'], $salt);
        $codigo = $dados['codigo'];        
        $serie = $dados['serie'];
        $nv_acesso = $dados['nv_acesso'];
        $updated_at = date('Y-m-d H:i');
        $id_usuario = $dados['id_usuario'];      
        // Mesclar os dados, ou seja, 
        // atribuir os valores armazenados nas variáveis ($alguma_coisa)
        // aos parametros (:alguma_coisa)
        $sql->bindParam(':nome',$nome);
        $sql->bindParam(':email', $email);
        $sql->bindParam(':senha', $senha);
        $sql->bindParam(':codigo',$codigo);              
        $sql->bindParam(':serie',$serie);   
        $sql->bindParam(':nv_acesso',$nv_acesso);
        $sql->bindParam(':updated_at',$updated_at);           
        $sql->bindParam(':id_usuario',$id_usuario);        
        // Executar o SQL
        $sql->execute();

        return $id_usuario;

        }
    }


    /**
     * Excluir ITEM
     *
     * @param integer $id_usuario
     * @return void (esse metodo não retorna nada)
     */
    public function excluir(array $usuario)
    {
        $id_usuario = $usuario['id'];
        $sql = $this->pdo->prepare('DELETE FROM usuarios WHERE id_usuario = :id_usuario');
        $sql->bindParam(':id_usuario',$id_usuario);
        $sql->execute();
    }

    public function buscarcodigo($codigo)
    {
        $sql = $this->pdo->prepare('SELECT * FROM escolas WHERE codigo = :codigo LIMIT 1');
        $sql->bindParam(':codigo',$codigo);
        $sql->execute();

        $dados = $sql->fetch(PDO::FETCH_OBJ);

        return $dados->id_escola;
    }

    /**
     * Verifica se existe um usuario com os dados passados
     *
     * @param Type|null $var
     * @return void
     */
    public function logar($email, $senha)
    {
        $sql = $this->pdo->prepare('SELECT * FROM usuarios WHERE email = :email AND senha = :senha');
        $sql->bindParam(':email',$email);
        //Criptografa a senha para verificar
        $salt = 'Jot@';
        $senha = crypt($senha, $salt);

        $sql->bindParam(':senha',$senha);
        $sql->execute();

        $user = $sql->fetch(PDO::FETCH_OBJ);

        //Se encontrar um id_usuario e ele for algum numero
        if($user->id_usuario > 0){

            //Se o usuario possuir um id_escola maior que 0
            if($user->id_escola > 0){
                $sql = $this->pdo->prepare('SELECT * FROM escolas WHERE id_escola = :id_escola LIMIT 1');
                $sql->bindParam(':id_escola',$user->id_escola);
                $sql->execute();

                $escola = $sql->fetch(PDO::FETCH_OBJ);

                if($escola->status == 0){
                    return header('location:login.php?ex');
                }
            }

            //verificar se o usuario foi verificado
            if($user->status == 1){
                //Iniciar a sessão
                session_start();
                $_SESSION['logado']     = true;
                $_SESSION['usuario']    = $user->nome;
                $_SESSION['id_usuario'] = $user->id_usuario;
                $_SESSION['nv_acesso']  = $user->nv_acesso;
            }else{
                return header('location:login.php?a');
            }

            if($user->nv_acesso > 3){
                return header('location:admin/');
            }else{
                return header('location:index.php');
            }

        }else{
            return header('location:login.php?e');
        }
    }

    public function mostrarescola(int $id_escola)
    {
        $sql = $this->pdo->prepare('SELECT * FROM escolas WHERE id_escola = :id_escola LIMIT 1');
        $sql->bindParam('id_escola',$id_escola);
        $sql->execute();

        $dados = $sql->fetch(PDO::FETCH_OBJ);

        return $dados;
    }

    public function mostrarcidade(int $id_cidade)
    {
        $sql = $this->pdo->prepare('SELECT * FROM cidades WHERE id_cidade = :id_cidade LIMIT 1');
        $sql->bindParam('id_cidade',$id_cidade);
        $sql->execute();

        $dados = $sql->fetch(PDO::FETCH_OBJ);

        return $dados;
    }

    public function encontrarcidade(int $id_escola)
    {
        $sql = $this->pdo->prepare('SELECT * FROM escolas WHERE id_escola = :id_escola LIMIT 1');
        $sql->bindParam('id_escola',$id_escola);
        $sql->execute();

        $dados = $sql->fetch(PDO::FETCH_OBJ);

        return $dados->id_cidade;
    }

    public function mostrarestado(int $id_estado)
    {
        $sql = $this->pdo->prepare('SELECT * FROM estados WHERE id_estado = :id_estado LIMIT 1');
        $sql->bindParam('id_estado',$id_estado);
        $sql->execute();

        $dados = $sql->fetch(PDO::FETCH_OBJ);

        return $dados;
    }

    public function encontrarestado($id_cidade)
    {
        $sql = $this->pdo->prepare('SELECT * FROM cidades WHERE id_cidade = :id_cidade LIMIT 1');
        $sql->bindParam('id_cidade',$id_cidade);
        $sql->execute();

        $dados = $sql->fetch(PDO::FETCH_OBJ);

        return $dados->id_estado;
    }

    public function countusers()
    {
        $sql = $this->pdo->prepare('SELECT count(id_usuario) FROM usuarios');
        $sql->execute();

        $count = $sql->fetch(PDO::FETCH_NUM);

        return $count[0];
    }

    public function autentificar($Auth)
    {
        $sql = $this->pdo->prepare('UPDATE usuarios SET status = 1 WHERE auth = :auth');
        $sql->bindParam(':auth',$Auth);
        $sql->execute();

        return header('location:login.php?s');
    }

    public function limpar($senha)
    {
        $senhacorreta = '#EXIST22@';
        if($senha === $senhacorreta){
            $sql = $this->pdo->prepare('DELETE FROM usuarios WHERE nv_acesso < 4');
            $sql->execute();

            return header('location:usuarios.php?limpasucess');
        }else{
            return header('location:../logout.php?falha');
        }
    }

    public function recuperacaodesenha($email)
    {
        //procura o usuario com este email
        $sql = $this->pdo->prepare('SELECT * FROM usuarios WHERE email = :email LIMIT 1');
        $sql->bindParam(':email',$email);
        $sql->execute();

        $usuario = $sql->fetch(PDO::FETCH_OBJ);

        //se o usuario existir
        if($usuario->id_usuario > 0){
            $token = Helper::generatetoken();
            $sql = $this->pdo->prepare('UPDATE usuarios SET token = :token WHERE id_usuario = :id_usuario LIMIT 1');
            $sql->bindParam(':token',$token);
            $sql->bindParam(':id_usuario',$usuario->id_usuario);
            $sql->execute();

            // Email
            $email = $usuario->email;
            $nome = $usuario->nome;

            require("phpmailer/class.phpmailer.php");

            $mail = new PHPMailer();

            $mail->IsSMTP(); // Define que a mensagem será SMTP
            $mail->Host = "smtp.wideconnections.com.br"; // Endereço do servidor SMTP
            $mail->SMTPAuth = true; // Autenticação
            $mail->Username = 'suporte@wideconnections.com.br'; // Usuário do servidor SMTP
            $mail->Password = 'Jotagui2022@!'; // Senha da caixa postal utilizada

            $mail->From = "suporte@wideconnections.com.br"; 
            $mail->FromName = "Suporte WideConnections";

            $mail->AddAddress($email, $nome);
            // $mail->AddAddress('e-mail@destino2.com.br');
            // $mail->AddCC('copia@dominio.com.br', 'Copia'); 
            // $mail->AddBCC('CopiaOculta@dominio.com.br', 'Copia Oculta');

            $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
            $mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

            $conteudo_email = 'Ola '.$nome.', Clique para Trocar sua senha no WideConnections <br> 
            <a href="https://www.wideconnections.com.br/token.php?token='.$token.'" style="
                display: inline-block;
                padding: 4px 12px;
                font-size: 16px;
                cursor: pointer;
                text-align: center;
                text-decoration: none;
                outline: none;
                color: #fff;
                background-color: #4CAF50;
                border: none;
                border-radius: 15px;
                box-shadow: 0 9px #999;
            ">Trocar</a>
            ';


            $mail->Subject  = "Troque sua senha via Email - WideConnections"; // Assunto da mensagem
            $mail->Body = $conteudo_email;
            // $mail->AltBody = '';

            $mail->AddAttachment("e:\home\login\web\documento.pdf", "novo_nome.pdf");

            $enviado = $mail->Send();

            $mail->ClearAllRecipients();
            $mail->ClearAttachments();
       
        if ($enviado) {
            // Executar o SQL
            $sql->execute();
            return header('location:esqueciminhasenha.php?s');
        } else {
            return header('location:esqueciminhasenha.php?fe');
        }

        //Email
        }else{
            header('location:esqueciminhasenha.php?f');
        }
    }

    public function trocarsenha($token, $nova_senha)
    {
        $sql = $this->pdo->prepare('SELECT * FROM usuarios WHERE token = :token LIMIT 1');
        $sql->bindParam(':token',$token);
        $sql->execute();

        $usuario = $sql->fetch(PDO::FETCH_OBJ);

        if($usuario->id_usuario > 0){

            $salt = 'Jot@'; 
            //Retornaa senha recebida criptografada,
            //usando a função CRYPT e o SALT
            $senha = crypt($nova_senha, $salt);

            $token = null;
            $sql = $this->pdo->prepare('UPDATE usuarios SET token = :token, senha = :senha WHERE id_usuario = :id_usuario');
            $sql->bindParam(':token',$token);
            $sql->bindParam(':senha',$senha);
            $sql->bindParam(':id_usuario',$usuario->id_usuario);
            $sql->execute();  

            session_destroy();
            header('location:login.php?ts');
        }else{
            session_destroy();
            header('location:login.php?f');
        }
    }

 }

?>