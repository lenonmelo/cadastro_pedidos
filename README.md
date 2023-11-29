# Projeto do Lenon Platenetti de Melo

# Objetivo


# Desenvolvimento
Para o desenvolvimento da aplicação foram utilizadas as seguintes tecnologias web.
* PHP versão 8.0.28;
* Framework Laravel versão 9.19;
* Framework de estilo CSS Bootstrap versão 4.4.1;
* Estrutura visual com o plugin AdminLTE versão 3.9;
* Interação de tela utilizando Javascript com a biblioteca jQuery versão 3.6.0;
* Composer versão 2.5.4;
* Banco Mysql versão 15.1

# Rodar a aplicação
Para executar a aplicação, é necessário que o ambiente/máquina tenha as seguintes aplicações instaladas e configuradas:
* PHP 8.0.x, instalado e configurado nas variáveis de ambiente do sistema;
<br><b>OBS:</b> Você pode instalá-lo por meio de aplicações com ambientes prontos, como Xampp ou Wampp.
* Extensão PHP-GD: Será utilizado para a manipulação de imagens.
* Composer: Será utilizado para a instalação dos pacotes necessários.
* Artisan: Será utilizado para iniciar o servidor de teste.
* MySQL 15.X ou Maria DB.
  p.env
Após concluir as instalações necessárias, siga estas etapas:
* Clonar o projeto na pasta que pretende executar o sistema;
* Acesse a pasta principal do sistema através do terminal.
* Execute o seguinte comando para instalar os pacotes necessários;

      php composer install

* Faça uma cópia do arquivo ".env.example" encontrado na estrutura principal do sistema e altere o nome para ".env".
* Nas configurações do banco de dados, inclua as informações referentes ao banco que será utilizado, conforme indicado abaixo:

      DB_CONNECTION=mysql <br>
      DB_HOST=127.0.0.1<br>
      DB_PORT=3306<br>
      DB_DATABASE=xxxxxxxx
      DB_USERNAME=xxxx
      DB_PASSWORD=xxxx

* Acesse o terminal e execute o seguinte comando na pasta principal do projeto:

      php artisan migrate

* Neste momento, o Artisan irá perguntar se deseja criar a base de dados; certifique-se de aceitar essa opção.
* Agora, o banco de dados será criado automaticamente, e as migrações serão executadas automaticamente.
* Além disso, execute o seguinte comando para executar a seed, que incluirá os dados do usuário admin na tabela de usuários e dados padrões na tabela status de pedidos.

      php artisan db:seed

* Agora, mais uma vez, através do terminal, na pasta principal do sistema, execute o seguinte comando para iniciar o servidor de teste:

      php artisan serve 

* Acesse o endereço local do servidor no seu navegador, conforme exibido no terminal.
      
      http://127.0.0.1:8000

# Acesso

* O usuário e senha padrão de teste são as seguintes:

      Usuário: admin@teste.com.br
      Senha: admin


# Observação

* Quando você rodar o sistema pela primeira vez no servidor, pode ser que ele solicite a geração de uma chave de acesso. Nesse momento, basta clicar no botão exibido na tela para gerar a chave e, em seguida, acesse novamente o endereço.
