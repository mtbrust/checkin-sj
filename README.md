# Check-In SJ

Sistema web de **controle de cadastro e presença** para o evento **Semana Jovem (SJ 2025)**. Desenvolvido para uso local/em rede durante o evento, permitindo que a equipe registre visitantes, faça check-in por pulseira e acompanhe estatísticas em tempo real.

**Autor:** [Mateus Brust](mailto:contato@desv.com.br) — DESV

---

## Funcionalidades

### Cadastro de visitantes
- Registro com nome, telefone, sexo, data de nascimento, endereço e igreja/religião
- Identificação por **chave composta de pulseira**: número + cor (amarela ou azul)
- Suporte a troca de pulseira (`oldPulseira`)
- Captura de foto via câmera (opcional)
- Preview da foto em popup nas listagens
- Modo offline no cadastro com rascunho automático local
- Fila de pendências persistente (IndexedDB com fallback localStorage)
- Lista de pendentes com ação **Forçar cadastro** e sincronização manual/automática
- Flags de interesse: WhatsApp, informações, fé, contato, participação no palco, calouro
- Status do visitante: `1` OK · `2` Atualizar · `3` Atenção · `4` Bloqueado

### Presença (check-in)
- Registro rápido informando cor e número da pulseira
- Retorno imediato do status do visitante (cadastrado, bloqueado, sem cadastro, etc.)
- Layout mobile otimizado: botão de presença sempre visível e retorno compacto em 3 colunas
- Teste de stress disponível para administradores (`?page=presenca&stress=1`)

### Equipe
- Login simplificado por **CPF**
- Cadastro automático de novo membro da equipe (nome + telefone)
- Sessão PHP com controle de acesso às páginas protegidas

### Pesquisa
- Busca por texto (nome, tipo de pulseira, endereço)
- Busca por número (pulseira, pulseira antiga, telefone)
- Exibe histórico de presenças do visitante

### Estatísticas (somente administradores)
- Últimos 10 cadastros e presenças
- Cadastros e presenças por dia
- Quantidade por tipo de pulseira
- Cadastros duplicados
- Pulseiras sem cadastro
- Participantes do palco (visitantes presentes hoje que aceitaram ir ao palco)
- Tela **Check-in em andamento** (`?page=checkin-andamento`) com atualização automática

---

## Requisitos

- PHP 7.4+ (recomendado 8.x)
- MySQL ou MariaDB
- Apache (ex.: XAMPP)
- [Composer](https://getcomposer.org/)

### Extensões PHP recomendadas
- `pdo_mysql`
- `mbstring`
- `json`
- `session`

---

## Instalação

### 1. Clonar o repositório

```bash
git clone <url-do-repositorio> checkin-sj
cd checkin-sj
```

### 2. Instalar dependências

```bash
composer install
```

### 3. Configurar o banco de dados

Copie o arquivo de configuração padrão:

```bash
cp config-default.php config.php
```

Edite `config.php` e ajuste as credenciais em `BASE_BDS`:

| Parâmetro  | Padrão      | Descrição              |
|------------|-------------|------------------------|
| `HOST`     | `localhost` | Servidor MySQL         |
| `PORT`     | `3306`      | Porta                  |
| `USERNAME` | `root`      | Usuário                |
| `PASSWORD` | *(vazio)*   | Senha                  |
| `DATABASE` | `desv_sj`   | Nome do banco          |
| `PREFIX`   | `sj_`       | Prefixo das tabelas    |

Crie o banco de dados no MySQL:

```sql
CREATE DATABASE desv_sj CHARACTER SET utf8 COLLATE utf8_general_ci;
```

### 4. Criar as tabelas

Execute um script PHP temporário ou use o console para chamar:

```php
<?php
require_once 'src/php/App.php';
App::init();
App::createTables();
echo "Tabelas criadas com sucesso.";
```

Isso cria as tabelas:
- `sj_visitantes` — cadastro de visitantes
- `sj_presencas` — registros de presença
- `sj_logins` — equipe/voluntários
- `sj_comentarios`, `sj_midias`, `sj_log`, `sj_modelo` — auxiliares

Um usuário administrador inicial é inserido via seed em `BdLogins`.

### 5. Configurar o servidor web

Aponte o DocumentRoot ou um Virtual Host para a pasta do projeto e acesse:

```
http://localhost/checkin-sj/
```

---

## Uso

### Rotas de páginas

| URL | Descrição |
|-----|-----------|
| `?page=home` | Página inicial (resumo de cadastros/presenças do usuário) |
| `?page=equipe` | Login/cadastro da equipe |
| `?page=cadastro` | Novo cadastro de visitante *(requer login)* |
| `?page=presenca` | Registro de presença *(requer login)* |
| `?page=pesquisa&f-pesquisa=...` | Pesquisa de visitantes |
| `?page=cadastro_editar&id=X` | Editar cadastro *(requer login)* |
| `?page=estatisticas` | Painel de estatísticas *(somente admin)* |
| `?page=checkin-andamento` | Feed em tempo real das novas presenças *(somente admin)* |

### API JSON

Endpoints via `?api=<nome>` (retorno JSON):

| Endpoint | Ações principais |
|----------|------------------|
| `?api=login` | `acao=login`, `acao=sair` |
| `?api=equipe` | Login/cadastro por CPF (POST) |
| `?api=cadastro` | Inserir/atualizar visitante (POST) |
| `?api=presenca` | `acao=presenca` — registrar check-in |
| `?api=visitante` | `acao=foto` — retornar URL de foto para popup/listagens |
| `?api=estatistica` | Diversas ações: `ultimoscadastros`, `ultimaspresencas`, `cadastrosDiarios`, `visitasDiarias`, `participantespalco`, etc. |

### Fluxo típico no evento

1. Voluntário acessa **Equipe** e faz login com CPF
2. Na **Presença**, informa cor e número da pulseira do visitante
3. Se não houver cadastro, vai em **Cadastro** e completa os dados
4. Administrador acompanha **Estatísticas**, **Check-in em andamento** e usa **Pesquisa** para localizar visitantes

---

## Novidades recentes

- Configuração do site via `SiteConfig` com persistência em `data/site-settings.json` (modo HTTP/HTTPS e URL base)
- Carga de testes ampliada para cenários reais (duplicados, presença sem cadastro, status variados)
- Check-in em andamento inicia vazio ao abrir/recarregar e exibe apenas novas presenças
- Fallback de foto no feed em tempo real para `src/midia/user.webp`
- Padronização das consultas para considerar visitante por **pulseira + cor** em presença, últimas presenças e relatórios legados
- Cadastro offline v2: fila persistente mesmo após atualizar a página, sincronização ao voltar conexão e botão para forçar envio por item

---

## Segurança e permissões

- Sessão PHP gerenciada pela classe `Seguranca`
- Páginas `cadastro`, `presenca` e `cadastro_editar` exigem login (`Seguranca::check()`)
- Página `estatisticas` exige CPF de administrador (`Seguranca::checkAdmin()`)
- CPFs de admin configurados em `Seguranca::getCpfsAdmins()`

> **Atenção:** O login da equipe é simplificado (CPF sem senha forte). Adequado para ambiente controlado do evento; revise antes de expor na internet.

---

## Estrutura técnica

```
checkin-sj/
├── index.php                 # Bootstrap da aplicação
├── config-default.php        # Template de configuração
├── config.php                # Config local (não versionado)
├── composer.json
├── src/
│   ├── php/
│   │   ├── App.php           # Inicialização e criação de tabelas
│   │   ├── DataBase.php      # Camada PDO genérica (CRUD, queries)
│   │   ├── Seguranca.php     # Sessão e controle de acesso
│   │   ├── BdVisitantes.php  # Visitantes
│   │   ├── BdPresencas.php   # Presenças
│   │   ├── BdLogins.php      # Equipe
│   │   ├── BdComentarios.php
│   │   ├── BdMidias.php
│   │   ├── BdLogDb.php
│   │   ├── BdModelo.php
│   │   └── estrutura_01.php  # Layout HTML + roteamento page/api
│   ├── html/                 # Views
│   ├── api/                  # Controllers JSON
│   ├── js/                   # Scripts (máscaras, câmera, AJAX)
│   └── css/                  # Estilos (Bootstrap, custom)
└── vendor/                   # Composer (mpdf)
```

### Frontend
- Bootstrap 5, jQuery, jQuery Mask
- SweetAlert2 para notificações
- html2canvas para captura de imagem
- Scripts de câmera em `src/js/camera.js`, `script_cam.js`

---

## Tarefas planejadas

Conforme `tarefas.txt`:

- [ ] Estatísticas em tempo real de quem está entrando
- [ ] Sorteio de público para participação no palco
- [ ] Verificação de elegibilidade para pulseira VIP
- [ ] Validação de cadastros duplicados e presença sem cadastro
- [ ] Testes de stress no servidor

---

## Licença

Projeto interno DESV. Consulte o autor para uso e distribuição.
