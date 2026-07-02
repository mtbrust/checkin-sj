# Check-In SJ

Sistema web de **controle de cadastro e presença** para a **Semana Jovem 2026** (20 a 25 de julho). Desenvolvido para uso local/em rede durante o evento, permitindo que a equipe registre visitantes, faça check-in por pulseira e acompanhe estatísticas em tempo real.

**Instituição:** Juventude GetUp  
**Autor:** [Mateus Brust](mailto:contato@desv.com.br) — DESV

---

## Funcionalidades

### Cadastro de visitantes
- Registro com nome, telefone, sexo, data de nascimento, endereço e igreja/religião
- Identificação por **chave composta de pulseira**: número + cor (amarela ou azul)
- Suporte a troca de pulseira (`oldPulseira`)
- Captura de foto via câmera (opcional), com compressão e preview em popup
- **Modo offline:** rascunho automático local enquanto preenche o formulário
- **Fila de pendências** persistente (IndexedDB, com fallback em localStorage)
- Lista de cadastros pendentes com **Forçar cadastro** e **Sincronizar agora**
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
- Exibe histórico de presenças do visitante (por pulseira + cor)

### Estatísticas (somente administradores)
- KPIs clicáveis com filtros (cadastros, pulseiras, status, duplicados, sem cadastro)
- Cadastros e presenças por dia
- Últimos cadastros e últimas presenças
- Participantes do palco (presentes hoje com interesse no palco)
- Tela **Check-in em andamento** (`?page=checkin-andamento`): feed em tempo real das novas presenças, com fallback de foto `user.webp`

### Configurações e relatórios (somente administradores)
- Ajuste de protocolo HTTP/HTTPS via `SiteConfig` (`data/site-settings.json`)
- Ferramentas de manutenção (carga de teste, reset de tabelas) para usuário principal
- **Relatório Geral (PDF):** download com cabeçalho do evento, estatísticas gerais e por dia (layout tipo painel), lista compacta de visitantes com status, pulseira, dias de presença, flags e link WhatsApp no telefone
- **Relatório excel (CSV):** exportação completa dos cadastros com `qtd_dias_presenca` e URL WhatsApp

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
- `gd` (opcional, útil para imagens)

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

A dependência **mpdf/mpdf** é usada na geração do Relatório Geral em PDF.

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
| `?page=config` | Configurações, relatórios e manutenção *(somente admin)* |

### API

Endpoints via `?api=<nome>`:

| Endpoint | Descrição |
|----------|-----------|
| `?api=login` | Login/sair da equipe |
| `?api=equipe` | Cadastro por CPF (POST) |
| `?api=cadastro` | Inserir/atualizar visitante (POST, JSON) |
| `?api=presenca` | Registrar check-in (POST, JSON) |
| `?api=visitante` | `acao=foto` — URL da foto para popup/listagens |
| `?api=estatistica` | KPIs, listagens, `checkinandamento`, etc. (JSON) |
| `?api=relatorio&acao=pdf` | Download do Relatório Geral em PDF *(admin)* |
| `?api=relatorio&acao=csv` | Download do Relatório excel em CSV *(admin)* |

### Fluxo típico no evento

1. Voluntário acessa **Equipe** e faz login com CPF
2. Na **Presença**, informa cor e número da pulseira do visitante
3. Se não houver cadastro, vai em **Cadastro** e completa os dados (com suporte offline se a rede cair)
4. Administrador acompanha **Estatísticas**, **Check-in em andamento** e **Pesquisa**
5. Ao final (ou durante), em **Config**, gera **Relatório Geral** ou **Relatório excel**

### Cadastro sem internet

1. Preencha o formulário normalmente (o rascunho é salvo no aparelho)
2. Ao clicar em **Cadastrar** sem conexão, o registro entra na fila local
3. Quando a rede voltar, use **Sincronizar agora** ou **Forçar cadastro** na lista de pendentes
4. A fila permanece mesmo após atualizar a página (desde que o navegador não limpe os dados do site)

---

## Relatório Geral (PDF)

Gerado em `?page=config` → **Relatório Geral**. Conteúdo:

**Cabeçalho (todas as páginas)**
- Semana Jovem 2026 — 20 a 25 de Julho
- Tema: *Justiça quem é o juiz?* · 13º evento
- Instagram do evento: [@semanajovemgetup](https://www.instagram.com/semanajovemgetup/)
- Instituição: Juventude GetUp · [@juventude_getup](https://www.instagram.com/juventude_getup/)

**Página 1 — estatísticas**
- Cards de KPIs (mesmo conceito da tela Estatísticas)
- Painéis **Cadastros por dia** e **Presenças por dia**

**Páginas seguintes — visitantes**
- Lista compacta: status, pulseira (cor), nome, telefone (link WhatsApp), dias de presença, flags (palco, 1ª vez, WhatsApp), igreja/cidade

---

## Novidades recentes

- Relatório Geral em PDF (mPDF) e exportação CSV na página Config
- Cabeçalho do PDF com dados oficiais do evento SJ 2026
- Layout de estatísticas no PDF alinhado ao painel web (cards e mini-cards por dia)
- Cadastro offline v2: fila IndexedDB, lista de pendentes, sincronização manual/automática
- Check-in em andamento: feed vazio ao abrir, exibe só novas presenças; foto padrão `user.webp`
- Chave composta **pulseira + cor** padronizada em presença, relatórios e joins legados
- Presença mobile: botão fixo e retorno em 3 colunas
- `SiteConfig` com persistência em `data/site-settings.json` (HTTP/HTTPS)

---

## Segurança e permissões

- Sessão PHP gerenciada pela classe `Seguranca`
- Páginas `cadastro`, `presenca` e `cadastro_editar` exigem login (`Seguranca::check()`)
- Páginas `estatisticas`, `config`, `checkin-andamento` e download de relatórios exigem admin (`Seguranca::checkAdmin()`)
- CPFs de admin configurados em `Seguranca::getCpfsAdmins()`

> **Atenção:** O login da equipe é simplificado (CPF sem senha forte). Adequado para ambiente controlado do evento; revise antes de expor na internet.

---

## Estrutura técnica

```
checkin-sj/
├── index.php
├── config-default.php
├── config.php                # Config local (não versionado)
├── data/
│   └── site-settings.json    # Protocolo HTTP/HTTPS
├── composer.json
├── src/
│   ├── php/
│   │   ├── App.php
│   │   ├── SiteConfig.php
│   │   ├── RelatorioGeral.php
│   │   ├── Seguranca.php
│   │   ├── BdVisitantes.php
│   │   ├── BdPresencas.php
│   │   ├── BdLogins.php
│   │   ├── MidiaVisitante.php
│   │   └── estrutura_01.php
│   ├── html/
│   │   ├── config.php
│   │   ├── estatisticas.php
│   │   ├── checkin-andamento.php
│   │   └── form_visitante.php
│   ├── api/
│   │   ├── relatorio.php
│   │   ├── estatistica.php
│   │   └── cadastro.php
│   └── js/
│       ├── visitante-foto.js
│       └── visitante-popup.js
└── vendor/                   # Composer (mpdf)
```

### Frontend
- Bootstrap 5, jQuery, jQuery Mask
- SweetAlert2 para notificações
- IndexedDB / localStorage para fila offline de cadastros

---

## Tarefas planejadas

Conforme `tarefas.txt`:

- [x] Estatísticas em tempo real de quem está entrando (Check-in em andamento)
- [ ] Sorteio de público para participação no palco
- [ ] Verificação de elegibilidade para pulseira VIP
- [x] Validação/indicadores de cadastros duplicados e presença sem cadastro
- [ ] Testes de stress no servidor (ambiente de produção)

---

## Licença

Projeto interno DESV. Consulte o autor para uso e distribuição.
